<div class="col-9" style="align-self: center!important;align-items: center!important;align-content: center!important;margin: 10px auto!important;">
    <div class="row align-items-center">
        <div class="col">
            <div class="page-pretitle">
                <?= $Index['name']; ?>
            </div>
            <h2 class="page-title">
                Ads WhatsApp
            </h2>
        </div>
        <div class="col-auto ms-auto d-print-none">
            <div class="btn-list">
                <a href="panel.php?exe=timeline/whatsapp/create<?= $n; ?>" class="btn btn-primary">Criar novo</a>
            </div>
        </div>
    </div>
    <br/>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Home</h3>&nbsp;&nbsp;&nbsp;
        </div>
        <div id="aPaulo">
            <?php
            $staus = ["Activar", "Suspender"];
            $database = "ads_whatsapp";
            $postId = filter_input(INPUT_GET, "postId", FILTER_VALIDATE_FLOAT);
            if(isset($postId) || $postId != null):
                $Read = new Read();
                $Update = new Update();
                $action = filter_input(INPUT_GET, "action", FILTER_DEFAULT);
                switch ($action):
                    case "delete":
                        $Delete = new Delete();
                        $Delete->ExeDelete($database, "WHERE id=:i", "i={$postId}");
                        if($Delete->getResult() || $Delete->getRowCount()):
                            WSError("Publicaçāo apagada com sucesso!", WS_ACCEPT);
                        else:
                            WSError("Ops: aconteceu um erro inesperado ao apagar o status da publicaçāo!", WS_ERROR);
                        endif;
                        break;
                    case "status":
                        $Read->ExeRead($database, "WHERE id=:i", "i={$postId}");
                        if($Read->getResult()):
                            $Info = $Read->getResult()[0];
                            if($Info["status"] == 1): $data["status"] = 0; else: $data["status"] = 1; endif;
                            $Update->ExeUpdate($database, $data, "WHERE id=:i", "i={$postId}");
                            if($Update->getResult()):
                                WSError("A publicaçāo do site foi {$staus[$Info['status']]}", WS_INFOR);
                            else:
                                WSError("Ops: aconteceu um erro inesperado ao alterar o status da publicaçāo!", WS_ERROR);
                            endif;
                        endif;
                        break;
                    default:
                        WSError("Ops: nāo encontramos a açāo desejada!", WS_INFOR);
                endswitch;
            endif;
            ?>
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <td>ID</td>
                    <th>Imagem</th>
                    <th>Titulo</th>
                    <td>Descrição</td>
                    <th>Data</th>
                    <th>-</th>
                </tr>
                </thead>
                <tbody id="getResult">
                <?php
                    $posti = 0;
                    $getPage = filter_input(INPUT_GET, 'page',FILTER_VALIDATE_INT);
                    $Pager = new Pager("panel.php?exe=timeline/whatsapp/index{$n}&page=");
                    $Pager->ExePager($getPage, 5);

                    $read = new Read();
                    $read->ExeRead($database, "ORDER BY id DESC LIMIT :limit OFFSET :offset", "limit={$Pager->getLimit()}&offset={$Pager->getOffset()}");
                    if($read->getResult()):
                        foreach ($read->getResult() as $key):
                            ?>
                            <tr>
                                <td><?= $key["id"]; ?></td>
                                <td><img src="uploads/<?php if($key["cover"] != '' || !empty($key['cover'])): echo $key["cover"]; else: echo 'default.jpg'; endif; ?>" style="width: 40px!important;height: 40px!important;border-radius: 50%"></td>
                                <td><?= $key["titulo"]; ?></td>
                                <td><?= $key["content"]; ?></td>
                                <td><?= $key["data"]." ".$key['hora']; ?></td>
                                <td>
                                    <a href="panel.php?exe=timeline/whatsapp/index<?= $n; ?>&postId=<?= $key['id']; ?>&action=status" class="btn btn-sm btn-primary"><?= $staus[$key['status']]; ?></a>&nbsp;
                                    <a href="panel.php?exe=timeline/whatsapp/update<?= $n; ?>&postId=<?= $key['id']; ?>" class="btn btn-sm btn-warning">Editar</a>&nbsp;
                                    <a href="panel.php?exe=timeline/whatsapp/index<?= $n; ?>&postId=<?= $key['id']; ?>&action=delete" class="btn btn-sm btn-danger">Apagar</a>&nbsp;

                                </td>
                            </tr>
                        <?php
                        endforeach;
                    endif;
                ?>
                </tbody>
            </table>
        </div>
        <div class="card-footer d-flex align-items-center">
            <?php
                $Pager->ExePaginator($database, "ORDER BY id DESC");
                echo $Pager->getPaginator();
            ?>
        </div>
    </div>
</div>
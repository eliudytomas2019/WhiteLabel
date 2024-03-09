<div class="row align-items-center">
    <div class="col">
        <div class="page-pretitle">
            ProSmart
        </div>
        <h2 class="page-title">
            Websites Author
        </h2>
    </div>
    <div class="col-auto ms-auto d-print-none">
        <div class="btn-list">
            <a href="Admin.php?exe=websites/blog" class="btn btn-warning d-none d-sm-inline-block">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 13l-4 -4l4 -4m-4 4h11a4 4 0 0 1 0 8h-1" /></svg>
                Voltar
            </a>
            <a href="Admin.php?exe=websites/create_author" class="btn btn-primary">Criar novo</a>
        </div>
    </div>
</div>
<br/>
<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Author</h3>&nbsp;&nbsp;&nbsp;
        </div>
        <div id="aPaulo">
            <?php
            $staus = ["Activar", "Suspender"];
            $database = "website_author";
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
                    <th>Nome</th>
                    <td>Email</td>
                    <th>Views</th>
                    <th>-</th>
                </tr>
                </thead>
                <tbody id="getResult">
                <?php
                $posti = 0;
                $getPage = filter_input(INPUT_GET, 'page',FILTER_VALIDATE_INT);
                $Pager = new Pager("Admin.php?exe=websites/index_author&page=");
                $Pager->ExePager($getPage, 5);

                $read = new Read();
                $read->ExeRead($database, "ORDER BY id DESC LIMIT :limit OFFSET :offset", "limit={$Pager->getLimit()}&offset={$Pager->getOffset()}");
                if($read->getResult()):
                    foreach ($read->getResult() as $key):
                        ?>
                        <tr>
                            <td><?= $key["id"]; ?></td>
                            <td><img src="uploads/<?php if($key["logotype"] != '' || !empty($key['logotype'])): echo $key["logotype"]; else: echo 'default.jpg'; endif; ?>" style="width: 40px!important;height: 40px!important;border-radius: 50%"></td>
                            <td><?= $key["name"]; ?></td>
                            <td><?= $key["email"]; ?></td>
                            <td><?= $key["views"]; ?></td>
                            <td>
                                <a href="Admin.php?exe=websites/index_author&postId=<?= $key['id']; ?>&action=status" class="btn btn-sm btn-primary"><?= $staus[$key['status']]; ?></a>&nbsp;
                                <a href="Admin.php?exe=websites/update_author&postId=<?= $key['id']; ?>" class="btn btn-sm btn-warning">Editar</a>&nbsp;
                                <a href="Admin.php?exe=websites/index_author&postId=<?= $key['id']; ?>&action=delete" class="btn btn-sm btn-danger">Apagar</a>&nbsp;

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
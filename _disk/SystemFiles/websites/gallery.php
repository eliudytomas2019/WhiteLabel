<div class="row align-items-center">
    <div class="col">
        <div class="page-pretitle">
            ProSmart
        </div>
        <h2 class="page-title">
            Websites Gallery
        </h2>
    </div>
    <div class="col-auto ms-auto d-print-none">
        <div class="btn-list">
            <a href="Admin.php?exe=websites/home" class="btn btn-warning d-none d-sm-inline-block">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 13l-4 -4l4 -4m-4 4h11a4 4 0 0 1 0 8h-1" /></svg>
                Voltar
            </a>
            <a href="Admin.php?exe=websites/gallery_create" class="btn btn-primary">Criar novo</a>
        </div>
    </div>
</div>
<br/>
<div class="container-xl">
    <?php
    $staus = ["Activar", "Suspender"];
    $database = "website_gallery";
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
    <div class="row row-cards">
        <?php
        $posti = 0;
        $getPage = filter_input(INPUT_GET, 'page',FILTER_VALIDATE_INT);
        $Pager = new Pager("Admin.php?exe=websites/index_about&page=");
        $Pager->ExePager($getPage, 12);

        $read = new Read();
        $read->ExeRead($database, "ORDER BY id DESC LIMIT :limit OFFSET :offset", "limit={$Pager->getLimit()}&offset={$Pager->getOffset()}");
        if($read->getResult()):
        foreach ($read->getResult() as $key):
        ?>
        <div class="col-sm-6 col-lg-4">
            <div class="card card-sm">
                <a href="#" class="d-block"><img src="uploads/<?php if($key["logotype"] != '' || !empty($key['logotype'])): echo $key["logotype"]; else: echo 'default.jpg'; endif; ?>" class="card-img-top"></a>
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="ms-auto">
                            <a href="Admin.php?exe=websites/gallery&postId=<?= $key['id']; ?>&action=status" class="btn btn-sm btn-primary"><?= $staus[$key['status']]; ?></a>&nbsp;
                            <a href="Admin.php?exe=websites/gallery&postId=<?= $key['id']; ?>&action=delete" class="btn btn-sm btn-danger">Apagar</a>&nbsp;
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        endforeach;
        endif;
        ?>
    </div>
    <div class="d-flex">
        <?php
        $Pager->ExePaginator($database, "ORDER BY id DESC");
        echo $Pager->getPaginator();
        ?>
    </div>
</div>
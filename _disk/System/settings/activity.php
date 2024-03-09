<?php
if(!class_exists('login')):
    header("index.php");
    die();
endif;

if($level >= 4): $n =  '&id_db_settings='.$id_db_settings; else: $n = null; endif;

if($userlogin['level'] < 3):
    header("Location: painel.php?exe=default/index".$n);
endif;

?>
<div class="page-header d-print-none">
    <div class="row align-items-center">
        <div class="col">
            <h2 class="page-title">
                Configurações
            </h2>
        </div>
    </div>
</div>
<div class="row gx-lg-4">
    <?php require_once("_disk/IncludesApp/MenuSettings.inc.php"); ?>
    <div class="col-lg-9">
        <div class="card">
            <div class="card-header">
                <h5 class="modal-title">Registro de atividades</h5>
            </div>
            <div class="card-body">
                <div class="divide-y">
                    <?php
                        $posti = 0;
                        $getPage = filter_input(INPUT_GET, 'page',FILTER_VALIDATE_INT);
                        $Pager = new Pager("panel.php?exe=settings/activity{$n}&page=");
                        $Pager->ExePager($getPage, 6);

                        $Read = new Read();
                        $Reads = new Read();
                        $Read->ExeRead("db_users_active_store", "WHERE id_db_settings=:i ORDER BY id DESC LIMIT :limit OFFSET :offset", "i={$id_db_settings}&limit={$Pager->getLimit()}&offset={$Pager->getOffset()}");
                        if($Read->getResult()):
                            foreach ($Read->getResult() as $key):
                                $Reads->ExeRead("db_users", "WHERE id=:i ", "i={$key['session_id']}");
                                if($Reads->getResult()): $use = $Reads->getResult()[0]; else: $use = null; endif;
                                ?>
                                <div>
                                    <div class="row">
                                        <div class="col-auto">
                                            <span class="avatar" style="background-image: url(./uploads/<?php if($use['cover'] == "" || $use['cover'] == null): echo "user.png"; else: echo $use['cover']; endif; ?>)"></span>
                                        </div>
                                        <div class="col">
                                            <div class="text-truncate">
                                                <strong><?= $use["name"]; ?></strong> acessou: <strong>"<?= $key["page"]; ?>"</strong>
                                            </div>
                                            <div class="text-muted" style="color: #313030!important;">pelo navegador: <strong><?= $key["browser"]; ?></strong>, data de navegaçāo: <strong><?= $key["data"]; ?></strong>, com o endereço de IP: <strong><?= $key["user_ip"]; ?></strong>, usando o sistema operacional: <strong><?= $key["system"]; ?></strong>, <strong><?= $key["x"]; ?></strong>x</div>
                                        </div>
                                        <div class="col-auto align-self-center">
                                            <div class="badge bg-primary"></div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            endforeach;
                        endif;

                        $Pager->ExePaginator("db_users_active_store", "WHERE id_db_settings=:i ORDER BY id DESC", "i={$id_db_settings}");
                        echo $Pager->getPaginator();
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
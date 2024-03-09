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
                <h5 class="modal-title">Notificações</h5>
            </div>
            <div class="card-body">
                <div class="divide-y">
                    <?php
                    $posti = 0;
                    $getPage = filter_input(INPUT_GET, 'page',FILTER_VALIDATE_INT);
                    $Pager = new Pager("panel.php?exe=settings/notifications{$n}&page=");
                    $Pager->ExePager($getPage, 6);

                    $Read = new Read();
                    $Reads = new Read();
                    $Read->ExeRead("db_alert", "WHERE id_db_settings=:i ORDER BY id DESC LIMIT :limit OFFSET :offset", "i={$id_db_settings}&limit={$Pager->getLimit()}&offset={$Pager->getOffset()}");
                    if($Read->getResult()):
                        foreach ($Read->getResult() as $key):
                            $Data['status'] = 2;
                            $Update = new Update();
                            $Update->ExeUpdate("db_alert", $Data, "WHERE id=:i AND id_db_settings=:iv ", "i={$key['id']}&iv={$id_db_settings}");

                            ?>
                            <div>
                                <div class="row">
                                    <div class="col">
                                        <div class="text-truncate">
                                            <?= $key['title'];?>
                                        </div>
                                        <div class="text-muted" style="color: #313030!important;"><?= $key['content']; ?>; Data: <?= $key['dia']." de ".$Meses[$key['mes']]." de ".$key['ano']." às ".$key['hora'];?></div>
                                    </div>
                                </div>
                            </div>
                        <?php
                        endforeach;
                    endif;

                    $Pager->ExePaginator("db_alert", "WHERE id_db_settings=:i ORDER BY id DESC", "i={$id_db_settings}");
                    echo $Pager->getPaginator();
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
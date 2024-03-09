<?php
if(!class_exists('login')):
    header("index.php");
    die();
endif;

if($level >= 4): $n =  '&id_db_settings='.$id_db_settings; else: $n = null; endif;

if($userlogin['level'] < 1):
    header("location: panel.php?exe=default/home".$n);
endif;

include_once("_disk/IncludesApp/my-modal-mesas-settings.inc.php");
?>
<div class="page-header d-print-none">
    <div class="row align-items-center">
        <div class="col">
            <div class="page-pretitle">
                <?= $Index['name']; ?>
            </div>
            <h2 class="page-title">
                Local
            </h2>
        </div>
        <div class="col-auto ms-auto d-print-none">
            <div class="btn-list">
                <a href="#" class="btn btn-primary d-sm-inline-block" data-bs-toggle="modal" data-bs-target="#mesas">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg>
                    Adicionar novo Local
                </a>
            </div>
        </div>
    </div>
</div>

<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Local</h3>&nbsp;&nbsp;&nbsp;
        </div>
        <div class="table-responsive">
            <div id="aPaulo"></div>
            <table class="table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Local</th>
                    <th>Capacidade</th>
                    <th>Descrição</th>
                    <th>-</th>
                </tr>
                </thead>
                <tbody>
                <?php
                    $posti = 0;
                    $getPage = filter_input(INPUT_GET, 'page',FILTER_VALIDATE_INT);
                    $Pager = new Pager("panel.php?exe=local/index{$n}&page=");
                    $Pager->ExePager($getPage, 30);

                    $read->ExeRead("cv_mesas", "WHERE id_db_settings=:i ORDER BY name ASC LIMIT :limit OFFSET :offset", "i={$id_db_settings}&limit={$Pager->getLimit()}&offset={$Pager->getOffset()}");
                    if($read->getResult()):
                        foreach ($read->getResult() as $key):
                            extract($key);
                            ?>
                            <tr>
                                <td><?= $key['id']; ?></td>
                                <td><?= $key['name']; ?></td>
                                <td><?= $key['capacidade']; ?></td>
                                <td><?= $key['obs']; ?></td>
                                <td style="width: 200px!important;">
                                    <a href="<?= HOME; ?>panel.php?exe=local/update<?= $n; ?>&postid=<?= $id; ?>" title="Editar" class="btn btn-warning btn-sm">Editar</a>
                                    <?php if($_SESSION['userlogin']['level'] >= 3): ?>
                                        <a href="javascript:void()" onclick="DeleteMesa(<?= $id; ?>)" title="Deletar" class="btn btn-danger btn-sm">Excluir</a>
                                    <?php endif; ?>
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
                $Pager->ExePaginator("cv_mesas");
                echo $Pager->getPaginator();
            ?>
        </div>
    </div>
</div>
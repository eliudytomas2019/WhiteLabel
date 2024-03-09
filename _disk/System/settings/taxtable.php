<?php
if(!class_exists('login')):
    header("index.php");
    die();
endif;

if($level >= 4): $n =  '&id_db_settings='.$id_db_settings; else: $n = null; endif;

if($userlogin['level'] < 3):
    header("location: panel.php?exe=default/home".$n);
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
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <div class="page-pretitle">
                        <?= $Index['name']; ?>
                    </div>
                    <h2 class="page-title">
                        Taxa de imposto
                    </h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="panel.php?exe=settings/CreateTaxtable<?= $n; ?>" class="btn btn-primary d-none d-sm-inline-block">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg>
                            Adicionar novo taxa de imposto
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="modal-title">Taxas de imposto</h5>
            </div>
            <div class="card-body">
                <div id="aPaulo"></div>
                <table class="table">
                    <thead>
                    <tr>
                        <th>Res</th>
                        <th><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Código Type"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "代码"; endif; ?></th>
                        <th><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Código Imposto"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "代码"; endif; ?></th>
                        <th><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Descrição"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "描述"; endif; ?></th>
                        <th><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Porcentagem"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "百分比"; endif; ?></th>
                        <th>Montante de Imposto</th>
                        <th style="width: 200px!important;">-</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $read->ExeRead("db_taxtable", "WHERE id_db_settings=:id ORDER BY description DESC, taxtableEntry ASC", "id={$id_db_settings}");
                    if ($read->getResult()):
                        foreach ($read->getResult() as $user):
                            extract($user);
                            ?>
                            <tr>
                                <td><?= $taxtableEntry ?></td>
                                <td><?= $taxType; ?></td>
                                <td><?= $taxCode; ?></td>
                                <td><?= $description; ?></td>
                                <td><?= $taxPercentage; ?></td>
                                <td><?= $taxAmount; ?></td>
                                <td>
                                    <a href="?exe=settings/TaxtableUpdate<?= $n; ?>&userid=<?= $taxtableEntry; ?>" title="Editar" class="btn btn-warning btn-sm">Editar</a>
                                    <a href="#" onclick="DeleteTaxTable(<?= $taxtableEntry; ?>)" title="Deletar" class="btn btn-danger btn-sm">Deletar</a>
                                </td>
                            </tr>
                        <?php
                        endforeach;
                    endif;
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php
/**
 * Created by PhpStorm.
 * User: Kwanzar Soft
 * Date: 15/05/2020
 * Time: 00:22
 */

if(!class_exists('login')):
    header("index.php");
    die();
endif;

if($level >= 4): $n =  '&id_db_settings='.$id_db_settings; else: $n = null; endif;

if($userlogin['level'] < 3 || $Config->CheckLicence($userlogin['id_db_kwanzar'])['ps3'] == 1):
    header("location: panel.php?exe=default/index".$n);
endif;

require_once("_includes/my-modal-taxtable-create-settings.inc.php");
?>

<div class="row page-titles mx-0">
    <div class="col p-md-0">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= HOME; ?>panel.php?exe=default/home<?php if($level >= 4): echo '&id_db_settings='.$id_db_settings; endif; ?>"><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Painel de controle"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "控制面板"; endif; ?></a></li>
            <li class="breadcrumb-item active"><a href="<?= HOME; ?>panel.php?exe=taxtable/taxtable<?php if($level >= 4): echo '&id_db_settings='.$id_db_settings; endif; ?>"><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Taxa de Imposto"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "税率"; endif; ?></a></li>
        </ol>
    </div>
</div>

<div class="container-fluid">
    <div class="styles">
         <a href="#" data-toggle="modal" data-target="#taxtable" class="btn btn-primary btn-sm">
             Criar nova taxa
         </a>&nbsp;
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Taxa de Impostos</h4>
                    <div class="table-responsive">
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
                                            <a href="?exe=taxtable/update<?= $n; ?>&userid=<?= $taxtableEntry; ?>" title="Editar" class="btn btn-warning btn-sm">Editar</a>
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
    </div>
</div>



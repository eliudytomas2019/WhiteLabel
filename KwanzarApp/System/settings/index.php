<?php
/**
 * Created by PhpStorm.
 * User: Kwanzar Soft
 * Date: 12/05/2020
 * Time: 23:29
 */

if(!class_exists('login')):
    header("index.php");
    die();
endif;

if($level >= 4): $n =  '&id_db_settings='.$id_db_settings; else: $n = null; endif;

if($userlogin['level'] < 3):
    header("location: panel.php?exe=default/index".$n);
endif;

require_once("_includes/my-modal-logotype-settings.inc.php");
require_once("_includes/my-modal-dados-da-empresa-settings.inc.php");
require_once("_includes/my-modal-config-settings.inc.php");
?>
<div class="modal fade bs-example-modal-lg" id="SAFT" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
            </div>
            <div class="modal-body">
                <form method="post" action="saf-t.php" target="_blank">
                    <div class="form-group">
                        <span>Gerar SAFT.</span>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-4">
                            <input type="hidden" name="id_db_settings" id="id_db_settings" value="<?= $id_db_settings; ?>"/>
                            <input type="date" required name="dataInicial" class="form-control"/>
                        </div>
                        <div class="col-sm-4">
                            <input type="date" required name="dataFinal" class="form-control"/>
                        </div>
                        <div class="col-sm-4">
                            <input type="submit" name="SendPostForm" class="btn btn-outline-primary btn-sm" value="Gerar SAFT">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row page-titles mx-0">
    <div class="col p-md-0">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= HOME; ?>panel.php?exe=default/home<?php if($level >= 4): echo '&id_db_settings='.$id_db_settings; endif; ?>"><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Painel de controle"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "控制面板"; endif; ?></a></li>
            <li class="breadcrumb-item active"><a href="<?= HOME; ?>panel.php?exe=settings/index<?php if($level >= 4): echo '&id_db_settings='.$id_db_settings; endif; ?>"><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Definições e privacidade"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "定义和隐私"; endif; ?></a></li>
        </ol>
    </div>
</div>

<div class="page-inner">
    <div class="styles">
        <a href="<?= HOME; ?>panel.php?exe=settings/index<?= $n; ?>" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#config"><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Configurações"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "设置"; endif; ?></a>
        <a href="<?= HOME; ?>panel.php?exe=users/index<?= $n; ?>" class="btn btn-primary btn-sm"><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Usuários"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "用户"; endif; ?></a>
        <?php if($Config->CheckLicence($userlogin['id_db_kwanzar'])['ps3'] != 1): ?>
            <a href="<?= HOME; ?>panel.php?exe=settings/active/index<?= $n; ?>" class="btn btn-primary btn-sm">Motivo de documentos de retificação</a>
            <a href="<?= HOME; ?>panel.php?exe=taxtable/taxtable<?= $n; ?>" class="btn btn-primary btn-sm"><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Taxa de Impostos"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "税率"; endif; ?></a>
            <a href="<?= HOME; ?>saf-t.php?<?= $n; ?>" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#SAFT">SAF-T</a>
        <?php endif; ?>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <h4><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Informações da empresa"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "公司信息"; endif; ?></h4>
                    </div>
                </div>
                <div class="card-body">

                        <table class="table mt-3">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "LOGOTIPO"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "徽标"; endif; ?></th>
                                <th><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "EMPRESA"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "公司"; endif; ?></th>
                                <th>-</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $read->ExeRead("db_settings", "WHERE id=:i AND id_db_kwanzar=:is", "i={$id_db_settings}&is={$id_db_kwanzar}");

                            if($read->getResult()):
                                $key = $read->getResult()[0];
                                ?>
                                <tr>
                                    <td><?= $key['id']; ?></td>
                                    <th><img src="uploads/<?php if($key['logotype'] != null): echo $key['logotype']; else: echo 'logotype.jpg'; endif; ?>" alt="logotipo" class="logotypes"></th>
                                    <td><?= $key['empresa']; ?></td>
                                    <td >
                                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#basicModal"><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Dados bancário"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "Dados bancário"; endif; ?></button>&nbsp;
                                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#bd-example-modal-lg"><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Dados da empresa"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "Dados da empresa"; endif; ?></button>&nbsp;
                                        <a href="<?= HOME; ?>panel.php?exe=settings/update<?= $n; ?>" class="btn btn-primary btn-sm"><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Logo-marca"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "徽标"; endif; ?></a>
                                    </td>
                                </tr>
                                <?php
                            else:
                                unset($_SESSION['userlogin']);
                                header('Location: index.php?exe=restrito');
                            endif;
                            ?>
                            </tbody>
                        </table>

                </div>
            </div>
        </div>
    </div>
</div>

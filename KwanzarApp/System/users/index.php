<?php
/**
 * Created by PhpStorm.
 * User: Kwanzar Soft
 * Date: 14/05/2020
 * Time: 00:37
 */

if(!class_exists('login')):
    header("index.php");
    die();
endif;

if($level >= 4): $n =  '&id_db_settings='.$id_db_settings; else: $n = null; endif;

if($userlogin['level'] < 3):
    header("location: panel.php?exe=default/index".$n);
endif;

require_once("./_includes/my-modal-create-users.settings.inc.php");
?>

<div class="row page-titles mx-0">
    <div class="col p-md-0">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= HOME; ?>panel.php?exe=default/home<?php if($level >= 4): echo '&id_db_settings='.$id_db_settings; endif; ?>"><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Painel de controle"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "控制面板"; endif; ?></a></li>
            <li class="breadcrumb-item active"><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Usuários"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "用户 "; endif; ?><a href="<?= HOME; ?>panel.php?exe=users/index<?php if($level >= 4): echo '&id_db_settings='.$id_db_settings; endif; ?>"></a></li>
        </ol>
    </div>
</div>

<div class="container-fluid">

    <div class="styles">
        <?php
            $read->ExeRead("db_users", "WHERE id_db_kwanzar=:ip ", "ip={$id_db_kwanzar}");
            if($read->getRowCount() < $Config->CheckLicence($userlogin['id_db_kwanzar'])['users']):
                ?>
                    <a href="" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#db_users">Criar novo</a>
                <?php
            endif;
        ?>
    </div>


    <div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <h4><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Usuários"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "用户 "; endif; ?></h4>
                </div>

                <div class="table-responsive">
                    <div id="getResult"></div>
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Nome"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "名称"; endif; ?></th>
                            <th><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "E-mail"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "电子邮件"; endif; ?></th>
                            <th>Lastupdate</th>
                            <th><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Nível de acesso"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "访问级别"; endif; ?></th>
                            <th><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Status"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "地位"; endif; ?></th>
                            <th>-</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $read->ExeRead("db_users", "WHERE id_db_kwanzar=:ip AND id_db_settings=:idd ORDER BY name ASC ", "ip={$id_db_kwanzar}&idd={$id_db_settings}");
                        if($read->getResult()):
                            foreach($read->getResult() as $key):
                                extract($key);
                                $level = ['', 'Usuário', 'Gestor', 'Administrador', 'Root', 'Desenvolvidor'];
                                $stat = ['Desativado', 'Ativo'];
                                ?>
                                <tr>
                                    <td><?= $key['id'] ?></td>
                                    <td><?= $key['name'] ?></td>
                                    <td><?= $key['username'] ?></td>
                                    <td><?= $key['lastupdate'] ?></td>
                                    <td><?= $level[$key['level']]; ?></td>
                                    <td><?= $stat[$key['status']] ?></td>
                                    <td style="width: 280px!important;">
                                        <?php
                                            if($userlogin['level'] >= 3):
                                                if($userlogin['id'] != $key['id'] || $read->getRowCount() == 1):
                                                    ?>
                                                    <a href="<?= HOME; ?>panel.php?exe=users/update<?= $n; ?>&id_user=<?= $key['id']; ?>" class="btn btn-primary btn-sm"><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Editar"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "编辑"; endif; ?></a>&nbsp;
                                                    <a href="#" class="btn btn-danger btn-sm" onclick="DeleteUsers(<?= $key['id']; ?>);"><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Eliminar"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "消除"; endif; ?></a>
                                                    <a href="#" class="btn btn-warning btn-sm" onclick="SuspenderConta(<?= $key['id']; ?>);"><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Suspender"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "暂停"; endif; ?></a>
                                                    <?php
                                                endif;
                                            endif;
                                        ?>
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


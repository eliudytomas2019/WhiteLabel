<?php
/**
 * Created by PhpStorm.
 * User: Kwanzar Soft
 * Date: 16/05/2020
 * Time: 02:32
 */

if(!class_exists('login')):
    header("index.php");
    die();
endif;

if($level >= 4): $n =  '&id_db_settings='.$id_db_settings; else: $n = null; endif;

if($userlogin['level'] < 2):
    header("location: panel.php?exe=default/index".$n);
endif;

?>
<div class="row page-titles mx-0">
    <div class="col p-md-0">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= HOME; ?>panel.php?exe=default/home<?php if($level >= 4): echo '&id_db_settings='.$id_db_settings; endif; ?>">
                    <?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Painel de controle"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "控制面板"; endif; ?>
                </a></li>
            <li class="breadcrumb-item active"><a href="<?= HOME; ?>panel.php?exe=supplier/index<?php if($level >= 4): echo '&id_db_settings='.$id_db_settings; endif; ?>"><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Fornecedores"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "供应商"; endif; ?></a></li>
        </ol>
    </div>
</div>

<div class="container-fluid">
    <div id="styles">
        <a href="<?= HOME; ?>panel.php?exe=supplier/create<?= $n; ?>" class="btn btn-outline-primary btn-sm">
            <?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "CRIAR NOVO FORNECEDOR"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "创建一个新的供应商"; endif; ?>
        </a>&nbsp;
    </div>


    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <?php
                    $delete = filter_input(INPUT_GET, 'delete', FILTER_VALIDATE_INT);
                    if ($delete):
                        $Delete = new Supplier();
                        $Delete->ExeDelete($delete);

                        WSError($Delete->getError()[0], $Delete->getError()[1]);
                        echo "<br/>";
                    endif;
                    ?>
                    <?php include_once("./KwanzarApp/SystemFiles/search-supplier-user.inc.php"); ?>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "RES."; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "结果"; endif; ?></th>
                                <th><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "COVER"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "COVER"; endif; ?></th>
                                <th><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "NOME"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "名称"; endif; ?></th>
                                <th><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "TIPO"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "类型"; endif; ?></th>
                                <th><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "NIF"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "NIF"; endif; ?></th>
                                <th><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "TELEFONE"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "电话 "; endif; ?></th>
                                <th><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "E-MAIL"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "电子邮件"; endif; ?></th>
                                <th width="220">-</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $posti = 0;
                            $getPage = filter_input(INPUT_GET, 'page',FILTER_VALIDATE_INT);
                            $Pager = new Pager('?exe=supplier/index&page=');
                            $Pager->ExePager($getPage, 30);

                            $read->ExeRead("cv_supplier", "WHERE id_db_settings=:id ORDER BY nome ASC LIMIT :limit OFFSET :offset", "id={$id_db_settings}&limit={$Pager->getLimit()}&offset={$Pager->getOffset()}");
                            if($read->getResult()):
                                foreach ($read->getResult() as $key):
                                    extract($key);
                                    ?>
                                    <tr>
                                        <td><?= $key['id']; ?></td>
                                        <td><img style="width: 40px!important;height: 40px!important;border-radius: 50%!important;" src="./uploads/<?php if($key['cover'] != ''): echo $key['cover']; else: echo 'user.png'; endif;  ?>"</td>
                                        <td><?= $key['nome']; ?></td>
                                        <td><?= $key['type']; ?></td>
                                        <td><?= $key['nif']; ?></td>
                                        <td><?= $key['telefone']; ?></td>
                                        <td><?= $key['email']; ?></td>
                                        <td>
                                            <a href="<?= HOME; ?>panel.php?exe=supplier/update<?= $n; ?>&postid=<?= $id; ?>" title="Editar" class="btn btn-warning btn-sm">Editar</a>
                                            <?php if($_SESSION['userlogin']['level'] >= 3): ?>
                                                <a href="<?= HOME; ?>panel.php?exe=supplier/index<?= $n; ?>&delete=<?= $id; ?>" title="Deletar" class="btn btn-danger btn-sm">Eliminar</a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php
                                endforeach;
                            endif;
                            ?>

                            </tbody>
                        </table>

                        <?php
                        $Pager->ExePaginator("cv_supplier");
                        echo $Pager->getPaginator();
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
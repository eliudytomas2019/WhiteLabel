<?php
/**
 * Created by PhpStorm.
 * User: Kwanzar Soft
 * Date: 01/04/2020
 * Time: 16:57
 */
?>
<div class="form-group">
    <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search" method="post" type="post" action="">
        <div class="input-group">
            <input type="text" name="number" value="<?php if (!empty($ClienteData['number'])) echo $ClienteData['number']; ?>" class="form-control bg-light border-0 small" placeholder="Buscar Clientes por NOME/NIF" aria-label="Search" aria-describedby="basic-addon2">
            <div class="input-group-append">
                <input class="btn btn-primary" name="SendPostForm" type="submit" value="<?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Pesquisar"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "搜寻"; endif; ?>">
            </div>
        </div>
    </form>
</div>
<?php
$ClienteData = filter_input_array(INPUT_POST, FILTER_DEFAULT);
if ($ClienteData && $ClienteData['SendPostForm']):
    $number = htmlspecialchars(trim($_POST['number']));

    ?>
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
            <th style="width: 160px!important;">-</th>
        </tr>
        </thead>
        <tbody>
        <?php

        $read->ExeRead("cv_supplier", "WHERE (id_db_settings=:id AND nome LIKE '%' :nn '%') OR (id_db_settings=:id AND nif LIKE '%' :nn '%') ", "id={$id_db_settings}&nn={$number}");

        if($read->getResult()):
            foreach ($read->getResult() as $key):
                extract($key);
                ?>
                <tr>
                    <td><?= $key['id']; ?></td>
                    <td><img style="width: 60px!important;height: 60px!important;border-radius: 50%!important;" src="./uploads/<?php if($key['cover'] != ''): echo $key['cover']; else: echo 'user.png'; endif;  ?>"</td>
                    <td><?= $key['nome']; ?></td>
                    <td><?= $key['type']; ?></td>
                    <td><?= $key['nif']; ?></td>
                    <td><?= $key['telefone']; ?></td>
                    <td><?= $key['email']; ?></td>
                    <td>
                        <a href="<?= HOME; ?>panel.php?exe=supplier/update<?= $n; ?>&postid=<?= $id; ?>" title="Editar" class="btn btn-warning btn-sm"><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Editar"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "编辑"; endif; ?></a>
                        <a href="<?= HOME; ?>panel.php?exe=supplier/index<?= $n; ?>&delete=<?= $id; ?>" title="Deletar" class="btn btn-danger btn-sm"><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Eliminar"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "消除"; endif; ?></a>
                    </td>
                </tr>
                <?php
            endforeach;
        else:
            WSError("Opsss! Não encontramos o documento procurado, atualize a página e tente novamente.", WS_ALERT);
        endif;

        ?>
        </tbody>
    </table>
    <?php
endif;
?>

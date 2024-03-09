<?php
/**
 * Created by PhpStorm.
 * User: Kwanzar Soft
 * Date: 24/04/2020
 * Time: 18:41
 */

$id_db_set = filter_input(INPUT_GET, 'postId', FILTER_DEFAULT);
$id_db_ = filter_input(INPUT_GET, 'id_db_', FILTER_DEFAULT);

$ClienteData = filter_input_array(INPUT_POST, FILTER_DEFAULT);
if ($ClienteData && $ClienteData['SendPostForm']):
    $read = new Read();
    $read->ExeRead("db_users", "WHERE id_db_settings=:idd ", "idd={$id_db_settings}");

    $Date = [
        'level' => strip_tags(trim($_POST['level'])),
        'name' => strip_tags(trim($_POST['name'])),
        'username' => strip_tags(trim($_POST['username']))
    ];

    $users = new DBKwanzar();
    $users->ExeUsers($Date, $id_db_set, $id_db_);

    WSError($users->getError()[0], $users->getError()[1]);
endif;
?>
<div class="container-fluid">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Cadastramento de usuários!</h4>
                <div class="basic-form">
                    <div id="getResult"></div>
                    <form method="post" name="form_users_create" enctype="multipart/form-data" action="#getResult">
                        <div class="row">
                            <div class="col">
                                <input type="text" name="name" id="name" class="form-control" placeholder="Nome">
                            </div>
                            <div class="col">
                                <input type="text" name="username" id="username" class="form-control" placeholder="Username">
                            </div>
                        </div>
                        <br/>
                        <div class="row">
                            <div class="col">
                                <select name="level" id="level" class="form-control">
                                    <option value = "">-- Selecione o nível de acesso --</option>
                                    <option value="1" <?php if (isset($ClienteData['level']) && $ClienteData['level'] == 1) echo 'selected="selected"'; ?>>Usuário</option>
                                    <option value="2" <?php if (isset($ClienteData['level']) && $ClienteData['level'] == 2) echo 'selected="selected"'; ?>>Gestor</option>
                                    <option value="3" <?php if (isset($ClienteData['level']) && $ClienteData['level'] == 3) echo 'selected="selected"'; ?>>Administrador</option>
                                    <option value="4" <?php if (isset($ClienteData['level']) && $ClienteData['level'] == 4) echo 'selected="selected"'; ?>>Root</option>
                                </select>
                            </div>
                        </div>
                        <br/>
                        <hr/>
                        <div class="row">
                            <div class="col">
                                <input type="submit" name="SendPostForm" class="btn btn-primary" value="Cadastrar"/>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


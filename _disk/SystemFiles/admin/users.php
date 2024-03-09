<?php
$id_db_set = filter_input(INPUT_GET, 'postId', FILTER_DEFAULT);
$id_db_ = filter_input(INPUT_GET, 'id_db_', FILTER_DEFAULT);

$ClienteData = filter_input_array(INPUT_POST, FILTER_DEFAULT);
if ($ClienteData && $ClienteData['SendPostForm']):
    $read = new Read();
    $read->ExeRead("db_users", "WHERE id_db_settings=:idd ", "idd={$id_db_set}");

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
<div class="page-header d-print-none">
    <div class="row align-items-center">

        <div class="col-auto ms-auto d-print-none">
            <div class="btn-list">
                <a href="Admin.php?exe=admin/empresa" class="btn btn-primary d-none d-sm-inline-block">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 13l-4 -4l4 -4m-4 4h11a4 4 0 0 1 0 8h-1" /></svg>
                    Voltar
                </a>
            </div>
        </div>
        <div class="col">
            <div class="page-pretitle">
                Kwanzar
            </div>
            <h2 class="page-title">
                Administrador
            </h2>
        </div>
    </div>
</div>

<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Cadastramento de usuários</h3>
        </div>
        <div class="card-body">
            <div id="getResult"></div>
            <form method="post" name="form_users_create" enctype="multipart/form-data" action="#getResult">
                <div class="form-group mb-3 ">
                    <label class="form-label">Nome</label>
                    <div>
                        <input type="text" value="<?php if (!empty($ClienteData['name'])) echo $ClienteData['name']; ?>" name="name" id="name" class="form-control" placeholder="Nome">
                    </div>
                </div>

                <div class="form-group mb-3 ">
                    <label class="form-label">E-mail</label>
                    <div>
                        <input type="text" value="<?php if (!empty($ClienteData['username'])) echo $ClienteData['username']; ?>" name="username" id="username" class="form-control" placeholder="Username">
                    </div>
                </div>

                <div class="form-group mb-3 ">
                    <label class="form-label">Nível de acesso</label>
                    <select name="level" id="level" class="form-control">
                        <option value = "">-- Selecione o nível de acesso --</option>
                        <option value="1" <?php if (isset($ClienteData['level']) && $ClienteData['level'] == 1) echo 'selected="selected"'; ?>>Usuário</option>
                        <option value="2" <?php if (isset($ClienteData['level']) && $ClienteData['level'] == 2) echo 'selected="selected"'; ?>>Gestor</option>
                        <option value="3" <?php if (isset($ClienteData['level']) && $ClienteData['level'] == 3) echo 'selected="selected"'; ?>>Administrador</option>
                        <option value="4" <?php if (isset($ClienteData['level']) && $ClienteData['level'] == 4) echo 'selected="selected"'; ?>>Root</option>
                    </select>
                </div>

                <div class="form-footer">
                    <input type="submit" name="SendPostForm" class="btn btn-primary" value="Cadastrar"/>
                </div>
            </form>
        </div>
    </div>
</div>
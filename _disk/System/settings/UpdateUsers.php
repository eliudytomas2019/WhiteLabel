<?php
$id_user = strip_tags(trim(filter_input(INPUT_GET, 'id_user', FILTER_VALIDATE_INT)));

if(!class_exists('login')):
    header("index.php");
    die();
endif;

if($level >= 4): $n =  '&id_db_settings='.$id_db_settings; else: $n = null; endif;

if($userlogin['level'] < 3):
    header("location: panel.php?exe=default/index".$n);
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
                <?php require_once("btnBreak.inc.php"); ?>
                <div class="col">
                    <div class="page-pretitle">
                        <?= $Index['name']; ?>
                    </div>
                    <h2 class="page-title">
                        Usuários
                    </h2>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h5 class="modal-title">Usuários</h5>
            </div>
            <div class="card-body">
                <?php
                $ClienteData = filter_input_array(INPUT_POST, FILTER_DEFAULT);
                $userId = filter_input(INPUT_GET, 'userid', FILTER_VALIDATE_INT);

                if ($ClienteData && $ClienteData['SendPostForm']):
                    $Cadastrar = new DBKwanzar();
                    $Cadastrar->ExeUsersUpdate($id_user, $id_db_settings, $ClienteData);

                    if($Cadastrar->getResult()):
                        WSError($Cadastrar->getError()[0], $Cadastrar->getError()[1]);
                    else:
                        WSError($Cadastrar->getError()[0], $Cadastrar->getError()[1]);
                    endif;
                else:
                    $ReadUser = new Read;
                    $ReadUser->ExeRead("db_users", "WHERE id=:userid", "userid={$id_user}");
                    if (!$ReadUser->getResult()):

                    else:
                        $ClienteData = $ReadUser->getResult()[0];
                        unset($ClienteData['password']);
                    endif;
                endif;
                ?>
                <form class="form-horizontal" method="post" action="" name = "SendPostForm"  enctype="multipart/form-data">
                    <div class="form-group">
                        <label class="col-sm-2 col-form-label">Nome</label>
                        <input type="text" name="name" class="form-control" value="<?php if (!empty($ClienteData['name'])) echo $ClienteData['name']; ?>" placeholder="Nome">
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 col-form-label">Nível de Acesso</label>
                        <select name="level" class="form-control">
                            <option value = "">Selecione o Nível</option>
                            <option value="1" <?php if (isset($ClienteData['level']) && $ClienteData['level'] == 1) echo 'selected="selected"'; ?>>Usuário</option>
                            <option value="2" <?php if (isset($ClienteData['level']) && $ClienteData['level'] == 2) echo 'selected="selected"'; ?>>Gestor</option>
                            <option value="3" <?php if (isset($ClienteData['level']) && $ClienteData['level'] == 3) echo 'selected="selected"'; ?>>Administrador</option>
                        </select>
                    </div><br/>
                    <div class="form-group row">
                        <div class="col-sm-10">
                            <input type="submit" name="SendPostForm" class="btn btn-primary" value="Atualizar dados"/>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
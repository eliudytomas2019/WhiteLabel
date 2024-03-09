<?php
if(!class_exists('login')):
    header("index.php");
    die();
endif;

if($level >= 4): $n =  '&id_db_settings='.$id_db_settings; else: $n = null; endif;
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
        <?php if($userlogin['level'] == 3 || $userlogin['level'] >= 4): ?>
            <br/>
            <div class="col-lg-12 col-xl-12">
                <?php require_once("_disk/Helps/users-money.charts.inc.php"); ?>
            </div>
        <?php endif; ?>
        <br/>
        <div class="col-lg-12 col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div id="chart-completion-tasks-9"></div>
                </div>
            </div>
        </div>
        <br/>
        <div class="card">
            <div class="card-header">
                <h5 class="modal-title">Perfil de usuário</h5>
            </div>
            <div class="card-body">
                <?php
                $id_user = $userlogin['id'];
                $ClienteData = filter_input_array(INPUT_POST, FILTER_DEFAULT);
                if ($ClienteData && $ClienteData['SendPostForm']):
                    $file = ($_FILES['cover']['tmp_name'] ? $_FILES['cover'] : null);
                    $Cadastrar = new DBKwanzar();
                    $Cadastrar->ExeProfile($id_user, $ClienteData, $file);

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
                <form method="post" action="" name = "SendPostForm"  enctype="multipart/form-data">
                    <div class="form-group row">
                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Nome</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="fname" name="name" value="<?php if (!empty($ClienteData['name'])) echo $ClienteData['name']; ?>" placeholder="Nome">
                        </div>
                    </div><br/>
                    <div class="form-group row">
                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Telefone</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="telefone" name="telefone" value="<?php if (!empty($ClienteData['telefone'])) echo $ClienteData['telefone']; ?>" placeholder="Telefone">
                        </div>
                    </div><br/>
                    <div class="form-group row">
                        <label for="email1" class="col-sm-3 text-right control-label col-form-label">Foto de Perfil</label>
                        <div class="col-sm-9">
                            <input type="file"  name="cover"  class="form-control" id="email1">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-10">
                            <input type="submit" name="SendPostForm" class="btn btn-primary" value="Atualizar Dados"/>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
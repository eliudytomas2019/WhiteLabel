<?php
/**
 * Created by PhpStorm.
 * User: Kwanzar Soft
 * Date: 07/04/2020
 * Time: 20:58
 */

if(!class_exists('login')):
    header("index.php");
    die();
endif;

if($level >= 4): $n =  '&id_db_settings='.$id_db_settings; else: $n = null; endif;
?>
<div class="panel-header bg-primary-gradient">
    <div class="page-inner py-5">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
            <div>
                <h2 class="text-white pb-2 fw-bold">Perfil de usuário</h2>
                <h5 class="text-white op-7 mb-2"><?= $userlogin['name']; ?></h5>
            </div>
            <div class="ml-md-auto py-2 py-md-0">
                <a class="btn btn-white btn-border btn-round mr-2" href="<?= HOME; ?>password-users.php">Atualizar senha</a>
                <a class="btn btn-secondary btn-round" data-toggle="modal" data-target="#UsersConfig">Configurações da conta</a>
            </div>
        </div>
    </div>
</div>

<div class="page-inner mt--5">
    <div class="row mt--2">
        <div class="col-md-12">
            <div class="card full-height">
                <div class="card-body">
                    <div class="card-title">Editar Perfil</div>
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
                            </div>

                            <div class="form-group row">
                                <label for="email1" class="col-sm-3 text-right control-label col-form-label">Foto de Perfil</label>
                                <div class="col-sm-9">
                                    <input type="file"  name="cover"  class="form-control" id="email1">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-10">
                                    <input type="submit" name="SendPostForm" class="btn btn-primary btn-sm" value="Atualizar Dados"/>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Estatísticas do usuário</div>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="multipleBarChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
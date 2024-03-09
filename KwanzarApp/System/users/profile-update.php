<?php
/**
 * Created by PhpStorm.
 * User: Kwanzar Soft
 * Date: 08/04/2020
 * Time: 01:33
 */

if(!class_exists('login')):
    header("index.php");
    die();
endif;

if($level >= 4): $n =  '&id_db_settings='.$id_db_settings; else: $n = null; endif;
?>

<div class="container-fluid">
    <div class="styles">
        <a href="panel.php?exe=users/profile<?= $n; ?>" class="btn btn-primary btn-sm">Voltar</a>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Perfil de Usuário!</h4>
                    <div class="basic-form">
                        <?php
                        $ClienteData = filter_input_array(INPUT_POST, FILTER_DEFAULT);

                        if ($ClienteData && $ClienteData['SendPostForm']):

                            $file = ($_FILES['cover']['tmp_name'] ? $_FILES['cover'] : null);
                            $Cadastrar = new DBKwanzar();
                            $Cadastrar->ExeUpdate($id_user, $ClienteData, $file, $id_db_settings);

                            if($Cadastrar->getResult()):
                                WSError($Cadastrar->getError()[0], $Cadastrar->getError()[1]);
                            else:
                                WSError($Cadastrar->getError()[0], $Cadastrar->getError()[1]);
                            endif;
                        else:
                            $ReadUser = new Read;
                            $ReadUser->ExeRead("db_users", "WHERE id=:userid AND id_db_settings=:i", "userid={$id_user}&i={$id_db_settings}");
                            if (!$ReadUser->getResult()):

                            else:
                                $ClienteData = $ReadUser->getResult()[0];
                                unset($ClienteData['password']);
                            endif;
                        endif;
                        ?>
                        <form  method="post" action="" name = "SendPostForm"  enctype="multipart/form-data">
                            <div class="form-group row">
                                <label for="fname" class="col-sm-3 text-right control-label col-form-label">Nome</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="fname" name="name" value="<?php if (!empty($ClienteData['name'])) echo $ClienteData['name']; ?>" placeholder="Nome">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email1" class="col-sm-3 text-right control-label col-form-label">Imagem(Foto de Perfil)</label>
                                <div class="col-sm-9">
                                    <input type="file"  name="cover"  class="form-control" id="email1">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-10">
                                    <input type="submit" name="SendPostForm" class="btn btn-dark" value="Atualizar Dados"/>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
/**
 * Created by PhpStorm.
 * User: Kwanzar Soft
 * Date: 09/06/2020
 * Time: 14:26
 */

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

<div class="row page-titles mx-0">
    <div class="col p-md-0">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= HOME; ?>panel.php?exe=default/home<?php if($level >= 4): echo '&id_db_settings='.$id_db_settings; endif; ?>">Painel de controle</a></li>
            <li class="breadcrumb-item active">Usuários<a href="<?= HOME; ?>panel.php?exe=users/index<?php if($level >= 4): echo '&id_db_settings='.$id_db_settings; endif; ?>"></a></li>
        </ol>
    </div>
</div>


<div class="container-fluid">
    <div class="styles">
        <a href="<?= HOME; ?>panel.php?exe=users/index<?= $n; ?>" class="btn btn-primary btn-icon-split btn-sm">
            <span class="text">Voltar</span>
        </a>&nbsp;
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Atualizar Usuários!</h4>
                    <div class="basic-form">
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
                                <input type="text" name="name" class="form-control" value="<?php if (!empty($ClienteData['name'])) echo $ClienteData['name']; ?>" placeholder="Nome">
                            </div>
                            <div class="form-group">
                                <select name="level" class="form-control">
                                    <option value = "">Selecione o Nível</option>
                                    <option value="1" <?php if (isset($ClienteData['level']) && $ClienteData['level'] == 1) echo 'selected="selected"'; ?>>Usuário</option>
                                    <option value="2" <?php if (isset($ClienteData['level']) && $ClienteData['level'] == 2) echo 'selected="selected"'; ?>>Gestor</option>
                                    <option value="3" <?php if (isset($ClienteData['level']) && $ClienteData['level'] == 3) echo 'selected="selected"'; ?>>Administrador</option>
                                </select>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-10">
                                    <input type="submit" name="SendPostForm" class="btn btn-primary btn-sm" value="Atualizar dados"/>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

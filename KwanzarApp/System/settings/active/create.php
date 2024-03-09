<?php
/**
 * Created by PhpStorm.
 * User: Kwanzar Soft
 * Date: 14/10/2020
 * Time: 10:53
 */


if(!class_exists('login')):
    header("index.php");
    die();
endif;

if($level >= 4): $n =  '&id_db_settings='.$id_db_settings; else: $n = null; endif;

if($userlogin['level'] < 3):
    header("location: painel.php?exe=default/index".$n);
endif;

?>
<div class="row page-titles mx-0">
    <div class="col p-md-0">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= HOME; ?>panel.php?exe=default/home<?php if($level >= 4): echo '&id_db_settings='.$id_db_settings; endif; ?>">Painel de controle</a></li>
            <li class="breadcrumb-item active"><a href="<?= HOME; ?>panel.php?exe=settings/active/index<?= $n; ?>">Motivo de documentos de retificação</a></li>
        </ol>
    </div>
</div>


<div class="container-fluid">
    <div class="styles">
        <a href="<?= HOME; ?>panel.php?exe=settings/active/index<?= $n; ?>" class="btn btn-primary btn-sm"><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Voltar"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "回传"; endif; ?></a>
    </div>


    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Motivo de documentos de rectificação</h4>
                    <?php
                    $ClienteData = filter_input_array(INPUT_POST, FILTER_DEFAULT);
                    if($ClienteData && $ClienteData['SendPostForm']):

                        $settings = new DBKwanzar();
                        $settings->ExeActive($ClienteData, $id_db_settings);

                        WSError($settings->getError()[0], $settings->getError()[1]);
                    endif;
                    ?>
                    <div class="basic-form">
                        <form method="post" action="" name = "SendPostForm"  enctype="multipart/form-data">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col">
                                        <span>Motivo de documentos de rectificação</span>
                                        <textarea name="active" id="active"  placeholder="Motivo de documentos de rectificação" class="form-control"><?php if (!empty($ClienteData['active'])) echo $ClienteData['active']; ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <hr/>
                            <div class="form-group row">
                                <div class="col-sm-10">
                                    <input type="submit" name="SendPostForm" class="btn btn-primary btn-sm" value="Salvar"/>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
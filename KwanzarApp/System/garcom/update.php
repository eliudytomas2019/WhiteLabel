<?php
/**
 * Created by PhpStorm.
 * User: Kwanzar Soft
 * Date: 16/08/2020
 * Time: 15:32
 */

if(!class_exists('login')):
    header("index.php");
    die();
endif;

if($level >= 4): $n =  '&id_db_settings='.$id_db_settings; else: $n = null; endif;

if($userlogin['level'] < 1):
    header("location: panel.php?exe=default/index".$n);
endif;
?>

<div class="container-fluid">
    <div id="styles">
        <a href="<?= HOME; ?>panel.php?exe=garcom/index<?= $n; ?>" class="btn btn-primary btn-sm">
            <span class="text">Voltar</span>
        </a>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Garçom</h4>
                    <div class="basic-form">
                        <?php
                        $userId = filter_input(INPUT_GET, 'postid', FILTER_VALIDATE_INT);
                        $ClienteData = filter_input_array(INPUT_POST, FILTER_DEFAULT);
                        if ($ClienteData && $ClienteData['SendPostForm']):
                            $Count = new Garcom();
                            $Count->ExeUpdate($userId, $ClienteData, $id_db_settings);

                            if($Count->getResult()):
                                WSError($Count->getError()[0], $Count->getError()[1]);
                            else:
                                WSError($Count->getError()[0], $Count->getError()[1]);
                            endif;
                        else:
                            $ReadUser = new Read;
                            $ReadUser->ExeRead("cv_garcom", "WHERE id = :userid AND id_db_settings=:i", "userid={$userId}&i={$id_db_settings}");
                            if (!$ReadUser->getResult()):

                            else:
                                $ClienteData = $ReadUser->getResult()[0];
                            endif;
                        endif;
                        ?>
                        <form class="form-horizontal" method="post" action="" name = "SendPostForm"  enctype="multipart/form-data">
                            <div class="form-group">
                                <input type="text" name="name" class="form-control" value="<?php if (!empty($ClienteData['name'])) echo $ClienteData['name']; ?>" placeholder="Garçom">
                            </div>
                            <div class="form-group">
                                <input type="text" name="telefone" class="form-control" value="<?php if (!empty($ClienteData['telefone'])) echo $ClienteData['telefone']; ?>" placeholder="telefone">
                            </div>

                            <div class="form-group">
                                <input type="text" name="porcentagem" class="form-control" value="<?php if (!empty($ClienteData['porcentagem'])) echo $ClienteData['porcentagem']; ?>" placeholder="porcentagem">
                            </div>

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

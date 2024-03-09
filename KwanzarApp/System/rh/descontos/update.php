<?php
/**
 * Created by PhpStorm.
 * User: Kwanzar Soft
 * Date: 04/09/2020
 * Time: 02:37
 */

if(!class_exists('login')):
    header("index.php");
    die();
endif;

if($level >= 4): $n =  '&id_db_settings='.$id_db_settings; else: $n = null; endif;

if($userlogin['level'] < 2):
    header("location: panel.php?exe=default/index".$n);
endif;
?>
<div class="row page-titles mx-0">
    <div class="col p-md-0">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= HOME; ?>panel.php?exe=default/home<?php if($level >= 4): echo '&id_db_settings='.$id_db_settings; endif; ?>">Painel de controle</a></li>
            <li class="breadcrumb-item active"><a href="<?= HOME; ?>panel.php?exe=rh/descontos/index<?php if($level >= 4): echo '&id_db_settings='.$id_db_settings; endif; ?>">Descontos</a></li>
        </ol>
    </div>
</div>

<div class="container-fluid">
    <div class="styles">
        <a href="?exe=rh/descontos/index<?= $n; ?>" class="btn btn-primary btn-sm">
            Voltar
        </a>&nbsp;
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Descontos</h4>
                    <div class="basic-form">
                        <?php
                        $ClienteData = filter_input_array(INPUT_POST, FILTER_DEFAULT);
                        $userId = filter_input(INPUT_GET, 'postid', FILTER_VALIDATE_INT);
                        if ($ClienteData && $ClienteData['SendPostForm']):
                            $Count = new RH();
                            $Count->UpdateDescontos($userId, $ClienteData, $id_db_settings);

                            if($Count->getResult()):
                                WSError($Count->getError()[0], $Count->getError()[1]);
                            else:
                                WSError($Count->getError()[0], $Count->getError()[1]);
                            endif;
                        else:
                            $ReadUser = new Read;
                            $ReadUser->ExeRead("rh_descontos", "WHERE id=:userid AND id_db_settings=:i", "userid={$userId}&i={$id_db_settings}");
                            if (!$ReadUser->getResult()):

                            else:
                                $ClienteData = $ReadUser->getResult()[0];
                            endif;
                        endif;
                        ?>
                        <form class="form-horizontal" method="post" action="" name = "SendPostForm"  enctype="multipart/form-data">
                            <div class="form-group">
                                <input type="text"  class="form-control " placeholder="Desconto" name="desconto" value="<?php if (!empty($ClienteData['desconto'])) echo $ClienteData['desconto']; ?>">
                            </div>
                            <div class="form-group">
                                <input type="text"  class="form-control" placeholder="Descrição" name="descricao" value="<?php if (!empty($ClienteData['descricao'])) echo $ClienteData['descricao']; ?>"/>
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

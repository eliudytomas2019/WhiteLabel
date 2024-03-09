<?php
/**
 * Created by PhpStorm.
 * User: Kwanzar Soft
 * Date: 04/09/2020
 * Time: 03:12
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
            <li class="breadcrumb-item active"><a href="<?= HOME; ?>panel.php?exe=rh/horarios/index<?php if($level >= 4): echo '&id_db_settings='.$id_db_settings; endif; ?>">Horários</a></li>
        </ol>
    </div>
</div>

<div class="container-fluid">
    <div class="styles">
        <a href="?exe=rh/horarios/index<?= $n; ?>" class="btn btn-primary btn-sm">
            Voltar
        </a>&nbsp;
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Horários</h4>
                    <div class="basic-form">
                        <?php
                        $ClienteData = filter_input_array(INPUT_POST, FILTER_DEFAULT);
                        $userId = filter_input(INPUT_GET, 'postid', FILTER_VALIDATE_INT);
                        if ($ClienteData && $ClienteData['SendPostForm']):
                            $Count = new RH();
                            $Count->UpdateHorarios($userId, $ClienteData, $id_db_settings);

                            if($Count->getResult()):
                                WSError($Count->getError()[0], $Count->getError()[1]);
                            else:
                                WSError($Count->getError()[0], $Count->getError()[1]);
                            endif;
                        else:
                            $ReadUser = new Read;
                            $ReadUser->ExeRead("rh_horarios", "WHERE id=:userid AND id_db_settings=:i", "userid={$userId}&i={$id_db_settings}");
                            if (!$ReadUser->getResult()):

                            else:
                                $ClienteData = $ReadUser->getResult()[0];
                            endif;
                        endif;
                        ?>
                        <form class="form-horizontal" method="post" action="" name = "SendPostForm"  enctype="multipart/form-data">
                            <div class="form-group">
                                <span>Horário</span>
                                <input type="text"  class="form-control" placeholder="Horario" name="horario" id="horario" value="<?php if (!empty($ClienteData['horario'])) echo $ClienteData['horario']; ?>"/>
                            </div>
                            <div class="form-group">
                                <span>Hora de Entrada</span>
                                <input type="time"  class="form-control" name="entrada" id="entrada" value="<?php if (!empty($ClienteData['entrada'])) echo $ClienteData['entrada']; ?>"/>
                            </div>
                            <div class="form-group">
                                <span>Hora do Almoço</span>
                                <input type="time"  class="form-control" name="almoco" id="almoco" value="<?php if (!empty($ClienteData['almoco'])) echo $ClienteData['almoco']; ?>"/>
                            </div>
                            <div class="form-group">
                                <span>Hora de Saída</span>
                                <input type="time"  class="form-control" name="saida" id="saida" value="<?php if (!empty($ClienteData['saida'])) echo $ClienteData['saida']; ?>"/>
                            </div>
                            <div class="form-group">
                                <span>Dias de trabalho</span>
                                <input type="text"  class="form-control" placeholder="Dias de trabalho" name="dias" id="dias" value="<?php if (!empty($ClienteData['dias'])) echo $ClienteData['dias']; ?>"/>
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

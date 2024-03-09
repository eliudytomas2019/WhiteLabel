<?php
$id_userX = strip_tags(trim(filter_input(INPUT_GET, 'id_user', FILTER_VALIDATE_INT)));

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
        <div class="page-header">
            <div class="row align-items-center">
                <?php require_once("btnBreak.inc.php"); ?>
                <div class="col">
                    <div class="page-pretitle">
                        <?= $Index['name']; ?>
                    </div>
                    <h2 class="page-title">
                        Horário e Agenda
                    </h2>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h5 class="modal-title">Horário e Agenda</h5>
            </div>
            <div class="card-body">
                <div>
                    <?php
                        $postId = filter_input(INPUT_GET, "postId", FILTER_VALIDATE_INT);

                        $Read = new Read();
                        $Read->ExeRead("db_users_clinic_horario", "WHERE id=:i ", "i={$postId}");

                        if($Read->getResult()):
                            $ClienteData = $Read->getResult()[0];
                        endif;
                    ?>
                </div>
                <div id="getResult"></div>
                <form method="post" action="#" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-lg-3">
                            <span>Hora de Entrada</span>
                            <input type="time" value="<?php if(isset($ClienteData['hora_i'])) echo $ClienteData['hora_i']; ?>" class="form-control" name="hora_i" id="hora_i"/>
                        </div>
                        <div class="col-lg-3">
                            <span>Hora de Saída</span>
                            <input type="time" class="form-control" value="<?php if(isset($ClienteData['hora_f'])) echo $ClienteData['hora_f']; ?>" name="hora_f" id="hora_f"/>
                        </div>
                        <div class="col-lg-6">
                            <span>Dia da Semana</span>
                            <select name="dia_da_semana" id="dia_da_semana" class="form-control">
                                <option>-- Selecione o dia da semana --</option>
                                <option value="Monday" <?php if(isset($ClienteData['dia_da_semana']) && $ClienteData['dia_da_semana'] == "Monday") echo "selected"; ?>>Segunda-feira</option>
                                <option value="Tuesday" <?php if(isset($ClienteData['dia_da_semana']) && $ClienteData['dia_da_semana'] == "Tuesday") echo "selected"; ?>>Terça-feira</option>
                                <option value="Wednesday" <?php if(isset($ClienteData['dia_da_semana']) && $ClienteData['dia_da_semana'] == "Wednesday") echo "selected"; ?>>Quarta-feira</option>
                                <option value="Thursday" <?php if(isset($ClienteData['dia_da_semana']) && $ClienteData['dia_da_semana'] == "Thursday") echo "selected"; ?>>Quinta-feira</option>
                                <option value="Friday" <?php if(isset($ClienteData['dia_da_semana']) && $ClienteData['dia_da_semana'] == "Friday") echo "selected"; ?>>Sexta-feira</option>
                                <option value="Saturday" <?php if(isset($ClienteData['dia_da_semana']) && $ClienteData['dia_da_semana'] == "Saturday") echo "selected"; ?>>Sábado</option>
                                <option value="Sunday" <?php if(isset($ClienteData['dia_da_semana']) && $ClienteData['dia_da_semana'] == "Sunday") echo "selected"; ?>>Domingo</option>
                            </select>
                        </div>
                    </div>
                    <hr/>
                    <br/><div class="col-lg-12">
                        <button type="button" onclick="ClinicHorarioUpdate(<?= $id_userX; ?>, <?= $id_db_settings; ?>, <?= $postId; ?>);" class="btn btn-primary">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
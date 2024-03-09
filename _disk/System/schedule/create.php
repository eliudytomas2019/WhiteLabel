<?php
if(!class_exists('login')):
    header("index.php");
    die();
endif;

if($level >= 4): $n =  '&id_db_settings='.$id_db_settings; else: $n = null; endif;

if($userlogin['level'] < 1):
    header("location: panel.php?exe=default/index".$n);
endif;

$postId = filter_input(INPUT_GET, "postid", FILTER_VALIDATE_INT);
?>
<div class="page-header col-md-9" style="margin: 0 auto!important;">
    <div class="row align-items-center">

        <div class="col-auto ms-auto d-print-none">
           <?php require_once("btnBreak.inc.php"); ?>
        </div>
        <div class="col">
            <div class="page-pretitle">
                <?= $Index['name']; ?>
            </div>
            <h2 class="page-title">
                Novo Agendamento
            </h2>
        </div>
    </div>
</div>

<div class="col-md-9" style="margin: 0 auto!important;">
    <div class="card">
        <div class="card-header">
            <h5 class="modal-title">Novo Agendamento</h5>
        </div>
        <div class="card-body">
            <div class="col-12" style="margin: 0 auto!important;">
                <div id="getResult"></div>
                <form method="post" action="" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-4">
                            <span>Paciente</span>
                            <select name="id_paciente" id="id_paciente" class="form-control">
                                <option>--- Seleciona o paciente ---</option>
                                <?php
                                $Read = new Read();
                                $Read->ExeRead("cv_customer", "WHERE id_db_settings=:i ", "i={$id_db_settings}");

                                if($Read->getResult()):
                                    foreach ($Read->getResult() as $key):

                                        if(!isset($key['dia']) || empty($key['dia'])): $key['dia'] = date('d'); endif;
                                        if(!isset($key['mes']) || empty($key['mes'])): $key['mes'] = date('m'); endif;
                                        if(!isset($key['ano']) || empty($key['ano'])): $key['ano'] = date('Y'); endif;
                                        ?>
                                        <option value="<?= $key['id']; ?>"><?= $key['nome']. " ({$key['dia']}/{$Meses[intval($key['mes'])]}/{$key['ano']}) "; ?></option>
                                    <?php
                                    endforeach;
                                endif;
                                ?>
                            </select>
                        </div>
                        <div class="col-4">
                            <span>Médico</span>
                            <select name="id_medico" id="id_medico" class="form-control">
                                <option>--- Seleciona o Médico ---</option>
                                <?php
                                $lv = 3;
                                $status = 1;
                                $Read = new Read();
                                $Read->ExeRead("db_users", "WHERE id_db_settings=:i AND level=:lv AND status=:st ", "i={$id_db_settings}&lv={$lv}&st={$status}");

                                if($Read->getResult()):
                                    foreach ($Read->getResult() as $key):
                                        ?>
                                        <option value="<?= $key['id']; ?>"><?= $key['name']." ({$key['username']})"; ?></option>
                                    <?php
                                    endforeach;
                                endif;
                                ?>
                            </select>
                        </div>
                        <div class="col-4">
                            <span>Status</span>
                            <select name="status_schedule" id="status_schedule" class="form-control">
                                <option value="1">Agendada</option>
                                <option value="2">Confirmada</option>
                                <option value="3">Paciente aguardando</option>
                                <option value="4">Paciente em atendimento</option>
                                <option value="5">Finalizada</option>
                                <option value="6">Faltou</option>
                                <option value="7">Cancelado pelo Paciente</option>
                                <option value="8">Cancelado pelo Médico</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <span>Data</span>
                            <input type="date" id="date_schedule" name="date_schedule" class="form-control">
                        </div>
                        <div class="col-4">
                            <span>Hora Inícial</span>
                            <input type="time" id="hora_i_schedule" name="hora_i_schedule" class="form-control">
                        </div>
                        <div class="col-4">
                            <span>Hora Final</span>
                            <input type="time" id="hora_f_schedule" name="hora_f_schedule" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <span>Observações</span>
                        <textarea class="form-control" name="content_schedule" id="content_schedule"></textarea>
                    </div>
                    <hr/>
                    <button type="button" onclick="CreateSchedule();" class="btn btn-primary">Salvar</button>
                </form>
            </div>
        </div>
    </div>
</div>
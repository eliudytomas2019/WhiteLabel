<div class="row">
    <?php
    $agendadas = null;
    $confirmadas = null;
    $finalizadas = null;
    $canceladas = null;

    $Readx = new Read();
    $Readx->ExeRead("db_clinic_agendamento", "WHERE id_db_settings=:i", "i={$id_db_settings}");
    if($Readx->getResult()):
        foreach ($Readx->getResult() as $key):
            if($key['status_schedule'] == 1):
                $agendadas += 1;
            elseif($key['status_schedule'] == 2):
                $confirmadas += 1;
            elseif($key['status_schedule'] == 5):
                $finalizadas += 1;
            else:
                $canceladas += 1;
            endif;
        endforeach;
    endif;
    ?>
    <div class="col-sm-3">
        <div class="card">
            <div class="card-body p-2 text-center">
                <div class="h1 m-0"><?= $agendadas; ?></div>
                <div class="text-muted mb-3" style="color: #313030!important;">Consultas Agendadas</div>
            </div>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="card">
            <div class="card-body p-2 text-center">
                <div class="h1 m-0"><?= $confirmadas; ?></div>
                <div class="text-muted mb-3" style="color: #313030!important;">Consultas Confirmadas</div>
            </div>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="card">
            <div class="card-body p-2 text-center">
                <div class="h1 m-0"><?= $finalizadas; ?></div>
                <div class="text-muted mb-3" style="color: #313030!important;">Consultas Finalizadas</div>
            </div>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="card">
            <div class="card-body p-2 text-center">
                <div class="h1 m-0"><?= $canceladas; ?></div>
                <div class="text-muted mb-3" style="color: #313030!important;">Consultas canceladas</div>
            </div>
        </div>
    </div>
</div><br/>
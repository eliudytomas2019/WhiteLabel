<?php
$Paciente = null;
$Medico = null;

$ColorSchedule = ["", "#0000FF", "#FFFF00", "#4B0082", "white", "lime", "orange", "red", "red"];

$Schedule = [];

$Read = new Read();

if($level == 3):
    $Read->ExeRead("db_clinic_agendamento", "WHERE id_db_settings=:i AND id_medico=:id ORDER BY id ASC ", "i={$id_db_settings}&id={$id_user}");
else:
    $Read->ExeRead("db_clinic_agendamento", "WHERE id_db_settings=:i ORDER BY id ASC ", "i={$id_db_settings}");
endif;

if($Read->getResult()):
    foreach ($Read->getResult() as $key):
        $Read->ExeRead("db_users", "WHERE id=:i ", "i={$key['id_medico']}");
        if($Read->getResult()):
            $Medico = $Read->getResult()[0];
        endif;

        $Read->ExeRead("cv_customer", "WHERE id=:id ", "id={$key['id_paciente']}");
        if($Read->getResult()):
            $Paciente = $Read->getResult()[0];
        endif;

        $Schedule[] = [
            'id' => $key['id'],
            'title' => "Consulta | Médico: {$Medico['name']} | Paciente: {$Paciente['nome']} | Estado: {$StatusSchedule[$key['status_schedule']]} ",
            "color" => "{$ColorSchedule[intval($key['status_schedule'])]}",
            'start' => "{$key['date_schedule']}T{$key['hora_i_schedule']}",
            'end' => "{$key['date_schedule']}T{$key['hora_f_schedule']}"
        ];
    endforeach;
endif;
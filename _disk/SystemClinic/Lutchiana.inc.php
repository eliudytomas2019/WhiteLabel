<?php
$posti = 0;
$getPage = filter_input(INPUT_GET, 'page',FILTER_VALIDATE_INT);
$Pager = new Pager("panel.php?exe=patient/index{$n}&page=");
$Pager->ExePager($getPage, 10);

$read = new Read();
$read->ExeRead("cv_customer", "WHERE id_db_settings=:id ORDER BY id DESC LIMIT :limit OFFSET :offset", "id={$id_db_settings}&limit={$Pager->getLimit()}&offset={$Pager->getOffset()}");
if($read->getResult()):
    foreach ($read->getResult() as $key):
        extract($key);

        if($level == 3):
            $Readx = new Read();
            $Readx->ExeRead("db_clinic_agendamento", "WHERE id_db_settings=:i AND id_paciente=:iv AND id_medico=:mm ", "i={$id_db_settings}&iv={$key['id']}&mm={$id_user}");
            if($Readx->getResult()):
                require("EuPraMerdaNaoVolto.inc.php");
            endif;
        else:
            require("EuPraMerdaNaoVolto.inc.php");
        endif;

    endforeach;
endif;
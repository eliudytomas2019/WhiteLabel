<?php
if(DBKwanzar::CheckConfig($id_db_settings) == false || DBKwanzar::CheckConfig($id_db_settings)['JanuarioSakalumbu'] == null  || DBKwanzar::CheckConfig($id_db_settings)['JanuarioSakalumbu'] == '' || empty(DBKwanzar::CheckConfig($id_db_settings)['JanuarioSakalumbu'])):
    $ttt = 2; else: $ttt = DBKwanzar::CheckConfig($id_db_settings)['JanuarioSakalumbu'];
endif;

$Yea = date('Y');
$vp = date('m');
$sLnL = 0;


$Ya = date('Y') - 1;
$Yb = date('Y');

$iInfo1 = [];
$iInfo2 = [];

$read = new Read();

$Ch1mound = [];

if(!isset(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || empty(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || DBKwanzar::CheckConfig($id_db_settings)['Idioma'] == "Português"):
    $Meses = ["", "Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"];
else:
    $Meses = ["", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
endif;

for($i = 1; $i <= $vp; $i++):
    if($i <= 9): $mounds = "0".$i; else: $mounds = $i; endif;

    $Ch1mound[] .= $Meses[$i];

    $ol1 = "sd_billing";
    $ol2 = "sd_billing_pmp";
    $ol3 = "sd_retification";
    $ol4 = "sd_retification_pmp";

    $read->FullRead("SELECT COUNT(id) as iInfo1 FROM {$ol1} WHERE id_db_settings={$id_db_settings} AND InvoiceType!='PP' AND mes={$mounds} AND ano={$Yb} AND suspenso={$sLnL} AND status={$ttt}");
    if($read->getResult()):
        $iInfo2[] += $read->getResult()[0]['iInfo1'];
    endif;

    $read->FullRead("SELECT COUNT(id) as iInfo2 FROM {$ol1} WHERE id_db_settings={$id_db_settings} AND InvoiceType!='PP' AND mes={$mounds} AND ano={$Ya} AND suspenso={$sLnL} AND status={$ttt}");
    if($read->getResult()):
        $iInfo1[] += $read->getResult()[0]['iInfo2'];
    endif;
endfor;
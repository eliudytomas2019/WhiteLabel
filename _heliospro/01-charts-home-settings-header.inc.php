<?php
/**
 * Created by PhpStorm.
 * User: Kwanzar Soft
 * Date: 05/06/2020
 * Time: 13:56
 */

$iInfo = [];
$aInfo = [];
$eInfo = [];
$oInfo = [];
$uInfo = [];
$xInfo = [];
$nInfo = [];

if(DBKwanzar::CheckConfig($id_db_settings) == false || DBKwanzar::CheckConfig($id_db_settings)['JanuarioSakalumbu'] == null  || DBKwanzar::CheckConfig($id_db_settings)['JanuarioSakalumbu'] == '' || empty(DBKwanzar::CheckConfig($id_db_settings)['JanuarioSakalumbu'])):
    $ttt = 2; else: $ttt = DBKwanzar::CheckConfig($id_db_settings)['JanuarioSakalumbu'];
endif;

$Yea = date('Y');
$vp = date('m');
$sLnL = 0;


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

    $read->FullRead("SELECT COUNT(id) as iInfo FROM {$ol1} WHERE id_db_settings={$id_db_settings} AND InvoiceType='FR' AND mes={$mounds} AND ano={$Yea} AND suspenso={$sLnL} AND status={$ttt}");
    if($read->getResult()):
        $iInfo[] += $read->getResult()[0]['iInfo'];
    endif;

    $read->FullRead("SELECT COUNT(id) as iInfo FROM {$ol1} WHERE id_db_settings={$id_db_settings} AND InvoiceType='FT' AND mes={$mounds} AND ano={$Yea} AND suspenso={$sLnL} AND status={$ttt}");
    if($read->getResult()):
        $aInfo[] += $read->getResult()[0]['iInfo'];
    endif;

    $read->FullRead("SELECT COUNT(id) as iInfo FROM {$ol3} WHERE id_db_settings={$id_db_settings} AND InvoiceType='NC' AND mes={$mounds} AND ano={$Yea} AND status={$ttt}");
    if($read->getResult()):
        $eInfo[] += $read->getResult()[0]['iInfo'];
    endif;

    $read->FullRead("SELECT COUNT(id) as iInfo FROM {$ol3} WHERE id_db_settings={$id_db_settings} AND InvoiceType='ND' AND mes={$mounds} AND ano={$Yea} AND status={$ttt}");
    if($read->getResult()):
        $oInfo[] += $read->getResult()[0]['iInfo'];
    endif;

    $read->FullRead("SELECT COUNT(id) as iInfo FROM {$ol3} WHERE id_db_settings={$id_db_settings} AND InvoiceType='RE' AND mes={$mounds} AND ano={$Yea} AND status={$ttt}");
    if($read->getResult()):
        $uInfo[] += $read->getResult()[0]['iInfo'];
    endif;

    $read->FullRead("SELECT COUNT(id) as iInfo FROM {$ol3} WHERE id_db_settings={$id_db_settings} AND InvoiceType='RC' AND mes={$mounds} AND ano={$Yea} AND status={$ttt}");
    if($read->getResult()):
        $xInfo[] += $read->getResult()[0]['iInfo'];
    endif;

    $read->FullRead("SELECT COUNT(id) as iInfo FROM {$ol3} WHERE id_db_settings={$id_db_settings} AND InvoiceType='RG' AND mes={$mounds} AND ano={$Yea} AND status={$ttt}");
    if($read->getResult()):
        $nInfo[] += $read->getResult()[0]['iInfo'];
    endif;
endfor;
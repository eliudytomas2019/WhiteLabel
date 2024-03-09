<?php
/**
 * Created by PhpStorm.
 * User: Kwanzar Soft
 * Date: 05/06/2020
 * Time: 15:52
 */

$iAnfo = [];
$aAnfo = [];
$eAnfo = [];
$oAnfo = [];
$uAnfo = [];
$xAnfo = [];
$nAnfo = [];

if(DBKwanzar::CheckConfig($id_db_settings) == false || DBKwanzar::CheckConfig($id_db_settings)['JanuarioSakalumbu'] == null): $ttt = 2; else: $ttt = DBKwanzar::CheckConfig($id_db_settings)['JanuarioSakalumbu']; endif;

$Yea = date('Y');
$vp = date('d');
$sLnL = 0;


$read = new Read();
$sj = date('m');

$Ch2mound = [];

for($i = 1; $i <= $vp; $i++):
    if($i <= 9): $mounds = "0".$i; else: $mounds = $i; endif;

    $Ch2mound[] += $i;

    $ol1 = "sd_billing";
    $ol2 = "sd_billing_pmp";
    $ol3 = "sd_retification";
    $ol4 = "sd_retification_pmp";

    $read->FullRead("SELECT COUNT(id) as iInfo FROM {$ol1} WHERE id_db_settings={$id_db_settings} AND InvoiceType='FR' AND dia={$mounds} AND mes={$sj} AND ano={$Yea} AND suspenso={$sLnL} AND status={$ttt}");
    if($read->getResult()):
        $iAnfo[] += $read->getResult()[0]['iInfo'];
    endif;

    $read->FullRead("SELECT COUNT(id) as iInfo FROM {$ol1} WHERE id_db_settings={$id_db_settings} AND InvoiceType='FT' AND dia={$mounds} AND mes={$sj} AND ano={$Yea} AND suspenso={$sLnL} AND status={$ttt}");
    if($read->getResult()):
        $aAnfo[] += $read->getResult()[0]['iInfo'];
    endif;

    $read->FullRead("SELECT COUNT(id) as iInfo FROM {$ol3} WHERE id_db_settings={$id_db_settings} AND InvoiceType='NC' AND dia={$mounds} AND mes={$sj} AND ano={$Yea} AND status={$ttt}");
    if($read->getResult()):
        $eAnfo[] += $read->getResult()[0]['iInfo'];
    endif;

    $read->FullRead("SELECT COUNT(id) as iInfo FROM {$ol3} WHERE id_db_settings={$id_db_settings} AND InvoiceType='ND' AND dia={$mounds} AND mes={$sj} AND ano={$Yea} AND status={$ttt}");
    if($read->getResult()):
        $oAnfo[] += $read->getResult()[0]['iInfo'];
    endif;

    $read->FullRead("SELECT COUNT(id) as iInfo FROM {$ol3} WHERE id_db_settings={$id_db_settings} AND InvoiceType='RE' AND dia={$mounds} AND mes={$sj} AND ano={$Yea} AND status={$ttt}");
    if($read->getResult()):
        $uAnfo[] += $read->getResult()[0]['iInfo'];
    endif;

    $read->FullRead("SELECT COUNT(id) as iInfo FROM {$ol3} WHERE id_db_settings={$id_db_settings} AND InvoiceType='RC' AND dia={$mounds} AND mes={$sj} AND ano={$Yea} AND status={$ttt}");
    if($read->getResult()):
        $xAnfo[] += $read->getResult()[0]['iInfo'];
    endif;

    $read->FullRead("SELECT COUNT(id) as iInfo FROM {$ol3} WHERE id_db_settings={$id_db_settings} AND InvoiceType='RG' AND dia={$mounds} AND mes={$sj} AND ano={$Yea} AND status={$ttt}");
    if($read->getResult()):
        $nAnfo[] += $read->getResult()[0]['iInfo'];
    endif;
endfor;
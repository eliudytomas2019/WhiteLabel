<?php
/**
 * Created by PhpStorm.
 * User: Kwanzar Soft
 * Date: 21/06/2020
 * Time: 00:00
 */

if(!isset(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || empty(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || DBKwanzar::CheckConfig($id_db_settings)['Idioma'] == "Português"):
    $Meses003 = ["", "Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"];
else:
    $Meses003 = ["", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
endif;

$CharMeses003 = [];

$F01 = [];
$F02 = [];
$F03 = [];
$F04 = [];
$F05 = [];
$F06 = [];
$F07 = [];

$mY = date('m');
$Y = date('Y');

for($i = 1; $i <= $mY; $i++):
    if($i <= 9): $mP = "0".$i; else: $mP = $i; endif;
    $CharMeses003[] = $Meses003[$i];

    $Readln = new Read();
    $Readln->FullRead("SELECT count(id) as chart01 FROM sd_billing WHERE session_id={$userlogin['id']} AND id_db_settings={$id_db_settings} AND mes={$mP} AND ano={$Y} AND InvoiceType='PP'");
    if($Readln->getResult()):
        $F01[] += $Readln->getResult()[0]['chart01'];
    endif;

    $Readln->FullRead("SELECT count(id) as chart02 FROM sd_billing WHERE session_id={$userlogin['id']} AND id_db_settings={$id_db_settings} AND mes={$mP} AND ano={$Y} AND InvoiceType='FR'");
    if($Readln->getResult()):
        $F02[] += $Readln->getResult()[0]['chart02'];
    endif;

    $Readln->FullRead("SELECT count(id) as chart03 FROM sd_billing WHERE session_id={$userlogin['id']} AND id_db_settings={$id_db_settings} AND mes={$mP} AND ano={$Y} AND InvoiceType='FT'");
    if($Readln->getResult()):
        $F03[] += $Readln->getResult()[0]['chart03'];
    endif;

    $Readln->FullRead("SELECT count(id) as chart04 FROM sd_retification WHERE session_id={$userlogin['id']} AND id_db_settings={$id_db_settings} AND mes={$mP} AND ano={$Y} AND InvoiceType='RE'");
    if($Readln->getResult()):
        $F04[] += $Readln->getResult()[0]['chart04'];
    endif;

    $Readln->FullRead("SELECT count(id) as chart07 FROM sd_retification WHERE session_id={$userlogin['id']} AND id_db_settings={$id_db_settings} AND mes={$mP} AND ano={$Y} AND InvoiceType='RC'");
    if($Readln->getResult()):
        $F07[] += $Readln->getResult()[0]['chart07'];
    endif;

    $Readln->FullRead("SELECT count(id) as chart05 FROM sd_retification WHERE session_id={$userlogin['id']} AND id_db_settings={$id_db_settings} AND mes={$mP} AND ano={$Y} AND InvoiceType='ND'");
    if($Readln->getResult()):
        $F05[] += $Readln->getResult()[0]['chart05'];
    endif;

    $Readln->FullRead("SELECT count(id) as chart06 FROM sd_retification WHERE session_id={$userlogin['id']} AND id_db_settings={$id_db_settings} AND mes={$mP} AND ano={$Y} AND InvoiceType='NC'");
    if($Readln->getResult()):
        $F06[] += $Readln->getResult()[0]['chart06'];
    endif;
endfor;
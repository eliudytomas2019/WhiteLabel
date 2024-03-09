<?php
/**
 * Created by PhpStorm.
 * User: Kwanzar Soft
 * Date: 30/07/2020
 * Time: 01:13
 */

if(!isset(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || empty(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || DBKwanzar::CheckConfig($id_db_settings)['Idioma'] == "Português"):
    $Tattos = ["", "Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"];
else:
    $Tattos = ["", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
endif;

$Jantes = [];

$FR01 = [];

$mY = date('m');
$Y = date('Y');

for($i = 1; $i <= $mY; $i++):
    if($i <= 9): $mP = "0".$i; else: $mP = $i; endif;
    $Jantes[] = $Tattos[$i];

    $Readln = new Read();
    $Readln->FullRead("SELECT count(id) as chart01 FROM db_users_active_store WHERE  id_db_settings={$id_db_settings} AND mes={$mP} AND ano={$Y}");
    if($Readln->getResult()):
        $FR01[] += $Readln->getResult()[0]['chart01'];
    endif;
endfor;
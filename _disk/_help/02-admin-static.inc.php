<?php
$Read = new Read();
$Reads = new Read();

$dia = date('d');
$mes = date('m');
$ano = date('Y');
$access_user = null;
$users_online = 0;


$Meses = ["", "Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"];


$mess = [];
$users_actives = [];
$empresas_actives = [];
$empresas_novasz = [];

for($i = 1; $i <= $mes; $i++):
    if($i <= 9): $mounds = "0".$i; else: $mounds = $i; endif;
    $mess[] = $Meses[$i];

    $Read->FullRead("SELECT COUNT(session_id) as access FROM db_users_active_static WHERE  mes={$mounds} AND ano={$ano}");
    if($Read->getResult()): $users_actives[] = $Read->getResult()[0]['access']; endif;

    $Read->FullRead("SELECT COUNT(id) as access FROM db_settings WHERE  mes={$mounds} AND ano={$ano}");
    if($Read->getResult()): $empresas_novasz[] = $Read->getResult()[0]['access']; endif;

    $Read->FullRead("SELECT COUNT(id_db_settings) as access FROM db_settings_static WHERE mes={$mounds} AND ano={$ano}");
    if($Read->getResult()): $empresas_actives[] = $Read->getResult()[0]['access']; endif;
endfor;
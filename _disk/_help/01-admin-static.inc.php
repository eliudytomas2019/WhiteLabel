<?php
$Read = new Read();
$Reads = new Read();

$dia = date('d');
$mes = date('m');
$ano = date('Y');
$access_user = null;
$users_online = 0;


$Meses = ["", "Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"];


$dias = [];
$users_active = [];
$empresas_active = [];
$empresas_novas = [];

for($i = 1; $i <= $dia; $i++):
    if($i <= 9): $mounds = "0".$i; else: $mounds = $i; endif;
    $dias[] += $mounds;

    $Read->FullRead("SELECT COUNT(session_id) as access FROM db_users_active_static WHERE dia={$mounds} AND mes={$mes} AND ano={$ano}");
    if($Read->getResult()): $users_active[] = $Read->getResult()[0]['access']; endif;

    $Read->FullRead("SELECT COUNT(id) as access FROM db_settings WHERE dia={$mounds} AND mes={$mes} AND ano={$ano}");
    if($Read->getResult()): $empresas_novas[] = $Read->getResult()[0]['access']; endif;

    $Read->FullRead("SELECT COUNT(id_db_settings) as access FROM db_settings_static WHERE dia={$mounds} AND mes={$mes} AND ano={$ano}");
    if($Read->getResult()): $empresas_active[] = $Read->getResult()[0]['access']; endif;
endfor;
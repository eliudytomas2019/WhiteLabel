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
$licencas_paga = [];
$novas_empresas = [];

for($i = 1; $i <= $mes; $i++):
    if($i <= 9): $mounds = "0".$i; else: $mounds = $i; endif;
    $mess[] = $Meses[$i];

    $Read->FullRead("SELECT COUNT(id) as access FROM ws_times_backup WHERE  mes={$mounds} AND ano={$ano}");
    if($Read->getResult()): $licencas_paga[] = $Read->getResult()[0]['access']; endif;

    $Read->FullRead("SELECT COUNT(id) as access FROM db_settings WHERE mes={$mounds} AND ano={$ano}");
    if($Read->getResult()): $novas_empresas[] = $Read->getResult()[0]['access']; endif;
endfor;
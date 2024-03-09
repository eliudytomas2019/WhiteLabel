<?php

$mes = date('m');
$ano = date('Y');
$dias = date('d');

$Meses = ["", "Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"];

$z8_dias = [];
$z8_result = [];


for($i = 1; $i <= $mes; $i++):
    if($i <= 9): $mounds = "0".$i; else: $mounds = $i; endif;
    $z8_dias[] = $Meses[$i];


    $Read = new Read();
    $Read->FullRead("SELECT COUNT(id) as actives FROM site_views_static WHERE mes={$mounds} AND ano={$ano} ");
    if($Read->getResult()): $z8_result[] = $Read->getResult()[0]['actives']; endif;
endfor;
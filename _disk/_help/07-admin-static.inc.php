<?php

$mes = date('m');
$ano = date('Y');
$dias = date('d');

$z7_dias = [];
$z7_result = [];

for($i = 1; $i <= $dias; $i++):
    if($i <= 9): $dia = "0".$i; else: $dia = $i; endif;
    $z7_dias[] = $i;

    $Read = new Read();
    $Read->FullRead("SELECT COUNT(id) as actives FROM site_views_static WHERE dia={$dia} AND mes={$mes} AND ano={$ano} ");
    if($Read->getResult()): $z7_result[] = $Read->getResult()[0]['actives']; endif;
endfor;
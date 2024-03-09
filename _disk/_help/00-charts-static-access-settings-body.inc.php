<?php
$mO = date('Y');
$mI = date('d');
$mA = date('m');
$All01 = [];
$All02 = [];

for($i = 0; $i <= $mI; $i++):
    if($mI <= 9): $ip = "0".$i; else: $ip = $i; endif;

    $All01[] += $ip;

    $read = new Read();
    $read->FullRead("SELECT count(id) as Tot01 FROM site_views_static WHERE dia={$ip} AND mes={$mA} AND ano={$mO}");

    if($read->getResult()):
        $All02[] += $read->getResult()[0]['Tot01'];
    endif;
endfor;
<?php
$empresas_names = [];
$empresas_views = [];

$Read = new Read();
$Reads = new Read();
$AllReads = new Read();

$Read->ExeRead("db_settings_all_in_one", "ORDER BY total DESC LIMIT 5");
if($Read->getResult()):
    foreach ($Read->getResult() as $views):
        $AllReads->ExeRead("db_settings", "WHERE id=:i", "i={$views['id_db_settings']}");
        if($AllReads->getResult()): $empresas_names[] .= $AllReads->getResult()[0]['empresa']; else: $empresas_names[] .= "Visitante"; endif;
        $empresas_views[] += $views['total'];
    endforeach;
endif;
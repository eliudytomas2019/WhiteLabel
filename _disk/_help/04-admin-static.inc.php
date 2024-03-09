<?php
$users_names = [];
$users_views = [];

$Read = new Read();
$Reads = new Read();
$AllReads = new Read();

$Read->ExeRead("db_users_all_in_one", "ORDER BY total DESC LIMIT 5");
if($Read->getResult()):
    foreach ($Read->getResult() as $views):
        $AllReads->ExeRead("db_users", "WHERE id=:i", "i={$views['session_id']}");
        if($AllReads->getResult()):  $users_names[] .= $AllReads->getResult()[0]['name']; else: $users_names[] .= "Visitante"; endif;
        $users_views[] += $views['total'];
    endforeach;
endif;
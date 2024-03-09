<?php
$Browser = [];
$Views = [];

$Read = new Read();
$Read->ExeRead("db_users_browser_static", "ORDER BY views DESC LIMIT 5");
if($Read->getResult()):
    foreach ($Read->getResult() as $key):
        $Browser[] .= $key["browser"];
        $Views[] += $key["views"];
    endforeach;
endif;
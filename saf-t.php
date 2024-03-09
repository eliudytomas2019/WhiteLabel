<?php
require_once("Config.inc.php");

$ClienteData = filter_input_array(INPUT_POST, FILTER_DEFAULT);
if ($ClienteData && $ClienteData['SendPostForm']):
    $id_db_settings = htmlspecialchars(trim($_POST['id_db_settings']));
    $dateI          = htmlspecialchars(trim($_POST['dataInicial']));
    $dateF          = htmlspecialchars(trim($_POST['dataFinal']));

    $Saft = new Saft();
    $Saft->XML($dateI, $dateF, $id_db_settings);
endif;
ob_end_flush();
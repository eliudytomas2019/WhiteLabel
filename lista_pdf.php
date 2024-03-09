<?php
//ini_set('max_execution_time', 180);
use Dompdf\Dompdf;

require __DIR__."/vendor/autoload.php";
$dompdf = new Dompdf();

ob_start();
require_once("_disk/IncludesApp/headerPanel.inc.php");
$Reads = new Read();
$Reads->ExeRead("z_config");
if($Reads->getResult()): $Index = $Reads->getResult()[0]; else: $Index = null; endif;
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="_disk/css/developer_css.css"/>
</head>
<body>
<?php
    require("_System4Life/01-system-WoW-Lista-de-Precos.inc.php");
?>
</body>
</html>
<?php

$dompdf->loadHtml(ob_get_clean());
$dompdf->setPaper("A4");

$file = "Lista_de_precos_".time();

$dompdf->render();
$dompdf->stream("{$file}", ["Attachment" => false]);

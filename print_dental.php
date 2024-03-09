<?php
use Dompdf\Dompdf;

require __DIR__."/vendor/autoload.php";
$dompdf = new Dompdf();

ob_start();
require_once("_disk/IncludesApp/headerPanel.inc.php");
$Reads = new Read();
$Reads->ExeRead("z_config");
if($Reads->getResult()): $Index = $Reads->getResult()[0]; else: $Index = null; endif;
$Number = filter_input(INPUT_GET, "post", FILTER_VALIDATE_INT);
$action = filter_input(INPUT_GET, "action", FILTER_DEFAULT);
if(isset($_GET['id_user'])):         $id_user         = (int) filter_input(INPUT_GET, "id_user", FILTER_DEFAULT); endif;
if(isset($_GET['id_mesa'])):         $id_mesa         = (int) filter_input(INPUT_GET, "id_mesa", FILTER_DEFAULT); endif;
if(isset($_GET['dateI'])):           $dateI           = strip_tags(trim($_GET['dateI'])); endif;
if(isset($_GET['dateF'])):           $dateF           = strip_tags(trim($_GET['dateF'])); endif;
if(isset($_GET['TypeDoc'])):         $TypeDoc         = strip_tags(trim($_GET['TypeDoc'])); endif;
if(isset($_GET['Function_id'])):     $Function_id     = strip_tags(trim($_GET['Function_id'])); endif;
if(isset($_GET['Customers_id'])):    $Customers_id    = strip_tags(trim($_GET['Customers_id'])); endif;
if(isset($_GET['SourceBilling'])):   $SourceBilling   = strip_tags(trim($_GET['SourceBilling'])); else: $SourceBilling = null; endif;
if(isset($_GET['InvoiceType'])):     $InvoiceType     = strip_tags(trim($_GET['InvoiceType'])); endif;
if(isset($_GET['dia'])):             $day             = strip_tags(trim($_GET['dia'])); endif;
if(isset($_GET['mes'])):             $mondy           = strip_tags(trim($_GET['mes'])); endif;
if(isset($_GET['ano'])):             $year            = strip_tags(trim($_GET['ano'])); endif;
if(isset($_GET['postId'])):          $postId          = strip_tags(trim($_GET['postId'])); endif;
if(!isset($mondy)): $mondy = date('m'); endif;
if(!isset($year)):  $year  = date('Y'); endif;
$DB = new DBKwanzar();


$Total_sI = 0;
$Total_I  = 0;

$n = 0;
$g;
$iva_i = 0;
$Aiko = "";
$totol_iva = 0;
$total_desconto = 0;
$total_valor = 0;
$total_preco = 0;
$total_geral = 0;
$Si          = 0;
$So          = 0;
$p = array();

if(DBKwanzar::CheckConfig($id_db_settings)['JanuarioSakalumbu'] == null): $ttt = 2; else: $ttt = DBKwanzar::CheckConfig($id_db_settings)['JanuarioSakalumbu']; endif;
$suspenso = 0;

require_once("Anamnese.inc.php");
?>
    <!DOCTYPE html>
    <html>
    <head>
        <link rel="stylesheet" href="./css/POSKwanzar.css"/>
        <script type="text/javascript">setTimeout("window.close();", 10000);</script>
    </head>
    <body onload="window.print();">
    <?php
    if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['NumberOfCopies'] == '' || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['NumberOfCopies'] == null || empty(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['NumberOfCopies']) || !isset(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['NumberOfCopies'])): $iPus = 1; else: $iPus = 1; endif;

    if(DBKwanzar::CheckConfig($id_db_settings)['DocModel'] == 2):
        if($action == 01):
            $id_paciente = strip_tags(trim($_GET['id_paciente']));
            require("_System4Life/01-system-DeD-document-new.inc.php");
            $name_file = "anemnese_{$id_paciente}_{$postId}";
        elseif($action == 02):
            $id_paciente = strip_tags(trim($_GET['id_paciente']));
            require("_System4Life/02-system-DeD-document-new.inc.php");
            $name_file = "receita_0{$postId}";
        elseif($action == 03):
            $id_paciente = strip_tags(trim($_GET['id_paciente']));
            require("_System4Life/03-system-DeD-document-new.inc.php");
            $name_file = "atestado_0{$postId}";
        elseif($action == 2005):
            require("_SystemWoW/header-geral-system-WoW-invoice-document.inc.php");
            require("AppData/2003-system-WoW.inc.php");
            require("_SystemWoW/footer-outer.inc.php");
        elseif($action == 1965):
            require("_SystemWoW/header-geral-system-WoW-invoice-document.inc.php");
            require("AppData/2001-system-WoW.inc.php");
            require("_SystemWoW/footer-outer.inc.php");
        else:
            $name_file = null;
        endif;
    endif;
    ?>
    <title><?= $name_file; ?></title>
    </body>
    </html>
<?php


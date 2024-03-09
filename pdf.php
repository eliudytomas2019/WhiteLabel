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
if(isset($_GET['InvoiceType'])):     $InvoiceType     = strip_tags(trim($_GET['InvoiceType'])); else: $InvoiceType = null; endif;
if(isset($_GET['dia'])):             $day             = strip_tags(trim($_GET['dia'])); endif;
if(isset($_GET['mes'])):             $mondy           = strip_tags(trim($_GET['mes'])); endif;
if(isset($_GET['ano'])):             $year            = strip_tags(trim($_GET['ano'])); endif;
if(isset($_GET['postId'])):          $postId          = strip_tags(trim($_GET['postId'])); endif;
if(!isset($mondy)): $mondy = date('m'); endif;
if(!isset($year)):  $year  = date('Y'); endif;

if(isset($_GET['method_id'])):         $method_id         = strip_tags(trim($_GET['method_id'])); endif;
if(isset($_GET['invoice_id'])):        $invoice_id        = strip_tags(trim($_GET['invoice_id'])); endif;

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

if($year <= "2020" && $mondy <= "07"):
    $InBody = '';
    $InHead = '';
else:
    $InHead = "AND sd_billing.InvoiceType=:In AND sd_billing_pmp.InvoiceType=:In";
    $InBody = "&In={$InvoiceType}";
endif;
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="icon" href="uploads/<?= $Index['icon']; ?>"/>
    <?php if(DBKwanzar::CheckConfig($id_db_settings)['DocModel'] == 2 || DBKwanzar::CheckConfig($id_db_settings)['DocModel'] == 3): ?>
        <link rel="stylesheet" href="_disk/css/developer.css"/>
    <?php else: ?>
        <link rel="stylesheet" href="_disk/css/developer2.css"/>
    <?php endif; ?>

    <link rel="stylesheet" href="_disk/css/Kwanzar.css" />
</head>
<body>
<?php
    if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['NumberOfCopies'] == '' || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['NumberOfCopies'] == null || empty(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['NumberOfCopies']) || !isset(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['NumberOfCopies'])): $iPus = 1; else: $iPus = 1; endif;

    if(DBKwanzar::CheckConfig($id_db_settings)['DocModel'] == 2):
        switch ($action):
            case '01':
                if(!isset(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || empty(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || DBKwanzar::CheckConfig($id_db_settings)['Idioma'] == "Português"):
                    for($i = 1; $i <= $iPus; $i++):
                        require("_System4Life/02-system-WoW-invoice-document-new.inc.php");
                    endfor;
                else:
                    for($i = 1; $i <= $iPus; $i++):
                        require("_System4Life/02-system-WoW-invoice-document-new-ingles.inc.php");
                    endfor;
                endif;
                break;
            case '02':
                if($InvoiceType == 'NC' || $InvoiceType == 'RE' || $InvoiceType == 'ND'):
                    if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Impression'] == 'A4' || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Impression'] == '' || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Impression'] == null || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Impression'] == 'A4M2'):
                        for($i = 1; $i <= $iPus; $i++):
                            require("_SystemWoW/02-system-WoW-invoice-document-new-new.inc.php");
                        endfor;
                    endif;
                elseif($InvoiceType == 'RG' || $InvoiceType == 'RC'):
                    if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Impression'] == 'A4' || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Impression'] == '' || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Impression'] == null || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Impression'] == 'A4M2'):
                        for($i = 1; $i <= $iPus; $i++):
                            require("_SystemWoW/02.2-system-WoW-invoice-document-new.inc.php");
                        endfor;
                    endif;
                endif;
                break;
            case '03':
                if($InvoiceType == 'GT'):
                    if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Impression'] == 'A4' || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Impression'] == '' || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Impression'] == null || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Impression'] == 'A4M2'):
                        for($i = 1; $i <= $iPus; $i++):
                            require("_SystemWoW/03-system-WoW-invoice-document-new-new.inc.php");
                        endfor;
                    endif;
                endif;
                break;
            case '05':
                if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Impression'] == 'A4' || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Impression'] == '' || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Impression'] == null || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Impression'] == 'A4M2'):
                    for($i = 1; $i <= $iPus; $i++):
                        require("_SystemWoW/05-system-WoW-invoice-document-new-new.inc.php");
                    endfor;
                endif;
                break;
            case '167435':
                require("_System4Life/01-system-WoW-ExtractCustomer.inc.php");
                break;
            default:
                WSError("Ops!!! Não econtramos o relatório desejado!", WS_ALERT);
        endswitch;;
    elseif(DBKwanzar::CheckConfig($id_db_settings)['DocModel'] == 3):
        for($i = 1; $i <= $iPus; $i++):
            require("_System4Life/03-system-WoW-invoice-document-new.inc.php");
        endfor;
    elseif(DBKwanzar::CheckConfig($id_db_settings)['DocModel'] == 4):
        for($i = 1; $i <= $iPus; $i++):
            require("_System4Life/04-system-WoW-invoice-document-new.inc.php");
        endfor;
    endif;
?>
</body>
</html>
<?php

$dompdf->loadHtml(ob_get_clean());
$dompdf->setPaper("A4");

$dompdf->render();
$dompdf->stream("{$file}", ["Attachment" => false]);
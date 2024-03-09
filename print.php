<?php
require_once("_disk/IncludesApp/headerPanel.inc.php");
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

if(isset($_GET['method_id'])):         $method_id         = strip_tags(trim($_GET['method_id'])); endif;
if(isset($_GET['invoice_id'])):        $invoice_id        = strip_tags(trim($_GET['invoice_id'])); endif;

$Reads = new Read();
$Reads->ExeRead("z_config");
if($Reads->getResult()): $Index = $Reads->getResult()[0]; else: $Index = null; endif;
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <?php
        if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false && $action == 1 || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Impression'] == 'A4' && $action == 1 || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Impression'] == '' && $action == 1 || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Impression'] == null && $action == 1):
            if(DBKwanzar::CheckConfig($id_db_settings)['DocModel'] == null || !isset(DBKwanzar::CheckConfig($id_db_settings)['DocModel']) || DBKwanzar::CheckConfig($id_db_settings)['DocModel'] == 1):
                ?>
                <?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Impression'] == 'A4'):?>
                    <link rel="stylesheet" href="css/HeliosPro.css"/>
                <?php elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Impression'] != 'A4'): ?>
                    <link rel="stylesheet" href="./css/POSKwanzar.css"/>
                <?php else: ?>
                    <link rel="stylesheet" href="./css/POSKwanzar.css"/>
                <?php endif; ?>
                <?php
            elseif(DBKwanzar::CheckConfig($id_db_settings)['DocModel'] == 2 || DBKwanzar::CheckConfig($id_db_settings)['DocModel'] == 3 || DBKwanzar::CheckConfig($id_db_settings)['DocModel'] == 4):
                ?>
                <link rel="stylesheet" href="./css/Silvio.css"/>
                <?php
            else:
                ?>
                <?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Impression'] == 'A4'):?>
                    <link rel="stylesheet" href="css/HeliosPro.css"/>
                <?php elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Impression'] != 'A4'): ?>
                    <link rel="stylesheet" href="./css/POSKwanzar.css"/>
                <?php else: ?>
                    <link rel="stylesheet" href="./css/POSKwanzar.css"/>
                <?php endif; ?>
                <?php
            endif;
        else:
            ?>
            <?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Impression'] == 'A4'):?>
                <link rel="stylesheet" href="css/HeliosPro.css"/>
            <?php elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Impression'] != 'A4'): ?>
                <link rel="stylesheet" href="./css/POSKwanzar.css"/>
            <?php else: ?>
                <link rel="stylesheet" href="./css/POSKwanzar.css"/>
            <?php endif; ?>
            <?php
        endif;
    ?>

    <link rel="icon" href="uploads/<?= $Index['icon']; ?>"/>
    <script type="text/javascript">setTimeout("window.close();", 10000);</script>
</head>
<body onload="window.print();">
<?php

if($action):
    if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['NumberOfCopies'] == '' || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['NumberOfCopies'] == null || empty(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['NumberOfCopies']) || !isset(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['NumberOfCopies'])): $iPus = 3; else: $iPus = DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['NumberOfCopies']; endif;
    switch ($action):
        case '01':
            if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Impression'] == 'A4' || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Impression'] == '' || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Impression'] == null):
                if(DBKwanzar::CheckConfig($id_db_settings)['DocModel'] == null || !isset(DBKwanzar::CheckConfig($id_db_settings)['DocModel']) || DBKwanzar::CheckConfig($id_db_settings)['DocModel'] == 1):
                    for($i = 1; $i <= $iPus; $i++):
                        require("_System4Life/01-system-WoW-invoice-document-new.inc.php");
                    endfor;
                elseif(DBKwanzar::CheckConfig($id_db_settings)['DocModel'] == 2):
                    for($i = 1; $i <= $iPus; $i++):
                        require("_System4Life/02-system-WoW-invoice-document-new.inc.php");
                    endfor;
                elseif(DBKwanzar::CheckConfig($id_db_settings)['DocModel'] == 3):
                    for($i = 1; $i <= $iPus; $i++):
                        require("_System4Life/03-system-WoW-invoice-document-new.inc.php");
                    endfor;
                elseif(DBKwanzar::CheckConfig($id_db_settings)['DocModel'] == 4):
                    for($i = 1; $i <= $iPus; $i++):
                        require("_System4Life/04-system-WoW-invoice-document-new.inc.php");
                    endfor;
                endif;
            else:
                for($i = 1; $i <= $iPus; $i++):
                    require("_SystemWoW/01-1-system-WoW-invoice-document.inc.php");
                endfor;
            endif;
            break;
        case '02':
            if($InvoiceType == 'NC' || $InvoiceType == 'RE' || $InvoiceType == 'ND'):
                if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Impression'] == 'A4' || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Impression'] == '' || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Impression'] == null || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Impression'] == 'A4M2'):
                    for($i = 1; $i <= $iPus; $i++):
                        require("_SystemWoW/02-system-WoW-invoice-document.inc.php");
                    endfor;
                endif;
            elseif($InvoiceType == 'RG' || $InvoiceType == 'RC'):
                if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Impression'] == 'A4' || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Impression'] == '' || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Impression'] == null || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Impression'] == 'A4M2'):
                    for($i = 1; $i <= $iPus; $i++):
                        require("_SystemWoW/02.2-system-WoW-invoice-document.inc.php");
                    endfor;
                endif;
            endif;
            break;
        case '12':
            for($i = 1; $i <= $iPus; $i++):
                require("_System4Life/12-system-WoW-invoice-document.inc.php");
            endfor;
            break;
        case '11':
            if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Impression'] == 'A4' || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Impression'] == '' || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Impression'] == null || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Impression'] == 'A4M2'):
                for($i = 1; $i <= $iPus; $i++):
                    require("_SystemWoW/10-system-WoW-invoice-document.inc.php");
                endfor;
            endif;
            break;
        case '03':
            require("_SystemWoW/header-geral-system-WoW-invoice-document.inc.php");
            require("_SystemWoW/03-system-WoW-invoice-document-body.inc.php");
            require("_SystemWoW/footer-outer.inc.php");
            break;
        case '1998':
            require("_SystemWoW/header-geral-system-WoW-invoice-document.inc.php");
            require("AppData/03-system-WoW.inc.php");
            require("_SystemWoW/footer-outer.inc.php");
            break;
        case '2022':
            require("_SystemWoW/header-geral-system-WoW-invoice-document.inc.php");
            require("AppData/04-system-WoW.inc.php");
            require("_SystemWoW/footer-outer.inc.php");
            break;
        case '2021':
            if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Impression'] == 'A4' || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Impression'] == '' || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Impression'] == null):
                require("_SystemWoW/header-geral-system-WoW-invoice-document.inc.php");
                require("AppData/02-system-WoW.inc.php");
                require("_SystemWoW/footer-outer.inc.php");
            else:
                require("AppData/01-1-system-WoW-invoice-document.inc.php");
            endif;
            break;
        case '122021':
            require("_SystemWoW/header-geral-system-WoW-invoice-document.inc.php");
            require("AppData/06-system-WoW.inc.php");
            require("_SystemWoW/footer-outer.inc.php");
            break;
        case '082022':
            require("_SystemWoW/header-geral-system-WoW-invoice-document.inc.php");
            require("AppData/07-system-WoW.inc.php");
            require("_SystemWoW/footer-outer.inc.php");
            break;
        case '04':
            require("_SystemWoW/header-geral-system-WoW-invoice-document.inc.php");
            require("_SystemWoW/04-system-WoW-invoice-document-body.inc.php");
            require("_SystemWoW/footer-outer.inc.php");
            break;
        case '05':
            require("_SystemWoW/header-geral-system-WoW-invoice-document.inc.php");
            require("_SystemWoW/05-system-WoW-invoice-document-body.inc.php");
            require("_SystemWoW/footer-outer.inc.php");
            break;
        case '06':
            require("_SystemWoW/header-geral-system-WoW-invoice-document.inc.php");
            require("_SystemWoW/06-system-WoW-invoice-document-body.inc.php");
            require("_SystemWoW/footer-outer.inc.php");
            break;
        case '07':
            require("_SystemWoW/header-geral-system-WoW-invoice-document.inc.php");
            require("_SystemWoW/07-system-WoW-invoice-document-body.inc.php");
            require("_SystemWoW/footer-outer.inc.php");
            break;
        case '08':
            require("_SystemWoW/header-geral-system-WoW-invoice-document.inc.php");
            require("_SystemWoW/08-system-WoW-invoice-document-body.inc.php");
            require("_SystemWoW/footer-outer.inc.php");
            break;
        case '09':
            require("_SystemWoW/header-geral-system-WoW-invoice-document.inc.php");
            require("_SystemWoW/09-system-WoW-invoice-document-body.inc.php");
            require("_SystemWoW/footer-outer.inc.php");
            break;
        case '10':
            if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Impression'] == 'A4'):
                require("_SystemWoW/header-geral-system-WoW-invoice-document.inc.php");
                require("_SystemWoW/10-system-WoW-invoice-document-body.inc.php");
                require("_SystemWoW/footer-outer.inc.php");
            else:
                ?>
                <div class="boleto" style="width: <?= DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Impression']; ?>mm!important;">
                    <?php
                    require("_SystemWoW/10-system-WoW-invoice-document-body.inc.php");
                    require("_SystemWoW/footer-outer.inc.php");
                    ?>
                </div>
                <?php
            endif;
            break;
        case '15':
            require("_SystemWoW/header-geral-system-WoW-invoice-document.inc.php");
            require("AppData/05-system-WoW.inc.php");
            require("_SystemWoW/footer-outer.inc.php");
            //require("_SystemWoW/04-system-WoW-invoice-document-new.inc.php");
            break;
        case '16':
            for($i = 1; $i <= $iPus; $i++):
                require("_SystemWoW/02-system-WoW-invoice-document-new.inc.php");
            endfor;
            break;
        case '18':
            require("_SystemWoW/header-geral-system-WoW-invoice-document.inc.php");
            require("_SystemWoW/tema-do-documento-balanco-patrimonial.inc.php");
            require("_SystemWoW/18-system-WoW-invoice-document-new.inc.php");
            require("_SystemWoW/footer-outer.inc.php");
            break;
        case '19':
            require("_SystemWoW/header-geral-system-WoW-invoice-document.inc.php");
            require("_SystemWoW/tema-do-documento-operacao-patrimonial.inc.php");
            require("_SystemWoW/19-system-WoW-invoice-document-new.inc.php");
            require("_SystemWoW/footer-outer.inc.php");
            break;
        case '2023':
            require("_System4Life/01-system-WoW-Lista-de-Precos.inc.php");
            break;
        default:
            WSError("Oppsss! Não econtramos o relatório desejado!", WS_ALERT);
    endswitch;
endif;
?>
</body>
</html>
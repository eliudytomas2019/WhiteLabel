<?php
$Number = filter_input(INPUT_GET, "post", FILTER_VALIDATE_INT);
$action = filter_input(INPUT_GET, "action", FILTER_DEFAULT);
$id_db_settings = filter_input(INPUT_GET, "id_db_settings", FILTER_DEFAULT);
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


if(isset($_GET['method_id'])):         $method_id         = strip_tags(trim($_GET['method_id'])); endif;
if(isset($_GET['invoice_id'])):        $invoice_id        = strip_tags(trim($_GET['invoice_id'])); endif;

if(isset($Number) && isset($id_db_settings)):
    $Delete = new Delete();
    $Delete->ExeDelete("sd_billing, sd_billing_pmp", "WHERE sd_billing.id_db_settings=:i AND sd_billing.suspenso=:s AND sd_billing.status=:st AND  sd_billing.numero=:n AND sd_billing_pmp.numero=:n AND sd_billing_pmp.status=:st AND sd_billing_pmp.id_db_settings=:i {$InHead} ORDER BY sd_billing.id DESC", "i={$id_db_settings}&s={$suspenso}&st={$ttt}&n={$Number}{$InBody}");

    if($Delete->getResult()):
        WSError("Factura Apagada com sucesso!", WS_ACCEPT);
    else:
        WSError("Aconteceu um erro inesperado ao apagar a factura!", WS_ERROR);
    endif;
endif;
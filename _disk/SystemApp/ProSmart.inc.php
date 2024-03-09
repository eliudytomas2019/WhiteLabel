<?php
$acao = strip_tags((filter_input(INPUT_POST, 'acao', FILTER_DEFAULT)));
if($acao):
    require_once("../../Config.inc.php");
    if(isset($_POST['id_db_kwanzar'])):  $id_db_kwanzar   = (int) $_POST['id_db_kwanzar']; endif;
    if(isset($_POST['id_db_settings'])): $id_db_settings  = (int) $_POST['id_db_settings']; endif;
    if(isset($_POST['id_user'])):        $userlogin['id'] = (int) $_POST['id_user']; $id_user = (int) $_POST['id_user']; endif;
    if(isset($_POST['level'])):          $level           = (int) $_POST['level']; endif;
    if(isset($_POST['id_product'])): $id_product = (int) $_POST['id_product']; endif;
    if(isset($_POST['id_mesa'])): $id_mesa = (int) $_POST['id_mesa']; endif;
    if(isset($_POST['id_garcom'])): $id_garcom = (int) $_POST['id_garcom']; endif;
    switch ($acao):
        case 'AdsHome':

            $Count = new Websites();
            $Count->AdsHome();

            if(!$Count->getResult()):
                WSError($Count->getError()[0], $Count->getError()[1]);
            endif;

            break;
        case 'AdsMsg':
            $postId = filter_input(INPUT_POST, "postId", FILTER_VALIDATE_FLOAT);

            $Count = new Websites();
            $Count->MsgAds($postId);

            if(!$Count->getResult()):
                WSError($Count->getError()[0], $Count->getError()[1]);
            endif;

            break;
        case 'RelodingPDV':
            require_once("../../_disk/AppFiles/EndFamily.inc.php");
            break;
        case 'FinishPDV':
            if(isset($_POST['pagou'])): $Data['pagou'] = (double) $_POST['pagou']; endif;
            if(isset($_POST['troco'])): $Data['troco'] = (double) $_POST['troco']; endif;

            $POS = new POS();
            $POS->Finish($id_db_settings, $id_user, $Data, $id_db_kwanzar, $id_mesa);

            if(!$POS->getResult()):
                WSError($POS->getError()[0], $POS->getError()[1]);
            else:
                require_once("../../_disk/AppFiles/EndFamily.inc.php");
            endif;

            break;
        case 'DataPDV':
            if(isset($_POST['TaxPointDate'])):         $TaxPointDate         = strip_tags(($_POST['TaxPointDate'])); endif;
            if(isset($_POST['customer'])):             $customer             = strip_tags(($_POST['customer'])); endif;
            if(isset($_POST['InvoiceType'])):          $InvoiceType          = strip_tags(($_POST['InvoiceType'])); endif;
            if(isset($_POST['method'])):               $method               = strip_tags(($_POST['method'])); endif;
            if(isset($_POST['SourceBilling'])):        $SourceBilling        = strip_tags(($_POST['SourceBilling'])); endif;;
            if(isset($_POST['settings_desc_financ'])): $settings_desc_financ = strip_tags(($_POST['settings_desc_financ'])); endif;;

            $Data['method']               = $method;
            $Data['TaxPointDate']         = $TaxPointDate;
            $Data['customer']             = $customer;
            $Data['InvoiceType']          = $InvoiceType;
            $Data['SourceBilling']        = $SourceBilling;
            $Data['settings_desc_financ'] = $settings_desc_financ;

            $POS = new POS();
            $POS->Fact($Data, $id_db_settings, $id_user, $id_mesa, $id_garcom);

            if(!$POS->getResult()):
                WSError($POS->getError()[0], $POS->getError()[1]);
            else:
                require_once("../../_disk/AppFiles/EndFamily.inc.php");
            endif;

            break;
        case 'loadingPDV':
            require_once("../../_disk/AppFiles/PDV.inc.php");
            break;
        case 'matrix':
            $value = (int) $_POST['value'];
            $id    = (int) $_POST['id'];

            $PDV = new POS();
            $PDV->Qtds($id_db_settings, $id_user, $id, $value);
            if($PDV->getResult()):
                require_once("../../_disk/AppFiles/PDV.inc.php");
            else:
                WSError($PDV->getError()[0], $PDV->getError()[1]);
            endif;
            break;
        case 'RemovePDV':
            $id_product = strip_tags(($_POST['id_product']));
            $POS = new POS();
            $POS->RemovePS($id_product, $id_db_settings, $id_user);
            if($POS->getResult()):
                require_once("../../_disk/AppFiles/PDV.inc.php");
            else:
                WSError($POS->getError()[0], $POS->getError()[1]);
            endif;

            break;
        case 'AdicionarPDV':
            $POS = new POS();
            $POS->ProcessPDV($id_db_settings, $id_user, $id_product, $id_mesa);
            if($POS->getResult()):
                require_once("../../_disk/AppFiles/PDV.inc.php");
            else:
                WSError($POS->getError()[0], $POS->getError()[1]);
            endif;
            break;
        case 'SearchProduct':
            $searching = strip_tags(($_POST['searching']));
            $read = new Read();
            $read->ExeRead("cv_product", "WHERE (id_db_settings=:i AND product LIKE '%' :link '%') OR (id_db_settings=:i AND codigo LIKE '%' :link '%') OR (id_db_settings=:i AND codigo_barras LIKE '%' :link '%') ", "i={$id_db_settings}&link={$searching}");
            require_once("../../_disk/AppFiles/ReadPDV.inc.php");
            break;
        case 'ReadPDV':
            $read = new Read();
            $read->ExeRead("cv_product", "WHERE id_db_settings=:i ORDER BY product ASC LIMIT 20", "i={$id_db_settings}");
            require_once("_disk/AppFiles/ReadPDV.inc.php");

            break;
        case 'testimony':
            $testemunho = strip_tags(trim($_POST["testemunho"]));
            $ProSmart = new ProSmart();

            $ProSmart->Testimony($id_user, $testemunho);
            WSError($ProSmart->getError()[0], $ProSmart->getError()[1]);

            break;
        default:
            WSError("Ops: não encontramos a ação desejada!", WS_INFOR);
    endswitch;
endif;
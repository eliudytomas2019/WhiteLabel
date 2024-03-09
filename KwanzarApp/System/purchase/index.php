<?php
/**
 * Created by PhpStorm.
 * User: Kwanzar Soft
 * Date: 14/06/2020
 * Time: 19:37
 */

if(!class_exists('login')):
    header("index.php");
    die();
endif;

if($level >= 4): $n =  '&id_db_settings='.$id_db_settings; else: $n = null; endif;

if($userlogin['level'] < 2):
    header("location: panel.php?exe=default/index".$n);
endif;

include_once("_includes/my-modal-purchase-sd-settings.inc.php");
?>
<div class="container-fluid">
    <div class="styles">
        <a href="javascript:void" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#PurchaseInInvoice">
            NOVA ENTRADA DE ESTOQUE
        </a>&nbsp;
    </div>


    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body" id="BillieJean">
                    <?php require_once("KwanzarApp/SystemFiles/search-purchase-settings.inc.php") ?>
                </div>
            </div>
        </div>
    </div>
</div>

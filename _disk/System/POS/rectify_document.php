<?php
    $Number = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
    $SourceBilling = filter_input(INPUT_GET, "SourceBilling", FILTER_DEFAULT);
    $InvoiceType = filter_input(INPUT_GET, "InvoiceType", FILTER_DEFAULT);
    $Commic = filter_input(INPUT_GET, "InvoiceType", FILTER_DEFAULT);
?>
<input type="hidden" id="id_invoice" name="id_invoice" value="<?= $Number; ?>"/>
<div class="page-header d-print-none">
    <div class="row align-items-center">
        <div class="col">
            <div class="page-pretitle">
                <?= $Index['name']; ?>
            </div>
            <h2 class="page-title">
                POS
            </h2>
        </div>
        <div class="col-auto ms-auto d-print-none">
            <div class="btn-list">
               <?php include_once("btnBreak.inc.php"); ?>
                <a href="javascript:void" class="btn btn-primary d-none d-sm-inline-block" data-bs-toggle="modal" data-bs-target="#ModalsCarregarDocumentos">
                    Documentos
                </a>
            </div>
        </div>
    </div>
</div>
<div class="row row-cards">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5 class="modal-title">Retificação de documento</h5>
            </div>
            <div class="card-body">
                <div id="getAlert"></div>
                <div id="Rap">
                    <?php include_once("_disk/Helps/retification-settings.inc.php"); ?>
                </div>
            </div>
        </div>
    </div>
</div>
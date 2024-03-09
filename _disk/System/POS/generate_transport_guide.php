<?php
    $Number = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
    $SourceBilling = filter_input(INPUT_GET, "SourceBilling", FILTER_DEFAULT);
    $InvoiceType = filter_input(INPUT_GET, "InvoiceType", FILTER_DEFAULT);
    $Commic = filter_input(INPUT_GET, "InvoiceType", FILTER_DEFAULT);
?>
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
                <a href="panel.php?exe=POS/invoice<?= $n; ?>" class="btn btn-default d-none d-sm-inline-block">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 13l-4 -4l4 -4m-4 4h11a4 4 0 0 1 0 8h-1" /></svg>
                    Voltar
                </a>
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
                <h5 class="modal-title">Guia do Transporte</h5>
            </div>
            <div class="card-body" id="Rap">
                <?php include_once("_disk/Helps/guid--settings.inc.php"); ?>
            </div>
        </div>
    </div>
</div>
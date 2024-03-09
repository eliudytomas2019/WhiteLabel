<?php
require_once("_disk/IncludesApp/PatientUsers.inc.php");
include_once("_disk/IncludesApp/ModalsCarregarProdutos.inc.php");
?>
<br/><div class="row gx-lg-4">
    <?php require_once("_disk/IncludesApp/MenuPatient.inc.php"); ?>
    <div class="col-lg-9">
        <?php if($Beautiful["documentos"] > $Beautiful['documentos_feito']): ?>
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <div class="page-pretitle">
                        <?= $Index['name']; ?>
                    </div>
                    <h2 class="page-title">
                        Orçamento
                    </h2>
                </div>
                <div class="col-auto ms-auto">
                    <div class="btn-list">
                        <a href="javascript:void" class="btn btn-default" data-bs-toggle="modal" data-bs-target="#ModalsCarregarProdutos">
                            <i class="fas fa-shopping-cart"></i> <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg> Adicionar Itens
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
        <br/><div class="card">
            <div class="card-header">
                <h5 class="modal-title">Orçamento</h5>
            </div>
            <div class="card-body">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body" id="RealNigga">
                            <?php
                            require_once("_disk/Helps/table-product-pos-settings.inc.php"); ?>
                        </div>
                    </div>
                </div>
                <br/><div class="col-lg-12">
                    <div class="card">
                        <div class="card-body" id="sd_billing">
                            <?php if($Beautiful["documentos"] > $Beautiful['documentos_feito']): ?>
                                <?php require_once("_disk/Helps/right-pos-settings.inc.php"); ?>
                            <?php else: ?>
                                <label class="form-label col-form-label">Documentos: <p><?= $Beautiful['documentos_feito']." / ".$Beautiful['documentos']; ?></p></label>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
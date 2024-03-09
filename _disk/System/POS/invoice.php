<?php
$Read = new Read();
$Read->ExeRead("db_config", "WHERE id_db_settings=:i ", "i={$id_db_settings}");
if(!$Read->getResult() || !$Read->getRowCount()):
    header("Location: panel.php?exe=settings/System_Settings{$n}");
endif;
?>
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <div class="page-pretitle">
                <?= $Index['name']; ?>
            </div>
            <h2 class="page-title">
                Facturas
            </h2>
        </div>
        <div class="col-auto ms-auto">
            <div class="btn-list">
                <?php
                    require("AnaJulia.php");
                ?>

                <a href="#" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modal">
                    <!-- Download SVG icon from http://tabler-icons.io/i/color-swatch -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M19 3h-4a2 2 0 0 0 -2 2v12a4 4 0 0 0 8 0v-12a2 2 0 0 0 -2 -2" /><path d="M13 7.35l-2 -2a2 2 0 0 0 -2.828 0l-2.828 2.828a2 2 0 0 0 0 2.828l9 9" /><path d="M7.3 13h-2.3a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h12" /><line x1="17" y1="17" x2="17" y2="17.01" /></svg>
                    Novo Cliente
                </a>

                <a class="btn btn-primary btn-sm" <?php $Read->ExeRead("db_users_settings", "WHERE id_db_settings=:i ", "i={$id_db_settings}"); if(!$Read->getResult() || !$Read->getRowCount()): ?> href="panel.php?exe=settings/account_configurations<?= $n; ?>" <?php else:?> href="javascript:void" data-bs-toggle="modal" data-bs-target="#ModalsCarregarDocumentos" <?php endif; ?>>
                    <!-- Download SVG icon from http://tabler-icons.io/i/download -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" /><polyline points="7 11 12 16 17 11" /><line x1="12" y1="4" x2="12" y2="16" /></svg>
                    Imprimir
                </a>

                <?php if($Beautiful["documentos"] > $Beautiful['documentos_feito']): ?>
                    <a href="javascript:void" class="btn btn-default btn-sm" data-bs-toggle="modal" data-bs-target="#ModalsCarregarProdutos">
                        <i class="fas fa-shopping-cart"></i> <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg> Adicionar Itens
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<div class="row row-cards">
    <?php
        include_once("_disk/IncludesApp/ModalsCarregarProdutos.inc.php"); ?>
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="modal-title">Emissão de documentos comercial</h5>
            </div>
            <div class="card-body" id="RealNigga">
                <div id="OnCheckBox"></div>
                <div id="AnaJulia"></div>
                <?php
                    require_once("_disk/Helps/table-product-pos-settings.inc.php"); ?>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5 class="modal-title">Dados da factura</h5>
            </div>
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
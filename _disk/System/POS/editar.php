<?php
$Read = new Read();
$Read->ExeRead("db_config", "WHERE id_db_settings=:i ", "i={$id_db_settings}");
if(!$Read->getResult() || !$Read->getRowCount()):
    header("Location: panel.php?exe=settings/System_Settings{$n}");
endif;

if(!empty($_POST['Number'])):    $Number     = strip_tags(trim($_POST['Number'])); endif;
if(!empty($_GET['post'])):    $Number = filter_input(INPUT_GET, "post", FILTER_VALIDATE_INT); endif;
if(DBKwanzar::CheckConfig($id_db_settings)['JanuarioSakalumbu'] == null): $ttt = 2; else: $ttt = DBKwanzar::CheckConfig($id_db_settings)['JanuarioSakalumbu']; endif;

$read = new Read();
$read->ExeRead("sd_billing", "WHERE sd_billing.numero=:n AND sd_billing.status=:st AND sd_billing.id_db_settings=:i ", "i={$id_db_settings}&st={$ttt}&n={$Number}");

if($read->getResult()):
    $key = $read->getResult()[0];
else:
    $key['TaxPointDate'] = null;
endif;
?>
<div class="page-header d-print-none">
    <div class="row align-items-center">
        <div class="col">
            <div class="page-pretitle">
                <?= $Index['name']; ?>
            </div>
            <h2 class="page-title">
                Proformas
            </h2>
        </div>
        <div class="col-auto ms-auto">
            <div class="btn-list">
                <a class="btn btn-primary btn-sm" <?php $Read->ExeRead("db_users_settings", "WHERE id_db_settings=:i ", "i={$id_db_settings}"); if(!$Read->getResult() || !$Read->getRowCount()): ?> href="panel.php?exe=settings/account_configurations<?= $n; ?>" <?php else:?> href="javascript:void" data-bs-toggle="modal" data-bs-target="#ModalsCarregarDocumentos" <?php endif; ?>>
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" /><polyline points="7 11 12 16 17 11" /><line x1="12" y1="4" x2="12" y2="16" /></svg>
                    Imprimir
                </a>

                <?php if($Beautiful["documentos"] > $Beautiful['documentos_feito']): ?>
                    <a href="javascript:void" class="btn btn-default btn-sm" data-bs-toggle="modal" data-bs-target="#ModalsCarregarProdutos">
                        <i class="fas fa-shopping-cart"></i> <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg> Adicionar Itens
                    </a>
                <?php endif; ?>
            </div>


            <div class="btn-list">
                <span>Data do Documento</span>
                <input type="date" onchange="TaxPointDate(<?= $key['id']; ?>, <?= $Number; ?>)" class="form-control" value="<?= $key['TaxPointDate']; ?>" id="TaxPointDate" name="TaxPointDate"/>
            </div>
        </div>
    </div>
</div>
<div class="row row-cards">
    <?php
    include_once("_disk/IncludesApp/ModalsCarregarProdutos-proforma-edit.inc.php"); ?>
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5 class="modal-title">Editar a proforma</h5>
            </div>
            <div class="card-body" id="RealNigga">
                <div id="DepoisDaTorne"></div>
                <?php
                require_once("_disk/Helps/table-product-pos-settings-proforma-edit.inc.php"); ?>
            </div>
        </div>
    </div>
</div>
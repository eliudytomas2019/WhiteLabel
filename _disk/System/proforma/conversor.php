<?php
$Read = new Read();
$Read->ExeRead("db_config", "WHERE id_db_settings=:i ", "i={$id_db_settings}");
if(!$Read->getResult() || !$Read->getRowCount()):
    header("Location: panel.php?exe=settings/System_Settings{$n}");
endif;

$postId = filter_input(INPUT_GET, "postId", FILTER_VALIDATE_INT);
$xCustomerId = null;
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
            </div>
        </div>
    </div>
</div>
<div class="row row-cards center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="modal-title">Converter Proforma em Factura</h5>
            </div>
            <div class="card-body" id="RealNigga">
                <?php
                    require_once("_disk/Helps/table-product-pos-settings-proforma-edit-ii.inc.php");
                ?>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Converter Proforma em Factura</h3>
            </div>
            <div class="card-body">
                <form>
                    <div id="Figma"></div>
                    <div class="col-lg-12">
                        <div class="mb-3">
                            <label class="form-label">Cliente</label>
                            <select id="customer" class="form-control">
                                <?php
                                $read = new Read();
                                $read->ExeRead("cv_customer", "WHERE id_db_settings=:i ORDER BY id ASC", "i={$id_db_settings}");
                                if($read->getResult()):
                                    foreach ($read->getResult() as $Supplier):
                                        ?>
                                        <option value="<?= $Supplier['id']; ?>" <?php if(isset($xCustomerId) && $xCustomerId == $Supplier['id']) echo 'selected="selected"'; ?>><?= $Supplier['nome']; ?></option>
                                    <?php
                                    endforeach;
                                else:
                                    WSError("Oppsss! Não encontramos nenhum Cliente, cadastre um para prosseguir!", WS_ALERT);
                                endif;
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group mb-3 ">
                        <div class="mb-3">
                            <label class="form-label">Documento</label>
                            <select class="form-control" name="InvoiceType" id="InvoiceType">
                                <option value="FR">FACTURA/RECIBO</option>
                                <option value="FT">FACTURA</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="mb-3">
                            <label class="form-label">Pagamento</label>
                            <select class="form-control" id="method" onchange="AtualizarMethod()">
                                <option value="CD" <?php if(isset($DataSupplier['method']) && $DataSupplier['method'] == "CD"): echo 'selected="selected"'; elseif(DBKwanzar::CheckConfig($id_db_settings)['MethodDefault'] == null || isset(DBKwanzar::CheckConfig($id_db_settings)['MethodDefault']) && DBKwanzar::CheckConfig($id_db_settings)['MethodDefault'] == 2): echo "selected"; endif; ?>>Cartão de Debito</option>
                                <option value="NU" <?php if(isset($DataSupplier['method']) && $DataSupplier['method'] == "NU"): echo 'selected="selected"'; elseif(DBKwanzar::CheckConfig($id_db_settings)['MethodDefault'] == null || isset(DBKwanzar::CheckConfig($id_db_settings)['MethodDefault']) && DBKwanzar::CheckConfig($id_db_settings)['MethodDefault'] == 1): echo "selected"; endif; ?>>Numerário</option>
                                <option value="TB" <?php if(isset($DataSupplier['method']) && $DataSupplier['method'] == "TB") echo 'selected="selected"'; ?>>Transferência Bancária</option>
                                <option value="MB" <?php if(isset($DataSupplier['method']) && $DataSupplier['method'] == "MB") echo 'selected="selected"'; ?>>Referência de pagamentos para Multicaixa</option>
                                <option value="OU" <?php if(isset($DataSupplier['method']) && $DataSupplier['method'] == "OU") echo 'selected="selected"'; ?>>Outros Meios Aqui não Assinalados</option>
                                <option value="ALL" <?php if(isset($DataSupplier['method']) && $DataSupplier['method'] == "ALL") echo 'selected="selected"'; ?>>-------------------- Diversificado --------------------</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="mb-3" id="Champanhe">
                            <input type="hidden" id="pagou" value="0">
                            <input type="hidden" id="troco" value="0">

                            <input type="hidden" id="cartao_de_debito" value="0">
                            <input type="hidden" id="numerario" value="0">
                            <input type="hidden" id="transferencia" value="0">
                            <input type="hidden" id="all_total" value="0">
                        </div>
                    </div>
                    <div class="form-footer">
                        <a href="javascript:void()" onclick="Figma(<?= $postId; ?>);" class="btn btn-primary">Salvar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
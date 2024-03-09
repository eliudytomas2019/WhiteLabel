<?php
$stp = 1;

$ReadLn = new Read();
$ReadLn->ExeRead("sd_billing", "WHERE id_db_settings=:i AND session_id=:ip AND page_found=:ppY AND status=:stp", "i={$id_db_settings}&ip={$id_user}&ppY={$page_found}&stp={$stp}");

$DataSupplier = filter_input(INPUT_POST, FILTER_DEFAULT);

if($ReadLn->getResult()):
    $DataSupplier = $ReadLn->getResult()[0];
endif;
?>
<div class="col-lg-12">
    <input type="hidden" id="TaxPointDate" value="<?= date('Y-m-d'); ?>" class="form-kwanzar">
    <div class="col-lg-12">
        <div class="mb-3">
            <label class="form-label">Cliente</label>
            <select id="customer" onclick="SelectVeiculoII()" onselect="SelectVeiculoII()" onchange="SelectVeiculoII()" class="form-control">
                <?php
                    $read = new Read();
                    $read->ExeRead("cv_customer", "WHERE id_db_settings=:i ORDER BY id ASC", "i={$id_db_settings}");
                    if($read->getResult()):
                        foreach ($read->getResult() as $Supplier):
                            extract($Supplier);
                            ?>
                            <option value="<?= $Supplier['id']; ?>" <?php if(isset($DataSupplier['id_customer']) && $DataSupplier['id_customer'] == $Supplier['id']) echo 'selected="selected"'; ?>><?= $Supplier['nome']; ?></option>
                        <?php
                        endforeach;
                    else:
                        WSError("Oppsss! Não encontramos nenhum Cliente, cadastre um para prosseguir!", WS_ALERT);
                    endif;
                ?>
            </select>
        </div>
    </div>
    <?php if(DBKwanzar::CheckConfig($id_db_settings)['DocModel'] == 4): ?>
        <div class="col-lg-12">
            <div class="mb-3">
                <label class="form-label">Observações</label>
                <select id="id_obs" name="id_obs" class="form-control">
                    <?php
                    $read = new Read();
                    $read->ExeRead("cv_obs", "WHERE id_db_settings=:i ORDER BY id DESC", "i={$id_db_settings}");
                    if($read->getResult()):
                        foreach ($read->getResult() as $Supplier):
                            extract($Supplier);
                            ?>
                            <option value="<?= $Supplier['nome']; ?>" <?php if(isset($DataSupplier['id_obs']) && $DataSupplier['id_obs'] == $Supplier['nome']) echo 'selected="selected"'; ?>><?= $Supplier['nome']; ?></option>
                        <?php
                        endforeach;
                    else:
                        WSError("Oppsss! Não encontramos nenhuma observação, cadastre um para prosseguir!", WS_ALERT);
                    endif;
                    ?>
                </select>
            </div>
        </div>
    <?php else: ?>
        <input type="hidden" name="id_obs" id="id_obs" value="" class="form-control"/>
    <?php endif; ?>
    <?php if($DB->CheckCpanelAndSettings($id_db_settings, $id_db_kwanzar)['atividade'] == 4): ?>
        <div class="col-lg-12">
            <div class="mb-3">
                <label class="form-label">Marca</label>
                <input type="text" disabled class="form-control" value="<?php if(isset($DataSupplier['id_fabricante'])): echo $DataSupplier['id_fabricante']; endif; ?>" style="text-align: left!important;" id="id_fabricante">
            </div>
            <div class="mb-3">
                <label class="form-label">Modelo</label>
                <select class="form-control" id="id_veiculos" onclick="SelectPlacaII()" onselect="SelectPlacaII()" onchange="SelectPlacaII()">
                    <?php if(isset($DataSupplier['id_veiculos'])): ?>
                        <option value="<?= $DataSupplier['id_veiculos']; ?>" value="FR" <?php if(isset($DataSupplier['id_veiculos']) && $DataSupplier['id_veiculos'] == "{$DataSupplier['id_veiculos']}") echo 'selected="selected"'; ?>><?= $DataSupplier['id_veiculos'] ?></option>
                    <?php endif; ?>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Matricula</label>
                <input type="text" disabled class="form-control" value="<?php if(isset($DataSupplier['matriculas'])): echo $DataSupplier['matriculas']; endif; ?>" style="text-align: left!important;" id="matriculas">
            </div>
        </div>
    <?php else: ?>
        <input type="hidden" name="id_fabricante" id="id_fabricante"/>
        <input type="hidden" name="id_veiculos" id="id_veiculos"/>
        <input type="hidden" name="matriculas" id="matriculas"/>
    <?php endif; ?>
    <div class="col-lg-12">
        <div class="mb-3">
            <label class="form-label">Documento</label>
            <select class="form-control" id="InvoiceType">
                <option value="PP" <?php if(isset($DataSupplier['InvoiceType']) && $DataSupplier['InvoiceType'] == "PP") echo 'selected="selected"'; ?>>PROFORMA</option>
            </select>
        </div>
    </div>
    <select class="form-control" id="SourceBilling" style="display: none!important;">
        <option value="P" <?php if(isset($DataSupplier['SourceBilling']) && $DataSupplier['SourceBilling'] == "P") echo 'selected="selected"'; ?>>Documento produzido na aplicação;</option>
        <?php if($level >= 3): ?>
            <option value="M" <?php if(isset($DataSupplier['SourceBilling']) && $DataSupplier['SourceBilling'] == "M") echo 'selected="selected"'; ?>>Documento proveniente de Recuperação ou de emissão manual;</option>
        <?php endif; ?>
    </select>
    <div class="col-lg-12" hidden>
        <div class="mb-3" hidden>
            <label hidden class="form-label">Pagamento</label>
            <select hidden class="form-control" id="method">
                <option value="CD" <?php if(isset($DataSupplier['method']) && $DataSupplier['method'] == "CD"): echo 'selected="selected"'; elseif(DBKwanzar::CheckConfig($id_db_settings)['MethodDefault'] == null || isset(DBKwanzar::CheckConfig($id_db_settings)['MethodDefault']) && DBKwanzar::CheckConfig($id_db_settings)['MethodDefault'] == 2): echo "selected"; endif; ?>>Cartão de Debito</option>
                <option value="NU" <?php if(isset($DataSupplier['method']) && $DataSupplier['method'] == "NU"): echo 'selected="selected"'; elseif(DBKwanzar::CheckConfig($id_db_settings)['MethodDefault'] == null || isset(DBKwanzar::CheckConfig($id_db_settings)['MethodDefault']) && DBKwanzar::CheckConfig($id_db_settings)['MethodDefault'] == 1): echo "selected"; endif; ?>>Numerário</option>
                <option value="TB" <?php if(isset($DataSupplier['method']) && $DataSupplier['method'] == "TB") echo 'selected="selected"'; ?>>Transferência Bancária</option>
                <option value="MB" <?php if(isset($DataSupplier['method']) && $DataSupplier['method'] == "MB") echo 'selected="selected"'; ?>>Referência de pagamentos para Multicaixa</option>
                <option value="OU" <?php if(isset($DataSupplier['method']) && $DataSupplier['method'] == "OU") echo 'selected="selected"'; ?>>Outros Meios Aqui não Assinalados</option>
            </select>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="mb-3" hidden>
            <label class="form-label" hidden>Desconto Financeiro</label>
            <input hidden type="number" min="0" max="100" <?php if($level < 3): ?>disabled<?php endif; ?> id="settings_desc_financ" value="<?php if(isset($DataSupplier['settings_desc_financ'])): echo $DataSupplier['settings_desc_financ']; else: echo "0"; endif; ?>" placeholder="0" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Referência</label>
            <input type="text" id="referencia" name="referencia" value="<?php if(isset($DataSupplier['referencia'])): echo $DataSupplier['referencia']; else: echo "0"; endif; ?>" placeholder="Referência" class="form-control">
        </div>

        <div class="mb-3"><a href="javascript:void()" onclick="DadosDaFactura01()" class="btn btn-default w-100"><!-- Download SVG icon from http://tabler-icons.io/i/cloud-storm -->
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 18a4.6 4.4 0 0 1 0 -9a5 4.5 0 0 1 11 2h1a3.5 3.5 0 0 1 0 7h-1" /><polyline points="13 14 11 18 14 18 12 22" /></svg>Processar</a></div>

        <i class="col-line"></i>
        <hr/>
        <?php
        $suspenso = 0;
        $status = 1;

        $read = new Read();
        $read->ExeRead("sd_billing", "WHERE id_db_settings=:i AND session_id=:ses AND page_found=:ppY AND suspenso=:s AND status=:st", "i={$id_db_settings}&ses={$id_user}&ppY={$page_found}&s={$suspenso}&st={$status}");

        if($read->getResult()):
            if($read->getResult()[0]['method'] == 'NU' && $read->getResult()[0]['InvoiceType'] != 'PP'):
                    ?>
                <i class="col-line"></i>
                <div class="col-lg-12">
                    <div class="mb-3">
                        <label class="form-label">Pagou</label>
                        <input type="text" id="pagou" class="form-control calc" placeholder="Pagou">
                    </div>
                    <div class="mb-3" id="RapCosciente">

                    </div>
                <?php
            else:
                ?>
                <input type="hidden" id="pagou" value="0">
                <input type="hidden" id="troco" value="0">
                <?php
            endif;
                    ?>

                    <div class="mb-3">
                        <!---a href="javascript:void" class="btn btn-warning" onclick="AnularVenda()">Suspender a venda</a--->
                        <a href="javascript:void" class="btn btn-primary w-100" onclick="FinalizarProforma()"><!-- Download SVG icon from http://tabler-icons.io/i/location -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M21 3l-6.5 18a0.55 .55 0 0 1 -1 0l-3.5 -7l-7 -3.5a0.55 .55 0 0 1 0 -1l18 -6.5" /></svg>Finalizar Proforma</a>
                    </div>
                </div>
            </div>
            <?php
        endif;
    ?>
</div>
<select class="form-control" id="SourceBilling" style="display: none!important;">
    <option value="P" <?php if(isset($DataSupplier['SourceBilling']) && $DataSupplier['SourceBilling'] == "P") echo 'selected="selected"'; ?>>Documento produzido na aplicação;</option>
    <?php if($level >= 3): ?>
        <option value="M" <?php if(isset($DataSupplier['SourceBilling']) && $DataSupplier['SourceBilling'] == "M") echo 'selected="selected"'; ?>>Documento proveniente de Recuperação ou de emissão manual;</option>
    <?php endif; ?>
</select>
<div class="col-lg-12">
    <div class="mb-3">
        <label class="form-label">Desconto Financeiro</label>
        <input type="text" min="0" max="100" <?php if($level < 3): ?>disabled<?php endif; ?> id="settings_desc_financ" value="<?php if(isset($DataSupplier['settings_desc_financ'])): echo $DataSupplier['settings_desc_financ']; else: echo "0"; endif; ?>" placeholder="0" class="form-control">
    </div>
</div>
<select class="form-control" id="SourceBilling" style="display: none!important;">
    <option value="P" <?php if(isset($DataSupplier['SourceBilling']) && $DataSupplier['SourceBilling'] == "P") echo 'selected="selected"'; ?>>Documento produzido na aplicação;</option>
    <?php if($level >= 3): ?>
        <option value="M" <?php if(isset($DataSupplier['SourceBilling']) && $DataSupplier['SourceBilling'] == "M") echo 'selected="selected"'; ?>>Documento proveniente de Recuperação ou de emissão manual;</option>
    <?php endif; ?>
</select>
<input type="hidden" id="TaxPointDate" value="<?= date('Y-m-d'); ?>" class="form-kwanzar">
<div class="col-lg-12">
    <div class="mb-3">
        <label class="form-label">Cliente</label>
        <select id="customer" class="form-control">
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
<div class="col-lg-12">
    <div class="mb-3">
        <label class="form-label">Tipo de documento</label>
        <select class="form-control" id="InvoiceType">
            <option value="FR" <?php if(isset($DataSupplier['InvoiceType']) && $DataSupplier['InvoiceType'] == "FR") echo 'selected="selected"'; ?>>FACTURA/RECIBO</option>
            <option value="FT" <?php if(isset($DataSupplier['InvoiceType']) && $DataSupplier['InvoiceType'] == "FT") echo 'selected="selected"'; ?>>FACTURA</option>
        </select>
    </div>
</div>
<div class="col-lg-12">
    <div class="mb-3">
        <label class="form-label">Metodo de pagamento</label>
        <select class="form-control" id="method">
            <option value="CD" <?php if(isset($DataSupplier['method']) && $DataSupplier['method'] == "CD"): echo 'selected="selected"'; elseif(DBKwanzar::CheckConfig($id_db_settings)['MethodDefault'] == null || isset(DBKwanzar::CheckConfig($id_db_settings)['MethodDefault']) && DBKwanzar::CheckConfig($id_db_settings)['MethodDefault'] == 2): echo "selected"; endif; ?>>Cartão de Debito</option>
            <option value="NU" <?php if(isset($DataSupplier['method']) && $DataSupplier['method'] == "NU"): echo 'selected="selected"'; elseif(DBKwanzar::CheckConfig($id_db_settings)['MethodDefault'] == null || isset(DBKwanzar::CheckConfig($id_db_settings)['MethodDefault']) && DBKwanzar::CheckConfig($id_db_settings)['MethodDefault'] == 1): echo "selected"; endif; ?>>Numerário</option>
        </select>
    </div>
</div>
<div class="col-lg-12">
    <div class="row">
        <div class="col-6">
            <label class="form-label">Operador</label>
            <select class="form-control" id="id_garcom" name="id_garcom">
                <?php
                $Read = new Read();
                $Read->ExeRead("cv_garcom", "WHERE id_db_settings=:i", "i={$id_db_settings}");
                if($Read->getResult()):
                    foreach ($Read->getResult() as $item):
                        ?>
                        <option value="<?= $item["id"]; ?>"><?= $item["name"]; ?></option>
                    <?php
                    endforeach;
                endif;
                ?>
            </select>
        </div>
        <div class="col-6">
            <label class="form-label">Local</label>
            <select class="form-control" id="id_mesa" name="id_mesa" onchange="loadingPDV(<?= $id_user; ?>)">
                <?php
                $Read = new Read();
                $Read->ExeRead("cv_mesas", "WHERE id_db_settings=:i", "i={$id_db_settings}");
                if($Read->getResult()):
                    foreach ($Read->getResult() as $item):
                        ?>
                        <option value="<?= $item["id"]; ?>" onclick="loadingPDV(<?= $id_user; ?>)"><?= $item["name"]; ?></option>
                    <?php
                    endforeach;
                endif;
                ?>
            </select>
        </div>
    </div>
</div><br/>
<div class="col-lg-12" hidden>
    <div class="mb-3">
        <label>Pesquisar...</label>
        <input type="text"  class="form-control" placeholder="Pesquisar itens...">
    </div>
</div>
<?php

$s = 0;
$iddInvoice = null;

$read = new Read();
$read->ExeRead("sd_billing", "WHERE id=:i AND id_db_settings=:sp", "i={$Number}&sp={$id_db_settings}");
if($read->getResult()):
    $dating = $read->getResult()[0];

    $n1 = "sd_billing";
    $n3 = "sd_billing_pmp";
    $n2 = "sd_retification";
    $n4 = "sd_retification_pmp";

    $Cochi = $dating['InvoiceType']." ".$dating['mes'].$dating['Code'].$dating['ano']."/".$dating['numero'];

    $t_v = 0;
    $t_g = 0;

    $read->ExeRead("{$n3}", "WHERE id_db_settings=:i AND numero=:nn AND InvoiceType=:ip", "i={$id_db_settings}&nn={$dating['numero']}&ip={$dating['InvoiceType']}");
    if($read->getResult()):
        foreach($read->getResult() as $ky):
            $value = $ky['quantidade_pmp'] * $ky['preco_pmp'];

            if($ky['desconto_pmp'] >= 100):
                $desconto = $ky['desconto_pmp'];
            else:
                $desconto = ($value * $ky['desconto_pmp']) / 100;
            endif;

            //$desconto = ($value * $ky['desconto_pmp']) / 100;
            $imposto  = ($value * $ky['taxa']) / 100;

            $t_v += ($value - $desconto) + $imposto;
        endforeach;
    endif;

    $read->ExeRead("{$n4}", "WHERE id_db_settings=:i AND id_invoice=:nn", "i={$id_db_settings}&nn={$Number}");
    if($read->getResult()):
        foreach($read->getResult() as $ey):

            $value = $ey['quantidade_pmp'] * $ey['preco_pmp'];
            if($ey['desconto_pmp'] >= 100):
                $desconto = $ey['desconto_pmp'];
            else:
                $desconto = ($value * $ey['desconto_pmp']) / 100;
            endif;
            //$desconto = ($value * $ey['desconto_pmp']) / 100;
            $imposto  = ($value * $ey['taxa']) / 100;

            $t_g += ($value - $desconto) + $imposto;
        endforeach;
    endif;

    if($t_g >= $t_v):
        if($level >= 4): $df =  '&id_db_settings='.$id_db_settings; else: $df = null; endif;
        header("location: panel.php?exe=POS/invoice".$df);
        die();
    endif;
else:
    header("index.php");
    die();
endif;
?>

<div class="col-md-12">
    <div class="row">
        <div class="col-lg-3">
            <div class="mb-3">
                <label class="form-label">Data de disponibilização</label>
                <input type="date" id="TaxPointDate" value="<?= date('Y-m-d'); ?>" class="form-control">
            </div>
        </div>
        <div class="col-lg-2">
            <div class="mb-3">
                <label class="form-label">Documento</label>
                <select class="form-control" id="InvoiceType" name="InvoiceType">
                    <?php
                    $Nike = null;
                    $read->ExeRead("sd_retification", "WHERE id_db_settings=:sp AND id_invoice=:i", "sp={$id_db_settings}&i={$Number}");
                    if($read->getResult()):
                        $ClienteData = $read->getResult()[0];
                        $f    = $read->getResult()[0];
                        $Nike = $read->getResult()[0];

                        ?>
                        <option value="NC" <?php if (isset($ClienteData['InvoiceType']) && $ClienteData['InvoiceType'] == "NC") echo 'selected="selected"'; ?>>NOTA DE CREDITO</option>
                        <option value="RG" <?php if (isset($ClienteData['InvoiceType']) && $ClienteData['InvoiceType'] == "RG") echo 'selected="selected"'; ?>>RECIBO</option>
                        <?php
                    else:
                        $Nike = $dating['InvoiceType'];
                        if($dating['InvoiceType'] == 'FR'):
                            ?>
                            <option value="NC" <?php if (isset($ClienteData['InvoiceType']) && $ClienteData['InvoiceType'] == "NC") echo 'selected="selected"'; ?>>NOTA DE CREDITO</option>
                        <?php
                        elseif($dating['InvoiceType'] == 'FT'):
                            ?>
                            <option value="NC" <?php if (isset($ClienteData['InvoiceType']) && $ClienteData['InvoiceType'] == "NC") echo 'selected="selected"'; ?>>NOTA DE CREDITO</option>
                            <option value="RG" <?php if (isset($ClienteData['InvoiceType']) && $ClienteData['InvoiceType'] == "RG") echo 'selected="selected"'; ?>>RECIBO</option>
                        <?php
                        endif;
                    endif;
                    ?>
                </select>
            </div>
        </div>
        <div class="col-lg-2">
            <div class="mb-3">
                <label class="form-label">Pagamento</label>
                <select class="form-control" id="method" name="method">
                    <option value="CD" <?php if (isset($ClienteData['method']) && $ClienteData['method'] == "CD") echo 'selected="selected"'; ?>>Cartão de Debito</option>
                    <option value="NU" <?php if (isset($ClienteData['method']) && $ClienteData['method'] == "NU") echo 'selected="selected"'; ?>>Numerário</option>
                    <option value="TB" <?php if (isset($ClienteData['method']) && $ClienteData['method'] == "TB") echo 'selected="selected"'; ?>>Transferência Bancária</option>
                    <option value="MB" <?php if (isset($ClienteData['method']) && $ClienteData['method'] == "MB") echo 'selected="selected"'; ?>>Referência de pagamentos para Multicaixa</option>
                    <option value="OU" <?php if (isset($ClienteData['method']) && $ClienteData['method'] == "OU") echo 'selected="selected"'; ?>>Outros Meios Aqui não Assinalados</option>
                </select>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="mb-3">
                <label class="form-label">Motivo de rectificação</label>
                <select class="form-control" id="settings_doctype" name="settings_doctype">
                    <option value="Devolução de produtos" <?php if (isset($ClienteData['settings_doctype']) && $ClienteData['settings_doctype'] == "Devolução de produtos") echo 'selected="selected"'; ?>>Devolução de produtos</option>
                    <option value="Pagamento"  <?php if (isset($ClienteData['settings_doctype']) && $ClienteData['settings_doctype'] == "Erro na Factura") echo 'selected="selected"'; ?>>Erro na Factura</option>
                    <option value="Pagamento" <?php if (isset($ClienteData['settings_doctype']) && $ClienteData['settings_doctype'] == "Pagamento") echo 'selected="selected"'; ?>>Pagamento</option>
                    <?php
                    $Read = new Read();
                    $Read->ExeRead("db_active", "WHERE id_db_settings=:i", "i={$id_db_settings}");

                    if($Read->getResult()):
                        foreach($Read->getResult() as $kT):
                            ?>
                            <option value="<?= $kT['active']; ?>" <?php if (isset($ClienteData['settings_doctype']) && $ClienteData['settings_doctype'] == "{$kT['active']}") echo 'selected="selected"'; ?>><?= $kT['active']; ?></option>
                        <?php
                        endforeach;
                    endif;
                    ?>
                </select>
            </div>
        </div>
        <div class="col-lg-2">
            <div class="mb-7">
                <label class="form-label">-</label>
                <a href="javascript:void" onclick="Retification(<?= $Number; ?>, '<?= $Commic; ?>')" class="btn btn-primary">Processar</a>
            </div>
        </div>
    </div>
</div>

<div class="col-md-12">
    <div class="row">
        <?php
        $sL = 1;
        $q  = 0;
        $read->ExeRead("sd_retification", "WHERE id_db_settings=:i AND id_invoice=:id AND status=:st", "i={$id_db_settings}&id={$Number}&st={$sL}");
        if($read->getResult()):
            //var_dump($read->getResult()[0]);
            $iddInvoice = $read->getResult()[0]['Invoice'];
            $numeroXvideos =  $read->getResult()[0]['numero'];
            ?>
            <form method="post" action="" enctype="multipart/form-data">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Item</th>
                        <th>Quantidade</th>
                        <th>Ação</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $read->ExeRead("sd_billing_pmp", "WHERE id_db_settings=:i AND numero=:iS AND InvoiceType=:ip", "i={$id_db_settings}&iS={$dating['numero']}&ip={$Commic}");

                    if($read->getResult()):
                        foreach($read->getResult() as $key):

                            $read->ExeRead("sd_retification_pmp", "WHERE id_db_settings=:ip AND id_invoice=:i AND id_product=:vg", "ip={$id_db_settings}&i={$Number}&vg={$key['id_product']}");
                            if($read->getResult()):
                                foreach($read->getResult() as $n):
                                    $q = $key['quantidade_pmp'] - $n['quantidade_pmp'];
                                endforeach;
                            else:
                                $q = $key['quantidade_pmp'];
                            endif;

                            ?>
                            <tr>
                                <td>
                                    <?= $key['product_name'] ?>
                                    <input type="hidden" id="id_db_settings_<?= $key['id']; ?>" value="<?= $id_db_settings; ?>"/>
                                    <input type="hidden" id="id_user_<?= $key['id']; ?>" value="<?= $id_user;?>"/>
                                    <input type="hidden" id="idd_<?= $key['id']; ?>" value="<?= $key['id_product'];?>"/>
                                    <input type="hidden" id="status_<?= $key['id']; ?>" value="<?= $key['status']; ?>"/>
                                </td>
                                <td><input type="number" min="0" value="<?= $q; ?>" class="form-control" id="quantidade_<?= $key['id']; ?>" max="<?= $q; ?>" placeholder="Quantidade"></td>

                                <?php  if($q >= 1): ?>
                                <td><a href="javascript:void" onclick="AddRetification(<?= $key['id']; ?>, '<?= $Commic; ?>', '<?= $iddInvoice; ?>', '<?= $Number; ?>')" class="btn btn-default"><svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" /><line x1="12" y1="11" x2="12" y2="17" /><line x1="9" y1="14" x2="15" y2="14" /></svg></a></td>
                                <?php endif; ?>
                            </tr>
                            <?php
                        endforeach;
                    endif;
                    ?>
                    </tbody>
                </table>
            </form>
            <i class="col-line"></i>
            <a href="javascript:void()" onclick="RemFinish('<?= $Commic; ?>', <?= $Number; ?>, '<?= $iddInvoice?>', '<?= $numeroXvideos ?>')" class="btn btn-primary">Finalizar</a>
            <br/>
        <?php
        endif;
        ?>
    </div>
</div>
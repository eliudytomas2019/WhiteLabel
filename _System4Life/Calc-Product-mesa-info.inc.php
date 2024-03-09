<?php
/**
 * Created by PhpStorm.
 * User: Kwanzar Soft
 * Date: 15/08/2020
 * Time: 15:52
 */

$total_incidencia     = 0;
$total_com_imposto    = 0;
$total_com_desconto   = 0;
$total_geral          = 0;
$total_itens          = 0;
?>
<div id="maquilhagem">
    <table>
        <thead>
        <tr>
            <th>Item</th>
            <th>Qtd</th>
            <th>Preço</th>
            <th>Total</th>
            <th><i class="far fa-trash-alt"></i></th>
        </tr>
        </thead>
        <tbody>
        <?php
            $Read = new Read();
            $Read->ExeRead("sd_billing_tmp", "WHERE id_db_settings=:i AND session_id=:ip AND id_mesa=:ipp", "i={$id_db_settings}&ip={$id_user}&ipp={$id_mesa}");

            if($Read->getResult()):
                foreach($Read->getResult() as $key):
                    $value    = $key['quantidade_tmp'] * $key['preco_tmp'];
                    $desconto = ($value * $key['desconto_tmp']) / 100;
                    $imposto  = ($value * $key['taxa']) / 100;

                    $total = ($value - $desconto) + $imposto;

                    $total_com_desconto += $desconto;
                    $total_com_imposto  += $imposto;
                    $total_incidencia   += $value;
                    $total_itens += $key['quantidade_tmp'];
                    ?>
                    <tr>
                        <td><?= $key['product_name']; ?></td>
                        <td><input type="text" style="width: 30px!important;" value="<?= $key['quantidade_tmp']; ?>" min="<?= $key['quantidade_tmp']; ?>" class="form-jah Qtds" data-file="<?= $key['id']; ?>" placeholder="Qtd"></td>
                        <td><?= number_format($key['preco_tmp'], 2); ?></td>
                        <td><?= number_format($total, 2); ?></td>
                        <td><a href="javascript:void()" onclick="RemoveMesa(<?= $key['id']; ?>)"><i class="far fa-trash-alt"></i></a></td>
                    </tr>
                    <?php
                endforeach;
            endif;
        ?>
        </tbody>
    </table>
</div>

<?php $total_geral = ($total_incidencia - $total_com_desconto) + $total_com_imposto; ?>

<div class="Momment">
    <div class="Array">
        <div class="AllMy">
            <p>Total de itens</p>
            <p><?= number_format($total_itens, 2); ?></p>
        </div>
        <div class="AllMy">
            <p>Incidência</p>
            <p><?= number_format($total_incidencia, 2); ?></p>
        </div>
    </div>
    <div class="Array">
        <div class="AllMy">
            <p>Desconto</p>
            <p><?= number_format($total_com_desconto, 2); ?></p>
        </div>
        <div class="AllMy">
            <p>Impostos</p>
            <p><?= number_format($total_com_imposto, 2); ?></p>
        </div>
    </div>
    <div class="CallYou">
        <p>Total a pagar</p>
        <p><?= number_format($total_geral, 2); ?></p>
    </div>
</div>

<!--- MODAL --->

<div class="my-modal">
    <div class="header_my_modal">
        <a href="javascript:void()" class="close_header">X</a>
    </div>
    <div id="assim">
        <div id="getReturn"></div>
        <div class="Tattoo">
            <div class="Tomas">
                <span>Data de disponibilização</span>
                <input type="date" id="TaxPointDate" value="<?= date('Y-m-d'); ?>" class="form-jah">
            </div>
            <div class="Tomas">
                <span>Cliente</span>
                <select id="customer" class="form-jah">
                    <?php
                    $read = new Read();
                    $read->ExeRead("cv_customer", "WHERE id_db_settings=:i ORDER BY nome ASC, nif ASC", "i={$id_db_settings}");
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
        <div class="Tattoo">
            <div class="Tomas">
                <span>Documento</span>
                <select class="form-jah" id="InvoiceType">
                    <option value="FR" <?php if(isset($DataSupplier['InvoiceType']) && $DataSupplier['InvoiceType'] == "FR") echo 'selected="selected"'; ?>>FACTURA/RECIBO</option>
                    <?php if($level >= 3): ?><option value="FT" <?php if(isset($DataSupplier['InvoiceType']) && $DataSupplier['InvoiceType'] == "FT") echo 'selected="selected"'; ?>>FATURA</option><?php endif; ?>
                </select>
            </div>
            <div class="Tomas">
                <span>Pagamento</span>
                <select onclick="Magia()" class="form-jah" id="method">
                    <option value="CD" <?php if(isset($DataSupplier['method']) && $DataSupplier['method'] == "CD") echo 'selected="selected"'; ?>>Cartão de Debito</option>
                    <option value="CC" <?php if(isset($DataSupplier['method']) && $DataSupplier['method'] == "CC") echo 'selected="selected"'; ?>>Cartão de Credito</option>
                    <option value="CH" <?php if(isset($DataSupplier['method']) && $DataSupplier['method'] == "CH") echo 'selected="selected"'; ?>>Cheque Bancário</option>
                    <option value="NU" <?php if(isset($DataSupplier['method']) && $DataSupplier['method'] == "NU") echo 'selected="selected"'; ?>>Numerário</option>
                    <option value="TB" <?php if(isset($DataSupplier['method']) && $DataSupplier['method'] == "TB") echo 'selected="selected"'; ?>>Transferência Bancária</option>
                    <option value="OU" <?php if(isset($DataSupplier['method']) && $DataSupplier['method'] == "OU") echo 'selected="selected"'; ?>>Outros Meios Aqui não Assinalados</option>
                </select>
            </div>
        </div>
        <div class="Tattoo">
            <div class="Tomas">
                <span>Desconto Financeiro</span>
                <input type="number" min="0" max="100" <?php if($level < 3): ?>disabled<?php endif; ?> id="settings_desc_financ" value="<?php if(isset($DataSupplier['settings_desc_financ'])): echo $DataSupplier['settings_desc_financ']; else: echo "0"; endif; ?>" placeholder="0" class="form-jah">
            </div>

            <div class="Tomas">
                <span>Garçom</span>
                <select id="id_garcom" class="form-jah">
                    <?php
                    $read = new Read();
                    $read->ExeRead("cv_garcom", "WHERE id_db_settings=:i ORDER BY name ASC", "i={$id_db_settings}");
                    if($read->getResult()):
                        foreach ($read->getResult() as $Supplier):
                            extract($Supplier);
                            ?>
                            <option value="<?= $Supplier['id']; ?>" <?php if(isset($DataSupplier['id_garcom']) && $DataSupplier['id_garcom'] == $Supplier['id']) echo 'selected="selected"'; ?>><?= $Supplier['name']; ?></option>
                            <?php
                        endforeach;
                    else:
                        WSError("Oppsss! Não encontramos nenhum Garçom, cadastre um para prosseguir!", WS_ALERT);
                    endif;
                    ?>
                </select>
            </div>
        </div>

        <div class="line"></div>
        <div class="Tattoo magic">
            <div class="Helios">
                <span>Total</span>
                <input type="text" value="<?= number_format($total_geral, 2); ?>" data-file="<?= $total_geral; ?>" id="valueTotal"  class="form-jah strong">
            </div>
            <div class="Helios">
                <span>Pagou</span>
                <input type="text" id="valuePagou" class="form-jah strong">
            </div>
            <div class="Helios">
                <span>Troco</span>
                <input type="text" id="valueTroco" disabled class="form-jah strong disabled">
            </div>
        </div>
        <div class="line"></div>

        <a href="javascript:void()" onclick="FinishPDV(<?= $id_db_settings.", ".$id_user.", ".$id_mesa ?>)" class="tdn status-off-1"><i class="fas fa-money-bill-wave-alt"></i> Finalizar venda</a>
    </div>
</div>

<?php
$Total_sI = 0;
$Total_I  = 0;

$n = 0;
$g;
$iva_i = 0;
$Aiko = "";
$totol_iva = 0;
$total_desconto = 0;
$total_valor = 0;
$total_preco = 0;
$total_geral = 0;
$total_service = 0;
$Si          = 0;
$So          = 0;
$p = array();

if(DBKwanzar::CheckConfig($id_db_settings)['JanuarioSakalumbu'] == null): $ttt = 2; else: $ttt = DBKwanzar::CheckConfig($id_db_settings)['JanuarioSakalumbu']; endif;
$suspenso = 0;

if($year <= "2020" && $mondy <= "07"):
    $InBody = '';
    $InHead = '';
else:
    $InHead = "AND sd_billing.InvoiceType=:In AND sd_billing_pmp.InvoiceType=:In";
    $InBody = "&In={$InvoiceType}";
endif;

$read->ExeRead("sd_billing, sd_billing_pmp", "WHERE sd_billing.id_db_settings=:i AND sd_billing.suspenso=:s AND sd_billing.status=:st AND  sd_billing.numero=:n AND sd_billing_pmp.numero=:n AND sd_billing_pmp.status=:st AND sd_billing_pmp.id_db_settings=:i {$InHead} ORDER BY sd_billing.id DESC", "i={$id_db_settings}&s={$suspenso}&st={$ttt}&n={$Number}{$InBody}");

if($read->getResult()):
    $k = $read->getResult()[0];
    POS::Timer($k['numero'], $InvoiceType);
    ?>
    <div class="header">
        <img src="./uploads/<?php if($k['settings_logotype'] == null || $k['settings_logotype'] == null): echo $Index['logotype']; else: echo $k['settings_logotype']; endif;  ?>" class="img-silvio"/>
        <div class="header-silvio">
            <div class="header-silvio-a">
                <div class="A4-left">
                    <h2><?= $k['settings_empresa']; ?></h2>
                    <p><span>NIF:</span> <?= $k['settings_nif']; ?></p>
                    <p class="website"><span>Website:</span> <?= $k['settings_website']; ?></p>
                    <p><span>E-MAIL:</span> <?= $k['settings_email']; ?></p>
                    <p><span>Address:</span> <?= $k['settings_endereco']; ?></p>
                    <p><span>Telephone:</span> <?= $k['settings_telefone']; ?></p>
                </div>
            </div>
            <div class="header-silvio-b">
                <h4>Dear. Messrs)</h4>
                <span><?= $k['customer_name'] ?></span>
                <span><?php if($k['customer_nif'] == null || $k['customer_nif'] == '' || $k['customer_nif'] == '999999999'): echo "Consumidor final"; else: echo $k['customer_nif']; endif; ?></span>
                <span><?= $k['customer_endereco'] ?></span>
            </div>
        </div>
        <div class="limpopo-silvio">
            <h1><?php if($k['InvoiceType'] == 'PP'): echo "Proforma Invoice "; elseif($k['InvoiceType'] == 'FT'): echo 'Invoice '; else: echo 'Invoice/Receipt '; endif; ?> <?= $k['InvoiceType']." ".$k['mes'].$k['Code'].$k['ano']."/".$k['numero']; if(Strong::Config($id_db_settings)['JanuarioSakalumbu'] == 2 || DBKwanzar::CheckConfig($id_db_settings)['JanuarioSakalumbu'] == '' || Strong::Config($id_db_settings)['JanuarioSakalumbu'] == null): echo '&nbsp;MODO DE INSTRUÇÃO, ESSE DOCUMENTO NÃO É VÁLIDO'; endif; ?></h1>

            <?php $Data = ["", "Original", "Double", "Triplicate"]; ?>
            <span><?php if($k['timer'] == null || $k['timer'] == '' || $k['timer'] < 3): ?> <?= $Data[$i]; ?><?php else: ?> 2nd copy in accordance with the original<?php endif; ?></span>
        </div>
        <table class="">
            <thead>
            <tr>
                <th>Coin</th>
                <th>Date of issue</th>
                <th>Issuance time</th>
                <?php if($k['InvoiceType'] == 'FR'): ?>
                    <th>Payment method</th>
                <?php endif; ?>
                <?php if($k['InvoiceType'] == 'PP'): ?>
                    <th>Valid until</th>
                <?php endif; ?>
                <th>Operator</th>
                <th>Reference</th>
                <th>Page</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td><?= $k['settings_moeda']; ?></td>
                <td><?= $k['dia']."-".$k['mes']."-".$k['ano'] ?></td>
                <td><?= $k['hora'] ?></td>
                <?php
                $dp = explode("-", $k['date_expiration']);
                if($k['InvoiceType'] == 'FR'): ?>
                    <td><?php if($k['method'] == 'CC'): echo 'Credit card'; elseif($k['method'] == 'MB'): echo 'Payment reference for Multicaixa'; elseif($k['method'] == 'CD'): echo 'Debit card'; elseif($k['method'] == 'CH'): echo 'Bank check'; elseif($k['method'] == 'NU'): echo 'Cash'; elseif ($k['method'] == 'TB'): echo 'Bank transfer'; elseif($k['method'] == 'OU'): echo 'Other Means Not Listed Here'; elseif($k['method'] == 'ALL'): echo 'Diversified'; endif; ?>
                    </td>
                <?php endif; ?>
                <?php if($k['InvoiceType'] == 'PP'): ?>
                    <td><?= $dp[2]."-".$dp[1]."-".$dp[0]; ?></td>
                <?php endif; ?>
                <td><?= $k['username'] ?></td>
                <td><?= $k['referencia'] ?></td>
                <td><span class="page"></span></td>
            </tr>
            </tbody>
        </table>
    </div>

    <div class="table-silvio">
        <table>
            <thead class="punheta">
            <tr>
                <th>Code</th>
                <th>Discrimination</th>
                <th>Qty</th>
                <th>Uni price.</th>
                <th>Discount%</th>
                <th>Rate%</th>
                <th>Total</th>
            </tr>
            </thead>
            <tbody>
            <?php
            require("./_SystemWoW/Arrays_calc.inc.php");

            foreach($read->getResult() as $key):
                extract($key);
                $p = $key;

                $value = ($key['quantidade_pmp'] * $key['preco_pmp']);
                $iva = ($value * $key['taxa']) / 100;

                if($key['desconto_pmp'] >= 100):
                    $desconto = $key['desconto_pmp'];
                else:
                    $desconto = ($value * $key['desconto_pmp']) / 100;
                endif;

                //$desconto = ($value * $key['desconto_pmp']) / 100;
                $valor = ($value);

                $totol_iva += $iva;
                $total_desconto += $desconto;
                $total_valor += $valor;
                $total_preco += $value;

                require("./_SystemWoW/Calc_Impostos.inc.php");

                $value_01 = $value + $iva;

                if($key['product_type'] == "S"):
                    $total_service += $value;
                endif;
                ?>
                <tr>
                    <td><?= $key['product_code']; ?></td>
                    <td>
                        <?= $key['product_name'] ?>
                        <?php if(DBKwanzar::CheckConfig($id_db_settings) == false || DBKwanzar::CheckConfig($id_db_settings)['PadraoAGT'] == null || DBKwanzar::CheckConfig($id_db_settings)['PadraoAGT'] == 2): ?><?php if($key['taxa'] == 0): echo ' <small>('.$n.')</small>'; endif; ?><?php endif; ?><br/>
                        <?php if($key['taxa'] == 0): ?><small style="font-size: 7pt!important;"><?= $key['TaxExemptionReason']; ?></small><br/><?php endif; ?>
                        <small><?= $key['product_list']; ?></small>
                    </td>
                    <td><?= str_replace(",", ".", number_format($key['quantidade_pmp'], 2)) ?></td>
                    <td><?= str_replace(",", ".", number_format($key['preco_pmp'], 2));  ?></td>
                    <td><?= str_replace(",", ".", number_format($key['desconto_pmp'], 2));  ?></td>
                    <td><?= str_replace(",", ".", number_format($key['taxa'], 2));  ?> <?php if(DBKwanzar::CheckConfig($id_db_settings) == false || DBKwanzar::CheckConfig($id_db_settings)['PadraoAGT'] == null || DBKwanzar::CheckConfig($id_db_settings)['PadraoAGT'] == 2): ?><?php if($key['taxa'] == 0): echo "(".$key['TaxExemptionCode'].")"; endif; ?><?php endif; ?></td>
                    <td><?= str_replace(",", ".", number_format($value_01, 2));  ?></td>
                </tr>
            <?php
            endforeach;
            ?>
            </tbody>
        </table>
        <div class="limpopo-silvio-2">
                <span><?php
                    if(DBKwanzar::CheckConfig($id_db_settings) == false || DBKwanzar::CheckConfig($id_db_settings)['PadraoAGT'] == null || DBKwanzar::CheckConfig($id_db_settings)['PadraoAGT'] == 2):
                        require("./_SystemWoW/footer-invoice-geral-w-ingles.inc.php");
                    endif;
                    ?></span>
        </div>
    </div>
    <?php
    if($k['IncluirNaFactura'] == 2):
        $Retencao = ($total_service * $k['RetencaoDeFonte']) / 100;
    else:
        $Retencao = 0;
    endif;

    $descont_f = ($total_preco * $k['settings_desc_financ']) / 100;
    $total_geral = ($total_valor - ($descont_f + $total_desconto + $Retencao)) + $totol_iva;
    ?>
    <div class="footer-small">
        <div class="cripton-silvio">
            <div class="cripton-silvio-a">
                <?php  require("./_SystemWoW/Table_Impostos-II.inc.php"); ?>

                <?php if(!empty($k['settings_banco']) || !empty($k['settings_banco1']) || !empty($k['settings_banco2'])): ?>
                    <label class="Uno ap">
                        <span>BANK</span>
                        <p><?= $k['settings_banco'] ?> | <?= $k['settings_banco1'] ?> | <?= $k['settings_banco2'] ?></p>
                    </label>
                <?php endif;  ?>

                <?php if(!empty($k['settings_nib']) || !empty($k['settings_nib1']) || !empty($k['settings_nib2'])): ?>
                    <label class="Uno">
                        <span>ACCOUNT/NIB</span>
                        <p><?= $k['settings_nib'] ?> | <?= $k['settings_nib1'] ?> | <?= $k['settings_nib2'] ?></p>
                    </label>
                <?php endif;  ?>

                <?php if(!empty($k['settings_iban']) || !empty($k['settings_iban1']) || !empty($k['settings_iban2'])): ?>
                    <label class="Uno">
                        <span>IBAN</span>
                        <p><?= $k['settings_iban'] ?> | <?= $k['settings_iban1'] ?> | <?= $k['settings_iban2'] ?></p>
                    </label>
                <?php endif;  ?>

                <?php if(!empty($k['settings_swift']) || !empty($k['settings_swift1']) || !empty($k['settings_swift2'])): ?>
                    <label class="Uno af">
                        <span>SWIFT/BIC</span>
                        <p><?= $k['settings_swift'] ?> | <?= $k['settings_swift1'] ?> | <?= $k['settings_swift2'] ?></p>
                    </label>
                <?php endif;  ?>

                <div class="nota-silvio">
                    <?php
                    require("./_SystemWoW/Obs.invoice-ingles.inc.php");
                    ?>
                </div>
            </div>

            <div class="cripton-silvio-b">
                <table class="spec">
                    <tr><td>Total Gross</td> <td><?php echo str_replace(",", ".", number_format($total_preco, 2)); ?></td></tr>
                    <tr><td>Commercial Discount</td> <td><?php echo str_replace(",", ".", number_format($total_desconto, 2));  ?></td></tr>
                    <tr><td>Financial discount (<?= str_replace(",", ".", number_format($k['settings_desc_financ'], 1)); ?>%)</td> <td><?= str_replace(",", ".",number_format($descont_f, 2)); ?></td></tr>
                    <tr><td>Total Tax</td> <td><?php echo str_replace(",", ".", number_format($totol_iva, 2)); ?></td></tr>
                    <?php if($k['method'] == 'NU' && $k['InvoiceType'] != 'PP'): ?>
                        <tr><td>Paid</td> <td><?= str_replace(",", ".", number_format($p['pagou'] ,2)); ?></td></tr>
                        <tr><td>Change</td> <td><?= str_replace(",", ".", number_format($p['troco'] ,2)); ?></td></tr>
                    <?php endif; ?>
                    <?php if($k['method'] == 'ALL' && $k['InvoiceType'] != 'PP'): ?>
                        <tr><td>Cash</td> <td><?= str_replace(",", ".", number_format($p['numerario'] ,2)); ?></td></tr>
                        <tr><td>Debit card</td> <td><?= str_replace(",", ".", number_format($p['cartao_de_debito'] ,2)); ?></td></tr>
                        <tr><td>Transfer</td> <td><?= str_replace(",", ".", number_format($p['transferencia'] ,2)); ?></td></tr>
                    <?php endif; ?>
                    <tr><td>Retention (<?= str_replace(",", ".", number_format($k['RetencaoDeFonte'], 1)) ?>%)</td> <td><?php if($k['IncluirNaFactura'] == 2): ?><?php echo number_format($Retencao, 2);  ?><?php  endif; ?></td></tr>
                </table>

                <div class="total-silvio">
                    <p>Total (<?= $k['settings_moeda']; ?>) <?= str_replace(",", ".", number_format($total_geral ,2)); ?></p>
                </div>
            </div>
        </div>
    </div>
<?php
endif;

$file = $k['InvoiceType']." ".$k['mes'].$k['Code'].$k['ano']."_".$k['numero'];
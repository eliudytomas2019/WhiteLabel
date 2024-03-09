<?php
$Total_sI = 0;
$Total_I  = 0;

$n = 0;
$g = null;
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
?>
<div class="newA4">
    <?php
        $read->ExeRead("sd_billing, sd_billing_pmp", "WHERE sd_billing.id_db_settings=:i AND sd_billing.suspenso=:s AND sd_billing.status=:st AND  sd_billing.numero=:n AND sd_billing_pmp.numero=:n AND sd_billing_pmp.status=:st AND sd_billing_pmp.id_db_settings=:i {$InHead} ORDER BY sd_billing.id DESC", "i={$id_db_settings}&s={$suspenso}&st={$ttt}&n={$Number}{$InBody}");

        if($read->getResult()):
            $k = $read->getResult()[0];
            POS::Timer($k['numero'], $InvoiceType);
            //var_dump($k['id']);
            ?>
            <title><?= $k['InvoiceType']." ".$k['mes'].$k['Code'].$k['ano']."_".$k['numero'];  ?></title>

            <div class="newA4reader">
                <?php if(DBKwanzar::CheckConfig($id_db_settings)['IncluirCover'] == null || DBKwanzar::CheckConfig($id_db_settings)['IncluirCover'] == 2): ?><img src="./uploads/<?php if($k['settings_logotype'] == null || $k['settings_logotype'] == null): echo $Index['logotype']; else: echo $k['settings_logotype']; endif;  ?>" class="logotype-invoice" <?php if(DBKwanzar::CheckConfig($id_db_settings)['WidthLogotype'] == null && DBKwanzar::CheckConfig($id_db_settings)['HeightLogotype'] == null): ?>style="max-height: 100px!important;max-width: 180px!important;" <?php else: ?>style="height: <?= DBKwanzar::CheckConfig($id_db_settings)['HeightLogotype']; ?>px!important;width: <?= DBKwanzar::CheckConfig($id_db_settings)['WidthLogotype']; ?>px!important;"<?php endif;  ?>/><?php endif; ?>
                <div class="A4-getMe">
                    <div class="A4-left">
                        <h2><?= $k['settings_empresa']; ?></h2>
                        <p><span>Endereço:</span> <?= $k['settings_endereco']; ?></p>
                        <p><span>Contribuinte:</span> <?= $k['settings_nif']; ?></p>
                        <p><span>Telefone:</span> <?= $k['settings_telefone']; ?></p>
                        <p><span>Email:</span> <?= $k['settings_email']; ?></p>
                        <p><span>Website:</span> <?= $k['settings_website']; ?></p>
                    </div>
                    <div class="A4-right">
                        <h4>Exmo.(s) Sr.(s)</h4>
                        <span><?= $k['customer_name'] ?></span>
                        <span>Contribuinte: <?php if($k['customer_nif'] == null || $k['customer_nif'] == '' || $k['customer_nif'] == '999999999'): echo "Consumidor final"; else: echo $k['customer_nif']; endif; ?></span>
                        <span>Endereço: <?= $k['customer_endereco'] ?></span>
                    </div>
                </div>

                <div class="Yolanda">
                    <?php $Data = ["", "Original", "Duplicado", "Triplicado"]; ?>
                    <h1 class="header-one pussy"><?php if($k['InvoiceType'] == 'PP'): echo "Factura Pró-forma "; elseif($k['InvoiceType'] == 'FT'): echo 'Factura '; else: echo 'Factura/Recibo '; endif; ?> <?= $k['InvoiceType']." ".$k['mes'].$k['Code'].$k['ano']."/".$k['numero']; if(Strong::Config($id_db_settings)['JanuarioSakalumbu'] == 2 || DBKwanzar::CheckConfig($id_db_settings)['JanuarioSakalumbu'] == '' || Strong::Config($id_db_settings)['JanuarioSakalumbu'] == null): echo '&nbsp;MODO DE INSTRUÇÃO, ESSE DOCUMENTO NÃO É VÁLIDO'; endif; ?> </h1>


                    <?php if($k['timer'] == null || $k['timer'] == '' || $k['timer'] < 3): ?><p class="Lu">Moeda: (<?= $k['settings_moeda']; ?>) <?= $Data[$i]; ?></p><?php else: ?><p class="Luzineth">Moeda: (<?= $k['settings_moeda']; ?>) 2ª via em conformidade com a original</p><?php endif; ?>
                </div>

                <table class="DomingosTomas">
                    <thead>
                        <tr>
                            <th>Data de emissão</th>
                            <th>Hora de emissão</th>
                            <?php if($k['InvoiceType'] == 'FR'): ?>
                                <th>Meio de pagamento</th>
                            <?php elseif($k['InvoiceType'] == 'PP'): ?>
                                <th>Válida até</th>
                            <?php endif; ?>
                            <th>Operador</th>
                            <th>Referência</th>
                            <th>Página</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?= $k['ano']."-".$k['mes']."-".$k['dia'] ?></td>
                            <td><?= $k['hora'] ?></td>
                            <?php if($k['InvoiceType'] == 'FR'): ?>
                                <td><?php if($k['method'] == 'CC'): echo 'Cartão de Credito'; elseif($k['method'] == 'MB'): echo 'Referência de pagamentos para Multicaixa'; elseif($k['method'] == 'CD'): echo 'Cartão de Debito'; elseif($k['method'] == 'CH'): echo 'Cheque Bancário'; elseif($k['method'] == 'NU'): echo 'Numerário'; elseif ($k['method'] == 'TB'): echo 'Transferência Bancária'; elseif($k['method'] == 'OU'): echo 'Outros Meios Aqui não Assinalados'; endif; ?>
                                </td>
                            <?php elseif($k['InvoiceType'] == 'PP'): ?>
                                <td><?= $k['date_expiration']; ?></td>
                            <?php endif; ?>
                            <td><?= $k['username'] ?></td>
                            <td><?= $k['referencia'] ?></td>
                            <td>1 de 1</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="newA4-body">
                <table>
                    <thead>
                    <tr>
                        <th>Código</th>
                        <th>Descriminação</th>
                        <th>Qtd</th>
                        <th>Preço uni.</th>
                        <th>Desc%</th>
                        <th>Taxa%</th>
                        <th>Total</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php
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

                                if($key['taxa'] == 0):
                                    $n += 1;
                                    $g = "Isento"; //$key['TaxExemptionReason'];
                                    $v = $key['taxa'];
                                    $Total_sI += $valor;
                                    $So += $iva;
                                else:
                                    $iva_i = $key['taxa'];
                                    $Aiko = $key['taxType'];
                                    $Total_I += $valor;
                                    $pr = $key['taxa'];
                                    $Si += $iva;
                                endif;

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
            <div class="newA4-footer">
                <div class="A4-getMe">
                    <div class="footer-left">
                        <?php if(DBKwanzar::CheckConfig($id_db_settings) == false || DBKwanzar::CheckConfig($id_db_settings)['PadraoAGT'] == null || DBKwanzar::CheckConfig($id_db_settings)['PadraoAGT'] == 2): ?>
                        <h2>Resumo de Impostos</h2>
                        <table>
                            <thead>
                                <tr>
                                    <th>Descrição</th>
                                    <th>Taxa%</th>
                                    <th>Incidência</th>
                                    <th>Total Imposto</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($n > 0): ?>
                                    <tr>
                                        <td><?= '<small style="color: #000">('.$n.') '.$g.'</small>'; ?></td>
                                        <td><?= str_replace(",", ".", number_format($v, 2)); ?></td>
                                        <td><?= str_replace(",", ".", number_format($Total_sI, 2)); ?></td>
                                        <td><?= str_replace(",", ".", number_format($So, 2)); ?></td>
                                    </tr>
                                <?php endif; ?>
                                <?php if($iva_i > 0): ?>
                                    <tr>
                                        <td><?= $Aiko; ?></td>
                                        <td><?= str_replace(",", ".", number_format($pr, 2)); ?></td>
                                        <td><?= str_replace(",", ".", number_format($Total_I, 2)); ?></td>
                                        <td><?= str_replace(",", ".", number_format($Si, 2)); ?></td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                        <?php endif; ?>

                        <div class="FooterBanca">
                            <?php if(!empty($k['settings_nib']) && !empty($k['settings_iban']) && !empty($k['settings_swift'])): ?>
                                <span class="titleOne">Dados Bancários</span>
                                <label class="Uno ap">
                                    <span>NIB</span>
                                    <p><?= $k['settings_nib'] ?></p>
                                </label>
                                <label class="Uno">
                                    <span>IBAN</span>
                                    <p><?= $k['settings_iban'] ?></p>
                                </label>
                                <label class="Uno af">
                                    <span>SWIFT/BIC</span>
                                    <p><?= $k['settings_swift'] ?></p>
                                </label>
                            <?php elseif(!empty($k['settings_coordenadas'])): ?>
                                <span class="titleOne">Dados bancários</span>
                                <label class="Uno">
                                    <p><?= $k['settings_coordenadas'] ?></p>
                                </label>
                            <?php endif; ?>
                        </div>
                        <?php
                        if(DBKwanzar::CheckConfig($id_db_settings) == false || DBKwanzar::CheckConfig($id_db_settings)['PadraoAGT'] == null || DBKwanzar::CheckConfig($id_db_settings)['PadraoAGT'] == 2):
                            require("./_SystemWoW/Obs.invoice.inc.php");
                        endif;
                        ?>
                    </div>

                    <div class="footer-right">
                        <table class="spec">
                            <tr><td>Total Iliquido</td> <td><?php echo str_replace(",", ".", number_format($total_preco, 2)); ?></td></tr>
                            <tr><td>Desconto Comercial</td> <td><?php echo str_replace(",", ".", number_format($total_desconto, 2));  ?></td></tr>
                            <tr><td>Desconto Financeiro (<?= str_replace(",", ".", number_format($k['settings_desc_financ'], 1)); ?>%)</td> <td><?= str_replace(",", ".",number_format($descont_f, 2)); ?></td></tr>
                            <tr><td>Total de Imposto</td> <td><?php echo str_replace(",", ".", number_format($totol_iva, 2)); ?></td></tr>
                            <?php if($k['method'] == 'NU' && $k['InvoiceType'] != 'PP'): ?>
                                <tr><td>Pagou</td> <td><?= str_replace(",", ".", number_format($p['pagou'] ,2)); ?></td></tr>
                                <tr><td>Troco</td> <td><?= str_replace(",", ".", number_format($p['troco'] ,2)); ?></td></tr>
                            <?php endif; ?>
                            <?php if($k['IncluirNaFactura'] == 2): ?> <tr><td>Retenção (<?= str_replace(",", ".", number_format($k['RetencaoDeFonte'], 1)) ?>%)</td> <td><?php echo number_format($Retencao, 2);  ?></td></tr> <?php  endif; ?>
                            <tr class="total"><td>Total</td> <td><?php echo str_replace(",", ".", number_format($total_geral ,2))." ".$k['settings_moeda'];  ?></td></tr>
                        </table>
                        <?php
                        if(DBKwanzar::CheckConfig($id_db_settings) == false || DBKwanzar::CheckConfig($id_db_settings)['PadraoAGT'] == null || DBKwanzar::CheckConfig($id_db_settings)['PadraoAGT'] == 2):
                            require("./_SystemWoW/footer-invoice-geral.inc.php");
                        endif;
                        ?>
                    </div>
                </div>
            </div>
            <?php
        endif;
    ?>
</div>
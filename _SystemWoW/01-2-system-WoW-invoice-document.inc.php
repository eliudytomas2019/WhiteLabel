-<?php
/**
 * Created by PhpStorm.
 * User: Kwanzar Soft
 * Date: 28/07/2020
 * Time: 20:47
 */
?>
<div class="A4">
    <?php
    $n = 0;
    $g;
    $iva_i = 0;
    $Aiko = "";
    $totol_iva = 0;
    $total_desconto = 0;
    $total_valor = 0;
    $total_preco = 0;
    $total_geral = 0;
    $p = array();

    if(DBKwanzar::CheckConfig($id_db_settings)['JanuarioSakalumbu'] == null): $ttt = 2; else: $ttt = DBKwanzar::CheckConfig($id_db_settings)['JanuarioSakalumbu']; endif;
    $suspenso = 0;

    if($year <= "2020" && $mondy <= "07" && $day <= "09"):
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
        //var_dump($k['id']);
        ?>
        <nav class="A4-reader">
            <div class="A4-reader-two">
                <div class="A4-invoice">
                    <img src="./uploads/<?php if($k['settings_logotype'] == null || $k['settings_logotype'] == null): echo "logotype.png"; else: echo $k['settings_logotype']; endif;  ?>" class="logotype-invoice" style="width: <?= DBKwanzar::CheckConfig($id_db_settings)['WidthLogotype'] ?>px!important;height: <?= DBKwanzar::CheckConfig($id_db_settings)['HeightLogotype'] ?>px!important;"/>
                    <h2><?= $k['settings_empresa']; ?></h2>
                    <p><span>Endereço:</span> <?= $k['settings_endereco']; ?></p>
                    <p><span>Contribuinte:</span> <?= $k['settings_nif']; ?></p>
                    <p><span>Telefone:</span> <?= $k['settings_telefone']; ?></p>
                    <p><span>Email:</span> <?= $k['settings_email']; ?></p>
                </div>

                <div class="A4-customer">
                    <div style="width: <?= DBKwanzar::CheckConfig($id_db_settings)['WidthLogotype'] ?>px!important;height: <?= DBKwanzar::CheckConfig($id_db_settings)['HeightLogotype'] ?>px!important;"></div>
                    <h4>Exmo.(s) Sr.(s)</h4>
                    <div class="umpixel">
                        <span><?= $k['customer_name'] ?></span>
                        <p>Contribuinte: <?php if($k['customer_nif'] == null || $k['customer_nif'] == '' || $k['customer_nif'] == '999999999'): echo "Consumidor final"; else: echo $k['customer_nif']; endif; ?></p>
                        <p>Endereço: <?= $k['customer_endereco'] ?></p>
                    </div>
                </div>
            </div>

            <div class="heliospro">
                <title><?= $k['InvoiceType']." ".$k['mes'].$k['Code'].$k['ano']."_".$k['numero'];  ?></title>
                <div id="xuxu">
                    <?php $Data = ["", "Original", "Duplicado", "Triplicado"]; ?>
                    <h1 class="header-one pussy"><?php if($k['InvoiceType'] == 'PP'): echo "Factura Pró-forma "; elseif($k['InvoiceType'] == 'FT'): echo 'Factura '; else: echo 'Factura/Recibo '; endif; ?> <?= $k['InvoiceType']." ".$k['mes'].$k['Code'].$k['ano']."/".$k['numero']; if(Strong::Config($id_db_settings)['JanuarioSakalumbu'] == 2 || DBKwanzar::CheckConfig($id_db_settings)['JanuarioSakalumbu'] == '' || Strong::Config($id_db_settings)['JanuarioSakalumbu'] == null): echo '&nbsp;MODO DE INSTRUÇÃO, ESSE DOCUMENTO NÃO É VÁLIDO'; endif; ?> </h1>


                    <?php if($k['timer'] == null || $k['timer'] == ''): ?><p class="Lu">Moeda: (<?= $k['settings_moeda']; ?>) <?= $Data[$i]; ?></p><?php else: ?><p class="Luzineth">Moeda: (<?= $k['settings_moeda']; ?>) 2ª via em conformidade com a original</p><?php endif; ?>
                </div>

                <table>
                    <thead>
                    <tr>
                        <th>Data de emissão</th>
                        <th>Hora de emissão</th>
                        <?php if($k['InvoiceType'] == 'FR'): ?>
                            <th>Meio de pagamento</th>
                        <?php elseif($k['InvoiceType'] == 'PP'): ?>
                            <th>Válida até</th>
                        <?php endif; ?>
                        <th>Emitida por</th>
                        <th>Página</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td><?= $k['ano']."-".$k['mes']."-".$k['dia'] ?></td>
                        <td><?= $k['hora'] ?></td>
                        <?php if($k['InvoiceType'] == 'FR'): ?>
                            <td><?php if($k['method'] == 'CC'): echo 'Cartão de Credito'; elseif($k['method'] == 'CD'): echo 'Cartão de Debito'; elseif($k['method'] == 'CH'): echo 'Cheque Bancário'; elseif($k['method'] == 'NU'): echo 'Numerário'; elseif ($k['method'] == 'TB'): echo 'Transferência Bancária'; elseif($k['method'] == 'OU'): echo 'Outros Meios Aqui não Assinalados'; endif; ?>
                            </td>
                        <?php elseif($k['InvoiceType'] == 'PP'): ?>
                            <td><?= $k['date_expiration']; ?></td>
                        <?php endif; ?>
                        <td><?= $k['username'] ?></td>
                        <td>1 de 1</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </nav>

        <div class="a4-body">
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
                <tbody style="font-size: 9pt!important;text-transform: uppercase!important;">
                <?php
                foreach($read->getResult() as $key):
                    extract($key);
                    $p = $key;

                    $value = ($key['quantidade_pmp'] * $key['preco_pmp']);
                    $iva = ($value * $key['taxa']) / 100;
                    $desconto = ($value * $key['desconto_pmp']) / 100;
                    $valor = ($value - $desconto) + $iva;

                    $totol_iva += $iva;
                    $total_desconto += $desconto;
                    $total_valor += $valor;
                    $total_preco += $value;

                    if($key['taxa'] == 0):
                        $n += 1;
                        $g = $key['TaxExemptionReason'];
                    else:
                        $iva_i = $key['taxa'];
                        $Aiko = $key['taxType'];
                    endif;
                    ?>
                    <tr>
                        <td style="font-style: italic"><?= $key['product_code']; ?></td>
                        <td style="font-size: 8pt!important;">
                            <?= $key['product_name'] ?>
                            <?php if($key['taxa'] == 0): echo ' <small>('.$n.')</small>'; endif; ?><br/>
                            <small><?= $key['product_list']; ?></small>
                        </td>
                        <td><?= number_format($key['quantidade_pmp'], 2) ?></td>
                        <td><?= number_format($key['preco_pmp'], 2);  ?></td>
                        <td><?= $key['desconto_pmp']  ?>%</td>
                        <td><?= $key['taxa']  ?>% <?php if($key['taxa'] == 0): echo "(".$key['TaxExemptionCode'].")"; endif; ?></td>
                        <td><?= number_format($valor, 2);  ?></td>
                    </tr>
                    <?php
                endforeach;
                ?>
                </tbody>
            </table>
        </div>
        <?php
        $total_geral = $total_valor;
        ?>
        <div class="a4-footer">
            <div class="xuxu">
                <div class="factura-footer-left">
                    <div class="banca">
                        <?php if(!empty($k['settings_nib']) && !empty($k['settings_iban']) && !empty($k['settings_swift'])): ?>
                            <span class="dope-muzik">Dados bancários</span>
                            <label class="grouwn">
                               NIB&nbsp;<?= $k['settings_nib'] ?>
                            </label>
                            <label class="grouwn">
                                IBAN&nbsp;<?= $k['settings_iban'] ?>
                            </label>
                            <label class="grouwn">
                                SWIFT&nbsp;<?= $k['settings_swift'] ?>
                            </label>
                        <?php elseif(!empty($k['settings_coordenadas'])): ?>
                            <span class="dope-muzik">Dados bancários</span>
                            <label class="grouwn a">
                                <p style="font-size: 9pt!important;"><?= $k['settings_coordenadas'] ?></p>
                            </label>
                        <?php endif; ?>
                    </div>

                    <p class="dope-muzik" style="margin: 0!important;"><b>Observações</b></p>
                    <?php
                    if($n > 0): echo '<small style="color: #000; font-size: 9pt!important;">('.$n.') '.$g.'</small>'; endif;
                    require("./_SystemWoW/Obs.invoice.inc.php");
                    require("./_SystemWoW/footer-invoice-geral.inc.php");
                    ?>
                </div>

                <div class="factura-footer-right">
                    <table id="tabelaspec">
                        <caption></caption>
                        <tr><td class="ce">Insidência</td> <td class="cd"><?php echo number_format($total_preco, 2); ?></td></tr>
                        <tr><td class="ce">Desconto</td>   <td class="cd"><?php echo number_format($total_desconto, 2);  ?></td></tr>
                        <tr><td class="ce">Imposto</td>    <td class="cd"><?php echo number_format($totol_iva, 2); ?></td></tr>
                        <tr><td class="ce">Total</td>      <td class="cd"><?php echo number_format($total_geral ,2)." ".$k['settings_moeda'];  ?></td></tr>
                        <?php if($k['method'] == 'NU' && $k['InvoiceType'] != 'PP'): ?>
                            <tr><td class="ce">Pagou</td> <td class="cd"><?php echo number_format($p['pagou'] ,2);  ?></td></tr>
                            <tr><td class="ce">Troco</td> <td class="cd"><?php echo number_format($p['troco'] ,2);  ?></td></tr>
                        <?php endif; ?>
                    </table>
                </div>
            </div>
        </div>
        <?php
    endif;
    ?>
</div>


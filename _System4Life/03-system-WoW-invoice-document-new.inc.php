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
?>
    <?php
    $read->ExeRead("sd_billing, sd_billing_pmp", "WHERE sd_billing.id_db_settings=:i AND sd_billing.suspenso=:s AND sd_billing.status=:st AND  sd_billing.numero=:n AND sd_billing_pmp.numero=:n AND sd_billing_pmp.status=:st AND sd_billing_pmp.id_db_settings=:i {$InHead} ORDER BY sd_billing_pmp.id ASC", "i={$id_db_settings}&s={$suspenso}&st={$ttt}&n={$Number}{$InBody}");

    if($read->getResult()):
        $k = $read->getResult()[0];
        POS::Timer($k['numero'], $InvoiceType);
        //var_dump($k['id']);
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
                        <p><span>Endereço:</span> <?= $k['settings_endereco']; ?></p>
                        <p><span>Telefone:</span> <?= $k['settings_telefone']; ?></p>
                    </div>
                </div>
                <div class="header-silvio-b">
                    <h4>Exmo.(s) Sr.(s)</h4>
                    <span><?= $k['customer_name'] ?></span>
                    <span><?php if($k['customer_nif'] == null || $k['customer_nif'] == '' || $k['customer_nif'] == '999999999'): echo "Consumidor final"; else: echo $k['customer_nif']; endif; ?></span>
                    <span><?= $k['customer_endereco'] ?></span>
                </div>
            </div>

            <div class="limpopo-silvio">
                <h1><?php if($k['InvoiceType'] == 'PP'): echo "Factura Pró-forma "; elseif($k['InvoiceType'] == 'FT'): echo 'Factura '; else: echo 'Factura/Recibo '; endif; ?> <?= $k['InvoiceType']." ".$k['mes'].$k['Code'].$k['ano']."/".$k['numero']; if(Strong::Config($id_db_settings)['JanuarioSakalumbu'] == 2 || DBKwanzar::CheckConfig($id_db_settings)['JanuarioSakalumbu'] == '' || Strong::Config($id_db_settings)['JanuarioSakalumbu'] == null): echo '&nbsp;MODO DE INSTRUÇÃO, ESSE DOCUMENTO NÃO É VÁLIDO'; endif; ?></h1>

                <?php $Data = ["", "Original", "Duplicado", "Triplicado"]; ?>
                <span><?php if($k['timer'] == null || $k['timer'] == '' || $k['timer'] < 3): ?> <?= $Data[$i]; ?><?php else: ?> 2ª via em conformidade com a original<?php endif; ?></span>
            </div>

            <table class="">
                <thead>
                <tr>
                    <th>Moeda</th>
                    <th>Data de Emissão</th>
                    <th>Hora de Emissão</th>
                    <?php if($k['InvoiceType'] == 'FR'): ?>
                        <th>Metodo de Pagamento</th>
                    <?php endif; ?>
                    <?php if($k['InvoiceType'] == 'PP'): ?>
                        <th>Válida Até</th>
                    <?php endif; ?>
                    <th>Operador</th>
                    <th>Página</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td><?= $k['settings_moeda']; ?></td>
                    <td><?= $k['dia']."-".$k['mes']."-".$k['ano'] ?></td>
                    <td><?php

                        $hora = explode(":", $k['hora']);
                        $hora1 = $hora[0]+1;

                        if($hora1 <= 9): $agora = "0".$hora1; else: $agora = $hora1; endif;

                        echo $agora.":".$hora[1].":".$hora[2];
                        ?></td>
                    <?php
                    $dp = explode("-", $k['date_expiration']);
                    if($k['InvoiceType'] == 'FR'): ?>
                        <td><?php if($k['method'] == 'CC'): echo 'Cartão de Credito'; elseif($k['method'] == 'MB'): echo 'Referência de pagamentos para Multicaixa'; elseif($k['method'] == 'CD'): echo 'Cartão de Debito'; elseif($k['method'] == 'CH'): echo 'Cheque Bancário'; elseif($k['method'] == 'NU'): echo 'Numerário'; elseif ($k['method'] == 'TB'): echo 'Transferência Bancária'; elseif($k['method'] == 'OU'): echo 'Outros Meios Aqui não Assinalados'; endif; ?>
                        </td>
                    <?php endif; ?>
                    <?php if($k['InvoiceType'] == 'PP'): ?>
                        <td><?= $dp[2]."-".$dp[1]."-".$dp[0]; ?></td>
                    <?php endif; ?>
                    <td><?= $k['username'] ?></td>
                    <td><span class="page"></span></td>
                </tr>
                </tbody>
            </table>
        </div>

        <div class="table-silvio">
            <table class="">
                <thead>
                <tr>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Matricula</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td><?= $k['id_fabricante']; ?></td>
                    <td><?= $k['id_veiculos']; ?></td>
                    <td class="pp"><?= $k['matriculas'] ?></td>
                </tr>
                </tbody>
            </table>
            <table>
                <thead class="punheta">
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


                    if($key['product_type'] != 'O'):
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
                    endif;

                    if($key['product_type'] == "S"):
                        $total_service += $value;
                    endif;
                    ?>
                    <?php if($key['product_type'] != 'O'): ?>
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
                        <td><?= str_replace(",", ".", number_format($valor, 2));  ?></td>
                    </tr>
                    <?php else: ?>
                        <tr>
                            <td><?= $key['product_code']; ?></td>
                            <td>
                                <?= $key['product_name'] ?>
                                <?php if(DBKwanzar::CheckConfig($id_db_settings) == false || DBKwanzar::CheckConfig($id_db_settings)['PadraoAGT'] == null || DBKwanzar::CheckConfig($id_db_settings)['PadraoAGT'] == 2): ?><?php if($key['taxa'] == 0): echo ' <small>('.$n.')</small>'; endif; ?><?php endif; ?><br/>
                                <small><?= $key['product_list']; ?></small>
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    <?php endif; ?>
                <?php
                endforeach;
                ?>
                </tbody>
            </table>
            <div class="limpopo-silvio-2">
                <span><?php
                    if(DBKwanzar::CheckConfig($id_db_settings) == false || DBKwanzar::CheckConfig($id_db_settings)['PadraoAGT'] == null || DBKwanzar::CheckConfig($id_db_settings)['PadraoAGT'] == 2):
                        require("./_SystemWoW/footer-invoice-geral-w.inc.php");
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

                    <?php if(!empty($k['settings_nib']) && !empty($k['settings_iban']) && !empty($k['settings_swift'])): ?>
                        <label class="Uno ap">
                            <span>BANCO</span>
                            <p><?= $k['settings_banco'] ?></p>
                        </label>
                        <label class="Uno">
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

                    <div class="nota-silvio">
                        <?php
                        require("./_SystemWoW/Obs.invoice.inc.php");
                        ?>
                    </div>
                </div>

                <div class="cripton-silvio-b">
                    <table class="spec">
                        <tr><td>Total Iliquido</td> <td><?php echo str_replace(",", ".", number_format($total_preco, 2)); ?></td></tr>
                        <tr><td>Desconto Comercial</td> <td><?php echo str_replace(",", ".", number_format($total_desconto, 2));  ?></td></tr>
                        <tr><td>Desconto Financeiro (<?= str_replace(",", ".", number_format($k['settings_desc_financ'], 1)); ?>%)</td> <td><?= str_replace(",", ".",number_format($descont_f, 2)); ?></td></tr>
                        <tr><td>Total de Imposto</td> <td><?php echo str_replace(",", ".", number_format($totol_iva, 2)); ?></td></tr>
                        <?php if($k['method'] == 'NU' && $k['InvoiceType'] != 'PP'): ?>
                            <tr><td>Pagou</td> <td><?= str_replace(",", ".", number_format($p['pagou'] ,2)); ?></td></tr>
                            <tr><td>Troco</td> <td><?= str_replace(",", ".", number_format($p['troco'] ,2)); ?></td></tr>
                        <?php endif; ?>
                        <tr><td>Retenção (<?= str_replace(",", ".", number_format($k['RetencaoDeFonte'], 1)) ?>%)</td> <td><?php if($k['IncluirNaFactura'] == 2): ?><?php echo number_format($Retencao, 2);  ?><?php  endif; ?></td></tr>
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
    ?>
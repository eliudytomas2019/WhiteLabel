<?php
$DB = new DBKwanzar();
?>
<div class="boleto" style="width: <?php if($DB->CheckCpanelAndSettings($id_db_settings)['atividade'] != 2 && DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Impression'] == 'A4'): DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Impression']; else: echo 72; endif; ?>mm!important;">
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
    $Si          = 0;
    $So          = 0;
    $total_service = 0;
    $p = array();

    if(DBKwanzar::CheckConfig($id_db_settings)['JanuarioSakalumbu'] == null): $ttt = 2; else: $ttt = DBKwanzar::CheckConfig($id_db_settings)['JanuarioSakalumbu']; endif;
    $suspenso = 0;

    if($year <= "2020" && $mondy <= "08"):
        $InBody = '';
        $InHead = '';
    else:
        $InHead = "AND sd_billing.InvoiceType=:In AND sd_billing_pmp.InvoiceType=:In";
        $InBody = "&In={$InvoiceType}";
    endif;

    $read->ExeRead("sd_billing, sd_billing_pmp", "WHERE sd_billing.id_db_settings=:i AND sd_billing.suspenso=:s AND sd_billing.status=:st AND sd_billing.numero=:n AND sd_billing_pmp.numero=:n AND sd_billing_pmp.status=:st AND sd_billing_pmp.id_db_settings=:i {$InHead}", "i={$id_db_settings}&s={$suspenso}&st={$ttt}&n={$Number}{$InBody}");

    if($read->getResult()):
        $k = $read->getResult()[0];
        ?>
        <?php if(DBKwanzar::CheckConfig($id_db_settings)['IncluirCover'] == null || DBKwanzar::CheckConfig($id_db_settings)['IncluirCover'] == 2): ?><img src="./uploads/<?php if($k['settings_logotype'] == null || $k['settings_logotype'] == null): echo $Index['logotype']; else: echo $k['settings_logotype']; endif;  ?>" class="logotype-invoice-2" style="margin: 1px auto!important;align-content: center!important;align-items: center!important;align-self: center!important;"/><?php endif; ?>
        <div class="header-boleto">
            <p><?= $k['settings_empresa']; ?></p>
            <p>NIF: <?= $k['settings_nif']; ?></p>
            <p><?= $k['settings_endereco']; ?></p>
            <p><?= $k['settings_telefone']; ?></p>
            <p><?= $k['settings_email']; ?></p>
            <p><?= $k['settings_website']; ?></p>
            <p><?php if($k['InvoiceType'] == 'PP'): echo "Factura Pró-forma "; elseif($k['InvoiceType'] == 'FT'): echo 'Factura '; else: echo 'Factura/Recibo '; endif; ?> </p>
            <p>Número de Factura</p>
            <p><?= $k['InvoiceType']." ".$k['mes'].$k['Code'].$k['ano']."/".$k['numero']; if(Strong::Config($id_db_settings)['JanuarioSakalumbu'] == 2 || DBKwanzar::CheckConfig($id_db_settings)['JanuarioSakalumbu'] == '' || Strong::Config($id_db_settings)['JanuarioSakalumbu'] == null): echo '&nbsp;MODO DE INSTRUÇÃO, ESSE DOCUMENTO NÃO É VÁLIDO'; endif; ?></p>
            <p>Data de Emissão: <?= $k['ano']."-".$k['mes']."-".$k['dia'] ?></p>
            <p>Operador: <?= $k['username'] ?></p>

            <p class="Lu">Moeda: (<?= $k['settings_moeda']; ?>)</p>

            <title><?= $k['InvoiceType']." ".$k['mes'].$k['Code'].$k['ano']."_".$k['numero'];  ?></title>
            <?php
                $DB = new DBKwanzar();
                if($DB->CheckCpanelAndSettings($id_db_settings, $id_db_kwanzar)['atividade'] == 2 || $DB->CheckCpanelAndSettings($id_db_settings, $id_db_kwanzar)['atividade'] == 3):
                    $Read = new Read();
                    $Read->ExeRead("cv_mesas", "WHERE id=:i", "i={$k['id_mesa']}");
                    if($Read->getResult()): ?>  <p class="Lu">Local: <?= $Read->getResult()[0]['name']; ?></p> <?php endif;
                    $Read->ExeRead("cv_garcom", "WHERE id=:i", "i={$k['id_garcom']}");
                    if($Read->getResult()): ?>  <p class="Lu">Atendente: <?= $Read->getResult()[0]['name']; ?></p> <?php endif;
                endif;
            ?>
        </div>
        <div class="body-boleto table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Descrição</th>
                        <th>Desc(%)</th>
                        <th>Taxa(%)</th>
                        <th>Valor</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    foreach($read->getResult() as $key):
                        extract($key);
                        $p = $key;

                        $value = $key['quantidade_pmp'] * $key['preco_pmp'] ;
                        $iva = ($value * $key['taxa']) / 100;
                        if($key['desconto_pmp'] >= 100):
                            $desconto = $key['desconto_pmp'];
                        else:
                            $desconto = ($value * $key['desconto_pmp']) / 100;
                        endif;
                        //$desconto = ($value * $key['desconto_pmp']) / 100;
                        $valor = $value;

                        $totol_iva += $iva;
                        $total_desconto += $desconto;
                        $total_valor += $valor;
                        $total_preco += $value;

                        if($key['taxa'] == 0):
                            $n += 1;
                            $g = "Isento";
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

                        if($key['product_type'] == "S"):
                            $total_service += $value;
                        endif;
                        ?>
                        <tr>
                            <td>
                                <?= $key['product_name'] ?>
                                <?php if(DBKwanzar::CheckConfig($id_db_settings) == false || DBKwanzar::CheckConfig($id_db_settings)['PadraoAGT'] == null || DBKwanzar::CheckConfig($id_db_settings)['PadraoAGT'] == 2): ?><?php if($key['taxa'] == 0): echo ' <small>('.$n.')</small>'; endif; ?><?php endif; ?><br/>
                                <?php if($key['taxa'] == 0): ?><small style="font-size: 7pt!important;"><?= $key['TaxExemptionReason']; ?></small><br/><?php endif; ?>
                                <small><?= $key['product_list']; ?></small><br/>
                                <?= str_replace(",", ".", number_format($key['quantidade_pmp'], 2)) ?> x <?= str_replace(",", ".", number_format($key['preco_pmp'], 2));  ?>
                            </td>
                            <td><?= str_replace(",", ".", number_format($key['desconto_pmp'], 2));  ?></td>
                            <td><?= str_replace(",", ".", number_format($key['taxa'], 2));  ?> <?php if(DBKwanzar::CheckConfig($id_db_settings) == false || DBKwanzar::CheckConfig($id_db_settings)['PadraoAGT'] == null || DBKwanzar::CheckConfig($id_db_settings)['PadraoAGT'] == 2): ?><?php if($key['taxa'] == 0): echo "(".$key['TaxExemptionCode'].")"; endif; ?><?php endif; ?></td>
                            <td><?= str_replace(",", ".", number_format($valor, 2));  ?></td>
                        </tr>
                        <?php
                    endforeach;

                /*$descont_f = ($total_preco * $k['settings_desc_financ']) / 100;
                $total_geral = ($total_valor - ($descont_f + $total_desconto)) + $totol_iva;

                if($k['IncluirNaFactura'] == 2):
                    $Retencao = ($total_geral * $k['RetencaoDeFonte']) / 100;
                endif;*/

                if($k['IncluirNaFactura'] == 2):
                    $Retencao = ($total_service * $k['RetencaoDeFonte']) / 100;
                else:
                    $Retencao = 0;
                endif;

                $descont_f = ($total_preco * $k['settings_desc_financ']) / 100;
                $total_geral = ($total_valor - ($descont_f + $total_desconto + $Retencao)) + $totol_iva;
                ?>
                </tbody>
            </table>

            <?php if(DBKwanzar::CheckConfig($id_db_settings) == false || DBKwanzar::CheckConfig($id_db_settings)['PadraoAGT'] == null || DBKwanzar::CheckConfig($id_db_settings)['PadraoAGT'] == 2): ?>
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

            <table class="spec">
                <tr><td>Total Ilíquido</td> <td><?php echo str_replace(",", ".", number_format($total_preco, 2)); ?></td></tr>
                <tr><td>Desconto Comercial</td> <td><?php echo str_replace(",", ".", number_format($total_desconto, 2));  ?></td></tr>
                <tr><td>Desconto Financeiro (<?= str_replace(",", ".", number_format($k['settings_desc_financ'], 2)); ?>%):</td> <td><?= str_replace(",", ".", number_format($descont_f, 2)); ?></td></tr>
                <tr><td>Total de Imposto</td> <td><?php echo str_replace(",", ".", number_format($totol_iva, 2)); ?></td></tr>
                <?php if($k['method'] == 'NU' && $k['InvoiceType'] != 'PP'): ?>
                    <tr><td>Pagou</td> <td><?= str_replace(",", ".", number_format($p['pagou'] ,2)); ?></td></tr>
                    <tr><td>Troco</td> <td><?= str_replace(",", ".", number_format($p['troco'] ,2)); ?></td></tr>
                <?php endif; ?>
                <?php if($k['IncluirNaFactura'] == 2): ?> <tr><td>Retenção na Fonte (<?= str_replace(",", ".", number_format($k['RetencaoDeFonte'], 1)) ?>%)</td> <td><?php echo number_format($Retencao, 2);  ?></td></tr> <?php  endif; ?>
                <tr class="total"><td>Total</td> <td><?php echo str_replace(",", ".", number_format($total_geral ,2))." ".$k['settings_moeda'];  ?></td></tr>
            </table>

            <div class="header-boleto">
                <p><?= $k['customer_name'] ?></p>
                <p><?php if($k['customer_nif'] == null || $k['customer_nif'] == '' || $k['customer_nif'] == '999999999'): echo "Consumidor final"; else: echo $k['customer_nif']; endif; ?></p>
                <p><?= $k['customer_endereco'] ?></p>

                <?php
                if(DBKwanzar::CheckConfig($id_db_settings) == false || DBKwanzar::CheckConfig($id_db_settings)['PadraoAGT'] == null || DBKwanzar::CheckConfig($id_db_settings)['PadraoAGT'] == 2):
                    require("./_SystemWoW/Obs.invoice.inc.php");
                    require("./_SystemWoW/footer-invoice-geral.inc.php");
                endif;
                ?>
            </div>
        </div>
        <?php
    endif;
    ?>
</div>

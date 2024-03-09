<?php
$Total_sI = 0;
$Total_I  = 0;
$Si          = 0;
$So          = 0;
?>
<div class="newA4">
    <?php
    $n = 0;
    $g = null;
    $iva_i = 0;
    $Aiko = "";
    $totol_iva = 0;
    $total_desconto = 0;
    $total_valor = 0;
    $total_service = 0;
    $total_preco = 0;
    $total_geral = 0;
    $Sp          = 0;
    $p = array();

    $n1 = "sd_retification";
    $n2 = "sd_retification_pmp";

    if(DBKwanzar::CheckConfig($id_db_settings)['JanuarioSakalumbu'] == null): $ttt = 2; else: $ttt = DBKwanzar::CheckConfig($id_db_settings)['JanuarioSakalumbu']; endif;
    $suspenso = 0;

    $t_gX01 = 0;

    $n4 = "sd_retification_pmp";
    $read->ExeRead("{$n4}", "WHERE id_db_settings=:i AND session_id=:idd AND status=:st AND id_invoice=:nn AND SourceBilling=:sc", "i={$id_db_settings}&idd={$id_user}&st={$ttt}&nn={$invoice_id}&sc={$SourceBilling}");
    if($read->getResult()):
        foreach($read->getResult() as $ey):
            $value = $ey['quantidade_pmp'] * $ey['preco_pmp'];
            $desconto = ($value * $ey['desconto_pmp']) / 100;
            $imposto  = ($value * $ey['taxa']) / 100;

            $t_gX01 += ($value - $desconto) + $imposto;
        endforeach;
    endif;

    $read->ExeRead("{$n1}, {$n2}", "WHERE {$n1}.id_db_settings=:i AND {$n1}.InvoiceType=:In AND {$n1}.status=:st AND {$n1}.numero=:n AND {$n2}.numero=:n AND {$n2}.status=:st AND {$n2}.id_db_settings=:i AND {$n2}.InvoiceType=:In", "i={$id_db_settings}&In={$InvoiceType}&st={$ttt}&n={$Number}");

    if($read->getResult()):
        $k = $read->getResult()[0];
        POS::Timers($k['numero'], $InvoiceType);
        ?>
        <title><?= $k['InvoiceType']." ".$k['mes'].$k['Code'].$k['ano']."_".$k['numero'];  ?></title>

        <div class="newA4reader">
            <?php if(DBKwanzar::CheckConfig($id_db_settings)['IncluirCover'] == null || DBKwanzar::CheckConfig($id_db_settings)['IncluirCover'] == 2): ?><img src="./uploads/<?php if($k['settings_logotype'] == null || $k['settings_logotype'] == null): echo $Index['logotype']; else: echo $k['settings_logotype']; endif;  ?>" class="logotype-invoice" style="max-height: 100px!important;max-width: 180px!important;"/><?php endif; ?>
            <div class="A4-getMe">
                <div class="A4-left">
                    <h2><?= $k['settings_empresa']; ?></h2>
                    <p><span>Endereço:</span> <?= $k['settings_endereco']; ?></p>
                    <p><span>Contribuinte:</span> <?= $k['settings_nif']; ?></p>
                    <p><span>Telefone:</span> <?= $k['settings_telefone']; ?></p>
                    <p><span>Email:</span> <?= $k['settings_email']; ?></p>
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
                <h1 class="header-one pussy"><?php if($k['InvoiceType'] == 'RG'): echo "Recibo "; endif; ?> <?= $k['InvoiceType']." ".$k['mes'].$k['Code'].$k['ano']."/".$k['numero']; if(Strong::Config($id_db_settings)['JanuarioSakalumbu'] == 2 || DBKwanzar::CheckConfig($id_db_settings)['JanuarioSakalumbu'] == '' || Strong::Config($id_db_settings)['JanuarioSakalumbu'] == null): echo '&nbsp;MODO DE INSTRUÇÃO, ESSE DOCUMENTO NÃO É VÁLIDO'; endif; ?> </h1>


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

        <div class="newA4-body">
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

                    $Sp += $iva;
                endforeach;

                /*$descont_f = ($total_preco * $k['settings_desc_financ']) / 100;


                if($k['IncluirNaFactura'] == 2):
                    $Retencao = ($k['r'] * $k['RetencaoDeFonte']) / 100;
                    $total_geral = ($total_valor - ($descont_f + $total_desconto)) + ($totol_iva + $Retencao);
                else:
                    $total_geral = ($total_valor - ($descont_f + $total_desconto)) + $totol_iva;
                endif;*/

                if($k['IncluirNaFactura'] == 2):
                    $Retencao = ($total_service * $k['RetencaoDeFonte']) / 100;
                else:
                    $Retencao = 0;
                endif;

                $descont_f = ($total_preco * $k['settings_desc_financ']) / 100;
                $total_geral = ($total_valor - ($descont_f + $total_desconto + $Retencao)) + $totol_iva;
                ?>
            <?php $px1 = $k['f'] - $t_gX01; ?>

            <div class="GotMe">
                <p class="jud">
                    <strong>Total da Factura</strong>: <?= number_format($k['f'], 2)?>
                </p>
                <p class="jud">
                    <strong>Total do Imposto</strong>: <?= number_format($Sp, 2)?>
                </p>
                <?php if($k['IncluirNaFactura'] == 2): ?><p class="jud">
                    <strong>Retenção na Fonte (<?= number_format($k['RetencaoDeFonte'], 1) ?>%):</strong> <?php echo number_format($Retencao, 2);  ?>
                    </p><?php  endif; ?>
                <p class="jud">
                    <strong>Valor do Recibo</strong>: <?= number_format($k['r'], 2)?>
                </p>
                <p class="jud">
                    <strong>Valor em Falta</strong>: <?= number_format($px1, 2); ?>
                </p>
                <p class="smile">Recebemos do(s) Exmo.(s) Sr.(s) <strong><?= $k['customer_name']; ?></strong>, a quantia de <?= str_replace(",", ".", number_format($total_geral, 2))." ".$k['settings_moeda']; ?> através de <?php if($k['method'] == 'CC'): echo 'Cartão de Credito'; elseif($k['method'] == 'CD'): echo 'Cartão de Debito'; elseif($k['method'] == 'CH'): echo 'Cheque Bancário'; elseif($k['method'] == 'NU'): echo 'Numerário'; elseif ($k['method'] == 'TB'): echo 'Transferência Bancária'; elseif($k['method'] == 'OU'): echo 'Outros Meios Aqui não Assinalados'; endif; ?>.</p>
            </div>
        </div>

        <?php
    endif;
    ?>

    <div class="newA4-footer">
        <div class="A4-getMe">
            <div class="footer-left">
                <?php if(DBKwanzar::CheckConfig($id_db_settings) == false || DBKwanzar::CheckConfig($id_db_settings)['PadraoAGT'] == null || DBKwanzar::CheckConfig($id_db_settings)['PadraoAGT'] == 2): ?><p class="jud">Respeitosos cumprimentos,</p><?php endif; ?>
                <?php
                if(DBKwanzar::CheckConfig($id_db_settings) == false || DBKwanzar::CheckConfig($id_db_settings)['PadraoAGT'] == null || DBKwanzar::CheckConfig($id_db_settings)['PadraoAGT'] == 2):
                    require("./_SystemWoW/Obs.invoice.inc.php");
                endif;
                ?>
                <p class="porn">
                    _________________________<br/>
                    Assinatura
                </p>
            </div>

            <div class="footer-right">
                <?php
                if(DBKwanzar::CheckConfig($id_db_settings) == false || DBKwanzar::CheckConfig($id_db_settings)['PadraoAGT'] == null || DBKwanzar::CheckConfig($id_db_settings)['PadraoAGT'] == 2):
                    require("./_SystemWoW/footer-geral.inc.php");
                endif;
                ?>
            </div>
        </div>
    </div>
</div>

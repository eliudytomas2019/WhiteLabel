<?php
$file = "Extract_".time();

$read = new Read();
$read->ExeRead("db_settings", "WHERE id=:i", "i={$id_db_settings}");

if($read->getResult()):
$k = $read->getResult()[0];
?>

<div class="header">
    <img src="./uploads/<?php if($k['logotype'] == null || $k['logotype'] == null): echo $Index['logotype']; else: echo $k['logotype']; endif;  ?>" class="img-silvio"/>
    <div class="header-silvio">
        <div class="header-silvio-a">
            <div class="A4-left">
                <h2><?= $k['empresa']; ?></h2>
                <p><span>NIF:</span> <?= $k['nif']; ?></p>
                <p class="website"><span>Website:</span> <?= $k['website']; ?></p>
                <p><span>E-MAIL:</span> <?= $k['email']; ?></p>
                <p><span>Endereço:</span> <?= $k['endereco']; ?></p>
                <p><span>Telefone:</span> <?= $k['telefone']; ?></p>
            </div>
        </div>
        <div class="header-silvio-b">
            <h4>Exmo.(s) Sr.(s)</h4>
            <?php
                if($Customers_id == "all"):
                    ?>
                    <span>Todos os clientes</span>
                    <span>Consumidor final</span>
                    <span>Consumidor final</span>
                    <?php
                else:
                    $Read = new Read();
                    $Read->ExeRead("cv_customer", "WHERE id=:i ", "i={$Customers_id}");

                    if($Read->getResult()):
                        $customer = $Read->getResult()[0];
                        ?>
                        <span><?= $customer['nome']; ?></span>
                        <span><?php if($customer['nif'] == null || $customer['nif'] == '' || $customer['nif'] == '999999999'): echo "Consumidor final"; else: echo $customer['nif']; endif; ?></span>
                        <span><?= $customer['endereco'] ?></span>
                        <span><?= $customer['addressDetail'] ?></span>
                        <?php
                    endif;
                endif;
            ?>
        </div>
    </div>
    <div class="limpopo-silvio">
        <h1>EXTRATO DE CONTA CORRENTE</h1>

        <span></span>
    </div>
    <table class="">
        <thead>
        <tr>
            <th>Moeda</th>
            <th>Data de Emissão</th>
            <th>Hora de Emissão</th>
            <th>Operador</th>
            <th>Página</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td><?= DBKwanzar::CheckConfig($id_db_settings)['moeda']; ?></td>
            <td><?= date('d/m/Y'); ?></td>
            <td><?= date('H:i'); ?></td>
            <td><?= $userlogin['name'] ?></td>
            <td><span class="page"></span></td>
        </tr>
        </tbody>
    </table>
</div>
<?php endif; ?>

<div class="table-silvio">
    <table class="table table-responsive">
        <thead style="text-align: center!important;font-weight: bold!important;color: #000!important;">
        <tr>
            <th>Data</th>
            <th>Documento</th>
            <th>Valor</th>
            <th>Depositado</th>
            <th>Saldo</th>
            <th>Status</th>
        </tr>
        </thead>
        <tbody style="text-align: center!important;">
        <?php
        $total_geral_saldo = 0;
        $total_geral_divida = 0;
        $total_geral_pago = 0;

        $nx1 = 0;
        $nx2 = 0;
        $nx3 = 0;
        $nx4 = 0;
        $nx5 = 0;
        $nx6 = 0;

        $suspenso = 0;
        $inv = "FT";

        if(DBKwanzar::CheckConfig($id_db_settings)['JanuarioSakalumbu'] == null): $ttt = 2; else: $ttt = DBKwanzar::CheckConfig($id_db_settings)['JanuarioSakalumbu']; endif;

        if(isset($dateI) && isset($dateF) && !empty($dateI) && !empty($dateF)):
            $f    = explode("-", $dateF);
            $i    = explode("-", $dateI);
            $date = " AND sd_billing.dia BETWEEN {$i[2]} AND {$f[2]} AND sd_billing.mes BETWEEN {$i[1]} AND {$f[1]} AND sd_billing.ano BETWEEN {$i[0]} AND {$f[0]} ";
        else:
            $date = null;
        endif;

        if($Customers_id  == "all"): $clientes = null; else: $clientes = " AND sd_billing.id_customer='{$Customers_id}' "; endif;

        if($method_id == "all"):
            $method = null;
            $v = null;
        else:
            $method  = " AND sd_billing.method='{$method_id}' ";
            $v = "&m=".$method_id;
        endif;

        $n3 = "sd_billing_pmp";
        $n2 = "sd_retification";
        $n4 = "sd_retification_pmp";
        $n5 = "sd_guid";
        $n6 = "sd_guid_pmp";
        $PPs = "'PP'";

        if(DBKwanzar::CheckConfig($id_db_settings) == false || Strong::Config($id_db_settings)['JanuarioSakalumbu'] == 3 || Strong::Config($id_db_settings)['JanuarioSakalumbu'] == '' || Strong::Config($id_db_settings)['JanuarioSakalumbu'] == null):
            $st = 3;
        else:
            $st = 2;
        endif;

        $s = 0;

        $Read = new Read();
        $Read->ExeRead("sd_billing", "WHERE sd_billing.id_db_settings=:i AND sd_billing.InvoiceType=:inv AND sd_billing.suspenso=:s AND sd_billing.status=:st {$date} {$clientes} {$method} ORDER BY sd_billing.id DESC", "i={$id_db_settings}&inv={$inv}&s={$suspenso}&st={$ttt}");

        if($Read->getResult()):
            foreach ($Read->getResult() as $key):
                $nx1 += 1;
                $t_v = 0;
                $t_g = 0;

                $read = new Read();
                $read->ExeRead("{$n3}", "WHERE id_db_settings=:i AND status=:st AND numero=:nn AND SourceBilling=:sc AND InvoiceType=:itt", "i={$id_db_settings}&st={$st}&nn={$key['numero']}&sc={$key['SourceBilling']}&itt={$key['InvoiceType']}");
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

                $read->ExeRead("{$n4}", "WHERE id_db_settings=:i  AND status=:st AND id_invoice=:nn AND SourceBilling=:sc", "i={$id_db_settings}&st={$st}&nn={$key['id']}&sc={$key['SourceBilling']}");
                if($read->getResult()):
                    foreach($read->getResult() as $ey):
                        extract($ey);

                        $value = $ey['quantidade_pmp'] * $ey['preco_pmp'];
                        $desconto = ($value * $ey['desconto_pmp']) / 100;
                        $imposto  = ($value * $ey['taxa']) / 100;

                        $t_g += ($value - $desconto) + $imposto;
                    endforeach;
                endif;

                $saldo = $t_g - $t_v;

                $total_geral_divida += $t_g;
                $total_geral_pago += $saldo;
                $total_geral_saldo += $t_v;
                ?>
                <tr>
                    <td><?= $key['dia']."/".$key['mes']."/".$key['ano']; ?></td>
                    <td><?= $key['InvoiceType']." ".$key['mes']."".$key['Code']."".$key['ano']."/".$key['numero']; ?></td>
                    <td><?= str_replace(",", ".",number_format($t_v, 2)); ?></td>
                    <td><?= str_replace(",", ".",number_format($t_g, 2)); ?></td>
                    <td><?= str_replace(",", ".",number_format($saldo, 2)); ?></td>
                    <td>
                        <?php
                        if($t_g >= $t_v):
                            if($ey['InvoiceType'] == "NC"):
                                $nx5 += 1;
                                ?>
                                <label class="warning">Anulado</label>
                            <?php
                            else:
                                $nx2 += 1;
                                ?>
                                <label class="success">Pago</label>
                            <?php
                            endif;
                        elseif($t_v > $t_g && $t_g != 0):
                            if($ey['InvoiceType'] == "NC"):
                                $nx6 += 1;
                                ?>
                                <label class="warning">Parcialmente Anulado</label>
                            <?php
                            else:
                                $nx3 += 1;
                                ?>
                                <label class="yellon">Parcialmente Pago</label>
                            <?php
                            endif;
                        else:
                            $nx4 += 1;
                            ?>
                            <label class="danger">Por Pagar</label>
                        <?php
                        endif;
                        ?>
                    </td>
                </tr>
            <?php
            endforeach;
        endif;
        ?>
        </tbody>
        <tfoot>
        <tr>
            <th colspan="2"></th>
            <th><?= str_replace(",", ".",number_format($total_geral_saldo, 2)); ?></th>
            <th><?= str_replace(",", ".",number_format($total_geral_divida, 2)); ?></th>
            <th><?= str_replace(",", ".",number_format($total_geral_pago, 2)); ?></th>
            <th></th>
        </tr>
        </tfoot>
    </table>
    <div class="limpopo-silvio-2">
        <span><?php
            if(DBKwanzar::CheckConfig($id_db_settings) == false || DBKwanzar::CheckConfig($id_db_settings)['PadraoAGT'] == null || DBKwanzar::CheckConfig($id_db_settings)['PadraoAGT'] == 2):
                require("./_SystemWoW/footer-invoice-geral-w.inc.php");
            endif;
            ?></span>
    </div>
</div>


<div class="footer-small">
    <div class="cripton-silvio">
        <div class="cripton-silvio-a">
            <h2>Detalhes bancários</h2>

            <?php if(!empty($k['settings_banco'])): ?>
                <label class="Uno ap">
                    <span>BANCO</span>
                    <p><?= $k['settings_banco'] ?></p>
                </label>
            <?php endif;  ?>

            <?php if(!empty($k['nib'])): ?>
                <label class="Uno">
                    <span>CONTA/NIB</span>
                    <p><?= $k['nib'] ?></p>
                </label>
            <?php endif;  ?>

            <?php if(!empty($k['iban'])): ?>
                <label class="Uno">
                    <span>IBAN</span>
                    <p><?= $k['iban'] ?></p>
                </label>
            <?php endif;  ?>

            <?php if(!empty($k['swift'])): ?>
                <label class="Uno af">
                    <span>SWIFT/BIC</span>
                    <p><?= $k['swift'] ?></p>
                </label>
            <?php endif;  ?>

            <div class="nota-silvio">
                <?php
                require("./_SystemWoW/Obs.invoice.inc.php");
                ?>
            </div>
        </div>

        <div class="cripton-silvio-b">
            <table class="spec">
                <tr><td>TOTAL:</td> <td><?= $nx1; ?></td></tr>
                <tr><td>LIQUIDADOS:</td> <td><?= $nx2; ?></td></tr>
                <tr><td>PARCIALMENTE LIQUIDADOS:</td> <td><?= $nx3; ?></td></tr>
                <tr><td>ANULADOS:</td> <td><?= $nx5; ?></td></tr>
                <tr><td>PARCIALMENTE ANULADOS:</td> <td><?= $nx6; ?></td></tr>
                <tr><td>POR LIQUIDAR:</td> <td><?= $nx4; ?></td></tr>
            </table>

            <div class="total-silvio">
                <p>SALDO (<?= DBKwanzar::CheckConfig($id_db_settings)['moeda']; ?>) <?= str_replace(",", ".",number_format($total_geral_pago, 2)) ?></p>
            </div>
        </div>
    </div>
</div>

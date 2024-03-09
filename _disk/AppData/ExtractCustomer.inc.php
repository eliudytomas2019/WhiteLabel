<?php
require_once("../../Config.inc.php");

$id_db_settings= strip_tags(trim($_POST['id_db_settings']));

$Customers_id  = strip_tags(trim($_POST['Customers_id']));
$dateI         = strip_tags(trim($_POST['dateI']));
$dateF         = strip_tags(trim($_POST['dateF']));
$method_id     = strip_tags(trim($_POST['method_id']));

?>

<div class="styles">
    <a href="pdf.php?action=167435&dateI=<?= $dateI; ?>&dateF=<?= $dateF; ?>&id_db_settings=<?= $id_db_settings; ?>&Customers_id=<?= $Customers_id ?>&method_id=<?= $method_id; ?>" class="bol bol-default bol-sm btn btn-primary btn-sm" target="_blank">Imprimir</a><br/>
</div>

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
        $total_anulado = 0;

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
                $total_geral_saldo += $t_v;
                $total_geral_pago += $saldo;
                ?>
                <tr>
                    <td><?= $key['dia']."/".$key['mes']."/".$key['ano']; ?></td>
                    <td><?= $key['InvoiceType']." ".$key['mes']."".$key['Code']."".$key['ano']."/".$key['numero']; ?></td>
                    <td style="text-align: right!important;"><?= str_replace(",", ".",number_format($t_v, 2)); ?></td>
                    <td style="text-align: right!important;"><?= str_replace(",", ".",number_format($t_g, 2)); ?></td>
                    <td style="text-align: right!important;"><?= str_replace(",", ".",number_format($saldo, 2)); ?></td>
                    <td style="text-align: right!important;">

                        <?php
                        if($t_g >= $t_v):
                            if($ey['InvoiceType'] == "NC"):
                                ?>
                                <label class="warning">Anulado</label>
                                <?php
                            else:
                                ?>
                                <label class="success">Pago</label>
                                <?php
                            endif;
                        elseif($t_v > $t_g && $t_g != 0):
                            if($ey['InvoiceType'] == "NC"):
                                ?>
                                <label class="warning">Parcialmente Anulado</label>
                                <?php
                            else:
                                ?>
                                <label class="yellon">Parcialmente Pago</label>
                                <?php
                            endif;
                        else:
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
            <th style="text-align: right!important;"><?= str_replace(",", ".",number_format($total_geral_saldo, 2)); ?></th>
            <th style="text-align: right!important;"><?= str_replace(",", ".",number_format($total_geral_divida, 2)); ?></th>
            <th style="text-align: right!important;"><?= str_replace(",", ".",number_format($total_geral_pago, 2)); ?></th>
            <th></th>
        </tr>
    </tfoot>
</table>

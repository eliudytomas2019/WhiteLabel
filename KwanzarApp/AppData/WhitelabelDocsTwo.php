<?php
require_once("../../Config.inc.php");

$dateI         = strip_tags(trim($_POST['dateI']));
$dateF         = strip_tags(trim($_POST['dateF']));
$id_db_settings= strip_tags(trim($_POST['id_db_settings']));


$f    = explode("-", $dateF);
$i    = explode("-", $dateI);
$date = " AND sd_billing.dia BETWEEN {$i[2]} AND {$f[2]} AND sd_billing.mes BETWEEN {$i[1]} AND {$f[1]} AND sd_billing.ano BETWEEN {$i[0]} AND {$f[0]} ";

?>
<div class="styles">
    <a href="print.php?action=082022&dateI=<?= $dateI; ?>&dateF=<?= $dateF; ?>&id_db_settings=<?= $id_db_settings; ?>" class="bol bol-default bol-sm btn btn-primary btn-sm" target="_blank">Imprimir</a>
</div>

<table class="table table-responsive">
    <thead>
    <tr>
        <th>Descrição</th>
        <th>Qtd</th>
        <th>Preço Uni.</th>
        <th>Desc%</th>
        <th>Imposto%</th>
        <th>Total</th>
    </tr>
    </thead>
    <tbody>
        <?php
            if(DBKwanzar::CheckConfig($id_db_settings)['JanuarioSakalumbu'] == null): $ttt = 2; else: $ttt = DBKwanzar::CheckConfig($id_db_settings)['JanuarioSakalumbu']; endif;
            $a = "PP";
            $documentos = " AND sd_billing.InvoiceType!=:a AND sd_billing_pmp.InvoiceType=sd_billing.InvoiceType ";


            $t_incidencia = 0;
            $t_descontos = 0;
            $t_impostos = 0;
            $t_geral = 0;
            $suspenso = 0;
            $line = 0;

            $t_qtd = 0;
            $_pricing = 0;

            $Read = new Read();
            $Read->ExeRead("cv_product", "WHERE id_db_settings=:i", "i={$id_db_settings}");

            if($Read->getResult()):
                foreach ($Read->getResult() as $item):
                    $g = null;
                    $Action = "a={$a}&st={$ttt}&s={$suspenso}&{$g}";
                    $Where  = "WHERE sd_billing.id_db_settings={$id_db_settings} AND sd_billing_pmp.id_product={$item['id']} AND sd_billing_pmp.id_db_settings=sd_billing.id_db_settings  {$documentos} AND sd_billing.status=:st AND sd_billing.suspenso=:s  {$date} AND sd_billing.numero=sd_billing_pmp.numero ORDER BY sd_billing.numero DESC ";

                    $qtd = 0;
                    $desc = 0;
                    $impos = 0;
                    $total = 0;

                    $Read->ExeRead("sd_billing, sd_billing_pmp", $Where, $Action);
                    if($Read->getResult()):
                        $line += 1;
                        foreach ($Read->getResult() as $key):
                            $value    = $key['quantidade_pmp'] * $key['preco_pmp'];
                            $imposto  = ($key['preco_pmp'] * $key['taxa']) / 100;
                            if($key['desconto_pmp'] >= 100):
                                $desconto = $key['desconto_pmp'];
                            else:
                                $desconto = ($value * $key['desconto_pmp']) / 100;
                            endif;
                            $total    += ($value - $desconto) + $imposto;

                            $t_descontos += $desconto;
                            $t_impostos += $imposto;
                            $t_incidencia += $value;
                            $t_geral += $total;

                            $qtd += $key['quantidade_pmp'];
                            $desc += $desconto;
                            $impos += $imposto;

                            $t_qtd += $key['quantidade_pmp'];
                            $_pricing += $item['preco_venda'];
                        endforeach;
                        ?>
                        <tr>
                            <td><?= $item['product']; ?></td>
                            <td><?= $qtd; ?></td>
                            <td><?= str_replace(",", ".", number_format($item['preco_venda'], 2)); ?></td>
                            <td><?= str_replace(",", ".", number_format($desc, 2)); ?></td>
                            <td><?= str_replace(",", ".", number_format($impos, 2)); ?></td>
                            <td><?= str_replace(",", ".", number_format($total, 2)); ?></td>
                        </tr>
                        <?php
                    endif;
                endforeach;
            endif;
        ?>
    </tbody>
    <tfoot>
        <tr>
            <th style="text-align: right!important;">Totais ==></th>
            <th><?= $t_qtd; ?></th>
            <th><?= str_replace(",", ".", number_format($_pricing, 2)); ?></th>
            <th><?= str_replace(",", ".", number_format($t_descontos, 2)); ?></th>
            <th><?= str_replace(",", ".", number_format($t_impostos, 2)); ?></th>
            <th><?= str_replace(",", ".", number_format($t_geral, 2)); ?> AOA</th>
        </tr>
    </tfoot>
</table>
<table class="table">
    <tfoot>
        <tr>
            <input type="hidden" id="t_total" name="t_total" value="<?= $t_geral; ?>"/>
            <th style="text-align: right!important;"><strong>Total</strong></th>
            <th>
                <strong><?= str_replace(",", ".", number_format($t_geral, 2)); ?> AOA</strong><br/>
                <small><strong><?= $line; ?></strong> itens; <strong><?= $t_qtd; ?></strong> unidade(s).</small>
            </th>
        </tr>
    </tfoot>
</table>
<?php
require_once("../../Config.inc.php");

$id_db_settings= strip_tags(trim($_POST['id_db_settings']));
$ILoja       = strip_tags(trim($_POST['ILoja']));
$id_iva       = strip_tags(trim($_POST['id_iva']));
$Itens_type      = strip_tags(trim($_POST['Itens_type']));
$Categories_id = strip_tags(trim($_POST['Categories_id']));

$value = null;
$iva = null;
$total_geral = null;
$total_qtd = null;
$total_imposto = null;
$total_preco = null;
?>
<hr/>
<div class="styles">
    <a href="print.php?action=2022&ILoja=<?= $ILoja; ?>&id_iva=<?= $id_iva; ?>&Itens_type=<?= $Itens_type; ?>&id_db_settings=<?= $id_db_settings; ?>&Categories_id=<?= $Categories_id; ?>" class="bol bol-default bol-sm btn btn-primary btn-sm" target="_blank">Imprimir</a>
</div><br/>

<table class="table table-responsive">
    <thead>
        <tr>
            <th>REF.</th>
            <th>DESCRIÇÃO</th>
            <th>QTD</th>
            <th>IMPOSTO</th>
            <th>PREÇO UNIT.</th>
            <th>TOTAL</th>
        </tr>
    </thead>
    <tbody>
    <?php
        if($Categories_id == "all"): $Link = null; $And = null; else: $Link = " id_category={$Categories_id} "; $And = " AND "; endif;
        if($ILoja == "all"): $Link2 = null;  $And1 = null; else: $Link2 = " {$And} ILoja={$ILoja} "; $And1 = " AND "; endif;

        if($id_iva == "all"):
            $Link3 = null;
            $And2 = null;
        else:
            if($And != null && $And1 == null): $And1 = "AND"; endif;
            $Link3 = " {$And1} id_iva={$id_iva} ";
            $And2 = " AND ";
        endif;

        if($Itens_type == "all"):
            $Link4 = null;
            $And3 = null;
        else:
            if($And != null && $And2 == null || $And1 != null && $And2 == null): $And2 = "AND"; endif;
            $Link4 = " {$And2} type='{$Itens_type}' ";
            $And3 = " AND ";
        endif;

        if($And != null || $And1 != null || $And2 != null || $And3 != null): $Fuck = "AND"; else: $Fuck = null; endif;

        $Where = "WHERE id_db_settings={$id_db_settings} {$Fuck} {$Link} {$Link2} {$Link3} {$Link4} ";

        $Read = new Read();
        $Read->ExeRead("cv_product", $Where);

        if($Read->getResult()):
            foreach ($Read->getResult() as $key):

                /**$DB = new DBKwanzar();
                if($DB->CheckCpanelAndSettings($id_db_settings)['atividade'] == 1 || $DB->CheckCpanelAndSettings($id_db_settings)['atividade'] == 4):
                    $NnM = $key['quantidade'];
                else:
                    $NnM = $key['gQtd'];
                endif;**/

                $NnM = $key['quantidade'];

                $value = ($NnM * $key['preco_venda']);
                $iva = ($value * $key['iva']) / 100;
                $total = ($value + $iva);
                $total_geral += $total;

                $total_qtd += $NnM;
                $total_imposto += $iva;
                $total_preco += $key['preco_venda'];
                ?>
                <tr>
                    <td><?= $key["codigo"]; ?></td>
                    <td><?= $key["product"]; ?></td>
                    <td><?= number_format($NnM, 2); ?></td>
                    <td><?= number_format($key['iva'], 2); ?>%</td>
                    <td><?= str_replace(",", ".", number_format($key['preco_venda'], 2)); ?></td>
                    <td><?= str_replace(",", ".", number_format($total, 2)); ?></td>
                </tr>
                <?php
            endforeach;
        endif;
    ?>
    </tbody>
    <tfoot>
        <tr>
            <th colspan="2" style="text-align: right!important;">TOTAL ==></th>
            <th><?= str_replace(",", ".", number_format($total_qtd, 2)); ?></th>
            <th><?= str_replace(",", ".", number_format($total_imposto, 2)); ?></th>
            <th><?= str_replace(",", ".", number_format($total_preco, 2)); ?></th>
            <th><?= str_replace(",", ".", number_format($total_geral, 2)); ?> AOA</th>
        </tr>
    </tfoot>
</table>
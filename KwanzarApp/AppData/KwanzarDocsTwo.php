<?php
require_once("../../Config.inc.php");

$id_db_settings= strip_tags(trim($_POST['id_db_settings']));
$id_user       = strip_tags(trim($_POST['id_user']));
$Function_id   = strip_tags(trim($_POST['Function_id']));
$dateI         = strip_tags(trim($_POST['dateI']));
$dateF         = strip_tags(trim($_POST['dateF']));

$suspenso = 0;

?>
<div class="styles">
    <a href="print.php?action=2021&dateI=<?= $dateI; ?>&dateF=<?= $dateF; ?>&id_user=<?= $id_user ?>&id_db_settings=<?= $id_db_settings; ?>&Function_id=<?= $Function_id; ?>" class="bol bol-default bol-sm btn btn-primary btn-sm" target="_blank">Imprimir</a>
</div>
    <table class="table table-responsive">
        <thead>
            <tr>
                <th>Item</th>
                <th>Quantidade</th>
            </tr>
        </thead>
        <tbody>
        <?php
        if(DBKwanzar::CheckConfig($id_db_settings)['JanuarioSakalumbu'] == null): $ttt = 2; else: $ttt = DBKwanzar::CheckConfig($id_db_settings)['JanuarioSakalumbu']; endif;

        $Read = new Read();
        $Read->ExeRead("cv_product", "WHERE id_db_settings=:i ORDER BY product ASC", "i={$id_db_settings}");

        if($Read->getResult()):
            foreach ($Read->getResult() as $row):
                if($Function_id   == "all"):   $funcionarios = null; else: $funcionarios = " AND sd_billing.id_user={$Function_id} "; endif;
                if(isset($dateI) && !empty($dateI)): $x1 = explode("-", $dateI); else: $x1 = explode("-", date('Y-m-d')); endif;
                if(isset($dateF) && !empty($dateF)): $x2 = explode("-", $dateF); else: $x2 = explode("-", date('Y-m-d')); endif;

                $date = " AND sd_billing.dia BETWEEN {$x1[2]} AND {$x2[2]} AND sd_billing.mes BETWEEN {$x1[1]} AND {$x2[1]} AND sd_billing.ano BETWEEN {$x1[0]} AND {$x2[0]} ";

                $Action = "st={$ttt}&s={$suspenso}&i={$row['id']}";
                $Where  = "WHERE sd_billing.id_db_settings={$id_db_settings} AND sd_billing_pmp.id_db_settings=sd_billing.id_db_settings {$date} AND id_product=:i AND sd_billing.InvoiceType='FR' AND sd_billing_pmp.InvoiceType=sd_billing.InvoiceType {$funcionarios}  AND sd_billing.status=:st AND sd_billing.suspenso=:s AND sd_billing.numero=sd_billing_pmp.numero ORDER BY sd_billing.numero DESC ";

                $Read = new Read();
                $Read->ExeRead("sd_billing, sd_billing_pmp", $Where, $Action);
                if($Read->getResult()):
                    ?>
                    <tr>
                        <td><?= $row['product'] ?></td>
                        <td><?= $Read->getRowCount() ?></td>
                    </tr>
                    <?php
                endif;
            endforeach;
        endif;
        ?>
        </tbody>
    </table>

    <table class="table">
         <?php
            if($Function_id   == "all"):   $funcionarios = null; else: $funcionarios = " AND sd_billing.id_user={$Function_id} "; endif;
            $date1 = " AND sd_retification.dia BETWEEN {$x1[2]} AND {$x2[2]} AND sd_retification.mes BETWEEN {$x1[1]} AND {$x2[1]} AND sd_retification.ano BETWEEN {$x1[0]} AND {$x2[0]} ";
            $tNC = 0;
            $tRG = 0;
            $tFT = 0;
            $tFR = 0;

            $Where  = "WHERE sd_billing.id_db_settings={$id_db_settings} AND sd_billing_pmp.id_db_settings=sd_billing.id_db_settings {$date} AND id_product=:i AND sd_billing.InvoiceType='FT' AND sd_billing_pmp.InvoiceType=sd_billing.InvoiceType  AND sd_billing.status=:st AND sd_billing.suspenso=:s {$funcionarios} AND sd_billing.numero=sd_billing_pmp.numero ORDER BY sd_billing.numero DESC ";
            $Read->ExeRead("sd_billing, sd_billing_pmp", $Where, $Action);
             if($Read->getResult()):
                 foreach ($Read->getResult() as $key):
                     $value    = $key['quantidade_pmp'] * $key['preco_pmp'];
                     $imposto  = ($key['preco_pmp'] * $key['taxa']) / 100;
                     if($key['desconto_pmp'] >= 100):
                         $desconto = $key['desconto_pmp'];
                     else:
                         $desconto = ($value * $key['desconto_pmp']) / 100;
                     endif;
                     //$desconto = ($key['preco_pmp'] * $key['desconto_pmp']) / 100;
                     $total    = ($value - $desconto) + $imposto;
                     $tFT += $total;
                 endforeach;
             endif;

         $Where  = "WHERE sd_billing.id_db_settings={$id_db_settings} AND sd_billing_pmp.id_db_settings=sd_billing.id_db_settings {$date} AND id_product=:i AND sd_billing.InvoiceType='FR' AND sd_billing_pmp.InvoiceType=sd_billing.InvoiceType  AND sd_billing.status=:st AND sd_billing.suspenso=:s {$funcionarios} AND sd_billing.numero=sd_billing_pmp.numero ORDER BY sd_billing.numero DESC ";
         $Read->ExeRead("sd_billing, sd_billing_pmp", $Where, $Action);
         if($Read->getResult()):
             foreach ($Read->getResult() as $key):
                 $value    = $key['quantidade_pmp'] * $key['preco_pmp'];
                 $imposto  = ($key['preco_pmp'] * $key['taxa']) / 100;
                 if($key['desconto_pmp'] >= 100):
                     $desconto = $key['desconto_pmp'];
                 else:
                     $desconto = ($value * $key['desconto_pmp']) / 100;
                 endif;
                 //$desconto = ($key['preco_pmp'] * $key['desconto_pmp']) / 100;
                 $total    = ($value - $desconto) + $imposto;
                 $tFR += $total;
             endforeach;
         endif;

            if($Function_id   == "all"):   $funcionarios = null; else: $funcionarios = " AND sd_retification.id_user={$Function_id} "; endif;
            $n1 = "NC";
            $Action1 = "st={$ttt}&n1={$n1}";
            $Where1  = "WHERE sd_retification.id_db_settings={$id_db_settings} AND sd_retification_pmp.id_db_settings=sd_retification.id_db_settings {$date1} AND sd_retification.InvoiceType=:n1 AND sd_retification_pmp.InvoiceType=sd_retification.InvoiceType {$funcionarios}  AND sd_retification.status=:st AND sd_retification.numero=sd_retification_pmp.numero ORDER BY sd_retification.numero DESC ";

            $Read = new Read();
            $Read->ExeRead("sd_retification, sd_retification_pmp", $Where1, $Action1);
            if($Read->getResult()):
                foreach ($Read->getResult() as $key):
                    $value    = $key['quantidade_pmp'] * $key['preco_pmp'];
                    $imposto  = ($key['preco_pmp'] * $key['taxa']) / 100;
                    if($key['desconto_pmp'] >= 100):
                        $desconto = $key['desconto_pmp'];
                    else:
                        $desconto = ($value * $key['desconto_pmp']) / 100;
                    endif;
                    //$desconto = ($key['preco_pmp'] * $key['desconto_pmp']) / 100;
                    $total    = ($value - $desconto) + $imposto;
                    $tNC += $total;
                endforeach;
            endif;

             $n2 = "RG";
             $Action2 = "st={$ttt}&n2={$n2}";
             $Where2  = "WHERE sd_retification.id_db_settings={$id_db_settings} AND sd_retification_pmp.id_db_settings=sd_retification.id_db_settings {$date1} AND sd_retification.InvoiceType=:n2 AND sd_retification_pmp.InvoiceType=sd_retification.InvoiceType {$funcionarios} AND sd_retification.status=:st AND sd_retification.numero=sd_retification_pmp.numero ORDER BY sd_retification.numero DESC ";

             $Read = new Read();
             $Read->ExeRead("sd_retification, sd_retification_pmp", $Where2, $Action2);
             if($Read->getResult()):
                 foreach ($Read->getResult() as $key):
                     $value    = $key['quantidade_pmp'] * $key['preco_pmp'];
                     $imposto  = ($key['preco_pmp'] * $key['taxa']) / 100;
                     if($key['desconto_pmp'] >= 100):
                         $desconto = $key['desconto_pmp'];
                     else:
                         $desconto = ($value * $key['desconto_pmp']) / 100;
                     endif;
                     //$desconto = ($key['preco_pmp'] * $key['desconto_pmp']) / 100;
                     $total    = ($value - $desconto) + $imposto;
                     $tRG += $total;
                 endforeach;
             endif;
        ?>
        <tr><th>Venda(s) realizada(s):</th> <th><?= number_format($tFR, 2); ?></th></tr>
        <tr><th>Venda(s) anulada(s):</th> <th><?= number_format($tFT, 2); ?></th></tr>
        <tr><th>Venda(s) a credito:</th> <th><?= number_format($tNC, 2); ?></th></tr>
        <tr><th>Dividas Paga:</th> <th><?= number_format($tRG, 2); ?></th></tr>
    </table>

    <table class="table">
        <tfoot>
            <tr>
                <th>INCIDÊNCIA: <?= number_format($tFR+$tFT+$tNC+$tNC, 2); ?></th>
                <th>VENDA(S) DO DIA: <?= number_format($tFR, 2); ?></th>
                <th>VENDA(S) A CREDITO: <?= number_format($tFT, 2); ?></th>
                <th>VENDA(S) ANULADAS: <?= number_format($tNC, 2); ?></th>
                <th>DIVIDA(S) PAGA: <?= number_format($tRG, 2); ?></th>
                <th>TOTAL: <strong><?= number_format(($tFR - $tNC) + $tRG, 2); ?> AOA</strong></th>
            </tr>
        </tfoot>
    </table>
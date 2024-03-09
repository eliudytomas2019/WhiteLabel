<table  class="table text-wrap table-responsive">
    <thead>
    <tr>
        <th style="max-width: 20%!important;">Item</th>
        <th style="max-width: 15%!important;">Qtd</th>
        <th style="max-width: 20%!important;">Preço Uni.</th>
        <th style="max-width: 15%!important;">Desc%</th>
        <th style="max-width: 10%!important;">Taxa(%)</th>
        <th style="max-width: 10%!important;">Total</th>
        <th style="max-width: 10%!important;"><i class="far fa-trash-alt"></i></th>
    </tr>
    </thead>
    <tbody>

    <?php

    if(!empty($_POST['Number'])):    $Number     = strip_tags(trim($_POST['Number'])); endif;
    if(!empty($_GET['post'])):    $Number = filter_input(INPUT_GET, "post", FILTER_VALIDATE_INT); endif;

    if(isset($_GET['id_user'])):         $id_user         = (int) filter_input(INPUT_GET, "id_user", FILTER_DEFAULT); endif;
    if(isset($_GET['id_mesa'])):         $id_mesa         = (int) filter_input(INPUT_GET, "id_mesa", FILTER_DEFAULT); endif;
    if(isset($_GET['dateI'])):           $dateI           = strip_tags(trim($_GET['dateI'])); endif;
    if(isset($_GET['dateF'])):           $dateF           = strip_tags(trim($_GET['dateF'])); endif;
    if(isset($_GET['TypeDoc'])):         $TypeDoc         = strip_tags(trim($_GET['TypeDoc'])); endif;
    if(isset($_GET['Function_id'])):     $Function_id     = strip_tags(trim($_GET['Function_id'])); endif;
    if(isset($_GET['Customers_id'])):    $Customers_id    = strip_tags(trim($_GET['Customers_id'])); endif;
    if(isset($_GET['SourceBilling'])):   $SourceBilling   = strip_tags(trim($_GET['SourceBilling'])); else: $SourceBilling = null; endif;

    if(isset($_GET['dia'])):             $day             = strip_tags(trim($_GET['dia'])); endif;
    if(isset($_GET['mes'])):             $mondy           = strip_tags(trim($_GET['mes'])); endif;
    if(isset($_GET['ano'])):             $year            = strip_tags(trim($_GET['ano'])); endif;
    if(isset($_GET['postId'])):          $postId          = strip_tags(trim($_GET['postId'])); endif;

    if(isset($_POST['InvoiceType'])):    $InvoiceType     = strip_tags(trim($_POST['InvoiceType'])); endif;
    if(isset($_GET['InvoiceType'])):     $InvoiceType     = strip_tags(trim($_GET['InvoiceType'])); endif;

    if(isset($_GET['method_id'])):         $method_id         = strip_tags(trim($_GET['method_id'])); endif;
    if(isset($_GET['invoice_id'])):        $invoice_id        = strip_tags(trim($_GET['invoice_id'])); endif;

    if(!isset($mondy)): $mondy = date('m'); endif;
    if(!isset($year)):  $year  = date('Y'); endif;

    $t_quantidade = 0;
    $t_desconto = 0;
    $t_value = 0;
    $t_sub = 0;
    $t_geral = 0;
    $t_imposto = 0;

    $t_total = 0;
    $t_incidencia = 0;
    $t_rows = 0;

    if(DBKwanzar::CheckConfig($id_db_settings)['JanuarioSakalumbu'] == null): $ttt = 2; else: $ttt = DBKwanzar::CheckConfig($id_db_settings)['JanuarioSakalumbu']; endif;
    $suspenso = 0;

    $read = new Read();
    if($year <= "2020" && $mondy <= "07"):
        $InBody = '';
        $InHead = '';
    else:
        $InHead = " AND sd_billing_pmp.InvoiceType=:In";
        $InBody = "&In={$InvoiceType}";
    endif;

    $read->ExeRead("sd_billing_pmp", "WHERE sd_billing_pmp.numero=:n AND sd_billing_pmp.status=:st AND sd_billing_pmp.id_db_settings=:i {$InHead} ", "i={$id_db_settings}&st={$ttt}&n={$Number}{$InBody}");

    if($read->getResult()):
        foreach($read->getResult() as $key):
            $t_rows += 1;
            $t_quantidade += $key['quantidade_pmp'];
            $value    = ($key['quantidade_pmp'] * $key['preco_pmp']);
            $imposto  = ($value * $key['taxa']) / 100;

            if($key['desconto_pmp'] >= 100):
                $desconto = $key['desconto_pmp'];
            else:
                $desconto = ($value * $key['desconto_pmp']) / 100;
            endif;

            $t_total += $value;

            $sub = ($value - $desconto) + $imposto;

            $t_imposto += $imposto;
            $t_desconto += $desconto;
            //$t_value += $value;
            $t_sub += $value;
            ?>
            <tr style="font-size: 10pt!important;">
                <td style="max-width: 20%!important;"><?= $key['product_name']; ?></td>
                <td style="max-width: 10%!important;">
                    <input type="number" style="max-width: 100%!important;" value="<?= $key['quantidade_pmp']; ?>" min="<?= $key['quantidade_pmp']; ?>" class="form-control QtdsX1" data-file="<?= $key['id']; ?>" placeholder="Qtd">
                    <input value="<?= $Number ?>" id="number_x" name="number_x" type="hidden"/>
                    <input value="<?= $InvoiceType ?>" id="InvoiceType_x" name="InvoiceType_x" type="hidden"/>
                </td>
                <td style="max-width: 20%!important;">
                    <input type="number" style="max-width: 100%!important;" <?php if($level < 3): ?> disabled <?php endif; ?> value="<?= $key['preco_pmp']; ?>" min="<?= $key['preco_pmp']; ?>" class="form-control PricingsX1" data-file="<?= $key['id']; ?>" placeholder="Preço">
                </td>
                <td style="max-width: 10%!important;">
                    <input type="number" style="max-width: 100%!important;" <?php if($level < 3): ?> disabled <?php endif; ?> value="<?= $key['desconto_pmp']; ?>" min="<?= $key['desconto_pmp']; ?>" class="form-control DescsX1" data-file="<?= $key['id']; ?>" placeholder="Descs">
                </td>
                <td style="max-width: 10%!important;"><?= str_replace(",", ".",number_format($key['taxa'], 2)) ?>%</td>
                <td style="max-width: 10%!important;"><?= str_replace(",", ".",number_format($sub, 2)); ?></td>
                <td style="max-width: 10%!important;">
                    <a href="javascript:void()" onclick="RemovePSX(<?= $key['id']; ?>)" class="btn btn-danger btn-sm">
                        Excluir
                    </a>
                </td>
            </tr>
        <?php
        endforeach;
    endif;

    $t_geral = ($t_sub - $t_desconto) + $t_imposto;
    ?>
    </tbody>
    <tfoot>
    <tr>
        <input type="hidden" id="t_total" name="t_total" value="<?= $t_total; ?>"/>
        <th colspan="5" style="text-align: right!important;"><strong>Total</strong></th>
        <th colspan="2">
            <strong><?= str_replace(",", ".", number_format($t_total, 2)); ?></strong><br/>
            <small><strong><?= $t_rows; ?></strong> itens; <strong><?= $t_quantidade; ?></strong> unidade(s).</small>
        </th>
    </tr>
    </tfoot>
</table>

<table class="table">
    <thead>
    <tr>
        <th>Incidência</th>
        <th>Desconto</th>
        <th>Imposto</th>
        <th>Total</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td><?= str_replace(",", ".", number_format($t_sub, 2)); ?></td>
        <td><?= str_replace(",", ".",number_format($t_desconto, 2)); ?></td>
        <td><?= str_replace(",", ".",number_format($t_imposto, 2)); ?></td>
        <td><?php echo str_replace(",", ".",number_format($t_geral, 2)); if(DBKwanzar::CheckConfig($id_db_settings) != false) echo " ".DBKwanzar::CheckConfig($id_db_settings)['moeda']; ?><input type="hidden" value="<?= $t_geral?>" id="totalGeral"></td>
    </tr>
    </tbody>
</table>
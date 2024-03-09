<table  class="table text-wrap table-responsive">
    <thead>
        <tr>
            <th style="max-width: 20%!important;">Código</th>
            <th style="max-width: 20%!important;">Item</th>
            <th style="max-width: 20%!important;">Codigo de barras</th>
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
        $t_quantidade = 0;
        $t_desconto = 0;
        $t_value = 0;
        $t_sub = 0;
        $t_geral = 0;
        $t_imposto = 0;

        $t_total = 0;
        $t_incidencia = 0;
        $t_rows = 0;


        if(!isset($id_mesa)): $id_mesa = 0; endif;
        $suspenso = 0;

        $read = new Read();
        $read->ExeRead("sd_billing_tmp", "WHERE id_db_settings=:st AND session_id=:ses AND page_found=:ppY AND suspenso=:s ORDER BY id ASC", "st={$id_db_settings}&ses={$id_user}&ppY={$page_found}&s={$suspenso}");

        if($read->getResult()):
            foreach($read->getResult() as $key):
                extract($key);
                $t_rows += 1;
                $t_quantidade += $key['quantidade_tmp'];
                $value    = ($key['quantidade_tmp'] * $key['preco_tmp']);
                $imposto  = ($value * $key['taxa']) / 100;

                if($key['desconto_tmp'] >= 100):
                    $desconto = $key['desconto_tmp'];
                else:
                    $desconto = ($value * $key['desconto_tmp']) / 100;
                endif;

                $t_total += $value;

                $sub = ($value - $desconto) + $imposto;

                $t_imposto += $imposto;
                $t_desconto += $desconto;
                //$t_value += $value;
                $t_sub += $value;
                ?>
                <tr style="font-size: 10pt!important;">
                    <td style="max-width: 20%!important;"><?= $key['product_code']; ?></td>
                    <td style="max-width: 20%!important;"><?= $key['product_name']; ?></td>
                    <td style="max-width: 20%!important;"><?= $key['product_codigo_barras']; ?></td>
                    <td style="max-width: 10%!important;">
                        <input type="number" style="max-width: 100%!important;" value="<?= $key['quantidade_tmp']; ?>" min="<?= $key['quantidade_tmp']; ?>" class="form-control Qtds" data-file="<?= $key['id']; ?>" placeholder="Qtd">
                    </td>
                    <td style="max-width: 20%!important;">
                        <input type="number" style="max-width: 100%!important;" value="<?= $key['preco_tmp']; ?>" min="<?= $key['preco_tmp']; ?>" class="form-control Pricings" data-file="<?= $key['id']; ?>" placeholder="Preço">
                    </td>
                    <td style="max-width: 10%!important;">
                        <input type="number" style="max-width: 100%!important;" value="<?= $key['desconto_tmp']; ?>" min="<?= $key['desconto_tmp']; ?>" class="form-control Descs" data-file="<?= $key['id']; ?>" placeholder="Descs">
                    </td>
                    <td style="max-width: 10%!important;"><?= str_replace(",", ".",number_format($key['taxa'], 2)) ?>%</td>
                    <td style="max-width: 10%!important;"><?= str_replace(",", ".",number_format($sub, 2)); ?></td>
                    <td style="max-width: 10%!important;">
                        <a href="javascript:void()" onclick="RemovePS(<?= $key['id']; ?>)" class="btn btn-danger btn-sm">
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
            <th colspan="4">
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
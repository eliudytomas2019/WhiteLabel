<table class="table table-vcenter card-table bg-white align-items-center mt-3">
    <thead>
    <tr>
        <th>Items</th>
        <th>Qtd</th>
        <th>Total</th>
        <th>-</th>
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

            $Read = new Read();
            $Read->ExeRead("sd_billing_tmp", "WHERE id_db_settings=:i AND session_id=:ip AND id_mesa=:iv", "i={$id_db_settings}&ip={$id_user}&iv={$id_mesa}");
            if($Read->getResult()):
                foreach ($Read->getResult() as $key):
                    $t_rows += 1;
                    $t_quantidade += $key['quantidade_tmp'];
                    $value    = ($key['quantidade_tmp'] * $key['preco_tmp']);
                    $imposto  = ($value * $key['taxa']) / 100;
                    $desconto = ($value * $key['desconto_tmp']) / 100;
                    $t_total += $value;

                    $sub = ($value - $desconto) + $imposto;

                    $t_imposto += $imposto;
                    $t_desconto += $desconto;
                    //$t_value += $value;
                    $t_sub += $value;

                    $total = $key["quantidade_tmp"] * $key["preco_tmp"];
                    ?>
                    <tr>
                        <td><?= $key["product_name"] ?></td>
                        <td>
                            <input type="text" style="width: 50px!important;" value="<?= $key['quantidade_tmp']; ?>" min="<?= $key['quantidade_tmp']; ?>" class="form-control matrix" data-file="<?= $key['id']; ?>" placeholder="Qtd">x<?= str_replace(",", ".", number_format($key["preco_tmp"], 2)); ?>
                        </td>
                        <td><?= str_replace(",", ".", number_format($total, 2)); ?></td>
                        <td>
                            <a href="javascript:void()" onclick="RemovePDV(<?= $key['id']; ?>)" class="btn btn-danger btn-sm">
                                Apagar
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
            <th colspan="2" style="text-align: right!important;"><strong>Total</strong></th>
            <th colspan="2">
                <small><strong><?= $t_rows; ?></strong> itens; <strong><?= $t_quantidade; ?></strong> unidade(s).</small>
            </th>
        </tr>
    </tfoot>
    <tfoot>
        <tr>
            <th>Incidência</th>
            <th>Desconto</th>
            <th>Imposto</th>
            <th>Total</th>
        </tr>

        <tr>
            <td><?= str_replace(",", ".", number_format($t_sub, 2)); ?></td>
            <td><?= str_replace(",", ".", number_format($t_desconto, 2)); ?></td>
            <td><?= str_replace(",", ".", number_format($t_imposto, 2)); ?></td>
            <td><?php echo str_replace(",", ".", number_format($t_geral, 2)); if(DBKwanzar::CheckConfig($id_db_settings) != false) echo " ".DBKwanzar::CheckConfig($id_db_settings)['moeda']; ?><input type="hidden" value="<?= $t_geral?>" id="totalGeral"></td>
        </tr>
    </tfoot>
</table>
<?php
/**
 * Created by PhpStorm.
 * User: Kwanzar Soft
 * Date: 16/08/2020
 * Time: 01:45
 */

$total_incidencia     = 0;
$total_com_imposto    = 0;
$total_com_desconto   = 0;
$total_geral          = 0;
$total_itens          = 0;

?>
<div class="boleto" style="width: <?= DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Impression']; ?>mm!important;">
    <div class="header-boleto">
        <p>Data de Emissão: <?= date('d-m-Y H:i:s'); ?></p>
        <p>Mesa: <?php $PDV = new PDV();  echo $PDV->Consult($id_mesa, $id_db_settings)['name']; ?></p>
        <title>Mesa: <?php echo $PDV->Consult($id_mesa, $id_db_settings)['name']; ?></title>
    </div>
    <div class="body-boleto table-responsive">
        <table>
            <thead>
            <tr>
                <th>Item</th>
                <th>Qtd</th>
                <th>Preço</th>
                <th>Total</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $Read = new Read();
            $Read->ExeRead("sd_billing_tmp", "WHERE id_db_settings=:i AND session_id=:ip AND id_mesa=:ipp", "i={$id_db_settings}&ip={$id_user}&ipp={$id_mesa}");

            if($Read->getResult()):
                foreach($Read->getResult() as $key):
                    $value    = $key['quantidade_tmp'] * $key['preco_tmp'];
                    $desconto = ($value * $key['desconto_tmp']) / 100;
                    $imposto  = ($value * $key['taxa']) / 100;

                    $total = ($value - $desconto) + $imposto;

                    $total_com_desconto += $desconto;
                    $total_com_imposto  += $imposto;
                    $total_incidencia   += $value;
                    $total_itens += $key['quantidade_tmp'];
                    ?>
                    <tr>
                        <td><?= $key['product_name']; ?></td>
                        <td><?= $key['quantidade_tmp']; ?></td>
                        <td><?= number_format($key['preco_tmp'], 2); ?></td>
                        <td><?= number_format($total, 2); ?></td>
                    </tr>
                    <?php
                endforeach;
            endif;
            ?>
            </tbody>
        </table>
    </div>
</div>

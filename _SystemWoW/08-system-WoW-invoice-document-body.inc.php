<?php
/**
 * Created by PhpStorm.
 * User: Kwanzar Soft
 * Date: 17/06/2020
 * Time: 18:45
 */
?>

<div class="Yolanda">
    <h1 class="header-one pussy">Inventário da Loja</h1>
    <p class="Luzineth">Moeda: (AOA)</p>
</div>

<table class="DomingosTomas">
    <thead>
    <tr>
        <th>Data de emissão</th>
        <th>Hora de emissão</th>
        <th>Emitida por</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td><?= date("d-m-Y"); ?></td>
        <td><?= date('H:i:s') ?></td>
        <td><?= $userlogin['name'] ?></td>
    </tr>
    </tbody>
</table>
<div class="card-body">
    <div class="table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th>Artigo</th>
                <th>Descrição</th>
                <th>Quantidade</th>
                <th>Un.</th>
                <th>Preço</th>
                <th>Valor</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $tQ = 0;
            $tV = 0;
            $read = new Read();
            $read->ExeRead("cv_product", "WHERE id_db_settings=:i AND type='P'", "i={$id_db_settings}");

            if($read->getResult()):
                foreach($read->getResult() as $key):
                    if($key['ILoja'] == null || $key['ILoja'] == '' || $key['ILoja'] != 1):
                        $i0 = 0;
                        $o0 = 0;
                        $st = 1;

                        if(DBKwanzar::CheckSettingsII($id_db_settings)['atividade'] == 1):
                            $qtd = $key['quantidade'];
                        else:
                            $qtd = $key['unidades'];
                        endif;

                        $i0 += $qtd;
                        $o0 += $qtd * $key['preco_venda'];


                        $tQ += $i0;
                        $tV += $o0;
                        ?>
                        <tr>
                            <td><?= $key['codigo']; ?></td>
                            <td><?= $key['product']; ?></td>
                            <td><?= number_format($i0, 2); ?></td>
                            <td><?= $key['unidade_medida']; ?></td>
                            <td><?= number_format($key['preco_venda'], 2); ?></td>
                            <td><?= number_format($o0, 2); ?></td>
                        </tr>
                        <?php
                    endif;
                endforeach;
            endif;
            ?>
            </tbody>
            <tfoot>
            <tr>
                <th></th>
                <th>Total</th>
                <th><?= number_format($tQ, 2); ?></th>
                <th></th>
                <th></th>
                <th><?= number_format($tV, 2)." ".DBKwanzar::CheckConfig($id_db_settings)['moeda']; ?></th>
            </tr>
            </tfoot>
        </table>
    </div>
</div>

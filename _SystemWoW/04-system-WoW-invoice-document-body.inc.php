<?php
/**
 * Created by PhpStorm.
 * User: Kwanzar Soft
 * Date: 15/06/2020
 * Time: 02:28
 */

$dI = explode("-", $dateI);
$dF = explode("-", $dateF);

if(!empty($dateI) && !empty($dateF)):
    $s_total = 0;

    $Read = new Read();
    $read = new Read();
    $Read->ExeRead("sd_purchase", "WHERE (id_db_settings=:i) AND (dia BETWEEN {$dI[2]} AND {$dF[2]}) AND (mes BETWEEN {$dI[1]} AND {$dF[1]}) AND (ano BETWEEN {$dI[0]} AND {$dF[0]}) ORDER BY id DESC ", "i={$id_db_settings}");


    ?>

    <div class="table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th>FORNECEDOR</th>
                <th>PRODUTO</th>
                <th>DATA DE FABRICO</th>
                <th>DATA DE EXPIRAÇÃO</th>
                <th>UNIDADES</th>
                <th>QUANTIDADE</th>
                <th>PREÇO</th>
                <th>TOTAL</th>
            </tr>
            </thead>
            <tbody>
            <?php
            if($Read->getResult()):
                foreach($Read->getResult() as $key):
                    extract($key);
                    ?>
                    <tr>
                        <td><?php $read->ExeRead("cv_supplier", "WHERE id=:i AND id_db_settings=:ip", "i={$key['id_supplier']}&ip={$id_db_settings}"); if($read->getResult()): echo $read->getResult()[0]['nome']; endif;  ?></td>
                        <td>
                            <?php
                            $read->ExeRead("cv_product", "WHERE id=:i AND id_db_settings=:ip", "i={$key['id_product']}&ip={$id_db_settings}");
                            if($read->getResult()): echo $read->getResult()[0]['product']; endif;
                            ?>
                        </td>
                        <?php

                        $ipX = 0;
                        $Read->ExeRead("sd_purchase_story", "WHERE id_sd_purchase=:i", "i={$key['id']}");
                        if($Read->getResult()):
                            foreach($Read->getResult() as $k):
                                extract($k);
                                $ipX += $k['qtd'];
                            endforeach;
                        endif;

                        $total = ($key['quantidade'] + $ipX) * $key['preco_compra'];
                        $s_total += $total;
                        ?>
                        <td><?= $key['dateF'] ?></td>
                        <td><?= $key['dateEx'] ?></td>
                        <td><?= number_format($key['unidade'], 2); ?></td>
                        <td><?= number_format($key['quantidade'] + $ipX, 2) ?></td>
                        <td><?= number_format($key['preco_compra'], 2) ?></td>
                        <td><?= number_format($total, 2); ?></td>
                    </tr>
                    <?php
                endforeach;
            endif;
            ?>
            </tbody>
            <tfoot>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>Total Geral =></td>
                <td><?= number_format($s_total, 2);?></td>
            </tr>
            </tfoot>
        </table>
    </div>
    <?php
else:
    WSError("Ops: preencha a data para prosseguir com o processo!", WS_INFOR);
endif;
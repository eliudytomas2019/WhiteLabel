<?php
/**
 * Created by PhpStorm.
 * User: Kwanzar Soft
 * Date: 15/06/2020
 * Time: 04:39
 */

$dI = explode("-", $dateI);
$dF = explode("-", $dateF);

if(!empty($dateI) && !empty($dateF)):
    $t_1 = 0;
    $t_2 = 0;
    $t_3 = 0;

    ?>
    <div class="card-body">

        <table class="table table-striped mt-3">
            <thead>
            <tr>
                <th scope="col">Data</th>
                <th scope="col">Descrição</th>
                <th scope="col">Qtd</th>
                <th scope="col">Preço</th>
                <th scope="col">Usuário</th>
                <th scope="col">Entrada</th>
                <th scope="col">Saída</th>
                <th scope="col">Investimento</th>
            </tr>
            </thead>
            <tbody>
            <?php

            $read = new Read();
            $read->ExeRead("sd_spending", "WHERE id_db_settings=:i AND (dia BETWEEN {$dI[2]} AND {$dF[2]}) AND (mes BETWEEN {$dI[1]} AND {$dF[1]}) AND (ano BETWEEN {$dI[0]} AND {$dF[0]}) ORDER BY id ASC", "i={$id_db_settings}");

            if($read->getResult()):
                foreach($read->getResult() as $key):
                    extract($key);
                    ?>
                    <tr>
                        <td><?= $key['dia']."/".$key['mes']."/".$key['ano']; ?></td>
                        <td><?= $key['descricao'] ?></td>
                        <td><?= $key['quantidade'] ?></td>
                        <td><?= number_format($key['preco'], 2) ?></td>
                        <td><?php $read->ExeRead("db_users", "WHERE id=:i", "i={$key['session_id']}"); if($read->getResult()): echo $read->getResult()[0]['name']; endif; ?></td>
                        <?php
                        if($key['natureza'] == "E"):
                            $t_1 += $key['quantidade'] * $key['preco'];
                            ?>
                            <td><?= number_format($key['quantidade'] * $key['preco'], 2); ?></td>
                            <td></td>
                            <td></td>
                            <?php
                        elseif($key['natureza'] == 'S'):
                            $t_2 += $key['quantidade'] * $key['preco'];
                            ?>
                            <td></td>
                            <td><?= number_format($key['quantidade'] * $key['preco'], 2); ?></td>
                            <td></td>
                            <?php
                        else:
                            $t_3 += $key['quantidade'] * $key['preco'];
                            ?>
                            <td></td>
                            <td></td>
                            <td><?= number_format($key['quantidade'] * $key['preco'], 2); ?></td>
                            <?php
                        endif;
                        ?>
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
                <td>TOTAL =></td>
                <td><?= number_format($t_1, 2); ?></td>
                <td><?= number_format($t_2, 2); ?></td>
                <td><?= number_format($t_3, 2); ?></td>
                <td></td>
            </tr>
            </tfoot>
        </table>
    </div>
    <?php
else:
    WSError("Ops: preencha a data para prosseguir com o processo!", WS_INFOR);
endif;
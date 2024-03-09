<?php
/**
 * Created by PhpStorm.
 * User: Kwanzar Soft
 * Date: 15/06/2020
 * Time: 04:21
 */
?>
<div class="card">
    <div class="card-header">
        <div class="card-title">Gestão de despesa de: <?= date('m')."/".date('Y'); ?></div>
    </div>
    <div class="card-body">
        <table class="table table-striped mt-3">
            <thead>
            <tr>
                <th scope="col">Dia</th>
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
            $m = date('m');
            $y = date('Y');

            $t_1 = 0;
            $t_2 = 0;
            $t_3 = 0;

            $read = new Read();
            $read->ExeRead("sd_spending", "WHERE id_db_settings=:i AND mes=:mm AND ano=:aa ORDER BY id ASC", "i={$id_db_settings}&mm={$m}&aa={$y}");

            if($read->getResult()):
                foreach($read->getResult() as $key):
                    extract($key);
                    ?>
                    <tr>
                        <td><?= $key['dia'] ?></td>
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
</div>

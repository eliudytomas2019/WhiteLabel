<?php
require_once("../../Config.inc.php");

$dateI         = strip_tags(trim($_POST['dateI']));
$dateF         = strip_tags(trim($_POST['dateF']));
$operacao      = strip_tags(trim($_POST['operacao']));
$id_db_settings= strip_tags(trim($_POST['id_db_settings']));

?>
<div class="styles">
    <a href="print.php?action=122021&dateI=<?= $dateI; ?>&dateF=<?= $dateF; ?>&id_db_settings=<?= $id_db_settings; ?>&operacao=<?= $operacao; ?>" class="bol bol-default bol-sm btn btn-primary btn-sm" target="_blank">Imprimir</a>
</div>
<table class="table table-responsive">
    <thead>
    <tr>
        <th>Movimento</th>
        <th>Natureza</th>
        <th>Operador</th>
        <th>Código</th>
        <th>Descrição</th>
        <th>Qtd Atual</th>
        <th>Qtd Entrada</th>
        <th>Custo</th>
        <th>Preço Venda</th>
    </tr>
    </thead>
    <tbody>
        <?php
            $line = 0;
            $Read = new Read();

            if($operacao == "all"): $White = " "; else: $White = " AND operacao='{$operacao}' "; endif;

            $Read->ExeRead("cv_product", "WHERE id_db_settings=:i", "i={$id_db_settings}");
            if($Read->getResult()):
                foreach ($Read->getResult() as $item):
                    $Read->FullRead("SELECT * FROM cv_operation WHERE data_operacao BETWEEN '{$dateI}' AND '{$dateF}' AND id_product={$item['id']} {$White} ");

                    $qtd = 0;
                    $custo = 0;
                    if($Read->getResult()):
                        foreach ($Read->getResult() as $key):
                            $line += 1;
                            $custo += $key['custo_compra'];
                            $qtd += $key['quantidade'];

                            ?>
                                <tr>
                                    <td><?= $key['operacao']; ?></td>
                                    <td><?= $key['natureza']; ?></td>
                                    <td>
                                        <?php
                                            $Read->ExeRead("db_users", "WHERE id=:i ", "i={$key['id_user']}");
                                            if($Read->getResult()):
                                                echo $Read->getResult()[0]['name'];
                                            endif;
                                        ?>
                                    </td>
                                    <td><?= $item['codigo']; ?></td>
                                    <td><?= $item['product']; ?></td>
                                    <td><?= $item['quantidade']; ?></td>
                                    <td><?= $key['quantidade']; ?></td>
                                    <td><?= str_replace(",", ".", number_format($key['custo_compra'], 2)); ?></td>
                                    <td><?= str_replace(",", ".", number_format($item['preco_venda'], 2)); ?></td>
                                </tr>
                            <?php
                        endforeach;
                    endif;
                endforeach;
            endif;
        ?>
    </tbody>
    <tfoot>
        <tr>
            <th colspan="9" style="text-align: right!important;"><?= $line; ?> Movimento(s)</th>
        </tr>
    </tfoot>
</table>
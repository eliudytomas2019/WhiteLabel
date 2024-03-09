<?php
$dateI         = strip_tags(trim($_GET['dateI']));
$dateF         = strip_tags(trim($_GET['dateF']));
$operacao      = strip_tags(trim($_GET['operacao']));
$id_db_settings= strip_tags(trim($_GET['id_db_settings']));
?>
<div class="Yolanda">
    <h1 class="header-one pussy">Movimentos de Stock</h1>
    <p class="Luzineth">Moeda: (AOA)</p>
</div>

<table class="DomingosTomas">
    <thead>
    <tr>
        <th>Data Inicial</th>
        <th>Data Final</th>
        <th>Data de emissão</th>
        <th>Hora de emissão</th>
        <th>Emitida por</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td><?= $dateI; ?></td>
        <td><?= $dateF; ?></td>
        <td><?= date("d-m-Y"); ?></td>
        <td><?= date('H:i:s') ?></td>
        <td><?= $userlogin['name'] ?></td>
    </tr>
    </tbody>
</table>

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
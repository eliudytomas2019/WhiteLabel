<?php
$Read = new Read();
$Read->ExeRead("cv_product", "WHERE id_db_settings=:i ORDER BY product ASC ", "i={$id_db_settings}");
?>
<h1 style="text-align: center!important;
    margin: 10px!important;
    font-size: 26pt!important;">PREÇARIOS</h1>
<table class="table">
    <thead>
        <tr>
            <th>Imagem</th>
            <th>Nome</th>
            <th>Código de Barras</th>
            <th>Preço</th>
        </tr>
    </thead>
    <tbody>
    <?php
        if($Read->getResult()):
            foreach ($Read->getResult() as $key):

                $promocao = explode("-", $key['data_fim_promocao']);
                if($promocao[0] >= date('Y')):
                    if($promocao[1] >= date('m')):
                        if($promocao[2] >= date('d')):
                            $preco = $key['preco_promocao'];
                        else:
                            $preco = $key['preco_promocao'];
                        endif;
                    else:
                        $preco = $key['preco_promocao'];
                    endif;
                elseif($promocao[0] < date('Y')):
                    $preco = $key['preco_venda'];
                endif;

                $desconto = ($preco * $key['desconto']) / 100;

                $total = $preco - $desconto;
                ?>
                <tr>
                    <td><img class="img_ternaria" src="uploads/<?php echo ($key['cover'] != "") ? $key['cover'] : "default.jpg"; ?>"/></td>
                    <td><?= $key["product"]; ?></td>
                    <td><?= $key["codigo_barras"]; ?></td>
                    <td><?= number_format($total, 2). " AOA"?></td>
                </tr>
                <?php
            endforeach;
        endif;
    ?>
    </tbody>
</table>

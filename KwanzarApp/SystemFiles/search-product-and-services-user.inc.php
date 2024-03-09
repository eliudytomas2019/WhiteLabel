<?php
$posti = 0;
$getPage = filter_input(INPUT_GET, 'page',FILTER_VALIDATE_INT);
$Pager = new Pager("panel.php?exe=product/index{$n}&page=");
$Pager->ExePager($getPage, 50);

$read->ExeRead("cv_product", "WHERE id_db_settings=:id ORDER BY id DESC LIMIT :limit OFFSET :offset", "id={$id_db_settings}&limit={$Pager->getLimit()}&offset={$Pager->getOffset()}");
if($read->getResult()):
    foreach ($read->getResult() as $key):
        //extract($key);

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


        /**$DB = new DBKwanzar();
        if($DB->CheckCpanelAndSettings($id_db_settings)['atividade'] == 1 || $DB->CheckCpanelAndSettings($id_db_settings)['atividade'] == 4):
            $NnM = $key['quantidade'];
        else:
            $NnM = $key['gQtd'];
        endif;**/
        ?>
        <tr>
            <td><?= $key['codigo']; ?></td>
            <td><img style="width: 40px!important;height: 40px!important;border-radius: 50%!important;" src="./uploads/<?php if($key['cover'] != ''): echo $key['cover']; else: echo 'default.jpg'; endif;  ?>"</td>
            <td title="<?= $key['product']; ?>"><?= $key['product']; ?></td>
            <td><?= $key['codigo_barras']; ?></td>
            <td><?= $key["quantidade"]; ?></td>
            <td><?= str_replace(",", ".", number_format($preco, 2)); ?> AOA</td>
            <td><?= $key["local_product"]; ?></td>
            <td><?= $key["remarks"]; ?></td>
            <td>
                <a href="panel.php?exe=product/product-promotions<?= $n; ?>&postid=<?= $key['id']; ?>" class="btn btn-default btn-sm" title="Preço promocional">Preço promocional</a>
                <?php if($key['IE_commerce'] == 2): ?><a href="<?= HOME; ?>panel.php?exe=product/gallery<?= $n; ?>&postid=<?= $key['id']; ?>" class="btn btn-sm btn-primary">Galeria</a><?php endif; ?>
                <a href="panel.php?exe=product/update<?= $n; ?>&postid=<?= $key['id']; ?>" title="Editar" class="btn btn-warning btn-sm">Editar</a>
                <a href="javascript:void()" onclick="DeleteProduct(<?= $key['id']?>)" title="Eliminar" class="btn btn-danger btn-sm">eliminar</a>
            </td>
        </tr>
        <?php
    endforeach;
endif;
?>
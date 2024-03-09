<?php
/**
 * Created by PhpStorm.
 * User: Kwanzar Soft
 * Date: 14/06/2020
 * Time: 23:51
 */
if($level >= 4): $n =  '&id_db_settings='.$id_db_settings; else: $n = null; endif;
$read = new Read();
?>
<div class="form-group d-none d-sm-inline-block form-inline mr-auto ml-md-4 my-3 my-md-0 mw-100 navbar-search">
    <div class="input-group">
        <input type="text" id="searchPurchase" class="form-control bg-light border-0 small" placeholder="Buscar Estoque"  aria-label="Search" aria-describedby="basic-addon2">
        <div class="input-group-append">
            <input class="btn btn-primary" name="" type="submit" value="Pesquisar">
        </div>
    </div>
</div>

<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>Res</th>
                <th>Produto</th>
                <th>Preço compra</th>
                <th>Quantidade</th>
                <th>Unidades</th>
                <th>Data de compra</th>
                <th>Data de Expiração</th>
                <th>Status</th>
                <th>-</th>
            </tr>
        </thead>
        <tbody id="hPro">
            <?php


            $Status = ["Exgotado", "Activo", "Suspenso"];
            $s = 1;
            $read->ExeRead("sd_purchase", "WHERE id_db_settings=:id AND status=:s ORDER BY id  DESC", "id={$id_db_settings}&s={$s}");
            if($read->getResult()):
                foreach ($read->getResult() as $key):
                    extract($key);
                    ?>
                    <tr>
                        <td><?= $key['id']; ?></td>
                        <td><?php $read->ExeRead("cv_product", "WHERE id=:i AND id_db_settings=:ip", "i={$key['id_product']}&ip={$id_db_settings}"); if($read->getResult()): echo $read->getResult()[0]['product']; endif; ?></td>
                        <td><?= number_format($key['preco_compra'], 2); ?></td>
                        <td><?= number_format($key['quantidade'], 2); ?></td>
                        <td><?= number_format($key['unidade'], 2); ?></td>
                        <td><?= $key['data_lanca']; ?></td>
                        <td><?= $key['dateEx']; ?></td>
                        <td><?= $Status[$key['status']]; ?></td>
                        <td>
                            <a href="<?= HOME; ?>panel.php?exe=purchase/create&postid=<?= $key['id']; ?><?= $n; ?>" class="btn btn-primary btn-sm">Mover para loja</a>
                            &nbsp;<a href="<?= HOME; ?>panel.php?exe=purchase/update&postid=<?= $key['id']; ?><?= $n; ?>" class="btn btn-sm btn-warning">Saída de Estoque</a>
                        </td>
                    </tr>
                    <?php
                endforeach;
            endif;
            ?>
        </tbody>
    </table>
</div>


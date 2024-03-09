<tr>
    <td><?= $key["id"]; ?></td>
    <td><?= $key["product"]; ?></td>
    <td><?= $key["codigo_barras"]; ?></td>
    <td><input type="date" class="form-control data_expiracao_x" name="data_expiracao_<?= $key['id']; ?>" id="data_expiracao_<?= $key['id']; ?>" value="<?= $key["data_expiracao"]; ?>" data-file="<?= $key['id']; ?>"></td>
    <td><input type="text" class="form-control quantidade_x" name="quatidade_<?= $key['id']; ?>" id="quatidade_<?= $key['id']; ?>" value="<?= $key["quantidade"]; ?>" data-file="<?= $key['id']; ?>"></td>
    <td><input type="text" class="form-control custo_compra_x" name="custo_compra_<?= $key['id']; ?>" id="custo_compra_<?= $key['id']; ?>" value="<?= $key["custo_compra"]; ?>" data-file="<?= $key['id']; ?>"></td>
    <td><?= number_format($key["preco_venda"], 2); ?></td>
    <td><?= number_format($in_total, 2); ?></td>
    <td><a href="?exe=product/stock-in&postid=<?= $key['id']; ?><?= $n; ?>" class="btn btn-primary btn-sm">Movimentar</a></td>
</tr>
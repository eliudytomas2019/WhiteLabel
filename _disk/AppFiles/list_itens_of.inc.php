<table class="table">
    <thead>
    <tr>
        <th></th>
        <th>Item</th>
        <th>Qtd.</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $Read = new Read();
    $Read->ExeRead("ii_billing_tmp", "WHERE id_db_settings=:i AND id_user=:y", "i={$id_db_settings}&y={$id_user}");

    if($Read->getResult()):
        foreach ($Read->getResult() as $key):
            ?>
            <tr>
                <td><a href="javascript:void()" onclick="cancelII(<?= $key['id']; ?>)" class="btn btn-danger">Apagar</a></td>
                <td style="width: 30%!important;" class="small"><?= $key['product'] ?></td>
                <td style="width: 60px!important;"><input type="text" style="text-align: center!important;" value="<?= $key['qtd_tmp']; ?>" class="form-control hSpros" data-value="<?= $key['id_product']; ?>" placeholder="quantidade"></td>
            </tr>
        <?php
        endforeach;
    endif;
    ?>
    </tbody>
</table>
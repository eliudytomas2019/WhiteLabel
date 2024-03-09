<div class="table-responsive">
    <input type="text" name="SearchDocs" id="SearchDocs" onclick="SearchDocs();" class="form-control" placeholder="Pesquisar documentos">
    <table class="table text-center">
        <thead>
        <tr>
            <th>NÚMERO</th>
            <th>DATA & HORA</th>
            <th>DOCUMENTO</th>
            <th>-</th>
            <th>ID</th>
        </tr>
        </thead>
        <tbody id="ReturnDocs">
        <?php
        $status = 3;
        $Read = new Read();
        $Read->ExeRead("ii_billing", "WHERE id_db_settings=:i AND id_user=:y AND status=:st ORDER BY id DESC LIMIT 10", "i={$id_db_settings}&y={$id_user}&st={$status}");

        if($Read->getResult()):
            foreach ($Read->getResult() as $key):
                ?>
                <tr>
                    <td><?= $key['numero']; ?></td>
                    <td><?= $key['dia']."/".$key["mes"]."/".$key['ano']." ".$key['hora']; ?></td>
                    <td><?= $key['InvoiceType']; ?></td>
                    <td>
                        <a href="print.php?action=16&id_db_settings=<?= $id_db_settings; ?>&postId=<?= $key['id']; ?>&InvoiceType=<?= $key['InvoiceType']; ?>&post=<?= $key['numero']; ?>" target="_blank" class="btn btn-success btn-sm small">Imprimir</a>&nbsp;
                    </td>
                    <td><?= $key['id']; ?></td>
                </tr>
            <?php
            endforeach;
        endif;
        ?>
        </tbody>
    </table>
</div>
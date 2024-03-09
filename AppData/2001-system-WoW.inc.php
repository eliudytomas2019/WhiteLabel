<h2 style="margin: 10px auto; text-align: center!important;text-transform: uppercase!important;">Lista dos Materiais Fixos</h2>

    <table class="table">
        <thead>
        <tr>
            <th>ID</th>
            <th>Descrição</th>
            <th>Quantidade</th>
            <th>Unidades</th>
            <th>Tipo</th>
        </tr>
        </thead>
        <tbody id="DaSo">
        <?php
        $read = new Read();
        $read->ExeRead("cv_clinic_product", "WHERE id_db_settings=:id ORDER BY id DESC", "id={$id_db_settings}");
        if($read->getResult()):
            foreach ($read->getResult() as $key):
                ?>
                <tr>
                    <td><?= $key['id']; ?></td>
                    <td><?= $key['name']; ?></td>
                    <td><?= $key['qtd']; ?></td>
                    <td><?= $key['unidades']; ?></td>
                    <td><?= $key['type'] ?></td>
                </tr>
            <?php
            endforeach;
        endif;
        ?>
        </tbody>
    </table>

<?php if(isset($userlogin['level'])): if($userlogin['level'] >= 4): $n =  '&id_db_settings='.$id_db_settings; else: $n = null; endif; else: $n = null; endif; ?>
<div id="aPaulo"></div>
<div class="table-responsive">
    <table class="table">
        <thead>
        <tr>
            <th>ID</th>
            <th>MARCA</th>
            <th>DESCRIÇÃO</th>
            <th>DATA</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php
        $posti = 0;
        $getPage = filter_input(INPUT_GET, 'page',FILTER_VALIDATE_INT);

        $Pager = new Pager('panel.php?exe=marcas/index'.$n.'&page=');
        $Pager->ExePager($getPage, 30);

        $read = new Read();
        $read->ExeRead("cv_marcas", "WHERE id_db_settings=:id ORDER BY marca ASC LIMIT :limit OFFSET :offset", "id={$id_db_settings}&limit={$Pager->getLimit()}&offset={$Pager->getOffset()}");
        if($read->getResult()):
            foreach ($read->getResult() as $key):
                extract($key);
                ?>
                <tr>
                    <td><?= $key['id']; ?></td>
                    <td><?= $key['marca']; ?></td>
                    <td><?= $key['content']; ?></td>
                    <td><?= $key['data']; ?></td>
                    <td>

                        <a href="panel.php?exe=marcas/update<?= $n; ?>&postid=<?= $id; ?>" title="Editar" class="btn btn-warning btn-sm">Editar</a>
                        <a href="" title="Deletar" class="btn btn-danger btn-sm" onclick="DeleteMarca(<?= $id; ?>)">Apagar</a>
                    </td>
                </tr>
            <?php
            endforeach;
        endif;
        ?>
        </tbody>
    </table>
</div>
<div class="card-footer d-flex align-items-center">
    <?php
    $Pager->ExePaginator("cv_marcas", "WHERE id_db_settings=:id ORDER BY marca ASC", "id={$id_db_settings}");
    echo $Pager->getPaginator();
    ?>
</div>
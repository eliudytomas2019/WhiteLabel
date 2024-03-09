<?php if(isset($userlogin['level'])): if($userlogin['level'] >= 4): $n =  '&id_db_settings='.$id_db_settings; else: $n = null; endif; else: $n = null; endif; ?>
<div id="aPaulo"></div>
<div class="table-responsive">
    <table class="table">
        <thead>
        <tr>
            <th>ID</th>
            <th>CATEGORIA</th>
            <th>DESCRIÇÃO</th>
            <th>% de Lucro</th>
            <th>DATA</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php
        $posti = 0;
        $getPage = filter_input(INPUT_GET, 'page',FILTER_VALIDATE_INT);

        $DB = new DBKwanzar();
        if($DB->CheckCpanelAndSettings($id_db_settings)['atividade'] == 19):
            $Pager = new Pager('panel.php?exe=definitions/index_category'.$n.'&page=');
        else:
            $Pager = new Pager('panel.php?exe=category/index'.$n.'&page=');
        endif;

        $Pager->ExePager($getPage, 30);

        $read = new Read();
        $read->ExeRead("cv_category", "WHERE id_db_settings=:id ORDER BY category_title ASC LIMIT :limit OFFSET :offset", "id={$id_db_settings}&limit={$Pager->getLimit()}&offset={$Pager->getOffset()}");
        if($read->getResult()):
            foreach ($read->getResult() as $key):
                extract($key);
                ?>
                <tr>
                    <td><?= $key['id_xxx']; ?></td>
                    <td><?= $key['category_title']; ?></td>
                    <td><?= $key['category_content']; ?></td>
                    <td><?= $key['porcentagem_ganho']; ?></td>
                    <td><?= $key['category_data']; ?></td>
                    <td>
                        <?php if($DB->CheckCpanelAndSettings($id_db_settings)['atividade'] == 19): ?>
                            <a href="panel.php?exe=definitions/category_update<?= $n; ?>&postid=<?= $key['id_xxx']; ?>" title="Editar" class="btn btn-warning btn-sm">Editar</a>
                        <?php else: ?>
                            <a href="panel.php?exe=category/update<?= $n; ?>&postid=<?= $key['id_xxx']; ?>" title="Editar" class="btn btn-warning btn-sm">Editar</a>
                        <?php endif; ?>
                        <a href="" title="Deletar" class="btn btn-danger btn-sm" onclick="DeleteCategory(<?= $key['id_xxx']; ?>)">Apagar</a>
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
    $Pager->ExePaginator("cv_category", "WHERE id_db_settings=:id ORDER BY category_title ASC", "id={$id_db_settings}");
    echo $Pager->getPaginator();
    ?>
</div>
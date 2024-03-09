<?php
/**
 * Created by PhpStorm.
 * User: Kwanzar Soft
 * Date: 15/05/2020
 * Time: 23:34
 */

if(isset($userlogin['level'])): if($userlogin['level'] >= 4): $n =  '&id_db_settings='.$id_db_settings; else: $n = null; endif; else: $n = null; endif;
?>
<table class="table">
    <thead>
    <tr>
        <th width="10">RES.</th>
        <th width="40">CATEGORIA</th>
        <th>DESCRIÇÃO</th>
        <th>DATA</th>
        <th width="300">-</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $posti = 0;
    $getPage = filter_input(INPUT_GET, 'page',FILTER_VALIDATE_INT);
    $Pager = new Pager('panel.php?exe=category/index'.$n.'&page=');
    $Pager->ExePager($getPage, 30);

    $read = new Read();
    $read->ExeRead("cv_category", "WHERE id_db_settings=:id ORDER BY category_title ASC LIMIT :limit OFFSET :offset", "id={$id_db_settings}&limit={$Pager->getLimit()}&offset={$Pager->getOffset()}");
    if($read->getResult()):
        foreach ($read->getResult() as $key):
            extract($key);
            ?>
            <tr>
                <td><?= $key['id']; ?></td>
                <td><?= $key['category_title']; ?></td>
                <td><?= $key['category_content']; ?></td>
                <td><?= $key['category_data']; ?></td>
                <td>
                    <a href="<?= HOME; ?>panel.php?exe=category/update<?= $n; ?>&postid=<?= $id; ?>" title="Editar" class="btn btn-warning btn-sm">Editar</a>
                    <a href="" title="Deletar" class="btn btn-danger btn-sm" onclick="DeleteCategory(<?= $id; ?>)">Apagar</a>
                </td>
            </tr>
            <?php
        endforeach;
    endif;
    ?>
    </tbody>
</table>

<?php
$Pager->ExePaginator("cv_category");
echo $Pager->getPaginator();
?>

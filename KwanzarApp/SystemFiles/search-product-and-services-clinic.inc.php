<?php
$posti = 0;
$getPage = filter_input(INPUT_GET, 'page',FILTER_VALIDATE_INT);
$Pager = new Pager("panel.php?exe=fixos/indexx{$n}&page=");
$Pager->ExePager($getPage, 10);

$read = new Read();
$read->ExeRead("cv_clinic_product", "WHERE id_db_settings=:id ORDER BY id DESC LIMIT :limit OFFSET :offset", "id={$id_db_settings}&limit={$Pager->getLimit()}&offset={$Pager->getOffset()}");
if($read->getResult()):
    foreach ($read->getResult() as $key):
        ?>
        <tr>
            <td><?= $key['id']; ?></td>
            <td><?= $key['name']; ?></td>
            <td><?= $key['qtd']; ?></td>
            <td><?= $key['unidades']; ?></td>
            <td><?= $key['type'] ?></td>
            <td>
                <a href="panel.php?exe=fixos/moviment<?= $n; ?>&postid=<?= $key['id']; ?>" class="btn btn-default btn-sm">Movimentar</a>
                <a href="panel.php?exe=fixos/updatex<?= $n; ?>&postid=<?= $key['id']; ?>" title="Editar" class="btn btn-warning btn-sm">Editar</a>
                <a href="javascript:void()" onclick="DeleteProductx(<?= $key['id']?>)" title="Eliminar" class="btn btn-danger btn-sm">eliminar</a>
            </td>
        </tr>
    <?php
    endforeach;
endif;
?>
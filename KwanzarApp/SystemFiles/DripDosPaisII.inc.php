<?php

$posti = 0;
$getPage = filter_input(INPUT_GET, 'page',FILTER_VALIDATE_INT);
$Pager = new Pager("panel.php?exe=obs/index{$n}&page=");
$Pager->ExePager($getPage, 10);

$read = new Read();
$read->ExeRead("cv_obs", "WHERE id_db_settings=:id ORDER BY id DESC LIMIT :limit OFFSET :offset", "id={$id_db_settings}&limit={$Pager->getLimit()}&offset={$Pager->getOffset()}");
if($read->getResult()):
    foreach ($read->getResult() as $key):
        extract($key);
        ?>
        <tr>
            <td  style="max-width: 50px!important;"><?= $key['id']; ?></td>
            <td  style="max-width: 200px!important;"><?= $key['nome']; ?></td>
            <td  style="max-width: 200px!important;"><?= $key['data']; ?></td>
            <td>
                <a href="panel.php?exe=obs/update<?= $n; ?>&postid=<?= $id; ?>" title="Editar" class="btn btn-warning btn-sm">Editar</a>
                <?php if($level >= 3): ?>
                    <a href="javascript:void" onclick="DeleteObs(<?= $key['id']; ?>)" title="Deletar" class="btn btn-danger btn-sm">Apagar</a>
                <?php endif; ?>
            </td>
        </tr>
    <?php
    endforeach;
endif;
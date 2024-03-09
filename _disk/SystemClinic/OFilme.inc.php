<?php
$posti = 0;
$getPage = filter_input(INPUT_GET, 'page',FILTER_VALIDATE_INT);
$Pager = new Pager("panel.php?exe=patient/Tratamentos{$n}&postid={$postid}&page=");
$Pager->ExePager($getPage, 10);

$Read = new Read();
$Read->ExeRead("cv_customer_tratamento", "WHERE id_paciente=:i AND id_db_settings=:id ORDER BY id DESC LIMIT :limit OFFSET :offset", "i={$postid}&id={$id_db_settings}&limit={$Pager->getLimit()}&offset={$Pager->getOffset()}");

if($Read->getResult()):
    foreach ($Read->getResult() as $key):
        ?>
        <tr>
            <td><?= $key['id']; ?></td>
            <td><?= $key['data']." ".$key['hora']; ?></td>
            <td><?php $Read->ExeRead("cv_product", "WHERE id=:i ", "i={$key['id_procedimento']}"); if($Read->getResult()): echo $Read->getResult()[0]['product']; endif; ?><br/><small><?= $key["content_data"]; ?></small></td>
            <td><?= $key['dente']; ?></td>
            <td><?= $key['face']; ?></td>
            <td><?php $Read->ExeRead("db_users", "WHERE id=:i ", "i={$key['id_user']}"); if($Read->getResult()): echo $Read->getResult()[0]['name']; endif; ?></td>
            <td>
                <?php if($key['status'] == 1): ?>
                    <a href="javascript:void()" onclick="FinalizarTratamento(<?= $key['id']; ?>, <?= $postid; ?>, <?= $id_db_settings; ?>);" class="btn btn-default btn-sm">Finalizar</a>
                    <a href="javascript:void()" onclick="DeleteTratamento(<?= $key['id']; ?>, <?= $postid; ?>, <?= $id_db_settings; ?>);" class="btn btn-danger btn-sm">Apagar</a>
                <?php endif; ?>
            </td>
        </tr>
        <?php
    endforeach;
endif;
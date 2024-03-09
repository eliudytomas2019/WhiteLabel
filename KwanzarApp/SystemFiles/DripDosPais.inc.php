<?php

$posti = 0;
$getPage = filter_input(INPUT_GET, 'page',FILTER_VALIDATE_INT);
$Pager = new Pager("panel.php?exe=customer/index{$n}&page=");
$Pager->ExePager($getPage, 10);

$read = new Read();
$read->ExeRead("cv_customer", "WHERE id_db_settings=:id ORDER BY id DESC LIMIT :limit OFFSET :offset", "id={$id_db_settings}&limit={$Pager->getLimit()}&offset={$Pager->getOffset()}");
if($read->getResult()):
    foreach ($read->getResult() as $key):
        extract($key);
        ?>
        <tr>
            <td  style="max-width: 50px!important;"><?= $key['id']; ?></td>
            <td><img style="width: 40px!important;height: 40px!important;border-radius: 50%!important;" src="./uploads/<?php if($key['cover'] != ''): echo $key['cover']; else: echo 'default.jpg'; endif;  ?>"</td>
            <td  style="max-width: 200px!important;"><?= $key['nome']; ?></td>
            <td  style="max-width: 200px!important;"><?= $key['nif']; ?></td>
            <td  style="max-width: 200px!important;"><?= $key['telefone']; ?></td>
            <td  style="max-width: 200px!important;"><?= $key['email']; ?></td>
            <td  style="max-width: 200px!important;"><?= $key['endereco']; ?></td>
            <td>
                <a href="?exe=customer/history<?= $n; ?>&postid=<?= $id; ?>" class="btn btn-primary btn-sm">Histório</a>
                <a href="panel.php?exe=customer/update<?= $n; ?>&postid=<?= $id; ?>" title="Editar" class="btn btn-warning btn-sm">Editar</a>
                <?php if($level >= 3): ?>
                    <a href="panel.php?exe=customer/credito<?= $n; ?>&postid=<?= $id; ?>" title="Limite de Crédito" class="btn btn-default btn-sm">Limite de Crédito</a>
                    <a href="javascript:void" onclick="DeleteCustomer(<?= $key['id']; ?>)" title="Deletar" class="btn btn-danger btn-sm">Apagar</a>
                <?php endif; ?>
            </td>
        </tr>
    <?php
    endforeach;
endif;
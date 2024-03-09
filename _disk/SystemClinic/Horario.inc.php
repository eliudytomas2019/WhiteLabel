<?php
$posti = 0;
$getPage = filter_input(INPUT_GET, 'page',FILTER_VALIDATE_INT);
$Pager = new Pager("panel.php?exe=settings/UsersOptions{$n}&id_user={$id_userX}&page=");
$Pager->ExePager($getPage, 25);

$Read = new Read();
$Read->ExeRead("db_users_clinic_horario", "WHERE id_user=:i AND id_db_settings=:id ORDER BY hora_i ASC LIMIT :limit OFFSET :offset", "i={$id_userX}&id={$id_db_settings}&limit={$Pager->getLimit()}&offset={$Pager->getOffset()}");

if($Read->getResult()):
    foreach ($Read->getResult() as $key):
        ?>
        <tr>
            <td><?= $key["id"]; ?></td>
            <td><?= $key["hora_i"]; ?></td>
            <td><?= $key["hora_f"]; ?></td>
            <td><?= str_replace($DaysY, $DaysX, $key['dia_da_semana']); ?></td>
            <td>
                <a href="panel.php?exe=settings/UpdateHorario<?= $n; ?>&id_user=<?= $id_userX; ?>&postId=<?= $key['id']; ?>" class="btn btn-sm btn-warning">Editar</a>
                <a href="#" onclick="DeleteHorario(<?= $key['id']; ?>, <?= $id_userX; ?>);" class="btn btn-sm btn-danger">Apagar</a>
            </td>
        </tr>
    <?php
    endforeach;
endif;
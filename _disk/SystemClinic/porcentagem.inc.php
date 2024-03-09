<?php
$Read = new Read();
$Read->ExeRead("db_settings_clinic_porcentagem", "WHERE id_db_settings=:id ", "id={$id_db_settings}");

if($Read->getResult()):
    foreach ($Read->getResult() as $key):
        ?>
        <tr>
            <td><?= $key["id"]; ?></td>
            <td><?php $Read->ExeRead("db_users", "WHERE id=:i ", "i={$key['id_user']}"); if($Read->getResult()): echo $Read->getResult()[0]['name']; endif; ?></td>
            <td><?= $key["porcentagem"]; ?>%</td>
            <td>
                <a href="" data-bs-toggle="modal" data-bs-target="#modal-porcentagem-de-ganho" class="btn btn-sm btn-warning">Editar</a>
                <a href="#" onclick="DeletePorcentagem(<?= $key['id']?>);" class="btn btn-sm btn-danger">Apagar</a>
            </td>
        </tr>
    <?php
    endforeach;
endif;
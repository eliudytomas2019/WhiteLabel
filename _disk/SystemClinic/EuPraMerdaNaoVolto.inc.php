<?php
if(isset($key['ano'])): $idade = date('Y') - $key['ano']; else: $idade = null; endif;
?>
<tr>
    <td  style="max-width: 50px!important;"><?= $key['id']; ?></td>
    <td><img style="width: 40px!important;height: 40px!important;border-radius: 50%!important;" src="./uploads/<?php if($key['cover'] != ''): echo $key['cover']; else: echo 'default.jpg'; endif;  ?>"</td>
    <td  style="max-width: 200px!important;"><?= $key['nome']; ?></td>
    <td  style="max-width: 200px!important;"><?php if(isset($key['ano'])): ?><?= $key['dia']."/".$Meses[intval($key['mes'])]."/".$key['ano']; ?><?php endif; ?></td>
    <td  style="max-width: 200px!important;"><?php if(isset($key['ano'])): ?> <?= $idade; ?> anos<?php endif; ?></td>
    <td  style="max-width: 200px!important;"><?= $key['sexo']; ?></td>
    <td  style="max-width: 200px!important;"><?= $key['nif']; ?></td>
    <td  style="max-width: 200px!important;"><?= $key['telefone']; ?></td>
    <td  style="max-width: 200px!important;"><?= $key['email']; ?></td>
    <td  style="max-width: 200px!important;"><?= $key['endereco']; ?></td>
    <td>
        <a href="?exe=patient/history<?= $n; ?>&postid=<?= $id; ?>" class="btn btn-default">Procedimentos</a>
        <!--- a href="panel.php?exe=patient/update<?= $n; ?>&postid=<?= $id; ?>" title="Editar" class="btn btn-warning btn-sm">Editar</a --->
    </td>
</tr>
<tr>
    <td colspan="2"></td>
    <td colspan="10">
        <?php
        $Read = new Read();
        $Read->ExeRead("db_clinic_agendamento", "WHERE id_db_settings=:i AND id_paciente=:iv ORDER BY id DESC LIMIT 1", "i={$id_db_settings}&iv={$key['id']}");

        if($Read->getResult()):
            $xDate = explode("-", $Read->getResult()[0]['date_schedule']);
            ?>Última consulta agendada: <?= $xDate[2]." de ".$Meses[intval($xDate[1])]." de ".$xDate[0]; ?><?php
        endif;
        ?>
    </td>
</tr>
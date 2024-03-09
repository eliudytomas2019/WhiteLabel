<?php
$t_v = 0;
$t_g = 0;

$read->ExeRead("{$n3}", "WHERE id_db_settings=:i AND session_id=:idd AND status=:st AND numero=:nn AND SourceBilling=:sc AND InvoiceType=:itt", "i={$id_db_settings}&idd={$id_user}&st={$st}&nn={$key['numero']}&sc={$key['SourceBilling']}&itt={$key['InvoiceType']}");
if($read->getResult()):
    foreach($read->getResult() as $ky):
        $value = $ky['quantidade_pmp'] * $ky['preco_pmp'];
        $desconto = ($value * $ky['desconto_pmp']) / 100;
        $imposto  = ($value * $ky['taxa']) / 100;

        $t_v += ($value - $desconto) + $imposto;
    endforeach;
endif;

?>
<tr>
    <td><?= $key['numero'] ?></td>
    <td><?= $key['InvoiceType']." ".$key['mes']."".$key['Code']."".$key['ano']."/".$key['numero']; ?></td>
    <td><?php $Read = new Read(); $Read->ExeRead("db_users", "WHERE id=:i", "i={$key['session_id']}"); if($Read->getResult()): echo $Read->getResult()[0]['name']; endif; ?></td>
    <td><?= $key['customer_name']; ?></td>
    <td><?= $key['dia']."/".$key['mes']."/".$key['ano']." ".$key['hora']; ?></td>
    <td><?= $key['InvoiceType'] ?></td>
    <td style="width: 350px!important">
        <?php
        if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Impression'] == 'A4' && DBKwanzar::CheckConfig($id_db_settings)['DocModel'] == 2 || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Impression'] == 'A4' && DBKwanzar::CheckConfig($id_db_settings)['DocModel'] == 3 || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Impression'] == 'A4' && DBKwanzar::CheckConfig($id_db_settings)['DocModel'] == 4):
            ?>
            <a href="pdf.php?action=01&post=<?= $key['numero']; ?><?php if($level >= 4): echo '&id_db_settings='.$id_db_settings; endif; ?>&SourceBilling=<?= $key['SourceBilling']; ?>&InvoiceType=<?= $key['InvoiceType']; ?>&dia=<?= $key['dia']; ?>&mes=<?= $key['mes']; ?>&ano=<?= $key['ano']; ?>" target="_blank" class="bol bol-default bol-sm btn btn-primary btn-sm">Imprimir</a>
        <?php else: ?>
            <a href="print.php?action=01&post=<?= $key['numero']; ?><?php if($level >= 4): echo '&id_db_settings='.$id_db_settings; endif; ?>&SourceBilling=<?= $key['SourceBilling']; ?>&InvoiceType=<?= $key['InvoiceType']; ?>&dia=<?= $key['dia']; ?>&mes=<?= $key['mes']; ?>&ano=<?= $key['ano']; ?>" target="_blank" class="bol bol-default bol-sm btn btn-primary btn-sm">Imprimir</a>
        <?php endif; ?>

        <a href="panel.php?exe=proforma/edit&post=<?= $key['numero']; ?><?php if($level >= 4): echo '&id_db_settings='.$id_db_settings; endif; ?>&SourceBilling=<?= $key['SourceBilling']; ?>&InvoiceType=<?= $key['InvoiceType']; ?>&dia=<?= $key['dia']; ?>&mes=<?= $key['mes']; ?>&ano=<?= $key['ano']; ?>" class="btn btn-warning btn-sm">Editar</a>

        <?php
            $Read = new Read();
            $Read->ExeRead("{$n1}", "WHERE id_db_settings=:i AND pp_number=:nn", "i={$id_db_settings}&nn={$key['numero']}");
            if(!$Read->getResult()):
                ?>
                <a href="panel.php?exe=proforma/conversor&postId=<?= $key['numero']; ?><?php if($level >= 4): echo '&id_db_settings='.$id_db_settings; endif; ?>&InvoiceType=<?= $key['InvoiceType']; ?>" class="btn btn-default btn-sm">Converter</a>
                <?php
            endif;
        ?>
    </td>
    <td><?= $key['id']; ?></td>
</tr>
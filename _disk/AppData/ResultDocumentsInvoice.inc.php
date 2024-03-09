<?php
$t_v = 0;
$t_g = 0;

$read->ExeRead("{$n3}", "WHERE id_db_settings=:i AND status=:st AND numero=:nn AND SourceBilling=:sc AND InvoiceType=:itt", "i={$id_db_settings}&st={$st}&nn={$key['numero']}&sc={$key['SourceBilling']}&itt={$key['InvoiceType']}");
if($read->getResult()):
    foreach($read->getResult() as $ky):
        $value = $ky['quantidade_pmp'] * $ky['preco_pmp'];
        if($ky['desconto_pmp'] >= 100):
            $desconto = $ky['desconto_pmp'];
        else:
            $desconto = ($value * $ky['desconto_pmp']) / 100;
        endif;
        //$desconto = ($value * $ky['desconto_pmp']) / 100;
        $imposto  = ($value * $ky['taxa']) / 100;

        $t_v += ($value - $desconto) + $imposto;
    endforeach;
endif;

$read->ExeRead("{$n4}", "WHERE id_db_settings=:i AND status=:st AND id_invoice=:nn AND SourceBilling=:sc", "i={$id_db_settings}&st={$st}&nn={$key['id']}&sc={$key['SourceBilling']}");
if($read->getResult()):
    foreach($read->getResult() as $ey):
        extract($ey);

        $value = $ey['quantidade_pmp'] * $ey['preco_pmp'];
        $desconto = ($value * $ey['desconto_pmp']) / 100;
        $imposto  = ($value * $ey['taxa']) / 100;

        $t_g += ($value - $desconto) + $imposto;
    endforeach;
endif;
?>
<tr>
    <td><?= $key['numero'] ?></td>
    <td><?= $key['InvoiceType']." ".$key['mes']."".$key['Code']."".$key['ano']."/".$key['numero']; ?></td>
    <td><?php $Read = new Read(); $Read->ExeRead("db_users", "WHERE id=:i", "i={$key['session_id']}"); if($Read->getResult()): echo $Read->getResult()[0]['name']; endif; ?></td>
    <td><?= $key['customer_name']; ?></td>
    <td><?php if($key['method'] == 'CC'): echo 'Cartão de Credito'; elseif($key['method'] == 'CD'): echo 'Cartão de Debito'; elseif($key['method'] == 'CH'): echo 'Cheque Bancário'; elseif($key['method'] == 'NU'): echo 'Numerário'; elseif ($key['method'] == 'TB'): echo 'Transferência Bancária'; elseif($key['method'] == 'OU'): echo 'Outros Meios Aqui não Assinalados'; endif; ?></td>
    <td><?= $key['dia']."/".$key['mes']."/".$key['ano']." ".$key['hora']; ?></td>
    <td><?= $key['InvoiceType'] ?></td>
    <td>
        <?php
        if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Impression'] == 'A4' && DBKwanzar::CheckConfig($id_db_settings)['DocModel'] == 2 || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Impression'] == 'A4' && DBKwanzar::CheckConfig($id_db_settings)['DocModel'] == 3 || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Impression'] == 'A4' && DBKwanzar::CheckConfig($id_db_settings)['DocModel'] == 4):
            ?>
            <a href="pdf.php?action=01&post=<?= $key['numero']; ?><?php if($level >= 4): echo '&id_db_settings='.$id_db_settings; endif; ?>&SourceBilling=<?= $key['SourceBilling']; ?>&InvoiceType=<?= $key['InvoiceType']; ?>&dia=<?= $key['dia']; ?>&mes=<?= $key['mes']; ?>&ano=<?= $key['ano']; ?>" target="_blank" class="bol bol-default bol-sm btn btn-primary btn-sm">Imprimir</a>
        <?php else: ?>
            <a href="print.php?action=01&post=<?= $key['numero']; ?><?php if($level >= 4): echo '&id_db_settings='.$id_db_settings; endif; ?>&SourceBilling=<?= $key['SourceBilling']; ?>&InvoiceType=<?= $key['InvoiceType']; ?>&dia=<?= $key['dia']; ?>&mes=<?= $key['mes']; ?>&ano=<?= $key['ano']; ?>" target="_blank" class="bol bol-default bol-sm btn btn-primary btn-sm">Imprimir</a>
        <?php endif; ?>

        <?php

            if($level >= 3):
                if($t_g >= $t_v):
                elseif($t_v > $t_g):
                    if($key['InvoiceType'] != 'PP'):
                        ?>
                        <a href="panel.php?exe=POS/rectify_document&id=<?= $key['id']; ?><?php if($level >= 4): echo '&id_db_settings='.$id_db_settings; endif; ?>&SourceBilling=<?= $key['SourceBilling']; ?>&InvoiceType=<?= $key['InvoiceType']; ?>" class="bol bol-primary bol-sm btn btn-warning btn-sm">Retificar</a>
                    <?php
                    endif;
                endif;
                ?>
                <a href="panel.php?exe=POS/editar&post=<?= $key['numero']; ?><?php if($level >= 4): echo '&id_db_settings='.$id_db_settings; endif; ?>&SourceBilling=<?= $key['SourceBilling']; ?>&InvoiceType=<?= $key['InvoiceType']; ?>&dia=<?= $key['dia']; ?>&mes=<?= $key['mes']; ?>&ano=<?= $key['ano']; ?>" class="bol bol-danger bol-sm btn btn-danger btn-sm">Editar</a>
                <?php
            endif;
            if($key['InvoiceType'] != 'PP'):
                ?>
                <a href="panel.php?exe=POS/generate_transport_guide&id=<?= $key['id']; ?><?php if($level >= 4): echo '&id_db_settings='.$id_db_settings; endif; ?>&SourceBilling=<?= $key['SourceBilling']; ?>&InvoiceType=<?= $key['InvoiceType']; ?>" class="bol bol-default bol-sm btn btn-default btn-sm">Guia de Transporte</a>
                <?php
            endif;
        ?>
    </td>
    <td><?= $key['id']; ?></td>
    <?php
    $Invoice = $key['InvoiceType']." ".$key['mes'].$key['Code'].$key['ano']."/".$key['numero'];
    $read->ExeRead("{$n2}", "WHERE {$n2}.id_db_settings=:i AND {$n2}.session_id=:id AND {$n2}.Invoice=:in AND {$n2}.status=:st AND {$n2}.SourceBilling=:sc", "i={$id_db_settings}&id={$id_user}&in={$Invoice}&st={$st}&sc={$key['SourceBilling']}");

    if($read->getResult()):
    foreach ($read->getResult() as $k):
    ?>
    <tr>
        <td></td>
        <td></td>
        <td><?= $k['numero'] ?></td>
        <td><?php if($k['method'] == 'CC'): echo 'Cartão de Credito'; elseif($k['method'] == 'CD'): echo 'Cartão de Debito'; elseif($k['method'] == 'CH'): echo 'Cheque Bancário'; elseif($k['method'] == 'NU'): echo 'Numerário'; elseif ($k['method'] == 'TB'): echo 'Transferência Bancária'; elseif($k['method'] == 'OU'): echo 'Outros Meios Aqui não Assinalados'; endif; ?></td>
        <td><?php $Read = new Read(); $Read->ExeRead("db_users", "WHERE id=:i", "i={$k['session_id']}"); if($Read->getResult()): echo $Read->getResult()[0]['name']; endif; ?></td>
        <td><?= $k['dia']."/".$k['mes']."/".$k['ano']." ".$k['hora']; ?></td>
        <td><?= $k['InvoiceType'] ?></td>
        <td width="350">
            <?php
            if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Impression'] == 'A4' && DBKwanzar::CheckConfig($id_db_settings)['DocModel'] == 2 || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Impression'] == 'A4' && DBKwanzar::CheckConfig($id_db_settings)['DocModel'] == 3 || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Impression'] == 'A4' && DBKwanzar::CheckConfig($id_db_settings)['DocModel'] == 4):
                ?>
                <a href="pdf.php?action=02&post=<?= $k['numero']; ?><?php if($level >= 4): echo '&id_db_settings='.$id_db_settings; endif; ?>&SourceBilling=<?= $k['SourceBilling']; ?>&InvoiceType=<?= $k['InvoiceType']; ?>&dia=<?= $k['dia']; ?>&mes=<?= $k['mes']; ?>&ano=<?= $k['ano']; ?>&invoice_id=<?= $key['id']; ?>&SourceBilling=<?= $key['SourceBilling']; ?>" target="_blank" class="bol bol-default bol-sm btn btn-primary btn-sm">Imprimir</a>
            <?php else: ?>
                <a href="print.php?action=02&post=<?= $k['numero']; ?><?php if($level >= 4): echo '&id_db_settings='.$id_db_settings; endif; ?>&SourceBilling=<?= $k['SourceBilling']; ?>&InvoiceType=<?= $k['InvoiceType']; ?>&dia=<?= $k['dia']; ?>&mes=<?= $k['mes']; ?>&ano=<?= $k['ano']; ?>&invoice_id=<?= $key['id']; ?>&SourceBilling=<?= $key['SourceBilling']; ?>" target="_blank" class="bol bol-default bol-sm btn btn-primary btn-sm">Imprimir</a>
            <?php endif; ?>
        </td>
        <td><?= $k['id']; ?></td>
    </tr>
<?php
endforeach;
endif;
?>

<?php
$Invoice = $key['InvoiceType']." ".$key['mes'].$key['Code'].$key['ano']."/".$key['numero'];
$read->ExeRead("{$n5}", "WHERE {$n5}.id_db_settings=:i AND {$n5}.session_id=:id AND {$n5}.Invoice=:in AND {$n5}.status=:st AND {$n5}.SourceBilling=:sc", "i={$id_db_settings}&id={$id_user}&in={$Invoice}&st={$st}&sc={$key['SourceBilling']}");

if($read->getResult()):
    foreach ($read->getResult() as $k):
        ?>
        <tr>
            <td></td>
            <td></td>
            <td><?= $k['numero'] ?></td>
            <td><?php if($k['method'] == 'CC'): echo 'Cartão de Credito'; elseif($k['method'] == 'CD'): echo 'Cartão de Debito'; elseif($k['method'] == 'CH'): echo 'Cheque Bancário'; elseif($k['method'] == 'NU'): echo 'Numerário'; elseif ($k['method'] == 'TB'): echo 'Transferência Bancária'; elseif($k['method'] == 'OU'): echo 'Outros Meios Aqui não Assinalados'; endif; ?></td>
            <td><?php $Read = new Read(); $Read->ExeRead("db_users", "WHERE id=:i", "i={$k['session_id']}"); if($Read->getResult()): echo $Read->getResult()[0]['name']; endif; ?></td>
            <td><?= $k['dia']."/".$k['mes']."/".$k['ano']." ".$k['hora']; ?></td>
            <td><?= $k['InvoiceType'] ?></td>
            <td width="350">
                <?php
                if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Impression'] == 'A4' && DBKwanzar::CheckConfig($id_db_settings)['DocModel'] == 2 || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Impression'] == 'A4' && DBKwanzar::CheckConfig($id_db_settings)['DocModel'] == 3 || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Impression'] == 'A4' && DBKwanzar::CheckConfig($id_db_settings)['DocModel'] == 4):
                    ?>
                    <a href="pdf.php?action=03&post=<?= $k['numero']; ?><?php if($level >= 4): echo '&id_db_settings='.$id_db_settings; endif; ?>&SourceBilling=<?= $k['SourceBilling']; ?>&InvoiceType=<?= $k['InvoiceType']; ?>&dia=<?= $k['dia']; ?>&mes=<?= $k['mes']; ?>&ano=<?= $k['ano']; ?>&invoice_id=<?= $key['id']; ?>&SourceBilling=<?= $key['SourceBilling']; ?>" target="_blank" class="bol bol-default bol-sm btn btn-primary btn-sm">Imprimir</a>
                <?php else: ?>
                    <a href="print.php?action=03&post=<?= $k['numero']; ?><?php if($level >= 4): echo '&id_db_settings='.$id_db_settings; endif; ?>&SourceBilling=<?= $k['SourceBilling']; ?>&InvoiceType=<?= $k['InvoiceType']; ?>&dia=<?= $k['dia']; ?>&mes=<?= $k['mes']; ?>&ano=<?= $k['ano']; ?>&invoice_id=<?= $key['id']; ?>&SourceBilling=<?= $key['SourceBilling']; ?>" target="_blank" class="bol bol-default bol-sm btn btn-primary btn-sm">Imprimir</a>
                <?php endif; ?>
            </td>
            <td><?= $k['id']; ?></td>
        </tr>
    <?php
    endforeach;
endif;
?>
</tr>
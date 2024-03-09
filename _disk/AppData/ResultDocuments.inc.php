<tr>
    <td><?= $key['id'] ?></td>
    <td><?= $key['mes'].$key['ano']."/".$key['id']; ?></td>
    <td><?php $Read->ExeRead("cv_customer", "WHERE id=:i", "i={$key['id_customer']}"); if($Read->getResult()): echo $Read->getResult()[0]['nome']; endif; ?></td>
    <td><?php if($key['method'] == 'CC'): echo 'Cartão de Credito'; elseif($key['method'] == 'CD'): echo 'Cartão de Debito'; elseif($key['method'] == 'CH'): echo 'Cheque Bancário'; elseif($key['method'] == 'NU'): echo 'Numerário'; elseif ($key['method'] == 'TB'): echo 'Transferência Bancária'; elseif($key['method'] == 'OU'): echo 'Outros Meios Aqui não Assinalados'; endif; ?></td>
    <td><?= $key['dia']."/".$key['mes']."/".$key['ano']." ".$key['hora']; ?></td>
    <td>
        <a href="pdf.php?action=05&post=<?= $key['id']; ?>&postId=<?= $key['id_customer']; ?>&invoice_id=<?= $key['id_user']; ?><?php if($level >= 4): echo '&id_db_settings='.$id_db_settings; endif; ?>&dia=<?= $key['dia']; ?>&mes=<?= $key['mes']; ?>&ano=<?= $key['ano']; ?>" target="_blank" class="bol bol-default bol-sm btn btn-primary btn-sm">Imprimir</a>
    </td>
</tr>
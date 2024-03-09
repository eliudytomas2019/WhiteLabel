<?php
/**
 * Created by PhpStorm.
 * User: Kwanzar Soft
 * Date: 17/08/2020
 * Time: 11:12
 */
?>
<div class="believer">
    <div class="header_my_modal">
        <a href="javascript:void()" class="close_header">X</a>
    </div>
    <div id="assim">
        <table class="table" style="text-align: left!important;align-content: flex-start!important;align-items: flex-start!important;">
            <thead>
            <tr>
                <th>Número</th>
                <th>Cliente</th>
                <th>Forma de Pagamento</th>
                <th>Data</th>
                <th>Documento</th>
                <th><i class="fas fa-file-contract"></i></th>
            </tr>
            </thead>
            <tbody>
            <?php
            if(DBKwanzar::CheckConfig($id_db_settings) == false || Strong::Config($id_db_settings)['JanuarioSakalumbu'] == 3 || Strong::Config($id_db_settings)['JanuarioSakalumbu'] == '' || Strong::Config($id_db_settings)['JanuarioSakalumbu'] == null):
                $st = 3;
            else:
                $st = 2;
            endif;

            $s = 0;

            $posti = 0;
            $getPage = filter_input(INPUT_GET, 'page',FILTER_VALIDATE_INT);
            $Pager = new Pager('painel.php?exe=billing/index&page=');
            $Pager->ExePager($getPage, 10);

            $n1 = "sd_billing";
            $n3 = "sd_billing_pmp";
            $n2 = "sd_retification";
            $n4 = "sd_retification_pmp";
            $n5 = "sd_guid";
            $n6 = "sd_guid_pmp";

            $read = new Read();
            $read->ExeRead("{$n1}", "WHERE ({$n1}.id_db_settings=:i AND {$n1}.session_id=:id AND {$n1}.status=:st AND {$n1}.suspenso={$s}) ORDER BY {$n1}.id DESC LIMIT :limit OFFSET :offset", "i={$id_db_settings}&id={$id_user}&st={$st}&limit={$Pager->getLimit()}&offset={$Pager->getOffset()}");
            if($read->getResult()):
                foreach ($read->getResult() as $key):
                    extract($key);

                    $t_v = 0;
                    $t_g = 0;

                    $read->ExeRead("{$n3}", "WHERE id_db_settings=:i AND session_id=:idd AND status=:st AND numero=:nn AND SourceBilling=:sc AND InvoiceType=:itt", "i={$id_db_settings}&idd={$id_user}&st={$st}&nn={$key['numero']}&sc={$key['SourceBilling']}&itt={$key['InvoiceType']}");
                    if($read->getResult()):
                        foreach($read->getResult() as $ky):
                            extract($ky);
                            $value = $ky['quantidade_pmp'] * $ky['preco_pmp'];
                            $desconto = ($value * $ky['desconto_pmp']) / 100;
                            $imposto  = ($value * $ky['taxa']) / 100;

                            $t_v += ($value - $desconto) + $imposto;
                        endforeach;
                    endif;

                    $read->ExeRead("{$n4}", "WHERE id_db_settings=:i AND session_id=:idd AND status=:st AND id_invoice=:nn AND SourceBilling=:sc", "i={$id_db_settings}&idd={$id_user}&st={$st}&nn={$key['id']}&sc={$key['SourceBilling']}");
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
                        <td><?= $key['customer_name']; ?></td>
                        <td><?php if($key['method'] == 'CC'): echo 'Cartão de Credito'; elseif($key['method'] == 'CD'): echo 'Cartão de Debito'; elseif($key['method'] == 'CH'): echo 'Cheque Bancário'; elseif($key['method'] == 'NU'): echo 'Numerário'; elseif ($key['method'] == 'TB'): echo 'Transferência Bancária'; elseif($key['method'] == 'OU'): echo 'Outros Meios Aqui não Assinalados'; endif; ?></td>
                        <td><?= $key['dia']."/".$key['mes']."/".$key['ano']." ".$key['hora']; ?></td>
                        <td><?= $key['InvoiceType'] ?></td>
                        <td style="width: 350px!important">
                            <a href="print.php?action=01&post=<?= $key['numero']; ?><?php if($level >= 4): echo '&id_db_settings='.$id_db_settings; endif; ?>&SourceBilling=<?= $key['SourceBilling']; ?>&InvoiceType=<?= $key['InvoiceType']; ?>&dia=<?= $key['dia']; ?>&mes=<?= $key['mes']; ?>&ano=<?= $key['ano']; ?>" target="_blank" class="btns status-off-5">Imprimir</a>
                            <!--- <a href="pdf.php?action=01&post=<?= $key['numero']; ?><?php if($level >= 4): echo '&id_db_settings='.$id_db_settings; endif; ?>&SourceBilling=<?= $key['SourceBilling']; ?>&InvoiceType=<?= $key['InvoiceType']; ?>&dia=<?= $key['dia']; ?>&mes=<?= $key['mes']; ?>&ano=<?= $key['ano']; ?>" target="_blank" class="bol bol-default bol-sm">PDF</a> --->

                            <?php
                            if($level >= 3):
                                if($t_g >= $t_v):
                                elseif($t_v > $t_g):
                                    if($key['InvoiceType'] != 'PP'):
                                        ?>
                                        <a href="docs.php?id=<?= $key['id']; ?><?php if($level >= 4): echo '&id_db_settings='.$id_db_settings; endif; ?>&SourceBilling=<?= $key['SourceBilling']; ?>&InvoiceType=<?= $key['InvoiceType']; ?>" class="btns status-off-2">Retificar</a>
                                        <?php
                                    endif;
                                endif;
                            endif;
                            ?>
                            <?php
                                if($key['InvoiceType'] != 'PP'):
                                    ?>
                                    <a href="guid.php?id=<?= $key['id']; ?><?php if($level >= 4): echo '&id_db_settings='.$id_db_settings; endif; ?>&SourceBilling=<?= $key['SourceBilling']; ?>&InvoiceType=<?= $key['InvoiceType']; ?>" class="btns status-off-5">Guia .T</a>
                                     <?php
                                endif;
                            ?>
                        </td>
                        <?php
                            $In = $key['InvoiceType']." ".$key['mes'].$key['Code'].$key['ano']."/".$key['numero'];
                            $read->ExeRead("{$n5}", "WHERE {$n5}.id_db_settings=:i AND {$n5}.session_id=:id AND {$n5}.Invoice=:in AND {$n5}.status=:st AND {$n5}.SourceBilling=:sc", "i={$id_db_settings}&id={$id_user}&in={$In}&st={$st}&sc={$key['SourceBilling']}");

                            if($read->getResult()):
                                foreach ($read->getResult() as $k):
                                    extract($k);
                                    ?>
                                    <tr>
                                        <td></td>
                                        <td><?= $k['numero'] ?></td>
                                        <td><?php if($k['method'] == 'CC'): echo 'Cartão de Credito'; elseif($k['method'] == 'CD'): echo 'Cartão de Debito'; elseif($k['method'] == 'CH'): echo 'Cheque Bancário'; elseif($k['method'] == 'NU'): echo 'Numerário'; elseif ($k['method'] == 'TB'): echo 'Transferência Bancária'; elseif($k['method'] == 'OU'): echo 'Outros Meios Aqui não Assinalados'; endif; ?></td>
                                        <td><?= $k['dia']."/".$k['mes']."/".$k['ano']." ".$k['hora']; ?></td>
                                        <td><?= $k['InvoiceType'] ?></td>
                                        <td width="250">
                                            <a href="print.php?action=11&post=<?= $k['numero']; ?><?php if($level >= 4): echo '&id_db_settings='.$id_db_settings; endif; ?>&SourceBilling=<?= $k['SourceBilling']; ?>&InvoiceType=<?= $k['InvoiceType']; ?>&dia=<?= $k['dia']; ?>&mes=<?= $k['mes']; ?>&ano=<?= $k['ano']; ?>" target="_blank" class="btns status-off-5">Imprimir</a>
                                        </td>
                                    </tr>
                                    <?php
                                endforeach;
                            endif;
                        ?>
                        <?php
                            $Invoice = $key['InvoiceType']." ".$key['mes'].$key['Code'].$key['ano']."/".$key['numero'];
                            $read->ExeRead("{$n2}", "WHERE {$n2}.id_db_settings=:i AND {$n2}.session_id=:id AND {$n2}.Invoice=:in AND {$n2}.status=:st AND {$n2}.SourceBilling=:sc", "i={$id_db_settings}&id={$id_user}&in={$Invoice}&st={$st}&sc={$key['SourceBilling']}");

                            if($read->getResult()):
                                foreach ($read->getResult() as $k):
                                    extract($k);
                                    ?>
                                    <tr>
                                        <td></td>
                                        <td><?= $k['numero'] ?></td>
                                        <td><?php if($k['method'] == 'CC'): echo 'Cartão de Credito'; elseif($k['method'] == 'CD'): echo 'Cartão de Debito'; elseif($k['method'] == 'CH'): echo 'Cheque Bancário'; elseif($k['method'] == 'NU'): echo 'Numerário'; elseif ($k['method'] == 'TB'): echo 'Transferência Bancária'; elseif($k['method'] == 'OU'): echo 'Outros Meios Aqui não Assinalados'; endif; ?></td>
                                        <td><?= $k['dia']."/".$k['mes']."/".$k['ano']." ".$k['hora']; ?></td>
                                        <td><?= $k['InvoiceType'] ?></td>
                                        <td width="250">
                                            <a href="print.php?action=02&post=<?= $k['numero']; ?><?php if($level >= 4): echo '&id_db_settings='.$id_db_settings; endif; ?>&SourceBilling=<?= $k['SourceBilling']; ?>&InvoiceType=<?= $k['InvoiceType']; ?>&dia=<?= $k['dia']; ?>&mes=<?= $k['mes']; ?>&ano=<?= $k['ano']; ?>" target="_blank" class="btns status-off-5">Imprimir</a>
                                        </td>
                                    </tr>
                                    <?php
                                endforeach;
                            endif;
                        ?>
                    </tr>
                    <?php
                endforeach;
            endif;
            ?>
            </tbody>
        </table>

    </div>
</div>

<?php
/**
 * Created by PhpStorm.
 * User: Kwanzar Soft
 * Date: 13/06/2020
 * Time: 17:53
 */

if(!class_exists('login')):
    header("index.php");
    die();
endif;

if($level >= 4): $n =  '&id_db_settings='.$id_db_settings; else: $n = null; endif;
$postid = strip_tags(trim(filter_input(INPUT_GET, 'postid', FILTER_VALIDATE_INT)));

if($userlogin['level'] < 1):
    header("location: panel.php?exe=default/index".$n);
endif;
?>

<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Registro de atividades</h4>
        <ul class="breadcrumbs">
            <li class="nav-home">
                <a href="<?= HOME; ?>panel.php?exe=default/home<?= $n; ?>">
                    <i class="flaticon-home"></i>
                </a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="<?= HOME; ?>panel.php?exe=customer/index<?= $n; ?>">Clientes</a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="<?= HOME; ?>panel.php?exe=customer/static<?= $n; ?>&postid=<?= $postid; ?>">Registro de atividades</a>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Registro de atividades</div>
                </div>
                <div class="card-body">
                    <table class="table mt-3">
                        <thead>
                        <tr>
                            <th scope="col">Número</th>
                            <th scope="col">Cliente</th>
                            <th scope="col">Documento</th>
                            <th scope="col">Data</th>
                            <th scope="col">M. Pagamento</th>
                            <th scope="col">Vendedor</th>
                            <th scope="col">-</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                            $p1 = "sd_billing"; $p2 = "sd_retification";
                            $n1 = "sd_billing";
                            $n3 = "sd_billing_pmp";
                            $n2 = "sd_retification";
                            $n4 = "sd_retification_pmp";

                            if(DBKwanzar::CheckConfig($id_db_settings) == false || DBKwanzar::CheckConfig($id_db_settings)['JanuarioSakalumbu'] == null): $ttt = 2; else: $ttt = DBKwanzar::CheckConfig($id_db_settings)['JanuarioSakalumbu']; endif;
                            $suspenso = 0;

                            if(Strong::Config($id_db_settings) == false || Strong::Config($id_db_settings)['JanuarioSakalumbu'] == 3 || Strong::Config($id_db_settings)['JanuarioSakalumbu'] == '' || Strong::Config($id_db_settings)['JanuarioSakalumbu'] == null):
                                $st = 3;
                            else:
                                $st = 2;
                            endif;

                            $s = 0;

                            $read = new Read();
                            $read->ExeRead("{$p1}", "WHERE ({$p1}.id_db_settings=:i AND {$p1}.id_customer=:cu AND {$p1}.suspenso={$suspenso} AND {$p1}.status=:st) ORDER BY id DESC ", "i={$id_db_settings}&cu={$postid}&st={$ttt}");

                            if($read->getResult()):
                                foreach($read->getResult() as $key):
                                    extract($key);

                                    $t_v = 0;
                                    $t_g = 0;

                                    $read->ExeRead("{$n3}", "WHERE id_db_settings=:i AND session_id=:idd AND status=:st AND numero=:nn AND SourceBilling=:sc", "i={$id_db_settings}&idd={$id_user}&st={$st}&nn={$key['numero']}&sc={$key['SourceBilling']}");
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
                                        <td><?= $key['InvoiceType'] ?></td>
                                        <td><?= $key['dia']."/".$key['mes']."/".$key['ano']." ".$key['hora']; ?></td>
                                        <td><?php if($key['method'] == 'CC'): echo 'Cartão de Credito'; elseif($key['method'] == 'CD'): echo 'Cartão de Debito'; elseif($key['method'] == 'CH'): echo 'Cheque Bancário'; elseif($key['method'] == 'NU'): echo 'Numerário'; elseif ($key['method'] == 'TB'): echo 'Transferência Bancária'; elseif($key['method'] == 'OU'): echo 'Outros Meios Aqui não Assinalados'; endif; ?></td>
                                        <td><?= $key['username']; ?></td>
                                        <td>
                                            <a href="<?= HOME; ?>print.php?action=01&post=<?= $key['numero']; ?><?php if($level >= 4): echo '&id_db_settings='.$id_db_settings; endif; ?>&SourceBilling=<?= $key['SourceBilling']; ?>" target="_blank" class="btn btn-default btn-sm">Imprimir</a>

                                            <?php
                                            if($t_g >= $t_v):
                                            elseif($t_v > $t_g):
                                                if($key['InvoiceType'] != 'PP'):
                                                    ?>
                                                    <a href="<?= HOME; ?>docs.php?id=<?= $key['id']; ?><?php if($level >= 4): echo '&id_db_settings='.$id_db_settings; endif; ?>&SourceBilling=<?= $key['SourceBilling']; ?>" class="btn btn-warning btn-sm">Retificar</a>
                                                    <?php
                                                endif;
                                            endif;
                                            ?>
                                        </td>
                                    </tr>
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
                                                    <td><?= $k['InvoiceType'] ?></td>
                                                    <td><?= $k['dia']."/".$k['mes']."/".$k['ano']." ".$k['hora']; ?></td>
                                                    <td><?php if($k['method'] == 'CC'): echo 'Cartão de Credito'; elseif($k['method'] == 'CD'): echo 'Cartão de Debito'; elseif($k['method'] == 'CH'): echo 'Cheque Bancário'; elseif($k['method'] == 'NU'): echo 'Numerário'; elseif ($k['method'] == 'TB'): echo 'Transferência Bancária'; elseif($k['method'] == 'OU'): echo 'Outros Meios Aqui não Assinalados'; endif; ?></td>
                                                    <td><?= $k['username']; ?></td>
                                                    <td width="350">
                                                        <a href="<?= HOME; ?>print.php?action=02&post=<?= $k['numero']; ?><?php if($level >= 4): echo '&id_db_settings='.$id_db_settings; endif; ?>&SourceBilling=<?= $k['SourceBilling']; ?>" target="_blank" class="btn btn-default btn-sm">Imprimir</a>
                                                    </td>
                                                </tr>
                                                <?php
                                            endforeach;
                                        endif;
                                    ?>
                                    <?php
                                endforeach;
                            endif;
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
/**
 * Created by PhpStorm.
 * User: Kwanzar Soft
 * Date: 05/08/2020
 * Time: 22:02
 */
?>
<div class="content">
    <div class="panel-header bg-primary-gradient">
        <div class="page-inner py-5">
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                <div>
                    <h2 class="text-white pb-2 fw-bold">Pesquisa: <?= $h; ?></h2>
                </div>

                <div class="ml-md-auto py-2 py-md-0">
                    <a href="<?= HOME; ?>panel.php?exe=default/home<?= $n; ?>" class="btn btn-secondary btn-round">Voltar ao cPanel</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <br/>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title"><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Clientes"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "客户端"; endif; ?></h4>

                    <div class="table-responsive">
                        <div id="aPaulo"></div>
                        <table class="table">
                            <thead>
                            <tr>
                                <th><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "NOME"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "名称"; endif; ?></th>
                                <th><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "TIPO"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "类型"; endif; ?></th>
                                <th><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "TELEFONE"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "电话 "; endif; ?></th>
                                <th><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "E-MAIL"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "电子邮件"; endif; ?></th>
                                <th width="290">-</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php

                            $read->ExeRead("cv_customer", "WHERE (id_db_settings=:id AND nome LIKE '%' :link '%') OR (id_db_settings=:id AND nif LIKE '%' :link '%') ", "id={$id_db_settings}&link={$h}");
                            if($read->getResult()):
                                $result0001 += $read->getRowCount();
                                foreach ($read->getResult() as $key):
                                    extract($key);
                                    ?>
                                    <tr>
                                        <td><?= $key['nome']; ?></td>
                                        <td><?= $key['type']; ?></td>
                                        <td><?= $key['telefone']; ?></td>
                                        <td><?= $key['email']; ?></td>
                                        <td width="150">
                                            <a href="<?= HOME; ?>panel.php?exe=customer/static<?= $n; ?>&postid=<?= $id; ?>" class="btn btn-primary btn-sm"><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Histórico"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "故事"; endif; ?></a>
                                            <a href="<?= HOME; ?>panel.php?exe=customer/update<?= $n; ?>&postid=<?= $id; ?>" title="Editar" class="btn btn-warning btn-sm"><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Editar"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "编辑"; endif; ?></a>
                                            <?php if($_SESSION['userlogin']['level'] >= 3): ?>
                                                <a href="javascript:void" onclick="DeleteCustomer(<?= $key['id']; ?>)" title="Deletar" class="btn btn-danger btn-sm"><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Eliminar"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "消除"; endif; ?></a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
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


    <br/>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title">Categorias</h2>
                    <div class="table-responsive" id="getResult">
                        <table class="table">
                            <thead>
                            <tr>
                                <th width="10">RES.</th>
                                <th width="40">CATEGORIA</th>
                                <th>DESCRIÇÃO</th>
                                <th>DATA</th>
                                <th width="300">-</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $read = new Read();
                            $read->ExeRead("cv_category", "WHERE id_db_settings=:id AND category_title LIKE '%' :link '%' ", "id={$id_db_settings}&link={$h}");
                            if($read->getResult()):
                                $result0001 += $read->getRowCount();
                                foreach ($read->getResult() as $key):
                                    extract($key);
                                    ?>
                                    <tr>
                                        <td><?= $key['id']; ?></td>
                                        <td><?= $key['category_title']; ?></td>
                                        <td><?= $key['category_content']; ?></td>
                                        <td><?= $key['category_data']; ?></td>
                                        <td>
                                            <a href="<?= HOME; ?>panel.php?exe=category/update<?= $n; ?>&postid=<?= $id; ?>" title="Editar" class="btn btn-warning btn-sm">Editar</a>
                                            <a href="" title="Deletar" class="btn btn-danger btn-sm" onclick="DeleteCategory(<?= $id; ?>)">Apagar</a>
                                        </td>
                                    </tr>
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

    <br/>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body" id="getResult">
                    <h2 class="card-title"><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Produtos & Estoque"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "产品/股票"; endif; ?></h2>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Res"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "rês"; endif; ?></th>
                                <th><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Cover"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "Cover"; endif; ?></th>
                                <th><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Código"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "代码"; endif; ?></th>
                                <th><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Produto/Serviço"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "产品/服务"; endif; ?></th>
                                <th><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Preço Venda"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "销售价格"; endif; ?></th>
                                <th><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Quantidade"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "数量"; endif; ?></th>
                                <th style="width: 300px!important;">-</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php

                            $read->ExeRead("cv_product", "WHERE id_db_settings=:id AND product LIKE '%' :link '%' ", "id={$id_db_settings}&link={$h}");
                            if($read->getResult()):
                                foreach ($read->getResult() as $key):
                                    extract($key);
                                    $result0001 += 1;
                                    ?>
                                    <tr>
                                        <td><?= $key['id']; ?></td>
                                        <td><img style="width: 40px!important;height: 40px!important;border-radius: 50%!important;" src="./uploads/<?php if($key['cover'] != ''): echo $key['cover']; else: echo 'default.jpg'; endif;  ?>"</td>
                                        <td><?= $key['codigo']; ?></td>
                                        <td><?= $key['product']; ?></td>
                                        <td><?= number_format($key['preco_venda'], 2); ?></td>
                                        <td><?= number_format($key['quantidade'], 2); ?></td>
                                        <td>
                                            <a href="<?= HOME; ?>panel.php?exe=product/product-promotions<?= $n; ?>&postid=<?= $key['id']; ?>" class="btn btn-primary btn-sm" title="promoções">Promoções</a>
                                            <a href="<?= HOME; ?>panel.php?exe=product/update<?= $n; ?>&postid=<?= $key['id']; ?>" title="Editar" class="btn btn-warning btn-sm"><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Editar"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "编辑"; endif; ?></a>
                                            <a href="" onclick="DeleteProduct(<?= $key['id']?>)" title="Deletar" class="btn btn-danger btn-sm"><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Eliminar"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "消除"; endif; ?></a>
                                        </td>
                                    </tr>
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

    <br/>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Documentos comercial</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive" id="King">
                            <table class="table" style="text-align: left!important;align-content: flex-start!important;align-items: flex-start!important;">
                                <thead>
                                <tr>
                                    <th>Número</th>
                                    <th>Cliente</th>
                                    <th>Forma de Pagamento</th>
                                    <th>Data</th>
                                    <th>Documento</th>
                                    <th style="width: 350px!important">-</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                if(Strong::Config($id_db_settings) == false || Strong::Config($id_db_settings)['JanuarioSakalumbu'] == 3 || Strong::Config($id_db_settings)['JanuarioSakalumbu'] == '' || Strong::Config($id_db_settings)['JanuarioSakalumbu'] == null):
                                    $st = 3;
                                else:
                                    $st = 2;
                                endif;

                                $s = 0;

                                $n1 = "sd_billing";
                                $n3 = "sd_billing_pmp";
                                $n2 = "sd_retification";
                                $n4 = "sd_retification_pmp";
                                $n5 = "sd_guid";

                                $read = new Read();
                                $read->ExeRead("{$n1}", "WHERE ({$n1}.id_db_settings=:i AND numero LIKE '%' :link '%'  AND  {$n1}.status=:st AND {$n1}.suspenso={$s}) OR ({$n1}.id_db_settings=:i AND customer_nif LIKE '%' :link '%'  AND  {$n1}.status=:st AND {$n1}.suspenso={$s}) OR ({$n1}.id_db_settings=:i AND customer_name LIKE '%' :link '%'  AND  {$n1}.status=:st AND {$n1}.suspenso={$s}) OR ({$n1}.id_db_settings=:i AND username LIKE '%' :link '%'  AND  {$n1}.status=:st AND {$n1}.suspenso={$s})", "i={$id_db_settings}&link={$h}&st={$st}");
                                if($read->getResult()):
                                    foreach ($read->getResult() as $key):
                                        extract($key);

                                        $t_v = 0;
                                        $t_g = 0;

                                        $read->ExeRead("{$n3}", "WHERE id_db_settings=:i AND status=:st AND numero=:nn AND InvoiceType=:itt", "i={$id_db_settings}&st={$st}&nn={$key['numero']}&itt={$key['InvoiceType']}");
                                        if($read->getResult()):
                                            foreach($read->getResult() as $ky):
                                                extract($ky);
                                                $value = $ky['quantidade_pmp'] * $ky['preco_pmp'];
                                                $desconto = ($value * $ky['desconto_pmp']) / 100;
                                                $imposto  = ($value * $ky['taxa']) / 100;

                                                $t_v += ($value - $desconto) + $imposto;
                                            endforeach;
                                        endif;

                                        $read->ExeRead("{$n4}", "WHERE id_db_settings=:i AND status=:st AND id_invoice=:nn", "i={$id_db_settings}&st={$st}&nn={$key['id']}");
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
                                                <a href="print.php?action=01&post=<?= $key['numero']; ?><?php if($level >= 4): echo '&id_db_settings='.$id_db_settings; endif; ?>&SourceBilling=<?= $key['SourceBilling']; ?>&InvoiceType=<?= $key['InvoiceType']; ?>&dia=<?= $key['dia']; ?>&mes=<?= $key['mes']; ?>&ano=<?= $key['ano']; ?>" target="_blank" class="bol bol-default bol-sm">Imprimir</a>
                                                <!--- <a href="pdf.php?action=01&post=<?= $key['numero']; ?><?php if($level >= 4): echo '&id_db_settings='.$id_db_settings; endif; ?>&SourceBilling=<?= $key['SourceBilling']; ?>&InvoiceType=<?= $key['InvoiceType']; ?>&dia=<?= $key['dia']; ?>&mes=<?= $key['mes']; ?>&ano=<?= $key['ano']; ?>" target="_blank" class="bol bol-default bol-sm">PDF</a> --->

                                                <?php
                                                if($t_g >= $t_v):
                                                elseif($t_v > $t_g):
                                                    if($key['InvoiceType'] != 'PP'):
                                                        ?>
                                                        <a href="docs.php?id=<?= $key['id']; ?><?php if($level >= 4): echo '&id_db_settings='.$id_db_settings; endif; ?>&SourceBilling=<?= $key['SourceBilling']; ?>&InvoiceType=<?= $key['InvoiceType']; ?>" class="bol bol-primary bol-sm">Retificar</a>
                                                        <?php
                                                    endif;
                                                endif;
                                                ?>
                                                <?php
                                                    if($key['InvoiceType'] != 'PP'):
                                                        ?>
                                                        <a href="guid.php?id=<?= $key['id']; ?><?php if($level >= 4): echo '&id_db_settings='.$id_db_settings; endif; ?>&SourceBilling=<?= $key['SourceBilling']; ?>&InvoiceType=<?= $key['InvoiceType']; ?>" class="bol bol-default bol-sm">Guia .T</a>
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
                                                            <td width="350">
                                                                <a href="print.php?action=11&post=<?= $k['numero']; ?><?php if($level >= 4): echo '&id_db_settings='.$id_db_settings; endif; ?>&SourceBilling=<?= $k['SourceBilling']; ?>&InvoiceType=<?= $k['InvoiceType']; ?>&dia=<?= $k['dia']; ?>&mes=<?= $k['mes']; ?>&ano=<?= $k['ano']; ?>" target="_blank" class="bol bol-default bol-sm">Imprimir</a>
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
                                                            <td width="350">
                                                                <a href="print.php?action=02&post=<?= $k['numero']; ?><?php if($level >= 4): echo '&id_db_settings='.$id_db_settings; endif; ?>&SourceBilling=<?= $k['SourceBilling']; ?>&InvoiceType=<?= $k['InvoiceType']; ?>&dia=<?= $k['dia']; ?>&mes=<?= $k['mes']; ?>&ano=<?= $k['ano']; ?>" target="_blank" class="bol bol-default bol-sm">Imprimir</a>
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
                </div>
            </div>
        </div>
</div>
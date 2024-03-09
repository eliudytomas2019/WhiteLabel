<?php
/**
 * Created by PhpStorm.
 * User: Kwanzar Soft
 * Date: 13/05/2020
 * Time: 00:56
 */

$acao = strip_tags((filter_input(INPUT_POST, 'acao', FILTER_DEFAULT)));

if($acao):
    if(isset($_POST['id_db_kwanzar'])):  $id_db_kwanzar = (int) $_POST['id_db_kwanzar']; endif;
    if(isset($_POST['id_db_settings'])): $id_db_settings = (int) $_POST['id_db_settings']; endif;
    if(isset($_POST['id_user'])):        $id_user = (int) $_POST['id_user']; endif;
    if(isset($_POST['level'])):          $level = (int) $_POST['level']; endif;
    require_once("../../Config.inc.php");

    $read = new Read();
    switch ($acao):
        case 'PorcentagemP':
            $porcentagem  = (float) $_POST['porcentagem'];
            $CustoCompraP = (float) $_POST['custo_compra'];

            $fv = ($CustoCompraP + ($CustoCompraP * $porcentagem) / 100);
            echo $fv;

            break;
        case 'searchPurchase':
            $txt = strip_tags(trim($_POST['txt']));

            if($level >= 4): $n =  '&id_db_settings='.$id_db_settings; else: $n = null; endif;

            $read->ExeRead("cv_product", "WHERE (id_db_settings=:id AND product LIKE '%' :link '%') ORDER BY product ASC", "id={$id_db_settings}&link={$txt}");

            if($read->getResult()):
                foreach ($read->getResult() as $waya):
                    $Status = ["Exgotado", "Activo", "Suspenso"];
                    $s = 1;
                    $read->ExeRead("sd_purchase", "WHERE id_db_settings=:id AND id_product=:ip AND status=:s ORDER BY id  DESC", "id={$id_db_settings}&ip={$waya['id']}&s={$s}");
                    if($read->getResult()):
                        foreach ($read->getResult() as $key):
                            ?>
                            <tr>
                                <td><?= $key['id']; ?></td>
                                <td><?php $read->ExeRead("cv_product", "WHERE id=:i AND id_db_settings=:ip", "i={$key['id_product']}&ip={$id_db_settings}"); if($read->getResult()): echo $read->getResult()[0]['product']; endif; ?></td>
                                <td><?= number_format($key['preco_compra'], 2); ?></td>
                                <td><?= number_format($key['quantidade'], 2); ?></td>
                                <td><?= number_format($key['unidade'], 2); ?></td>
                                <td><?= $key['data_lanca']; ?></td>
                                <td><?= $key['dateEx']; ?></td>
                                <td><?= $Status[$key['status']]; ?></td>
                                <td>
                                    <a href="<?= HOME; ?>panel.php?exe=purchase/create&postid=<?= $key['id']; ?><?= $n; ?>" class="btn btn-primary btn-sm">Mover para loja</a>
                                    &nbsp;<a href="<?= HOME; ?>panel.php?exe=purchase/update&postid=<?= $key['id']; ?><?= $n; ?>" class="btn btn-sm btn-warning">Saída de Estoque</a>
                                </td>
                            </tr>
                            <?php
                        endforeach;
                    endif;
                endforeach;
            endif;

            break;
        case 'searchProductTxt':
            $txt = strip_tags(trim($_POST['txt']));

            if($level >= 4): $n =  '&id_db_settings='.$id_db_settings; else: $n = null; endif;

            $read->ExeRead("cv_product", "WHERE (id_db_settings=:id AND product LIKE '%' :link '%') OR (id_db_settings=:id AND codigo LIKE '%' :link '%') OR (id_db_settings=:id AND codigo_barras LIKE '%' :link '%') ORDER BY product ASC", "id={$id_db_settings}&link={$txt}");

            if($read->getResult()):
                foreach ($read->getResult() as $key):
                    //extract($key);
                    $promocao = explode("-", $key['data_fim_promocao']);
                    if($promocao[0] >= date('Y')):
                        if($promocao[1] >= date('m')):
                            if($promocao[2] >= date('d')):
                                $preco = $key['preco_promocao'];
                            else:
                                $preco = $key['preco_promocao'];
                            endif;
                        else:
                            $preco = $key['preco_promocao'];
                        endif;
                    elseif($promocao[0] < date('Y')):
                        $preco = $key['preco_venda'];
                    endif;


                    $DB = new DBKwanzar();
                    /*if($DB->CheckCpanelAndSettings($id_db_settings)['atividade'] == 1 || $DB->CheckCpanelAndSettings($id_db_settings)['atividade'] == 4):
                        $NnM = $key['quantidade'];
                    else:
                        $NnM = $key['gQtd'];
                    endif;*/

                    $NnM = $key['quantidade'];
                    ?>
                    <tr>
                        <td><?= $key['codigo']; ?></td>
                        <td><img style="width: 40px!important;height: 40px!important;border-radius: 50%!important;" src="./uploads/<?php if($key['cover'] != ''): echo $key['cover']; else: echo 'default.jpg'; endif;  ?>"</td>
                        <td title="<?= $key['product']; ?>"><?= $key['product']; ?></td>
                        <td><?= $key['codigo_barras']; ?></td>
                        <td><?= number_format($key["quantidade"], 2); ?></td>
                        <td><?= str_replace(",", ".", number_format($preco, 2)); ?> AOA</td>
                        <td><?= $key["local_product"]; ?></td>
                        <td><?= $key["remarks"]; ?></td>
                        <td>
                            <a href="panel.php?exe=product/product-promotions<?= $n; ?>&postid=<?= $key['id']; ?>" class="btn btn-default btn-sm" title="Preço promocional">Preço promocional</a>
                            <?php if($key['IE_commerce'] == 2): ?><a href="<?= HOME; ?>panel.php?exe=product/gallery<?= $n; ?>&postid=<?= $key['id']; ?>" class="btn btn-sm btn-primary">Galeria</a><?php endif; ?>
                            <a href="panel.php?exe=product/update<?= $n; ?>&postid=<?= $key['id']; ?>" title="Editar" class="btn btn-warning btn-sm">Editar</a>
                            <a href="javascript:void()" onclick="DeleteProduct(<?= $key['id']?>)" title="Eliminar" class="btn btn-danger btn-sm">Eliminar</a>
                        </td>
                    </tr>
                    <?php
                endforeach;
            endif;

            break;
        case 'QuandoOKumbuCair':
            $type = "P";
            $txt = strip_tags(trim($_POST['txt']));

            $qtd = 0;
            $uni = 0;
            $custo_total = 0;
            $preco_total = 0;
            $lucro_total = 0;

            if($level >= 4): $n =  '&id_db_settings='.$id_db_settings; else: $n = null; endif;

            $read->ExeRead("cv_product", "WHERE (id_db_settings=:id AND type=:t AND product LIKE '%' :link '%') OR (id_db_settings=:id AND type=:t AND codigo LIKE '%' :link '%') OR (id_db_settings=:id AND type=:t AND codigo_barras LIKE '%' :link '%') ORDER BY product ASC LIMIT 10", "id={$id_db_settings}&t={$type}&link={$txt}");

            if($read->getResult()):
                foreach ($read->getResult() as $key):
                    $qtd += $key["quantidade"];
                    $uni += $key["quantidade"] * $key["unidades"];
                    $custo_total += $key["custo_compra"];
                    $preco_total += $key["preco_venda"];

                    /**$DB = new DBKwanzar();
                    if($DB->CheckCpanelAndSettings($id_db_settings)['atividade'] == 1 || $DB->CheckCpanelAndSettings($id_db_settings)['atividade'] == 4):
                        $NnM = $key['quantidade'];
                    else:
                        $NnM = ($key['quantidade'] * $key["unidades"]);
                    endif;**/

                    $NnM = $key['quantidade'];

                    $in_total = ($NnM * $key["preco_venda"]) - $key["custo_compra"];
                    $lucro_total += $in_total;
                    require("../../_disk/AppData/PauloRikardo2.inc.php");
                endforeach;
            endif;

            break;
        case 'SearchSpending':
            if($level >= 4): $n =  '&id_db_settings='.$id_db_settings; else: $n = null; endif;
            if(isset($_POST['dateI'])):           $dateI           = strip_tags(($_POST['dateI'])); endif;
            if(isset($_POST['dateF'])):           $dateF           = strip_tags(($_POST['dateF'])); endif;

            $dI = explode("-", $dateI);
            $dF = explode("-", $dateF);

            if(!empty($dateI) && !empty($dateF)):
                $t_1 = 0;
                $t_2 = 0;
                $t_3 = 0;

                ?>
                <a href="<?= HOME; ?>print.php?action=06&dateI=<?= $dateI; ?>&dateF=<?= $dateF; ?><?= $n; ?>" class="btn btn-primary btn-sm" target="_blank">Imprimir</a>
                <div class="card-body">

                    <table class="table table-striped mt-3">
                        <thead>
                        <tr>
                            <th scope="col">Data</th>
                            <th scope="col">Descrição</th>
                            <th scope="col">Qtd</th>
                            <th scope="col">Preço</th>
                            <th scope="col">Usuário</th>
                            <th scope="col">Entrada</th>
                            <th scope="col">Saída</th>
                            <th scope="col">Investimento</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php

                            $read = new Read();
                            $read->ExeRead("sd_spending", "WHERE id_db_settings=:i AND (dia BETWEEN {$dI[2]} AND {$dF[2]}) AND (mes BETWEEN {$dI[1]} AND {$dF[1]}) AND (ano BETWEEN {$dI[0]} AND {$dF[0]}) ORDER BY id ASC", "i={$id_db_settings}");

                            if($read->getResult()):
                                foreach($read->getResult() as $key):
                                    extract($key);
                                    ?>
                                    <tr>
                                        <td><?= $key['dia']."/".$key['mes']."/".$key['ano']; ?></td>
                                        <td><?= $key['descricao'] ?></td>
                                        <td><?= $key['quantidade'] ?></td>
                                        <td><?= number_format($key['preco'], 2) ?></td>
                                        <td><?php $read->ExeRead("db_users", "WHERE id=:i", "i={$key['session_id']}"); if($read->getResult()): echo $read->getResult()[0]['name']; endif; ?></td>
                                        <?php
                                        if($key['natureza'] == "E"):
                                            $t_1 += $key['quantidade'] * $key['preco'];
                                            ?>
                                            <td><?= number_format($key['quantidade'] * $key['preco'], 2); ?></td>
                                            <td></td>
                                            <td></td>
                                            <?php
                                        elseif($key['natureza'] == 'S'):
                                            $t_2 += $key['quantidade'] * $key['preco'];
                                            ?>
                                            <td></td>
                                            <td><?= number_format($key['quantidade'] * $key['preco'], 2); ?></td>
                                            <td></td>
                                            <?php
                                        else:
                                            $t_3 += $key['quantidade'] * $key['preco'];
                                            ?>
                                            <td></td>
                                            <td></td>
                                            <td><?= number_format($key['quantidade'] * $key['preco'], 2); ?></td>
                                            <?php
                                        endif;
                                        ?>
                                    </tr>
                                    <?php
                                endforeach;
                            endif;
                            ?>
                         </tbody>
                        <tfoot>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>TOTAL =></td>
                            <td><?= number_format($t_1, 2); ?></td>
                            <td><?= number_format($t_2, 2); ?></td>
                            <td><?= number_format($t_3, 2); ?></td>
                            <td></td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
                <?php
            else:
                WSError("Ops: preencha a data para prosseguir com o processo!", WS_INFOR);
            endif;

            break;
        case 'DeleteSpending':
            $id = (int) $_POST['id'];

            $Spending = new Spending();
            $Spending->ExeDelete($id, $id_db_settings);

            WSError($Spending->getError()[0], $Spending->getError()[1]);

            break;
        case 'Spending':
            $Data['descricao'] = strip_tags($_POST['descricao']);
            $Data['preco'] = strip_tags(($_POST['preco']));
            $Data['natureza'] = strip_tags(($_POST['natureza']));
            $Data['quantidade'] = strip_tags(($_POST['quantidade']));

            $Spending = new Spending();
            $Spending->ExeSpending($Data, $id_db_settings, $id_user);

            WSError($Spending->getError()[0], $Spending->getError()[1]);

            break;
        case 'SearchDays':
            if($level >= 4): $n =  '&id_db_settings='.$id_db_settings; else: $n = null; endif;
            if(isset($_POST['dateI'])):           $dateI           = strip_tags(($_POST['dateI'])); endif;
            if(isset($_POST['dateF'])):           $dateF           = strip_tags(($_POST['dateF'])); endif;

            $dI = explode("-", $dateI);
            $dF = explode("-", $dateF);

            if(!empty($dateI) && !empty($dateF)):
                $s_total = 0;

                $Read = new Read();
                $read = new Read();
                $Read->ExeRead("sd_purchase", "WHERE (id_db_settings=:i) AND (dia BETWEEN {$dI[2]} AND {$dF[2]}) AND (mes BETWEEN {$dI[1]} AND {$dF[1]}) AND (ano BETWEEN {$dI[0]} AND {$dF[0]}) ORDER BY id DESC ", "i={$id_db_settings}");


                ?>
                <a href="<?= HOME; ?>print.php?action=04&dateI=<?= $dateI; ?>&dateF=<?= $dateF; ?><?= $n; ?>" class="btn btn-primary btn-sm" target="_blank">Imprimir</a>

                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>FORNECEDOR</th>
                            <th>PRODUTO</th>
                            <th>DATA DE FABRICO</th>
                            <th>DATA DE EXPIRAÇÃO</th>
                            <th>UNIDADES</th>
                            <th>QUANTIDADE</th>
                            <th>PREÇO</th>
                            <th>TOTAL</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                            if($Read->getResult()):
                                foreach($Read->getResult() as $key):
                                    extract($key);
                                    ?>
                                    <tr>
                                        <td><?php $read->ExeRead("cv_supplier", "WHERE id=:i AND id_db_settings=:ip", "i={$key['id_supplier']}&ip={$id_db_settings}"); if($read->getResult()): echo $read->getResult()[0]['nome']; endif;  ?></td>
                                        <td>
                                            <?php
                                                $read->ExeRead("cv_product", "WHERE id=:i AND id_db_settings=:ip", "i={$key['id_product']}&ip={$id_db_settings}");
                                                if($read->getResult()): echo $read->getResult()[0]['product']; endif;
                                            ?>
                                        </td>
                                        <?php

                                        $ipX = 0;
                                        $Read->ExeRead("sd_purchase_story", "WHERE id_sd_purchase=:i", "i={$key['id']}");
                                        if($Read->getResult()):
                                            foreach($Read->getResult() as $k):
                                                extract($k);
                                                $ipX += $k['qtd'];
                                            endforeach;
                                        endif;

                                        $total = ($key['quantidade'] + $ipX) * $key['preco_compra'];
                                        $s_total += $total;
                                        ?>
                                        <td><?= $key['dateF'] ?></td>
                                        <td><?= $key['dateEx'] ?></td>
                                        <td><?= number_format($key['unidade'], 2); ?></td>
                                        <td><?= number_format($key['quantidade'] + $ipX, 2) ?></td>
                                        <td><?= number_format($key['preco_compra'], 2) ?></td>
                                        <td><?= number_format($total, 2); ?></td>
                                    </tr>
                                    <?php
                                endforeach;
                            endif;
                        ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>Total Geral =></td>
                                <td><?= number_format($s_total, 2);?></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <?php
            else:
                WSError("Ops: preencha a data para prosseguir com o processo!", WS_INFOR);
            endif;

            break;
        case 'TreePurchase':
            $id                 = strip_tags(($_POST['id']));
            $Data['quantidade'] = strip_tags(($_POST['quantidade']));
            $Data['unidade']    = strip_tags(($_POST['unidade']));
            $Data['Type']       = strip_tags(($_POST['Type']));

            $Purchase = new Purchase();
            $Purchase->TreePurchase($Data, $id, $id_db_settings, $id_user);

            WSError($Purchase->getError()[0], $Purchase->getError()[1]);

            break;
        case 'TwoPurchase':
            $id = strip_tags(($_POST['id']));
            $Data['quantidade'] = strip_tags(($_POST['quantidade']));
            $Data['unidade'] = strip_tags(($_POST['unidade']));

            $Purchase = new Purchase();
            $Purchase->ExeExport($Data, $id, $id_db_settings, $id_user);

            WSError($Purchase->getError()[0], $Purchase->getError()[1]);

            break;
        case 'ForPurchase':
            $id = strip_tags(($_POST['id']));
            $Data['quantidade'] = strip_tags(($_POST['quantidade']));
            $Data['unidade'] = strip_tags(($_POST['unidade']));

            $Purchase = new Purchase();
            $Purchase->ExeExportTwo($Data, $id, $id_db_settings, $id_user);

            WSError($Purchase->getError()[0], $Purchase->getError()[1]);

            break;
        case 'NoN':
            require_once("../SystemFiles/search-purchase-settings.inc.php");
            break;
        case 'FormPurchase':
            $Data['id_product'] = strip_tags(($_POST['id_product']));
            //$Data['id_supplier'] = strip_tags(($_POST['id_supplier']));
            //$Data['data_lanca'] = strip_tags(($_POST['data_lanca']));
            $Data['quantidade'] = strip_tags(($_POST['quantidade']));
            $Data['unidade'] = strip_tags(($_POST['unidade']));
            //$Data['preco_compra'] = strip_tags(($_POST['preco_compra']));
            //$Data['description'] =  strip_tags($_POST['description']);
            //$Data['dateF'] = strip_tags(($_POST['dateF']));
            //$Data['dateEx'] = strip_tags(($_POST['dateEx']));

            $Purchase = new Purchase();
            $Purchase->ExePurchase($Data, $id_db_settings, $id_user);

            WSError($Purchase->getError()[0], $Purchase->getError()[1]);

            break;
        case 'FormCreateCustomer':
            $Data['nome'] = strip_tags(($_POST['nome']));
            $Data['nif'] = strip_tags(($_POST['nif']));
            $Data['telefone'] = strip_tags(($_POST['telefone']));
            $Data['email'] = strip_tags(($_POST['email']));
            $Data['endereco'] = strip_tags(($_POST['endereco']));
            $Data['type'] = strip_tags(($_POST['type']));
            $Data['addressDetail'] = strip_tags(($_POST['endereco']));
            $Data['city'] = strip_tags(($_POST['city']));
            $Data['country'] = "AO";
            $Data['obs'] = strip_tags(($_POST['obs']));

            $logoty['logotype'] = null;
            $Count = new Customer;
            $Count->ExeCreate($logoty, $Data, $id_db_settings);

            if($Count->getResult()):
                WSError($Count->getError()[0], $Count->getError()[1]);
            else:
                WSError($Count->getError()[0], $Count->getError()[1]);
            endif;

            break;
        case 'FormCreateObs':
            $Data['nome'] = strip_tags(($_POST['nome']));

            $Count = new Customer;
            $Count->ExeCreateObs($Data, $id_db_settings);

            if($Count->getResult()):
                WSError($Count->getError()[0], $Count->getError()[1]);
            else:
                WSError($Count->getError()[0], $Count->getError()[1]);
            endif;

            break;
        case 'readyCustomers':
            if($level >= 4): $n =  '&id_db_settings='.$id_db_settings; else: $n = null; endif;
            require_once("../SystemFiles/DripDosPais.inc.php");
            break;
        case 'readyCustomersII':
            if($level >= 4): $n =  '&id_db_settings='.$id_db_settings; else: $n = null; endif;
            require_once("../SystemFiles/UmaFestaTodoDia.inc.php");
            break;
        case 'readyObs':
            if($level >= 4): $n =  '&id_db_settings='.$id_db_settings; else: $n = null; endif;
            require_once("../SystemFiles/DripDosPaisII.inc.php");
            break;
        case 'searchCustommersTxt':
            $txt = strip_tags(trim($_POST['txt']));
            if($level >= 4): $n =  '&id_db_settings='.$id_db_settings; else: $n = null; endif;

            $read = new Read();
            $read->ExeRead("cv_customer", "WHERE (nome LIKE '%' :link '%' AND id_db_settings=:id) OR (nif LIKE '%' :link '%' AND id_db_settings=:id) OR (telefone LIKE '%' :link '%' AND id_db_settings=:id) OR (email LIKE '%' :link '%' AND id_db_settings=:id) OR (endereco LIKE '%' :link '%' AND id_db_settings=:id) ORDER BY id DESC LIMIT 10", "link={$txt}&id={$id_db_settings}");
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
                                <a href="javascript:void" onclick="DeleteCustomer(<?= $key['id']; ?>)" title="Deletar" class="btn btn-danger btn-sm">Apagar</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php
                endforeach;
            endif;

            break;
        case 'FormCreateCustomers':
            $Data['nome'] = strip_tags(($_POST['nome']));
            $Data['nif'] = strip_tags(($_POST['nif']));
            $Data['endereco'] = strip_tags(($_POST['endereco']));
            $Data['type'] = strip_tags(($_POST['type']));
            $Data['city'] = strip_tags(($_POST['city']));
            $Data['country'] = strip_tags(($_POST['country']));

            $logoty['logotype'] = null;
            $Count = new Customer;
            $Count->ExeCreate($logoty, $Data, $id_db_settings);

            if($Count->getResult()):
                WSError($Count->getError()[0], $Count->getError()[1]);
                echo "<script>reload();</script>";
            else:
                WSError($Count->getError()[0], $Count->getError()[1]);
            endif;

            break;
        case 'FormProductAndServices':
            $Data['Description'] = strip_tags($_POST['Description']);
            $Data['preco_venda'] = strip_tags(($_POST['preco_venda']));
            $Data['iva'] = strip_tags(($_POST['iva']));
            $Data['unidade_medida'] = strip_tags(($_POST['unidade_medida']));
            $Data['type'] = strip_tags(($_POST['type']));
            $Data['id_category'] = strip_tags(($_POST['id_category']));
            $Data['codigo'] = strip_tags(($_POST['codigo']));
            $Data['codigo_barras'] = strip_tags(($_POST['codigo_barras']));
            $Data['product'] = strip_tags(($_POST['product']));
            $logoty['logotype'] = null;

            $Count = new Product();
            $Count->ExeCreate($logoty, $Data, $id_db_settings);

            if($Count->getResult()):
                WSError($Count->getError()[0], $Count->getError()[1]);
                include_once("../SystemFiles/search-product-and-services-user.inc.php");
            else:
                WSError($Count->getError()[0], $Count->getError()[1]);
            endif;


            break;
        case 'FormCreateMesa':
            $Data['name'] = strip_tags(($_POST['name']));
            $Data['localizacao'] = strip_tags(($_POST['localizacao']));
            $Data['capacidade'] = strip_tags(($_POST['capacidade']));
            $Data['obs'] = strip_tags(($_POST['obs']));

            $Mesa = new Mesas();
            $Mesa->ExeCreate($Data, $id_db_settings);

            WSError($Mesa->getError()[0], $Mesa->getError()[1]);

            break;
        case 'FormCreateGarcom':
            $Data['name'] = strip_tags(($_POST['name']));
            $Data['telefone'] = strip_tags(($_POST['telefone']));
            $Data['porcentagem'] = strip_tags(($_POST['porcentagem']));

            $Mesa = new Garcom();
            $Mesa->ExeCreate($Data, $id_db_settings);

            WSError($Mesa->getError()[0], $Mesa->getError()[1]);

            break;
        case 'DeleteCustomer':
            $delete = (int) filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

            $read->ExeRead("sd_billing", "WHERE id_db_settings=:i AND id_customer=:iT", "i={$id_db_settings}&iT={$delete}");
            if(!$read->getResult()):
                $Delete = new Delete();
                $Delete->ExeDelete("cv_customer", "WHERE id=:ip AND id_db_settings=:i", "ip={$delete}&i={$id_db_settings}");

                if($Delete->getResult() || $Delete->getRowCount()):
                    WSError("Cliente eliminado com sucesso!", WS_ACCEPT);
                else:
                    WSError("Ops: aconteceu um erro inesperado ao eliminar o cliente (099)", WS_ERROR);
                endif;
            else:
                WSError("Ops: não é permitido eliminar um cliente na qual já foi produzido documentos.", WS_INFOR);
            endif;

            break;
        case 'DeleteObs':
            $delete = (int) filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

            $read->ExeRead("sd_billing", "WHERE id_db_settings=:i AND id_obs=:iT", "i={$id_db_settings}&iT={$delete}");
            if(!$read->getResult()):
                $Delete = new Delete();
                $Delete->ExeDelete("cv_obs", "WHERE id=:ip AND id_db_settings=:i", "ip={$delete}&i={$id_db_settings}");

                if($Delete->getResult() || $Delete->getRowCount()):
                    WSError("Observação eliminado com sucesso!", WS_ACCEPT);
                else:
                    WSError("Ops: aconteceu um erro inesperado ao eliminar a Observação (099)", WS_ERROR);
                endif;
            else:
                WSError("Ops: não é permitido eliminar a Observação na qual consta nos documentos comerciais.", WS_INFOR);
            endif;

            break;
        case 'DeleteMesa':
            $id = (int) filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

            $Delete = new Mesas();
            $Delete->ExeDelete($id, $id_db_settings);

            WSError($Delete->getError()[0], $Delete->getError()[1]);

            break;
        case 'DeleteGarcom':
            $id = (int) filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

            $Delete = new Garcom();
            $Delete->ExeDelete($id, $id_db_settings);

            WSError($Delete->getError()[0], $Delete->getError()[1]);

            break;
        case 'DeleteProduct':
            $id = (int) filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

            $Delete = new Product();
            $Delete->ExeDelete($id, $id_db_settings);

            WSError($Delete->getError()[0], $Delete->getError()[1]);

            break;
        case 'DeleteProductx':
            $id = (int) filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

            $Delete = new Delete();
            $Delete->ExeDelete("cv_clinic_product", "WHERE id=:i AND id_db_settings=:iv ", "i={$id}&iv={$id_db_settings}");

            if($Delete->getResult() || $Delete->getRowCount()):
                WSError("Material apagado com sucesso!", WS_ALERT);
            else:
                WSError("Aconteceu um erro ao apagar o material!", WS_ERROR);
            endif;

            break;
        case 'DeleteCategory':
            $id = (int) filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

            $Delete = new Category();
            $Delete->ExeDelete($id);


            WSError($Delete->getError()[0], $Delete->getError()[1]);
            include_once("../SystemFiles/body-category-settings.inc.php");

            break;

        case 'DeleteMarca':
            $id = (int) filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

            $Delete = new Marcas();
            $Delete->ExeDelete($id);


            WSError($Delete->getError()[0], $Delete->getError()[1]);
            include_once("../../_disk/IncludesApp/body-marcas-settings.inc.php");

            break;
        case 'FormCategory':
            $Data['category_title'] = strip_tags(($_POST['category_title']));
            $Data['category_content'] = strip_tags(($_POST['category_content']));
            $Data['porcentagem_ganho'] = strip_tags(trim(abs($_POST['porcentagem_ganho'])));

            $Count = new Category();
            $Count->ExeCreate($Data, $id_db_settings);

            if($Count->getResult()):
                WSError($Count->getError()[0], $Count->getError()[1]);
                include_once("../../_disk/IncludesApp/body-category-settings.inc.php");
            else:
                WSError($Count->getError()[0], $Count->getError()[1]);
            endif;

            break;
        case 'FormMarca':
            $Data['marca'] = strip_tags(($_POST['marca']));
            $Data['content'] = strip_tags(($_POST['content']));

            $Count = new Marcas();
            $Count->ExeCreate($Data, $id_db_settings);

            if($Count->getResult()):
                WSError($Count->getError()[0], $Count->getError()[1]);
                include_once("../../_disk/IncludesApp/body-marcas-settings.inc.php");
            else:
                WSError($Count->getError()[0], $Count->getError()[1]);
            endif;

            break;
        case 'DeleteTaxTable':
            $idTax = (int) filter_input(INPUT_POST, 'idTax', FILTER_VALIDATE_INT);

            $delUser = new TaxTable;
            $delUser->ExeDelete($idTax);
            WSError($delUser->getError()[0], $delUser->getError()[1]);

            break;
        case 'FormTaxTable':
            $Data['taxCode'] = strip_tags(($_POST['taxCode']));
            $Data['taxType'] = strip_tags(($_POST['taxType']));
            $Data['description'] = strip_tags($_POST['description']);
            $Data['taxPercentage'] = strip_tags(($_POST['taxPercentage']));
            $Data['taxAmount'] = strip_tags(($_POST['taxAmount']));
            $Data['TaxCountryRegion'] = strip_tags(($_POST['TaxCountryRegion']));
            $Data['TaxExemptionReason'] = strip_tags(($_POST['TaxExemptionReason']));

            $Cadastrar = new TaxTable();
            $Cadastrar->ExeCreate($Data, $id_db_settings);

            if($Cadastrar->getResult()):
                WSError($Cadastrar->getError()[0], $Cadastrar->getError()[1]);
            else:
                WSError($Cadastrar->getError()[0], $Cadastrar->getError()[1]);
            endif;

            break;
        case 'SuspenderConta':
            $IdUsers = (int) filter_input(INPUT_POST, 'IdUsers', FILTER_VALIDATE_INT);

            $Db = new DBKwanzar();
            $Db->SuspenderConta($IdUsers, $id_db_settings, $id_db_kwanzar);

            WSError($Db->getError()[0], $Db->getError()[1]);

            break;
        case 'DeleteUsers':
            $IdUsers = (int) filter_input(INPUT_POST, 'IdUsers', FILTER_VALIDATE_INT);

            $Db = new DBKwanzar();
            $Db->DeleteUsers($IdUsers, $id_db_settings, $id_db_kwanzar);

            WSError($Db->getError()[0], $Db->getError()[1]);

            break;
        case 'FormCreateUsers':
            if(!empty($_POST['username'])): $Data['username'] = strip_tags(($_POST['username'])); endif;
            if(!empty($_POST['email'])): $Data['email'] = strip_tags(($_POST['email'])); endif;
            if(!empty($_POST['name'])):     $Data['name'] = strip_tags(($_POST['name']));         endif;
            if(!empty($_POST['levels'])):    $Data['level'] = strip_tags(($_POST['levels']));       endif;

            $Db = new DBKwanzar();
            $Db->ExeUsers($Data, $id_db_settings, $id_db_kwanzar);

            WSError($Db->getError()[0], $Db->getError()[1]);

            break;
        case 'FormConfig':
            if(!empty($_POST['JanuarioSakalumbu'])): $Data['JanuarioSakalumbu'] = strip_tags(($_POST['JanuarioSakalumbu'])); endif;
            if(!empty($_POST['moeda'])):             $Data['moeda']             = strip_tags(($_POST['moeda'])); endif;
            if(!empty($_POST['estoque_minimo'])):    $Data['estoque_minimo']    = strip_tags(($_POST['estoque_minimo'])); endif;
            if(!empty($_POST['sequencialCode'])):    $Data['sequencialCode']    = strip_tags(($_POST['sequencialCode'])); endif;
            if(!empty($_POST['WidthLogotype'])):     $Data['WidthLogotype']     = strip_tags(($_POST['WidthLogotype'])); endif;
            if(!empty($_POST['HeightLogotype'])):    $Data['HeightLogotype']    = strip_tags(($_POST['HeightLogotype'])); endif;
            if(!empty($_POST['HeliosPro'])):         $Data['HeliosPro']         = strip_tags(($_POST['HeliosPro'])); endif;
            if(!empty($_POST['IncluirNaFactura'])):  $Data['IncluirNaFactura']  = strip_tags(($_POST['IncluirNaFactura'])); endif;
            if(!empty($_POST['RetencaoDeFonte'])):   $Data['RetencaoDeFonte']   = strip_tags(($_POST['RetencaoDeFonte'])); endif;
            if(!empty($_POST['IncluirCover'])):      $Data['IncluirCover']      = strip_tags(($_POST['IncluirCover'])); endif;
            if(!empty($_POST['MethodDefault'])):     $Data['MethodDefault']     = strip_tags(($_POST['MethodDefault'])); endif;
            if(!empty($_POST['ECommerce'])):         $Data['ECommerce']         = strip_tags(($_POST['ECommerce'])); endif;
            if(!empty($_POST['PadraoAGT'])):         $Data['PadraoAGT']         = strip_tags(($_POST['PadraoAGT'])); endif;
            if(!empty($_POST['DocModel'])):          $Data['DocModel']         = strip_tags(($_POST['DocModel'])); endif;
            if(!empty($_POST['Idioma'])):          $Data['Idioma']         = strip_tags(($_POST['Idioma'])); endif;

            if(!empty($_POST['regimeIVA'])):          $Data['regimeIVA']         = strip_tags(($_POST['regimeIVA'])); endif;

            if(!empty($_POST['taxa_preferencial'])):          $Data['taxa_preferencial']         = strip_tags(($_POST['taxa_preferencial'])); endif;
            if(!empty($_POST['cambio_atual'])):          $Data['cambio_atual']         = strip_tags(($_POST['cambio_atual'])); endif;
            if(!empty($_POST['cambio_x_preco'])):          $Data['cambio_x_preco']         = strip_tags(($_POST['cambio_x_preco'])); endif;
            if(!empty($_POST['porcentagem_x_cambio'])):          $Data['porcentagem_x_cambio']         = strip_tags(($_POST['porcentagem_x_cambio'])); endif;

            $Db = new DBKwanzar();
            $Db->ExeConfig($Data, $id_db_settings, $id_db_kwanzar);

            WSError($Db->getError()[0], $Db->getError()[1]);

            break;
        case 'update':
            $Data = [
                'empresa'            => strip_tags(($_POST['empresa'])),
                'nif'                => strip_tags(($_POST['nif'])),
                'telefone'           => strip_tags(($_POST['telefone'])),
                'email'              => strip_tags(($_POST['email'])),
                'endereco'           => strip_tags(($_POST['endereco'])),
                'website'            => strip_tags(($_POST['website'])),
                'addressDetail'      => strip_tags(($_POST['endereco'])),
                'city'               => "Luanda",
                'taxEntity'          => 1,
                'country'            => "A0",
                'businessName'       => "SERVIÇOS",
                'BuildingNumber'     => 1,
                'atividade'          => strip_tags(($_POST['atividade']))
            ];

            $Db = new DBKwanzar();
            $Db->ExeUpdate($Data, $id_db_settings, $id_db_kwanzar);

            WSError($Db->getError()[0], $Db->getError()[1]);

            break;
        case 'FormValidateNib':
            $Data['nib']         = strip_tags(($_POST['nib']));
            $Data['iban']        = strip_tags(($_POST['iban']));
            $Data['swift']       = strip_tags(($_POST['swift']));
            $Data['banco']       = strip_tags(($_POST['banco']));

            $Data['nib1']         = strip_tags(($_POST['nib1']));
            $Data['iban1']        = strip_tags(($_POST['iban1']));
            $Data['swift1']       = strip_tags(($_POST['swift1']));
            $Data['banco1']       = strip_tags(($_POST['banco1']));

            $Data['nib2']         = strip_tags(($_POST['nib2']));
            $Data['iban2']        = strip_tags(($_POST['iban2']));
            $Data['swift2']       = strip_tags(($_POST['swift2']));
            $Data['banco2']       = strip_tags(($_POST['banco2']));

            $Data['coordenadas'] = $_POST['coordenadas'];

            $Db = new DBKwanzar();
            $Db->ExeNiB($Data, $id_db_settings, $id_db_kwanzar);

            WSError($Db->getError()[0], $Db->getError()[1]);
            break;
        default:
            WSError("Ops: não encontramos a ação desejada!", WS_INFOR);
    endswitch;
endif;
<?php

$acao = strip_tags((filter_input(INPUT_POST, 'acao', FILTER_DEFAULT)));

if ($acao):
    require_once("../../Config.inc.php");

    if (isset($_POST['level'])): $level = strip_tags(trim($_POST['level'])); endif;
    if (isset($_POST['id_user'])): $id_user = strip_tags(trim($_POST['id_user'])); endif;
    if (isset($_POST['id_db_settings'])): $id_db_settings = strip_tags(trim($_POST['id_db_settings'])); endif;
    if (isset($_POST['postId'])): $postId = strip_tags(trim($_POST['postId'])); endif;

    $POS = new POS;
    $Read = new Read();

    switch ($acao):
        case 'HeliosPro':
            $date_i = strip_tags(trim($_POST['date_i']));
            $date_f = strip_tags(trim($_POST['date_f']));
            $pesquisar = strip_tags(trim($_POST['pesquisar']));
            $id_users = strip_tags(trim($_POST['id_users']));
            ?>
            <br/>
            <a href="print.php?&number=15&action=15&date_i=<?= $date_i; ?>&date_f=<?= $date_f; ?>&pesquisar=<?= $pesquisar; ?>&id_users=<?= $id_users; ?>&id_db_settings=<?= $id_db_settings; ?>" class="btn btn-default" target="_blank">Imprimir</a><br/>
            <br/><table class="table text-center">
                <thead>
                    <tr>
                        <th>Nº</th>
                        <th>Documento</th>
                        <th>Hora & Data</th>
                        <th>Cliente/<br/>NIF/<br/>Endereço</th>
                        <th>VEICULO<br/>/Observações</th>
                        <th>Matricula</th>
                        <th>LAUDO TÉNICO/<br/>DESCRIÇÃO DO PROBLEMA<br/>/OBSERVAÇÕES</th>
                        <th>Itens adicionados</th>
                        <th>Quantidade</th>
                        <th>Mêcanico</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    $status = 3;
                    if(strlen($date_i) <= 0 || empty($date_i)): $date_i = date('Y-m-d'); endif;
                    if(strlen($date_f) <= 0 || empty($date_f)): $date_f = date('Y-m-d'); endif;

                    $data_inicial = explode("-", $date_i);
                    $data_final   = explode("-", $date_f);
                    $documents = "FO";

                    $ids = " ii_billing.id_db_settings={$id_db_settings} AND ii_billing_pmp.id_db_settings={$id_db_settings} AND ";
                    $datas = " AND ii_billing.dia BETWEEN {$data_inicial[2]} AND {$data_final[2]} AND ii_billing.mes BETWEEN {$data_inicial[1]} AND {$data_final[1]} AND ii_billing.ano BETWEEN {$data_inicial[0]} AND {$data_final[0]} ";
                    if($id_users == "all"):  $usuarios = ""; else: $usuarios = " AND ii_billing.id_mecanico='{$id_users}' "; endif;
                    //$docs = " AND ii_billing.InvoiceType='{$documents}' AND ii_billing_pmp.InvoiceType='{$documents}' ";
                    if($pesquisar == "" || $pesquisar == '' || empty($pesquisar) || $pesquisar == null || !isset($pesquisar)):
                        $link = $documents;
                        $search = " AND ii_billing.InvoiceType=:link AND ii_billing_pmp.InvoiceType=:link ";
                    else:
                        $link = $pesquisar;
                        $search = " AND (ii_billing.customer_name LIKE '%' :link '%' AND ii_billing.InvoiceType='{$documents}' AND ii_billing_pmp.InvoiceType='{$documents}' ) OR (ii_billing.customer_nif LIKE '%'  :link  '%' AND  ii_billing.InvoiceType='{$documents}' AND ii_billing_pmp.InvoiceType='{$documents}') OR (ii_billing.customer_endereco LIKE '%' :link '%' AND ii_billing.InvoiceType='{$documents}' AND ii_billing_pmp.InvoiceType='{$documents}') OR (ii_billing.kilometragem LIKE '%'  :link  '%' AND ii_billing.InvoiceType='{$documents}' AND ii_billing_pmp.InvoiceType='{$documents}' ) OR (ii_billing.matricula LIKE '%' :link  '%' AND ii_billing.InvoiceType='{$documents}' AND ii_billing_pmp.InvoiceType='{$documents}') OR (ii_billing.v_modelo LIKE '%'  :link  '%' AND ii_billing.InvoiceType='{$documents}' AND ii_billing_pmp.InvoiceType='{$documents}')";
                    endif;

                    $n = 0;
                    $Read = new Read();
                    $Read->ExeRead("ii_billing, ii_billing_pmp", "WHERE {$ids} ii_billing_pmp.id_invoice=ii_billing.id AND ii_billing.status={$status} {$search} {$datas} ", "link={$link}");
                    if($Read->getResult()):
                        foreach ($Read->getResult() as $key):
                            $n += 1;
                            ?>
                            <tr>
                                <td><?= $n; ?></td>
                                <td><?= $key['InvoiceType']." ".$key['mes'].$key['Code'].$key['ano']."/".$key['numero']; ?></td>
                                <td><?= $key["dia"]."/".$key["mes"]."/".$key["ano"]." ".$key["hora"]; ?></td>
                                <td><?= $key['customer_name']; ?><br/><?= $key['customer_nif']; ?><br/><?= $key['customer_endereco']; ?></td>
                                <td><?= $key['v_modelo']; ?><br/><?php $Read->ExeRead("i_veiculos", "WHERE id_db_settings={$id_db_settings} AND id={$key['id_veiculo']}"); if($Read->getResult()): echo $Read->getResult()[0]['content']; endif; ?></td>
                                <td><?= $key['matricula']; ?></td>
                                <td><?= $key['fo_laudo']; ?><br><?= $key['fo_problema']; ?><br/><?= $key['fo_observacoes']; ?></td>
                                <td><?= $key['product']; ?></td>
                                <td><?= $key['qtd_pmp']; ?></td>
                                <td><?php if(!empty($key['id_mecanico'])): $Read->ExeRead("db_users", "WHERE id_db_settings={$id_db_settings} AND id={$key['id_mecanico']}"); if($Read->getResult()): echo $Read->getResult()[0]['name']; endif; endif; ?></td>
                            </tr>
                            <?php
                        endforeach;
                    endif;
                 ?>
                </tbody>
            </table>
            <?php
            break;
        case 'Kwanzar':
            $date_i = strip_tags(trim($_POST['date_i']));
            $date_f = strip_tags(trim($_POST['date_f']));
            $documents = strip_tags(trim($_POST['documents']));
            $id_itens = strip_tags(trim($_POST['id_itens']));
            $id_fornecedor = strip_tags(trim($_POST['id_fornecedor']));
            $id_users = strip_tags(trim($_POST['id_users']));
            ?>
            <a href="print.php?&number=03&action=03&date_i=<?= $date_i; ?>&date_f=<?= $date_f; ?>&documents=<?= $documents; ?>&id_itens=<?= $id_itens; ?>&id_fornecedor=<?= $id_fornecedor; ?>&id_users=<?= $id_users; ?>&id_system=<?= $id_system; ?>" class="btn btn-success btn-sm" target="_blank">Imprimir</a><br/>
            <table class="table text-center">
                <thead>
                    <tr>
                        <th>Nº</th>
                        <th>Hora & Data</th>
                        <th>Tipo de movimento</th>
                        <th>Produto/descrição</th>
                        <th>Categoria</th>
                        <th>Fornecedor</th>
                        <th>Quantidade</th>
                        <th>Unidades</th>
                        <th>Usuário</th>
                        <th>Existência</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if(strlen($date_i) <= 0 || empty($date_i)): $date_i = date('Y-m-d'); endif;
                        if(strlen($date_f) <= 0 || empty($date_f)): $date_f = date('Y-m-d'); endif;

                        $data_inicial = explode("-", $date_i);
                        $data_final   = explode("-", $date_f);

                        $datas = " AND ii_stock.dia BETWEEN {$data_inicial[2]} AND {$data_final[2]} AND ii_stock.mes BETWEEN {$data_inicial[1]} AND {$data_final[1]} AND ii_stock.ano BETWEEN {$data_inicial[0]} AND {$data_final[0]} ";
                        if($id_users == "all"):  $usuarios = ""; else: $usuarios = " AND ii_stock.id_user='{$id_users}' AND ii_billing_pmp.id_user='{$id_users}' "; endif;

                        if($id_fornecedor == "all"): $clientes = ""; else: $clientes = " AND ii_stock.id_fornecedor='{$id_fornecedor}' "; endif;
                        if($documents == "all"): $docs = ""; else: $docs = " AND ii_stock.moviment='{$documents}' "; endif;
                        if($id_itens == "all"): $itens = ""; else: $itens = " AND ii_stock.id_product='{$id_itens}' "; endif;

                        $Moviment = ["", "Entrada", "Saída"];
                        $n = 0;
                        $t_entrada = 0;
                        $t_saida = 0;
                        $t_existencia = 0;
                        $t_qtd = 0;

                        $Read = new Read();
                        $Read->ExeRead("ii_stock", "WHERE ii_stock.id_system={$id_system} {$datas} {$clientes} {$docs} {$itens} {$usuarios}");
                        if($Read->getResult()):
                            foreach ($Read->getResult() as $key):
                                $n += 1;
                                $t_qtd += $key['qtd'];
                                if($key['moviment'] == 1):
                                    $t_entrada += $key['qtd'];
                                else:
                                    $t_saida += $key['qtd'];
                                endif;

                                $Read->ExeRead("i_product", "WHERE id_system={$id_system} AND id={$key['id_product']}");
                                if($Read->getResult()):
                                    $Array = $Read->getResult()[0];
                                    $t_existencia += $Array['qtd'];
                                    ?>
                                    <tr>
                                        <td><?= $n; ?></td>
                                        <td><?= $key['data']." ".$key['hora']; ?></td>
                                        <td><?= $Moviment[$key['moviment']];?></td>
                                        <td><?= $Array['product']; ?><br/><small><?= $key['content']; ?></small></td>
                                        <td>
                                            <?php
                                            $Read->ExeRead("i_category", "WHERE id=:i", "i={$Array['id_category']}");
                                            if($Read->getResult()): echo $Read->getResult()[0]['category']; endif;
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            $Read->ExeRead("i_fornecedores", "WHERE id=:i", "i={$key['id_fornecedor']}");
                                            if($Read->getResult()): echo $Read->getResult()[0]['name']; endif;
                                            ?>
                                        </td>
                                        <td><?php if($key['moviment'] == 2): echo "-"; endif; echo $key['qtd']; ?></td>
                                        <td><?= $key['unidades']; ?></td>
                                        <td>
                                            <?php
                                            $Read->ExeRead("i_users", "WHERE id=:i", "i={$key['id_user']}");
                                            if($Read->getResult()): echo $Read->getResult()[0]['name']; endif;
                                            ?>
                                        </td>
                                        <td><?= $Array['qtd']; ?></td>
                                    </tr>
                                    <?php
                                endif;
                            endforeach;
                        endif;
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th>Total ===></th>
                        <th></th>
                        <th><?= $t_qtd; ?></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th>Entrada: </th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th><?= $t_entrada; ?></th>
                    </tr>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th>Saída: </th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th><?= $t_saida; ?></th>
                    </tr>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th>Diferença: </th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th><?= ($t_entrada - $t_saida); ?></th>
                    </tr>
                </tfoot>
            </table>
            <?php
            break;
        case 'BioloRapido':
            $date_i = strip_tags(trim($_POST['date_i']));
            $date_f = strip_tags(trim($_POST['date_f']));
            $documents = strip_tags(trim($_POST['documents']));
            $type = strip_tags(trim($_POST['type']));
            $method_paypal = strip_tags(trim($_POST['method_paypal']));
            $id_itens = strip_tags(trim($_POST['id_itens']));
            $id_category = strip_tags(trim($_POST['id_category']));
            $id_customers = strip_tags(trim($_POST['id_customers']));
            $id_users = strip_tags(trim($_POST['id_users']));

            ?>
            <a href="print.php?&number=02&action=02&date_i=<?= $date_i; ?>&date_f=<?= $date_f; ?>&documents=<?= $documents; ?>&type=<?= $type; ?>&method_paypal=<?= $method_paypal; ?>&id_itens=<?= $id_itens; ?>&id_category=<?= $id_category; ?>&id_customers=<?= $id_customers; ?>&id_users=<?= $id_users; ?>&id_system=<?= $id_system; ?>" class="btn btn-success btn-sm" target="_blank">Imprimir</a><br/>
            <table class="table text-center">
                <thead>
                    <tr>
                        <th>Nº</th>
                        <th>Documento</th>
                        <th>Hora & Data</th>
                        <th>Cliente</th>
                        <th>NIF</th>
                        <th>Vendedor</th>
                        <th>Categoria</th>
                        <th>Tipo de Item</th>
                        <th>Pagamento</th>
                        <th>Item</th>
                        <th>Qtd</th>
                        <th>Preço Unitário</th>
                        <th>Desconto %</th>
                        <th>Taxa %</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $status = 3;
                        if(strlen($date_i) <= 0 || empty($date_i)): $date_i = date('Y-m-d'); endif;
                        if(strlen($date_f) <= 0 || empty($date_f)): $date_f = date('Y-m-d'); endif;

                        $data_inicial = explode("-", $date_i);
                        $data_final   = explode("-", $date_f);
                    $ids = " ii_billing.id_system={$id_system} AND ii_billing_pmp.id_system={$id_system} AND ";


                    $datas = " AND ii_billing.dia BETWEEN {$data_inicial[2]} AND {$data_final[2]} AND ii_billing.mes BETWEEN {$data_inicial[1]} AND {$data_final[1]} AND ii_billing.ano BETWEEN {$data_inicial[0]} AND {$data_final[0]} ";
                        if($id_users == "all"):  $usuarios = ""; else: $usuarios = " AND ii_billing.id_user='{$id_users}' AND ii_billing_pmp.id_user='{$id_users}' "; endif;
                        if($id_category == "all"): $category = ""; else: $category = " AND ii_billing_pmp.id_category='{$id_category}' "; endif;
                        if($id_customers == "all"): $clientes = ""; else: $clientes = " AND ii_billing.id_cliente='{$id_customers}' "; endif;
                        if($method_paypal == "all"): $method = ""; else: $method = " AND ii_billing.method='{$method_paypal}' "; endif;
                        if($type == "all"): $type_item = ""; else: $type_item = " AND ii_billing_pmp.product_type='{$type}' "; endif;
                        if($id_itens == "all"): $itens = ""; else: $itens = " AND ii_billing_pmp.id_product='{$id_itens}' "; endif;
                        $docs = " AND ii_billing.InvoiceType='{$documents}' AND ii_billing_pmp.InvoiceType='{$documents}' ";

                        $Read = new Read();
                        $Read->ExeRead("ii_billing, ii_billing_pmp", "WHERE {$ids} ii_billing_pmp.id_invoice=ii_billing.id AND ii_billing.status={$status} {$datas} {$docs} {$method} {$itens} {$type_item} {$clientes} {$category} {$usuarios}");

                        $n = 0;
                        $t_qtd = 0;
                        $t_desconto = 0;
                        $t_impostos = 0;
                        $t_geral = 0;
                        $moeda = null;

                        if($Read->getResult()):
                            foreach ($Read->getResult() as $key):
                                $n += 1;

                                $base     = $key['qtd_pmp'] * $key['preco_pmp'];
                                $desconto = ($key['desconto_pmp'] * $base) / 100;
                                $imposto  = ($key['taxa_pmp'] * $base) / 100;
                                $desconto_f = ($key['desconto_financeiro'] * $base) / 100;

                                $total = ($base - ($desconto + $desconto_f)) + $imposto;

                                $t_qtd += $key['qtd_pmp'];
                                $t_desconto += ($desconto + $desconto_f);
                                $t_impostos += $imposto;
                                $t_geral += $total;

                                $moeda = $key["config_moeda"];
                                ?>
                                <tr>
                                    <td><?= $n; ?></td>
                                    <td><?= $key["InvoiceType"]; ?></td>
                                    <td><?= $key["dia"]."/".$key["mes"]."/".$key["ano"]." ".$key["hora"]; ?></td>
                                    <td><?= $key["customer_name"]; ?></td>
                                    <td><?= $key["customer_nif"]; ?></td>
                                    <td><?= $key["username"]; ?></td>
                                    <td>
                                        <?php
                                            $Read->ExeRead("i_category", "WHERE id=:i", "i={$key['id_category']}");
                                            if($Read->getResult()): echo $Read->getResult()[0]['category']; endif;
                                        ?>
                                    </td>
                                    <td><?= $key["product_type"]; ?></td>
                                    <td><?php if($key['method'] == 'CC'): echo 'Cartão de Credito'; elseif($key['method'] == 'MB'): echo 'Referência de pagamentos para Multicaixa'; elseif($key['method'] == 'CD'): echo 'Cartão de Debito'; elseif($key['method'] == 'CH'): echo 'Cheque Bancário'; elseif($key['method'] == 'NU'): echo 'Numerário'; elseif ($key['method'] == 'TB'): echo 'Transferência Bancária'; elseif($key['method'] == 'OU'): echo 'Outros Meios Aqui não Assinalados'; endif; ?></td>
                                    <td><?= $key["product"]; ?></td>
                                    <td><?= $key["qtd_pmp"]; ?></td>
                                    <td><?= number_format($key["preco_pmp"], 2); ?></td>
                                    <td><?= number_format($key["desconto_pmp"], 2); ?></td>
                                    <td><?= number_format($key["taxa_pmp"], 2); ?></td>
                                    <td><?= number_format($total, 2); ?></td>
                                </tr>
                                <?php
                            endforeach;
                        endif;
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th>TOTAL ===></th>
                        <th><?= number_format($t_qtd, 2);?></th>
                        <th></th>
                        <th><?= number_format($t_desconto, 2);?></th>
                        <th><?= number_format($t_impostos, 2);?></th>
                        <th><?= number_format($t_geral, 2)." ".$moeda;?> </th>
                    </tr>
                </tfoot>
            </table>
            <?php
            break;
        default:
            WSError("Ops: não encontramos a ação desejada!", WS_INFOR);
    endswitch;
endif;
<?php
$acao = strip_tags((filter_input(INPUT_POST, 'acao', FILTER_DEFAULT)));
if ($acao):
    require_once("../../Config.inc.php");
    if (isset($_POST['level'])): $level = strip_tags(trim($_POST['level'])); endif;
    if (isset($_POST['id_user'])): $id_user = strip_tags(trim($_POST['id_user'])); endif;
    if (isset($_POST['id_db_settings'])): $id_db_settings = strip_tags(trim($_POST['id_db_settings'])); endif;
    if (isset($_POST['postId'])): $postId = strip_tags(trim($_POST['postId'])); endif;
    $POS = new Mecanica();
    $Read = new Read();
    switch ($acao):
        case 'ReadProductsAll':
            $qtd_pedido = strip_tags(trim($_POST['qtd_pedido']));
            $id_product = strip_tags(trim($_POST['id_product']));

            $Atitude = new Atitude();
            $Atitude->PedidoDaLoja($id_system, $id_user, $id_product, $qtd_pedido);

            WSError($Atitude->getError()[0], $Atitude->getError()[1]);

            break;
        case 'search_products':
            $search = strip_tags(trim($_POST['search']));

            $type = "P";
            $Read = new Read();
            $Read->ExeRead("i_product", "WHERE id_system=:i AND type=:t AND (product LIKE '%' :link '%') ORDER BY product ASC LIMIT 15", "i={$id_system}&t={$type}&link={$search}");

            if($Read->getResult()):
                foreach ($Read->getResult() as $key):
                    ?>
                    <tr>
                        <td><?= $key['product']; ?></td>
                        <td><?= $key['qQtd']; ?></td>
                        <td><?php if($key['qtd'] > 0): echo "SIM"; else: echo "NÃO"; endif; ?></td>
                        <td><input type="number" id="pedido_<?= $key['id']; ?>" value="1" min="1" max="1000000" class="form-control"></td>
                        <td><a href="javascript:void()" style="border-radius: 5px!important;" class="btn btn-sm btn-primary" id="pedir_<?= $key['id']; ?>" onclick="Pedir(<?= $id_system; ?>, <?= $key['id']; ?>, <?= $id_user; ?>);">Pedir</a></td>
                    </tr>
                <?php
                endforeach;
            endif;
            break;
        case 'ReadProducts':
            ?>
            <div class="card-header">
                <h6 class="card-title">Pesquisar produtos</h6>
                <div class="input-group">
                    <input type="text" id="search_products" class="form-control" placeholder="Pesquisar produtos"/>
                    <span class="input-group-btn">
                      <button class="btn btn-primary" onclick="search_products();" type="button"><i class="fa fa-search"></i></button>
                    </span>
                </div>
            </div>

            <div class="card-body row">
                <div class="table-responsive">
                    <div id="ReadProductsAll"></div>
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Produto</th>
                            <th>QTD. Existênte</th>
                            <th>Estoque</th>
                            <th>QTD. Pedido</th>
                            <th>-</th>
                        </tr>
                        </thead>
                        <tbody id="Itens05">
                            <?php
                                $type = "P";
                                $Read = new Read();
                                $Read->ExeRead("i_product", "WHERE id_system=:i AND type=:t ORDER BY product ASC LIMIT 15", "i={$id_system}&t={$type}");

                                if($Read->getResult()):
                                    foreach ($Read->getResult() as $key):
                                        ?>
                                        <tr>
                                            <td><?= $key['product']; ?></td>
                                            <td><?= $key['qQtd']; ?></td>
                                            <td><?php if($key['qtd'] > 0): echo "SIM"; else: echo "NÃO"; endif; ?></td>
                                            <td><input type="number" id="pedido_<?= $key['id']; ?>" value="1" min="1" max="1000000" class="form-control"></td>
                                            <td><a href="javascript:void()" style="border-radius: 5px!important;" class="btn btn-sm btn-primary" id="pedir_<?= $key['id']; ?>" onclick="Pedir(<?= $id_system; ?>, <?= $key['id']; ?>, <?= $id_user; ?>)">Pedir</a></td>
                                        </tr>
                                        <?php
                                    endforeach;
                                endif;
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php
            break;
        case 'SearchDocs':
            $search = strip_tags(trim($_POST['search']));
            $status = 3;
            $Read = new Read();
            $Read->ExeRead("ii_billing", "WHERE (id_system=:i AND id_user=:y AND status=:st AND numero LIKE '%' :link '%') OR  (id_system=:i AND id_user=:y AND status=:st AND InvoiceType LIKE '%' :link '%') OR (id_system=:i AND id_user=:y AND status=:st AND id LIKE '%' :link '%') AND  (id_system=:i AND id_user=:y AND status=:st AND customer_name LIKE '%' :link '%') OR  (id_system=:i AND id_user=:y AND status=:st AND customer_nif LIKE '%' :link '%') OR  (id_system=:i AND id_user=:y AND status=:st AND customer_endereco LIKE '%' :link '%') ORDER BY id DESC LIMIT 10", "i={$id_system}&y={$id_user}&st={$status}&link={$search}");

            if($Read->getResult()):
                foreach ($Read->getResult() as $key):
                    ?>
                    <tr>
                        <td><?= $key['numero']; ?></td>
                        <td><?php if($key['method'] == "CD"): echo "Cartão de Débito";  elseif($key['method'] == "CH"): echo "Cheque Bancário"; elseif($key['method'] == "MB"): echo "Referências de pagamento para Multicaixa"; elseif($key['method'] == "NU"): echo "Númerário"; elseif($key['method'] == "OU"): echo "Outros meios aqui não assinalados"; elseif($key['method'] == "PR"): echo "Permuta de bens"; elseif($key['method'] == "TB"): echo "Transferência bancária ou débito directo autorizado"; endif;?></td>
                        <td><?= $key['dia']."/".$key["mes"]."/".$key['ano']." ".$key['hora']; ?></td>
                        <td><?= $key['InvoiceType']; ?></td>
                        <td>
                            <a href="print.php?action=01&postId=<?= $key['id']; ?>&doc=<?= $key['InvoiceType']; ?>&number=<?= $key['numero']; ?>" target="_blank" class="btn btn-success btn-sm small">Imprimir</a>&nbsp;
                            <?php
                            if($key['InvoiceType'] == "FT"):
                                $Read->ExeRead("ii_billing_story", "WHERE id_system=:i AND id_invoice=:y", "i={$id_system}&y={$key['id']}");

                                if($Read->getResult()):
                                    if($Read->getResult()[0]['total'] > 0):
                                        ?>
                                        <a href="POS.php?exe=rectification&postId=<?= $key['id']; ?>&InvoiceType=<?= $key['InvoiceType']; ?>" class="btn btn-primary btn-sm small">Rectificar</a>&nbsp;
                                    <?php
                                    endif;
                                endif;
                            elseif($key['InvoiceType'] == "FR"):
                                $total_1 = 0;
                                $total_2 = 0;

                                $Read->ExeRead("ii_billing_pmp", "WHERE id_system=:i AND id_invoice=:y ", "i={$id_system}&y={$key['id']}");
                                if($Read->getResult()):
                                    foreach ($Read->getResult() as $item):
                                        $value = $item['qtd_pmp'] * $item['preco_pmp'];
                                        $imposto = ($value * $item['taxa_pmp']) / 100;
                                        $desconto = ($value * $item['desconto_pmp']) / 100;

                                        $total_1 += ($value - $desconto) + $imposto;
                                    endforeach;
                                endif;

                                $Read->ExeRead("ii_billing_pmp", "WHERE id_system=:i AND id_invoice_i=:y", "i={$id_system}&y={$key['id']}");
                                if($Read->getResult()):
                                    foreach ($Read->getResult() as $item):
                                        $value = $item['qtd_pmp'] * $item['preco_pmp'];
                                        $imposto = ($value * $item['taxa_pmp']) / 100;
                                        $desconto = ($value * $item['desconto_pmp']) / 100;

                                        $total_2 += ($value - $desconto) + $imposto;
                                    endforeach;
                                endif;

                                if($total_1 > $total_2):
                                    ?>
                                    <a href="POS.php?exe=rectification&postId=<?= $key['id']; ?>&InvoiceType=<?= $key['InvoiceType']; ?>" class="btn btn-primary btn-sm small">Rectificar</a>&nbsp;
                                <?php
                                endif;
                            endif;
                            ?>
                        </td>
                        <td><?= $key['id']; ?></td>
                    </tr>
                <?php
                endforeach;
            endif;
            break;
        case 'SelectDataEntrada':
            $id_cliente = (int) $_POST['id_cliente'];
            $id_veiculo = (int) $_POST['id_veiculo'];

            $Read->ExeRead("i_veiculos", "WHERE id_system=:i AND id_cliente=:y AND id=:ip", "i={$id_system}&y={$id_cliente}&ip={$id_veiculo}");

            if($Read->getResult()):
                foreach ($Read->getResult() as $key):
                    ?>
                    <?= $key['data_entrada']; ?>
                <?php
                endforeach;
            endif;

            break;
        case 'SelectKilometragem':
            $id_cliente = (int) $_POST['id_cliente'];
            $id_veiculo = (int) $_POST['id_veiculo'];

            $Read->ExeRead("i_veiculos", "WHERE id_system=:i AND id_cliente=:y AND id=:ip", "i={$id_system}&y={$id_cliente}&ip={$id_veiculo}");

            if($Read->getResult()):
                foreach ($Read->getResult() as $key):
                    ?>
                    <?= $key['km_atual']; ?>
                <?php
                endforeach;
            endif;

            break;
        case 'FinishII':
            $id_cliente = (double) $_POST['id_cliente'];
            $document = strip_tags(trim($_POST['document']));

            $data['matricula'] = strip_tags(trim($_POST['matricula']));
            $data['id_mecanico'] = strip_tags(trim($_POST['id_mecanico']));
            $data['kilometragem'] = strip_tags(trim($_POST['kilometragem']));
            $data['fo_data_entrada'] = strip_tags(trim($_POST['fo_data_entrada']));
            $data['id_veiculo'] = strip_tags(trim($_POST['id_veiculo']));
            $data['fo_problema'] = $_POST['fo_problema'];
            $data['fo_laudo'] = $_POST['fo_laudo'];
            $data['fo_observacoes'] = $_POST['fo_observacoes'];

            $POS->FinishII($id_db_settings, $id_user, $id_cliente, $document, $data);

            WSError($POS->getError()[0], $POS->getError()[1]);

            break;
        case 'add_qtds':
            $quantidade = strip_tags(trim($_POST['quantidade']));
            $POS->add_qtd($id_system, $id_user, $postId, $quantidade);

            if($POS->getResult()):
                require_once("../AppStore/list_itens_of.inc.php");
            else:
                WSError($POS->getError()[0], $POS->getError()[1]);
            endif;

            break;
        case 'cancelII':
            $POS->cancel($id_db_settings, $id_user, $postId);

            if($POS->getResult()):
                require_once("../AppFiles/list_itens_of.inc.php");
            else:
                WSError($POS->getError()[0], $POS->getError()[1]);
            endif;

            break;
        case 'search_itens_fo':
            $st = 1;
            $search = strip_tags(trim($_POST['search']));
            $Read->ExeRead("i_product", "WHERE (id_system=:i AND status=:st AND product LIKE '%' :link '%') OR (id_system=:i AND status=:st AND codigo LIKE '%' :link '%') OR (id_system=:i AND status=:st AND codigo_barras LIKE '%' :link '%') OR (id_system=:i AND status=:st AND imposto LIKE '%' :link '%')", "i={$id_db_settings}&st={$st}&link={$search}");
            require_once("../AppFiles/Search_itens_of.inc.php");
            break;
        case 'adicionarII':
            $quantidade = strip_tags(trim($_POST['quantidade']));

            $POS->adicionar($id_db_settings, $id_user, $postId, $quantidade);
            if($POS->getResult()):
                include_once("../AppFiles/list_itens_of.inc.php");
            else:
                WSError($POS->getError()[0], $POS->getError()[1]);
            endif;

            break;
        case 'WhatsApp':
            ?>
            <div class="modal-header">
                <h5 class="modal-title">Adicionar Itens</h5>
                <a href="#" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></a>
            </div>
            <div class="getResult"></div>
            <div class="modal-body">
                <div class="card-header">
                    <h3 class="card-title">Itens</h3>&nbsp;&nbsp;&nbsp;
                    <div class="form-group d-none d-sm-inline-block form-inline mr-auto ml-md-4 my-3 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" id="search_itens_fo" class="form-control bg-light border-0 small" placeholder="Pesquisar itens" aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" onclick="search_itens_fo();" type="button">Pesquisar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table" style="overflow-x: hidden!important;">
                        <thead>
                        <tr>
                            <th>Item</th>
                            <th>Quant.</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody id="Itens02" style="overflow-y: auto!important;">
                            <?php
                                $st = 1;

                                $Read = new Read();
                                $Read->ExeRead("cv_product", "WHERE id_db_settings=:i ORDER BY product ASC LIMIT 20", "i={$id_db_settings}");
                                include_once("../AppFiles/Search_itens_of.inc.php");
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php
            break;
        case 'SelectPlaca':
            $id_cliente = (int) $_POST['id_cliente'];
            $id_veiculo = (int) $_POST['id_veiculo'];

            $Read->ExeRead("i_veiculos", "WHERE id_db_settings=:i AND id_cliente=:y AND id=:ip", "i={$id_db_settings}&y={$id_cliente}&ip={$id_veiculo}");

            if($Read->getResult()):
                foreach ($Read->getResult() as $key):
                    ?>
                    <?= $key['placa']; ?>
                <?php
                endforeach;
            endif;

            break;
        case 'SelectPlacaII':
            $id_cliente = (int) $_POST['id_cliente'];
            $id_veiculo = (int) $_POST['id_veiculos'];

            $Read->ExeRead("i_veiculos", "WHERE id_db_settings=:i AND id_cliente=:y AND id=:ip", "i={$id_db_settings}&y={$id_cliente}&ip={$id_veiculo}");

            if($Read->getResult()):
                foreach ($Read->getResult() as $key):
                    ?>
                    <?= $key['placa']; ?>
                <?php
                endforeach;
            endif;

            break;
        case 'SelectFabricante':
            $id_cliente = (int) $_POST['id_cliente'];
            $id_veiculo = (int) $_POST['id_veiculos'];

            $Read->ExeRead("i_veiculos", "WHERE id_db_settings=:i AND id_cliente=:y AND id=:ip", "i={$id_db_settings}&y={$id_cliente}&ip={$id_veiculo}");

            if($Read->getResult()):
                $info = $Read->getResult()[0];
                $Read->ExeRead("i_fabricante", "WHERE id=:i", "i={$info['id_fabricante']}");
                if($Read->getResult()):
                    foreach ($Read->getResult() as $key):
                        echo $key['name'];
                    endforeach;
                endif;
            endif;

            break;
        case 'SelectVeiculos':
            $id_cliente = (int) $_POST['id_cliente'];

            $Read->ExeRead("i_veiculos", "WHERE id_db_settings=:i AND id_cliente=:y", "i={$id_db_settings}&y={$id_cliente}");

            if($Read->getResult()):
                foreach ($Read->getResult() as $key):
                    ?>
                    <option value="<?= $key['id']; ?>"><?= $key['veiculo']; ?></option>
                    <?php
                endforeach;
            endif;

            break;
        case 'SelectVeiculoII':
            $id_cliente = (int) $_POST['id_customer'];

            $Read->ExeRead("i_veiculos", "WHERE id_db_settings=:i AND id_cliente=:y", "i={$id_db_settings}&y={$id_cliente}");

            if($Read->getResult()):
                foreach ($Read->getResult() as $key):
                    ?>
                    <option value="<?= $key['id']; ?>"><?= $key['veiculo']; ?></option>
                <?php
                endforeach;
            endif;

            break;
        case 'ReadDocuments':
            ?>
            <div class="modal-header">
                <h5 class="modal-title">Documentos da Oficina</h5>
                <a href="#" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></a>
            </div>
            <div class="getResult"></div>
            <div class="modal-body">
                <div class="row">
                    <?php require_once("../AppFiles/documents.all.inc.php"); ?>
                </div>
            </div>
            <?php
            break;
        default:
            WSError("Ops: não encontramos a ação desejada!", WS_INFOR);
    endswitch;
endif;
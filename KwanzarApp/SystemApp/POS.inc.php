<?php
$acao = strip_tags((filter_input(INPUT_POST, 'acao', FILTER_DEFAULT)));
if($acao):
    require_once("../../Config.inc.php");
    if(isset($_POST['id_db_kwanzar'])):  $id_db_kwanzar   = (int) $_POST['id_db_kwanzar']; endif;
    if(isset($_POST['id_db_settings'])): $id_db_settings  = (int) $_POST['id_db_settings']; endif;
    if(isset($_POST['id_user'])):        $userlogin['id'] = (int) $_POST['id_user']; $id_user = (int) $_POST['id_user']; endif;
    if(isset($_POST['level'])):          $level           = (int) $_POST['level']; endif;
    if(isset($_POST['page_found'])): $page_found = strip_tags(($_POST['page_found'])); endif;

    if(isset($_POST['InvoiceType'])):     $InvoiceType     = strip_tags(trim($_POST['InvoiceType'])); endif;
    if(isset($_POST['Number'])):          $Number          = strip_tags(trim($_POST['Number'])); endif;

    switch ($acao):
        case 'Champanhe01':
            ?>
            <i class="col-line"></i>

            <input type="hidden" id="cartao_de_debito" value="0">
            <input type="hidden" id="numerario" value="0">
            <input type="hidden" id="transferencia" value="0">
            <input type="hidden" id="all_total" value="0">

            <div class="col-lg-12">
                <div class="mb-3">
                    <label class="form-label">Pagou</label>
                    <input type="text" id="pagou" class="form-control calc" placeholder="Pagou">
                </div>
                <div class="mb-3" id="RapCosciente">

                </div>
            </div>
            <?php
            break;
        case 'Champanhe02':
            ?>
            <div class="mb-3">
                <label class="form-label">Cartão de Débito</label>
                <input type="text" id="cartao_de_debito" name="cartao_de_debito" value="<?php if(isset($DataSupplier['cartao_de_debito'])): echo $DataSupplier['cartao_de_debito']; else: echo "0"; endif; ?>" placeholder="Cartão de Débito" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">Transferência</label>
                <input type="text" id="transferencia" name="transferencia" value="<?php if(isset($DataSupplier['transferencia'])): echo $DataSupplier['transferencia']; else: echo "0"; endif; ?>" placeholder="Transferência" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">Númerario</label>
                <input type="text" id="numerario" name="numerario" value="<?php if(isset($DataSupplier['numerario'])): echo $DataSupplier['numerario']; else: echo "0"; endif; ?>" placeholder="Númerario" class="form-control">
            </div>

            <input type="hidden" id="pagou" value="0">
            <input type="hidden" id="troco" value="0">

            <div class="mb-3" id="TodosOsDias">

            </div>
            <?php
            break;
        case 'Champanhe03':
            ?>
            <input type="hidden" id="pagou" value="0">
            <input type="hidden" id="troco" value="0">

            <input type="hidden" id="cartao_de_debito" value="0">
            <input type="hidden" id="numerario" value="0">
            <input type="hidden" id="transferencia" value="0">
            <input type="hidden" id="all_total" value="0">
            <?php
            break;
        case 'Venda02':
            $s = 0;
            if(DBKwanzar::CheckConfig($id_db_settings) == false || Strong::Config($id_db_settings)['JanuarioSakalumbu'] == 3 || Strong::Config($id_db_settings)['JanuarioSakalumbu'] == '' || Strong::Config($id_db_settings)['JanuarioSakalumbu'] == null):
                $st = 3;
            else:
                $st = 2;
            endif;

            $n1 = "sd_retification";
            $n3 = "sd_retification_pmp";
            $PPs = "PP";

            $read = new Read();
            $read->ExeRead("{$n1}", "WHERE ({$n1}.id_db_settings=:i AND {$n1}.session_id=:id AND {$n1}.InvoiceType!=:invoice AND {$n1}.status=:st) ORDER BY {$n1}.id DESC LIMIT 1", "i={$id_db_settings}&id={$id_user}&invoice={$PPs}&st={$st}");
            if($read->getResult()):
                foreach ($read->getResult() as $key):
                    $link = null;
                    $link = "pdf.php?action=02&post={$key['numero']}";
                    if($level >= 4): $link .= "&id_db_settings=".$id_db_settings; endif;
                    $link .= "&SourceBilling={$key['SourceBilling']}&InvoiceType={$key['InvoiceType']}&dia={$key['dia']}&mes={$key['mes']}&ano={$key['ano']}&invoice_id={$key['id_invoice']}";

                    echo $link;
                endforeach;
            endif;
            break;
        case 'Venda01':
            $s = 0;
            if(DBKwanzar::CheckConfig($id_db_settings) == false || Strong::Config($id_db_settings)['JanuarioSakalumbu'] == 3 || Strong::Config($id_db_settings)['JanuarioSakalumbu'] == '' || Strong::Config($id_db_settings)['JanuarioSakalumbu'] == null):
                $st = 3;
            else:
                $st = 2;
            endif;

            $n1 = "sd_billing";
            $n3 = "sd_billing_pmp";
            $PPs = "PP";

            $read = new Read();
            $read->ExeRead("{$n1}", "WHERE ({$n1}.id_db_settings=:i AND {$n1}.session_id=:id AND {$n1}.InvoiceType!=:invoice AND {$n1}.status=:st AND {$n1}.suspenso={$s}) ORDER BY {$n1}.id DESC LIMIT 1", "i={$id_db_settings}&id={$id_user}&invoice={$PPs}&st={$st}");
            if($read->getResult()):
                foreach ($read->getResult() as $key):
                    $link = null;
                    $link = "pdf.php?action=01&post={$key['numero']}";
                    if($level >= 4): $link .= "&id_db_settings=".$id_db_settings; endif;
                    $link .= "&SourceBilling={$key['SourceBilling']}&InvoiceType={$key['InvoiceType']}&dia={$key['dia']}&mes={$key['mes']}&ano={$key['ano']}";

                    echo $link;
                endforeach;
            endif;
            break;
        case 'Proforma01':
            $s = 0;
            if(DBKwanzar::CheckConfig($id_db_settings) == false || Strong::Config($id_db_settings)['JanuarioSakalumbu'] == 3 || Strong::Config($id_db_settings)['JanuarioSakalumbu'] == '' || Strong::Config($id_db_settings)['JanuarioSakalumbu'] == null):
                $st = 3;
            else:
                $st = 2;
            endif;

            $n1 = "sd_billing";
            $n3 = "sd_billing_pmp";
            $PPs = "PP";

            $read = new Read();
            $read->ExeRead("{$n1}", "WHERE ({$n1}.id_db_settings=:i AND {$n1}.session_id=:id AND {$n1}.InvoiceType=:invoice AND {$n1}.status=:st AND {$n1}.suspenso={$s}) ORDER BY {$n1}.id DESC LIMIT 1", "i={$id_db_settings}&id={$id_user}&invoice={$PPs}&st={$st}");
            if($read->getResult()):
                foreach ($read->getResult() as $key):
                    $link = null;
                    $link = "pdf.php?action=01&post={$key['numero']}";
                    if($level >= 4): $link .= "&id_db_settings=".$id_db_settings; endif;
                    $link .= "&SourceBilling={$key['SourceBilling']}&InvoiceType={$key['InvoiceType']}&dia={$key['dia']}&mes={$key['mes']}&ano={$key['ano']}";

                    echo $link;
                endforeach;
            endif;
            break;
        case 'MyCheckBox':
            $SalesType = $_POST['SalesType'];

            /***if(!isset(DBKwanzar::CheckConfig($id_db_settings)['taxa_preferencial']) || empty(DBKwanzar::CheckConfig($id_db_settings)['taxa_preferencial'])):
                WSError("Não foi possível concluir o processo porque não encontramos uma taxa de imposto preferêncial! ", WS_ALERT);
            else:
                if($SalesType == 1):
                    $tax = DBKwanzar::CheckConfig($id_db_settings)['taxa_preferencial'];
                    $read = new Read();
                    $read->ExeRead("db_taxtable", "WHERE taxtableEntry=:idd AND id_db_settings=:id ORDER BY taxPercentage ASC, taxCode ASC", "idd={$tax}&id={$id_db_settings}");

                    if($read->getResult()):
                        foreach ($read->getResult() as $key):
                            $Data['iva'] = $key['taxPercentage'];
                            $Data['id_iva'] = $key['taxtableEntry'];
                        endforeach;
                    endif;
                else:
                    $read = new Read();
                    $read->ExeRead("db_taxtable", "WHERE id_db_settings=:id ORDER BY taxPercentage ASC LIMIT 1", "id={$id_db_settings}");

                    if($read->getResult()):
                        foreach ($read->getResult() as $key):
                            $Data['iva'] = $key['taxPercentage'];
                            $Data['id_iva'] = $key['taxtableEntry'];
                        endforeach;
                    endif;
                endif;

                $Update = new Update();
                $Update->ExeUpdate("cv_product", $Data, "WHERE id_db_settings=:i", "i={$id_db_settings}");

                if(!$Update->getResult()):
                    WSError("Não foi possível atualizar a taxa de imposto nos produtos selecionados!", WS_ERROR);
                else:
                    $Dados['SalesType'] = $SalesType;

                    $Update->ExeUpdate("db_config", $Dados, "WHERE id_db_settings=:i", "i={$id_db_settings}");
                    if(!$Update->getResult()):
                        WSError("Aconteceu um erro inesperado ao atualizar as configurações!", WS_ERROR);
                    endif;
                endif;
            endif;***/

            $Dados['SalesType'] = $SalesType;

            $Update = new Update();
            $Update->ExeUpdate("db_users_settings", $Dados, "WHERE id_db_settings=:i AND session_id=:idd", "i={$id_db_settings}&idd={$id_user}");

            if(!$Update->getResult()):
                WSError("Não foi possível concluir a operação selecionada!", WS_ERROR);
            else:
                WSError("Operação realizada com sucesso!", WS_ACCEPT);
            endif;

            break;
        case 'AddViews':
            $Data['status'] = 2;
            $Update = new Update();
            $Update->ExeUpdate("db_alert", $Data, "WHERE id_db_settings=:iv ", "iv={$id_db_settings}");

            if($Update->getResult()):
                $st = 1;

                $Read = new Read();
                $Read->ExeRead("db_alert", "WHERE id_db_settings=:i AND status=:st", "i={$id_db_settings}&st={$st}");

                echo $Read->getRowCount();
            else:
                WSError("Aconteceu um erro ao atualizar as notificações!", WS_ALERT);
            endif;

            break;
        case 'data_expiracao_x':
            if($level >= 4): $n =  '&id_db_settings='.$id_db_settings; else: $n = null; endif;

            $value = strip_tags(trim($_POST['value']));
            $id    = (int) $_POST['id'];

            $PDV = new Product();
            $PDV->Data_expiracao_x($id_db_settings, $id, $value, $id_user);

            if($PDV->getResult()):
                WSError($PDV->getError()[0], $PDV->getError()[1]);
            else:
                WSError($PDV->getError()[0], $PDV->getError()[1]);
            endif;

            break;
        case 'custo_compra_x':
            if($level >= 4): $n =  '&id_db_settings='.$id_db_settings; else: $n = null; endif;

            $value = (int) $_POST['value'];
            $id    = (int) $_POST['id'];

            $PDV = new Product();
            $PDV->Custo_compra_x($id_db_settings, $id, $value);

            if($PDV->getResult()):
                WSError($PDV->getError()[0], $PDV->getError()[1]);
            else:
                WSError($PDV->getError()[0], $PDV->getError()[1]);
            endif;

            break;
        case 'quantidadex_x':
            if($level >= 4): $n =  '&id_db_settings='.$id_db_settings; else: $n = null; endif;

            $value = (int) $_POST['value'];
            $id    = (int) $_POST['id'];

            $PDV = new Product();
            $PDV->Quantidadex_x($id_db_settings, $id, $value, $id_user);

            if($PDV->getResult()):
                WSError($PDV->getError()[0], $PDV->getError()[1]);
            else:
                WSError($PDV->getError()[0], $PDV->getError()[1]);
            endif;

            break;
        case 'SearchProductxxx':
            $NnM = 0;
            $searching = strip_tags(($_POST['SearchProductxxx']));
            $SearchProduct01 = strip_tags(($_POST['SearchProductxxx00']));
            $a = 1;

            $read = new Read();
            $read->FullRead("SELECT *
FROM cv_product
LEFT JOIN cv_category ON cv_category.id_db_settings = cv_product.id_db_settings
                       AND cv_category.id_xxx = cv_product.id_category
WHERE 
    cv_product.id_db_settings ={$id_db_settings}
    AND (
        cv_product.product LIKE '%' '{$searching}' '%'
        AND cv_product.codigo LIKE '%' '{$SearchProduct01}' '%'
    )
    OR(
        cv_product.codigo LIKE '%' '{$searching}' '%'
        AND cv_product.product LIKE '%' '{$SearchProduct01}' '%'
    )OR(
        cv_product.product LIKE '%' '{$searching}' '%'
        AND cv_product.product LIKE '%' '{$SearchProduct01}' '%'
    )
    OR(
        cv_product.codigo_barras LIKE '%' '{$searching}' '%'
        AND cv_product.codigo LIKE '%' '{$SearchProduct01}' '%'
    )
    OR (
        cv_product.codigo LIKE '%' '{$searching}' '%'
        AND cv_product.codigo_barras LIKE '%' '{$SearchProduct01}' '%'
    )
    OR(
        cv_product.product LIKE '%' '{$searching}' '%'
        AND cv_product.remarks LIKE '%' '{$SearchProduct01}' '%'
    )
    OR(
        cv_product.remarks LIKE '%' '{$searching}' '%'
        AND cv_product.local_product LIKE '%' '{$SearchProduct01}' '%'
    )
    OR(
        cv_product.local_product LIKE '%' '{$searching}' '%'
        AND cv_product.remarks LIKE '%' '{$SearchProduct01}' '%'
    )
    OR (
        cv_product.product LIKE '%' '{$searching}' '%'
        AND cv_product.codigo LIKE '%' '{$SearchProduct01}' '%'
    )
    OR(
        cv_category.category_title LIKE '%' '{$searching}' '%'
        AND cv_product.product LIKE '%' '{$SearchProduct01}' '%'
        AND cv_product.id_category = cv_category.id_xxx
    )
    OR (
        cv_product.product LIKE '%' '{$searching}' '%'
        AND cv_category.category_title LIKE '%' '{$SearchProduct01}' '%'
        AND cv_product.id_category = cv_category.id_xxx
    )
    OR (
        cv_category.category_title LIKE '%' '{$searching}' '%'
        AND cv_product.codigo LIKE '%' '{$SearchProduct01}' '%'
        AND cv_product.id_category = cv_category.id_xxx
    )
    OR (
        cv_product.codigo LIKE '%' '{$searching}' '%'
        AND cv_category.category_title LIKE '%' '{$SearchProduct01}' '%'
        AND cv_product.id_category = cv_category.id_xxx
    )
    OR (
        cv_category.category_title LIKE '%' '{$searching}' '%'
        AND cv_product.codigo_barras LIKE '%' '{$SearchProduct01}' '%'
        AND cv_product.id_category = cv_category.id_xxx
    )
    OR (
        cv_product.codigo_barras LIKE '%' '{$searching}' '%'
        AND cv_category.category_title LIKE '%' '{$SearchProduct01}' '%'
        AND cv_product.id_category = cv_category.id_xxx
    )
    OR (
        cv_category.category_title LIKE '%' '{$searching}' '%'
        AND cv_product.remarks LIKE '%' '{$SearchProduct01}' '%'
        AND cv_product.id_category = cv_category.id_xxx
    )
    OR (
        cv_product.remarks LIKE '%' '{$searching}' '%'
        AND cv_category.category_title LIKE '%' '{$SearchProduct01}' '%'
        AND cv_product.id_category = cv_category.id_xxx
    )
    OR (
        cv_category.category_title LIKE '%' '{$searching}' '%'
        AND cv_product.local_product LIKE '%' '{$SearchProduct01}' '%'
        AND cv_product.id_category = cv_category.id_xxx
    )
    OR (
        cv_product.local_product LIKE '%' '{$searching}' '%'
        AND cv_category.category_title LIKE '%' '{$SearchProduct01}' '%'
        AND cv_product.id_category = cv_category.id_xxx
    )
ORDER BY cv_product.product ASC
LIMIT 50");

            if($read->getResult()):
                foreach($read->getResult() as $key):
                    if($key['ILoja'] == 2 || $key['ILoja'] == null || $key['ILoja'] == '' || $key['ILoja'] != 1):

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
                        if($DB->CheckCpanelAndSettings($id_db_settings)['atividade'] == 1 || $DB->CheckCpanelAndSettings($id_db_settings)['atividade'] == 4):
                            $NnM = $key['quantidade'];
                        else:
                            $NnM = $key['gQtd'];
                        endif;

                        if($key['desconto'] < 0 || $key['desconto'] == null || !isset($key['desconto'])): $Emanuel = 0; else: $Emanuel = $key['desconto']; endif;
                        ?>
                        <tr>
                            <td style="max-width: 30%!important;font-size: 10pt!important;"><?=  $key['codigo']; ?></td>
                            <td style="max-width: 30%!important;font-size: 10pt!important;"><?=  $key['product']; ?></td>
                            <td style="max-width: 30%!important;font-size: 10pt!important;"><?=  $key['codigo_barras']; ?></td>
                            <td style="max-width: 10%!important;">
                                <input style="width: 100%!important;" type="number" id="desconto_<?= $key['id']; ?>" <?php if($level < 3): ?> disabled <?php endif; ?> class="form-kwanzar" min="0" max="100000000000000000000000" value="<?= $Emanuel; ?>" placeholder="Desconto">
                            </td>
                            <td style="max-width: 10%!important;">
                                <input style="width: 100%!important;" type="hidden" id="taxa_<?= $key['id']; ?>" class="form-kwanzar" disabled value="<?= $key['id_iva']; ?>" placeholder="Taxa de imposto"><?= $key['iva']; ?>
                            </td>
                            <td style="max-width: 20%!important;">
                                <input style="width: 100%!important;" type="text" class="form-kwanzar" id="preco_<?= $key['id']; ?>" disabled value="<?= $preco; ?>">
                            </td>
                            <td style="max-width: 10%!important;">
                                <input style="width: 100%!important;" type="number" class="form-kwanzar" id="quantidade_<?= $key['id']; ?>" min="1" value="1"><br/>
                                <center>Exis.: <span><?= $NnM; ?></span></center>
                            </td>
                            <td style="max-width: 1%!important;">
                                <input type="hidden" value="<?= $userlogin['id']; ?>" id="session_id_<?= $key['id']; ?>">
                            </td>
                            <td style="max-width: 1%!important;">
                                <input type="hidden" value="<?= $id_db_settings; ?>" id="id_db_settings_<?= $key['id']; ?>">
                            </td>
                            <td style="max-width: 10%!important;">
                                <span><?= $key['local_product']; ?></span>
                            </td>
                            <td style="max-width: 10%!important;">
                                <span><?= $key['remarks']; ?></span>
                            </td>
                            <td style="max-width: 15%!important;">
                                <a href="javascript:void()" onclick="adicionarX(<?= $key['id']; ?>)" class="btn btn-default btn-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" /><line x1="12" y1="11" x2="12" y2="17" /><line x1="9" y1="14" x2="15" y2="14" /></svg>
                                </a>
                            </td>
                        </tr>
                    <?php
                    endif;
                endforeach;
            else:
                WSError("Ops: não encontramos nenhum produto disponível!", WS_INFOR);
            endif;

            break;
        case 'AddX':
            $Data['id_product'] = strip_tags(($_POST['id_product']));
            $Data['quantidade'] = strip_tags(($_POST['quantidade']));
            $Data['preco'] = strip_tags(($_POST['preco']));
            $Data['taxa'] = strip_tags(($_POST['taxa']));
            $Data['desconto'] = strip_tags(($_POST['desconto']));
            if(isset($_POST['id_mesa'])): $id_mesa = (int) $_POST['id_mesa']; else: $id_mesa = null; endif;

            $POS = new POS();
            $POS->AddX($Data, $id_db_settings, $userlogin['id'], $InvoiceType, $Number, $id_mesa);

            if($POS->getResult()):
                require_once("../../_disk/Helps/table-product-pos-settings-proforma-edit.inc.php");
            else:
                WSError($POS->getError()[0], $POS->getError()[1]);
            endif;

            break;
        case 'loadingPOSX':
            $NnM = 0;
            $a = 1;
            $read = new Read();
            $read->ExeRead("cv_product", "WHERE id_db_settings=:i AND ILoja!=:ss ORDER BY product ASC LIMIT 50", "i={$id_db_settings}&ss={$a}");

            if($read->getResult()):
                foreach($read->getResult() as $key):
                    if($key['ILoja'] == 2 || $key['ILoja'] == null || $key['ILoja'] == '' || $key['ILoja'] != 1):

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
                        if($DB->CheckCpanelAndSettings($id_db_settings)['atividade'] == 1 || $DB->CheckCpanelAndSettings($id_db_settings)['atividade'] == 4):
                            $NnM = $key['quantidade'];
                        else:
                            $NnM = $key['gQtd'];
                        endif;

                        if($key['desconto'] < 0 || $key['desconto'] == null || !isset($key['desconto'])): $Emanuel = 0; else: $Emanuel = $key['desconto']; endif;
                        ?>
                        <tr>
                            <td style="max-width: 30%!important;font-size: 10pt!important;"><?=  $key['codigo']; ?></td>
                            <td style="max-width: 30%!important;font-size: 10pt!important;"><?=  $key['product']; ?></td>
                            <td style="max-width: 30%!important;font-size: 10pt!important;"><?=  $key['codigo_barras']; ?></td>
                            <td style="max-width: 10%!important;">
                                <input style="width: 100%!important;" type="number" id="desconto_<?= $key['id']; ?>" <?php if($level < 3): ?> disabled <?php endif; ?> class="form-kwanzar" min="0" max="100000000000000000000000" value="<?= $Emanuel; ?>" placeholder="Desconto">
                            </td>
                            <td style="max-width: 10%!important;">
                                <input style="width: 100%!important;" type="hidden" id="taxa_<?= $key['id']; ?>" class="form-kwanzar" disabled value="<?= $key['id_iva']; ?>" placeholder="Taxa de imposto"><?= $key['iva']; ?>
                            </td>
                            <td style="max-width: 20%!important;">
                                <input style="width: 100%!important;" type="text" class="form-kwanzar" id="preco_<?= $key['id']; ?>" disabled value="<?= $preco; ?>">
                            </td>
                            <td style="max-width: 10%!important;">
                                <input style="width: 100%!important;" type="number" class="form-kwanzar" id="quantidade_<?= $key['id']; ?>" min="1" value="1"><br/>
                                <center>Exis.: <span><?= $NnM; ?></span></center>
                            </td>
                            <td style="max-width: 1%!important;">
                                <input type="hidden" value="<?= $userlogin['id']; ?>" id="session_id_<?= $key['id']; ?>">
                            </td>
                            <td style="max-width: 1%!important;">
                                <input type="hidden" value="<?= $id_db_settings; ?>" id="id_db_settings_<?= $key['id']; ?>">
                            </td>
                            <td style="max-width: 10%!important;">
                                <span><?= $key['local_product']; ?></span>
                            </td>
                            <td style="max-width: 10%!important;">
                                <span><?= $key['remarks']; ?></span>
                            </td>
                            <td style="max-width: 15%!important;">
                                <a href="javascript:void()" onclick="adicionarX(<?= $key['id']; ?>)" class="btn btn-default btn-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" /><line x1="12" y1="11" x2="12" y2="17" /><line x1="9" y1="14" x2="15" y2="14" /></svg>
                                </a>
                            </td>
                        </tr>
                    <?php
                    endif;
                endforeach;
            endif;
            break;
        case 'RemovePSX':
            $id_product = strip_tags(($_POST['id_product']));

            $POS = new POS();
            $POS->RemovePSX($id_product, $id_db_settings, $InvoiceType, $Number, $id_user);

            if($POS->getResult()):
                require_once("../../_disk/Helps/table-product-pos-settings-proforma-edit.inc.php");
            else:
                WSError($POS->getError()[0], $POS->getError()[1]);
            endif;

            break;
        case 'PricingsX1':
            $value = (int) $_POST['value'];
            $id    = (int) $_POST['id'];

            $PDV = new POS();
            $PDV->PricingsX1($id_db_settings, $id_user, $id, $value);

            if($PDV->getResult()):
                require_once("../../_disk/Helps/table-product-pos-settings-proforma-edit.inc.php");
            else:
                WSError($PDV->getError()[0], $PDV->getError()[1]);
            endif;

            break;
        case 'DescsX1':
            $value = (int) $_POST['value'];
            $id    = (int) $_POST['id'];

            $PDV = new POS();
            $PDV->DescsX1($id_db_settings, $id_user, $id, $value);

            if($PDV->getResult()):
                require_once("../../_disk/Helps/table-product-pos-settings-proforma-edit.inc.php");
            else:
                WSError($PDV->getError()[0], $PDV->getError()[1]);
            endif;

            break;
        case 'QtdsX1':
            $value = (int) $_POST['value'];
            $id    = (int) $_POST['id'];

            $PDV = new POS();
            $PDV->QtdsX1($id_db_settings, $id_user, $id, $value);

            if($PDV->getResult()):
                require_once("../../_disk/Helps/table-product-pos-settings-proforma-edit.inc.php");
            else:
                WSError($PDV->getError()[0], $PDV->getError()[1]);
            endif;

            break;
        case 'TaxPointDate':
            if(isset($_POST['postId'])):      $postId = (int) $_POST['postId']; endif;
            if(isset($_POST['TaxPointDate'])): $Data['TaxPointDate'] = strip_tags(($_POST['TaxPointDate'])); else: $Data = array(); endif;

            $POS = new POS();
            $POS->TaxPointDate($Data, $Number, $id_db_settings, $id_user, $postId, $id_db_kwanzar);
            $DB = new DBKwanzar();

            if(!$POS->getResult()):
                WSError($POS->getError()[0], $POS->getError()[1]);
            else:
                WSError($POS->getError()[0], $POS->getError()[1]);
            endif;
            break;
        case 'Figma':
            if(isset($_POST['postId'])):      $postId = (int) $_POST['postId']; endif;
            if(isset($_POST['InvoiceType'])): $InvoiceType = strip_tags(($_POST['InvoiceType'])); endif;
            if(isset($_POST['customer'])): $customer = strip_tags(($_POST['customer'])); endif;
            if(isset($_POST['method'])): $method = strip_tags(($_POST['method'])); endif;

            if(isset($_POST['pagou'])): $Data['pagou'] = (double) $_POST['pagou']; endif;
            if(isset($_POST['troco'])): $Data['troco'] = (double) $_POST['troco']; endif;

            if(isset($_POST['cartao_de_debito'])): $Data['cartao_de_debito'] = (double) $_POST['cartao_de_debito']; endif;
            if(isset($_POST['transferencia'])): $Data['transferencia'] = (double) $_POST['transferencia']; endif;
            if(isset($_POST['numerario'])): $Data['numerario'] = (double) $_POST['numerario']; endif;
            if(isset($_POST['all_total'])): $Data['all_total'] = (double) $_POST['all_total']; endif;

            $Data['InvoiceType'] = $InvoiceType;
            //$Data['customer']  = $customer;

            $POS = new POS();
            $POS->Conversor($Data, $id_db_settings, $id_user, $postId, $id_db_kwanzar, $customer, $method);
            $DB = new DBKwanzar();

            if(!$POS->getResult()):
                WSError($POS->getError()[0], $POS->getError()[1]);
            else:
                WSError($POS->getError()[0], $POS->getError()[1]);
            endif;
            break;
        case 'Distancia':
            $id_product = strip_tags(trim($_POST['id_product']));
            $qtdOne     = strip_tags(trim($_POST['qtdOne']));

            $PDV = new POS();
            $PDV->Distancia($id_db_settings, $id_product, $qtdOne);

            WSError($PDV->getError()[0], $PDV->getError()[1]);

            break;
        case 'Qtds':
            $value = (int) $_POST['value'];
            $id    = (int) $_POST['id'];

            $PDV = new POS();
            $PDV->Qtds($id_db_settings, $id_user, $id, $value);

            if($PDV->getResult()):
                require_once("../../_disk/Helps/table-product-pos-settings.inc.php");
            else:
                WSError($PDV->getError()[0], $PDV->getError()[1]);
            endif;

            break;
        case 'Descs':
            $value = (int) $_POST['value'];
            $id    = (int) $_POST['id'];

            $PDV = new POS();
            $PDV->Descs($id_db_settings, $id_user, $id, $value);

            if($PDV->getResult()):
                require_once("../../_disk/Helps/table-product-pos-settings.inc.php");
            else:
                WSError($PDV->getError()[0], $PDV->getError()[1]);
            endif;

            break;
        case 'Pricings':
            $value = (int) $_POST['value'];
            $id    = (int) $_POST['id'];

            $PDV = new POS();
            $PDV->Pricings($id_db_settings, $id_user, $id, $value);

            if($PDV->getResult()):
                require_once("../../_disk/Helps/table-product-pos-settings.inc.php");
            else:
                WSError($PDV->getError()[0], $PDV->getError()[1]);
            endif;

            break;
        case 'BoxClose':
            $POS = new POS();
            $POS->BoxClose($id_db_settings, $id_user);

            if($POS->getResult()):
                require_once("../../_requires/10-system-WoW-invoice-document-body.inc.php");
            else:
                WSError($POS->getError()[0], $POS->getError()[1]);
            endif;

            break;
            break;
        case 'SangriaBox':
            $text_sangria  = strip_tags(($_POST['text_sangria']));
            $value_sangria = strip_tags(($_POST['value_sangria']));

            $POS = new POS();
            $POS->SangriaBox($id_db_settings, $id_user, $value_sangria, $text_sangria);

            WSError($POS->getError()[0], $POS->getError()[1]);

            break;
        case 'OpenBox':
            $value_open = strip_tags(($_POST['value_open']));

            $POS = new POS();
            $POS->OpenBox($id_db_settings, $id_user, $value_open);

            WSError($POS->getError()[0], $POS->getError()[1]);

            break;
        case 'SearchDocuments':
            $searching = strip_tags(($_POST['searching']));
            $level = strip_tags(($_POST['level']));

            $Read = new Read();
            $Read->ExeRead("db_config", "WHERE id_db_settings=:i ", "i={$id_db_settings}");
            if(!$Read->getResult() || !$Read->getRowCount()):
                header("Location: panel.php?exe=settings/System_Settings{$n}");
            endif;

            ?>
            <table class="table" style="text-align: left!important;align-content: flex-start!important;align-items: flex-start!important;">
                <thead>
                <tr>
                    <th>Número</th>
                    <th>Nº do Documento</th>
                    <th>Cliente</th>
                    <th>Forma de Pagamento</th>
                    <th>Data</th>
                    <th>Documento</th>
                    <th style="width: 350px!important">-</th>
                    <th>ID</th>
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
                $n6 = "sd_guid_pmp";
                $PPs = "'PP'";

                $read = new Read();
                $read->ExeRead("{$n1}", "WHERE ({$n1}.id_db_settings=:i AND {$n1}.InvoiceType!={$PPs} AND numero LIKE '%' :link '%'  AND  {$n1}.status=:st AND {$n1}.suspenso={$s}) OR ({$n1}.id_db_settings=:i AND {$n1}.InvoiceType!={$PPs} AND customer_nif LIKE '%' :link '%'  AND  {$n1}.status=:st AND {$n1}.suspenso={$s}) OR ({$n1}.id_db_settings=:i AND {$n1}.InvoiceType!={$PPs} AND customer_name LIKE '%' :link '%'  AND  {$n1}.status=:st AND {$n1}.suspenso={$s}) OR ({$n1}.id_db_settings=:i AND {$n1}.InvoiceType!={$PPs} AND username LIKE '%' :link '%'  AND  {$n1}.status=:st AND {$n1}.suspenso={$s})", "i={$id_db_settings}&link={$searching}&st={$st}");
                if($read->getResult()):
                    foreach ($read->getResult() as $key):
                        require("../../_disk/AppData/ResultDocumentsInvoice.inc.php");
                    endforeach;
                endif;
                ?>
                </tbody>
            </table>
            <?php
            break;
        case 'SearchDocumentsProformas':
            $searching = strip_tags(($_POST['searching']));
            $level = strip_tags(($_POST['level']));
            ?>
            <table class="table" style="text-align: left!important;align-content: flex-start!important;align-items: flex-start!important;">
                <thead>
                <tr>
                    <th>Número</th>
                    <th>Cliente</th>
                    <th>Data</th>
                    <th>Documento</th>
                    <th style="width: 350px!important">-</th>
                    <th>ID</th>
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
                $PPs = "PP";

                $read = new Read();
                $read->ExeRead("{$n1}", "WHERE ({$n1}.id_db_settings=:i AND {$n1}.InvoiceType=:invoice AND numero LIKE '%' :link '%'  AND  {$n1}.status=:st AND {$n1}.suspenso={$s}) OR ({$n1}.id_db_settings=:i AND {$n1}.InvoiceType=:invoice AND customer_nif LIKE '%' :link '%'  AND  {$n1}.status=:st AND {$n1}.suspenso={$s}) OR ({$n1}.id_db_settings=:i AND {$n1}.InvoiceType=:invoice AND customer_name LIKE '%' :link '%'  AND  {$n1}.status=:st AND {$n1}.suspenso={$s}) OR ({$n1}.id_db_settings=:i AND {$n1}.InvoiceType=:invoice AND username LIKE '%' :link '%'  AND  {$n1}.status=:st AND {$n1}.suspenso={$s})", "i={$id_db_settings}&invoice={$PPs}&link={$searching}&st={$st}");
                if($read->getResult()):
                    foreach ($read->getResult() as $key):
                       require("../../_disk/AppData/ResultDocumentsProformas.inc.php");
                    endforeach;
                endif;
                ?>
                </tbody>
            </table>
            <?php
            break;
        case 'RemFinish':
            if(isset($_POST['InvoiceType'])):    $InvoiceType     = strip_tags(($_POST['InvoiceType'])); endif;
            if(isset($_POST['Number'])):         $Number          = (int) strip_tags(($_POST['Number'])); endif;
            if(isset($_POST['iddInvoice'])):     $iddInvoice          = strip_tags(($_POST['iddInvoice'])); endif;
            if(isset($_POST['is_number'])):     $is_number          = strip_tags(($_POST['is_number'])); endif;

            $POS = new POS();
            $POS->RemFinish($id_db_settings, $id_user, $InvoiceType, $Number, $iddInvoice, $is_number);

            if($POS->getResult()):
                WSError($POS->getError()[0], $POS->getError()[1]);
            else:
                WSError($POS->getError()[0], $POS->getError()[1]);
            endif;

            break;
        case 'GuidFinish':
            if(isset($_POST['InvoiceType'])):    $Commic          = strip_tags(($_POST['InvoiceType'])); endif;
            if(isset($_POST['InvoiceType'])):    $InvoiceType     = strip_tags(($_POST['InvoiceType'])); endif;
            if(isset($_POST['Number'])):         $Number          = (int) strip_tags(($_POST['Number'])); endif;

            $POS = new POS();
            $POS->GuidFinish($id_db_settings, $id_user, $InvoiceType, $Number);

            if($POS->getResult()):
                WSError($POS->getError()[0], $POS->getError()[1]);
            else:
                WSError($POS->getError()[0], $POS->getError()[1]);
            endif;

            break;
        case 'AddRetification':
            if(isset($_POST['InvoiceType'])):    $InvoiceType     = strip_tags(($_POST['InvoiceType'])); endif;
            if(isset($_POST['InvoiceType'])):    $Commic          = strip_tags(($_POST['InvoiceType'])); endif;
            if(isset($_POST['iddInvoice'])):     $iddInvoice          = strip_tags(($_POST['iddInvoice'])); endif;

            $idd                = (int) $_POST['id_sd_billing_pmp'];
            $Number                = (int) $_POST['Number'];
            $id_sd_billing_pmp  = (int) $_POST['idd'];
            $Data['quantidade'] = strip_tags(($_POST['quantidade']));
            $Data['status']     = strip_tags(($_POST['status']));

            $POS = new POS();
            $POS->Remove($Data, $id_db_settings, $id_sd_billing_pmp, $id_user, $idd, $InvoiceType, $iddInvoice, $Number);

            if($POS->getResult()):
                WSError($POS->getError()[0], $POS->getError()[1]);
            else:
                WSError($POS->getError()[0], $POS->getError()[1]);
            endif;

            break;
        case 'AddGuid':
            if(isset($_POST['InvoiceType'])):    $InvoiceType     = strip_tags(($_POST['InvoiceType'])); endif;
            if(isset($_POST['InvoiceType'])):    $Commic          = strip_tags(($_POST['InvoiceType'])); endif;
            $idd                = (int) $_POST['id_sd_billing_pmp'];
            $id_sd_billing_pmp  = (int) $_POST['idd'];
            $Data['quantidade'] = strip_tags(($_POST['quantidade']));
            $Data['status']     = strip_tags(($_POST['status']));

            $POS = new POS();
            $POS->RemoveGuid($Data, $id_db_settings, $id_sd_billing_pmp, $id_user, $idd, $InvoiceType);

            if($POS->getResult()):
                WSError($POS->getError()[0], $POS->getError()[1]);
            else:
                WSError($POS->getError()[0], $POS->getError()[1]);
            endif;

            break;
        case 'Xvideos':
            $Number = (int) $_POST['id_invoice'];
            if(isset($_POST['Invoice'])):       $InvoiceType         = strip_tags(($_POST['Invoice'])); endif;
            if(isset($_POST['Invoice'])):       $Commic              = strip_tags(($_POST['Invoice'])); endif;
            if(isset($_POST['TaxPointDate'])):  $TaxPointDate        = strip_tags(($_POST['TaxPointDate'])); endif;
            if(isset($_POST['InvoiceType'])):   $Invoice             = strip_tags(($_POST['InvoiceType'])); endif;
            if(isset($_POST['InvoiceType'])):   $Commic             = strip_tags(($_POST['InvoiceType'])); endif;
            if(isset($_POST['method'])):        $method              = strip_tags(($_POST['method'])); endif;
            if(isset($_POST['SourceBilling'])): $SourceBilling       = strip_tags(($_POST['SourceBilling'])); endif;
            if(isset($_POST['settings_doctype'])): $settings_doctype = strip_tags($_POST['settings_doctype']); endif;

            require_once("../../_disk/Helps/retification-settings.inc.php");

            break;
        case 'Retification':
            $Number = (int) $_POST['id_invoice'];
            if(isset($_POST['Invoice'])):       $InvoiceType         = strip_tags(($_POST['Invoice'])); endif;
            if(isset($_POST['Invoice'])):       $Commic              = strip_tags(($_POST['Invoice'])); endif;
            if(isset($_POST['TaxPointDate'])):  $TaxPointDate        = strip_tags(($_POST['TaxPointDate'])); endif;
            if(isset($_POST['InvoiceType'])):   $Invoice             = strip_tags(($_POST['InvoiceType'])); endif;
            if(isset($_POST['method'])):        $method              = strip_tags(($_POST['method'])); endif;
            if(isset($_POST['SourceBilling'])): $SourceBilling       = strip_tags(($_POST['SourceBilling'])); endif;
            if(isset($_POST['settings_doctype'])): $settings_doctype = strip_tags($_POST['settings_doctype']); endif;

            $Data['method'] = $method;
            $Data['TaxPointDate'] = $TaxPointDate;
            $Data['InvoiceType'] = $Invoice;
            $Data['SourceBilling'] = "P";
            $Data['settings_doctype'] = $settings_doctype;

            $POS = new POS();
            $POS->Retification($Data, $Number, $id_db_settings, $id_user, $InvoiceType);

            if(!$POS->getResult()):
                WSError($POS->getError()[0], $POS->getError()[1]);
            else:
                //WSError($POS->getError()[0], $POS->getError()[1]);
                require_once("../../_disk/Helps/retification-settings.inc.php");
            endif;

            break;
        case 'Guid':
            $Number = (int) $_POST['id_invoice'];
            if(isset($_POST['Invoice'])):       $InvoiceType       = strip_tags(($_POST['Invoice'])); endif;
            if(isset($_POST['Invoice'])):       $Commic       = strip_tags(($_POST['Invoice'])); endif;
            //if(isset($_POST['InvoiceType'])):   $Commic            = strip_tags(($_POST['InvoiceType'])); endif;
            if(isset($_POST['TaxPointDate'])):  $TaxPointDate      = strip_tags(($_POST['TaxPointDate'])); endif;
            if(isset($_POST['InvoiceType'])):   $Invoice           = strip_tags(($_POST['InvoiceType'])); endif;
            if(isset($_POST['method'])):        $method            = strip_tags(($_POST['method'])); endif;
            if(isset($_POST['SourceBilling'])): $SourceBilling     = strip_tags(($_POST['SourceBilling'])); endif;
            if(isset($_POST['guid_name'])):     $guid_name         = strip_tags(($_POST['guid_name'])); endif;
            if(isset($_POST['guid_matricula'])):$guid_matricula    = strip_tags(($_POST['guid_matricula'])); endif;
            if(isset($_POST['guid_obs'])):      $guid_obs          = strip_tags(($_POST['guid_obs'])); endif;
            if(isset($_POST['guid_endereco'])): $guid_endereco     = strip_tags(($_POST['guid_endereco'])); endif;
            if(isset($_POST['guid_city'])):     $guid_city         = strip_tags(($_POST['guid_city'])); endif;
            if(isset($_POST['guid_postal'])):   $guid_postal       = strip_tags(($_POST['guid_postal'])); endif;

            $Data['method']         = $method;
            $Data['TaxPointDate']   = $TaxPointDate;
            $Data['InvoiceType']    = $Invoice;
            $Data['SourceBilling']  = "P";
            $Data['guid_name']      = $guid_name;
            $Data['guid_matricula'] = $guid_matricula;
            $Data['guid_obs']       = $guid_obs;
            $Data['guid_endereco']  = $guid_endereco;
            $Data['guid_city']      = $guid_city;
            $Data['guid_postal']    = $guid_postal;

            $POS = new POS();
            $POS->Guid($Data, $Number, $id_db_settings, $id_user, $InvoiceType);

            if(!$POS->getResult()):
                WSError($POS->getError()[0], $POS->getError()[1]);
            else:
                require_once("../../_disk/Helps/guid--settings.inc.php");
            endif;

            break;
        case 'ConfigUsers':
            if(isset($_POST['Impression'])):      $Data['Impression']      = strip_tags(($_POST['Impression'])); endif;
            if(isset($_POST['NumberOfCopies'])):  $Data['NumberOfCopies']  = strip_tags(($_POST['NumberOfCopies'])); endif;
            if(isset($_POST['PRecuvaPassword'])): $Data['PRecuvaPassword'] = strip_tags(($_POST['PRecuvaPassword'])); endif;
            if(isset($_POST['RecuvaPassword'])):  $Data['RecuvaPassword']  = strip_tags(($_POST['RecuvaPassword'])); endif;
            if(isset($_POST['Language'])):        $Data['Language']        = strip_tags(($_POST['Language'])); endif;
            if(isset($_POST['positionMenu'])):    $Data['positionMenu']    = strip_tags(($_POST['positionMenu'])); endif;

            $DBKwanzar = new DBKwanzar();
            $DBKwanzar->UsersConfig($Data, $id_db_settings, $id_user);

            WSError($DBKwanzar->getError()[0], $DBKwanzar->getError()[1]);

            break;
        case 'DocumentPdv':
            $dateI = strip_tags(($_POST['dateI']));
            $dateF = strip_tags(($_POST['dateF']));
            $Function_id = strip_tags(($_POST['Function_id']));

            $TypeDoc = strip_tags(($_POST['TypeDoc']));
            $SourceBilling = strip_tags(($_POST['SourceBilling']));
            $Customers_id = strip_tags(($_POST['Customers_id']));

            if(empty($dateI) || empty($dateF)):
                WSError("Ops: selecione a data do documento!", WS_INFOR);
            else:
                ?>
                <div class="styles">
                    <a class="btn btn-default bol-sm btn btn-default btn-sm" href="export.php?dateI=<?= $dateI; ?>&dateF=<?= $dateF; ?>&id_user=<?= $id_user ?>&id_db_settings=<?= $id_db_settings; ?>&SourceBilling=<?= $SourceBilling; ?>&TypeDoc=<?= $TypeDoc; ?>&Function_id=<?= $Function_id; ?>&Customers_id=<?= $Customers_id; ?>" target="_blank">Exportar para o Excel</a>&nbsp;
                    <a href="print.php?action=03&dateI=<?= $dateI; ?>&dateF=<?= $dateF; ?>&id_user=<?= $id_user ?>&id_db_settings=<?= $id_db_settings; ?>&SourceBilling=<?= $SourceBilling; ?>&TypeDoc=<?= $TypeDoc; ?>&Function_id=<?= $Function_id; ?>&Customers_id=<?= $Customers_id ?>" target="_blank" class="bol bol-default bol-sm btn btn-primary btn-sm">Imprimir</a>
                </div>

                <table class="table">
                <thead>
                <tr>
                    <th>DOC</th>
                    <th>Nº DOC</th>
                    <th>PAGAMENTO</th>
                    <th>ITEM</th>
                    <th>QTD</th>
                    <th>PREÇO UN.</th>
                    <th>DESCONTO</th>
                    <th>TAXA</th>
                    <th>TOTAL</th>
                    <th>DATA</th>
                    <th>CLIENTE</th>
                    <th>VENDEDOR</th>
                </tr>
                </thead>
                <tbody>
                <?php

                $t_quantidade = 0;
                $t_desconto = 0;
                $t_value = 0;
                $t_sub = 0;
                $t_geral = 0;
                $t_imposto = 0;


                $suspenso = 0;
                if(DBKwanzar::CheckConfig($id_db_settings)['JanuarioSakalumbu'] == null): $ttt = 2; else: $ttt = DBKwanzar::CheckConfig($id_db_settings)['JanuarioSakalumbu']; endif;

                $I = explode("-", $dateI);
                $F = explode("-", $dateF);

                $Read = new Read();
                $us = array();

                $Read->ExeRead("db_users", "WHERE id=:id", "id={$id_user}");
                if($Read->getResult()):
                    $us = $Read->getResult()[0];
                endif;

                if($TypeDoc == "CO" || $TypeDoc == "FT" || $TypeDoc == "FR"):
                    if($SourceBilling == 'T'): $source = null; else: $source = " AND sd_billing.SourceBilling='{$SourceBilling}' "; endif;
                    if($Customers_id == "all"): $fCus = null; else: $fCus = " AND sd_billing.id_customer={$Customers_id} "; endif;

                    if($us['level'] >= 3):

                        if($Function_id == "all"): $nYf = null; else: $nYf = "AND sd_billing.session_id={$Function_id} AND sd_billing_pmp.session_id={$Function_id} "; endif;

                        if($TypeDoc == 'CO' || $TypeDoc == 'TM'): $lata = " AND sd_billing.InvoiceType!='PP' AND sd_billing_pmp.InvoiceType!='PP' "; elseif($TypeDoc == 'FT' || $TypeDoc == 'FR'):  $lata = " AND sd_billing.InvoiceType='{$TypeDoc}'  AND sd_billing_pmp.InvoiceType='{$TypeDoc}'"; endif;

                        $where = " WHERE sd_billing.id_db_settings=:i AND sd_billing.status=:st AND sd_billing.suspenso=:s {$lata} {$source} AND sd_billing.dia BETWEEN {$I[2]} AND {$F[2]} AND sd_billing.mes BETWEEN {$I[1]} AND {$F[1]} AND sd_billing.ano BETWEEN {$I[0]} AND {$F[0]} AND sd_billing_pmp.id_db_settings=:i AND sd_billing.numero=sd_billing_pmp.numero AND sd_billing_pmp.status=:st {$fCus} {$nYf}";
                        $clause = "i={$id_db_settings}&st={$ttt}&s={$suspenso}";
                    else:
                        if($TypeDoc == 'CO' || $TypeDoc == 'TM'): $lata = " AND sd_billing.InvoiceType!='PP' AND sd_billing_pmp.InvoiceType!='PP' "; elseif($TypeDoc == 'FT' || $TypeDoc == 'FR'):  $lata = " AND sd_billing.InvoiceType='{$TypeDoc}'  AND sd_billing_pmp.InvoiceType='{$TypeDoc}'"; endif;

                        $where = "WHERE sd_billing.id_db_settings=:i AND sd_billing.session_id=:ses AND sd_billing.status=:st AND sd_billing.suspenso=:s {$lata} {$source} AND sd_billing.dia BETWEEN {$I[2]} AND {$F[2]} AND sd_billing.mes BETWEEN {$I[1]} AND {$F[1]} AND sd_billing.ano BETWEEN {$I[0]} AND {$F[0]} AND sd_billing_pmp.id_db_settings=:i AND sd_billing.numero=sd_billing_pmp.numero AND sd_billing_pmp.status=:st {$fCus}";
                        $clause = "i={$id_db_settings}&ses={$id_user}&st={$ttt}&s={$suspenso}";
                    endif;
                        $Read->ExeRead("sd_billing, sd_billing_pmp", $where, $clause);
                        if($Read->getResult()):
                            foreach($Read->getResult() as $love):
                                extract($love);
                                $value = ($love['quantidade_pmp'] * $love['preco_pmp']);
                                $desconto = ($value * $love['desconto_pmp']) / 100;
                                $imposto  = ($value * $love['taxa']) / 100;
                                $total = ($value - $desconto) + $imposto;

                                $t_imposto += $imposto;
                                $t_desconto += $desconto;
                                $t_value += $value;
                                $t_sub += $total;
                                ?>
                                <tr>
                                    <td><?= $love['InvoiceType'] ?></td>
                                    <td><?= $love['numero'] ?></td>
                                    <td><?php
                                        if($love['method'] == 'CC'):
                                            echo 'Cartão de Credito';
                                        elseif($love['method'] == 'CD'):
                                            echo 'Cartão de Debito';
                                        elseif($love['method'] == 'CH'):
                                            echo 'Cheque Bancário';
                                        elseif($love['method'] == 'NU'):
                                            echo 'Numerário';
                                        elseif ($love['method'] == 'TB'):
                                            echo 'Transferência Bancária';
                                        elseif($love['method'] == 'OU'):
                                            echo 'Outros Meios Aqui não Assinalados';
                                        endif; ?></td>
                                    <td><?= $love['product_name'] ?></td>
                                    <td><?= number_format($love['quantidade_pmp'], 2) ?></td>
                                    <td><?= number_format($love['preco_pmp'], 2) ?></td>
                                    <td><?= number_format($love['desconto_pmp'], 2) ?>%</td>
                                    <td><?= number_format($love['taxa'], 2) ?>%</td>
                                    <td><?= number_format($total, 2) ?></td>
                                    <td><?= $love['dia']."-".$love['mes']."-".$love['ano'] ?></td>
                                    <td><?= $love['customer_name'] ?></td>
                                    <td><?= $love['username'] ?></td>
                                </tr>
                                <?php

                            endforeach;
                        endif;

                    $t_geral = ($t_sub - $t_desconto) + $t_imposto;
                elseif($TypeDoc == 'RT' || $TypeDoc == "NC" || $TypeDoc == "ND" || $TypeDoc == "RE" || $TypeDoc == "RC" || $TypeDoc == "RG"):
                    if($SourceBilling == 'T'): $source = null; else: $source = " AND sd_retification.SourceBilling='{$SourceBilling}' "; endif;

                    if($Customers_id == "all"): $fCus = null; else: $fCus = " AND sd_retification.id_customer={$Customers_id}"; endif;

                    if($us['level'] >= 3):
                        if($Function_id == "all"): $nYf = null; else: $nYf = "AND sd_retification.session_id={$Function_id} AND sd_retification_pmp.session_id={$Function_id} "; endif;

                        if($TypeDoc == 'RT' || $TypeDoc == 'TM'): $lata = " AND sd_retification.InvoiceType!='PP' AND sd_retification_pmp.InvoiceType!='PP' "; elseif($TypeDoc == 'NC' || $TypeDoc == 'ND' || $TypeDoc == 'RE' ||  $TypeDoc == 'RC' || $TypeDoc == 'RG'):  $lata = " AND sd_retification.InvoiceType='{$TypeDoc}' AND sd_retification_pmp.InvoiceType='{$TypeDoc}' "; endif;

                        $where = " WHERE sd_retification.id_db_settings=:i AND sd_retification.status=:st {$lata} {$source} AND sd_retification.dia BETWEEN {$I[2]} AND {$F[2]} AND sd_retification.mes BETWEEN {$I[1]} AND {$F[1]} AND sd_retification.ano BETWEEN {$I[0]} AND {$F[0]} AND sd_retification_pmp.id_db_settings=:i AND sd_retification_pmp.numero=sd_retification.numero AND sd_retification_pmp.status=:st {$fCus} {$nYf}";
                        $clause = "i={$id_db_settings}&st={$ttt}";
                    else:
                        $where = "WHERE sd_retification.id_db_settings=:i AND sd_retification.session_id=:ses AND sd_retification.status=:st {$lata} {$source} AND sd_retification.dia BETWEEN {$I[2]} AND {$F[2]} AND sd_retification.mes BETWEEN {$I[1]} AND {$F[1]} AND sd_retification.ano BETWEEN {$I[0]} AND {$F[0]} AND sd_retification_pmp.id_db_settings=:i AND sd_retification_pmp.numero=sd_retification.numero AND sd_retification_pmp.status=:st {$fCus}";
                        $clause = "i={$id_db_settings}&ses={$id_user}&st={$ttt}";
                    endif;

                    $Read->ExeRead("sd_retification, sd_retification_pmp", $where, $clause);
                    if($Read->getResult()):
                        foreach($Read->getResult() as $love):
                            extract($love);
                            $value = ($love['quantidade_pmp'] * $love['preco_pmp']);
                            $desconto = ($value * $love['desconto_pmp']) / 100;
                            $imposto  = ($value * $love['taxa']) / 100;
                            $total = ($value - $desconto) + $imposto;

                            $t_imposto += $imposto;
                            $t_desconto += $desconto;
                            $t_value += $value;
                            $t_sub += $total;
                            ?>
                            <tr>
                                <td><?= $love['InvoiceType'] ?></td>
                                <td><?= $love['numero'] ?></td>
                                <td><?php
                                    if($love['method'] == 'CC'):
                                        echo 'Cartão de Credito';
                                    elseif($love['method'] == 'CD'):
                                        echo 'Cartão de Debito';
                                    elseif($love['method'] == 'CH'):
                                        echo 'Cheque Bancário';
                                    elseif($love['method'] == 'NU'):
                                        echo 'Numerário';
                                    elseif ($love['method'] == 'TB'):
                                        echo 'Transferência Bancária';
                                    elseif($love['method'] == 'OU'):
                                        echo 'Outros Meios Aqui não Assinalados';
                                    endif; ?></td>
                                <td><?= $love['product_name'] ?></td>
                                <td><?= number_format($love['quantidade_pmp'], 2) ?></td>
                                <td><?= number_format($love['preco_pmp'], 2) ?></td>
                                <td><?= number_format($love['desconto_pmp'], 2) ?>%</td>
                                <td><?= number_format($love['taxa'], 2) ?>%</td>
                                <td><?= number_format($total, 2) ?></td>
                                <td><?= $love['dia']."-".$love['mes']."-".$love['ano'] ?></td>
                                <td><?= $love['customer_name'] ?></td>
                                <td><?= $love['username'] ?></td>
                            </tr>
                            <?php

                        endforeach;
                    endif;

                    $t_geral = ($t_sub - $t_desconto) + $t_imposto;
                else:
                    if($SourceBilling == 'T'): $source1 = null; else: $source1 = " AND sd_billing.SourceBilling='{$SourceBilling}' "; endif;

                    if($Customers_id == "all"): $fCus = null; else: $fCus = " AND sd_billing.id_customer={$Customers_id}"; endif;

                    if($us['level'] >= 3):

                        if($Function_id == "all"): $nYf = null; else: $nYf = "AND sd_billing.session_id={$Function_id} AND sd_billing_pmp.session_id={$Function_id} "; endif;

                        if($TypeDoc == 'CO' || $TypeDoc == 'TM'): $lata1 = " AND sd_billing.InvoiceType!='PP' AND sd_billing_pmp.InvoiceType!='PP' "; elseif($TypeDoc == 'FT' || $TypeDoc == 'FR'):  $lata = " AND sd_billing.InvoiceType='{$TypeDoc}'  AND sd_billing_pmp.InvoiceType='{$TypeDoc}' "; endif;

                        $where1 = " WHERE sd_billing.id_db_settings=:i AND sd_billing.status=:st AND sd_billing.suspenso=:s {$lata1} {$source1} AND sd_billing.dia BETWEEN {$I[2]} AND {$F[2]} AND sd_billing.mes BETWEEN {$I[1]} AND {$F[1]} AND sd_billing.ano BETWEEN {$I[0]} AND {$F[0]} AND sd_billing_pmp.id_db_settings=:i AND sd_billing.numero=sd_billing_pmp.numero AND sd_billing_pmp.status=:st {$fCus} {$nYf}";
                        $clause1 = "i={$id_db_settings}&st={$ttt}&s={$suspenso}";
                    else:
                        if($TypeDoc == 'CO' || $TypeDoc == 'TM'): $lata1 = " AND sd_billing.InvoiceType!='PP' AND sd_billing_pmp.InvoiceType!='PP' "; elseif($TypeDoc == 'FT' || $TypeDoc == 'FR'):  $lata = " AND sd_billing.InvoiceType='{$TypeDoc}'  AND sd_billing_pmp.InvoiceType='{$TypeDoc}' "; endif;


                        $where1 = "WHERE sd_billing.id_db_settings=:i AND sd_billing.session_id=:ses AND sd_billing.status=:st AND sd_billing.suspenso=:s {$lata1} {$source1} AND sd_billing.dia BETWEEN {$I[2]} AND {$F[2]} AND sd_billing.mes BETWEEN {$I[1]} AND {$F[1]} AND sd_billing.ano BETWEEN {$I[0]} AND {$F[0]} AND sd_billing_pmp.id_db_settings=:i AND sd_billing.numero=sd_billing_pmp.numero AND sd_billing_pmp.status=:st {$fCus}";
                        $clause1 = "i={$id_db_settings}&ses={$id_user}&st={$ttt}&s={$suspenso}";
                    endif;

                    $Read->ExeRead("sd_billing, sd_billing_pmp", $where1, $clause1);
                    if($Read->getResult()):
                        foreach($Read->getResult() as $love):
                            extract($love);
                            $value = ($love['quantidade_pmp'] * $love['preco_pmp']);
                            $desconto = ($value * $love['desconto_pmp']) / 100;
                            $imposto  = ($value * $love['taxa']) / 100;
                            $total = ($value - $desconto) + $imposto;

                            $t_imposto += $imposto;
                            $t_desconto += $desconto;
                            $t_value += $value;
                            $t_sub += $total;
                            ?>
                            <tr>
                                <td><?= $love['InvoiceType'] ?></td>
                                <td><?= $love['numero'] ?></td>
                                <td><?php
                                    if($love['method'] == 'CC'):
                                        echo 'Cartão de Credito';
                                    elseif($love['method'] == 'CD'):
                                        echo 'Cartão de Debito';
                                    elseif($love['method'] == 'CH'):
                                        echo 'Cheque Bancário';
                                    elseif($love['method'] == 'NU'):
                                        echo 'Numerário';
                                    elseif ($love['method'] == 'TB'):
                                        echo 'Transferência Bancária';
                                    elseif($love['method'] == 'OU'):
                                        echo 'Outros Meios Aqui não Assinalados';
                                    endif; ?></td>
                                <td><?= $love['product_name'] ?></td>
                                <td><?= number_format($love['quantidade_pmp'], 2) ?></td>
                                <td><?= number_format($love['preco_pmp'], 2) ?></td>
                                <td><?= number_format($love['desconto_pmp'], 2) ?>%</td>
                                <td><?= number_format($love['taxa'], 2) ?>%</td>
                                <td><?= number_format($total, 2) ?></td>
                                <td><?= $love['dia']."-".$love['mes']."-".$love['ano'] ?></td>
                                <td><?= $love['customer_name'] ?></td>
                                <td><?= $love['username'] ?></td>
                            </tr>
                            <?php

                        endforeach;
                    endif;


                    if($SourceBilling == 'T'): $source2 = null; else: $source2 = " AND sd_retification.SourceBilling='{$SourceBilling}' "; endif;

                    if($Customers_id == "all"): $fCus = null; else: $fCus = " AND sd_retification.id_customer={$Customers_id}"; endif;

                    if($us['level'] >= 3):

                        if($Function_id == "all"): $nYf = null; else: $nYf = "AND sd_retification.session_id={$Function_id} AND sd_retification_pmp.session_id={$Function_id} "; endif;

                        if($TypeDoc == 'RT' || $TypeDoc == 'TM'): $lata2 = " AND sd_retification.InvoiceType!='PP' AND sd_retification_pmp.InvoiceType!='PP' "; elseif($TypeDoc == 'NC' || $TypeDoc == 'ND' || $TypeDoc == 'RE' || $TypeDoc == 'RG' || $TypeDoc == 'RC'):  $lata2 = " AND sd_retification.InvoiceType='{$TypeDoc}' AND sd_retification_pmp.InvoiceType='{$TypeDoc}' "; endif;

                        $where2 = " WHERE sd_retification.id_db_settings=:i AND sd_retification.status=:st {$lata2} {$source2} AND sd_retification.dia BETWEEN {$I[2]} AND {$F[2]} AND sd_retification.mes BETWEEN {$I[1]} AND {$F[1]} AND sd_retification.ano BETWEEN {$I[0]} AND {$F[0]} AND sd_retification_pmp.id_db_settings=:i AND sd_retification_pmp.numero=sd_retification.numero AND sd_retification_pmp.status=:st {$fCus} {$nYf}";
                        $clause2 = "i={$id_db_settings}&st={$ttt}";
                    else:
                        if($TypeDoc == 'RT' || $TypeDoc == 'TM'): $lata2 = " AND sd_retification.InvoiceType!='PP' AND sd_retification_pmp.InvoiceType!='PP' "; elseif($TypeDoc == 'NC' || $TypeDoc == 'ND' || $TypeDoc == 'RE' || $TypeDoc == 'RG' || $TypeDoc == 'RC'):  $lata2 = " AND sd_retification.InvoiceType='{$TypeDoc}' AND sd_retification_pmp.InvoiceType='{$TypeDoc}' "; endif;

                        $where2 = "WHERE sd_retification.id_db_settings=:i AND sd_retification.session_id=:ses AND sd_retification.status=:st {$lata2} {$source2} AND sd_retification.dia BETWEEN {$I[2]} AND {$F[2]} AND sd_retification.mes BETWEEN {$I[1]} AND {$F[1]} AND sd_retification.ano BETWEEN {$I[0]} AND {$F[0]} AND sd_retification_pmp.id_db_settings=:i AND sd_retification_pmp.numero=sd_retification.numero AND sd_retification_pmp.status=:st {$fCus}";
                        $clause2 = "i={$id_db_settings}&ses={$id_user}&st={$ttt}";
                    endif;

                    $Read->ExeRead("sd_retification, sd_retification_pmp", $where2, $clause2);
                    if($Read->getResult()):
                        foreach($Read->getResult() as $love):
                            extract($love);
                            $value = ($love['quantidade_pmp'] * $love['preco_pmp']);
                            $desconto = ($value * $love['desconto_pmp']) / 100;
                            $imposto  = ($value * $love['taxa']) / 100;
                            $total = ($value - $desconto) + $imposto;

                            $t_imposto += $imposto;
                            $t_desconto += $desconto;
                            $t_value += $value;
                            $t_sub += $total;
                            ?>
                            <tr>
                                <td><?= $love['InvoiceType'] ?></td>
                                <td><?= $love['numero'] ?></td>
                                <td><?php
                                    if($love['method'] == 'CC'):
                                        echo 'Cartão de Credito';
                                    elseif($love['method'] == 'CD'):
                                        echo 'Cartão de Debito';
                                    elseif($love['method'] == 'CH'):
                                        echo 'Cheque Bancário';
                                    elseif($love['method'] == 'NU'):
                                        echo 'Numerário';
                                    elseif ($love['method'] == 'TB'):
                                        echo 'Transferência Bancária';
                                    elseif($love['method'] == 'OU'):
                                        echo 'Outros Meios Aqui não Assinalados';
                                    endif; ?></td>
                                <td><?= $love['product_name'] ?></td>
                                <td><?= number_format($love['quantidade_pmp'], 2) ?></td>
                                <td><?= number_format($love['preco_pmp'], 2) ?></td>
                                <td><?= number_format($love['desconto_pmp'], 2) ?>%</td>
                                <td><?= number_format($love['taxa'], 2) ?>%</td>
                                <td><?= number_format($total, 2) ?></td>
                                <td><?= $love['dia']."-".$love['mes']."-".$love['ano'] ?></td>
                                <td><?= $love['customer_name'] ?></td>
                                <td><?= $love['username'] ?></td>
                            </tr>
                            <?php

                        endforeach;
                    endif;

                    $t_geral = ($t_sub - $t_desconto) + $t_imposto;
                endif;
                ?>
                </tbody>
                </table>

                <table class="table">
                    <thead>
                    <tr>
                        <th>Incidência</th>
                        <th>Desconto</th>
                        <th>Imposto</th>
                        <th>Total</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td><?= number_format($t_sub, 2); ?></td>
                        <td><?= number_format($t_desconto, 2); ?></td>
                        <td><?= number_format($t_imposto, 2); ?></td>
                        <td><?= number_format($t_geral, 2)." ".DBKwanzar::CheckConfig($id_db_settings)['moeda']; ?><input type="hidden" value="<?= $t_geral?>" id="totalGeral"></td>
                    </tr>
                    </tbody>
                </table>
                <?php
            endif;

            break;
        case 'SuspenseVenda':

            $POS = new POS();
            $POS->SuspenseVenda($id_db_settings, $id_user);
            if(!$POS->getResult()):
                WSError($POS->getError()[0], $POS->getError()[1]);
            else:
                //WSError($POS->getError()[0], $POS->getError()[1]);
                require_once("../../_requires/right-pos-settings.inc.php");
            endif;

            break;
        case 'AnularVenda':
            $POS = new POS();
            $POS->AnularVenda($id_db_settings, $id_user);

            if(!$POS->getResult()):
                WSError($POS->getError()[0], $POS->getError()[1]);
            else:
                //WSError($POS->getError()[0], $POS->getError()[1]);
                require_once("../../_requires/right-pos-settings.inc.php");
            endif;

            break;
        case 'Fac':
            ?>
            <table class="table" style="text-align: left!important;align-content: flex-start!important;align-items: flex-start!important;">
                <thead>
                <tr>
                    <th>Número</th>
                    <th>Nº do Documento</th>
                    <th>Cliente</th>
                    <th>Forma de Pagamento</th>
                    <th>Data</th>
                    <th>Documento</th>
                    <th style="width: 350px!important">-</th>
                    <th>ID</th>
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
                $Pager = new Pager('painel.php?exe=POS/invoice&page=');
                $Pager->ExePager($getPage, 20);

                $n1 = "sd_billing";
                $n3 = "sd_billing_pmp";
                $n2 = "sd_retification";
                $n4 = "sd_retification_pmp";
                $n5 = "sd_guid";
                $n6 = "sd_guid_pmp";
                $PPs = "'PP'";

                $read = new Read();
                $read->ExeRead("{$n1}", "WHERE ({$n1}.id_db_settings=:i AND {$n1}.InvoiceType!={$PPs} AND {$n1}.session_id=:id AND {$n1}.status=:st AND {$n1}.suspenso={$s}) ORDER BY {$n1}.TaxPointDate DESC LIMIT 20", "i={$id_db_settings}&id={$id_user}&st={$st}");
                if($read->getResult()):
                    foreach ($read->getResult() as $key):
                        include("../../_disk/AppData/ResultDocumentsInvoice.inc.php");
                    endforeach;
                endif;
                ?>
                </tbody>
            </table>
            <?php
            break;
        case 'Facs':
            ?>
            <table class="table" style="text-align: left!important;align-content: flex-start!important;align-items: flex-start!important;">
                <thead>
                <tr>
                    <th>Número</th>
                    <th>Cliente</th>
                    <th>Data</th>
                    <th>Documento</th>
                    <th style="width: 350px!important">-</th>
                    <th>ID</th>
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
                $Pager = new Pager('painel.php?exe=proforma/proforma&page=');
                $Pager->ExePager($getPage, 20);

                $n1 = "sd_billing";
                $n3 = "sd_billing_pmp";
                $PPs = "PP";

                $read = new Read();
                $read->ExeRead("{$n1}", "WHERE ({$n1}.id_db_settings=:i AND {$n1}.session_id=:id AND {$n1}.InvoiceType=:invoice AND {$n1}.status=:st AND {$n1}.suspenso={$s}) ORDER BY {$n1}.TaxPointDate DESC LIMIT 20", "i={$id_db_settings}&id={$id_user}&invoice={$PPs}&st={$st}");
                if($read->getResult()):
                    foreach ($read->getResult() as $key):
                        require("../../_disk/AppData/ResultDocumentsProformas.inc.php");
                    endforeach;
                endif;
                ?>
                </tbody>
            </table>
            <?php
            break;
        case 'Atualiza':
            require_once("../../_disk/Helps/table-product-pos-settings.inc.php");
            break;
        case 'FinalizarVenda':
            if(isset($_POST['pagou'])): $Data['pagou'] = (double) $_POST['pagou']; endif;
            if(isset($_POST['troco'])): $Data['troco'] = (double) $_POST['troco']; endif;

            if(isset($_POST['cartao_de_debito'])): $Data['cartao_de_debito'] = (double) $_POST['cartao_de_debito']; endif;
            if(isset($_POST['transferencia'])): $Data['transferencia'] = (double) $_POST['transferencia']; endif;
            if(isset($_POST['numerario'])): $Data['numerario'] = (double) $_POST['numerario']; endif;
            if(isset($_POST['all_total'])): $Data['all_total'] = (double) $_POST['all_total']; endif;

            if(isset($_POST['id_mesa'])): $id_mesa = $_POST['id_mesa']; else: $id_mesa = null; endif;

            $POS = new POS();
            $POS->Finish($id_db_settings, $id_user, $Data, $id_db_kwanzar, $page_found);
            $DB = new DBKwanzar();

            if(!$POS->getResult()):
                WSError($POS->getError()[0], $POS->getError()[1]);
            else:
                //WSError($POS->getError()[0], $POS->getError()[1]);
                require_once("../../_disk/Helps/right-pos-settings.inc.php");
            endif;

            break;
        case 'FinalizarVendaII':
            if(isset($_POST['pagou'])): $Data['pagou'] = (double) $_POST['pagou']; endif;
            if(isset($_POST['troco'])): $Data['troco'] = (double) $_POST['troco']; endif;
            if(isset($_POST['id_mesa'])): $id_mesa = $_POST['id_mesa']; else: $id_mesa = null; endif;

            $POS = new POS();
            $POS->Finish($id_db_settings, $id_user, $Data, $id_db_kwanzar, $page_found);
            $DB = new DBKwanzar();

            if(!$POS->getResult()):
                WSError($POS->getError()[0], $POS->getError()[1]);
            else:
                //WSError($POS->getError()[0], $POS->getError()[1]);
                require_once("../../_disk/Helps/right-proforma-settings.inc.php");
            endif;

            break;
        case 'CalcII':
            if(isset($_POST['cartao_de_debito'])): $cartao_de_debito = abs($_POST['cartao_de_debito']); else: $cartao_de_debito = null; endif;
            if(isset($_POST['transferencia'])): $transferencia = abs($_POST['transferencia']); else: $transferencia = null; endif;
            if(isset($_POST['numerario'])): $numerario = abs($_POST['numerario']); else: $numerario = null; endif;

            $total = (double) $_POST['total'];
            $all_total = $total - ($cartao_de_debito + $transferencia + $numerario);
            ?>
            <span>Valor em Falta</span>
            <input type="text" placeholder="Total" disabled class="form-control calcII" value="<?= str_replace(",", ".", number_format($all_total, 2, ',', '.'))." ".DBKwanzar::CheckConfig($id_db_settings)['moeda']; ?>">
            <input type="hidden" id="all_total" name="all_total" disabled class="form-control" value="<?= $total; ?>">
            <?php
            break;
        case 'Calc':
            $pagou = (double) $_POST['pagou'];
            $total = (double) $_POST['total'];

            $troco = (double) $pagou - $total;
            ?>
            <span>Troco</span>
            <input type="text" placeholder="Troco" disabled class="form-control calc" value="<?= str_replace(",", ".", number_format($troco, 2))." ".DBKwanzar::CheckConfig($id_db_settings)['moeda']; ?>">
            <input type="hidden" id="troco" disabled class="form-control" value="<?= $troco; ?>" placeholder="Troco">
            <?php
            break;
        case 'DadosDaFactura':
            if(isset($_POST['TaxPointDate'])):         $TaxPointDate         = strip_tags(($_POST['TaxPointDate'])); endif;
            if(isset($_POST['customer'])):             $customer             = strip_tags(($_POST['customer'])); endif;
            if(isset($_POST['InvoiceType'])):          $InvoiceType          = strip_tags(($_POST['InvoiceType'])); endif;
            if(isset($_POST['method'])):               $method               = strip_tags(($_POST['method'])); endif;
            if(isset($_POST['SourceBilling'])):        $SourceBilling        = strip_tags(($_POST['SourceBilling'])); endif;;
            if(isset($_POST['settings_desc_financ'])): $settings_desc_financ = strip_tags(($_POST['settings_desc_financ'])); endif;;
            if(isset($_POST['id_veiculos'])):               $id_veiculos               = strip_tags(($_POST['id_veiculos'])); endif;
            if(isset($_POST['matriculas'])):        $matriculas        = strip_tags(($_POST['matriculas'])); endif;
            if(isset($_POST['id_fabricante'])): $id_fabricante = strip_tags(($_POST['id_fabricante'])); endif;
            if(isset($_POST['referencia'])): $referencia = strip_tags(trim($_POST['referencia'])); endif;
            if(isset($_POST['id_obs'])): $id_obs = strip_tags(($_POST['id_obs'])); endif;

            $Data['method']               = $method;
            $Data['referencia']           = $referencia;
            $Data['TaxPointDate']         = $TaxPointDate;
            $Data['customer']             = $customer;
            $Data['InvoiceType']          = $InvoiceType;
            $Data['SourceBilling']        = $SourceBilling;
            $Data['settings_desc_financ'] = $settings_desc_financ;
            $Data['id_veiculos']          = $id_veiculos;
            $Data['matriculas']        = $matriculas;
            $Data['id_fabricante'] = $id_fabricante;
            $Data['id_obs'] = $id_obs;

            $POS = new POS();
            $POS->Fact($Data, $id_db_settings, $id_user, $page_found);
            $DB = new DBKwanzar();

            if(!$POS->getResult()):
                WSError($POS->getError()[0], $POS->getError()[1]);
            else:
                require_once("../../_disk/Helps/right-pos-settings.inc.php");
            endif;

            break;
        case 'DadosDaFactura01':
            if(isset($_POST['referencia'])): $referencia = strip_tags(trim($_POST['referencia'])); endif;
            if(isset($_POST['TaxPointDate'])):         $TaxPointDate         = strip_tags(($_POST['TaxPointDate'])); endif;
            if(isset($_POST['customer'])):             $customer             = strip_tags(($_POST['customer'])); endif;
            if(isset($_POST['InvoiceType'])):          $InvoiceType          = strip_tags(($_POST['InvoiceType'])); endif;
            if(isset($_POST['method'])):               $method               = strip_tags(($_POST['method'])); endif;
            if(isset($_POST['SourceBilling'])):        $SourceBilling        = strip_tags(($_POST['SourceBilling'])); endif;;
            if(isset($_POST['settings_desc_financ'])): $settings_desc_financ = strip_tags(($_POST['settings_desc_financ'])); endif;
            if(isset($_POST['id_veiculos'])):               $id_veiculos               = strip_tags(($_POST['id_veiculos'])); endif;
            if(isset($_POST['matriculas'])):        $matriculas        = strip_tags(($_POST['matriculas'])); endif;
            if(isset($_POST['id_fabricante'])): $id_fabricante = strip_tags(($_POST['id_fabricante'])); endif;
            if(isset($_POST['id_obs'])): $id_obs = strip_tags(($_POST['id_obs'])); endif;

            $Data['method']               = $method;
            $Data['referencia']           = $referencia;
            $Data['TaxPointDate']         = $TaxPointDate;
            $Data['customer']             = $customer;
            $Data['InvoiceType']          = $InvoiceType;
            $Data['SourceBilling']        = $SourceBilling;
            $Data['settings_desc_financ'] = $settings_desc_financ;
            $Data['id_veiculos']          = $id_veiculos;
            $Data['matriculas']        = $matriculas;
            $Data['id_fabricante'] = $id_fabricante;
            $Data['id_obs'] = $id_obs;

            $POS = new POS();
            $POS->Fact($Data, $id_db_settings, $id_user, $page_found);
            $DB = new DBKwanzar();

            if(!$POS->getResult()):
                WSError($POS->getError()[0], $POS->getError()[1]);
            else:
                require_once("../../_disk/Helps/right-proforma-settings.inc.php");
            endif;

            break;
        case 'RemovePS':
            $id_product = strip_tags(($_POST['id_product']));

            $POS = new POS();
            $POS->RemovePS($id_product, $id_db_settings, $id_user);

            if($POS->getResult()):
                require_once("../../_disk/Helps/table-product-pos-settings.inc.php");
            else:
                WSError($POS->getError()[0], $POS->getError()[1]);
            endif;

            break;
        case 'Add':
            $page_found = strip_tags(($_POST['page_found']));
            $Data['page_found'] = strip_tags(($_POST['page_found']));
            $Data['id_product'] = strip_tags(($_POST['id_product']));
            $Data['quantidade'] = strip_tags(($_POST['quantidade']));
            $Data['preco'] = strip_tags(($_POST['preco']));
            $Data['taxa'] = strip_tags(($_POST['taxa']));
            $Data['desconto'] = strip_tags(($_POST['desconto']));
            $Data['product_codigo_barras'] = strip_tags(($_POST['codigo_barras']));
            if(isset($_POST['id_mesa'])): $id_mesa = (int) $_POST['id_mesa']; else: $id_mesa = null; endif;

            $POS = new POS();
            $POS->Add($Data, $id_db_settings, $userlogin['id'], $id_mesa);

            if($POS->getResult()):
                require_once("../../_disk/Helps/table-product-pos-settings.inc.php");
            else:
                WSError($POS->getError()[0], $POS->getError()[1]);
            endif;

            break;
        case 'SearchProduct':
            $NnM = 0;
            $searching = strip_tags(($_POST['SearchProduct']));
            $SearchProduct01 = strip_tags(($_POST['SearchProduct01']));
            $a = 1;

            $read = new Read();
            $read->FullRead("SELECT *
FROM cv_product
LEFT JOIN cv_category ON cv_category.id_db_settings = cv_product.id_db_settings
                       AND cv_category.id_xxx = cv_product.id_category
WHERE 
    cv_product.id_db_settings ={$id_db_settings}
    AND (
        cv_product.product LIKE '%' '{$searching}' '%'
        AND cv_product.codigo LIKE '%' '{$SearchProduct01}' '%'
    )
    OR(
        cv_product.codigo LIKE '%' '{$searching}' '%'
        AND cv_product.product LIKE '%' '{$SearchProduct01}' '%'
    )OR(
        cv_product.product LIKE '%' '{$searching}' '%'
        AND cv_product.product LIKE '%' '{$SearchProduct01}' '%'
    )
    OR(
        cv_product.codigo_barras LIKE '%' '{$searching}' '%'
        AND cv_product.codigo LIKE '%' '{$SearchProduct01}' '%'
    )
    OR (
        cv_product.codigo LIKE '%' '{$searching}' '%'
        AND cv_product.codigo_barras LIKE '%' '{$SearchProduct01}' '%'
    )
    OR(
        cv_product.product LIKE '%' '{$searching}' '%'
        AND cv_product.remarks LIKE '%' '{$SearchProduct01}' '%'
    )
    OR(
        cv_product.remarks LIKE '%' '{$searching}' '%'
        AND cv_product.local_product LIKE '%' '{$SearchProduct01}' '%'
    )
    OR(
        cv_product.local_product LIKE '%' '{$searching}' '%'
        AND cv_product.remarks LIKE '%' '{$SearchProduct01}' '%'
    )
    OR (
        cv_product.product LIKE '%' '{$searching}' '%'
        AND cv_product.codigo LIKE '%' '{$SearchProduct01}' '%'
    )
    OR(
        cv_category.category_title LIKE '%' '{$searching}' '%'
        AND cv_product.product LIKE '%' '{$SearchProduct01}' '%'
        AND cv_product.id_category = cv_category.id_xxx
    )
    OR (
        cv_product.product LIKE '%' '{$searching}' '%'
        AND cv_category.category_title LIKE '%' '{$SearchProduct01}' '%'
        AND cv_product.id_category = cv_category.id_xxx
    )
    OR (
        cv_category.category_title LIKE '%' '{$searching}' '%'
        AND cv_product.codigo LIKE '%' '{$SearchProduct01}' '%'
        AND cv_product.id_category = cv_category.id_xxx
    )
    OR (
        cv_product.codigo LIKE '%' '{$searching}' '%'
        AND cv_category.category_title LIKE '%' '{$SearchProduct01}' '%'
        AND cv_product.id_category = cv_category.id_xxx
    )
    OR (
        cv_category.category_title LIKE '%' '{$searching}' '%'
        AND cv_product.codigo_barras LIKE '%' '{$SearchProduct01}' '%'
        AND cv_product.id_category = cv_category.id_xxx
    )
    OR (
        cv_product.codigo_barras LIKE '%' '{$searching}' '%'
        AND cv_category.category_title LIKE '%' '{$SearchProduct01}' '%'
        AND cv_product.id_category = cv_category.id_xxx
    )
    OR (
        cv_category.category_title LIKE '%' '{$searching}' '%'
        AND cv_product.remarks LIKE '%' '{$SearchProduct01}' '%'
        AND cv_product.id_category = cv_category.id_xxx
    )
    OR (
        cv_product.remarks LIKE '%' '{$searching}' '%'
        AND cv_category.category_title LIKE '%' '{$SearchProduct01}' '%'
        AND cv_product.id_category = cv_category.id_xxx
    )
    OR (
        cv_category.category_title LIKE '%' '{$searching}' '%'
        AND cv_product.local_product LIKE '%' '{$SearchProduct01}' '%'
        AND cv_product.id_category = cv_category.id_xxx
    )
    OR (
        cv_product.local_product LIKE '%' '{$searching}' '%'
        AND cv_category.category_title LIKE '%' '{$SearchProduct01}' '%'
        AND cv_product.id_category = cv_category.id_xxx
    )
ORDER BY cv_product.product ASC
LIMIT 50");
            if($read->getResult()):
                foreach($read->getResult() as $key):
                    if($key['ILoja'] == 2 || $key['ILoja'] == null || $key['ILoja'] == '' || $key['ILoja'] != 1):

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
                        if($DB->CheckCpanelAndSettings($id_db_settings)['atividade'] == 1 || $DB->CheckCpanelAndSettings($id_db_settings)['atividade'] == 4):
                            $NnM = $key['quantidade'];
                        else:
                            $NnM = $key['gQtd'];
                        endif;

                        if($key['desconto'] < 0 || $key['desconto'] == null || !isset($key['desconto'])): $Emanuel = 0; else: $Emanuel = $key['desconto']; endif;


                        if(!isset(DBKwanzar::CheckConfig($id_db_settings)['estoque_minimo']) || empty(DBKwanzar::CheckConfig($id_db_settings)['estoque_minimo'])):
                            $alertY = " bg-secondary ";
                        elseif($key['quantidade'] <= DBKwanzar::CheckConfig($id_db_settings)['estoque_minimo']):
                            $alertY = " bg-danger ";
                        elseif($key['quantidade'] <= 5):
                            $alertY = " bg-warning ";
                        else:
                            $alertY = "bg-success";
                        endif;
                        ?>
                        <tr>
                            <td style="max-width: 10%!important;font-size: 10pt!important;"><span class="badge <?= $alertY; ?> me-1"></span></td>
                            <td style="max-width: 30%!important;font-size: 10pt!important;"><?=  $key['codigo']; ?></td>
                            <td style="max-width: 30%!important;font-size: 10pt!important;"><?=  $key['product']; ?></td>
                            <td style="max-width: 30%!important;font-size: 10pt!important;">
                                <input type="hidden" id="codigo_barras_<?= $key['id']; ?>" disabled value="<?= $key['codigo_barras']; ?>"><?=  $key['codigo_barras']; ?>
                            </td>
                            <td style="max-width: 10%!important;"><input style="width: 100%!important;" <?php if($level < 3): ?> disabled <?php endif; ?> type="number" id="desconto_<?= $key['id']; ?>" class="form-kwanzar" min="0" max="100000000000000000000000" value="<?= $Emanuel; ?>" placeholder="Desconto"></td>
                            <td style="max-width: 10%!important;"><input style="width: 100%!important;" type="hidden" id="taxa_<?= $key['id']; ?>" class="form-kwanzar" disabled value="<?= $key['id_iva']; ?>" placeholder="Taxa de imposto"><?= $key['iva']; ?></td>
                            <td style="max-width: 10%!important;"><input style="width: 100%!important;" type="text" class="form-kwanzar" id="preco_<?= $key['id']; ?>" disabled value="<?= $preco; ?>"></td>
                            <td style="max-width: 20%!important;"><input style="width: 100%!important;" type="number" class="form-kwanzar" id="quantidade_<?= $key['id']; ?>" min="1" value="1"><br/><center>Exis.: <span><?= $NnM; ?></span></center></td>
                            <td style="max-width: 1%!important;"><input type="hidden" value="<?= $userlogin['id']; ?>" id="session_id_<?= $key['id']; ?>"></td>
                            <td style="max-width: 1%!important;"><input type="hidden" value="<?= $id_db_settings; ?>" id="id_db_settings_<?= $key['id']; ?>"></td>
                            <td style="max-width: 10%!important;">
                                <span><?= $key['local_product']; ?></span>
                            </td>
                            <td style="max-width: 10%!important;">
                                <span><?= $key['remarks']; ?></span>
                            </td>
                            <td style="max-width: 15%!important;"><a href="javascript:void()" onclick="adicionar(<?= $key['id']; ?>)" class="btn btn-default btn-sm"><svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" /><line x1="12" y1="11" x2="12" y2="17" /><line x1="9" y1="14" x2="15" y2="14" /></svg></a></td>
                        </tr>
                        <?php
                    endif;
                endforeach;
            else:
                WSError("Ops: não encontramos nenhum produto disponível!", WS_INFOR);
            endif;

            break;
        case 'SearchChanges':
            $searching = strip_tags(($_POST['searching']));

            $read = new Read();
            $read->ExeRead("cv_product", "WHERE (id_db_settings=:i AND product LIKE '%' :link '%') OR (id_db_settings=:i AND codigo LIKE '%' :link '%') OR (id_db_settings=:i AND codigo_barras LIKE '%' :link '%') ", "i={$id_db_settings}&link={$searching}");

            if($read->getResult()):
                foreach($read->getResult() as $key):
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
                    if($DB->CheckCpanelAndSettings($id_db_settings)['atividade'] != 1):
                        $NnM = $key['unidades'];
                    else:
                        $NnM = $key['quantidade'];
                    endif;
                    ?>
                    <tr>
                        <td><?= $key['codigo']; ?></td>
                        <td title="<?= $key['product']; ?>"><?= $key['product']; ?></td>
                        <td><?= number_format($preco, 2); ?></td>
                        <td><?= number_format($NnM, 2); ?></td>
                        <?php
                        $s = 1;
                        $read = new Read();
                        $read->ExeRead("sd_purchase", "WHERE id_db_settings=:id AND id_product=:ipp AND status=:s ORDER BY id  DESC", "id={$id_db_settings}&ipp={$key['id']}&s={$s}");
                        if($read->getResult()):
                            foreach ($read->getResult() as $info):
                                //extract($info);
                                ?>
                                <td><?= number_format($info['quantidade'], 2); ?>&nbsp;
                                <?php
                            endforeach;
                        else:
                            ?><td><?= number_format(0, 2); ?></td><?php
                        endif;
                        ?>
                    </tr>
                    <?php
                endforeach;
            else:
                WSError("Ops: não encontramos nenhum produto disponível!", WS_INFOR);
            endif;

            break;
        case 'searchProductAlerts':
            $searching = strip_tags(($_POST['searching']));

            $ipp = "P";

            $read = new Read();
            $read->ExeRead("cv_product", "WHERE (id_db_settings=:i AND product LIKE '%' :link '%'  AND type=:ipp) OR (id_db_settings=:i AND codigo LIKE '%' :link '%'  AND type=:ipp) OR (id_db_settings=:i AND codigo_barras LIKE '%' :link '%'  AND type=:ipp) ", "i={$id_db_settings}&link={$searching}&ipp={$ipp}");

            if($read->getResult()):
                foreach($read->getResult() as $key):
                    $DB = new DBKwanzar();
                    if($DB->CheckCpanelAndSettings($id_db_settings)['atividade'] != 1):
                        $NnM = $key['unidades'];
                    else:
                        $NnM = $key['quantidade'];
                    endif;

                    ?>
                    <tr>
                        <td><?= $key['id']; ?></td>
                        <td><?= $key['codigo']; ?></td>
                        <td><?= $key['product']; ?></td>
                        <td><?= number_format($NnM, 2); ?></td>
                        <td><input min="1" value="1" type="number" name="qtdOne" id="qtdOne_<?= $key['id']; ?>" class="form-kwanzar" placeholder="Qtd"/></td>
                        <td><a href="javascript:void()" onclick="Distancia(<?= $key['id']; ?>)" class="bol bol-default bol-sm"><i class="far fa-paper-plane"></i></a></td>
                    </tr>
                    <?php
                endforeach;
            else:
                WSError("Ops: não encontramos nenhum produto disponível!", WS_INFOR);
            endif;

            break;
        case 'searchProductInfo':
            $searching = strip_tags(($_POST['searching']));

            $read = new Read();
            $read->ExeRead("cv_product", "WHERE (id_db_settings=:i AND product LIKE '%' :link '%') OR (id_db_settings=:i AND codigo LIKE '%' :link '%') OR (id_db_settings=:i AND codigo_barras LIKE '%' :link '%') ", "i={$id_db_settings}&link={$searching}");

            if($read->getResult()):
                foreach($read->getResult() as $key):
                    $st = 1;

                    $Read = new Read();
                    $Read->ExeRead("cv_pedido_product", "WHERE id_db_settings=:i AND id_product=:ipp AND status=:ip ORDER BY qtdOne DESC", "i={$id_db_settings}&ipp={$key['id']}&ip={$st}");

                    if($Read->getResult()):
                        $DB = new DBKwanzar();
                        if($DB->CheckCpanelAndSettings($id_db_settings)['atividade'] != 1):
                            $NnM = $key['unidades'];
                        else:
                            $NnM = $key['quantidade'];
                        endif;

                        ?>
                        <tr>
                            <td><?= $key['id'];  ?></td>
                            <td><?= $key['product'];  ?></td>
                            <td><?= number_format($NnM, 2);  ?></td>
                            <td><?= number_format($Read->getResult()[0]['qtdOne'], 2);  ?></td>
                            <?php
                            $s = 1;
                            $read = new Read();
                            $read->ExeRead("sd_purchase", "WHERE id_db_settings=:id AND id_product=:ipp AND status=:s ORDER BY id  DESC", "id={$id_db_settings}&ipp={$key['id']}&s={$s}");
                            if($read->getResult()):
                                foreach ($read->getResult() as $info):
                                    //extract($info);
                                    ?>
                                    <td><?= number_format($info['quantidade'], 2); ?>
                                    <td>
                                        <input type="hidden" name="unidade" id="unidade" class="unidade" value="<?= $info['unidade']; ?>"/>
                                        <input type="number" value="<?= $Read->getResult()[0]['qtdOne']; ?>" min="1" class="form-control" placeholder="QTD" name="qtdOne_<?= $info['id']; ?>" id="qtdOne_<?= $info['id']; ?>"/>
                                    </td>
                                    <td><a href="javascript:void()" onclick="ForPurchase(<?= $info['id']; ?>)" class="btn btn-sm btn-primary"><i class="far fa-paper-plane"></i></a></td>
                                    <?php
                                endforeach;
                            else:
                                ?><td><?= number_format(0, 2); ?></td><?php
                            endif;
                            ?>
                        </tr>
                        <?php
                    endif;
                endforeach;
            else:
                WSError("Ops: não encontramos nenhum produto disponível!", WS_INFOR);
            endif;

            break;
        case 'loadingPOS':
            $NnM = 0;
            $a = 1;
            $read = new Read();
            $read->ExeRead("cv_product", "WHERE id_db_settings=:i AND ILoja!=:ss ORDER BY product ASC LIMIT 50", "i={$id_db_settings}&ss={$a}");

            if($read->getResult()):
                foreach($read->getResult() as $key):
                    if($key['ILoja'] == 2 || $key['ILoja'] == null || $key['ILoja'] == '' || $key['ILoja'] != 1):

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
                        /**if($DB->CheckCpanelAndSettings($id_db_settings)['atividade'] == 1 || $DB->CheckCpanelAndSettings($id_db_settings)['atividade'] == 4):
                            $NnM = $key['quantidade'];
                        else:
                            $NnM = $key['gQtd'];
                        endif;**/

                        $NnM = $key['quantidade'];

                        if($key['desconto'] < 0 || $key['desconto'] == null || !isset($key['desconto'])): $Emanuel = 0; else: $Emanuel = $key['desconto']; endif;

                        if(!isset(DBKwanzar::CheckConfig($id_db_settings)['estoque_minimo']) || empty(DBKwanzar::CheckConfig($id_db_settings)['estoque_minimo'])):
                            $alertY = " bg-secondary ";
                        elseif($key['quantidade'] <= DBKwanzar::CheckConfig($id_db_settings)['estoque_minimo']):
                            $alertY = " bg-danger ";
                        elseif($key['quantidade'] <= 5):
                            $alertY = " bg-warning ";
                        else:
                            $alertY = "bg-success";
                        endif;
                        ?>
                        <tr>
                            <td style="max-width: 10%!important;font-size: 10pt!important;"><span class="badge <?= $alertY; ?> me-1"></span></td>
                            <td style="max-width: 30%!important;font-size: 10pt!important;"><?=  $key['codigo']; ?></td>
                            <td style="max-width: 30%!important;font-size: 10pt!important;"><?=  $key['product']; ?></td>
                            <td style="max-width: 30%!important;font-size: 10pt!important;">
                                <input type="hidden" id="codigo_barras_<?= $key['id']; ?>" disabled value="<?= $key['codigo_barras']; ?>"><?=  $key['codigo_barras']; ?>
                            </td>
                            <td style="max-width: 10%!important;">
                                <input style="width: 100%!important;" type="number" id="desconto_<?= $key['id']; ?>" class="form-kwanzar" min="0" max="100000000000000000000000" value="<?= $Emanuel; ?>" placeholder="Desconto">
                            </td>
                            <td style="max-width: 10%!important;">
                                <input style="width: 100%!important;" type="hidden" id="taxa_<?= $key['id']; ?>" class="form-kwanzar" disabled value="<?= $key['id_iva']; ?>" placeholder="Taxa de imposto"><?= $key['iva']; ?>
                            </td>
                            <td style="max-width: 20%!important;">
                                <input style="width: 100%!important;" type="text" class="form-kwanzar" id="preco_<?= $key['id']; ?>" disabled value="<?= $preco; ?>">
                            </td>
                            <td style="max-width: 10%!important;">
                                <input style="width: 100%!important;" type="number" class="form-kwanzar" id="quantidade_<?= $key['id']; ?>" min="1" value="1"><br/>
                                <center>Exis.: <span style="font-size: 11pt!important;"><?= $NnM; ?></span></center>
                            </td>
                            <td style="max-width: 1%!important;">
                                <input type="hidden" value="<?= $userlogin['id']; ?>" id="session_id_<?= $key['id']; ?>">
                            </td>
                            <td style="max-width: 1%!important;">
                                <input type="hidden" value="<?= $id_db_settings; ?>" id="id_db_settings_<?= $key['id']; ?>">
                            </td>
                            <td style="max-width: 10%!important;">
                                <span><?= $key['local_product']; ?></span>
                            </td>
                            <td style="max-width: 10%!important;">
                                <span><?= $key['remarks']; ?></span>
                            </td>
                            <td style="max-width: 15%!important;">
                                <a href="javascript:void()" onclick="adicionar(<?= $key['id']; ?>)" class="btn btn-default btn-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" /><line x1="12" y1="11" x2="12" y2="17" /><line x1="9" y1="14" x2="15" y2="14" /></svg>
                                </a>
                            </td>
                        </tr>
                        <?php
                    endif;
                endforeach;
            endif;
            break;
        default:
            WSError("Ops: não encontramos a ação desejada!", WS_INFOR);
    endswitch;
endif;
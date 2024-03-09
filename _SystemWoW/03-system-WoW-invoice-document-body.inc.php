<?php
/**
 * Created by PhpStorm.
 * User: Kwanzar Soft
 * Date: 04/06/2020
 * Time: 22:30
 */

if(empty($dateI) || empty($dateF)):
    WSError("Ops: selecione a data do documento!", WS_INFOR);
else:
    ?>
    <div class="heliospro">
        <title>RELATÓRIO DE VENDAS DE <?= $dateI." À ".$dateF; ?></title>
        <div id="xuxu">
            <h1 class="header-one pussy">RELATÓRIO DE VENDAS DE <?= $dateI." À ".$dateF; ?></h1>
        </div>

        <table>
            <thead>
            <tr>
                <th>Data de emissão</th>
                <th>Hora de emissão</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td><?= date('d-m-Y'); ?></td>
                <td><?= date('H:i:s'); ?></td>
            </tr>
            </tbody>
        </table>
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
                $where = "WHERE sd_billing.id_db_settings=:i AND sd_billing.session_id=:ses AND sd_billing.status=:st AND sd_billing.suspenso=:s {$lata} {$source} AND sd_billing.dia BETWEEN {$I[2]} AND {$F[2]} AND sd_billing.mes BETWEEN {$I[1]} AND {$F[1]} AND sd_billing.ano BETWEEN {$I[0]} AND {$F[0]} AND sd_billing_pmp.id_db_settings=:i AND sd_billing.numero=sd_billing_pmp.numero AND sd_billing_pmp.status=:st {$fCus}";
                $clause = "i={$id_db_settings}&ses={$id_user}&st={$ttt}&s={$suspenso}";
            endif;

            $Read->ExeRead("sd_billing, sd_billing_pmp", $where, $clause);
            if($Read->getResult()):
                foreach($Read->getResult() as $love):
                    extract($love);
                    $value = ($love['quantidade_pmp'] * $love['preco_pmp']);

                    if($love['desconto_pmp'] >= 100):
                        $desconto = $love['desconto_pmp'];
                    else:
                        $desconto = ($value * $love['desconto_pmp']) / 100;
                    endif;

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

                if($TypeDoc == 'RT' || $TypeDoc == 'TM'): $lata = " AND sd_retification.InvoiceType!='PP' AND sd_retification_pmp.InvoiceType!='PP' "; elseif($TypeDoc == 'NC' || $TypeDoc == 'ND' || $TypeDoc == 'RE' ||  $TypeDoc == 'RC' || $TypeDoc == "RG"):  $lata = " AND sd_retification.InvoiceType='{$TypeDoc}' AND sd_retification_pmp.InvoiceType='{$TypeDoc}' "; endif;

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

                if($TypeDoc == 'RT' || $TypeDoc == 'TM'): $lata2 = " AND sd_retification.InvoiceType!='PP' AND sd_retification_pmp.InvoiceType!='PP' "; elseif($TypeDoc == 'NC' || $TypeDoc == 'ND' || $TypeDoc == 'RE' || $TypeDoc == 'RC' || $TypeDoc == "RG"):  $lata2 = " AND sd_retification.InvoiceType='{$TypeDoc}' AND sd_retification_pmp.InvoiceType='{$TypeDoc}' "; endif;

                $where2 = " WHERE sd_retification.id_db_settings=:i AND sd_retification.status=:st {$lata2} {$source2} AND sd_retification.dia BETWEEN {$I[2]} AND {$F[2]} AND sd_retification.mes BETWEEN {$I[1]} AND {$F[1]} AND sd_retification.ano BETWEEN {$I[0]} AND {$F[0]} AND sd_retification_pmp.id_db_settings=:i AND sd_retification_pmp.numero=sd_retification.numero AND sd_retification_pmp.status=:st {$fCus} {$nYf}";
                $clause2 = "i={$id_db_settings}&st={$ttt}";
            else:
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
            <th>Insidência</th>
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

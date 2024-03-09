<?php
$suspenso = 0;
require_once("../../Config.inc.php");

$id_db_settings= strip_tags(trim($_POST['id_db_settings']));
$id_user       = strip_tags(trim($_POST['id_user']));
$TypeDoc       = strip_tags(trim($_POST['TypeDoc']));
$Itens_id      = strip_tags(trim($_POST['Itens_id']));
$Categories_id = strip_tags(trim($_POST['Categories_id']));
$Function_id   = strip_tags(trim($_POST['Function_id']));
$Customers_id  = strip_tags(trim($_POST['Customers_id']));
$dateI         = strip_tags(trim($_POST['dateI']));
$dateF         = strip_tags(trim($_POST['dateF']));
$method_id     = strip_tags(trim($_POST['method_id']));
$Itens_type    = strip_tags(trim($_POST['Itens_type']));

if(empty($dateI)): $dateI = date("Y-m-d"); endif;
if(empty($dateF)): $dateF = date('Y-m-d'); endif;
?>

<div class="styles">
    <a href="print.php?action=1998&dateI=<?= $dateI; ?>&dateF=<?= $dateF; ?>&id_user=<?= $id_user ?>&id_db_settings=<?= $id_db_settings; ?>&Itens_id=<?= $Itens_id; ?>&TypeDoc=<?= $TypeDoc; ?>&Function_id=<?= $Function_id; ?>&Customers_id=<?= $Customers_id ?>&Categories_id=<?= $Categories_id ?>&method_id=<?= $method_id; ?>&Itens_type=<?= $Itens_type; ?>" class="bol bol-default bol-sm btn btn-primary" target="_blank">Imprimir</a>
</div><br/>

<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>DATA & HORA</th>
                        <th>DOCUMENTO</th>
                        <th>REFERENCIA</th>
                        <th>PAGAMENTO</th>
                        <th>CLIENTE</th>
                        <th>CATEGORIA</th>
                        <th>CODIGO</th>
                        <th>CODIGO BARRAS</th>
                        <th>ITEM</th>
                        <th>QTD</th>
                        <th>PREÇO</th>
                        <th>DESC%</th>
                        <th>TAXA%</th>
                        <th>TOTAL</th>
                        <th>OPERADOR</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $Array01 = [];
                $Array02 = [];
                $Array03 = [];
                $Array04 = [];
                $Array05 = [];
                $Array06 = [];

                $t_cona = 0;
                $t_imposto_x = 0;
                $t_desconto_x = 0;
                $t_insidencia_x = 0;

                $t_r_geral_x = 0;
                $t_r_imposto_x = 0;
                $t_r_desconto_x = 0;
                $t_r_insidencia_x = 0;

                $t_cartao_de_debito_x = 0;
                $t_transferencia_x = 0;
                $t_numerario_x = 0;

                $t_conta_x_x_x = 0;

                if(DBKwanzar::CheckConfig($id_db_settings)['JanuarioSakalumbu'] == null): $ttt = 2; else: $ttt = DBKwanzar::CheckConfig($id_db_settings)['JanuarioSakalumbu']; endif;

                if($TypeDoc == "CO" || $TypeDoc == "TM" || $TypeDoc == "FR" || $TypeDoc == "FT"):
                    if(isset($dateI) && isset($dateF) && !empty($dateI) && !empty($dateF)):
                        $f    = explode("-", $dateF);
                        $i    = explode("-", $dateI);
                        $date = " AND sd_billing.dia BETWEEN {$i[2]} AND {$f[2]} AND sd_billing.mes BETWEEN {$i[1]} AND {$f[1]} AND sd_billing.ano BETWEEN {$i[0]} AND {$f[0]} ";
                    else:
                        $date = null;
                    endif;

                    if($Categories_id == "all"):   $categorias   = null; else: $categorias   = " AND sd_billing_pmp.product_id_category={$Categories_id} "; endif;
                    if($Itens_id      == "all"):   $produtos     = null; else: $produtos     = " AND sd_billing_pmp.id_product={$Itens_id} "; endif;
                    if($Customers_id  == "all"):   $clientes     = null; else: $clientes     = " AND sd_billing.id_customer={$Customers_id} "; endif;
                    if($Function_id   == "all"):   $funcionarios = null; else: $funcionarios = " AND sd_billing.session_id={$Function_id} "; endif;

                    if($method_id == "all"):
                        $method = null;
                        $v = null;
                    else:
                        $method  = " AND sd_billing.method=:m ";
                        $v = "&m=".$method_id;
                    endif;

                    if($Itens_type == "all"):
                        $type = null;
                        $g = null;
                    else:
                        $type  = " AND sd_billing_pmp.product_type=:g ";
                        $g = "&g=".$Itens_type;
                    endif;

                    if($TypeDoc == "CO" || $TypeDoc == "TM"):
                        $a = "PP";
                        $documentos = " AND sd_billing.InvoiceType!=:a AND sd_billing_pmp.InvoiceType=sd_billing.InvoiceType ";
                    else:
                        $a = $TypeDoc;
                        $documentos = " AND sd_billing.InvoiceType=:a  AND sd_billing_pmp.InvoiceType=sd_billing.InvoiceType ";
                    endif;

                    $Action = "{$v}&a={$a}&st={$ttt}&s={$suspenso}&{$g}";
                    $Where  = "WHERE sd_billing.id_db_settings={$id_db_settings} AND sd_billing_pmp.id_db_settings=sd_billing.id_db_settings {$clientes} {$funcionarios} {$method} {$documentos} AND sd_billing.status=:st AND sd_billing.suspenso=:s  {$date} {$produtos} {$categorias} {$type} AND sd_billing.numero=sd_billing_pmp.numero ORDER BY sd_billing.numero DESC ";

                    $Read = new Read();
                    $Read->ExeRead("sd_billing, sd_billing_pmp", $Where, $Action);

                    if($Read->getResult()):
                        foreach ($Read->getResult() as $key):
                            $value = ($key['quantidade_pmp'] * $key['preco_pmp']);
                            $t_insidencia_x += $value;

                            $taxa = ($value * $key['taxa']) / 100;
                            if($key['desconto_pmp'] >= 100):
                                $desconto = $key['desconto_pmp'];
                            else:
                                $desconto = ($value * $key['desconto_pmp']) / 100;
                            endif;

                            $total  = ($value - $desconto) + $taxa;


                            if($key['method'] == "ALL" && !in_array($key['numero'], $Array01)):
                                $t_numerario_x += $key['numerario'];
                                $t_cartao_de_debito_x += $key['cartao_de_debito'];
                                $t_transferencia_x += $key['transferencia'];

                                array_push($Array01, $key['numero']);
                            elseif($key['method'] == "NU"):
                                $t_numerario_x += $total;
                            elseif($key['method'] == "TB"):
                                $t_transferencia_x += $total;
                            elseif($key['method'] == "CD"):
                                $t_cartao_de_debito_x += $total;
                            endif;


                            $t_cona += $total;

                            $t_desconto_x += $desconto;
                            $t_imposto_x += $taxa;
                            ?>
                            <tr>
                                <td><?= $key['dia']."/".$key['mes']."/".$key['ano']." ".$key['hora']; ?></td>
                                <td><?= $key['InvoiceType']; ?></td>
                                <td><?php if($key['InvoiceType'] == 'PP'): echo "Factura Pró-forma "; elseif($key['InvoiceType'] == 'FT'): echo 'Factura '; else: echo 'Factura/Recibo '; endif; ?> <?= $key['InvoiceType']." ".$key['mes'].$key['Code'].$key['ano']."/".$key['numero']; ?></td>
                                <td><?php if($key['method'] == 'CC'): echo 'Cartão de Credito'; elseif($key['method'] == 'MB'): echo 'Referência de pagamentos para Multicaixa'; elseif($key['method'] == 'CD'): echo 'Cartão de Debito'; elseif($key['method'] == 'CH'): echo 'Cheque Bancário'; elseif($key['method'] == 'NU'): echo 'Numerário'; elseif ($key['method'] == 'TB'): echo 'Transferência Bancária'; elseif($key['method'] == 'OU'): echo 'Outros Meios Aqui não Assinalados'; elseif($key['method'] == 'ALL'): echo 'Diversificado'; endif; ?></td>
                                <td><?php $Read->ExeRead("cv_customer", "WHERE id=:i", "i={$key['id_customer']}"); if($Read->getResult()): echo $Read->getResult()[0]['nome']; endif; ?></td>
                                <td><?php $Read->ExeRead("cv_category", "WHERE id_xxx=:i", "i={$key['product_id_category']}"); if($Read->getResult()): echo $Read->getResult()[0]['category_title']; endif; ?></td>
                                <td><?= $key['product_code']; ?></td>
                                <td><?= $key['product_codigo_barras']; ?></td>
                                <td><?= $key['product_name']; ?></td>

                                <td><?= $key['quantidade_pmp']; ?></td>
                                <td><?= number_format($key['preco_pmp'], 2, ",", "."); ?></td>
                                <td><?= number_format($desconto, 2, ",", "."); ?></td>
                                <td><?= number_format($taxa, 2, ",", "."); ?></td>
                                <td><?= number_format($total, 2, ",", "."); ?></td>

                                <td><?php $Read->ExeRead("db_users", "WHERE id=:i", "i={$key['session_id']}"); if($Read->getResult()): echo $Read->getResult()[0]['name']; endif; ?></td>
                            </tr>
                            <?php
                        endforeach;
                    endif;

                    if($TypeDoc != "TM" && $TypeDoc != "FT"):
                        if(isset($dateI) && isset($dateF) && !empty($dateI) && !empty($dateF)):
                            $f    = explode("-", $dateF);
                            $i    = explode("-", $dateI);
                            $date = " AND sd_retification.dia BETWEEN {$i[2]} AND {$f[2]} AND sd_retification.mes BETWEEN {$i[1]} AND {$f[1]} AND sd_retification.ano BETWEEN {$i[0]} AND {$f[0]} ";
                        else:
                            $date = null;
                        endif;

                        if($Function_id   == "all"):   $funcionarios = null; else: $funcionarios = " AND sd_retification.session_id={$Function_id} "; endif;
                        if($Categories_id == "all"):   $categorias   = null; else: $categorias   = " AND sd_retification_pmp.product_id_category={$Categories_id} "; endif;
                        if($Itens_id      == "all"):   $produtos     = null; else: $produtos     = " AND sd_retification_pmp.id_product={$Itens_id} "; endif;
                        if($Customers_id  == "all"):   $clientes     = null; else: $clientes     = " AND sd_retification.id_customer={$Customers_id} "; endif;

                        if($method_id == "all"):
                            $method = null;
                            $v = null;
                        else:
                            $method  = " AND sd_retification.method=:m ";
                            $v = "&m=".$method_id;
                        endif;

                        if($Itens_type == "all"):
                            $type = null;
                            $g = null;
                        else:
                            $type  = " AND sd_retification_pmp.product_type=:g ";
                            $g = "&g=".$Itens_type;
                        endif;

                        if($TypeDoc == "RT" || $TypeDoc == "TM"):
                            $a = "PP";
                            $documentos = " AND sd_retification.InvoiceType!=:a AND sd_retification.InvoiceType=sd_retification.InvoiceType ";
                        else:
                            $a = $TypeDoc;
                            $documentos = " AND sd_retification.InvoiceType=:a  AND sd_retification_pmp.InvoiceType=sd_retification.InvoiceType ";
                        endif;

                        $Action = "{$v}&st={$ttt}&{$g}";
                        $Where  = "WHERE sd_retification.id_db_settings={$id_db_settings} AND sd_retification_pmp.id_db_settings=sd_retification.id_db_settings {$clientes} {$funcionarios} {$method} AND sd_retification.status=:st  {$date} {$produtos} {$categorias} {$type} AND sd_retification.numero=sd_retification_pmp.numero ORDER BY sd_retification.numero DESC ";

                        $Read = new Read();
                        $Read->ExeRead("sd_retification, sd_retification_pmp", $Where, $Action);

                        if($Read->getResult()):
                            foreach ($Read->getResult() as $infO):
                                if($infO['InvoiceType'] == "NC"):
                                    $value    = $infO['quantidade_pmp'] * $infO['preco_pmp'];
                                    $imposto  = ($infO['preco_pmp'] * $infO['taxa']) / 100;
                                    if($infO['desconto_pmp'] >= 100):
                                        $desconto = $infO['desconto_pmp'];
                                    else:
                                        $desconto = ($value * $infO['desconto_pmp']) / 100;
                                    endif;
                                    $total    = ($value - $desconto) + $imposto;

                                    $t_desconto_x -= $desconto;
                                    $t_imposto_x -= $imposto;
                                    $t_insidencia_x -= $value;

                                    $t_cona -= $total;

                                    if($infO['method'] == "ALL" && !in_array($infO['numero'], $Array02)):
                                        $t_numerario_x -= $infO['numerario'];
                                        $t_cartao_de_debito_x -= $infO['cartao_de_debito'];
                                        $t_transferencia_x -= $infO['transferencia'];

                                        array_push($Array02, $infO['numero']);
                                    elseif($infO['method'] == "CD"):
                                        $t_cartao_de_debito_x -= $total;
                                    elseif($infO['method'] == "NU"):
                                        $t_numerario_x -= $total;
                                    elseif($infO['method'] == "TB"):
                                        $t_transferencia_x -= $total;
                                    endif;

                                    $t_conta_x_x_x += $total;
                                else:
                                    $value    = $infO['quantidade_pmp'] * $infO['preco_pmp'];
                                    $imposto  = ($infO['preco_pmp'] * $infO['taxa']) / 100;
                                    if($key['desconto_pmp'] >= 100):
                                        $desconto = $infO['desconto_pmp'];
                                    else:
                                        $desconto = ($value * $infO['desconto_pmp']) / 100;
                                    endif;
                                    $total    = ($value - $desconto) + $imposto;

                                    $t_desconto_x += $desconto;
                                    $t_imposto_x += $imposto;
                                    $t_insidencia_x += $value;

                                    $t_cona += $total;
                                    $t_conta_x_x_x -= $total;

                                    if($infO['method'] == "ALL"):
                                        $t_numerario_x += $infO['numerario'];
                                        $t_cartao_de_debito_x += $infO['cartao_de_debito'];
                                        $t_transferencia_x += $infO['transferencia'];
                                    elseif($infO['method'] == "CD"):
                                        $t_cartao_de_debito_x += $total;
                                    elseif($infO['method'] == "NU"):
                                        $t_numerario_x += $total;
                                    elseif($infO['method'] == "TB"):
                                        $t_transferencia_x += $total;
                                    endif;
                                endif;
                            endforeach;
                        endif;
                    endif;


                    $Read->ExeRead("av_caixa", "WHERE id_db_settings=:ip AND  dia BETWEEN {$i[2]} AND {$f[2]} AND mes BETWEEN {$i[1]} AND {$f[1]} AND ano BETWEEN {$i[0]} AND {$f[0]} ", "ip={$id_db_settings}");
                    if($Read->getResult()):
                        foreach($Read->getResult() as $fucks):

                            $t_cona -= $fucks['valor'];
                            $t_numerario_x -= $fucks['valor'];
                            $t_conta_x_x_x += $fucks['valor'];
                            ?>
                            <tr>
                                <td></td>
                                <td><?= $fucks['id']; ?></td>
                                <td></td>
                                <td colspan="7"><strong>Obs:</strong> <?= $fucks['description']; ?></td>
                                <td><?= number_format($fucks['valor'], 2, ",", "."); ?></td>
                                <td><?= $fucks['dia']."/".$fucks['mes']."/".$fucks['ano']." ".$fucks['hora']; ?></td>
                                <td></td>
                                <td><?php $Read->ExeRead("db_users", "WHERE id=:i", "i={$fucks['id_user']}"); if($Read->getResult()): echo $Read->getResult()[0]['name']; endif; ?></td>
                            </tr>
                        <?php
                        endforeach;
                    endif;

                    $Read->ExeRead("av_entrada_e_saida", "WHERE id_db_settings=:ip AND  dia BETWEEN {$i[2]} AND {$f[2]} AND mes BETWEEN {$i[1]} AND {$f[1]} AND ano BETWEEN {$i[0]} AND {$f[0]} ", "ip={$id_db_settings}");
                    if($Read->getResult()):
                        foreach($Read->getResult() as $fuckx):

                            if($fuckx['type'] == "Entrada"):
                                $t_cona += $fuckx['valor'];
                                $t_conta_x_x_x -= $fuckx['valor'];

                                if($fuckx['method'] == "CD"):
                                    $t_cartao_de_debito_x += $fuckx['valor'];
                                elseif($fuckx['method'] == "NU"):
                                    $t_numerario_x += $fuckx['valor'];
                                elseif($fuckx['method'] == "TB"):
                                    $t_transferencia_x += $fuckx['valor'];
                                endif;
                            else:
                                $t_cona -= $fuckx['valor'];
                                $t_conta_x_x_x += $fuckx['valor'];

                                if($fuckx['method'] == "CD"):
                                    $t_cartao_de_debito_x -= $fuckx['valor'];
                                elseif($fuckx['method'] == "NU"):
                                    $t_numerario_x -= $fuckx['valor'];
                                elseif($fuckx['method'] == "TB"):
                                    $t_transferencia_x -= $fuckx['valor'];
                                endif;
                            endif;

                            ?>
                            <tr>
                                <td></td>
                                <td><?= $fuckx['id']; ?></td>
                                <td colspan="1"><?php if($fuckx['method'] == 'CC'): echo 'Cartão de Credito'; elseif($fuckx['method'] == 'MB'): echo 'Referência de pagamentos para Multicaixa'; elseif($fuckx['method'] == 'CD'): echo 'Cartão de Debito'; elseif($fuckx['method'] == 'CH'): echo 'Cheque Bancário'; elseif($fuckx['method'] == 'NU'): echo 'Numerário'; elseif ($fuckx['method'] == 'TB'): echo 'Transferência Bancária'; elseif($fuckx['method'] == 'OU'): echo 'Outros Meios Aqui não Assinalados'; endif; ?></td>
                                <td colspan="7"><strong>Obs:</strong> <?= $fuckx['description']; ?></td>
                                <td><?= number_format($fuckx['valor'], 2, ",", ".")." / ".$fuckx['type']; ?></td>
                                <td><?= $fuckx['dia']."/".$fuckx['mes']."/".$fuckx['ano']." ".$fuckx['hora']; ?></td>
                                <td><?php $Read->ExeRead("cv_customer", "WHERE id=:i", "i={$fuckx['id_customer']}"); if($Read->getResult()): echo $Read->getResult()[0]['nome']; endif; ?></td>
                                <td><?php $Read->ExeRead("db_users", "WHERE id=:i", "i={$fuckx['id_user']}"); if($Read->getResult()): echo $Read->getResult()[0]['name']; endif; ?></td>
                            </tr>
                        <?php
                        endforeach;
                    endif;
                endif;


                if($TypeDoc == "RT" || $TypeDoc == "TM" || $TypeDoc == "NC" || $TypeDoc == "RG"):
                    if(isset($dateI) && isset($dateF) && !empty($dateI) && !empty($dateF)):
                        $f    = explode("-", $dateF);
                        $i    = explode("-", $dateI);
                        $date = " AND sd_retification.dia BETWEEN {$i[2]} AND {$f[2]} AND sd_retification.mes BETWEEN {$i[1]} AND {$f[1]} AND sd_retification.ano BETWEEN {$i[0]} AND {$f[0]} ";
                    else:
                        $date = null;
                    endif;

                    if($Function_id   == "all"):   $funcionarios = null; else: $funcionarios = " AND sd_retification.session_id={$Function_id} "; endif;
                    if($Categories_id == "all"):   $categorias   = null; else: $categorias   = " AND sd_retification_pmp.product_id_category={$Categories_id} "; endif;
                    if($Itens_id      == "all"):   $produtos     = null; else: $produtos     = " AND sd_retification_pmp.id_product={$Itens_id} "; endif;
                    if($Customers_id  == "all"):   $clientes     = null; else: $clientes     = " AND sd_retification.id_customer={$Customers_id} "; endif;

                    if($method_id == "all"):
                        $method = null;
                        $v = null;
                    else:
                        $method  = " AND sd_retification.method=:m ";
                        $v = "&m=".$method_id;
                    endif;

                    if($Itens_type == "all"):
                        $type = null;
                        $g = null;
                    else:
                        $type  = " AND sd_retification_pmp.product_type=:g ";
                        $g = "&g=".$Itens_type;
                    endif;

                    if($TypeDoc == "RT" || $TypeDoc == "TM"):
                        $a = "PP";
                        $documentos = " AND sd_retification.InvoiceType!=:a AND sd_retification.InvoiceType=sd_retification.InvoiceType ";
                    else:
                        $a = $TypeDoc;
                        $documentos = " AND sd_retification.InvoiceType=:a  AND sd_retification_pmp.InvoiceType=sd_retification.InvoiceType ";
                    endif;

                    $Action = "{$v}&a={$a}&st={$ttt}&{$g}";
                    $Where  = "WHERE sd_retification.id_db_settings={$id_db_settings} AND sd_retification_pmp.id_db_settings=sd_retification.id_db_settings {$clientes} {$funcionarios} {$method} {$documentos} AND sd_retification.status=:st  {$date} {$produtos} {$categorias} {$type} AND sd_retification.numero=sd_retification_pmp.numero ORDER BY sd_retification.numero DESC ";

                    $Read = new Read();
                    $Read->ExeRead("sd_retification, sd_retification_pmp", $Where, $Action);

                    if($Read->getResult()):
                        foreach ($Read->getResult() as $key):
                            $value = ($key['quantidade_pmp'] * $key['preco_pmp']);

                            $taxa = ($value * $key['taxa']) / 100;
                            if($key['desconto_pmp'] >= 100):
                                $desconto = $key['desconto_pmp'];
                            else:
                                $desconto = ($value * $key['desconto_pmp']) / 100;
                            endif;

                            $total  = ($value - $desconto) + $taxa;

                            if($key['InvoiceType'] == "NC"):
                                $t_cona -= $total;
                                $t_insidencia_x -= $value;
                                $t_desconto_x -= $desconto;
                                $t_imposto_x -= $taxa;

                                if($key['method'] == "ALL" && !in_array($key['numero'], $Array03)):
                                    $t_numerario_x -= $key['numerario'];
                                    $t_cartao_de_debito_x -= $key['cartao_de_debito'];
                                    $t_transferencia_x -= $key['transferencia'];

                                    array_push($Array03, $key['numero']);
                                elseif($key['method'] == "NU"):
                                    $t_numerario_x -= $total;
                                elseif($key['method'] == "TB"):
                                    $t_transferencia_x -= $total;
                                elseif($key['method'] == "CD"):
                                    $t_cartao_de_debito_x -= $total;
                                endif;
                            else:
                                $t_cona += $total;
                                $t_insidencia_x += $value;
                                $t_desconto_x += $desconto;
                                $t_imposto_x += $taxa;

                                if($key['method'] == "ALL"):
                                    $t_numerario_x += $key['numerario'];
                                    $t_cartao_de_debito_x += $key['cartao_de_debito'];
                                    $t_transferencia_x += $key['transferencia'];
                                elseif($key['method'] == "NU"):
                                    $t_numerario_x += $total;
                                elseif($key['method'] == "TB"):
                                    $t_transferencia_x += $total;
                                elseif($key['method'] == "CD"):
                                    $t_cartao_de_debito_x += $total;
                                endif;
                            endif;
                            ?>
                            <tr>
                                <td><?= $key['dia']."/".$key['mes']."/".$key['ano']." ".$key['hora']; ?></td>
                                <td><?= $key['InvoiceType']; ?></td>
                                <td><?php if($key['InvoiceType'] == 'RG'): echo "Recibo "; elseif($key['InvoiceType'] == 'NC'): echo 'Nota de Crédito '; endif; ?> <?= $key['InvoiceType']." ".$key['mes'].$key['Code'].$key['ano']."/".$key['numero']; ?></td>
                                <td><?php if($key['method'] == 'CC'): echo 'Cartão de Credito'; elseif($key['method'] == 'MB'): echo 'Referência de pagamentos para Multicaixa'; elseif($key['method'] == 'CD'): echo 'Cartão de Debito'; elseif($key['method'] == 'CH'): echo 'Cheque Bancário'; elseif($key['method'] == 'NU'): echo 'Numerário'; elseif ($key['method'] == 'TB'): echo 'Transferência Bancária'; elseif($key['method'] == 'OU'): echo 'Outros Meios Aqui não Assinalados'; elseif($key['method'] == 'ALL'): echo 'Diversificado'; endif; ?></td>
                                <td><?php $Read->ExeRead("cv_customer", "WHERE id=:i", "i={$key['id_customer']}"); if($Read->getResult()): echo $Read->getResult()[0]['nome']; endif; ?></td>
                                <td><?php $Read->ExeRead("cv_category", "WHERE id_xxx=:i", "i={$key['product_id_category']}"); if($Read->getResult()): echo $Read->getResult()[0]['category_title']; endif; ?></td>
                                <td><?= $key['product_code']; ?></td>
                                <td><?= $key['product_codigo_barras']; ?></td>
                                <td><?= $key['product_name']; ?></td>

                                <td><?= $key['quantidade_pmp']; ?></td>
                                <td><?= number_format($key['preco_pmp'], 2, ",", "."); ?></td>
                                <td><?= number_format($desconto, 2, ",", "."); ?></td>
                                <td><?= number_format($taxa, 2, ",", "."); ?></td>
                                <td><?= number_format($total, 2, ",", "."); ?></td>

                                <td><?php $Read->ExeRead("db_users", "WHERE id=:i", "i={$key['session_id']}"); if($Read->getResult()): echo $Read->getResult()[0]['name']; endif; ?></td>
                            </tr>
                        <?php
                        endforeach;
                    endif;
                endif;
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<br/><div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <table class="table table-transparent table-responsive">
                <tr>
                    <td colspan="9" class="strong text-end">Multicaixa</td>
                    <td class="font-weight-bold text-end"><?= number_format($t_cartao_de_debito_x, 2, ",", "."); ?></td>
                </tr>
                <tr>
                    <td colspan="9" class="strong text-end">Transferência</td>
                    <td class="font-weight-bold text-end"><?= number_format($t_transferencia_x, 2, ",", "."); ?></td>
                </tr>
                <tr>
                    <td colspan="9" class="strong text-end">Númerario</td>
                    <td class="font-weight-bold text-end"><?= number_format($t_numerario_x, 2, ",", "."); ?></td>
                </tr>
                <tr>
                    <td colspan="9" class="font-weight-bold text-uppercase text-end">Incidência</td>
                    <td class="font-weight-bold text-end"><?= number_format($t_insidencia_x, 2, ",", "."); ?></td>
                </tr>
                <tr>
                    <td colspan="9" class="font-weight-bold text-uppercase text-end">Descontos</td>
                    <td class="font-weight-bold text-end"><?= number_format($t_desconto_x, 2, ",", "."); ?></td>
                </tr>
                <tr>
                    <td colspan="9" class="font-weight-bold text-uppercase text-end">Impostos</td>
                    <td class="font-weight-bold text-end"><?= number_format($t_imposto_x, 2, ",", "."); ?></td>
                </tr>
                <tr>
                    <td colspan="9" class="font-weight-bold text-uppercase text-end">Total</td>
                    <td class="font-weight-bold text-end"><?= number_format($t_cona, 2,",", "."); ?> AOA</td>
                </tr>
            </table>
        </div>
    </div>
</div>
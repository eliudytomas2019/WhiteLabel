<?php
if(!class_exists('login')):
    header("index.php");
    die();
endif;

if($level >= 4): $n =  '&id_db_settings='.$id_db_settings; else: $n = null; endif;

if($userlogin['level'] < 1):
    header("location: panel.php?exe=default/home".$n);
endif;

$postid = filter_input(INPUT_GET, "postid", FILTER_VALIDATE_INT);
?>

<div class="page-header d-print-none">
    <div class="row align-items-center">

        <div class="col-auto ms-auto d-print-none">
            <div class="btn-list">
                <a href="panel.php?exe=customer/index<?= $n; ?>" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 13l-4 -4l4 -4m-4 4h11a4 4 0 0 1 0 8h-1" /></svg>
                    Voltar
                </a>
            </div>
        </div>
        <div class="col">
            <div class="page-pretitle">
                <?= $Index['name']; ?>
            </div>
            <h2 class="page-title">
                Gestão de Clientes
            </h2>
        </div>
    </div>
</div>
<br/>
<?php
    $Read = new Read();

    $docs = null;
    $Read->ExeRead("ii_billing", "WHERE id_cliente=:i", "i={$postid}");
    if($Read->getResult()): $docs += $Read->getRowCount(); endif;

    $Read->ExeRead("sd_billing", "WHERE id_customer=:i", "i={$postid}");
    if($Read->getResult()): $docs += $Read->getRowCount(); endif;

    $Read->ExeRead("sd_retification", "WHERE id_customer=:i", "i={$postid}");
    if($Read->getResult()): $docs += $Read->getRowCount(); endif;
?>

<div class="row">
    <div class="col-md-6 col-xl-3">
        <div class="card card-sm">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <span class="bg-blue text-white avatar"><!-- Download SVG icon from http://tabler-icons.io/i/currency-dollar -->
                            <!-- Download SVG icon from http://tabler-icons.io/i/archive -->
	<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><rect x="3" y="4" width="18" height="4" rx="2" /><path d="M5 8v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-10" /><line x1="10" y1="12" x2="14" y2="12" /></svg>
                        </span>
                    </div>
                    <div class="col">
                        <div class="font-weight-medium">
                            <?= $docs; ?>
                        </div>
                        <div class="text-muted" style="color: #313030!important;">
                           Documentos Emitidos
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    $s = 0;
    $ttc = "FT";
    $t_v = 0;
    $t_g = 0;
    $tgg = 0;
    $t_gg = 0;

    $read = new Read();
    $read->ExeRead("sd_billing", "WHERE id_customer=:i AND id_db_settings=:sp AND InvoiceType=:ttc", "i={$postid}&sp={$id_db_settings}&ttc={$ttc}");
    if($read->getResult()):
        foreach ($read->getResult() as $dating):
            $n1 = "sd_billing";
            $n3 = "sd_billing_pmp";
            $n2 = "sd_retification";
            $n4 = "sd_retification_pmp";

            $Cochi = $dating['InvoiceType']." ".$dating['mes'].$dating['Code'].$dating['ano']."/".$dating['numero'];

            $read->ExeRead("{$n3}", "WHERE id_db_settings=:i AND numero=:nn AND InvoiceType=:ip", "i={$id_db_settings}&nn={$dating['numero']}&ip={$dating['InvoiceType']}");
            if($read->getResult()):
                foreach($read->getResult() as $ky):
                    $value = $ky['quantidade_pmp'] * $ky['preco_pmp'];
                    $desconto = ($value * $ky['desconto_pmp']) / 100;
                    $imposto  = ($value * $ky['taxa']) / 100;

                    $t_v += ($value - $desconto) + $imposto;
                endforeach;
            endif;

            $Tg = "RG";
            $read->ExeRead("{$n4}", "WHERE id_db_settings=:i AND InvoiceType=:tg AND id_invoice=:nn", "i={$id_db_settings}&tg={$Tg}&nn={$dating['id']}");
            if($read->getResult()):
                foreach($read->getResult() as $ey):
                    $value = $ey['quantidade_pmp'] * $ey['preco_pmp'];
                    $desconto = ($value * $ey['desconto_pmp']) / 100;
                    $imposto  = ($value * $ey['taxa']) / 100;

                    $t_g += ($value - $desconto) + $imposto;
                endforeach;
            endif;
        endforeach;
    endif;

    $Abc = "FT";
    $read = new Read();
    $read->ExeRead("sd_billing", "WHERE id_customer=:i AND id_db_settings=:sp AND InvoiceType=:abc", "i={$postid}&sp={$id_db_settings}&abc={$Abc}");
    if($read->getResult()):
        foreach ($read->getResult() as $dating):
            $n1 = "sd_billing";
            $n3 = "sd_billing_pmp";
            $n2 = "sd_retification";
            $n4 = "sd_retification_pmp";

            $Cochi = $dating['InvoiceType']." ".$dating['mes'].$dating['Code'].$dating['ano']."/".$dating['numero'];

            $read->ExeRead("{$n3}", "WHERE id_db_settings=:i AND numero=:nn AND InvoiceType=:ip", "i={$id_db_settings}&nn={$dating['numero']}&ip={$dating['InvoiceType']}");
            if($read->getResult()):
                foreach($read->getResult() as $ky):
                    $value = $ky['quantidade_pmp'] * $ky['preco_pmp'];
                    $desconto = ($value * $ky['desconto_pmp']) / 100;
                    $imposto  = ($value * $ky['taxa']) / 100;

                    $t_gg += ($value - $desconto) + $imposto;
                endforeach;
            endif;

            $Tg = "NC";
            $read->ExeRead("{$n4}", "WHERE id_db_settings=:i AND InvoiceType=:tg AND id_invoice=:nn", "i={$id_db_settings}&tg={$Tg}&nn={$dating['id']}");
            if($read->getResult()):
                foreach($read->getResult() as $ey):
                    $value = $ey['quantidade_pmp'] * $ey['preco_pmp'];
                    $desconto = ($value * $ey['desconto_pmp']) / 100;
                    $imposto  = ($value * $ey['taxa']) / 100;

                    $tgg += ($value - $desconto) + $imposto;
                endforeach;
            endif;
        endforeach;
    endif;

    $puta = null;
    $tmm = null;
    $Carrocel = "FR";
    $read = new Read();
    $read->ExeRead("sd_billing", "WHERE id_customer=:i AND id_db_settings=:sp AND InvoiceType=:cat", "i={$postid}&sp={$id_db_settings}&cat={$Carrocel}");
    if($read->getResult()):
        foreach ($read->getResult() as $dating):
            $n1 = "sd_billing";
            $n3 = "sd_billing_pmp";
            $n2 = "sd_retification";
            $n4 = "sd_retification_pmp";

            $Cochi = $dating['InvoiceType']." ".$dating['mes'].$dating['Code'].$dating['ano']."/".$dating['numero'];

            $read->ExeRead("{$n3}", "WHERE id_db_settings=:i AND numero=:nn AND InvoiceType=:ip", "i={$id_db_settings}&nn={$dating['numero']}&ip={$dating['InvoiceType']}");
            if($read->getResult()):
                foreach($read->getResult() as $ky):
                    $value = $ky['quantidade_pmp'] * $ky['preco_pmp'];
                    $desconto = ($value * $ky['desconto_pmp']) / 100;
                    $imposto  = ($value * $ky['taxa']) / 100;

                    $puta += ($value - $desconto) + $imposto;
                endforeach;
            endif;

            $Tg = "NC";
            $read->ExeRead("{$n4}", "WHERE id_db_settings=:i AND InvoiceType=:tg AND id_invoice=:nn", "i={$id_db_settings}&tg={$Tg}&nn={$dating['id']}");
            if($read->getResult()):
                foreach($read->getResult() as $ey):
                    $value = $ey['quantidade_pmp'] * $ey['preco_pmp'];
                    $desconto = ($value * $ey['desconto_pmp']) / 100;
                    $imposto  = ($value * $ey['taxa']) / 100;

                    $tmm += ($value - $desconto) + $imposto;
                endforeach;
            endif;
        endforeach;
    endif;

    $td_g = $t_v - ($t_g + $tgg);
    $t_geral = ($puta + $t_g) - ($tgg + $tmm);
    $Diferenca = $puta - $t_geral;
    ?>
    <div class="col-md-6 col-xl-3">
        <div class="card card-sm">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <span class="bg-primary text-white avatar"><!-- Download SVG icon from http://tabler-icons.io/i/shopping-cart -->
                            <!-- Download SVG icon from http://tabler-icons.io/i/chart-bubble -->
	<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="6" cy="16" r="3" /><circle cx="16" cy="19" r="2" /><circle cx="14.5" cy="7.5" r="4.5" /></svg>
                        </span>
                    </div>
                    <div class="col">
                        <div class="font-weight-medium">
                           <?= str_replace(",", ".", number_format($puta, 2))." AOA"; ?>
                        </div>
                        <div class="text-muted" style="color: #313030!important;">
                           Compra Pré-Paga
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card card-sm">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <span class="bg-red text-white avatar"><!-- Download SVG icon from http://tabler-icons.io/i/chart-bar -->
	<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><rect x="3" y="12" width="6" height="8" rx="1" /><rect x="9" y="8" width="6" height="12" rx="1" /><rect x="15" y="4" width="6" height="16" rx="1" /><line x1="4" y1="20" x2="18" y2="20" /></svg>
                        </span>
                    </div>
                    <div class="col">
                        <div class="font-weight-medium">
                            <?= str_replace(",", ".", number_format($Diferenca, 2))." AOA"; ?>
                        </div>
                        <div class="text-muted" style="color: #313030!important;">
                            Itens Devolvidos
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card card-sm">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <span class="bg-green text-white avatar"><!-- Download SVG icon from http://tabler-icons.io/i/chart-bar -->
	<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><rect x="3" y="12" width="6" height="8" rx="1" /><rect x="9" y="8" width="6" height="12" rx="1" /><rect x="15" y="4" width="6" height="16" rx="1" /><line x1="4" y1="20" x2="18" y2="20" /></svg>
                        </span>
                    </div>
                    <div class="col">
                        <div class="font-weight-medium">
                            <?= str_replace(",", ".", number_format($t_geral, 2))." AOA"; ?>
                        </div>
                        <div class="text-muted" style="color: #313030!important;">
                            Diferença
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card card-sm">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <span class="bg-red text-white avatar"><!-- Download SVG icon from http://tabler-icons.io/i/shopping-cart -->
                            <!-- Download SVG icon from http://tabler-icons.io/i/chart-bubble -->
	<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="6" cy="16" r="3" /><circle cx="16" cy="19" r="2" /><circle cx="14.5" cy="7.5" r="4.5" /></svg>
                        </span>
                    </div>
                    <div class="col">
                        <div class="font-weight-medium">
                            <?= str_replace(",", ".", number_format($t_v, 2))." AOA"; ?>
                        </div>
                        <div class="text-muted" style="color: #313030!important;">
                            Compra a credito
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card card-sm">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <span class="bg-green text-white avatar"><!-- Download SVG icon from http://tabler-icons.io/i/user -->
                            <!-- Download SVG icon from http://tabler-icons.io/i/presentation-analytics -->
	<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 12v-4" /><path d="M15 12v-2" /><path d="M12 12v-1" /><path d="M3 4h18" /><path d="M4 4v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-10" /><path d="M12 16v4" /><path d="M9 20h6" /></svg>
                        </span>
                    </div>
                    <div class="col">
                        <div class="font-weight-medium">
                            <?= str_replace(",", ".", number_format($t_g, 2))." AOA"; ?>
                        </div>
                        <div class="text-muted" style="color: #313030!important;">
                            Credito Pago
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card card-sm">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <span class="bg-yellow text-white avatar"><!-- Download SVG icon from http://tabler-icons.io/i/message -->
                            <!-- Download SVG icon from http://tabler-icons.io/i/chart-infographic -->
	<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="7" cy="7" r="4" /><path d="M7 3v4h4" /><line x1="9" y1="17" x2="9" y2="21" /><line x1="17" y1="14" x2="17" y2="21" /><line x1="13" y1="13" x2="13" y2="21" /><line x1="21" y1="12" x2="21" y2="21" /></svg>
                        </span>
                    </div>
                    <div class="col">
                        <div class="font-weight-medium">
                            <?= str_replace(",", ".", number_format($td_g, 2))." AOA"; ?>
                        </div>
                        <div class="text-muted" style="color: #313030!important;">
                            Divida Restante
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<br/>
<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Historico de Facturas</h3>&nbsp;&nbsp;&nbsp;
        </div>
        <div id="aPaulo"></div>
        <div class="table-responsive">
            <table class="table" style="text-align: left!important;align-content: flex-start!important;align-items: flex-start!important;">
                <thead>
                <tr>
                    <th>Número</th>
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
                $getPage1 = filter_input(INPUT_GET, 'page',FILTER_VALIDATE_INT);
                $Pager = new Pager("panel.php?exe=customer/history{$n}&postid=".$postid."&page=");
                $Pager->ExePager($getPage1, 10);

                $n1 = "sd_billing";
                $n3 = "sd_billing_pmp";
                $n2 = "sd_retification";
                $n4 = "sd_retification_pmp";
                $n5 = "sd_guid";
                $n6 = "sd_guid_pmp";
                $PPs = "'PP'";

                $read = new Read();
                $read->ExeRead("{$n1}", "WHERE ({$n1}.id_db_settings=:i AND {$n1}.id_customer=:is AND {$n1}.InvoiceType!={$PPs} AND {$n1}.session_id=:id AND {$n1}.status=:st AND {$n1}.suspenso={$s}) ORDER BY {$n1}.id DESC LIMIT :limit OFFSET :offset", "i={$id_db_settings}&is={$postid}&id={$id_user}&st={$st}&limit={$Pager->getLimit()}&offset={$Pager->getOffset()}");
                if($read->getResult()):
                    foreach ($read->getResult() as $key):
                        require("_disk/AppData/ResultDocumentsInvoice.inc.php");
                    endforeach;
                endif;
                ?>
                </tbody>
            </table>
        </div>
        <div class="card-footer d-flex align-items-center">
            <?php
            $Pager->ExePaginator("{$n1}", "WHERE ({$n1}.id_db_settings=:i AND {$n1}.id_customer=:is AND {$n1}.InvoiceType!={$PPs} AND {$n1}.session_id=:id AND {$n1}.status=:st AND {$n1}.suspenso={$s}) ORDER BY {$n1}.id DESC", "i={$id_db_settings}&is={$postid}&id={$id_user}&st={$st}");
            echo $Pager->getPaginator();
            ?>
        </div>
    </div>
</div>
<br/>
<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Historico de Proformas</h3>&nbsp;&nbsp;&nbsp;
        </div>
        <div id="aPaulo"></div>
        <div class="table-responsive">
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
                    $getPage2 = filter_input(INPUT_GET, 'page2',FILTER_VALIDATE_INT);
                    $Pagers = new Pager("panel.php?exe=customer/history{$n}&postid={$postid}&page2=");
                    $Pagers->ExePager($getPage2, 10);

                    $n1 = "sd_billing";
                    $n3 = "sd_billing_pmp";
                    $PPs = "PP";

                    $read = new Read();
                    $read->ExeRead("{$n1}", "WHERE ({$n1}.id_db_settings=:i AND {$n1}.id_customer=:is AND {$n1}.session_id=:id AND {$n1}.InvoiceType=:invoice AND {$n1}.status=:st AND {$n1}.suspenso={$s}) ORDER BY {$n1}.id DESC LIMIT :limit OFFSET :offset", "i={$id_db_settings}&is={$postid}&id={$id_user}&invoice={$PPs}&st={$st}&limit={$Pagers->getLimit()}&offset={$Pagers->getOffset()}");
                    if($read->getResult()):
                        foreach ($read->getResult() as $key):
                            require("_disk/AppData/ResultDocumentsProformas.inc.php");
                        endforeach;
                    endif;
                ?>
                </tbody>
            </table>
        </div>
        <div class="card-footer d-flex align-items-center">
            <?php
            $Pagers->ExePaginator("{$n1}", "WHERE ({$n1}.id_db_settings=:i AND {$n1}.id_customer=:is AND {$n1}.session_id=:id AND {$n1}.InvoiceType=:invoice AND {$n1}.status=:st AND {$n1}.suspenso={$s}) ORDER BY {$n1}.id DESC", "i={$id_db_settings}&is={$postid}&id={$id_user}&invoice={$PPs}&st={$st}");
            echo $Pagers->getPaginator();
            ?>
        </div>
    </div>
</div>
<?php if($DB->CheckCpanelAndSettings($id_db_settings, $id_db_kwanzar)['atividade'] == 4): ?>
    <br/>
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Histórico de Folhas de Obra</h3>&nbsp;&nbsp;&nbsp;
            </div>
            <div id="aPaulo"></div>
            <div class="table-responsive">
                <table class="table text-center">
                    <thead>
                    <tr>
                        <th>NÚMERO</th>
                        <th>DATA & HORA</th>
                        <th>DOCUMENTO</th>
                        <th>-</th>
                        <th>ID</th>
                    </tr>
                    </thead>
                    <tbody id="ReturnDocs">
                    <?php

                    $posti = 0;
                    $getPage5 = filter_input(INPUT_GET, 'pages',FILTER_VALIDATE_INT);
                    $Pagerw = new Pager("painel.php?exe=customer/history{$n}&postid={$postid}&pages=");
                    $Pagerw->ExePager($getPage5, 10);

                    $status = 3;
                    $Read = new Read();
                    $Read->ExeRead("ii_billing", "WHERE id_db_settings=:i AND id_cliente=:is AND id_user=:y AND status=:st ORDER BY id DESC LIMIT :limit OFFSET :offset", "i={$id_db_settings}&is={$postid}&y={$id_user}&st={$status}&limit={$Pagerw->getLimit()}&offset={$Pagerw->getOffset()}");

                    if($Read->getResult()):
                        foreach ($Read->getResult() as $key):
                            ?>
                            <tr>
                                <td><?= $key['numero']; ?></td>
                                <td><?= $key['dia']."/".$key["mes"]."/".$key['ano']." ".$key['hora']; ?></td>
                                <td><?= $key['InvoiceType']; ?></td>
                                <td>
                                    <a href="print.php?action=16&id_db_settings=<?= $id_db_settings; ?>&postId=<?= $key['id']; ?>&InvoiceType=<?= $key['InvoiceType']; ?>&post=<?= $key['numero']; ?>" target="_blank" class="btn btn-success btn-sm small">Imprimir</a>&nbsp;
                                </td>
                                <td><?= $key['id']; ?></td>
                            </tr>
                        <?php
                        endforeach;
                    endif;
                    ?>
                    </tbody>
                </table>
            </div>
            <div class="card-footer d-flex align-items-center">
                <?php
                $Pagerw->ExePaginator("ii_billing", "WHERE id_db_settings=:i AND id_cliente=:is AND id_user=:y AND status=:st ORDER BY id DESC", "i={$id_db_settings}&is={$postid}&y={$id_user}&st={$status}");
                echo $Pagerw->getPaginator();
                ?>
            </div>
        </div>
    </div>
<?php endif; ?>
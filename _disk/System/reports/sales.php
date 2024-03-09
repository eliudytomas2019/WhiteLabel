<?php
if(DBKwanzar::CheckConfig($id_db_settings) == false || DBKwanzar::CheckConfig($id_db_settings)['JanuarioSakalumbu'] == null): $ttt = 2; else: $ttt = DBKwanzar::CheckConfig($id_db_settings)['JanuarioSakalumbu']; endif;

$day    = date('d');
$moundy = date('m');
$year   = date('Y');

$t_inFo = 0;
$t_inFe = 0;
$t_inFa = 0;
$t_inFu = 0;

$Read = new Read();

// Hoje

$Read->ExeRead("sd_billing, sd_billing_pmp", "WHERE sd_billing.id_db_settings=:ip AND sd_billing.method='NU' AND sd_billing.InvoiceType='FR' AND sd_billing.status=:st AND sd_billing.dia=:d AND sd_billing.mes=:m AND sd_billing.ano=:a AND sd_billing_pmp.id_db_settings=:ip AND sd_billing_pmp.status=:st AND sd_billing_pmp.numero=sd_billing.numero AND sd_billing_pmp.InvoiceType='FR'", "ip={$id_db_settings}&st={$ttt}&d={$day}&m={$moundy}&a={$year}");
if($Read->getResult()):
    foreach($Read->getResult() as $fuck):
        $value = ($fuck['quantidade_pmp'] * $fuck['preco_pmp']);

        if($fuck['desconto_pmp'] >= 100):
            $desconto = $fuck['desconto_pmp'];
        else:
            $desconto = ($value * $fuck['desconto_pmp']) / 100;
        endif;

        //$desconto = ($value * $fuck['desconto_pmp']) / 100;
        $taxa = ($value * $fuck['taxa']) / 100;

        $total_i = ($value - $desconto) + $taxa;
        $desconto_e = ($fuck['settings_desc_financ'] * $total_i) / 100;
        $desconto_i = ($total_i - $desconto_e);

        $t_inFo += $desconto_i;
    endforeach;
endif;


$Read->ExeRead("sd_billing", "WHERE sd_billing.id_db_settings=:ip AND sd_billing.method='ALL' AND sd_billing.InvoiceType='FR' AND sd_billing.status=:st AND sd_billing.dia=:d AND sd_billing.mes=:m AND sd_billing.ano=:a ", "ip={$id_db_settings}&st={$ttt}&d={$day}&m={$moundy}&a={$year}");
if($Read->getResult()):
    foreach($Read->getResult() as $fuck):
        $t_inFo += $fuck['numerario'];
    endforeach;
endif;

$Read->ExeRead("av_entrada_e_saida", "WHERE av_entrada_e_saida.id_db_settings=:ip AND av_entrada_e_saida.method='NU' AND av_entrada_e_saida.dia=:d AND av_entrada_e_saida.mes=:m AND av_entrada_e_saida.ano=:a", "ip={$id_db_settings}&d={$day}&m={$moundy}&a={$year}");
if($Read->getResult()):
    foreach($Read->getResult() as $fuck):
        if($fuck['type'] == "Entrada"):
            $t_inFo += $fuck['valor'];
        else:
            $t_inFo -= $fuck['valor'];
        endif;
    endforeach;
endif;

$Read->ExeRead("sd_retification, sd_retification_pmp", "WHERE sd_retification.id_db_settings=:ip AND sd_retification.method='NU' AND sd_retification.InvoiceType='RG' AND sd_retification.status=:st AND sd_retification.dia=:d AND sd_retification.mes=:m AND sd_retification.ano=:a AND sd_retification_pmp.id_db_settings=:ip AND sd_retification_pmp.status=:st AND sd_retification_pmp.numero=sd_retification.numero AND sd_retification_pmp.InvoiceType='RG'", "ip={$id_db_settings}&st={$ttt}&d={$day}&m={$moundy}&a={$year}");
if($Read->getResult()):
    foreach($Read->getResult() as $fuck):
        $value = ($fuck['quantidade_pmp'] * $fuck['preco_pmp']);
        if($fuck['desconto_pmp'] >= 100):
            $desconto = $fuck['desconto_pmp'];
        else:
            $desconto = ($value * $fuck['desconto_pmp']) / 100;
        endif;
        //$desconto = ($value * $fuck['desconto_pmp']) / 100;
        $taxa = ($value * $fuck['taxa']) / 100;

        $total_i = ($value - $desconto) + $taxa;
        $desconto_e = ($fuck['settings_desc_financ'] * $total_i) / 100;
        $desconto_i = ($total_i - $desconto_e);

        $t_inFo += $desconto_i;
    endforeach;
endif;


$Read->ExeRead("av_caixa", "WHERE av_caixa.id_db_settings=:ip AND av_caixa.dia=:d AND av_caixa.mes=:m AND av_caixa.ano=:a", "ip={$id_db_settings}&d={$day}&m={$moundy}&a={$year}");
if($Read->getResult()):
    foreach($Read->getResult() as $fuck):
        $t_inFo -= $fuck['valor'];
    endforeach;
endif;

$Read->ExeRead("sd_retification, sd_retification_pmp", "WHERE sd_retification.id_db_settings=:ip AND sd_retification.method='NU' AND sd_retification.InvoiceType='NC' AND sd_retification.status=:st AND sd_retification.dia=:d AND sd_retification.mes=:m AND sd_retification.ano=:a AND sd_retification_pmp.id_db_settings=:ip AND sd_retification_pmp.status=:st AND sd_retification_pmp.numero=sd_retification.numero AND sd_retification_pmp.InvoiceType='NC'", "ip={$id_db_settings}&st={$ttt}&d={$day}&m={$moundy}&a={$year}");
if($Read->getResult()):
    foreach($Read->getResult() as $fuck):
        $value = ($fuck['quantidade_pmp'] * $fuck['preco_pmp']);
        if($fuck['desconto_pmp'] >= 100):
            $desconto = $fuck['desconto_pmp'];
        else:
            $desconto = ($value * $fuck['desconto_pmp']) / 100;
        endif;
        //$desconto = ($value * $fuck['desconto_pmp']) / 100;
        $taxa = ($value * $fuck['taxa']) / 100;

        $total_i = ($value - $desconto) + $taxa;
        $desconto_e = ($fuck['settings_desc_financ'] * $total_i) / 100;
        $desconto_i = ($total_i - $desconto_e);

        $t_inFo -= $desconto_i;
    endforeach;
endif;

// Ontem

if(date('d') == 1): if(date('m') == "01"): $onT = date('t-12-Y', strtotime('-1 year')); else: $onT = date('t-m-Y', strtotime('-1 month'));  endif; else: $onT = date('d-m-Y', strtotime('-1 day')); endif;

$onT = explode('-', $onT);
$day    = $onT[0];
$moundy = $onT[1];
$year   = $onT[2];

$Read->ExeRead("sd_billing, sd_billing_pmp", "WHERE sd_billing.id_db_settings=:ip AND sd_billing.method='NU' AND sd_billing.InvoiceType='FR' AND sd_billing.status=:st AND sd_billing.dia=:d AND sd_billing.mes=:m AND sd_billing.ano=:a AND sd_billing_pmp.id_db_settings=:ip AND sd_billing_pmp.status=:st AND sd_billing_pmp.numero=sd_billing.numero AND sd_billing_pmp.InvoiceType='FR'", "ip={$id_db_settings}&st={$ttt}&d={$day}&m={$moundy}&a={$year}");
if($Read->getResult()):
    foreach($Read->getResult() as $fuck):
        $value = ($fuck['quantidade_pmp'] * $fuck['preco_pmp']);
        if($fuck['desconto_pmp'] >= 100):
            $desconto = $fuck['desconto_pmp'];
        else:
            $desconto = ($value * $fuck['desconto_pmp']) / 100;
        endif;
        //$desconto = ($value * $fuck['desconto_pmp']) / 100;
        $taxa = ($value * $fuck['taxa']) / 100;

        $total_i = ($value - $desconto) + $taxa;
        $desconto_e = ($fuck['settings_desc_financ'] * $total_i) / 100;
        $desconto_i = ($total_i - $desconto_e);

        $t_inFe += $desconto_i;
    endforeach;
endif;

$Read->ExeRead("sd_billing", "WHERE sd_billing.id_db_settings=:ip AND sd_billing.method='ALL' AND sd_billing.InvoiceType='FR' AND sd_billing.status=:st AND sd_billing.dia=:d AND sd_billing.mes=:m AND sd_billing.ano=:a ", "ip={$id_db_settings}&st={$ttt}&d={$day}&m={$moundy}&a={$year}");
if($Read->getResult()):
    foreach($Read->getResult() as $fuck):
        $t_inFe += $fuck['numerario'];
    endforeach;
endif;

$Read->ExeRead("av_entrada_e_saida", "WHERE av_entrada_e_saida.id_db_settings=:ip AND av_entrada_e_saida.method='NU' AND av_entrada_e_saida.dia=:d AND av_entrada_e_saida.mes=:m AND av_entrada_e_saida.ano=:a", "ip={$id_db_settings}&d={$day}&m={$moundy}&a={$year}");
if($Read->getResult()):
    foreach($Read->getResult() as $fuck):
        if($fuck['type'] == "Entrada"):
            $t_inFe += $fuck['valor'];
        else:
            $t_inFe -= $fuck['valor'];
        endif;
    endforeach;
endif;

$Read->ExeRead("sd_retification, sd_retification_pmp", "WHERE sd_retification.id_db_settings=:ip AND sd_retification.method='NU' AND sd_retification.InvoiceType='RG' AND sd_retification.status=:st AND sd_retification.dia=:d AND sd_retification.mes=:m AND sd_retification.ano=:a AND sd_retification_pmp.id_db_settings=:ip AND sd_retification_pmp.status=:st AND sd_retification_pmp.numero=sd_retification.numero AND sd_retification_pmp.InvoiceType='RG'", "ip={$id_db_settings}&st={$ttt}&d={$day}&m={$moundy}&a={$year}");
if($Read->getResult()):
    foreach($Read->getResult() as $fuck):
        $value = ($fuck['quantidade_pmp'] * $fuck['preco_pmp']);
        if($fuck['desconto_pmp'] >= 100):
            $desconto = $fuck['desconto_pmp'];
        else:
            $desconto = ($value * $fuck['desconto_pmp']) / 100;
        endif;
        //$desconto = ($value * $fuck['desconto_pmp']) / 100;
        $taxa = ($value * $fuck['taxa']) / 100;

        $total_i = ($value - $desconto) + $taxa;
        $desconto_e = ($fuck['settings_desc_financ'] * $total_i) / 100;
        $desconto_i = ($total_i - $desconto_e);

        $t_inFe += $desconto_i;
    endforeach;
endif;

$Read->ExeRead("sd_retification, sd_retification_pmp", "WHERE sd_retification.id_db_settings=:ip AND sd_retification.method='NU' AND sd_retification.InvoiceType='NC' AND sd_retification.status=:st AND sd_retification.dia=:d AND sd_retification.mes=:m AND sd_retification.ano=:a AND sd_retification_pmp.id_db_settings=:ip AND sd_retification_pmp.status=:st AND sd_retification_pmp.numero=sd_retification.numero AND sd_retification_pmp.InvoiceType='NC'", "ip={$id_db_settings}&st={$ttt}&d={$day}&m={$moundy}&a={$year}");
if($Read->getResult()):
    foreach($Read->getResult() as $fuck):
        $value = ($fuck['quantidade_pmp'] * $fuck['preco_pmp']);
        if($fuck['desconto_pmp'] >= 100):
            $desconto = $fuck['desconto_pmp'];
        else:
            $desconto = ($value * $fuck['desconto_pmp']) / 100;
        endif;
        //$desconto = ($value * $fuck['desconto_pmp']) / 100;
        $taxa = ($value * $fuck['taxa']) / 100;

        $total_i = ($value - $desconto) + $taxa;
        $desconto_e = ($fuck['settings_desc_financ'] * $total_i) / 100;
        $desconto_i = ($total_i - $desconto_e);

        $t_inFe -= $desconto_i;
    endforeach;
endif;

$Read->ExeRead("av_caixa", "WHERE av_caixa.id_db_settings=:ip AND av_caixa.dia=:d AND av_caixa.mes=:m AND av_caixa.ano=:a", "ip={$id_db_settings}&d={$day}&m={$moundy}&a={$year}");
if($Read->getResult()):
    foreach($Read->getResult() as $fuck):
        $t_inFe -= $fuck['valor'];
    endforeach;
endif;

// Esse Mês

$moundy = date('m');
$year   = date('Y');

$Read->ExeRead("sd_billing, sd_billing_pmp", "WHERE sd_billing.id_db_settings=:ip AND sd_billing.method='NU' AND sd_billing.InvoiceType='FR' AND sd_billing.status=:st AND sd_billing.mes=:m AND sd_billing.ano=:a AND sd_billing_pmp.id_db_settings=:ip AND sd_billing_pmp.status=:st AND sd_billing_pmp.numero=sd_billing.numero AND sd_billing_pmp.InvoiceType='FR'", "ip={$id_db_settings}&st={$ttt}&m={$moundy}&a={$year}");
if($Read->getResult()):
    foreach($Read->getResult() as $fuck):
        $value = ($fuck['quantidade_pmp'] * $fuck['preco_pmp']);
        if($fuck['desconto_pmp'] >= 100):
            $desconto = $fuck['desconto_pmp'];
        else:
            $desconto = ($value * $fuck['desconto_pmp']) / 100;
        endif;
        //$desconto = ($value * $fuck['desconto_pmp']) / 100;
        $taxa = ($value * $fuck['taxa']) / 100;

        $total_i = ($value - $desconto) + $taxa;
        $desconto_e = ($fuck['settings_desc_financ'] * $total_i) / 100;
        $desconto_i = ($total_i - $desconto_e);

        $t_inFa += $desconto_i;
    endforeach;
endif;

$Read->ExeRead("sd_billing", "WHERE sd_billing.id_db_settings=:ip AND sd_billing.method='ALL' AND sd_billing.InvoiceType='FR' AND sd_billing.status=:st AND sd_billing.mes=:m AND sd_billing.ano=:a ", "ip={$id_db_settings}&st={$ttt}&m={$moundy}&a={$year}");
if($Read->getResult()):
    foreach($Read->getResult() as $fuck):
        $t_inFa += $fuck['numerario'];
    endforeach;
endif;

$Read->ExeRead("av_entrada_e_saida", "WHERE av_entrada_e_saida.id_db_settings=:ip AND av_entrada_e_saida.method='NU' AND av_entrada_e_saida.mes=:m AND av_entrada_e_saida.ano=:a", "ip={$id_db_settings}&m={$moundy}&a={$year}");
if($Read->getResult()):
    foreach($Read->getResult() as $fuck):
        if($fuck['type'] == "Entrada"):
            $t_inFa += $fuck['valor'];
        else:
            $t_inFa -= $fuck['valor'];
        endif;
    endforeach;
endif;

$Read->ExeRead("sd_retification, sd_retification_pmp", "WHERE sd_retification.id_db_settings=:ip AND sd_retification.method='NU' AND sd_retification.InvoiceType='RG' AND sd_retification.status=:st AND sd_retification.mes=:m AND sd_retification.ano=:a AND sd_retification_pmp.id_db_settings=:ip AND sd_retification_pmp.status=:st AND sd_retification_pmp.numero=sd_retification.numero AND sd_retification_pmp.InvoiceType='RG'", "ip={$id_db_settings}&st={$ttt}&m={$moundy}&a={$year}");
if($Read->getResult()):
    foreach($Read->getResult() as $fuck):
        $value = ($fuck['quantidade_pmp'] * $fuck['preco_pmp']);
        if($fuck['desconto_pmp'] >= 100):
            $desconto = $fuck['desconto_pmp'];
        else:
            $desconto = ($value * $fuck['desconto_pmp']) / 100;
        endif;
        //$desconto = ($value * $fuck['desconto_pmp']) / 100;
        $taxa = ($value * $fuck['taxa']) / 100;

        $total_i = ($value - $desconto) + $taxa;
        $desconto_e = ($fuck['settings_desc_financ'] * $total_i) / 100;
        $desconto_i = ($total_i - $desconto_e);

        $t_inFa += $desconto_i;
    endforeach;
endif;

$Read->ExeRead("sd_retification, sd_retification_pmp", "WHERE sd_retification.id_db_settings=:ip AND sd_retification.method='NU' AND sd_retification.InvoiceType='NC' AND sd_retification.status=:st AND sd_retification.mes=:m AND sd_retification.ano=:a AND sd_retification_pmp.id_db_settings=:ip AND sd_retification_pmp.status=:st AND sd_retification_pmp.numero=sd_retification.numero AND sd_retification_pmp.InvoiceType='NC'", "ip={$id_db_settings}&st={$ttt}&m={$moundy}&a={$year}");
if($Read->getResult()):
    foreach($Read->getResult() as $fuck):
        $value = ($fuck['quantidade_pmp'] * $fuck['preco_pmp']);
        if($fuck['desconto_pmp'] >= 100):
            $desconto = $fuck['desconto_pmp'];
        else:
            $desconto = ($value * $fuck['desconto_pmp']) / 100;
        endif;
        //$desconto = ($value * $fuck['desconto_pmp']) / 100;
        $taxa = ($value * $fuck['taxa']) / 100;

        $total_i = ($value - $desconto) + $taxa;
        $desconto_e = ($fuck['settings_desc_financ'] * $total_i) / 100;
        $desconto_i = ($total_i - $desconto_e);

        $t_inFa -= $desconto_i;
    endforeach;
endif;

$Read->ExeRead("av_caixa", "WHERE av_caixa.id_db_settings=:ip AND av_caixa.mes=:m AND av_caixa.ano=:a", "ip={$id_db_settings}&m={$moundy}&a={$year}");
if($Read->getResult()):
    foreach($Read->getResult() as $fuck):
        $t_inFa -= $fuck['valor'];
    endforeach;
endif;


// Esse ano

if(date('m') == "01"): $onT = date('12-Y', strtotime('-1 year')); else: $onT = date('m-Y', strtotime('-1 month'));  endif;

$oT = explode('-', $onT);
$moundy = $oT[0];
$year   = $oT[1];

$Read->ExeRead("sd_billing, sd_billing_pmp", "WHERE sd_billing.id_db_settings=:ip AND sd_billing.method='NU' AND sd_billing.InvoiceType='FR' AND sd_billing.status=:st AND sd_billing.mes=:m AND sd_billing.ano=:a AND sd_billing_pmp.id_db_settings=:ip AND sd_billing_pmp.status=:st AND sd_billing_pmp.numero=sd_billing.numero AND sd_billing_pmp.InvoiceType='FR'", "ip={$id_db_settings}&st={$ttt}&m={$moundy}&a={$year}");
if($Read->getResult()):
    foreach($Read->getResult() as $fuck):
        $value = ($fuck['quantidade_pmp'] * $fuck['preco_pmp']);
        if($fuck['desconto_pmp'] >= 100):
            $desconto = $fuck['desconto_pmp'];
        else:
            $desconto = ($value * $fuck['desconto_pmp']) / 100;
        endif;
        //$desconto = ($value * $fuck['desconto_pmp']) / 100;
        $taxa = ($value * $fuck['taxa']) / 100;

        $total_i = ($value - $desconto) + $taxa;
        $desconto_e = ($fuck['settings_desc_financ'] * $total_i) / 100;
        $desconto_i = ($total_i - $desconto_e);

        $t_inFu += $desconto_i;
    endforeach;
endif;

$Read->ExeRead("sd_billing", "WHERE sd_billing.id_db_settings=:ip AND sd_billing.method='ALL' AND sd_billing.InvoiceType='FR' AND sd_billing.status=:st AND sd_billing.mes=:m AND sd_billing.ano=:a ", "ip={$id_db_settings}&st={$ttt}&m={$moundy}&a={$year}");
if($Read->getResult()):
    foreach($Read->getResult() as $fuck):
        $t_inFu += $fuck['numerario'];
    endforeach;
endif;

$Read->ExeRead("av_entrada_e_saida", "WHERE av_entrada_e_saida.id_db_settings=:ip AND av_entrada_e_saida.method='NU' AND av_entrada_e_saida.mes=:m AND av_entrada_e_saida.ano=:a", "ip={$id_db_settings}&m={$moundy}&a={$year}");
if($Read->getResult()):
    foreach($Read->getResult() as $fuck):
        if($fuck['type'] == "Entrada"):
            $t_inFu += $fuck['valor'];
        else:
            $t_inFu -= $fuck['valor'];
        endif;
    endforeach;
endif;

$Read->ExeRead("sd_retification, sd_retification_pmp", "WHERE sd_retification.id_db_settings=:ip AND sd_retification.method='NU' AND sd_retification.InvoiceType='RC' AND sd_retification.status=:st AND sd_retification.mes=:m AND sd_retification.ano=:a AND sd_retification_pmp.id_db_settings=:ip AND sd_retification_pmp.status=:st AND sd_retification_pmp.numero=sd_retification.numero AND sd_retification_pmp.InvoiceType='RC'", "ip={$id_db_settings}&st={$ttt}&m={$moundy}&a={$year}");
if($Read->getResult()):
    foreach($Read->getResult() as $fuck):
        $value = ($fuck['quantidade_pmp'] * $fuck['preco_pmp']);
        if($fuck['desconto_pmp'] >= 100):
            $desconto = $fuck['desconto_pmp'];
        else:
            $desconto = ($value * $fuck['desconto_pmp']) / 100;
        endif;
        //$desconto = ($value * $fuck['desconto_pmp']) / 100;
        $taxa = ($value * $fuck['taxa']) / 100;

        $total_i = ($value - $desconto) + $taxa;
        $desconto_e = ($fuck['settings_desc_financ'] * $total_i) / 100;
        $desconto_i = ($total_i - $desconto_e);

        $t_inFu += $desconto_i;
    endforeach;
endif;

$Read->ExeRead("sd_retification, sd_retification_pmp", "WHERE sd_retification.id_db_settings=:ip AND sd_retification.method='NU' AND sd_retification.InvoiceType='NC' AND sd_retification.status=:st AND sd_retification.mes=:m AND sd_retification.ano=:a AND sd_retification_pmp.id_db_settings=:ip AND sd_retification_pmp.status=:st AND sd_retification_pmp.numero=sd_retification.numero AND sd_retification_pmp.InvoiceType='NC'", "ip={$id_db_settings}&st={$ttt}&m={$moundy}&a={$year}");
if($Read->getResult()):
    foreach($Read->getResult() as $fuck):
        $value = ($fuck['quantidade_pmp'] * $fuck['preco_pmp']);
        if($fuck['desconto_pmp'] >= 100):
            $desconto = $fuck['desconto_pmp'];
        else:
            $desconto = ($value * $fuck['desconto_pmp']) / 100;
        endif;
        //$desconto = ($value * $fuck['desconto_pmp']) / 100;
        $taxa = ($value * $fuck['taxa']) / 100;

        $total_i = ($value - $desconto) + $taxa;
        $desconto_e = ($fuck['settings_desc_financ'] * $total_i) / 100;
        $desconto_i = ($total_i - $desconto_e);

        $t_inFu -= $desconto_i;
    endforeach;
endif;

$Read->ExeRead("av_caixa", "WHERE av_caixa.id_db_settings=:ip AND av_caixa.mes=:m AND av_caixa.ano=:a", "ip={$id_db_settings}&m={$moundy}&a={$year}");
if($Read->getResult()):
    foreach($Read->getResult() as $fuck):
        $t_inFu -= $fuck['valor'];
    endforeach;
endif;
?>
<div class="row align-items-center" style="margin-bottom: 10px!important;">
    <div class="col-md-6 col-xl-3">
        <a class="card card-link" href="#">
            <div class="card-body">
                <div class="row">
                    <div class="col-auto">
                        <span class="avatar rounded"> <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M16.7 8a3 3 0 0 0 -2.7 -2h-4a3 3 0 0 0 0 6h4a3 3 0 0 1 0 6h-4a3 3 0 0 1 -2.7 -2" /><path d="M12 3v3m0 12v3" /></span>
                    </div>
                    <div class="col">
                        <div class="font-weight-medium">Hoje</div>
                        <div class="text-muted" style="color: #313030!important;"><?= str_replace(",", ".", number_format($t_inFo, 2)); ?> AOA</div>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-6 col-xl-3">
        <a class="card card-link" href="#">
            <div class="card-body">
                <div class="row">
                    <div class="col-auto">
                        <span class="avatar rounded"> <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M16.7 8a3 3 0 0 0 -2.7 -2h-4a3 3 0 0 0 0 6h4a3 3 0 0 1 0 6h-4a3 3 0 0 1 -2.7 -2" /><path d="M12 3v3m0 12v3" /></span>
                    </div>
                    <div class="col">
                        <div class="font-weight-medium">Ontem</div>
                        <div class="text-muted" style="color: #313030!important;"><?= str_replace(",", ".", number_format($t_inFe, 2)); ?> AOA</div>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-6 col-xl-3">
        <a class="card card-link" href="#">
            <div class="card-body">
                <div class="row">
                    <div class="col-auto">
                        <span class="avatar rounded"> <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M16.7 8a3 3 0 0 0 -2.7 -2h-4a3 3 0 0 0 0 6h4a3 3 0 0 1 0 6h-4a3 3 0 0 1 -2.7 -2" /><path d="M12 3v3m0 12v3" /></span>
                    </div>
                    <div class="col">
                        <div class="font-weight-medium">Esse mês</div>
                        <div class="text-muted" style="color: #313030!important;"><?= str_replace(",", ".", number_format($t_inFa, 2)); ?> AOA</div>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-6 col-xl-3">
        <a class="card card-link" href="#">
            <div class="card-body">
                <div class="row">
                    <div class="col-auto">
                        <span class="avatar rounded"> <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M16.7 8a3 3 0 0 0 -2.7 -2h-4a3 3 0 0 0 0 6h4a3 3 0 0 1 0 6h-4a3 3 0 0 1 -2.7 -2" /><path d="M12 3v3m0 12v3" /></span>
                    </div>
                    <div class="col">
                        <div class="font-weight-medium">Mês passado</div>
                        <div class="text-muted" style="color: #313030!important;"><?= str_replace(",", ".", number_format($t_inFu, 2)); ?> AOA</div>
                    </div>
                </div>
            </div>
        </a>
    </div>
</div><br/>

<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Relatório de vendas</h3>&nbsp;
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Data Inicio</label>
                        <?php $null = array(); $read->ExeRead("db_kwanzar", "WHERE id=:id", "id={$id_db_kwanzar}"); if($read->getResult()):$null = $read->getResult()[0];endif; ?>
                        <input type="date" id="dateI" class="form-control" placeholder="Data Fnicial"/>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Data Final</label>
                        <input type="date" id="dateF" class="form-control" placeholder="Data Final"/>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Pagamento</label>
                        <select class="form-control" id="method_id">
                            <option selected value="all">todos metodos de pagamento</option>
                            <option value="CD">Cartão de Debito</option>
                            <option value="NU">Numerário</option>
                            <option value="TB">Transferência Bancária</option>
                            <option value="MB">Referência de pagamentos para Multicaixa</option>
                            <option value="OU">Outros Meios Aqui não Assinalados</option>
                            <option value="ALL">Diversificado</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Documento</label>
                        <select class="form-control" id="TypeDoc">
                            <option value="CO" selected>Documentos comercial</option>
                            <option value="RT">Documentos de retificação</option>
                            <option value="TM">Todos os documentos juntos</option>
                            <optgroup label="Modo especialista">
                                <option value="FR">Factura/Recibo</option>
                                <option value="FT">Factura</option>
                                <option value="NC">Nota de credito</option>
                                <option value="RG">Recibo</option>
                            </optgroup>
                        </select>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Categoria</label>
                        <select class="form-control" id="Categories_id">
                            <option value="all">Todas Categorias </option>
                            <?php
                            $read->ExeRead("cv_category", "WHERE id_db_settings=:i ORDER BY category_title ASC", "i={$id_db_settings}");
                            if($read->getResult()):
                                foreach($read->getResult() as $key):
                                    extract($key);
                                    ?>
                                    <option value="<?= $key['id_xxx']; ?>"><?= $key['category_title']; ?></option>
                                <?php
                                endforeach;
                            endif;
                            ?>
                        </select>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Itens</label>
                        <select class="form-control" id="Itens_id">
                            <option value="all">Todos Itens </option>
                            <?php
                            $read->ExeRead("cv_product", "WHERE id_db_settings=:i ORDER BY product ASC", "i={$id_db_settings}");
                            if($read->getResult()):
                                foreach($read->getResult() as $key):
                                    extract($key);
                                    ?>
                                    <option value="<?= $key['id']; ?>"><?= $key['product']; ?></option>
                                <?php
                                endforeach;
                            endif;
                            ?>
                        </select>
                    </div>
                </div>


                <div class="col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">T. Itens</label>
                        <select class="form-control" id="Itens_type">
                            <option value = "all">todos tipos de itens</option>
                            <option value = "P">Produto</option>
                            <option value = "S">Serviço</option>
                            <option value = "O">Outros (portes, adiantamentos, etc)</option>
                        </select>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Cliente</label>
                        <select class="form-control" id="Customers_id">
                            <option value="all">Todos Clientes </option>
                            <?php
                            $read->ExeRead("cv_customer", "WHERE id_db_settings=:i ORDER BY nome ASC", "i={$id_db_settings}");
                            if($read->getResult()):
                                foreach($read->getResult() as $key):
                                    extract($key);
                                    ?>
                                    <option value="<?= $key['id']; ?>"><?= $key['nome']; ?></option>
                                <?php
                                endforeach;
                            endif;
                            ?>
                        </select>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Operador</label>
                        <select class="form-control" id="Function_id">
                            <?php if($level >= 3): ?>
                                <option value="all">Todos Usuários</option>
                                <?php
                                $read->ExeRead("db_users", "WHERE id_db_settings=:i ORDER BY name ASC", "i={$id_db_settings}");
                                if($read->getResult()):
                                    foreach($read->getResult() as $key):
                                        extract($key);
                                        ?>
                                        <option value="<?= $key['id']; ?>"><?= $key['name']; ?></option>
                                    <?php
                                    endforeach;
                                endif;
                                ?>
                            <?php else: ?>
                                <option selected value="<?= $userlogin['id']; ?>">Minhas Vendas</option>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>
            </div>

            <hr/>

            <a href="javascript:void()" onclick="KwanzarDocsOne();" class="btn btn-primary">
                Pesquisar
            </a>
        </div>
    </div>
</div>

<br/><div id="Azagia">

</div>
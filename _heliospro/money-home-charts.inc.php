<?php
/**
 * Created by PhpStorm.
 * User: Kwanzar Soft
 * Date: 22/08/2020
 * Time: 00:31
 */

if(DBKwanzar::CheckConfig($id_db_settings) == false || DBKwanzar::CheckConfig($id_db_settings)['JanuarioSakalumbu'] == null): $ttt = 2; else: $ttt = DBKwanzar::CheckConfig($id_db_settings)['JanuarioSakalumbu']; endif;

$day    = date('d');
$moundy = date('m');
$year   = date('Y');

$t_inFo = 0;
$t_inFe = 0;
$t_inFa = 0;
$t_inFu = 0;

$Read = new Read();

$Read->ExeRead("sd_billing, sd_billing_pmp", "WHERE sd_billing.id_db_settings=:ip AND sd_billing.InvoiceType='FR' AND sd_billing.status=:st AND sd_billing.dia=:d AND sd_billing.mes=:m AND sd_billing.ano=:a AND sd_billing_pmp.id_db_settings=:ip AND sd_billing_pmp.status=:st AND sd_billing_pmp.numero=sd_billing.numero AND sd_billing_pmp.InvoiceType='FR'", "ip={$id_db_settings}&st={$ttt}&d={$day}&m={$moundy}&a={$year}");
if($Read->getResult()):
    foreach($Read->getResult() as $fuck):
        $value = ($fuck['quantidade_pmp'] * $fuck['preco_pmp']);
        $desconto = ($value * $fuck['desconto_pmp']) / 100;
        $taxa = ($value * $fuck['taxa']) / 100;

        $total_i = ($value - $desconto) + $taxa;
        $desconto_e = ($fuck['settings_desc_financ'] * $total_i) / 100;
        $desconto_i = ($total_i - $desconto_e);

        $t_inFo += $desconto_i;
    endforeach;
endif;

$Read->ExeRead("sd_retification, sd_retification_pmp", "WHERE sd_retification.id_db_settings=:ip AND sd_retification.InvoiceType='RC' AND sd_retification.status=:st AND sd_retification.dia=:d AND sd_retification.mes=:m AND sd_retification.ano=:a AND sd_retification_pmp.id_db_settings=:ip AND sd_retification_pmp.status=:st AND sd_retification_pmp.numero=sd_retification.numero AND sd_retification_pmp.InvoiceType='RC'", "ip={$id_db_settings}&st={$ttt}&d={$day}&m={$moundy}&a={$year}");
if($Read->getResult()):
    foreach($Read->getResult() as $fuck):
        $value = ($fuck['quantidade_pmp'] * $fuck['preco_pmp']);
        $desconto = ($value * $fuck['desconto_pmp']) / 100;
        $taxa = ($value * $fuck['taxa']) / 100;

        $total_i = ($value - $desconto) + $taxa;
        $desconto_e = ($fuck['settings_desc_financ'] * $total_i) / 100;
        $desconto_i = ($total_i - $desconto_e);

        $t_inFo += $desconto_i;
    endforeach;
endif;

$Read->ExeRead("sd_retification, sd_retification_pmp", "WHERE sd_retification.id_db_settings=:ip AND sd_retification.InvoiceType='NC' AND sd_retification.status=:st AND sd_retification.dia=:d AND sd_retification.mes=:m AND sd_retification.ano=:a AND sd_retification_pmp.id_db_settings=:ip AND sd_retification_pmp.status=:st AND sd_retification_pmp.numero=sd_retification.numero AND sd_retification_pmp.InvoiceType='NC'", "ip={$id_db_settings}&st={$ttt}&d={$day}&m={$moundy}&a={$year}");
if($Read->getResult()):
    foreach($Read->getResult() as $fuck):
        $value = ($fuck['quantidade_pmp'] * $fuck['preco_pmp']);
        $desconto = ($value * $fuck['desconto_pmp']) / 100;
        $taxa = ($value * $fuck['taxa']) / 100;

        $total_i = ($value - $desconto) + $taxa;
        $desconto_e = ($fuck['settings_desc_financ'] * $total_i) / 100;
        $desconto_i = ($total_i - $desconto_e);

        $t_inFo -= $desconto_i;
    endforeach;
endif;

if(date('d') == 1): if(date('m') == "01"): $onT = date('t-12-Y', strtotime('-1 year')); else: $onT = date('t-m-Y', strtotime('-1 month'));  endif; else: $onT = date('d-m-Y', strtotime('-1 day')); endif;

$onT = explode('-', $onT);
$day    = $onT[0];
$moundy = $onT[1];
$year   = $onT[2];

$Read->ExeRead("sd_billing, sd_billing_pmp", "WHERE sd_billing.id_db_settings=:ip AND sd_billing.InvoiceType='FR' AND sd_billing.status=:st AND sd_billing.dia=:d AND sd_billing.mes=:m AND sd_billing.ano=:a AND sd_billing_pmp.id_db_settings=:ip AND sd_billing_pmp.status=:st AND sd_billing_pmp.numero=sd_billing.numero AND sd_billing_pmp.InvoiceType='FR'", "ip={$id_db_settings}&st={$ttt}&d={$day}&m={$moundy}&a={$year}");
if($Read->getResult()):
    foreach($Read->getResult() as $fuck):
        $value = ($fuck['quantidade_pmp'] * $fuck['preco_pmp']);
        $desconto = ($value * $fuck['desconto_pmp']) / 100;
        $taxa = ($value * $fuck['taxa']) / 100;

        $total_i = ($value - $desconto) + $taxa;
        $desconto_e = ($fuck['settings_desc_financ'] * $total_i) / 100;
        $desconto_i = ($total_i - $desconto_e);

        $t_inFe += $desconto_i;
    endforeach;
endif;

$Read->ExeRead("sd_retification, sd_retification_pmp", "WHERE sd_retification.id_db_settings=:ip AND sd_retification.InvoiceType='RC' AND sd_retification.status=:st AND sd_retification.dia=:d AND sd_retification.mes=:m AND sd_retification.ano=:a AND sd_retification_pmp.id_db_settings=:ip AND sd_retification_pmp.status=:st AND sd_retification_pmp.numero=sd_retification.numero AND sd_retification_pmp.InvoiceType='RC'", "ip={$id_db_settings}&st={$ttt}&d={$day}&m={$moundy}&a={$year}");
if($Read->getResult()):
    foreach($Read->getResult() as $fuck):
        $value = ($fuck['quantidade_pmp'] * $fuck['preco_pmp']);
        $desconto = ($value * $fuck['desconto_pmp']) / 100;
        $taxa = ($value * $fuck['taxa']) / 100;

        $total_i = ($value - $desconto) + $taxa;
        $desconto_e = ($fuck['settings_desc_financ'] * $total_i) / 100;
        $desconto_i = ($total_i - $desconto_e);

        $t_inFe += $desconto_i;
    endforeach;
endif;

$Read->ExeRead("sd_retification, sd_retification_pmp", "WHERE sd_retification.id_db_settings=:ip AND sd_retification.InvoiceType='NC' AND sd_retification.status=:st AND sd_retification.dia=:d AND sd_retification.mes=:m AND sd_retification.ano=:a AND sd_retification_pmp.id_db_settings=:ip AND sd_retification_pmp.status=:st AND sd_retification_pmp.numero=sd_retification.numero AND sd_retification_pmp.InvoiceType='NC'", "ip={$id_db_settings}&st={$ttt}&d={$day}&m={$moundy}&a={$year}");
if($Read->getResult()):
    foreach($Read->getResult() as $fuck):
        $value = ($fuck['quantidade_pmp'] * $fuck['preco_pmp']);
        $desconto = ($value * $fuck['desconto_pmp']) / 100;
        $taxa = ($value * $fuck['taxa']) / 100;

        $total_i = ($value - $desconto) + $taxa;
        $desconto_e = ($fuck['settings_desc_financ'] * $total_i) / 100;
        $desconto_i = ($total_i - $desconto_e);

        $t_inFe -= $desconto_i;
    endforeach;
endif;

$moundy = date('m');
$year   = date('Y');

$Read->ExeRead("sd_billing, sd_billing_pmp", "WHERE sd_billing.id_db_settings=:ip AND sd_billing.InvoiceType='FR' AND sd_billing.status=:st AND sd_billing.mes=:m AND sd_billing.ano=:a AND sd_billing_pmp.id_db_settings=:ip AND sd_billing_pmp.status=:st AND sd_billing_pmp.numero=sd_billing.numero AND sd_billing_pmp.InvoiceType='FR'", "ip={$id_db_settings}&st={$ttt}&m={$moundy}&a={$year}");
if($Read->getResult()):
    foreach($Read->getResult() as $fuck):
        $value = ($fuck['quantidade_pmp'] * $fuck['preco_pmp']);
        $desconto = ($value * $fuck['desconto_pmp']) / 100;
        $taxa = ($value * $fuck['taxa']) / 100;

        $total_i = ($value - $desconto) + $taxa;
        $desconto_e = ($fuck['settings_desc_financ'] * $total_i) / 100;
        $desconto_i = ($total_i - $desconto_e);

        $t_inFa += $desconto_i;
    endforeach;
endif;

$Read->ExeRead("sd_retification, sd_retification_pmp", "WHERE sd_retification.id_db_settings=:ip AND sd_retification.InvoiceType='RC' AND sd_retification.status=:st AND sd_retification.mes=:m AND sd_retification.ano=:a AND sd_retification_pmp.id_db_settings=:ip AND sd_retification_pmp.status=:st AND sd_retification_pmp.numero=sd_retification.numero AND sd_retification_pmp.InvoiceType='RC'", "ip={$id_db_settings}&st={$ttt}&m={$moundy}&a={$year}");
if($Read->getResult()):
    foreach($Read->getResult() as $fuck):
        $value = ($fuck['quantidade_pmp'] * $fuck['preco_pmp']);
        $desconto = ($value * $fuck['desconto_pmp']) / 100;
        $taxa = ($value * $fuck['taxa']) / 100;

        $total_i = ($value - $desconto) + $taxa;
        $desconto_e = ($fuck['settings_desc_financ'] * $total_i) / 100;
        $desconto_i = ($total_i - $desconto_e);

        $t_inFa += $desconto_i;
    endforeach;
endif;

$Read->ExeRead("sd_retification, sd_retification_pmp", "WHERE sd_retification.id_db_settings=:ip AND sd_retification.InvoiceType='NC' AND sd_retification.status=:st AND sd_retification.mes=:m AND sd_retification.ano=:a AND sd_retification_pmp.id_db_settings=:ip AND sd_retification_pmp.status=:st AND sd_retification_pmp.numero=sd_retification.numero AND sd_retification_pmp.InvoiceType='NC'", "ip={$id_db_settings}&st={$ttt}&m={$moundy}&a={$year}");
if($Read->getResult()):
    foreach($Read->getResult() as $fuck):
        $value = ($fuck['quantidade_pmp'] * $fuck['preco_pmp']);
        $desconto = ($value * $fuck['desconto_pmp']) / 100;
        $taxa = ($value * $fuck['taxa']) / 100;

        $total_i = ($value - $desconto) + $taxa;
        $desconto_e = ($fuck['settings_desc_financ'] * $total_i) / 100;
        $desconto_i = ($total_i - $desconto_e);

        $t_inFa -= $desconto_i;
    endforeach;
endif;


if(date('m') == "01"): $onT = date('12-Y', strtotime('-1 year')); else: $onT = date('m-Y', strtotime('-1 month'));  endif;

$oT = explode('-', $onT);
$moundy = $oT[0];
$year   = $oT[1];

$Read->ExeRead("sd_billing, sd_billing_pmp", "WHERE sd_billing.id_db_settings=:ip AND sd_billing.InvoiceType='FR' AND sd_billing.status=:st AND sd_billing.mes=:m AND sd_billing.ano=:a AND sd_billing_pmp.id_db_settings=:ip AND sd_billing_pmp.status=:st AND sd_billing_pmp.numero=sd_billing.numero AND sd_billing_pmp.InvoiceType='FR'", "ip={$id_db_settings}&st={$ttt}&m={$moundy}&a={$year}");
if($Read->getResult()):
    foreach($Read->getResult() as $fuck):
        $value = ($fuck['quantidade_pmp'] * $fuck['preco_pmp']);
        $desconto = ($value * $fuck['desconto_pmp']) / 100;
        $taxa = ($value * $fuck['taxa']) / 100;

        $total_i = ($value - $desconto) + $taxa;
        $desconto_e = ($fuck['settings_desc_financ'] * $total_i) / 100;
        $desconto_i = ($total_i - $desconto_e);

        $t_inFu += $desconto_i;
    endforeach;
endif;

$Read->ExeRead("sd_retification, sd_retification_pmp", "WHERE sd_retification.id_db_settings=:ip AND sd_retification.InvoiceType='RC' AND sd_retification.status=:st AND sd_retification.mes=:m AND sd_retification.ano=:a AND sd_retification_pmp.id_db_settings=:ip AND sd_retification_pmp.status=:st AND sd_retification_pmp.numero=sd_retification.numero AND sd_retification_pmp.InvoiceType='RC'", "ip={$id_db_settings}&st={$ttt}&m={$moundy}&a={$year}");
if($Read->getResult()):
    foreach($Read->getResult() as $fuck):
        $value = ($fuck['quantidade_pmp'] * $fuck['preco_pmp']);
        $desconto = ($value * $fuck['desconto_pmp']) / 100;
        $taxa = ($value * $fuck['taxa']) / 100;

        $total_i = ($value - $desconto) + $taxa;
        $desconto_e = ($fuck['settings_desc_financ'] * $total_i) / 100;
        $desconto_i = ($total_i - $desconto_e);

        $t_inFu += $desconto_i;
    endforeach;
endif;

$Read->ExeRead("sd_retification, sd_retification_pmp", "WHERE sd_retification.id_db_settings=:ip AND sd_retification.InvoiceType='NC' AND sd_retification.status=:st AND sd_retification.mes=:m AND sd_retification.ano=:a AND sd_retification_pmp.id_db_settings=:ip AND sd_retification_pmp.status=:st AND sd_retification_pmp.numero=sd_retification.numero AND sd_retification_pmp.InvoiceType='NC'", "ip={$id_db_settings}&st={$ttt}&m={$moundy}&a={$year}");
if($Read->getResult()):
    foreach($Read->getResult() as $fuck):
        $value = ($fuck['quantidade_pmp'] * $fuck['preco_pmp']);
        $desconto = ($value * $fuck['desconto_pmp']) / 100;
        $taxa = ($value * $fuck['taxa']) / 100;

        $total_i = ($value - $desconto) + $taxa;
        $desconto_e = ($fuck['settings_desc_financ'] * $total_i) / 100;
        $desconto_i = ($total_i - $desconto_e);

        $t_inFu -= $desconto_i;
    endforeach;
endif;
?>

<div class="row row-card-no-pd">
    <div class="col-sm-6 col-md-3">
        <div class="card card-stats card-round">
            <div class="card-body ">
                <div class="row">
                    <div class="col-5">
                        <div class="icon-big text-center">
                            <i class="flaticon-chart-pie text-warning"></i>
                        </div>
                    </div>
                    <div class="col-7 col-stats">
                        <div class="numbers">
                            <p class="card-category">Hoje</p>
                            <h4 class="card-title"><?= number_format($t_inFo, 2); ?></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-3">
        <div class="card card-stats card-round">
            <div class="card-body ">
                <div class="row">
                    <div class="col-5">
                        <div class="icon-big text-center">
                            <i class="flaticon-coins text-success"></i>
                        </div>
                    </div>
                    <div class="col-7 col-stats">
                        <div class="numbers">
                            <p class="card-category">Ontem</p>
                            <h4 class="card-title"><?= number_format($t_inFe, 2); ?></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-3">
        <div class="card card-stats card-round">
            <div class="card-body">
                <div class="row">
                    <div class="col-5">
                        <div class="icon-big text-center">
                            <i class="flaticon-coins text-primary"></i>
                        </div>
                    </div>
                    <div class="col-7 col-stats">
                        <div class="numbers">
                            <p class="card-category">Esse Mês</p>
                            <h4 class="card-title"><?= number_format($t_inFa, 2); ?></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-3">
        <div class="card card-stats card-round">
            <div class="card-body">
                <div class="row">
                    <div class="col-5">
                        <div class="icon-big text-center">
                            <i class="flaticon-coins text-primary"></i>
                        </div>
                    </div>
                    <div class="col-7 col-stats">
                        <div class="numbers">
                            <p class="card-category">Mês Passado</p>
                            <h4 class="card-title"><?= number_format($t_inFu, 2); ?></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
/**
 * Created by PhpStorm.
 * User: Kwanzar Soft
 * Date: 01/10/2020
 * Time: 23:21
 */

$Ativos = 0;
?>

<div class="panel-header bg-primary-gradient">
    <div class="page-inner py-5">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
            <div>
                <h2 class="text-white pb-2 fw-bold">FACE</h2>
                <h5 class="text-white op-7 mb-2">Fundo de Apoio à Catástrofe Emergencial</h5>
            </div>
            <div class="ml-md-auto py-2 py-md-0">
                <a href="javascript:void()" data-toggle="modal" data-target="#UsersConfig" class="btn btn-primary btn-round">Operação</a>
                <a href="" class="btn btn-secondary btn-round">Relatórios</a>
            </div>
        </div>
    </div>
</div>

<div class="page-inner">
    <div class="row">
        <?php
            $Read = new Read();
            $Read->ExeRead("ec_saldos");

            if($Read->getResult()):
                foreach($Read->getResult() as $key):
                    extract($key);

                    $Ativos += $key['ENTRADA'];
                    ?>
                    <div class="col-sm-8 col-md-4">
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
                                            <p class="card-category">Existência</p>
                                            <h4 class="card-title"><?= number_format($key['ENTRADA'], 2);?></h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-8 col-md-4">
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
                                            <p class="card-category">Face</p>
                                            <h4 class="card-title"><?= number_format($key['FACE'], 2);?></h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-8 col-md-4">
                        <div class="card card-stats card-round">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-5">
                                        <div class="icon-big text-center">
                                            <i class="flaticon-error text-danger"></i>
                                        </div>
                                    </div>
                                    <div class="col-7 col-stats">
                                        <div class="numbers">
                                            <p class="card-category">Saída</p>
                                            <h4 class="card-title"><?= number_format($key['SAIDA'], 2);?></h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                endforeach;
            endif;
        ?>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="htmlLegendsChart"></canvas>
                    </div>
                    <div id="myChartLegend"></div>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-6 col-sm-6 col-lg-4">
            <div class="card">
                <div class="card-body p-3 text-center">
                    <div class="text-right text-success">
                        50%
                        <i class="fa fa-chevron-up"></i>
                    </div>
                    <div class="h1 m-0"><?php $f = ($Ativos * 50 ) / 100; echo number_format($f, 2);   ?></div>
                    <div class="text-muted mb-3">FACE</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-sm-6 col-lg-4">
            <div class="card">
                <div class="card-body p-3 text-center">
                    <div class="text-right text-danger">
                        35%
                        <i class="fa fa-chevron-down"></i>
                    </div>
                    <div class="h1 m-0"><?php $d = ($Ativos * 35 ) / 100; echo number_format($d, 2);   ?></div>
                    <div class="text-muted mb-3">RENDA</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-sm-6 col-lg-4">
            <div class="card">
                <div class="card-body p-3 text-center">
                    <div class="text-right text-success">
                        15%
                        <i class="fa fa-chevron-up"></i>
                    </div>
                    <div class="h1 m-0"><?php $e = ($Ativos * 15 ) / 100; echo number_format($e, 2);   ?></div>
                    <div class="text-muted mb-3">ECONOMIA</div>
                </div>
            </div>
        </div>
    </div>
</div>
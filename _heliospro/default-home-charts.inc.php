<?php
/**
 * Created by PhpStorm.
 * User: Kwanzar Soft
 * Date: 05/06/2020
 * Time: 13:12
 */


$suspenso = 0;
if(DBKwanzar::CheckConfig($id_db_settings) == false || DBKwanzar::CheckConfig($id_db_settings)['JanuarioSakalumbu'] == null): $ttt = 2; else: $ttt = DBKwanzar::CheckConfig($id_db_settings)['JanuarioSakalumbu']; endif;

$year = date('Y');
$mount = date('m');
$n1 = "sd_billing";
$n2 = "sd_billing_pmp";
$n3 = "sd_retification";
$n4 = "sd_retification_pmp";

$t_fr = 0;
$t_ft = 0;
$t_nc = 0;
$t_nr = 0;
$t_im = 0;
$t_taxa = 0;

$read = new Read();
?>
<?php if($level >= 3): ?>
    <div class="row">
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">
                    <div class="card-title"><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Estatística de documentos comerciais produzido ao decorrer do ano."; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "商业文件统计"; endif; ?></div>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="htmlLegendsChart"></canvas>
                    </div>
                    <div id="myChartLegend"></div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="col-sm-12">
                <div class="card p-3">
                    <div class="d-flex align-items-center">
                    <span class="stamp stamp-md bg-success mr-3">
                        <i class="fa fa-shopping-cart"></i>
                    </span>
                        <div>
                            <?php
                            $read->ExeRead("cv_customer", "WHERE id_db_settings=:i", "i={$id_db_settings}");
                            ?>
                            <h5 class="mb-1"><b><a href="#"><?= $read->getRowCount()?></a></b></h5>
                            <small class="text-muted"><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Clinetes"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "客户"; endif; ?></small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="card p-3">
                    <div class="d-flex align-items-center">
                    <span class="stamp stamp-md bg-danger mr-3">
                        <i class="fa fa-users"></i>
                    </span>
                        <div>
                            <?php
                            $read->ExeRead("db_users", "WHERE id_db_settings=:i", "i={$id_db_settings}");
                            ?>
                            <h5 class="mb-1"><b><a href="#"><?= $read->getRowCount()?></b></h5>
                            <small class="text-muted">Usuários</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="card p-3">
                    <div class="d-flex align-items-center">
                    <span class="stamp stamp-md bg-warning mr-3">
                        <i class="fa fa-comment-alt"></i>
                    </span>
                        <div>
                            <?php
                            $read->ExeRead("cv_supplier", "WHERE id_db_settings=:i", "i={$id_db_settings}");
                            ?>
                            <h5 class="mb-1"><b><a href="#"><?= $read->getRowCount(); ?></a></b></h5>
                            <small class="text-muted"><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Fornecedores"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "供应商 "; endif; ?></small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">
                    <div class="card-title"><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Estatística de documentos comerciais produzido ao decorrer do mês."; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "商业文件统计本月的生产"; endif; ?></div>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="multipleLineChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">

        </div>
    </div>

    <div class="row">
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">
                    <div class="card-title"><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Itens mais comercializados"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "大多数营销项目"; endif; ?></div>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="barCharts2"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">

        </div>
    </div>

    <div class="row">
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">
                    <div class="card-title"><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Melhores vendedores"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "最畅销"; endif; ?></div>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="barCharts3"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">

        </div>
    </div>
<?php endif; ?>

<div class="row">
    <div class="col-md-9">
        <div class="card">
            <div class="card-header">
                <div class="card-title"><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Clientes mais populares"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "最受欢迎的客户"; endif; ?></div>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="barChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>


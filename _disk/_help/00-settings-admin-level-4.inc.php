<div class="row row-cards">
    <div class="page-header d-print-none">
        <div class="row align-items-center">
            <div class="col">
                <div class="page-pretitle">
                    ProSmart
                </div>
                <h2 class="page-title">
                    Área do Desenvolvidor
                </h2>
            </div>
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    <a href="_disk/_help/9cb8af3f5c58553c270412eb3d751fc3.inc.e.php" target="_blank" class="btn btn-primary d-none d-sm-inline-block">Backup de e-mail's</a>
                    <a href="_disk/_help/402051f4be0cc3aad33bcf3ac3d6532b.inc.b.php" target="_blank" class="btn btn-primary d-none d-sm-inline-block">Backup do sistema</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row align-items-center" style="margin-bottom: 10px!important;">

    <div class="col-md-6 col-xl-3">
        <div class="card card-sm">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <span class="bg-primary text-white avatar">
<!-- Download SVG icon from http://tabler-icons.io/i/archive -->
	<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><rect x="3" y="4" width="18" height="4" rx="2" /><path d="M5 8v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-10" /><line x1="10" y1="12" x2="14" y2="12" /></svg>
                        </span>
                    </div>
                    <div class="col">
                        <div class="font-weight-medium">
                            Empresas
                        </div>
                        <div class="text-muted"  style="color: #313030!important;">
                            <?php $System->ExeRead("db_settings"); ?>
                            <?= $System->getRowCount(); ?>
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
                        <span class="bg-primary text-white avatar">
                        <!-- Download SVG icon from http://tabler-icons.io/i/database -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><ellipse cx="12" cy="6" rx="8" ry="3"></ellipse><path d="M4 6v6a8 3 0 0 0 16 0v-6" /><path d="M4 12v6a8 3 0 0 0 16 0v-6" /></svg>
                        </span>
                    </div>
                    <div class="col">
                        <div class="font-weight-medium">
                            Usuários
                        </div>
                        <div class="text-muted"  style="color: #313030!important;">
                            <?php $System->ExeRead("db_users"); ?>
                            <?= $System->getRowCount(); ?>
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
                        <span class="bg-warning text-white avatar">
<!-- Download SVG icon from http://tabler-icons.io/i/database -->
	<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><ellipse cx="12" cy="6" rx="8" ry="3"></ellipse><path d="M4 6v6a8 3 0 0 0 16 0v-6" /><path d="M4 12v6a8 3 0 0 0 16 0v-6" /></svg>
                        </span>
                    </div>
                    <div class="col">
                        <div class="font-weight-medium">
                            Clientes
                        </div>
                        <div class="text-muted"  style="color: #313030!important;">
                            <?php $System->ExeRead("cv_customer"); ?>
                            <?= $System->getRowCount(); ?>
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
                        <span class="bg-primary text-white avatar">
                            <!-- Download SVG icon from http://tabler-icons.io/i/database -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><ellipse cx="12" cy="6" rx="8" ry="3"></ellipse><path d="M4 6v6a8 3 0 0 0 16 0v-6" /><path d="M4 12v6a8 3 0 0 0 16 0v-6" /></svg>
                        </span>
                    </div>
                    <div class="col">
                        <div class="font-weight-medium">
                            Fornecedores
                        </div>
                        <div class="text-muted"  style="color: #313030!important;">
                            <?php $System->ExeRead("cv_supplier"); ?>
                            <?= $System->getRowCount(); ?>
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
                        <span class="bg-primary text-white avatar">
<!-- Download SVG icon from http://tabler-icons.io/i/device-analytics -->
	<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><rect x="3" y="4" width="18" height="12" rx="1" /><line x1="7" y1="20" x2="17" y2="20" /><line x1="9" y1="16" x2="9" y2="20" /><line x1="15" y1="16" x2="15" y2="20" /><path d="M8 12l3 -3l2 2l3 -3" /></svg>
                        </span>
                    </div>
                    <div class="col">
                        <div class="font-weight-medium">
                            Documentos comercial
                        </div>
                        <div class="text-muted"  style="color: #313030!important;">
                            <?php $System->ExeRead("sd_billing"); ?>
                            <?= $System->getRowCount(); ?>
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
                        <span class="bg-green text-white avatar">

                        </span>
                    </div>
                    <div class="col">
                        <div class="font-weight-medium">
                            Documentos retificado
                        </div>
                        <div class="text-muted"  style="color: #313030!important;">
                            <?php $System->ExeRead("sd_retification"); ?>
                            <?= $System->getRowCount(); ?>
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
                        <span class="bg-green text-white avatar">

                        </span>
                    </div>
                    <div class="col">
                        <div class="font-weight-medium">
                            Taxas de imposto
                        </div>
                        <div class="text-muted"  style="color: #313030!important;">
                            <?php $System->ExeRead("db_taxtable"); ?>
                            <?= $System->getRowCount(); ?>
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
                        <span class="bg-green text-white avatar">

                        </span>
                    </div>
                    <div class="col">
                        <div class="font-weight-medium">
                            Licenças activas
                        </div>
                        <div class="text-muted"  style="color: #313030!important;">
                            <?php $System->ExeRead("ws_times", "WHERE status=1"); ?>
                            <?= $System->getRowCount(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row row-cards">
    <div class="col-lg-12 col-xl-12">
        <div class="card">
            <div class="card-body">
                <div id="chart-completion-tasks-3"></div>
            </div>
        </div>
    </div>
</div>

<?php
$dn1 = date('d');
$dn2 = date('m');
$dn3 = date('Y');

$read = new Read();
$read->ExeRead("site_views_static", "WHERE dia={$dn1} AND mes={$dn2} AND ano={$dn3}");
?>

<div class="row align-items-center" style="margin-bottom: 10px!important;">

    <div class="col-md-6 col-xl-3">
        <div class="card card-sm">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <span class="bg-primary text-white avatar">
<!-- Download SVG icon from http://tabler-icons.io/i/archive -->
	<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><rect x="3" y="4" width="18" height="4" rx="2" /><path d="M5 8v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-10" /><line x1="10" y1="12" x2="14" y2="12" /></svg>
                        </span>
                    </div>
                    <div class="col">
                        <div class="font-weight-medium">
                            Esse Mês
                        </div>
                        <div class="text-muted">
                            <?php $read->ExeRead("site_views_static", "WHERE mes={$dn2} AND ano={$dn3}"); ?>
                            <?= $read->getRowCount(); ?>
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
                        <span class="bg-primary text-white avatar">
                        <!-- Download SVG icon from http://tabler-icons.io/i/database -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><ellipse cx="12" cy="6" rx="8" ry="3"></ellipse><path d="M4 6v6a8 3 0 0 0 16 0v-6" /><path d="M4 12v6a8 3 0 0 0 16 0v-6" /></svg>
                        </span>
                    </div>
                    <div class="col">
                        <div class="font-weight-medium">
                            Esse ano
                        </div>
                        <div class="text-muted">
                            <?php $read->ExeRead("site_views_static", "WHERE ano={$dn3}"); ?>
                            <?= $read->getRowCount(); ?>
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
                        <span class="bg-warning text-white avatar">
<!-- Download SVG icon from http://tabler-icons.io/i/database -->
	<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><ellipse cx="12" cy="6" rx="8" ry="3"></ellipse><path d="M4 6v6a8 3 0 0 0 16 0v-6" /><path d="M4 12v6a8 3 0 0 0 16 0v-6" /></svg>
                        </span>
                    </div>
                    <div class="col">
                        <div class="font-weight-medium">
                            Geral
                        </div>
                        <div class="text-muted">
                            <?php $read->ExeRead("site_views_static"); ?>
                            <?= $read->getRowCount(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row row-cards">
    <div class="col-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex">
                    <?php
                    if(date('m') <= 9): $xYz =ltrim(date('m'), '0'); else: $xYz = date('m'); endif;
                    $Meses = ["", "Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"]; ?>
                    <h3 class="card-title">Facturação do mês de <?= $Meses[$xYz]; ?> de <?= date('Y'); ?></h3>
                </div>
                <div id="chart-line-stroke"></div>
            </div>
        </div>
    </div><br/>
    <div class="col-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex">
                    <h3 class="card-title">Exercício do ano de <?= date('Y'); ?></h3>
                </div>
                <div id="chart-social-referrals"></div>
            </div>
        </div>
    </div>
</div>

<br/><div class="row">
    <div class="col-lg-12 col-xl-12">
        <div class="card">
            <div class="card-body">
                <div id="chart-temperature"></div>
            </div>
        </div>
    </div>
</div>
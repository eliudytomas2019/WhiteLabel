<br/><div class="row row-cards">
    <div class="col-lg-4 col-xl-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex">
                    <h3 class="card-title"><?php if($DB->CheckCpanelAndSettings($id_db_settings, $id_db_kwanzar)['atividade'] >= 19): ?>Passe que mais comparece<?php else: ?>Top Clientes<?php endif; ?></h3>
                </div>
                <div id="chart-demo-pie"></div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-xl-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex">
                    <h3 class="card-title"><?php if($DB->CheckCpanelAndSettings($id_db_settings, $id_db_kwanzar)['atividade'] >= 19): ?>Profissional que mais atendeu<?php else: ?>Top Vendedores<?php endif; ?></h3>
                </div>
                <div id="chart-completion-tasks"></div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-xl-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex">
                    <h3 class="card-title"><?php if($DB->CheckCpanelAndSettings($id_db_settings, $id_db_kwanzar)['atividade'] >= 19): ?>Procedimento mais usado<?php else: ?>Top Itens<?php endif; ?></h3>
                </div>
                <div id="chart-completion-tasks-6"></div>
            </div>
        </div>
    </div>
</div>
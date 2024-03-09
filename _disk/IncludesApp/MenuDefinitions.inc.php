<div class="d-none d-lg-block col-lg-3">
    <ul class="nav nav-pills nav-vertical">
        <?php if($DB->CheckCpanelAndSettings($id_db_settings, $id_db_kwanzar)['atividade'] == 19): ?>
            <li class="nav-item"><a href="#" class="nav-link" style="font-weight: bold!important;">Configurações da Clínica</a></li>

            <?php if($level >= 4): ?>
                <li class="nav-item"><a href="panel.php?exe=definitions/index_porcentagem<?= $n; ?>" class="nav-link <?php if(in_array("index_porcentagem", $linkto)) echo "active"; ?>">Porcentagem de Ganhos (Médicos)</a></li>
            <?php endif; ?>

            <?php if($level == 1 || $level >= 4): ?>
                <li class="nav-item"><a href="panel.php?exe=definitions/index_category<?= $n; ?>" class="nav-link <?php if(in_array("index_category", $linkto) || in_array("category_update", $linkto)) echo "active"; ?>">Categorias dos procedimentos</a></li>
                <li class="nav-item"><a href="panel.php?exe=definitions/index<?= $n; ?>" class="nav-link <?php if(in_array("index", $linkto)  || in_array("create", $linkto) || in_array("update", $linkto)) echo "active"; ?>">Procedimentos</a></li>
            <?php endif; ?>

            <?php if($level == 2 || $level >= 4): ?>
                <li class="nav-item"><a href="panel.php?exe=fixos/indexx<?= $n; ?>" class="nav-link <?php if(in_array("fixos", $linkto)) echo "active"; ?>">Inventário dos Materiais Fixos</a></li>
                <li class="nav-item"><a href="panel.php?exe=relatorios_fixos/relatorios_fixos<?= $n; ?>" class="nav-link <?php if(in_array("relatorios_fixos", $linkto)) echo "active"; ?>">Relatório dos Materiais Fixos</a></li>
            <?php endif; ?>
        <?php endif; ?>
    </ul>
</div>
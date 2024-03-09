<div class="d-none d-lg-block col-lg-3">
    <ul class="nav nav-pills nav-vertical">
        <?php
        if($DB->CheckCpanelAndSettings($id_db_settings, $id_db_kwanzar)['atividade'] == 1 || $DB->CheckCpanelAndSettings($id_db_settings, $id_db_kwanzar)['atividade'] == 3):
            $xLevel = $level >= 3;
        endif;

        if($DB->CheckCpanelAndSettings($id_db_settings, $id_db_kwanzar)['atividade'] == 19):
            $xLevel = $level >= 4;
        endif;

        if($xLevel): ?>
            <li class="nav-item"><a href="#" class="nav-link" style="font-weight: bold!important;">Configurações</a></li>
            <li class="nav-item"><a href="panel.php?exe=settings/System_Settings<?= $n; ?>" class="nav-link <?php if(in_array("System_Settings", $linkto)) echo "active"; ?>">Configurações do sistema</a></li>
            <li class="nav-item"><a href="panel.php?exe=settings/company<?= $n; ?>" class="nav-link <?php if(in_array("company", $linkto)) echo "active"; ?>">Dados da empresa</a></li>
            <li class="nav-item"><a href="panel.php?exe=settings/BankData<?= $n; ?>" class="nav-link <?php if(in_array("BankData", $linkto)) echo "active"; ?>">Dados bancário</a></li>
            <li class="nav-item"><a href="panel.php?exe=settings/logotype<?= $n; ?>" class="nav-link <?php if(in_array("logotype", $linkto)) echo "active"; ?>">Logotipo</a></li>
            <?php if($DB->CheckCpanelAndSettings($id_db_settings, $id_db_kwanzar)['atividade'] == 1 || $DB->CheckCpanelAndSettings($id_db_settings, $id_db_kwanzar)['atividade'] == 3): ?>
                <li class="nav-item"><a href="panel.php?exe=settings/gallery<?= $n; ?>" class="nav-link <?php if(in_array("gallery", $linkto)) echo "active"; ?>">Galeria</a></li>
            <?php endif; ?>
            <li class="nav-item"><a href="panel.php?exe=settings/taxtable<?= $n; ?>" class="nav-link <?php if(in_array("taxtable", $linkto)) echo "active"; ?>">Impostos</a></li>

            <li class="nav-item"><a href="#" class="nav-link" style="font-weight: bold!important;">Funcionalidades</a></li>
            <?php if($Beautiful["ps3"] != 0): ?>
                <li class="nav-item"><a href="panel.php?exe=settings/import<?= $n; ?>" class="nav-link <?php if(in_array("import", $linkto)) echo "active"; ?>">Importaçāo & Exportaçāo de dados</a></li>
                <li class="nav-item"><a href="panel.php?exe=settings/export_saft<?= $n; ?>" class="nav-link <?php if(in_array("export_saft", $linkto)) echo "active"; ?>">Exportação de SAFT</a></li>
            <?php endif; ?>

            <li class="nav-item"><a href="panel.php?exe=settings/notifications<?= $n; ?>" class="nav-link <?php if(in_array("notifications", $linkto)) echo "active"; ?>">Notificações</a></li>
            <li class="nav-item"><a href="panel.php?exe=settings/activity<?= $n; ?>" class="nav-link <?php if(in_array("activity", $linkto)) echo "active"; ?>">Registro de atividade</a></li>

            <li class="nav-item"><a href="panel.php?exe=settings/licence<?= $n; ?>" class="nav-link <?php if(in_array("licence", $linkto)) echo "active"; ?>">Licença</a></li>
            <li class="nav-item"><a href="#" class="nav-link" style="font-weight: bold!important;">Gerir Utilizadores</a></li>
            <?php if($Beautiful["ps3"] != 0 || $level == 5): ?>
                <li class="nav-item"><a href="panel.php?exe=settings/users<?= $n; ?>" class="nav-link <?php if(in_array("users", $linkto) || in_array("CreateUsers", $linkto) || in_array("UpdateUsers", $linkto)) echo "active"; ?>">Utilizadores</a></li>
            <?php endif; ?>
        <?php endif; ?>
        <li class="nav-item"><a href="panel.php?exe=settings/account_configurations<?= $n; ?>" class="nav-link <?php if(in_array("account_configurations", $linkto)) echo "active"; ?>">Preferências do usuário</a></li>
        <li class="nav-item"><a href="panel.php?exe=settings/profile<?= $n; ?>" class="nav-link <?php if(in_array("profile", $linkto)) echo "active"; ?>">Meu perfil</a></li>
        <li class="nav-item"><a href="?logoff=true" class="nav-link">Terminar sessão</a></li>
    </ul>
</div>
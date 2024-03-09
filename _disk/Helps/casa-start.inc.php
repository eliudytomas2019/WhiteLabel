<br/><div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-3">
                    <img src="uploads/<?= $Index['logotype']; ?>" alt="Projects Dashboards" class="rounded">
                </div>
                <div class="col">
                    <h3 class="card-title mb-1">
                        <?php $name = explode(" ", $userlogin["name"]); ?>
                        <?= $name[0]; ?>, chegou ao <?= $Index['name']; ?>!<br/>
                        Vamos ajudar a configurar a sua conta.
                    </h3>
                    <div class="text-muted" style="color: <?= $Index['color_41']; ?>!important;">
                        Personalize o software de faturação
                    </div>
                    <div class="mt-3">
                        <?php
                        $counting = 0;

                        $Read = new Read();

                        $Read->ExeRead("db_settings", "WHERE id=:i ", "i={$id_db_settings}");
                        if($Read->getResult()):
                            if($Read->getResult()[0]['cef'] == 1): $counting += 25; endif;
                        endif;

                        $Read->ExeRead("db_settings", "WHERE id=:i ", "i={$id_db_settings}");
                        if($Read->getResult()):
                            if($Read->getResult()[0]['cef_nib'] == 1): $counting += 25; endif;
                        endif;

                        $Read->ExeRead("db_config", "WHERE id_db_settings=:i ", "i={$id_db_settings}");
                        if($Read->getResult()):
                            if($Read->getResult()[0]['cef'] == 1): $counting += 25; endif;
                        endif;

                        $Read->ExeRead("db_users_settings", "WHERE id_db_settings=:i ", "i={$id_db_settings}");
                        if($Read->getResult()):
                            if($Read->getResult()[0]['cef'] == 1): $counting += 25; endif;
                        endif;
                        ?>
                        <div class="row g-2 align-items-center">
                            <div class="col-auto">
                                <?= $counting; ?>%
                            </div>
                            <div class="col">
                                <div class="progress progress-sm">
                                    <div class="progress-bar" style="width: <?= $counting; ?>%" role="progressbar" aria-valuenow="<?= $counting; ?>" aria-valuemin="0" aria-valuemax="100">
                                        <span class="visually-hidden"><?= $counting; ?>% Completo</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-auto">
                    <div class="dropdown">
                        <a href="#" class="card-dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="1" /><circle cx="12" cy="19" r="1" /><circle cx="12" cy="5" r="1" /></svg>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a href="panel.php?exe=settings/company<?= $n; ?>" class="dropdown-item">Dados da empresa</a>
                            <a href="panel.php?exe=settings/BankData<?= $n; ?>" class="dropdown-item">Dados bancários</a>
                            <a href="panel.php?exe=settings/System_Settings<?= $n; ?>" class="dropdown-item">Definiçōes do sistema</a>
                            <a href="panel.php?exe=settings/account_configurations<?= $n; ?>" class="dropdown-item">Personalizar impressora</a>
                            <?php if(($DB->CheckCpanelAndSettings($id_db_settings, $id_db_kwanzar)['atividade'] >= 1 && $DB->CheckCpanelAndSettings($id_db_settings, $id_db_kwanzar)['atividade'] <= 4) || $DB->CheckCpanelAndSettings($id_db_settings, $id_db_kwanzar)['atividade'] == 9): ?>
                                <a href="panel.php?exe=product/create<?= $n; ?>" class="dropdown-item">Adicionar item</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
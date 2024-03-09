<?php if($level >= 1): ?>
    <div class="nav-item d-none d-md-flex me-3">
        <div class="btn-list">
            <a href="<?php if(isset($n)): ?>panel.php?exe=settings/licence<?= $n; ?><?php else: echo "#"; endif; ?>" class="btn btn-outline-white" style="color: #00345c!important;" rel="noreferrer">
                <?php
                $st = 1;
                $times = null;

                $read = new Read();
                $read->ExeRead("ws_times", "WHERE id_db_kwanzar=:i AND status=:st", "i={$userlogin['id_db_kwanzar']}&st={$st}");
                if($read->getResult()):
                    $times = $read->getResult()[0];
                    $ps3 = $times['plano'];
                    $data_inicial = date('Y-m-d');
                    $data_final = $times['times'];
                    $diferenca = strtotime($data_final) - strtotime($data_inicial);
                    $dias = floor($diferenca / (60 * 60 * 24));
                else:
                    unset($_SESSION['userlogin']);
                    header('Location: _login.php?exe=restrito');
                endif;
                ?>
                FALTAM <?= $dias; ?> DIAS |&nbsp; <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="15" cy="15" r="3" /><path d="M13 17.5v4.5l2 -1.5l2 1.5v-4.5" /><path d="M10 19h-5a2 2 0 0 1 -2 -2v-10c0 -1.1 .9 -2 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -1 1.73" /><line x1="6" y1="9" x2="18" y2="9" /><line x1="6" y1="12" x2="9" y2="12" /><line x1="6" y1="15" x2="8" y2="15" /></svg>
            </a>

            <?php if(isset($id_db_settings) && $level >= 3): ?>
                <a href="_disk/_help/402051f4be0cc3aad33bcf3ac3d6532b.inc.b.php" target="_blank" class="btn btn-outline-white">
                    <!-- Download SVG icon from http://tabler-icons.io/i/cloud-download -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M19 18a3.5 3.5 0 0 0 0 -7h-1a5 4.5 0 0 0 -11 -2a4.6 4.4 0 0 0 -2.1 8.4" /><line x1="12" y1="13" x2="12" y2="22" /><polyline points="9 19 12 22 15 19" /></svg>&nbsp;BackUp
                </a>
            <?php endif; ?>

            <?php if(isset($id_db_settings)): ?>
                <a href="#" class="btn btn-outline-white">
                    <?= number_format(DBKwanzar::CheckConfig($id_db_settings)['cambio_atual'], 2, ",", ".")." ".DBKwanzar::CheckConfig($id_db_settings)['moeda']." "; ?>
                    &nbsp;<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M11 3l9 9a1.5 1.5 0 0 1 0 2l-6 6a1.5 1.5 0 0 1 -2 0l-9 -9v-4a4 4 0 0 1 4 -4h4" /><circle cx="9" cy="9" r="2" /></svg>
                </a>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>

<?php
if(isset($id_db_settings)): ?>


    <?php
        $st = 1;

        $Read = new Read();
        $Read->ExeRead("db_alert", "WHERE id_db_settings=:i AND status=:st", "i={$id_db_settings}&st={$st}");
    ?>
    <div class="nav-item dropdown d-none d-md-flex me-3">
        <a href="#" onclick="AddViews();" class="nav-link px-0" data-bs-toggle="dropdown" tabindex="-1" aria-label="Show notifications">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 5a2 2 0 0 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6" /><path d="M9 17v1a3 3 0 0 0 6 0v-1" /></svg>
            <span class="badge bg-red" id="ReadViews"><?= $Read->getRowCount(); ?></span>
        </a>
        <div class="dropdown-menu dropdown-menu-end dropdown-menu-card">
            <div class="card">
                <?php
                    $Read = new Read();
                    $Read->ExeRead("db_alert", "WHERE id_db_settings=:i ORDER BY id DESC LIMIT 3", "i={$id_db_settings}");

                    if($Read->getResult()):
                        foreach ($Read->getResult() as $key):
                            ?>
                            <div class="card-body">
                                <?= $key['title']; ?>
                            </div>
                            <?php
                        endforeach;
                    endif;
                ?>
            </div>
        </div>
    </div>
<?php endif; ?>

<div class="nav-item dropdown">
    <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
        <span class="avatar avatar-sm" style="background-image: url(uploads/<?php if($userlogin['cover'] == "" || $userlogin['cover'] == null): echo "user.png"; else: echo $userlogin['cover']; endif; ?>)"></span>
        <div class="d-none d-xl-block ps-2">
            <?php
            if(isset($_SESSION['userlogin']['id_db_setting']) || !empty($_SESSION['userlogin']['id_db_settings'])):
                $DB = new DBKwanzar();
                if(isset($DB->CheckCpanelAndSettings($id_db_settings, $id_db_kwanzar)['atividade']) && $DB->CheckCpanelAndSettings($id_db_settings, $id_db_kwanzar)['atividade'] == 1 || isset($DB->CheckCpanelAndSettings($id_db_settings, $id_db_kwanzar)['atividade']) && $DB->CheckCpanelAndSettings($id_db_settings, $id_db_kwanzar)['atividade'] == 3):
                    if(!isset(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || empty(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || DBKwanzar::CheckConfig($id_db_settings)['Idioma'] == "Português"):
                        $DataLevel = ['', 'Usuário', 'Gestor', 'Administrador', 'Root', 'Desenvolvidor'];
                    else:
                        $DataLevel = ['', 'user', 'Manager', 'Administrator', 'Root', 'Developer'];
                    endif;
                elseif(isset($DB->CheckCpanelAndSettings($id_db_settings, $id_db_kwanzar)['atividade']) && $DB->CheckCpanelAndSettings($id_db_settings, $id_db_kwanzar)['atividade'] == 19):
                    if(!isset(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || empty(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || DBKwanzar::CheckConfig($id_db_settings)['Idioma'] == "Português"):
                        $DataLevel = ['', 'Recepcionista', 'Ass. Médico', 'Médico', 'Administrador', 'Desenvolvidor'];
                    else:
                        $DataLevel = ['', 'Receptionist', 'Medical Assistant', 'Doctor', 'Administrator', 'Developer'];
                    endif;
                else:
                    if(!isset(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || empty(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || DBKwanzar::CheckConfig($id_db_settings)['Idioma'] == "Português"):
                        $DataLevel = ['', 'Usuário', 'Gestor', 'Administrador', 'Root', 'Desenvolvidor'];
                    else:
                        $DataLevel = ['', 'user', 'Manager', 'Administrator', 'Root', 'Developer'];
                    endif;
                endif;
            else:
                if(!isset(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || empty(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || DBKwanzar::CheckConfig($id_db_settings)['Idioma'] == "Português"):
                    $DataLevel = ['', 'Usuário', 'Gestor', 'Administrador', 'Root', 'Desenvolvidor'];
                else:
                    $DataLevel = ['', 'user', 'Manager', 'Administrator', 'Root', 'Developer'];
                endif;
            endif;

            //$DataLevel = ["", "Usuário", "Gestor", "Administrador", "CEO", "Desenvolvidor"];
            ?>
            <div style="color: <?= $Index['color_41']; ?>!important;"><?= $userlogin["name"]; ?></div>
            <div class="mt-1 small text-muted" style="color: <?= $Index['color_41']; ?>!important;"><?= $DataLevel[$userlogin["level"]]; ?></div>
        </div>
    </a>
    <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">

        <?php if($level >= 4):  ?>
            <a class="dropdown-item" href="Admin.php">
                <?php
                    if(!isset(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || empty(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || DBKwanzar::CheckConfig($id_db_settings)['Idioma'] == "Português"):
                        echo "Painel de control";
                    else:
                        echo "Control panel";
                    endif;
                ?>
                </a>
            <div class="dropdown-divider"></div>
        <?php endif; ?>
        <?php if(isset($n)): ?> <a href="panel.php?exe=settings/profile<?= $n; ?>" class="dropdown-item">
            <?php
            if(!isset(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || empty(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || DBKwanzar::CheckConfig($id_db_settings)['Idioma'] == "Português"):
                echo "Perfil";
            else:
                echo "Profile";
            endif;
            ?></a> <?php endif; ?>
        <a href="?lock=true<?php if(isset($n)): echo $n; endif; ?>" class="dropdown-item">
            <?php
            if(!isset(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || empty(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || DBKwanzar::CheckConfig($id_db_settings)['Idioma'] == "Português"):
                echo "Bloqueio de ecrã";
            else:
                echo "Screen lock";
            endif;
            ?></a>
        <a href="password-users.php" class="dropdown-item">
            <?php
            if(!isset(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || empty(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || DBKwanzar::CheckConfig($id_db_settings)['Idioma'] == "Português"):
                echo "Alterar senha";
            else:
                echo "Change Password";
            endif;
            ?></a>
        <a href="?logoff=true" class="dropdown-item">
            <?php
            if(!isset(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || empty(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || DBKwanzar::CheckConfig($id_db_settings)['Idioma'] == "Português"):
                echo "Terminar sessão";
            else:
                echo "Log out";
            endif;
            ?></a>
    </div>
</div>
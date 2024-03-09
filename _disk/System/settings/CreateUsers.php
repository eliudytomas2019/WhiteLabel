<?php
if(!class_exists('login')):
    header("index.php");
    die();
endif;

if($level >= 4): $n =  '&id_db_settings='.$id_db_settings; else: $n = null; endif;

if($userlogin['level'] < 3):
    header("location: painel.php?exe=default/index".$n);
endif;

?>
<div class="page-header d-print-none">
    <div class="row align-items-center">
        <div class="col">
            <h2 class="page-title">
                Configurações
            </h2>
        </div>
    </div>
</div>
<div class="row gx-lg-4">
    <?php require_once("_disk/IncludesApp/MenuSettings.inc.php"); ?>
    <div class="col-lg-9">
        <div class="page-header d-print-none">
            <div class="row align-items-center">

                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="panel.php?exe=settings/users<?= $n; ?>" class="btn btn-primary d-none d-sm-inline-block">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 13l-4 -4l4 -4m-4 4h11a4 4 0 0 1 0 8h-1" /></svg>
                            Voltar
                        </a>
                    </div>
                </div>
                <div class="col">
                    <div class="page-pretitle">
                        <?= $Index['name']; ?>
                    </div>
                    <h2 class="page-title">
                        Usuários
                    </h2>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h5 class="modal-title">Usuários</h5>
            </div>
            <div class="card-body">
                <div class="aPaulo" id="aPaulo"></div>
                <form method="post" action="" name="FormCreateUsers">
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Nome completo</label>
                        <div class="col-sm-10">
                            <input type="text" name="name" required id="name" class="form-control"  placeholder="Nome">
                        </div>
                    </div><br/>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">E-mail</label>
                        <div class="col-sm-10">
                            <input type="text" name="username" required id="username" class="form-control"  placeholder="E-mail">
                        </div>
                    </div><br/>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Username</label>
                        <div class="col-sm-10">
                            <input type="text" name="email" id="email" class="form-control"  placeholder="Username">
                        </div>
                    </div><br/>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Nível de Acesso</label>
                        <div class="col-sm-10">
                            <select name="levels" id="levels" class="form-control">
                                <?php if($DB->CheckCpanelAndSettings($id_db_settings, $id_db_kwanzar)['atividade'] == 1 || $DB->CheckCpanelAndSettings($id_db_settings, $id_db_kwanzar)['atividade'] == 3): ?>
                                    <option value="1">Usuário</option>
                                    <option value="2">Gestor</option>
                                    <?php if($userlogin['level'] >= 3): ?>
                                        <option value="3">Administrador</option>
                                        <?php if($userlogin['level'] >= 4): ?>
                                            <option value="4">Root</option>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                <?php elseif($DB->CheckCpanelAndSettings($id_db_settings, $id_db_kwanzar)['atividade'] == 19): ?>
                                    <option value="1">Recepcionista</option>
                                    <option value="2">Ass. Médico</option>
                                    <?php if($userlogin['level'] == 1 || $userlogin['level'] == 4 || $userlogin['level'] == 5): ?>
                                        <option value="3">Médico</option>
                                        <?php if($userlogin['level'] >= 4): ?>
                                            <option value="4">Administrador</option>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>
                    <hr/>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </form>
            </div>
        </div>
    </div>
</div>
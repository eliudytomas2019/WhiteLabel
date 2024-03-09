<?php
if(!class_exists('login')):
    header("index.php");
    die();
endif;

if($level >= 4): $n =  '&id_db_settings='.$id_db_settings; else: $n = null; endif;

if($userlogin['level'] < 3):
    header("location: panel.php?exe=default/index".$n);
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
                <div class="col">
                    <div class="page-pretitle">
                        <?= $Index['name']; ?>
                    </div>
                    <h2 class="page-title">
                        Gerir utilizadores
                    </h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="panel.php?exe=settings/CreateUsers<?= $n; ?>" class="btn btn-primary btn-sm d-sm-inline-block" >
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg>
                            Adicionar utilizadores
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <div class="col">
                    <h5 class="modal-title">Utilizadores</h5>
                </div>
                <div class="col-auto ms-auto">
                    <div class="btn-list">
                        <input type="text" class="form-control SearchUsersX" id="SearchUsersX" name="SearchUsersX" placeholder="Pesquisar">
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div id="getResult"></div>
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>Nível de acesso</th>
                        <th>Status</th>
                        <th>-</th>
                    </tr>
                    </thead>
                    <tbody id="King2Da">
                    <?php
                    $posti = 0;
                    $getPage = filter_input(INPUT_GET, 'page',FILTER_VALIDATE_INT);
                    $Pager = new Pager("panel.php?exe=settings/users{$n}&page=");
                    $Pager->ExePager($getPage, 10);

                    $read = new Read();
                    $read->ExeRead("db_users", "WHERE id_db_kwanzar=:ip AND id_db_settings=:idd ORDER BY level DESC LIMIT :limit OFFSET :offset", "ip={$id_db_kwanzar}&idd={$id_db_settings}&limit={$Pager->getLimit()}&offset={$Pager->getOffset()}");
                    if($read->getResult()):
                        foreach($read->getResult() as $key):
                            extract($key);
                            if($DB->CheckCpanelAndSettings($id_db_settings, $id_db_kwanzar)['atividade'] == 1 || $DB->CheckCpanelAndSettings($id_db_settings, $id_db_kwanzar)['atividade'] == 2 || $DB->CheckCpanelAndSettings($id_db_settings, $id_db_kwanzar)['atividade'] == 3):
                                $levelsX = ['', 'Usuário', 'Gestor', 'Administrador', 'Root', 'Desenvolvidor'];
                            elseif($DB->CheckCpanelAndSettings($id_db_settings, $id_db_kwanzar)['atividade'] == 19):
                                $levelsX = ['', 'Recepcionista', 'Ass. Médico', 'Médico', 'Administrador', 'Desenvolvidor'];
                            endif;
                            $stat = ['Desativado', 'Ativo'];
                            ?>
                            <tr>
                                <td><?= $key['id'] ?></td>
                                <td><?= $key['name'] ?></td>
                                <td><?= $key['username'] ?></td>
                                <td><?= $levelsX[$key['level']]; ?></td>
                                <td><?= $stat[$key['status']] ?></td>
                                <td style="width: 280px!important;">
                                    <?php
                                    if($userlogin['level'] >= 3):
                                        ?>
                                        <?php if($DB->CheckCpanelAndSettings($id_db_settings, $id_db_kwanzar)['atividade'] == 19): ?>
                                            <?php if($key['level'] == 3): ?>
                                                <a href="panel.php?exe=settings/UsersOptions<?= $n; ?>&id_user=<?= $key['id']; ?>" class="btn btn-default btn-sm">Horário e Agenda</a>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                        <a href="panel.php?exe=settings/UpdateUsers<?= $n; ?>&id_user=<?= $key['id']; ?>" class="btn btn-primary btn-sm">Editar</a>
                                        <!--- <a href="#" class="btn btn-danger btn-sm" onclick="DeleteUsers(<?= $key['id']; ?>);">Eliminar</a> --->
                                        <a href="#" class="btn btn-warning btn-sm" onclick="SuspenderConta(<?= $key['id']; ?>);">Suspender</a>
                                        <a href="javascript:void" onclick="AdminSusPassword(<?= $key['id']; ?>)" class="btn btn-sm btn-primary">Repor password</a>&nbsp;
                                        <?php
                                    endif;
                                    ?>
                                </td>
                            </tr>
                        <?php
                        endforeach;
                    endif;
                    ?>
                    </tbody>
                </table>
                <div class="card-footer d-flex align-items-center">
                    <?php
                        $Pager->ExePaginator("db_users", "WHERE id_db_kwanzar=:ip AND id_db_settings=:idd ORDER BY level DESC", "ip={$id_db_kwanzar}&idd={$id_db_settings}");
                        echo $Pager->getPaginator();
                    ?>
                </div>


                <div class="row">
                    <div class="col-lg-9" style="margin: 10px auto!important;">
                        <div class="mb-3">
                            <?php if($DB->CheckCpanelAndSettings($id_db_settings, $id_db_kwanzar)['atividade'] == 1 || $DB->CheckCpanelAndSettings($id_db_settings, $id_db_kwanzar)['atividade'] == 3): ?>
                                <label class="form-label"><strong>Administrador</strong> - Pode utilizar todas as funcionalidades da aplicação e aceder a todas as páginas. Tem permissão para apagar e criar novos utilizadores, alterar as configurações e fazer a gestão da conta.</label>
                                <label class="form-label"><strong>Gestor</strong> - Pode gerir facturas, itens, e clientes, mas tem acesso limitado às configurações e gestão da conta. Este será o perfil, por omissão, de um novo utilizador.</label>
                                <label class="form-label"><strong>Usuário</strong> - Pode emitir documentos, gerir itens e clientes, mas tem acesso limitado às configurações. Este será um perfil de quem apenas emite documentos de venda. </label>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
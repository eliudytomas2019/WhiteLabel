<?php
    $Read = new Read();
    $Reads = new Read();

    if(!class_exists('login')):
        header("index.php");
        die();
    endif;

    if($userlogin['level'] <= 4):
        header("location: panel.php?exe=default/index".$n);
    endif;

    $dia = date('d');
    $mes = date('m');
    $ano = date('Y');

    $hoje = 0;
    $eseMes = 0;
    $esseAno = 0;

    $Read->ExeRead("ws_times_backup", "WHERE dia='{$dia}' AND mes='{$mes}' AND ano='{$ano}'");
    if($Read->getResult()):
        foreach ($Read->getResult() as $today):
            $hoje += $today['total'];
        endforeach;
    endif;

    $Read->ExeRead("ws_times_backup", "WHERE mes='{$mes}' AND ano='{$ano}'");
    if($Read->getResult()):
        foreach ($Read->getResult() as $today):
            $eseMes += $today['total'];
        endforeach;
    endif;

    $Read->ExeRead("ws_times_backup", "WHERE ano='{$ano}'");
    if($Read->getResult()):
        foreach ($Read->getResult() as $today):
            $esseAno += $today['total'];
        endforeach;
    endif;
?>
<div class="row row-deck row-cards">
    <div class="card-body">
        <div class="row row-cards">
            <div class="page-header d-print-none">
                <div class="row align-items-center">
                    <div class="col-auto ms-auto d-print-none">
                        <div class="btn-list">
                            <!---a href="Error.php" target="_blank" class="btn btn-warning d-none d-sm-inline-block">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><polyline points="5 7 10 12 5 17" /><line x1="13" y1="17" x2="19" y2="17" /></svg>
                                Reparar o Banco de Dados
                            </a--->
                            <a href="_disk/_help/_backup_users.php" target="_blank" class="btn btn-primary d-none d-sm-inline-block">
                                <!-- Download SVG icon from http://tabler-icons.io/i/cloud-download -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M19 18a3.5 3.5 0 0 0 0 -7h-1a5 4.5 0 0 0 -11 -2a4.6 4.4 0 0 0 -2.1 8.4" /><line x1="12" y1="13" x2="12" y2="22" /><polyline points="9 19 12 22 15 19" /></svg>
                                Email dos Usuários
                            </a>
                            <a href="_disk/_help/9cb8af3f5c58553c270412eb3d751fc3.inc.e.php" target="_blank" class="btn btn-primary d-none d-sm-inline-block">
                                <!-- Download SVG icon from http://tabler-icons.io/i/cloud-download -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M19 18a3.5 3.5 0 0 0 0 -7h-1a5 4.5 0 0 0 -11 -2a4.6 4.4 0 0 0 -2.1 8.4" /><line x1="12" y1="13" x2="12" y2="22" /><polyline points="9 19 12 22 15 19" /></svg>
                                Email dos clientes
                            </a>
                            <a href="_disk/_help/_backup_.php" target="_blank" class="btn btn-primary d-none d-sm-inline-block">
                                <!-- Download SVG icon from http://tabler-icons.io/i/cloud-download -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M19 18a3.5 3.5 0 0 0 0 -7h-1a5 4.5 0 0 0 -11 -2a4.6 4.4 0 0 0 -2.1 8.4" /><line x1="12" y1="13" x2="12" y2="22" /><polyline points="9 19 12 22 15 19" /></svg>
                                Email das Empresas
                            </a>
                            <a href="_disk/_help/402051f4be0cc3aad33bcf3ac3d6532b.inc.b.php" target="_blank" class="btn btn-success d-none d-sm-inline-block">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M19 18a3.5 3.5 0 0 0 0 -7h-1a5 4.5 0 0 0 -11 -2a4.6 4.4 0 0 0 -2.1 8.4" /><line x1="12" y1="13" x2="12" y2="22" /><polyline points="9 19 12 22 15 19" /></svg>
                                Backup do sistema
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div><br/>

        <div class="row">
            <div class="col-md-6 col-xl-4">
                <div class="card card-sm">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <span class="bg-blue text-white avatar">
                                  <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M16.7 8a3 3 0 0 0 -2.7 -2h-4a3 3 0 0 0 0 6h4a3 3 0 0 1 0 6h-4a3 3 0 0 1 -2.7 -2" /><path d="M12 3v3m0 12v3" /></svg>
                                </span>
                            </div>
                            <div class="col">
                                <div class="font-weight-medium">
                                    <?= str_replace(",", ".", number_format($hoje, 2)); ?> AOA
                                </div>
                                <div class="text-muted" style="color: <?= $Index['color_41']; ?>!important;">
                                    Hoje
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-4">
                <div class="card card-sm">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <span class="bg-blue text-white avatar">
                                  <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M16.7 8a3 3 0 0 0 -2.7 -2h-4a3 3 0 0 0 0 6h4a3 3 0 0 1 0 6h-4a3 3 0 0 1 -2.7 -2" /><path d="M12 3v3m0 12v3" /></svg>
                                </span>
                            </div>
                            <div class="col">
                                <div class="font-weight-medium">
                                    <?= str_replace(",", ".", number_format($eseMes, 2)); ?> AOA
                                </div>
                                <div class="text-muted" style="color: <?= $Index['color_41']; ?>!important;">
                                    Esse Mês
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-4">
                <div class="card card-sm">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <span class="bg-blue text-white avatar">
                                  <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M16.7 8a3 3 0 0 0 -2.7 -2h-4a3 3 0 0 0 0 6h4a3 3 0 0 1 0 6h-4a3 3 0 0 1 -2.7 -2" /><path d="M12 3v3m0 12v3" /></svg>
                                </span>
                            </div>
                            <div class="col">
                                <div class="font-weight-medium">
                                    <?= str_replace(",", ".", number_format($esseAno, 2)); ?> AOA
                                </div>
                                <div class="text-muted" style="color: <?= $Index['color_41']; ?>!important;">
                                    Esse Ano
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><br/>

        <div class="row">
            <?php
                $Read->FullRead("SELECT * FROM db_settings ORDER BY id ASC");
                if($Read->getResult()): $empresas = $Read->getRowCount(); else: $empresas = 0; endif;

                $usuarios = 0;
                $Read->ExeRead("db_users");
                if($Read->getResult() || $Read->getRowCount()): $usuarios = $Read->getRowCount(); endif;

                $Read->ExeRead("cv_customer");
                if($Read->getResult()): $clientes = $Read->getRowCount(); else: $clientes = 0; endif;

                $Read->ExeRead("sd_billing");
                if($Read->getResult()): $docs = $Read->getRowCount(); else: $docs = 0; endif;
            ?>
            <div class="col-md-6 col-xl-3">
                <div class="card card-sm">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <span class="bg-green-lt avatar">
                                    <!-- Download SVG icon from http://tabler-icons.io/i/briefcase -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><rect x="3" y="7" width="18" height="13" rx="2" /><path d="M8 7v-2a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2v2" /><line x1="12" y1="12" x2="12" y2="12.01" /><path d="M3 13a20 20 0 0 0 18 0" /></svg>
                                </span>
                            </div>
                            <div class="col">
                                <div class="font-weight-medium">
                                   <?= $empresas; ?>
                                </div>
                                <div class="text-muted" style="color: <?= $Index['color_41']; ?>!important;">
                                    Empresas
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
                                <span class="bg-green-lt avatar">
                                    <!-- Download SVG icon from http://tabler-icons.io/i/users -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="9" cy="7" r="4" /><path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" /><path d="M16 3.13a4 4 0 0 1 0 7.75" /><path d="M21 21v-2a4 4 0 0 0 -3 -3.85" /></svg>
                                </span>
                            </div>
                            <div class="col">
                                <div class="font-weight-medium">
                                    <?= $usuarios; ?>
                                </div>
                                <div class="text-muted" style="color: <?= $Index['color_41']; ?>!important;">
                                    Usuários
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
                        <span class="bg-green-lt avatar"><!-- Download SVG icon from http://tabler-icons.io/i/arrow-up -->
                          <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="18" y1="11" x2="12" y2="5" /><line x1="6" y1="11" x2="12" y2="5" /></svg>
                        </span>
                            </div>
                            <div class="col">
                                <div class="font-weight-medium">
                                    <?= $clientes; ?>
                                </div>
                                <div class="text-muted" style="color: <?= $Index['color_41']; ?>!important;">
                                    Clientes
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
                        <span class="bg-green-lt avatar"><!-- Download SVG icon from http://tabler-icons.io/i/arrow-up -->
                          <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="18" y1="11" x2="12" y2="5" /><line x1="6" y1="11" x2="12" y2="5" /></svg>
                        </span>
                            </div>
                            <div class="col">
                                <div class="font-weight-medium">
                                    <?= $docs; ?>
                                </div>
                                <div class="text-muted" style="color: <?= $Index['color_41']; ?>!important;">
                                    Documentos
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><br/>

        <div class="row">
            <div class="col-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex">
                            <h3 class="card-title">Acessos diário</h3>
                        </div>
                        <div id="chart-tasks-overview"></div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card">
                    <div class="card-body"><div class="d-flex">
                            <h3 class="card-title">Acessos Mensal</h3>
                        </div>
                        <div id="chart-completion-tasks-7"></div>
                    </div>
                </div>
            </div>
        </div><br/>

        <div class="col-lg-12 col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex">
                        <h3 class="card-title">Licenças Paga x Novas Empresas</h3>
                    </div>
                    <div id="chart-temperature"></div>
                </div>
            </div>
        </div><br/>

        <div class="row">
            <div class="col-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex">
                            <h3 class="card-title">Estatísticas de acesso mensal</h3>
                        </div>
                        <div id="chart-social-referrals"></div>
                    </div>
                </div>
            </div>

            <div class="col-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex">
                            <h3 class="card-title">Estatísticas de acesso anual</h3>
                        </div>
                        <div id="02-admin-static-charts"></div>
                    </div>
                </div>
            </div>
        </div>
        <br/>
        <div class="row">
            <div class="col-lg-8 col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex">
                            <h3 class="card-title">Top Navegadores</h3>
                        </div>
                        <div id="03-admin-static"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex">
                            <h3 class="card-title">Top Usuários</h3>
                        </div>
                        <div id="04-admin-static"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex">
                            <h3 class="card-title">Top Empresas</h3>
                        </div>
                        <div id="15-admin-static"></div>
                    </div>
                </div>
            </div>
        </div><br/>

        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="modal-title">Relatórios de Vendas</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label class="form-label">Data Inicio</label>
                                <?php $null = array(); $read->ExeRead("db_kwanzar", "WHERE id=:id", "id={$id_db_kwanzar}"); if($read->getResult()):$null = $read->getResult()[0];endif; ?>
                                <input type="date" id="dateI" class="form-control" placeholder="Data Fnicial"/>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label class="form-label">Data Final</label>
                                <input type="date" id="dateF" class="form-control" placeholder="Data Final"/>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="mb-3">
                                <br/>
                                <a href="javascript:void" onclick="EliudyTomasDocs();" class="btn btn-primary">
                                    Pesquisar
                                </a>
                            </div>
                        </div>
                    </div><br/>
                    <div id="EliudyTomasDocs"></div>
                </div>
            </div>
        </div><br/>

        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="modal-title">Usuários Activos</h5>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>COVER</th>
                                <th>NOME</th>
                                <th>E-MAIL</th>
                                <th>TELEFONE</th>
                                <th>ÚLTIMA SESSÃO</th>
                                <th>VISUALIZAÇÕES</th>
                                <th>STATUS</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $day = date('d');
                                $mes = date('m');
                                $ano = date('Y');

                                $Read = new Read();
                                $Read->ExeRead("db_users_active_static", " WHERE dia=:day AND mes=:m AND ano=:y ORDER BY total DESC  LIMIT 50", "day={$day}&m={$mes}&y={$ano}");

                                if($Read->getResult()):
                                    foreach ($Read->getResult() as $item):
                                        $Read->ExeRead("db_users", "WHERE id=:i", "i={$item['session_id']}");

                                        if($Read->getResult()):
                                            foreach ($Read->getResult() as $key):

                                                $limite = date('Y-m-d ').date('H:i:s');
                                                if(strtotime($key['session_end']) >= strtotime($limite)): $agora = "success"; else: $agora = "primary"; endif;
                                                ?>
                                                <tr>
                                                    <td><?= $key['id']; ?></td>
                                                    <td><img src="uploads/<?php if($key['cover'] == "" || $key['cover'] == null): echo "user.png"; else: echo $key['cover']; endif; ?>" style="width: 30px!important;height: 30px!important; border-radius: 50%!important;"> </td>
                                                    <td><?= $key['name']; ?></td>
                                                    <td><?= $key['username']; ?></td>
                                                    <td><?= $key['telefone']; ?></td>
                                                    <td><?= $key['session_start']; ?></td>
                                                    <td><?= $item['total']; ?></td>
                                                    <td>
                                                        <div class="badge bg-<?= $agora; ?>"></div>
                                                    </td>
                                                </tr>
                                                <?php
                                            endforeach;
                                        endif;
                                    endforeach;
                                endif;
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div><br/>


        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="modal-title">Registro de atividades</h5>
                </div>
                <div class="card-body">
                    <div class="divide-y">
                        <?php
                        $posti = 0;
                        $getPage = filter_input(INPUT_GET, 'page',FILTER_VALIDATE_INT);
                        $Pager = new Pager("Admin.php?exe=admin/eliudy&page=");
                        $Pager->ExePager($getPage, 5);

                        $Reads = new Read();
                        $Read->ExeRead("db_users_active_store", "ORDER BY id DESC LIMIT :limit OFFSET :offset", "limit={$Pager->getLimit()}&offset={$Pager->getOffset()}");
                        if($Read->getResult()):
                            foreach ($Read->getResult() as $key):
                                $Reads->ExeRead("db_users", "WHERE id=:i ", "i={$key['session_id']}");
                                if($Reads->getResult()):
                                    $use = $Reads->getResult()[0];
                                else:
                                    if($key['session_id'] == 0 || $key['session_id'] == null || empty($key['session_id'])):
                                        $use['name'] = "Visitante";
                                        $use['cover'] = null;
                                    else:
                                        $use = null;
                                    endif;
                                endif;
                                ?>
                                <div>
                                    <div class="row">
                                        <div class="col-auto">
                                            <span class="avatar" style="background-image: url(./uploads/<?php if($use['cover'] == "" || $use['cover'] == null): echo "user.png"; else: echo $use['cover']; endif; ?>)"></span>
                                        </div>
                                        <div class="col">
                                            <div class="text-truncate">
                                                <strong><?= $use["name"]; ?></strong> acessou: <strong>"<?= $key["page"]; ?>"</strong>
                                            </div>
                                            <div class="text-muted" style="color: #313030!important;">pelo navegador: <strong><?= $key["browser"]; ?></strong>, data de navegaçāo: <strong><?= $key["data"]; ?></strong>, com o endereço de IP: <strong><?= $key["user_ip"]; ?></strong>, usando o sistema operacional: <strong><?= $key["system_id"]; ?></strong>, <strong><?= $key["x"]; ?></strong>x</div>
                                        </div>
                                        <div class="col-auto align-self-center">
                                            <div class="badge bg-primary"></div>
                                        </div>
                                    </div>
                                </div>
                            <?php
                            endforeach;
                        endif;

                        $Pager->ExePaginator("db_users_active_store", "ORDER BY id DESC");
                        echo $Pager->getPaginator();
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
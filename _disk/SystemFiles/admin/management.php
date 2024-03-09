<div class="page-header d-print-none">
    <div class="row align-items-center">
        <div class="col">
            <h2 class="page-title">
                Gestão e Marketing
            </h2>
        </div>
    </div>

    <?php
        $active = 0;
        $expired = 0;
        $free = 0;
        $suspense = 0;

        $Read = new Read();
        $Read->ExeRead("ws_times");

        if($Read->getResult()):
            foreach ($Read->getResult() as $key):
                if($key['status'] == 0): $expired += 1; endif;
                if($key['status'] == 1 && $key['pricing'] > 0): $active += 1; endif;
                if($key['status'] == 1 && $key['pricing'] == null || $key['status'] == 1 && $key['pricing'] <= 0): $free += 1; endif;
            endforeach;
        endif;

        $i = 0;
        $Read->ExeRead("db_settings", "WHERE status=:i", "i={$i}");
        if($Read->getResult()): $suspense = $Read->getRowCount(); endif;
    ?>
</div><br/>
<div class="row row-cards">
    <div class="col-12">
        <a href="_emails/02-emails.inc.php" class="btn btn-primary" target="_blank">Activação de Conta</a>
        <a href="_emails/01-emails.inc.php" target="_blank" class="btn btn-primary">Renovação de Licença</a>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card card-sm">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <span class="bg-blue text-white avatar">
<!-- Download SVG icon from http://tabler-icons.io/i/cloud-storm -->
	<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 18a4.6 4.4 0 0 1 0 -9a5 4.5 0 0 1 11 2h1a3.5 3.5 0 0 1 0 7h-1" /><polyline points="13 14 11 18 14 18 12 22" /></svg>
                        </span>
                    </div>
                    <div class="col">
                        <div class="font-weight-medium">
                            <?= $active; ?>
                        </div>
                        <div class="text-muted" style="color: <?= $Index['color_41']; ?>!important;">
                            Licença Activas
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
                        <span class="bg-blue text-white avatar">
<!-- Download SVG icon from http://tabler-icons.io/i/click -->
	<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="3" y1="12" x2="6" y2="12" /><line x1="12" y1="3" x2="12" y2="6" /><line x1="7.8" y1="7.8" x2="5.6" y2="5.6" /><line x1="16.2" y1="7.8" x2="18.4" y2="5.6" /><line x1="7.8" y1="16.2" x2="5.6" y2="18.4" /><path d="M12 12l9 3l-4 2l-2 4l-3 -9" /></svg>
                        </span>
                    </div>
                    <div class="col">
                        <div class="font-weight-medium">
                            <?= $free; ?>
                        </div>
                        <div class="text-muted" style="color: <?= $Index['color_41']; ?>!important;">
                            Licenças Grátis
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
                        <span class="bg-blue text-white avatar">
                            <!-- Download SVG icon from http://tabler-icons.io/i/cloud-off -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="3" y1="3" x2="21" y2="21" /><path d="M18 18h-11c-2.598 0 -4.705 -2.015 -4.705 -4.5s2.107 -4.5 4.705 -4.5c.112 -.5 .305 -.973 .568 -1.408m2.094 -1.948c.329 -.174 .68 -.319 1.05 -.43c1.9 -.576 3.997 -.194 5.5 1c1.503 1.192 2.185 3.017 1.788 4.786h1a3.5 3.5 0 0 1 2.212 6.212" /></svg>
                        </span>
                    </div>
                    <div class="col">
                        <div class="font-weight-medium">
                            <?= $expired; ?>
                        </div>
                        <div class="text-muted" style="color: <?= $Index['color_41']; ?>!important;">
                            Licenças Expiradas
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
                        <span class="bg-blue text-white avatar">
                        <!-- Download SVG icon from http://tabler-icons.io/i/bell-off -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="3" y1="3" x2="21" y2="21" /><path d="M17 17h-13a4 4 0 0 0 2 -3v-3a7 7 0 0 1 1.279 -3.716m2.072 -1.934c.209 -.127 .425 -.244 .649 -.35a2 2 0 1 1 4 0a7 7 0 0 1 4 6v3" /><path d="M9 17v1a3 3 0 0 0 6 0v-1" /></svg>
                        </span>
                    </div>
                    <div class="col">
                        <div class="font-weight-medium">
                            <?= $suspense; ?>
                        </div>
                        <div class="text-muted" style="color: <?= $Index['color_41']; ?>!important;">
                            Contas Suspensas
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br/>

</div>

<br/><div class="row row-cards">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Controle de Licenças</h3>&nbsp;&nbsp;&nbsp;
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Empresa</th>
                            <th>NIF</th>
                            <th>Email</th>
                            <th>Telefone</th>
                            <th>Endereço</th>
                            <th>Dias</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $posti = 0;
                            $getPage = filter_input(INPUT_GET, 'page',FILTER_VALIDATE_INT);
                            $Pager = new Pager("Admin.php?exe=admin/management&page=");
                            $Pager->ExePager($getPage, 10);

                            $Read = new Read();
                            $Read->ExeRead("db_settings", "ORDER BY empresa ASC LIMIT :limit OFFSET :offset", "limit={$Pager->getLimit()}&offset={$Pager->getOffset()}");

                            if($Read->getResult()):
                                foreach ($Read->getResult() as $item):
                                    $Datatime = ["", "Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"];
                                    $Read->ExeRead("ws_times", "WHERE id_db_kwanzar=:i ORDER BY id DESC", "i={$item['id_db_kwanzar']}");
                                    if($Read->getResult()):
                                       foreach ($Read->getResult() as $times):
                                            $ps3 = $times['plano'];
                                            $data_inicial = date('Y-m-d');
                                            $data_final = $times['times'];
                                            $diferenca = strtotime($data_final) - strtotime($data_inicial);
                                            $dias = floor($diferenca / (60 * 60 * 24));

                                            if($dias <= 10):
                                                ?>
                                                <tr>
                                                    <td><?= $item['empresa']; ?></td>
                                                    <td><?= $item['nif']; ?></td>
                                                    <td><?= $item['email']; ?></td>
                                                    <td><?= $item['telefone']; ?></td>
                                                    <td><?= $item['endereco']; ?></td>
                                                    <td><?= $dias; ?></td>
                                                </tr>
                                                <?php
                                            endif;
                                        endforeach;
                                    endif;
                                endforeach;
                            endif;
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="card-footer d-flex align-items-center">
                <?php
                    $Pager->ExePaginator("db_settings", "ORDER BY empresa ASC");
                    echo $Pager->getPaginator();
                ?>
            </div>
        </div>
        </div>
    </div>
</div>
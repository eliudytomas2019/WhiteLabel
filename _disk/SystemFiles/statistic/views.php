<div class="page-header d-print-none">
    <div class="row align-items-center">

        <div class="col-auto ms-auto d-print-none">
            <div class="btn-list">
                <a href="Admin.php?exe=statistic/company" class="btn btn-primary d-none d-sm-inline-block">
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
                Detalhes da Empresa
            </h2>
        </div>
    </div>
</div>

<div class="row row-cards">
    <?php
        $postId = filter_input(INPUT_GET, "postId", FILTER_VALIDATE_INT);
        $Data = null;

        $read = new Read();
        $read->ExeRead("db_settings", "WHERE id=:i", "i={$postId}");
        if($read->getResult()):
            $Data = $read->getResult()[0];
        endif;

        $Meses = ["", "Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro", "Sem Registro"];
        if($Data['mes'] != null): $zeros = ltrim($Data['mes'], '0'); else: $zeros = 13; endif;
        $Modulos = ["", "Facturação & Stock", "Restaurantes & Bares", "Facturação", "Gestão Mecânica", "", "", "", "", "", "", "", "", "", "", "", "", "", "Gestão Clínica", "Gestão Clínica", "Gestão Clínica", "Gestão Clínica", "Gestão Clínica", "Gestão Clínica"];
    ?>

    <div class="col-md-3 col-lg-12">
        <div class="row row-cards">
            <div class="col-12">
                <div class="card">
                    <div class="card-body p-4 py-5 text-center">
                        <span class="avatar avatar-xl mb-4 avatar-rounded"><img src="uploads/<?php if(empty($Data['logotype']) || !isset($Data['logotype'])): echo 'default.jpg'; else: echo $Data['logotype']; endif; ?>" style="border-radius: 50%!important;"/></span>
                        <h3 class="mb-0"><?= $Data['empresa']; ?></h3>
                        <p class="text-muted"  style="color: <?= $Index['color_41']; ?>!important;">Data de registro: <?= $Data['dia'];?> de <?= $Meses[$zeros]; ?> de <?= $Data['ano']; ?></p>
                        <p class="mb-3">
                            <span class="badge bg-red-lt">Usuários</span>
                        </p>
                        <div>
                            <div class="avatar-list avatar-list-stacked">
                                <?php
                                    $Read = new Read();
                                    $Read->ExeRead("db_users", "WHERE id_db_settings=:i LIMIT 10", "i={$postId}");

                                    if($Read->getResult()):
                                        foreach ($Read->getResult() as $key):
                                            ?>
                                            <span class="avatar avatar-sm avatar-rounded" style="background-image: url(uploads/<?php if(empty($key['cover']) || !isset($key['cover'])): echo 'user.png'; else: echo $key['cover']; endif; ?>)"></span>
                                            <?php
                                        endforeach;
                                    endif;
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br/>
    <br/><div class="row" style="display: flex!important;flex-direction: row!important;justify-content: space-between!important;align-content: flex-start!important;align-items: flex-start!important;align-self: flex-start!important; "><br/>
       <div class="col-4">
           <br/>
           <div class="card">
               <div class="card-body">
                   <div class="card-title">Informações da Empresa</div>
                   <div class="mb-2">
                       NIF: <strong><?= $Data['nif']; ?></strong>
                   </div>
                   <div class="mb-2">
                       Telefone: <strong><?= $Data['telefone']; ?></strong>
                   </div>
                   <div class="mb-2">
                       Email: <strong><?= $Data['email']; ?></strong>
                   </div>
                   <div class="mb-2">
                       Website: <strong><?= $Data['website']; ?></strong>
                   </div>
                   <div class="mb-2">
                       Módulo: <strong><?= $Modulos[$Data['atividade']]; ?></strong>
                   </div>
                   <div class="mb-2">
                       Endereço: <strong><?= $Data['endereco']; ?></strong>
                   </div>
               </div>
           </div>
       </div>
       <div class="col-lg-8 col-xl-8">
           <br/>
           <?php
                $Read = new Read();

                $Users = null;
                $Read->ExeRead("db_users", "WHERE id_db_settings=:i", "i={$postId}");
                if($Read->getResult()): $Users = $Read->getRowCount(); endif;

               $Read->ExeRead("ii_billing", "WHERE id_db_settings=:i", "i={$postId}");
               $documentos = $Read->getRowCount();

               $Read->ExeRead("sd_billing", "WHERE id_db_settings=:i", "i={$postId}");
               $documentos += $Read->getRowCount();

               $Read->ExeRead("sd_retification", "WHERE id_db_settings=:i", "i={$postId}");
               $documentos += $Read->getRowCount();

               $Read->ExeRead("cv_product", "WHERE id_db_settings=:i", "i={$postId}");
               $Itens = $Read->getRowCount();
           ?>
           <div class="row">
               <div class="col-md-6 col-xl-4">
                   <div class="card card-sm">
                       <div class="card-body">
                           <div class="row align-items-center">
                               <div class="col-auto">
                                    <span class="bg-blue text-white avatar">
                                        <!-- Download SVG icon from http://tabler-icons.io/i/color-swatch -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M19 3h-4a2 2 0 0 0 -2 2v12a4 4 0 0 0 8 0v-12a2 2 0 0 0 -2 -2" /><path d="M13 7.35l-2 -2a2 2 0 0 0 -2.828 0l-2.828 2.828a2 2 0 0 0 0 2.828l9 9" /><path d="M7.3 13h-2.3a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h12" /><line x1="17" y1="17" x2="17" y2="17.01" /></svg>
                                    </span>
                               </div>
                               <div class="col">
                                   <div class="font-weight-medium">
                                       <?= $documentos; ?>
                                   </div>
                                   <div class="text-muted" style="color: <?= $Index['color_41']; ?>!important;">
                                       Documentos
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
                                        <!-- Download SVG icon from http://tabler-icons.io/i/users -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="9" cy="7" r="4" /><path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" /><path d="M16 3.13a4 4 0 0 1 0 7.75" /><path d="M21 21v-2a4 4 0 0 0 -3 -3.85" /></svg>
                                    </span>
                               </div>
                               <div class="col">
                                   <div class="font-weight-medium">
                                       <?= $Users; ?>
                                   </div>
                                   <div class="text-muted" style="color: <?= $Index['color_41']; ?>!important;">
                                       Usuários
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
                                        <!-- Download SVG icon from http://tabler-icons.io/i/tag -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M11 3l9 9a1.5 1.5 0 0 1 0 2l-6 6a1.5 1.5 0 0 1 -2 0l-9 -9v-4a4 4 0 0 1 4 -4h4" /><circle cx="9" cy="9" r="2" /></svg>
                                    </span>
                               </div>
                               <div class="col">
                                   <div class="font-weight-medium">
                                       <?= $Itens; ?>
                                   </div>
                                   <div class="text-muted" style="color: <?= $Index['color_41']; ?>!important;">
                                       Itens
                                   </div>
                               </div>
                           </div>
                       </div>
                   </div>
               </div>

               <div class="row" style="margin: 0 auto!important;">
                   <br/>
                   <div class="col-12" style="margin: 0 auto!important;"><br/>
                       <div class="card">
                           <div class="card-header">
                               <h3 class="card-title">Licença</h3>
                           </div>
                           <div class="table-responsive">
                               <?php
                                   $times = null;
                                   $Datatime = ["", "Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"];
                                   $read->ExeRead("ws_times", "WHERE id_db_kwanzar=:i ORDER BY id DESC", "i={$Data['id_db_kwanzar']}");
                                   if($read->getResult()):
                                       $times = $read->getResult()[0];
                                       $ps3 = $times['plano'];
                                       $data_inicial = date('Y-m-d');
                                       $data_final = $times['times'];
                                       $diferenca = strtotime($data_final) - strtotime($data_inicial);
                                       $dias = floor($diferenca / (60 * 60 * 24));
                                   endif;

                                   $fim = explode("-", $times['times']);
                                   if($fim[1] <= "09"):
                                       $ips = (int) $fim[1];
                                       $fim[1] = $ips;
                                   endif;

                                   if($times["mes"] <= "09"):
                                       $opp = (int) $times["mes"];
                                       $times["mes"] = $opp;
                                   endif;
                               ?>
                               <table class="table">
                                   <thead>
                                   <tr>
                                       <th>Plano</th>
                                       <th>Saldo</th>
                                       <th>Válido até</th>
                                       <th>Documentos</th>
                                       <th>Utilizadores</th>
                                       <th>Total pago</th>
                                   </tr>
                                   </thead>
                                   <tbody>
                                        <tr>
                                            <td><?= $ps3; ?> (<?= number_format($times['pricing'], 2);  ?> Kz / mês)</td>
                                            <td><?= $dias; ?> dia(s)</td>
                                            <td><?= $fim[2]." de ".$Datatime[$fim[1]]." de ".$fim[0]; ?></td>
                                            <td><?= $documentos." / ".$times['documentos']; ?></td>
                                            <td><?= $Users." / ".$times['users']; ?></td>
                                            <td><?= number_format($times['total'], 2); ?> Kz</td>
                                        </tr>
                                   </tbody>
                               </table>
                           </div>
                       </div>
                   </div><br/>
                   <br/>
                   <div class="col-12"><br/>
                       <div class="card">
                           <div class="card-header">
                               <h3 class="card-title">Usuários</h3>
                           </div>
                           <div id="aPaulo"></div>
                           <div id="getFake"></div>
                           <div class="table-responsive">
                               <table class="table">
                                   <thead>
                                   <tr>
                                       <th>ID</th>
                                       <th>Foto</th>
                                       <th>Nome</th>
                                       <th>Nível</th>
                                       <th>Email</th>
                                       <th>Telefone</th>
                                       <th>Status</th>
                                       <th>-</th>
                                   </tr>
                                   </thead>
                                   <tbody id="getResult">
                                   <?php
                                   $posti = 0;
                                   $getPage = filter_input(INPUT_GET, 'page',FILTER_VALIDATE_INT);
                                   $Pager = new Pager("Admin.php?exe=statistic/views&postId={$postId}&page=");
                                   $Pager->ExePager($getPage, 5);

                                   $Status = ["Activar", "Suspender"];
                                   $level = ['', 'Usuário', 'Gestor', 'Administrador', 'Root', 'Desenvolvidor'];
                                   $stat = ['Desativado', 'Ativo'];

                                   $read = new Read();
                                   $read->ExeRead("db_users", "WHERE id_db_settings=:id ORDER BY id DESC LIMIT :limit OFFSET :offset", "id={$postId}&limit={$Pager->getLimit()}&offset={$Pager->getOffset()}");
                                   if($read->getResult()):
                                       foreach ($read->getResult() as $key):
                                           ?>
                                           <tr>
                                               <td><?= $key['id']; ?></td>
                                               <th><img src="uploads/<?php if($key['cover'] == null || !isset($key['cover'])): echo "user.png"; else: echo $key['cover']; endif; ?>" style="width: 20px!important;height: 20px!important;border-radius: 50%!important;"> </th>
                                               <td><?= $key['name']; ?></td>
                                               <td><?= $level[$key['level']]; ?></td>
                                               <td><?= $key['username']; ?></td>
                                               <td><?= $key['telefone']; ?></td>
                                               <td><?= $stat[$key['status']] ?></td>
                                               <td>
                                                   <a href="javascript:void" onclick="AdminSusPassword(<?= $key['id']; ?>)" class="btn btn-sm btn-primary">Repor password</a>&nbsp;
                                                   <a href="javascript:void" onclick="AdminSusUsers(<?= $key['id']; ?>)" class="btn btn-sm btn-warning"><?= $Status[$key['status']]; ?></a>&nbsp;
                                               </td>
                                           </tr>
                                       <?php
                                       endforeach;
                                   endif;
                                   ?>
                                   </tbody>
                               </table>
                           </div>
                           <div class="card-footer d-flex align-items-center">
                               <?php
                               $Pager->ExePaginator("db_users", "WHERE id_db_settings=:id ORDER BY id DESC", "id={$postId}");
                               echo $Pager->getPaginator();
                               ?>
                           </div>
                       </div>
                   </div><br/>
                   <br/><div class="col-lg-12"><br/>
                       <div class="card">
                           <div class="card-header">
                               <h5 class="modal-title">Registro de atividades</h5>
                           </div>
                           <div class="card-body">
                               <div class="divide-y">
                                   <?php
                                   $posti = 0;
                                   $getPage = filter_input(INPUT_GET, 'page',FILTER_VALIDATE_INT);
                                   $Pager = new Pager("Admin.php?exe=statistic/views&postId={$postId}&page=");
                                   $Pager->ExePager($getPage, 3);

                                   $Read = new Read();
                                   $Reads = new Read();
                                   $Read->ExeRead("db_users_active_store", "WHERE id_db_settings=:i ORDER BY id DESC LIMIT :limit OFFSET :offset", "i={$postId}&limit={$Pager->getLimit()}&offset={$Pager->getOffset()}");
                                   if($Read->getResult()):
                                       foreach ($Read->getResult() as $key):
                                           $Reads->ExeRead("db_users", "WHERE id=:i ", "i={$key['session_id']}");
                                           if($Reads->getResult()): $use = $Reads->getResult()[0]; else: $use = null; endif;
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
                                                       <div class="text-muted" style="color: #313030!important;">pelo navegador: <strong><?= $key["browser"]; ?></strong>, data de navegaçāo: <strong><?= $key["data"]; ?></strong>, com o endereço de IP: <strong><?= $key["user_ip"]; ?></strong>, usando o sistema operacional: <strong><?= $key["system"]; ?></strong>, <strong><?= $key["x"]; ?></strong>x</div>
                                                   </div>
                                                   <div class="col-auto align-self-center">
                                                       <div class="badge bg-primary"></div>
                                                   </div>
                                               </div>
                                           </div>
                                       <?php
                                       endforeach;
                                   endif;

                                   $Pager->ExePaginator("db_users_active_store", "WHERE id_db_settings=:i ORDER BY id DESC", "i={$postId}");
                                   echo $Pager->getPaginator();
                                   ?>
                               </div>
                           </div>
                       </div>
                   </div>
               </div>
           </div>
       </div>
    </div>
</div>
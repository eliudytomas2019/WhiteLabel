<?php
$acao = strip_tags((filter_input(INPUT_POST, 'acao', FILTER_DEFAULT)));
if ($acao):
    require_once("../../Config.inc.php");

    $DaysX = ["", "Segunda-feira", "Terça-Feira", "Quarta-feira", "Quinta-feira", "Sexta-feira", "Sábado", "Domingo"];
    $DaysY = ["", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];
    $Meses = ["", "Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"];

    if (isset($_POST['level'])): $level = strip_tags(trim($_POST['level'])); endif;
    if (isset($_POST['id_user'])): $id_user = strip_tags(trim($_POST['id_user'])); endif;
    if (isset($_POST['id_user'])): $id_userX = strip_tags(trim($_POST['id_user'])); endif;
    if (isset($_POST['id_db_settings'])): $id_db_settings = (int) $_POST['id_db_settings']; endif;
    if (isset($_POST['postId'])): $postId = strip_tags(trim($_POST['postId'])); endif;
    $n =  '&id_db_settings='.$id_db_settings;

    $DB = new DBKwanzar();

    switch ($acao):
        case 'searchProductx':
            $value = strip_tags(trim($_POST['value']));

            $read = new Read();
            $read->ExeRead("cv_clinic_product", "WHERE (name LIKE '%' :link '%' AND id_db_settings=:idd) OR (codigo LIKE '%' :link '%' AND id_db_settings=:idd) OR (type LIKE '%' :link '%' AND id_db_settings=:idd) OR (id LIKE '%' :link '%' AND id_db_settings=:idd)", "link={$value}&idd={$id_db_settings}");
            if($read->getResult()):
                foreach($read->getResult() as $key):
                    ?>
                    <tr>
                        <td><?= $key['id']; ?></td>
                        <td><?= $key['name']; ?></td>
                        <td><?= $key['qtd']; ?></td>
                        <td><?= $key['unidades']; ?></td>
                        <td><?= $key['type'] ?></td>
                        <td>
                            <a href="panel.php?exe=fixos/moviment<?= $n; ?>&postid=<?= $key['id']; ?>" class="btn btn-default btn-sm">Movimentar</a>
                            <a href="panel.php?exe=fixos/updatex<?= $n; ?>&postid=<?= $key['id']; ?>" title="Editar" class="btn btn-warning btn-sm">Editar</a>
                            <a href="javascript:void()" onclick="DeleteProductx(<?= $key['id']?>)" title="Eliminar" class="btn btn-danger btn-sm">eliminar</a>
                        </td>
                    </tr>
                    <?php
                endforeach;
            endif;

            break;
        case 'FinalizarTratamento':
            $id = strip_tags(trim($_POST['id']));
            $postid = strip_tags(trim($_POST['id_paciente']));

            $Dental = new KwanzarDental();
            $Dental->FinalizarTratamento($id, $id_db_settings, $postid);

            if(!$Dental->getResult()):
                WSError($Dental->getError()[0], $Dental->getError()[1]);
            endif;

            break;
        case 'DeleteTratamento':
            $id = strip_tags(trim($_POST['id']));
            $postid = strip_tags(trim($_POST['id_paciente']));

            $Delete = new Delete();
            $Delete->ExeDelete("cv_customer_tratamento", "WHERE id=:tv AND id_paciente=:i AND id_db_settings=:id", "tv={$id}&i={$postid}&id={$id_db_settings}");

            if($Delete->getResult() || $Delete->getRowCount()):
            else:
                WSError("Aconteceu um erro ao apagar o tratamento!", WS_ERROR);
            endif;

            break;
        case 'ReadTratamento':
            $postid = strip_tags(trim($_POST['id_paciente']));
            require_once("OFilme.inc.php");

            break;
        case 'Tratamento':
            $Data['content_data'] = $_POST['content_data'];
            $Data['dente'] = strip_tags(trim($_POST['dente']));
            $Data['face'] = strip_tags(trim($_POST['face']));
            $Data['id_procedimento'] = strip_tags(trim($_POST['id_procedimento']));
            $Data['hora'] = strip_tags(trim($_POST['hora']));
            $Data['data'] = strip_tags(trim($_POST['data']));

            $postid = strip_tags(trim($_POST['id_paciente']));

            $Dental = new KwanzarDental();
            $Dental->Tratamento($id_user, $id_db_settings, $postid, $Data);

            if(!$Dental->getResult()):
                WSError($Dental->getError()[0], $Dental->getError()[1]);
            endif;

            break;
        case 'IrmaosAlmeida':
            $Data['content'] = strip_tags(trim($_POST['content']));
            $Data['status'] = strip_tags(trim($_POST['status']));

            $id = strip_tags(trim($_POST['id']));
            $postid = strip_tags(trim($_POST['id_paciente']));

            $Dental = new KwanzarDental();
            $Dental->UpdateOdontograma($id, $id_db_settings, $postid, $Data);

            if($Dental->getResult()):
                WSError($Dental->getError()[0], $Dental->getError()[1]);
            else:
                WSError($Dental->getError()[0], $Dental->getError()[1]);
            endif;

            break;
        case 'ReadGulheirmina':
            $postid = strip_tags(trim($_POST['id_paciente']));
            require_once("Odontograma.inc.php");
            break;
        case 'Marmelada':
            $id = strip_tags(trim($_POST['id']));
            $postid = strip_tags(trim($_POST['id_paciente']));

            $Read = new Read();
            $Read->ExeRead("cv_customer_odontograma", "WHERE id=:iv AND id_paciente=:i AND id_db_settings=:st ", "iv={$id}&i={$postid}&st={$id_db_settings}");
            if($Read->getResult()):
                $ClienteData = $Read->getResult()[0];
                ?>
                <form method="post" enctype="multipart/form-data">
                    <div class="col-12"><h4>Dente <?= $ClienteData['dente']; ?></h4></div>
                    <div class="col-12">
                        <span>Status</span>
                        <select class="form-control" id="status" name="status">
                            <option value="1"  <?php if (isset($ClienteData['status']) && $ClienteData['status'] == 1) echo 'selected="selected"'; ?>>Normal</option>
                            <option value="2"  <?php if (isset($ClienteData['status']) && $ClienteData['status'] == 2) echo 'selected="selected"'; ?>>Em Tratamento</option>
                            <option value="3"  <?php if (isset($ClienteData['status']) && $ClienteData['status'] == 3) echo 'selected="selected"'; ?>>Tratado</option>
                            <option value="4"  <?php if (isset($ClienteData['status']) && $ClienteData['status'] == 4) echo 'selected="selected"'; ?>>Removido</option>
                        </select>
                    </div>
                    <br/><div class="col-12">
                        <span>Descrição/Observação</span>
                        <textarea class="form-control" name="content" id="content"><?php if (!empty($ClienteData['content'])) echo htmlspecialchars($ClienteData['content']); ?></textarea>
                    </div>

                    <br/><div class="col-12">
                        <button type="button" onclick="Guilheirmina(<?= $id; ?>, <?= $postid ?>)" class="btn btn-primary">Salvar</button>
                    </div>
                </form>
                <?php
            endif;
            break;
        case 'searchProcedimentos':
            $value = strip_tags(trim($_POST['value']));

            $read = new Read();
            $read->ExeRead("cv_product", "WHERE (product LIKE '%' :link '%' AND id_db_settings=:idd) OR (codigo LIKE '%' :link '%' AND id_db_settings=:idd) OR (preco_venda LIKE '%' :link '%' AND id_db_settings=:idd) OR (type LIKE '%' :link '%' AND id_db_settings=:idd) OR (id LIKE '%' :link '%' AND id_db_settings=:idd)", "link={$value}&idd={$id_db_settings}");
            if($read->getResult()):
                foreach($read->getResult() as $key):

                    $promocao = explode("-", $key['data_fim_promocao']);
                    if($promocao[0] >= date('Y')):
                        if($promocao[1] >= date('m')):
                            if($promocao[2] >= date('d')):
                                $preco = $key['preco_promocao'];
                            else:
                                $preco = $key['preco_promocao'];
                            endif;
                        else:
                            $preco = $key['preco_promocao'];
                        endif;
                    elseif($promocao[0] < date('Y')):
                        $preco = $key['preco_venda'];
                    endif;


                    $DB = new DBKwanzar();
                    if($DB->CheckCpanelAndSettings($id_db_settings)['atividade'] == 1 || $DB->CheckCpanelAndSettings($id_db_settings)['atividade'] == 4):
                        $NnM = $key['quantidade'];
                    else:
                        $NnM = $key['gQtd'];
                    endif;

                    ?>
                    <tr>
                        <td><?= $key['id']; ?></td>
                        <td title="<?= $key['product']; ?>"><?= $key['product']; ?></td>
                        <td><?= number_format($preco, 2, ",", "."); ?> AOA</td>
                        <td>
                            <?php
                            $Read = new Read();
                            $Read->ExeRead("cv_category", "WHERE id=:i ", "i={$key['id_category']}");

                            if($Read->getResult()): echo $Read->getResult()[0]['category_title']; endif;
                            ?>
                        </td>
                        <td>
                            <a href="panel.php?exe=definitions/update<?= $n; ?>&postid=<?= $key['id']; ?>" title="Editar" class="btn btn-warning btn-sm">Editar</a>
                            <a href="javascript:void()" onclick="DeleteProcedimento(<?= $key['id']?>)" title="Eliminar" class="btn btn-danger btn-sm">apagar</a>
                        </td>
                    </tr>
                    <?php
                endforeach;
            endif;

            break;
        case 'ReadProcedimentos':
            require_once("search-product-and-services.inc.php");

            break;
        case 'DeleteProcedimento':
            $Delete = new Product();
            $Delete->ExeDelete($postId, $id_db_settings);

            WSError($Delete->getError()[0], $Delete->getError()[1]);

            break;
        case 'ReadArquivo':
            $postid = strip_tags(trim($_POST['id_paciente']));
            require_once("Arq.inc.php");
            break;
        case 'DeleteArquivo':
            $id = strip_tags(trim($_POST['id']));
            $postid = strip_tags(trim($_POST['id_paciente']));

            $Delete = new Delete();
            $Delete->ExeDelete("cv_customer_arquivo", "WHERE id=:i ", "i={$id}");

            if($Delete->getResult() || $Delete->getRowCount()):
                WSError("Arquivo apagado com sucesso!", WS_ACCEPT);
            else:
                WSError("Aconteceu um erro inesperado ao apagar o arquivo!", WS_ERROR);
            endif;

            break;
        case 'UpdateSchedule':
            $Data['date_schedule'] = strip_tags(trim($_POST['date_schedule']));
            $Data['hora_i_schedule'] = strip_tags(trim($_POST['hora_i_schedule']));
            $Data['hora_f_schedule'] = strip_tags(trim($_POST['hora_f_schedule']));
            $Data['status_schedule'] = strip_tags(trim($_POST['status_schedule']));
            $Data['id_medico'] = strip_tags(trim($_POST['id_medico']));
            $Data['id_paciente'] = strip_tags(trim($_POST['id_paciente']));

            $Data['content_schedule'] = $_POST['content_schedule'];

            $Dental = new KwanzarDental();
            $Dental->UpdateSchedule($id_db_settings, $postId, $Data);

            if($Dental->getResult()):
                WSError($Dental->getError()[0], $Dental->getError()[1]);
            else:
                WSError($Dental->getError()[0], $Dental->getError()[1]);
            endif;

            break;
        case 'id_event_schudule':
            $id_event_schudule = (int) $_POST['id_event_schudule'];

            $Read = new Read();
            $Read->ExeRead("db_clinic_agendamento", "WHERE id=:i ", "i={$id_event_schudule}");

            if($Read->getResult()):
                $ClienteData = $Read->getResult()[0];
                ?>

                <form method="post" action="" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-4">
                            <span>Paciente</span>
                            <select name="id_paciente" disabled id="id_paciente" class="form-control">
                                <option>--- Seleciona o paciente ---</option>
                                <?php
                                $Read = new Read();
                                $Read->ExeRead("cv_customer", "WHERE id_db_settings=:i ", "i={$id_db_settings}");

                                if($Read->getResult()):
                                    foreach ($Read->getResult() as $key):

                                        if(!isset($key['dia']) || empty($key['dia'])): $key['dia'] = date('d'); endif;
                                        if(!isset($key['mes']) || empty($key['mes'])): $key['mes'] = date('m'); endif;
                                        if(!isset($key['ano']) || empty($key['ano'])): $key['ano'] = date('Y'); endif;
                                        ?>
                                        <option value="<?= $key['id']; ?>" <?php if(isset($ClienteData['id_paciente']) && $ClienteData['id_paciente'] == $key['id']) echo "selected"; ?>><?= $key['nome']. " ({$key['dia']}/{$Meses[intval($key['mes'])]}/{$key['ano']}) "; ?></option>
                                    <?php
                                    endforeach;
                                endif;
                                ?>
                            </select>
                        </div>
                        <div class="col-4">
                            <span>Médico</span>
                            <select name="id_medico" disabled id="id_medico" class="form-control">
                                <option>--- Seleciona o Médico ---</option>
                                <?php
                                $lv = 3;
                                $status = 1;
                                $Read = new Read();
                                $Read->ExeRead("db_users", "WHERE id_db_settings=:i AND level=:lv AND status=:st ", "i={$id_db_settings}&lv={$lv}&st={$status}");

                                if($Read->getResult()):
                                    foreach ($Read->getResult() as $key):
                                        ?>
                                        <option value="<?= $key['id']; ?>" <?php if(isset($ClienteData['id_medico']) && $ClienteData['id_medico'] == $key['id']) echo "selected"; ?>><?= $key['name']." ({$key['username']})"; ?></option>
                                    <?php
                                    endforeach;
                                endif;
                                ?>
                            </select>
                        </div>
                        <div class="col-4">
                            <span>Status</span>
                            <select name="status_schedule" id="status_schedule" class="form-control">
                                <option value="1" <?php if(isset($ClienteData['status_schedule']) && $ClienteData['status_schedule'] == 1) echo "selected"; ?>>Agendada</option>
                                <option value="2" <?php if(isset($ClienteData['status_schedule']) && $ClienteData['status_schedule'] == 2) echo "selected"; ?>>Confirmada</option>
                                <option value="3" <?php if(isset($ClienteData['status_schedule']) && $ClienteData['status_schedule'] == 3) echo "selected"; ?>>Paciente aguardando</option>
                                <option value="4" <?php if(isset($ClienteData['status_schedule']) && $ClienteData['status_schedule'] == 4) echo "selected"; ?>>Paciente em atendimento</option>
                                <option value="5" <?php if(isset($ClienteData['status_schedule']) && $ClienteData['status_schedule'] == 5) echo "selected"; ?>>Finalizada</option>
                                <option value="6" <?php if(isset($ClienteData['status_schedule']) && $ClienteData['status_schedule'] == 6) echo "selected"; ?>>Faltou</option>
                                <option value="7" <?php if(isset($ClienteData['status_schedule']) && $ClienteData['status_schedule'] == 7) echo "selected"; ?>>Cancelado pelo Paciente</option>
                                <option value="8" <?php if(isset($ClienteData['status_schedule']) && $ClienteData['status_schedule'] == 8) echo "selected"; ?>>Cancelado pelo Médico</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <span>Data</span>
                            <input type="date" id="date_schedule" value="<?php if(!empty($ClienteData['date_schedule'])) echo $ClienteData['date_schedule']; ?>" name="date_schedule" class="form-control">
                        </div>
                        <div class="col-4">
                            <span>Hora Inícial</span>
                            <input type="time" id="hora_i_schedule" value="<?php if(!empty($ClienteData['hora_i_schedule'])) echo $ClienteData['hora_i_schedule']; ?>" name="hora_i_schedule" class="form-control">
                        </div>
                        <div class="col-4">
                            <span>Hora Final</span>
                            <input type="time" id="hora_f_schedule" value="<?php if(!empty($ClienteData['hora_f_schedule'])) echo $ClienteData['hora_f_schedule']; ?>" name="hora_f_schedule" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <span>Observações</span>
                        <textarea class="form-control" name="content_schedule" id="content_schedule"><?php if(!empty($ClienteData['content_schedule'])) echo $ClienteData['content_schedule']; ?></textarea>
                    </div>
                    <hr/>
                    <button type="button" onclick="UpdateSchedule(<?= $id_event_schudule; ?>);" class="btn btn-primary">Salvar</button>
                </form>
                <?php
            endif;

            break;
        case 'CreateSchedule':
            $Data['date_schedule'] = strip_tags(trim($_POST['date_schedule']));
            $Data['hora_i_schedule'] = strip_tags(trim($_POST['hora_i_schedule']));
            $Data['hora_f_schedule'] = strip_tags(trim($_POST['hora_f_schedule']));
            $Data['status_schedule'] = strip_tags(trim($_POST['status_schedule']));
            $Data['id_medico'] = strip_tags(trim($_POST['id_medico']));
            $Data['id_paciente'] = strip_tags(trim($_POST['id_paciente']));

            $Data['content_schedule'] = $_POST['content_schedule'];

            $Dental = new KwanzarDental();
            $Dental->CreateSchedule($id_db_settings, $Data);

            if($Dental->getResult()):
                WSError($Dental->getError()[0], $Dental->getError()[1]);
            else:
                WSError($Dental->getError()[0], $Dental->getError()[1]);
            endif;

            break;
        case 'DeletePaciente':
            $delete = (int) filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

            $read = new Read();
            $read->ExeRead("sd_billing", "WHERE id_db_settings=:i AND id_customer=:iT", "i={$id_db_settings}&iT={$delete}");
            if(!$read->getResult()):
                $Delete = new Delete();
                $Delete->ExeDelete("cv_customer", "WHERE id=:ip AND id_db_settings=:i", "ip={$delete}&i={$id_db_settings}");

                if($Delete->getResult() || $Delete->getRowCount()):
                    WSError("A ficha do paciente foi apagada com sucesso!", WS_ACCEPT);
                else:
                    WSError("Ops: aconteceu um erro inesperado ao apagar a ficha do paciente", WS_ERROR);
                endif;
            else:
                WSError("Não é permitido apagar a ficha do paciente na qual já foi consultado!", WS_INFOR);
            endif;

            break;
        case 'searchPacientes':
            $value = strip_tags(trim($_POST['value']));

            $read = new Read();
            $read->ExeRead("cv_customer", "WHERE (nome LIKE '%' :link '%' AND id_db_settings=:idd) OR (nif LIKE '%' :link '%' AND id_db_settings=:idd) OR (telefone LIKE '%' :link '%' AND id_db_settings=:idd) OR (email LIKE '%' :link '%' AND id_db_settings=:idd) OR (id LIKE '%' :link '%' AND id_db_settings=:idd)", "link={$value}&idd={$id_db_settings}");
            if($read->getResult()):
                foreach($read->getResult() as $key):
                    extract($key);
                    if($level == 3):
                        $Readx = new Read();
                        $Readx->ExeRead("db_clinic_agendamento", "WHERE id_db_settings=:i AND id_paciente=:iv AND id_medico=:mm ", "i={$id_db_settings}&iv={$key['id']}&mm={$id_user}");
                        if($Readx->getResult()):
                            require("EuPraMerdaNaoVolto.inc.php");
                        endif;
                    else:
                        require("EuPraMerdaNaoVolto.inc.php");
                    endif;
                endforeach;
            endif;


            break;
        case 'SalvePaciente':
            $Data['nome'] = strip_tags(trim($_POST['nome']));
            $Data['nif'] = strip_tags(trim($_POST['nif']));
            $Data['telefone'] = strip_tags(trim($_POST['telefone']));
            $Data['email'] = strip_tags(trim($_POST['email']));
            $Data['endereco'] = strip_tags(trim($_POST['endereco']));

            $Dental = new KwanzarDental();
            $Dental->SalvePaciente($id_db_settings, $Data);

            if($Dental->getResult()):
                WSError($Dental->getError()[0], $Dental->getError()[1]);
            else:
                WSError($Dental->getError()[0], $Dental->getError()[1]);
            endif;

            break;
        case 'ReadPacientes':
            require_once("Lutchiana.inc.php");
            break;
        case 'SearchUsersX':
            $value = strip_tags(trim($_POST['value']));

            $read = new Read();
            $read->ExeRead("db_users", "WHERE (username LIKE '%' :link '%' AND id_db_settings=:idd) OR (name LIKE '%' :link '%' AND id_db_settings=:idd) OR (id LIKE '%' :link '%' AND id_db_settings=:idd)", "link={$value}&idd={$id_db_settings}");
            if($read->getResult()):
                foreach($read->getResult() as $key):
                    extract($key);
                    if($DB->CheckCpanelAndSettings($id_db_settings, $id_db_kwanzar)['atividade'] == 1 || $DB->CheckCpanelAndSettings($id_db_settings, $id_db_kwanzar)['atividade'] == 3):
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
                            <?php if($DB->CheckCpanelAndSettings($id_db_settings, $id_db_kwanzar)['atividade'] == 19): ?>
                                <?php if($key['level'] == 3): ?>
                                    <a href="panel.php?exe=settings/UsersOptions<?= $n; ?>&id_user=<?= $key['id']; ?>" class="btn btn-default btn-sm">Horário e Agenda</a>
                                <?php endif; ?>
                            <?php endif; ?>
                            <a href="panel.php?exe=settings/UpdateUsers<?= $n; ?>&id_user=<?= $key['id']; ?>" class="btn btn-primary btn-sm">Editar</a>
                            <!--- <a href="#" class="btn btn-danger btn-sm" onclick="DeleteUsers(<?= $key['id']; ?>);">Eliminar</a> --->
                            <a href="#" class="btn btn-warning btn-sm" onclick="SuspenderConta(<?= $key['id']; ?>);">Suspender</a>
                        </td>
                    </tr>
                <?php
                endforeach;
            endif;

            break;
        case 'DeletePorcentagem':
            $id = strip_tags(trim($_POST['id']));

            $Delete = new Delete();
            $Delete->ExeDelete("db_settings_clinic_porcentagem", "WHERE id_db_settings=:i AND id=:iv ", "i={$id_db_settings}&iv={$id}");

            if($Delete->getResult() || $Delete->getRowCount()):
                WSError("Arquivo apagado com sucesso!", WS_ACCEPT);
            else:
                WSError("Aconteceu um erro inesperado ao apagar o arquivo!", WS_ERROR);
            endif;

            break;
        case 'ReadGanhos':
            require_once("porcentagem.inc.php");
            break;
        case 'PorcentagemGanhos':
            $Data['porcentagem'] = strip_tags(trim($_POST['porcentagem']));

            $Dental = new KwanzarDental();
            $Dental->PorcentagemGanhos($id_db_settings, $id_user, $Data);

            if($Dental->getResult()):
                WSError($Dental->getError()[0], $Dental->getError()[1]);
            else:
                WSError($Dental->getError()[0], $Dental->getError()[1]);
            endif;

            break;
        case 'ClinicHorarioUpdate':
            $Data['hora_i'] = strip_tags(trim($_POST['hora_i']));
            $Data['hora_f'] = strip_tags(trim($_POST['hora_f']));
            $Data['dia_da_semana'] = strip_tags(trim($_POST['dia_da_semana']));

            $Dental = new KwanzarDental();
            $Dental->ClinicHorarioUpdate($postId, $Data);

            if($Dental->getResult()):
                WSError($Dental->getError()[0], $Dental->getError()[1]);
            else:
                WSError($Dental->getError()[0], $Dental->getError()[1]);
            endif;

            break;
        case 'DeleteHorario':
            $id = strip_tags(trim($_POST['id']));

            $Delete = new Delete();
            $Delete->ExeDelete("db_users_clinic_horario", "WHERE id=:i ", "i={$id}");

            if($Delete->getResult() || $Delete->getRowCount()):
                WSError("Arquivo apagado com sucesso!", WS_ACCEPT);
            else:
                WSError("Aconteceu um erro inesperado ao apagar o arquivo!", WS_ERROR);
            endif;

            break;
        case 'ReadHorario':
            require_once("Horario.inc.php");
            break;
        case 'ClinicHorario':
            $Data['hora_i'] = strip_tags(trim($_POST['hora_i']));
            $Data['hora_f'] = strip_tags(trim($_POST['hora_f']));
            $Data['dia_da_semana'] = strip_tags(trim($_POST['dia_da_semana']));

            $Dental = new KwanzarDental();
            $Dental->CreateHorario($id_user, $id_db_settings, $Data);

            if($Dental->getResult()):
                WSError($Dental->getError()[0], $Dental->getError()[1]);
            else:
                WSError($Dental->getError()[0], $Dental->getError()[1]);
            endif;

            break;
        default:
            WSError("Ops: não encontramos a ação desejada!", WS_INFOR);
    endswitch;;
endif;
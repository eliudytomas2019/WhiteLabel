<?php
require_once("_disk/IncludesApp/PatientUsers.inc.php");
?>
<br/><div class="row gx-lg-4">
    <?php require_once("_disk/IncludesApp/MenuPatient.inc.php"); ?>
    <div class="col-lg-9">
        <div class="card">
            <div class="card-header">
                <h5 class="modal-title">Visão geral</h5>
            </div>
            <div class="card-body">
                <div id="Gulheirmina">
                    <?php require_once("_disk/SystemClinic/Odontograma.inc.php"); ?>
                </div>
                <br/><div class="row">
                    <div class="col-lg-6">
                        <div class="d-lg-block col-lg-12">
                            <h2 class="infoY">INFORMAÇÕES BÁSICAS</h2>
                            <div class="ciumenta">
                                <label>Anamnese:</label>
                                <?php
                                    $Read = new Read();
                                    $Read->ExeRead("cv_customer_anamnese", "WHERE id_paciente=:userid AND id_db_settings=:i", "userid={$postid}&i={$id_db_settings}");
                                ?>
                                <p><?php if($Read->getResult() || $Read->getResult()): echo "Preenchida"; endif; ?></p>
                            </div>
                            <div class="ciumenta">
                                <label>Telefone:</label>
                                <p>+244 <?= $CustomerData['telefone']; ?></p>
                            </div>
                            <div class="ciumenta">
                                <label>Endereço:</label>
                                <p><?= $CustomerData['endereco']; ?></p>
                            </div>
                            <div class="ciumenta">
                                <label>E-mail:</label>
                                <p><?= $CustomerData['email']; ?></p>
                            </div>
                            <div class="ciumenta">
                                <label>Data de Nascimento:</label>
                                <?php if(!empty($CustomerData['ano'])): $dateDd = $Meses[$CustomerData['mes']]; else: $dateDd = null; endif; ?>
                                <p><?= $CustomerData['dia']. " de ".$dateDd." de ".$CustomerData['ano']; ?></p>
                            </div>
                            <div class="ciumenta">
                                <label>Sexo: </label>
                                <p><?= $CustomerData['sexo']; ?></p>
                            </div>
                            <div class="ciumenta">
                                <label>Observações: </label>
                                <p><?= $CustomerData['obs']; ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="d-lg-block col-lg-12">
                            <h2 class="infoY">CONTATO DE EMERGÊNCIA</h2>
                            <?php
                            $ReadUser = new Read;
                            $ReadUser->ExeRead("cv_customer_contact", "WHERE id_paciente=:userid AND id_db_settings=:i", "userid={$postid}&i={$id_db_settings}");
                            if ($ReadUser->getResult()):
                                $ClienteData = $ReadUser->getResult()[0];
                            else:
                                $ClienteData = null;
                            endif;
                            ?>
                            <div class="ciumenta">
                                <label>Nome:</label>
                                <p><?php if(isset($ClienteData["nome"])) echo $ClienteData["nome"]; ?></p>
                            </div>
                            <div class="ciumenta">
                                <label>Telefone:</label>
                                <p>+244 <?php if(isset($ClienteData["telefone"])) echo $ClienteData["telefone"]; ?></p>
                            </div>
                            <div class="ciumenta">
                                <label>E-mail:</label>
                                <p><?php if(isset($ClienteData["email"])) echo $ClienteData["email"]; ?></p>
                            </div>

                            <h2 class="infoY">CONSULTAS</h2>
                            <?php
                            $posti = 0;
                            $getPage = filter_input(INPUT_GET, 'page',FILTER_VALIDATE_INT);
                            $Pager = new Pager("panel.php?exe=patient/history{$n}&postid={$postid}&page=");
                            $Pager->ExePager($getPage, 3);

                            $Readx = new Read();
                            $Readx->ExeRead("db_clinic_agendamento", "WHERE id_db_settings=:i AND id_paciente=:iv ORDER BY id DESC LIMIT :limit OFFSET :offset", "i={$id_db_settings}&iv={$postid}&limit={$Pager->getLimit()}&offset={$Pager->getOffset()}");
                            if($Readx->getResult()):
                                foreach ($Readx->getResult() as $key):
                                    $xDate = explode("-", $key['date_schedule']);
                                    ?>
                                    <div class="ciumenta">
                                        <label>Descrição: </label>
                                        <p><?= $xDate[2]." de ".$Meses[intval($xDate[1])]." de ".$xDate[0]." | status: ".$StatusSchedule[$key['status_schedule']]; ?> | Dr.(a): <?php $Read->ExeRead("db_users", "WHERE id=:i ", "i={$key['id_medico']}"); if($Read->getResult()): echo $Read->getResult()[0]['name']; endif; ?> | Obs: <?= $key["content_schedule"]; ?></p>
                                    </div>
                                    <?php
                                endforeach;
                            endif;

                            $Pager->ExePaginator("db_clinic_agendamento", "WHERE id_db_settings=:i AND id_paciente=:iv ORDER BY id DESC ", "i={$id_db_settings}&iv={$postid}");
                            echo $Pager->getPaginator();
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
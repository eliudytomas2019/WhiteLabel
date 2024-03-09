<?php
require_once("_disk/IncludesApp/PatientUsers.inc.php");
?>
<br/><div class="row gx-lg-4">
    <?php require_once("_disk/IncludesApp/MenuPatient.inc.php"); ?>
    <div class="col-lg-9">

        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <div class="page-pretitle">
                        <?= $Index['name']; ?>
                    </div>
                    <h2 class="page-title">
                        Documentos
                    </h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <?php if($userlogin['level'] == 3 || $userlogin['level'] >= 4): ?>
                            <a href="panel.php?exe=patient/receita<?= $n; ?>&postid=<?= $postid; ?>" class="btn btn-default"><!-- Download SVG icon from http://tabler-icons.io/i/barcode -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7v-1a2 2 0 0 1 2 -2h2" /><path d="M4 17v1a2 2 0 0 0 2 2h2" /><path d="M16 4h2a2 2 0 0 1 2 2v1" /><path d="M16 20h2a2 2 0 0 0 2 -2v-1" /><rect x="5" y="11" width="1" height="2" /><line x1="10" y1="11" x2="10" y2="13" /><rect x="14" y="11" width="1" height="2" /><line x1="19" y1="11" x2="19" y2="13" /></svg> Receita</a>
                            <a href="panel.php?exe=patient/justificativo<?= $n; ?>&postid=<?= $postid; ?>" class="btn btn-primary"><!-- Download SVG icon from http://tabler-icons.io/i/book -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 19a9 9 0 0 1 9 0a9 9 0 0 1 9 0" /><path d="M3 6a9 9 0 0 1 9 0a9 9 0 0 1 9 0" /><line x1="3" y1="6" x2="3" y2="19" /><line x1="12" y1="6" x2="12" y2="19" /><line x1="21" y1="6" x2="21" y2="19" /></svg> Atestado</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="modal-title">Documentos</h5>
            </div>
            <div class="card-body">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Historico de Receitas</h3>&nbsp;&nbsp;&nbsp;
                        </div>
                        <div id="aPaulo"></div>
                        <div class="table-responsive">
                            <table class="table" style="text-align: left!important;align-content: flex-start!important;align-items: flex-start!important;">
                                <thead>
                                <tr>
                                    <th>Data de Emissão</th>
                                    <th>Receita</th>
                                    <th>Médico</th>
                                    <th style="width: 350px!important">-</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $posti = 0;
                                $getPage5 = filter_input(INPUT_GET, 'page5',FILTER_VALIDATE_INT);
                                $Pager = new Pager("panel.php?exe=patient/Documentos{$n}&postid={$postid}&page5=");
                                $Pager->ExePager($getPage5, 10);

                                $Read = new Read();
                                $Read->ExeRead("cv_clinic_receita", "WHERE id_paciente=:i AND id_db_settings=:id ORDER BY id DESC LIMIT :limit OFFSET :offset", "i={$postid}&id={$id_db_settings}&limit={$Pager->getLimit()}&offset={$Pager->getOffset()}");

                                if($Read->getResult()):
                                    foreach ($Read->getResult() as $keys):
                                        ?>
                                        <tr>
                                            <td><?= $keys['data_emissao']; ?></td>
                                            <td>receita_0<?= $keys['id']; ?></td>
                                            <td><?php $Read->ExeRead("db_users", "WHERE id=:i ", "i={$keys['id_user']}"); if($Read->getResult()): echo $Read->getResult()[0]['name']; endif; ?></td>
                                            <td>
                                                <a href="print_dental.php?<?= $n; ?>&id_paciente=<?= $postid; ?>&postId=<?= $keys['id']; ?>&action=02" target="_blank" class="btn btn-default btn-sm">Imprimir</a>
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
                            $Pager->ExePaginator("cv_clinic_receita", "WHERE id_paciente=:i AND id_db_settings=:id ORDER BY id DESC ", "i={$postid}&id={$id_db_settings}");
                            echo $Pager->getPaginator();
                            ?>
                        </div>
                    </div>
                </div>
                <br/>
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Historico de Atestado</h3>&nbsp;&nbsp;&nbsp;
                        </div>
                        <div id="aPaulo"></div>
                        <div class="table-responsive">
                            <table class="table" style="text-align: left!important;align-content: flex-start!important;align-items: flex-start!important;">
                                <thead>
                                <tr>
                                    <th>Data de Emissão</th>
                                    <th>Atestado</th>
                                    <th>Médico</th>
                                    <th style="width: 350px!important">-</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $posti = 0;
                                $getPage55 = filter_input(INPUT_GET, 'page55',FILTER_VALIDATE_INT);
                                $Pager = new Pager("panel.php?exe=patient/Documentos{$n}&postid={$postid}&page55=");
                                $Pager->ExePager($getPage55, 10);

                                $Read = new Read();
                                $Read->ExeRead("cv_clinic_justificativo", "WHERE id_paciente=:i AND id_db_settings=:id ORDER BY id DESC LIMIT :limit OFFSET :offset", "i={$postid}&id={$id_db_settings}&limit={$Pager->getLimit()}&offset={$Pager->getOffset()}");

                                if($Read->getResult()):
                                    foreach ($Read->getResult() as $keys):
                                        ?>
                                        <tr>
                                            <td><?= $keys['data_emissao']; ?></td>
                                            <td>atestado_0<?= $keys['id']; ?></td>
                                            <td><?php $Read->ExeRead("db_users", "WHERE id=:i ", "i={$keys['id_user']}"); if($Read->getResult()): echo $Read->getResult()[0]['name']; endif; ?></td>
                                            <td>
                                                <a href="print_dental.php?<?= $n; ?>&id_paciente=<?= $postid; ?>&postId=<?= $keys['id']; ?>&action=03" target="_blank" class="btn btn-default btn-sm">Imprimir</a>
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
                            $Pager->ExePaginator("cv_clinic_receita", "WHERE id_paciente=:i AND id_db_settings=:id ORDER BY id DESC ", "i={$postid}&id={$id_db_settings}");
                            echo $Pager->getPaginator();
                            ?>
                        </div>
                    </div>
                </div>
                <br/>
                <div class="col-12">


                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Historico de Facturas</h3>&nbsp;&nbsp;&nbsp;
                        </div>
                        <div id="aPaulo"></div>
                        <div class="table-responsive">
                            <table class="table" style="text-align: left!important;align-content: flex-start!important;align-items: flex-start!important;">
                                <thead>
                                <tr>
                                    <th>Número</th>
                                    <th>Cliente</th>
                                    <th>Forma de Pagamento</th>
                                    <th>Data</th>
                                    <th>Documento</th>
                                    <th style="width: 350px!important">-</th>
                                    <th>ID</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                if(DBKwanzar::CheckConfig($id_db_settings) == false || Strong::Config($id_db_settings)['JanuarioSakalumbu'] == 3 || Strong::Config($id_db_settings)['JanuarioSakalumbu'] == '' || Strong::Config($id_db_settings)['JanuarioSakalumbu'] == null):
                                    $st = 3;
                                else:
                                    $st = 2;
                                endif;

                                $s = 0;
                                $posti = 0;
                                $getPage1 = filter_input(INPUT_GET, 'page',FILTER_VALIDATE_INT);
                                $Pager = new Pager("panel.php?exe=patient/Documentos{$n}&postid=".$postid."&page=");
                                $Pager->ExePager($getPage1, 10);

                                $n1 = "sd_billing";
                                $n3 = "sd_billing_pmp";
                                $n2 = "sd_retification";
                                $n4 = "sd_retification_pmp";
                                $n5 = "sd_guid";
                                $n6 = "sd_guid_pmp";
                                $PPs = "'PP'";

                                $read = new Read();
                                $read->ExeRead("{$n1}", "WHERE ({$n1}.id_db_settings=:i AND {$n1}.id_customer=:is AND {$n1}.InvoiceType!={$PPs} AND {$n1}.session_id=:id AND {$n1}.status=:st AND {$n1}.suspenso={$s}) ORDER BY {$n1}.id DESC LIMIT :limit OFFSET :offset", "i={$id_db_settings}&is={$postid}&id={$id_user}&st={$st}&limit={$Pager->getLimit()}&offset={$Pager->getOffset()}");
                                if($read->getResult()):
                                    foreach ($read->getResult() as $key):
                                        require("_disk/AppData/ResultDocumentsInvoice.inc.php");
                                    endforeach;
                                endif;
                                ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer d-flex align-items-center">
                            <?php
                            $Pager->ExePaginator("{$n1}", "WHERE ({$n1}.id_db_settings=:i AND {$n1}.id_customer=:is AND {$n1}.InvoiceType!={$PPs} AND {$n1}.session_id=:id AND {$n1}.status=:st AND {$n1}.suspenso={$s}) ORDER BY {$n1}.id DESC", "i={$id_db_settings}&is={$postid}&id={$id_user}&st={$st}");
                            echo $Pager->getPaginator();
                            ?>
                        </div>
                    </div>
                </div>
                <br/>
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Historico de Proformas</h3>&nbsp;&nbsp;&nbsp;
                        </div>
                        <div id="aPaulo"></div>
                        <div class="table-responsive">
                            <table class="table" style="text-align: left!important;align-content: flex-start!important;align-items: flex-start!important;">
                                <thead>
                                <tr>
                                    <th>Número</th>
                                    <th>Cliente</th>
                                    <th>Data</th>
                                    <th>Documento</th>
                                    <th style="width: 350px!important">-</th>
                                    <th>ID</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                if(DBKwanzar::CheckConfig($id_db_settings) == false || Strong::Config($id_db_settings)['JanuarioSakalumbu'] == 3 || Strong::Config($id_db_settings)['JanuarioSakalumbu'] == '' || Strong::Config($id_db_settings)['JanuarioSakalumbu'] == null):
                                    $st = 3;
                                else:
                                    $st = 2;
                                endif;

                                $s = 0;
                                $posti = 0;
                                $getPage2 = filter_input(INPUT_GET, 'page2',FILTER_VALIDATE_INT);
                                $Pagers = new Pager("panel.php?exe=patient/Documentos{$n}&postid={$postid}&page2=");
                                $Pagers->ExePager($getPage2, 10);

                                $n1 = "sd_billing";
                                $n3 = "sd_billing_pmp";
                                $PPs = "PP";

                                $read = new Read();
                                $read->ExeRead("{$n1}", "WHERE ({$n1}.id_db_settings=:i AND {$n1}.id_customer=:is AND {$n1}.session_id=:id AND {$n1}.InvoiceType=:invoice AND {$n1}.status=:st AND {$n1}.suspenso={$s}) ORDER BY {$n1}.id DESC LIMIT :limit OFFSET :offset", "i={$id_db_settings}&is={$postid}&id={$id_user}&invoice={$PPs}&st={$st}&limit={$Pagers->getLimit()}&offset={$Pagers->getOffset()}");
                                if($read->getResult()):
                                    foreach ($read->getResult() as $key):
                                        require("_disk/AppData/ResultDocumentsProformas.inc.php");
                                    endforeach;
                                endif;
                                ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer d-flex align-items-center">
                            <?php
                            $Pagers->ExePaginator("{$n1}", "WHERE ({$n1}.id_db_settings=:i AND {$n1}.id_customer=:is AND {$n1}.session_id=:id AND {$n1}.InvoiceType=:invoice AND {$n1}.status=:st AND {$n1}.suspenso={$s}) ORDER BY {$n1}.id DESC", "i={$id_db_settings}&is={$postid}&id={$id_user}&invoice={$PPs}&st={$st}");
                            echo $Pagers->getPaginator();
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
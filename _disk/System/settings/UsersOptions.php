<?php
$id_userX = strip_tags(trim(filter_input(INPUT_GET, 'id_user', FILTER_VALIDATE_INT)));

if(!class_exists('login')):
    header("index.php");
    die();
endif;

if($level >= 4): $n =  '&id_db_settings='.$id_db_settings; else: $n = null; endif;

if($userlogin['level'] < 3):
    header("location: panel.php?exe=default/index".$n);
endif;

require_once("_disk/IncludesApp/Modal.inc.php");
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
        <div class="page-header">
            <div class="row align-items-center">
                <?php require_once("btnBreak.inc.php"); ?>
                <div class="col">
                    <div class="page-pretitle">
                        <?= $Index['name']; ?>
                    </div>
                    <h2 class="page-title">
                        Horário e Agenda
                    </h2>
                </div>

                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-horario-users">
                            <!-- Download SVG icon from http://tabler-icons.io/i/calendar-stats -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M11.795 21h-6.795a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v4" /><path d="M18 14v4h4" /><circle cx="18" cy="18" r="4" /><path d="M15 3v4" /><path d="M7 3v4" /><path d="M3 11h16" /></svg>
                            Horário e Agenda</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h5 class="modal-title">Horário e Agenda</h5>
            </div>
            <div class="card-body">
                <div id="getResult"></div>
                <div class="col-lg-12">
                    <h2>Horário e Angenda</h2>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Hora Inícial</th>
                                <th>Hora Final</th>
                                <th>Dia da Semana</th>
                                <th>-</th>
                            </tr>
                        </thead>
                        <tbody id="TheBox">
                            <?php require_once("_disk/SystemClinic/Horario.inc.php"); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
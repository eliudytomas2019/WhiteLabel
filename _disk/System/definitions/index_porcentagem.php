<?php
if(!class_exists('login')):
    header("index.php");
    die();
endif;

if($level >= 4): $n =  '&id_db_settings='.$id_db_settings; else: $n = null; endif;
require_once("_disk/IncludesApp/Modal-porcentagem-de-ganho.inc.php");
?>
<div class="page-header d-print-none">
    <div class="row align-items-center">
        <div class="col">
            <h2 class="page-title">
                Administração
            </h2>
        </div>
    </div>
</div>
<div class="row gx-lg-4">
    <?php require_once("_disk/IncludesApp/MenuDefinitions.inc.php"); ?>
    <div class="col-lg-9">
        <div class="row align-items-center">
            <div class="col">
                <div class="page-pretitle">
                    <?= $Index['name']; ?>
                </div>
                <h2 class="page-title">
                    Porcentagem de ganho (Médicos)
                </h2>
            </div>
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    <a href="" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modal-porcentagem-de-ganho">
                        <!-- Download SVG icon from http://tabler-icons.io/i/businessplan -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><ellipse cx="16" cy="6" rx="5" ry="3" /><path d="M11 6v4c0 1.657 2.239 3 5 3s5 -1.343 5 -3v-4" /><path d="M11 10v4c0 1.657 2.239 3 5 3s5 -1.343 5 -3v-4" /><path d="M11 14v4c0 1.657 2.239 3 5 3s5 -1.343 5 -3v-4" /><path d="M7 9h-2.5a1.5 1.5 0 0 0 0 3h1a1.5 1.5 0 0 1 0 3h-2.5" /><path d="M5 15v1m0 -8v1" /></svg>
                        Criar Porcentagem</a>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h5 class="modal-title">Porcentagem de ganho (Médicos)</h5>
            </div>
            <div class="card-body">
                <div id="getResult"></div>
                <div class="col-lg-12">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Médico</th>
                            <th>Porcentagem</th>
                            <th>-</th>
                        </tr>
                        </thead>
                        <tbody id="TheBox">
                        <?php require_once("_disk/SystemClinic/porcentagem.inc.php"); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
if(!class_exists('login')):
    header("index.php");
    die();
endif;

if($level >= 4): $n =  '&id_db_settings='.$id_db_settings; else: $n = null; endif;

if($userlogin['level'] < 1):
    header("location: panel.php?exe=default/home".$n);
endif;
?>
<div class="page-header d-print-none">
    <div class="row align-items-center">
        <div class="col">
            <div class="page-pretitle">
                <?= $Index['name']; ?>
            </div>
            <h2 class="page-title">
                Observações
            </h2>
        </div>
        <div class="col-auto ms-auto d-print-none">
            <div class="btn-list">
                <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalObs">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg>
                    Nova Observação
                </a>
            </div>
        </div>
    </div>
</div>

<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Observações</h3>&nbsp;&nbsp;&nbsp;
        </div>
        <div id="aPaulo"></div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th style="max-width: 200px!important;">ID</th>
                    <th style="max-width: 200px!important;">Observação</th>
                    <th style="max-width: 200px!important;">Data</th>
                    <th>-</th>
                </tr>
                </thead>
                <tbody id="Seketxe">
                <?php
                    require_once("KwanzarApp/SystemFiles/DripDosPaisII.inc.php");
                ?>
                </tbody>
            </table>
        </div>
        <div class="card-footer d-flex align-items-center">
            <?php
                $Pager->ExePaginator("cv_obs", "WHERE id_db_settings=:id ORDER BY id DESC", "id={$id_db_settings}");
                echo $Pager->getPaginator();
            ?>
        </div>
    </div>
</div>
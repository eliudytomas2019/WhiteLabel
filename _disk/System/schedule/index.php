<?php
if(!class_exists('login')):
    header("index.php");
    die();
endif;

if($level >= 4): $n =  '&id_db_settings='.$id_db_settings; else: $n = null; endif;

if($userlogin['level'] < 1):
    header("location: panel.php?exe=default/home".$n);
endif;


require_once("_disk/SystemClinic/Schedule.inc.php");
require_once("_disk/SystemClinic/Schedule-body.inc.php");
?>

<div class="row" style="margin: 0 auto!important;">
    <div class="page-header col-11" style="margin: 0 auto!important;">
        <div class="row align-items-center">
            <div class="col">
                <div class="page-pretitle">
                    <?= $Index['name']; ?>
                </div>
                <h2 class="page-title">
                    Agenda
                </h2>
            </div>
            <?php if($level == 1 || $level >= 4):  ?>
                <div class="col-auto ms-auto">
                    <div class="btn-list">
                        <a href="panel.php?exe=schedule/create<?= $n; ?>" class="btn btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg>
                            Novo Agendamento
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div><br/>

    <br/><div class="card col-11" style="margin: 0 auto!important;">
        <div class="card-body">
            <div id='calendar' class="col-12"></div>
        </div>
    </div>
</div>
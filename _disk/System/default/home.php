<div class="row row-deck row-cards">
    <div class="card-body">
        <?php
        if(($DB->CheckCpanelAndSettings($id_db_settings, $id_db_kwanzar)['atividade'] >= 1 && $DB->CheckCpanelAndSettings($id_db_settings, $id_db_kwanzar)['atividade'] <= 4) || $DB->CheckCpanelAndSettings($id_db_settings, $id_db_kwanzar)['atividade'] == 9):
            if($level >= 3):
                require_once("_disk/Helps/home-money.charts.inc.php");
            endif;
            //require_once("_heliospro/default-home-charts.inc.php");

            require_once("_disk/Helps/home-users.charts.inc.php");
            require_once("_disk/Helps/home-charts.inc.php");
            require_once("_disk/Helps/home-charts-ii.inc.php");
        elseif($DB->CheckCpanelAndSettings($id_db_settings, $id_db_kwanzar)['atividade'] >= 19):
            require_once("_disk/Helps/home-tentacao.inc.php");

            if($level == 1 || $level >= 4):
                require_once("_disk/Helps/home-money.charts.inc.php");
                require_once("_disk/Helps/home-charts.inc.php");
            endif;

            require_once("_disk/Helps/home-charts-ii.inc.php");
        endif;
        ?>
    </div>
</div>
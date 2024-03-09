<?php
ob_start();
require("_disk/IncludesApp/headerPanel.inc.php");

require("_heliospro/01-charts-home-settings-header.inc.php");
require("_heliospro/02-charts-home-settings-header.inc.php");
require("_heliospro/03-charts-home-settings-header.inc.php");
require("_heliospro/04-charts-home-settings-header.inc.php");
require("_heliospro/05-charts-home-settings-header.inc.php");
require("_heliospro/06-charts-home-settings-header.inc.php");
require("_heliospro/03-autoload-home-settings-header.inc.php");


$SessionLogs = new SessionLogs($_SERVER, $id_user, $id_db_settings);

$Read = new Read();
$Read->ExeRead("z_config");

if($Read->getResult()): $Index = $Read->getResult()[0]; else: $Index = null; endif;

if(!isset(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || empty(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || DBKwanzar::CheckConfig($id_db_settings)['Idioma'] == "Português"):
    $DaysX = ["", "Segunda-feira", "Terça-Feira", "Quarta-feira", "Quinta-feira", "Sexta-feira", "Sábado", "Domingo"];
    $DaysY = ["", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];
    $Meses = ["", "Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"];
    $StatusSchedule = ["", "Agendada", "Confirmada", "Paciente aguardando", "Paciente em atendimento", "Finalizada", "Faltou", "Cancelado pelo Paciente", "Cancelado pelo Médico"];
else:
    $Meses = ["", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    $DaysY = ["", "Segunda-feira", "Terça-Feira", "Quarta-feira", "Quinta-feira", "Sexta-feira", "Sábado", "Domingo"];
    $DaysX = ["", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];
    $StatusSchedule = ["", "Scheduled", "Confirmed", "Patient waiting", "Patient in care", "Finished", "Missed", "Canceled by Patient", "Canceled by Doctor"];
endif;

require("Anamnese.inc.php");


if(isset($getexe) || !empty($getexe)):
    $NGA = explode("/", $getexe);
    $page_found = $NGA[0];
endif;
?>
<!doctype html>
<html lang="pt-BR" style="background: #f5f5f5!important;">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title><?= $Index['name']; ?> | Dashboard</title>
    <link href="./dist/css/tabler.min.css" rel="stylesheet"/>
    <link href="./dist/css/tabler-flags.min.css" rel="stylesheet"/>
    <link href="./dist/css/tabler-payments.min.css" rel="stylesheet"/>
    <link href="./dist/css/tabler-vendors.min.css" rel="stylesheet"/>
    <link href="./dist/css/demo.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="_disk/css/reset.css" />
    <link rel="stylesheet" href="_disk/css/prosmart.css" />
    <link rel="stylesheet" href="_disk/css/Kwanzar.css" />
    <link rel="stylesheet" href="_disk/css/ProSmart-PDV.css" />
    <link rel="stylesheet" href="_disk/css/Odontograma.css" />
    <link rel="icon" href="uploads/<?= $Index['icon']; ?>"/>

    <link href="dist/css/select2.min.css" rel="stylesheet" />
    <script src="tinymce/tinymce.min.js" referrerpolicy="origin"></script>
    <script>tinymce.init({selector:'textarea#obs, textarea#Description, textarea#testemunho, textarea#coordenadas, textarea#content, textarea#description'});</script>

    <?php require("plafaforms.inc.php"); ?>
</head>
<body class="antialiased" onload="loadingPOS(<?= $id_user; ?>);" style="background: <?= $Index['color_3']; ?>!important;">
<input type="hidden" name="id_user" id="id_user" value="<?= $id_user; ?>"/>
<input type="hidden" name="page_found" id="page_found" value="<?= $NGA[0]; ?>"/>
<input type="hidden" name="level" id="level" value="<?= $level; ?>"/>
<input type="hidden" name="id_db_kwanzar" id="id_db_kwanzar" value="<?= $id_db_kwanzar; ?>" />
<input type="hidden" name="id_db_settings" id="id_db_settings" value="<?= $id_db_settings; ?>"/>
<div class="wrapper" style="background: <?= $Index['color_3']; ?>!important;">
    <?php
        if (isset($getexe)):
            $linkto = explode('/', $getexe);
        else:
            $linkto = array();
        endif;

        if(!isset(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['positionMenu']) || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['positionMenu'] == null || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['positionMenu'] == 1):
            require("_disk/IncludesApp/headerSoftware.inc.php");
            require("_disk/IncludesApp/MenuSoftware.inc.php");
        else:
            require("_disk/IncludesApp/MenuSoftware-left.inc.php");
        endif;
    ?>
    <div class="page-wrapper">
        <div class="page-body">
            <div class="container-xl">
                <?php
                    if(!$SessionLogs->getResult()):
                        WSError($SessionLogs->getError()[0], $SessionLogs->getError()[1]);
                    endif;

                    if(!empty($_GET['exe'])):
                        $includepatch = __DIR__.DIRECTORY_SEPARATOR."_disk".DIRECTORY_SEPARATOR."System".DIRECTORY_SEPARATOR. strip_tags(trim($_GET['exe']).'.php');
                    else:
                        $includepatch = __DIR__.DIRECTORY_SEPARATOR."_disk".DIRECTORY_SEPARATOR."System".DIRECTORY_SEPARATOR."default".DIRECTORY_SEPARATOR. "home.php";
                    endif;

                    if(file_exists($includepatch)):
                        require($includepatch);
                    else:
                        require("_disk/404.inc.php");
                    endif;
                ?>
            </div>
        </div>
        <?php
            include("_disk/IncludesApp/RodapeSoftware.inc.php");

            if($DB->CheckCpanelAndSettings($id_db_settings)['atividade'] == 19):
                require("_disk/IncludesApp/Modal-pacientes.inc.php");
                require("_disk/IncludesApp/Modal-schedule.inc.php");
            endif;

            require("_disk/IncludesApp/Modal-default.inc.php");
            include("_disk/IncludesApp/ModalsCarregarDocumentos.inc.php");
            include("_disk/IncludesApp/ModalsCarregarDocumentosProformas.inc.php");
            include("_disk/IncludesApp/Modals.inc.php");
            include("_disk/IncludesApp/Modals-obs.inc.php");
        ?>
    </div>
</div>

<script src="_disk/js/jquery.min.js"></script>
<script src="_disk/js/WhiteLabel.v.2.1.js"></script>
<script src="_disk/js/ProSmart.js"></script>
<script src="_disk/js/KwanzarDental.js"></script>
<script src="_disk/js/32981a13284db7a021131df49e6cd203.js"></script>

<script src="dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('#customer').select2();
        $('#Categories_id').select2();
        $('#Itens_id').select2();
        $('#Customers_id').select2();
        $('#Function_id').select2();
        $('#id_category').select2();

        $('#id_procedimento').select2();
        $('#id_customer').select2();

        $('#id_paciente').select2();
        $('#id_medico').select2();
        $('#status_schedule').select2();
    });
</script>

<script src="./dist/libs/apexcharts/dist/apexcharts.min.js"></script>
<script src="./dist/js/tabler.min.js"></script>
<?php
    require("_disk/IncludesApp/Charts-01.inc.php");
    require("_disk/IncludesApp/Charts-02.inc.php");
    require("_disk/IncludesApp/Charts-03.inc.php");
    require("_disk/IncludesApp/Charts-04.inc.php");
    require("_disk/IncludesApp/Charts-05.inc.php");
    require("_disk/IncludesApp/Charts-06.inc.php");
    require("_disk/IncludesApp/Charts-07.inc.php");
?>
</body>
</html>
<?php
ob_end_flush();
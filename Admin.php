<?php
ob_start();
require_once("Config.inc.php");

$Read = new Read();
$Read->ExeRead("z_config");
if($Read->getResult()):
    $Index = $Read->getResult()[0];
else:
    $Index = null;
endif;

require_once("_disk/IncludesApp/headerInfo.inc.php");

$n = null;
if($level == 5):
    require_once("_disk/_help/01-admin-static.inc.php");
    require_once("_disk/_help/02-admin-static.inc.php");
    require_once("_disk/_help/03-admin-static.inc.php");
    require_once("_disk/_help/04-admin-static.inc.php");
    require_once("_disk/_help/05-admin-static.inc.php");
    require_once("_disk/_help/06-admin-static.inc.php");
    require_once("_disk/_help/07-admin-static.inc.php");
    require_once("_disk/_help/08-admin-static.inc.php");
    require_once("_disk/_help/00-charts-static-access-settings-body.inc.php");
    $DataProcessing = new DataProcessing($id_db_kwanzar, $id_user, $level);
endif;
$SessionLogs = new SessionLogs($_SERVER, $id_user);
?>
<!doctype html>
<html lang="pt">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title><?= $Index['name']; ?> | cPanel </title>
    <link href="./dist/css/tabler.min.css" rel="stylesheet"/>
    <link href="./dist/css/tabler-flags.min.css" rel="stylesheet"/>
    <link href="./dist/css/tabler-payments.min.css" rel="stylesheet"/>
    <link href="./dist/css/tabler-vendors.min.css" rel="stylesheet"/>
    <link href="./dist/css/demo.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="_disk/css/reset.css" />
    <link rel="stylesheet" href="_disk/css/prosmart.css" />
    <link rel="icon" href="uploads/<?= $Index['icon']; ?>"/>

    <script src="tinymce/tinymce.min.js" referrerpolicy="origin"></script>
    <script>tinymce.init({selector:'textarea'});</script>

    <?php require_once("plafaforms.inc.php"); ?>
</head>
<body class="antialiased" style="background: <?= $Index['color_3']; ?>!important;">
<input type="hidden" name="id_user" id="id_user" value="<?= $id_user; ?>">
<input type="hidden" name="level" id="level" value="<?= $level; ?>"/>
<input type="hidden" name="id_db_kwanzar" id="id_db_kwanzar" value="<?= $id_db_kwanzar; ?>"/>
<div class="wrapper">
    <?php
        if (isset($getexe)):
            $linkto = explode('/', $getexe);
        else:
            $linkto = array();
        endif;
        include_once("_disk/IncludesApp/headerSoftware.inc.php");
        include_once("_disk/IncludesApp/MenuSoftwareAdm9.inc.php");
    ?>
    <div class="page-wrapper">
        <div class="page-body">
            <div class="container-xl">
                <div class="row row-cards">
                    <?php if($level == 5): include_once("_disk/IncludesApp/MenuAdminSoftware.php"); endif; ?>
                    <div class="col-lg-9">
                        <?php
                            if(!$SessionLogs->getResult()):
                                WSError($SessionLogs->getError()[0], $SessionLogs->getError()[1]);
                            endif;

                            if(!empty($_GET['exe'])):
                                $includepatch = __DIR__.DIRECTORY_SEPARATOR."_disk".DIRECTORY_SEPARATOR."SystemFiles".DIRECTORY_SEPARATOR. strip_tags(trim($_GET['exe']).'.php');
                            else:
                                $includepatch = __DIR__.DIRECTORY_SEPARATOR."_disk".DIRECTORY_SEPARATOR."SystemFiles".DIRECTORY_SEPARATOR."default".DIRECTORY_SEPARATOR. "home.php";
                            endif;

                            if(file_exists($includepatch)):
                                require_once($includepatch);
                            else:
                                require_once("_disk/404.inc.php");
                            endif;
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
            include_once("_disk/IncludesApp/RodapeSoftware.inc.php");
            if($level != 5 && WSKwanzar::CheckLicence($id_db_kwanzar)['postos'] > DBKwanzar::CheckSettings($id_db_kwanzar)):
                include_once("_disk/IncludesApp/CreateNewEmpresaModal.inc.php");
            elseif($level == 5):
                include_once("_disk/IncludesApp/CreateNewEmpresaModal.inc.php");
            endif;
        ?>
    </div>
</div>

<script>
    function leva(){
        setInterval(function(){
            location = 'Admin.php'
        }, 3000);
    }
</script>

<script>
    function level(){
        setInterval(function(){
            location = 'Admin.php?exe=statistic/company'
        }, 3000);
    }
</script>

<script>
    function Ls(){
        setInterval(function(){
            location = 'Admin.php?exe=default/home'
        }, 3000);
    }
</script>

<script src="_disk/js/jquery.min.js"></script>
<script src="_disk/js/WhiteLabel.v.2.1.js"></script>

<?php if($level == 5): ?>
    <script type="text/javascript" src="_disk/js/32981a13284db7a021131df49e6cd203.js"></script>
<?php endif; ?>

<script src="./dist/libs/apexcharts/dist/apexcharts.min.js"></script>
<script src="./dist/js/tabler.min.js"></script>

<?php
if($level == 5):
    require_once("_disk/_help/01-admin-static-charts.inc.php");
    require_once("_disk/_help/02-admin-static-charts.inc.php");
    require_once("_disk/_help/03-admin-static-charts.inc.php");
    require_once("_disk/_help/04-admin-static-charts.inc.php");
    require_once("_disk/_help/05-admin-static-charts.inc.php");
    require_once("_disk/_help/06-admin-static-charts.inc.php");
    require_once("_disk/_help/07-admin-static-charts.inc.php");
    require_once("_disk/_help/08-admin-static-charts.inc.php");
    require_once("_disk/_help/09-admin-static-charts.inc.php");
    require_once("_disk/_help/00-charts-static-access-settings.inc.php");
endif;
?>
</body>
</html>
<?php
require("_emails/05-emails.inc.php");
ob_end_flush();
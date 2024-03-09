<?php
ob_start();
require_once("Config.inc.php");
$sessao = new Session;
Check::UserOnline();
$SessionLogs = new SessionLogs($_SERVER);

$logoff = filter_input(INPUT_GET, 'logoff', FILTER_VALIDATE_BOOLEAN);
$getexe = filter_input(INPUT_GET, 'exe', FILTER_DEFAULT);
$lock = filter_input(INPUT_GET, 'lock', FILTER_DEFAULT);

$Read = new Read();
$Read->ExeRead("z_config");
if($Read->getResult()): $Index = $Read->getResult()[0]; else: $Index = null; endif;

if(isset($getexe) || !empty($getexe)):
    $NGA = explode("/", $getexe);
    $page_found = $NGA[0];
endif;
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link rel="icon" href="uploads/<?= $Index['icon']; ?>"/>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@500;600&family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/lightbox/css/lightbox.min.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

    <link href="_disk/css/reset.css" rel="stylesheet">
    <link href="_disk/css/Euclides.css" rel="stylesheet">
</head>
<body>
<?php
    if (isset($getexe)):
        $linkto = explode('/', $getexe);
    else:
        Header("Location: index.php?exe=default/home");
    endif;

    if(!empty($_GET['exe'])):
        $includepatch = __DIR__.DIRECTORY_SEPARATOR."_front".DIRECTORY_SEPARATOR."System".DIRECTORY_SEPARATOR. strip_tags(trim($_GET['exe']).'.php');
    else:
        $includepatch = __DIR__.DIRECTORY_SEPARATOR."_front".DIRECTORY_SEPARATOR."System".DIRECTORY_SEPARATOR."default".DIRECTORY_SEPARATOR. "home.php";
    endif;

    if(file_exists($includepatch)):
        include("_front/Includes/Topbar.inc.php");
        include("_front/Includes/Navbar.inc.php");

        include($includepatch);

        include("_front/Includes/footer.inc.php");
    else:
        include("_front/404.inc.php");
    endif;
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="lib/easing/easing.min.js"></script>
<script src="lib/waypoints/waypoints.min.js"></script>
<script src="lib/owlcarousel/owl.carousel.min.js"></script>
<script src="lib/lightbox/js/lightbox.min.js"></script>

<script src="js/main.js"></script>
</body>
</html>
<?php
include("_front/JavaScript.inc.php");
ob_end_flush();
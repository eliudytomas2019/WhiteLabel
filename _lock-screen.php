<?php
require_once("_disk/IncludesApp/Lock-Screen.inc.php");
$Read = new Read();
$Read->ExeRead("z_config");
if($Read->getResult()): $Index = $Read->getResult()[0]; else: $Index = null; endif;
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title><?= $Index['name']; ?> | Login </title>
    <link href="./dist/css/tabler.min.css" rel="stylesheet"/>
    <link href="./dist/css/tabler-flags.min.css" rel="stylesheet"/>
    <link href="./dist/css/tabler-payments.min.css" rel="stylesheet"/>
    <link href="./dist/css/tabler-vendors.min.css" rel="stylesheet"/>
    <link href="./dist/css/demo.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="_disk/css/reset.css" />
    <link rel="icon" href="uploads/icon.png"/>


    <!-- Custom & Default Styles -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/carousel.css">
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="style.css">

    <script src="js/vendor/html5shiv.min.js"></script>
    <script src="js/vendor/respond.min.js"></script>

    <?php require_once("plafaforms.inc.php"); ?>
</head>
<body class="antialiased d-flex flex-column" style="background: <?= $Index['color_3']; ?>!important;">
<section id="home" class="video-section js-height-full">
    <div class="overlay"></div>
    <div class="home-text-wrapper relative container">
        <div class="home-message">
            <div class="container-tight py-4" style="margin-top: 60px!important;z-index: 2!important;">
                <div class="text-center mb-4">
                    <a href=""><img src="uploads/<?= $Index['logotype']; ?>" style="color: #fff!important;" height="76" alt=""></a>
                </div>
                <form class="card card-md" name="FormLockScreen" method="post" action="#getResult" autocomplete="off">
                    <div class="card-body text-center">
                        <div class="mb-4">
                            <h2 class="card-title">Ecrã bloqueado</h2>
                            <p class="text-muted" id="getResult" style="color: <?= $Index['color_41']; ?>!important;">Digite a palavra-passe para desbloquear o ecrã.</p>
                        </div>
                        <div class="mb-4">
                            <span class="avatar avatar-xl mb-3" style="background-image: url(uploads/<?php if($userlogin['cover'] == "" || $userlogin['cover'] == null): echo "user.png"; else: echo $userlogin['cover']; endif; ?>)"></span>
                            <h3><?= $userlogin["name"]; ?></h3>
                        </div>
                        <div class="mb-4">
                            <input type="hidden" name="Session_id" id="Session_id" value="<?= $userlogin['id']; ?>">
                            <input type="password" name="pass" id="pass" class="form-control" placeholder="Password&hellip;">
                        </div>
                        <div>
                            <button type="submit" class="btn btn-primary w-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><rect x="5" y="11" width="14" height="10" rx="2" /><circle cx="12" cy="16" r="1" /><path d="M8 11v-5a4 4 0 0 1 8 0" /></svg>
                                Desbloquear
                            </button>
                        </div>
                    </div>
                </form>
                <div class="text-center text-muted mt-3">
                    <a href="?logoff=true" style="color:#fff!important;">Iniciar sessão com outro usuário.</a>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    function leva(){
        setInterval(function(){
            location = 'Admin.php'
        }, 3000);
    }
</script>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/KwanzarScripts.js"></script>
<script src="./dist/js/tabler.min.js"></script>

<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/carousel.js"></script>
<script src="js/animate.js"></script>
<script src="js/custom.js"></script>
<!-- VIDEO BG PLUGINS -->
<script src="js/videobg.js"></script>
</body>
</html>
<?php
ob_end_flush();
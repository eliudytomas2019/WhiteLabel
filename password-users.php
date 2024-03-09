<?php
ob_start();
require_once("Config.inc.php");

$read   = new Read();
$create = new Create();
$update = new Update();
$delete = new Delete();

$sessao = new Session();
if(!isset($_SESSION['userlogin'])):
    unset($_SESSION['userlogin']);
    header('Location: index.php?exe=restrito');
endif;

$level = $_SESSION['userlogin']['level'];

if($level == 5):
    $login = new Login(5);
elseif($level == 4):
    $login = new Login(4);
elseif($level == 3):
    $login = new Login(3);
elseif($level == 2):
    $login = new Login(2);
else:
    $login = new Login(1);
endif;

if (!$login->CheckLogin()):
    unset($_SESSION['userlogin']);
    header('Location: index.php?exe=restrito');
else:
    $userlogin = $_SESSION['userlogin'];
    $id_db_kwanzar = $userlogin['id_db_kwanzar'];
endif;

$logoff = filter_input(INPUT_GET, 'logoff', FILTER_VALIDATE_BOOLEAN);
$getexe = filter_input(INPUT_GET, 'exe', FILTER_DEFAULT);
$lock = filter_input(INPUT_GET, 'lock', FILTER_DEFAULT);

if($logoff):
    unset($_SESSION['userlogin']);
    header('Location: _login.php?exe=logoff');
endif;

if($level <= 4):
    $Config = new WSKwanzar();
    if(!$Config->CheckTimes($userlogin['id_db_kwanzar'])):
        unset($_SESSION['userlogin']);
        header('Location: _login.php?exe=restrito');
    endif;
endif;

$SessionLogs = new SessionLogs($_SERVER, $_SESSION['userlogin']['id'], $_SESSION['userlogin']['id_db_settings']);


$Read = new Read();
$Read->ExeRead("z_config");
if($Read->getResult()): $Index = $Read->getResult()[0]; else: $Index = null; endif;
?>
<!doctype html>
<html lang="en" style="background: #575656!important;">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title><?= $Index['name']; ?> | Recuperaçāo de senha</title>
    <link href="./dist/css/tabler.min.css" rel="stylesheet"/>
    <link href="./dist/css/tabler-flags.min.css" rel="stylesheet"/>
    <link href="./dist/css/tabler-payments.min.css" rel="stylesheet"/>
    <link href="./dist/css/tabler-vendors.min.css" rel="stylesheet"/>
    <link href="./dist/css/demo.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="_disk/css/reset.css" />
    <link rel="stylesheet" href="_disk/css/prosmart.css" />
    <link rel="icon" href="uploads/<?= $Index['icon']; ?>"/>


    <!-- Custom & Default Styles -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/carousel.css">
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="style.css">

    <!--[if lt IE 9]>
    <script src="js/vendor/html5shiv.min.js"></script>
    <script src="js/vendor/respond.min.js"></script>
    <![endif]-->

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

                <form class="card card-md" name="FormPassword" method="post" action="">
                    <div class="card-body">
                        <h2 class="card-title text-center mb-4">Atualização de senha</h2>
                        <div id="getResult">
                            <?php
                                if(!$SessionLogs->getResult()):
                                    WSError($SessionLogs->getError()[0], $SessionLogs->getError()[1]);
                                endif;
                            ?>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" style="text-align: left!important;">Senha atual</label>
                            <input type="hidden" name="Session_id" id="Session_id" value="<?= $userlogin['id']; ?>">
                            <input type="password" name="password_atual" id="password_atual" required class="form-control" placeholder="Senha atual">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" style="text-align: left!important;">Nova senha</label>
                            <input type="password" name="password" id="password" class="form-control" placeholder="Nova senha">
                            <div id="pass"></div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" style="text-align: left!important;">Repita Senha</label>
                            <input type="password" name="replace_password" id="replace_password" class="form-control" placeholder="Repita senha">
                            <div id="novinho"></div>
                        </div>

                        <div class="form-footer">
                            <button type="submit" class="btn btn-primary  w-100">Atualizar senha</button>
                        </div>
                    </div>
                </form>
                <div class="text-center text-muted mt-3" style="color:#fff!important;">
                    <a href="?logoff=true" >Iniciar sessão com outro usuário.</a><br/>
                    <a href="Admin.php" >Voltar ao cPanel</a>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    function leva(){
        setInterval(function(){
            location = '?logoff=true'
        }, 1000);
    }
</script>

<script src="_disk/js/jquery.min.js"></script>
<script src="_disk/js/WhiteLabel.v.2.1.js"></script>
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
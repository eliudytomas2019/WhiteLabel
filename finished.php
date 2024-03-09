<?php
ob_start();
require_once("Config.inc.php");
$sessao = new Session;
Check::UserOnline();
$SessionLogs = new SessionLogs($_SERVER);

$Read = new Read();
$Read->ExeRead("z_config");
if($Read->getResult()): $Index = $Read->getResult()[0]; else: $Index = null; endif;
?>
    <!doctype html>
    <html lang="pt-BR">
    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
        <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
        <title><?= $Index['name']; ?> | Nova Senha </title>
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

        <!--[if lt IE 9]>
        <script src="js/vendor/html5shiv.min.js"></script>
        <script src="js/vendor/respond.min.js"></script>
        <![endif]-->
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
                    <form class="card card-md" name="Forgot" method="post" action="#getResult">
                        <div class="card-body">
                            <h2 class="card-title text-center mb-4">Atualização de senha</h2>
                            <div id="getResult">
                                <?php
                                if(!$SessionLogs->getResult()):
                                    WSError($SessionLogs->getError()[0], $SessionLogs->getError()[1]);
                                endif;

                                $userId = filter_input(INPUT_GET, 'postId', FILTER_VALIDATE_INT);
                                if(!isset($userId)): header("Location: _login.php"); endif;

                                $ClienteData = filter_input_array(INPUT_POST, FILTER_DEFAULT);
                                if (isset($ClienteData) && $ClienteData['Forgot']):
                                    if(isset($userId)):
                                        $Cadastrar = new DBKwanzar();
                                        $Cadastrar->ForgotPassword($userId, $ClienteData);

                                        if($Cadastrar->getResult()):
                                            WSError($Cadastrar->getError()[0], $Cadastrar->getError()[1]);
                                            echo "<script>leva();</script>";
                                        else:
                                            WSError($Cadastrar->getError()[0], $Cadastrar->getError()[1]);
                                        endif;
                                    endif;
                                endif;
                                ?>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" style="text-align: left!important;">Nova senha</label>
                                <input type="password" name="password" id="password" value="<?php if (!empty($ClienteData['password'])) echo $ClienteData['password']; ?>" class="form-control" placeholder="Nova senha">
                                <div id="pass"></div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" style="text-align: left!important;">Repita Senha</label>
                                <input type="password" name="replace_password" id="replace_password" value="<?php if (!empty($ClienteData['replace_password'])) echo $ClienteData['replace_password']; ?>" class="form-control" placeholder="Repita senha">
                                <div id="novinho"></div>
                            </div>
                            <div class="form-footer">
                                <input type="submit" name="Forgot" id="Forgot" value="Salvar" class="btn btn-primary w-100">
                            </div>
                        </div>
                    </form>
                    <div class="text-center text-muted mt-3" style="color:#fff!important;">
                        Já tem conta? <a href="_login.php" tabindex="-1">Entrar</a>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <script>
        function leva(){
            setInterval(function(){
                location = '_login.php'
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
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
        <title><?= $Index['name']; ?> | Esqueci a senha </title>
        <link href="./dist/css/tabler.min.css" rel="stylesheet"/>
        <link href="./dist/css/tabler-flags.min.css" rel="stylesheet"/>
        <link href="./dist/css/tabler-payments.min.css" rel="stylesheet"/>
        <link href="./dist/css/tabler-vendors.min.css" rel="stylesheet"/>
        <link href="./dist/css/demo.min.css" rel="stylesheet"/>
        <link rel="stylesheet" href="_disk/css/reset.css" />
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
                    <form class="card card-md" name="Forgot" method="post" action="">
                        <div class="card-body">
                            <h2 class="card-title text-center mb-4">Esqueceu a senha</h2>
                            <p>Digite seu endereço de e-mail e sua senha será redefinida e enviada para você.</p>
                            <div id="getResult">
                                <?php
                                    if(!$SessionLogs->getResult()):
                                        WSError($SessionLogs->getError()[0], $SessionLogs->getError()[1]);
                                    endif;

                                    $ClienteData = filter_input_array(INPUT_POST, FILTER_DEFAULT);
                                    if (isset($ClienteData) && $ClienteData['Forgot']):
                                        if(empty($ClienteData['email'])):
                                            WSError("Preencha o campo Email para finalizar o processo!", WS_ALERT);
                                        elseif(!Check::Email($ClienteData['email'])):
                                            WSError("Introduza endereço de Email válido!", WS_INFOR);
                                        else:
                                            $Read = new Read();
                                            $Read->ExeRead("db_users", "WHERE username=:i", "i={$ClienteData['email']}");

                                            if($Read->getResult()):
                                                $Data = $Read->getResult()[0];
                                                require_once("forgot-mailer.inc.php");
                                            else:
                                                WSError("Não encontramos nenhum usuário que corresponde ao endereço de Email digitado!", WS_ERROR);
                                            endif;
                                        endif;
                                    endif;
                                ?>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" style="text-align: left!important;">Email</label>
                                <input type="text" id="email" name="email" value="<?php if (!empty($ClienteData['email'])) echo $ClienteData['email']; ?>" class="form-control" placeholder="Enter email">
                            </div>
                            <div class="form-footer">
                                <input type="submit" name="Forgot" id="Forgot" value="Salvar" class="btn btn-primary w-100">
                            </div>
                        </div>
                    </form>
                    <div class="text-center text-muted mt-3" style="color:#fff!important;">
                        Já tem conta? <a href="_login.php" tabindex="-1">Entrar</a><br/>
                        Voltar ao <a href="index.php" tabindex="-1">website</a>
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
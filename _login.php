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
    <title><?= $Index['name']; ?> | Login </title>
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

    <?php require_once("plafaforms.inc.php"); ?>
</head>
<body class="antialiased d-flex flex-column" style="background: <?= $Index['color_3']; ?>!important;">
<section id="home" class="video-section js-height-full">
    <div class="overlay"></div>
    <div class="home-text-wrapper relative container">
        <div class="home-message">
            <div class="container-tight py-4" style="margin-top: 5px!important;z-index: 2!important;">
                <div class="text-center mb-4">
                    <a href=""><img src="uploads/<?= $Index['logotype']; ?>" style="color: #fff!important;" height="70" alt=""></a>
                </div>
                <form class="card card-md" name="FormUsersLogin" method="post" action="#getResult">
                    <div class="card-body">
                        <h2 class="card-title text-center mb-4">Faça login na sua conta</h2>
                        <div id="getResult">
                            <?php
                            if(!$SessionLogs->getResult()):
                                WSError($SessionLogs->getError()[0], $SessionLogs->getError()[1]);
                            endif;

                            $login = new Login(1);
                            if ($login->CheckLogin()):
                                header('Location: Admin.php');
                            endif;

                            $get = filter_input(INPUT_GET, 'exe', FILTER_DEFAULT);
                            if (!empty($get)):
                                if ($get == 'restrito'):
                                    WSError('<b>Ops:</b> Acesso negado. Favor efetue login para acessar o painel!+', WS_ALERT);
                                elseif ($get == 'logoff'):
                                    WSError('<b>Sucesso ao deslogar:</b> Sua sessão foi finalizada. Volte sempre!', WS_ACCEPT);
                                elseif($get == 'logs'):
                                    WSError("<b>Ops!</b> A sua conta encontra-se temporariamente suspença, contate o administrador.", WS_ERROR);
                                elseif($get == 'accounting'):
                                    WSError("<b>Ops!</b> O Painel da empresa encontra-se suspenso, contate o Administrador.", WS_INFOR);
                                elseif($get == 'session_off'):
                                    WSError("<b>Ops:</b> Não conseguimos estabelecer uma conexão segura, atualize a página e tente novamente!", WS_ALERT);
                                elseif($get == 'session_end'):
                                    WSError("<b>Ops:</b> A sessão expirou, faça novamente o login!", WS_ALERT);
                                endif;
                            endif;
                            ?>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" style="text-align: left!important;">Endereço de e-mail</label>
                            <input type="text" name="user" id="user" value="<?php if (!empty($ClienteData['user'])) echo $ClienteData['user']; ?>" class="form-control" placeholder="Digite o e-mail">
                        </div>
                        <div class="mb-2">
                            <label class="form-label" style="text-align: left!important;">
                                Senha
                                <span class="form-label-description">
                                    <a href="forgot-password.php">Esqueci a senha</a>
                                </span>
                            </label>
                            <div class="input-group input-group-flat">
                                <input type="password" name="pass" id="pass" value="<?php if (!empty($ClienteData['pass'])) echo $ClienteData['pass']; ?>" class="form-control"  placeholder="Senha"/>
                                <span class="input-group-text">
                                    <a href="#" onclick="MyXpassword()" class="link-secondary" title="Mostrar senha" data-bs-toggle="tooltip">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="2" /><path d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7" /></svg>
                                    </a>
                                </span>
                            </div>
                        </div>
                        <div class="form-footer">
                            <button type="submit" name="signin" id="signin" class="btn btn-primary w-100">Entrar</button>
                        </div>
                    </div>
                </form>
                <div class="text-center text-muted mt-3" style="color:#fff!important;">
                    Ainda não tem conta? <a href="_register.php" tabindex="-1">Inscrever-se</a><br/>
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
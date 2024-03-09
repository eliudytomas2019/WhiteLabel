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
    <title><?= $Index['name']; ?> | Criar conta </title>
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
            <div class="container-tight py-4">
                <div class="text-center mb-4">
                    <a href=""><img src="uploads/<?= $Index['logotype']; ?>" height="70" alt=""></a>
                </div>
                <form class="card card-md" name="FormCreateAccounting" action="#getResult" method="post">
                    <div class="card-body">
                        <h2 class="card-title text-center mb-4">Criar nova conta</h2>
                        <div id="getResult"> <?php if(!$SessionLogs->getResult()):
                            WSError($SessionLogs->getError()[0], $SessionLogs->getError()[1]);
                            endif; ?></div>
                        <div class="mb-3">
                            <label class="form-label" style="text-align: left!important;">Nome</label>
                            <input type="text" name="name" id="name" value="<?php if (!empty($ClienteData['name'])) echo $ClienteData['name']; ?>" class="form-control" placeholder="Nome">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" style="text-align: left!important;">Telefone</label>
                            <input type="text" name="telefone" id="telefone" value="<?php if (!empty($ClienteData['telefone'])) echo $ClienteData['telefone']; ?>" class="form-control" placeholder="Telefone">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" style="text-align: left!important;">Endereço de e-mail</label>
                            <input type="text" class="form-control" name="username" id="username" value="<?php if (!empty($ClienteData['username'])) echo $ClienteData['username']; ?>" placeholder="Endereço de e-mail">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" style="text-align: left!important;">Senha</label>
                            <div class="input-group input-group-flat">
                                <input type="password" class="form-control" name="password" id="password" value="<?php if (!empty($ClienteData['password'])) echo $ClienteData['password']; ?>" placeholder="Senha"  autocomplete="off">
                                <span class="input-group-text">
                                <a href="#" onclick="Mypassword()" class="link-secondary" title="Mostrar senha" data-bs-toggle="tooltip">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="2" /><path d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7" /></svg>
                                </a>
                            </span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-check" style="text-align: left!important;">
                                <input type="checkbox" onclick="TermsAnd(this);" name="TermsAndPolitic" id="TermsAndPolitic" class="form-check-input"/>
                                <span class="form-check-label">Concordo com os <a href="_terms-of-service.php" tabindex="-1" target="_blank">termos e política</a>.</span>
                            </label>
                        </div>
                        <div class="form-footer">
                            <button type="submit" name="btnCreateNewCount" id="btnCreateNewCount" class="btn btn-primary w-100">Criar nova conta</button>
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

<!--- Chamar as funções da Nucleus --->
<script src="_disk/js/jquery.min.js"></script>
<script src="_disk/js/WhiteLabel.v.2.1.js"></script>
<!--- Fim funções da nucleus --->
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
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
<html lang="pt">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title><?= $Index['name']; ?> | Termos de serviços </title>
    <link href="./dist/css/tabler.min.css" rel="stylesheet"/>
    <link href="./dist/css/tabler-flags.min.css" rel="stylesheet"/>
    <link href="./dist/css/tabler-payments.min.css" rel="stylesheet"/>
    <link href="./dist/css/tabler-vendors.min.css" rel="stylesheet"/>
    <link href="./dist/css/demo.min.css" rel="stylesheet"/>

    <link rel="stylesheet" href="_disk/css/reset.css" />
    <link rel="icon" href="uploads/<?= $Index['icon']; ?>"/>
</head>
<body class="antialiased border-top-wide border-primary d-flex flex-column" style="background: <?= $Index['color_3']; ?>!important;">
<div class="page page-center">
    <div class="container-narrow py-4">
        <div class="text-center mb-4">
            <a href=""><img src="uploads/<?= $Index['logotype']; ?>" height="76" alt=""></a>
        </div>
        <div class="card card-md">
            <div class="card-body">
            <?php
                $status = 1;
                $Read = new Read();
                $Read->ExeRead("website_terms", "WHERE status=:st ORDER BY id ASC LIMIT 1", "st={$status}");

                if($Read->getResult()):
                    foreach ($Read->getResult() as $key):
                        ?>
                        <h3 class="card-title"><?= $key['title']; ?></h3>
                        <div class="markdown">
                            <?= $key['content']; ?>
                        </div>
                        <?php
                    endforeach;
                endif;
            ?>
            </div>
        </div>
    </div>
</div>

<script src="_disk/js/jquery.min.js"></script>
<script src="_disk/js/WhiteLabel.v.2.1.js"></script>


<script src="./dist/js/tabler.min.js"></script>
</body>
</html>
<?php
ob_end_flush();
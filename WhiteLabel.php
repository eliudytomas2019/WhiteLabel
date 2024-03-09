<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>ProSmart - WhiteLabel Software</title>
    <link href="./dist/css/tabler.min.css" rel="stylesheet"/>
    <link href="./dist/css/tabler-flags.min.css" rel="stylesheet"/>
    <link href="./dist/css/tabler-payments.min.css" rel="stylesheet"/>
    <link href="./dist/css/tabler-vendors.min.css" rel="stylesheet"/>
    <link href="./dist/css/demo.min.css" rel="stylesheet"/>
</head>
<body class="antialiased d-flex flex-column" style="background: #575656!important;">
<div class="page page-center">
    <div class="container-tight py-4">
        <div class="card card-md">
            <div class="card-body text-center">
                <img src="uploads/ProSmart.png" height="76">
                <h1 class="mt-5">Bem-vindo ao ProSmart!</h1>
                <p class="text-muted" style="color: #313030!important;">A ProSmart possui soluções completas em suas plataformas white-label, perfeitas para a criação de aplicativos como o Kwanzar, Núcleos e outros. Conheça nossos principais produtos e crie o próximo sucesso do mundo digital.</p>
            </div>
            <div class="hr-text hr-text-center hr-text-spaceless">Banco de dados</div>
            <div class="card-body">
                <div id="getResult">
                    <?php
                    require_once("_app/Conn/SatanIsGod.class.php");
                    $ClienteData = filter_input_array(INPUT_POST, FILTER_DEFAULT);
                    if ($ClienteData && $ClienteData['SendPostFormL']):
                        $Satan = new SatanIsGod();
                        $Satan->CreateDatabase($ClienteData);
                        if($Satan->getResult()):
                            echo $Satan->getError();
                            header("Location: Config.php");
                        else:
                            echo $Satan->getError();
                        endif;
                    endif;
                    ?>
                </div>
               <form method="post" action="" name="SendPostFormL" enctype="multipart/form-data">
                   <div class="row">
                       <div class="mb-3 col-6">
                           <label class="form-label">Host</label>
                           <div class="input-group input-group-flat">
                               <input type="text" value="<?php if (!empty($ClienteData['host'])) echo $ClienteData['host']; ?>" class="form-control ps-1" name="host" placeholder="Host">
                           </div>
                       </div>
                       <div class="mb-3 col-6">
                           <label class="form-label">Usuário</label>
                           <div class="input-group input-group-flat">
                               <input type="text" value="<?php if (!empty($ClienteData['user'])) echo $ClienteData['user']; ?>" name="user" class="form-control ps-1" placeholder="User">
                           </div>
                       </div>
                   </div>
                   <div class="row">
                       <div class="mb-3 col-6">
                           <label class="form-label">Password</label>
                           <div class="input-group input-group-flat">
                               <input type="text" value="<?php if (!empty($ClienteData['pass'])) echo $ClienteData['pass']; ?>" name="pass" class="form-control ps-1" placeholder="Pass">
                           </div>
                       </div>
                       <div class="mb-3 col-6">
                           <label class="form-label">Database</label>
                           <div class="input-group input-group-flat">
                               <input type="text" value="<?php if (!empty($ClienteData['db'])) echo $ClienteData['db']; ?>" name="db" class="form-control ps-1" placeholder="Database">
                           </div>
                       </div>
                   </div>
                   <div class="col">
                       <div class="btn-list justify-content-end">
                           <input type="submit" name="SendPostFormL" class="btn btn-primary" value="Salvar">
                       </div>
                   </div>
               </form>
            </div>
        </div>
    </div>
</div>
<script src="./dist/js/tabler.min.js"></script>
</body>
</html>
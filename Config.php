<?php
require_once("Config.inc.php");
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>ProSmart | Personalizaçāo do template - WhiteLabel Software</title>
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
            <div class="hr-text hr-text-center hr-text-spaceless">Personalizaçāo do template</div>
            <div class="card-body">
                <div id="getResult">
                    <?php
                    $ClienteData = filter_input_array(INPUT_POST, FILTER_DEFAULT);
                    if ($ClienteData && $ClienteData['SendPostFormL']):
                        $logoty['logotype'] = ($_FILES['logotype']['tmp_name'] ? $_FILES['logotype'] : null);
                        $Satan = new SatanIsGod();
                        $Satan->CreateConfig($logoty, $ClienteData);
                        if($Satan->getResult()):
                            WSError($Satan->getError()[0], $Satan->getError()[1]);
                            header("Location: index.php");
                        else:
                            WSError($Satan->getError()[0], $Satan->getError()[1]);
                        endif;
                    else:
                        $Read = new Read();
                        $Read->ExeRead("z_config");

                        if($Read->getResult() || $Read->getRowCount()):
                            header("Location: index.php");
                        endif;
                    endif;
                    ?>
                </div>
                <form method="post" action="" name="SendPostFormL" enctype="multipart/form-data">
                    <div class="row">
                        <div class="mb-3 col-4">
                            <label class="form-label">Cor do Header</label>
                            <div class="input-group input-group-flat">
                                <input type="color" value="<?php if (!empty($ClienteData['color_1'])) echo $ClienteData['color_1']; ?>" class="form-control ps-1" name="color_1" placeholder="color_1">
                            </div>
                        </div>
                        <div class="mb-3 col-4">
                            <label class="form-label">Cor do Menu</label>
                            <div class="input-group input-group-flat">
                                <input type="color" value="<?php if (!empty($ClienteData['color_2'])) echo $ClienteData['color_2']; ?>" name="color_2" class="form-control ps-1" placeholder="color_2">
                            </div>
                        </div>
                        <div class="mb-3 col-4">
                            <label class="form-label">Fundo da Página</label>
                            <div class="input-group input-group-flat">
                                <input type="color" value="<?php if (!empty($ClienteData['color_3'])) echo $ClienteData['color_3']; ?>" name="color_3" class="form-control ps-1" placeholder="color_3">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-6">
                            <label class="form-label">Cor dos botões do menu</label>
                            <div class="input-group input-group-flat">
                                <input type="color" value="<?php if (!empty($ClienteData['color_41'])) echo $ClienteData['color_41']; ?>" class="form-control ps-1" name="color_41" placeholder="color_1">
                            </div>
                        </div>
                        <div class="mb-3 col-6">
                            <label class="form-label">Cor dos botões do sub-menu</label>
                            <div class="input-group input-group-flat">
                                <input type="color" value="<?php if (!empty($ClienteData['color_42'])) echo $ClienteData['color_42']; ?>" name="color_42" class="form-control ps-1" placeholder="color_2">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-6">
                            <label class="form-label">Logotipo</label>
                            <div class="input-group input-group-flat">
                                <input type="file" value="<?php if (!empty($ClienteData['logotype'])) echo $ClienteData['logotype']; ?>" name="logotype" class="form-control ps-1" placeholder="logotype">
                            </div>
                        </div>
                        <div class="mb-3 col-6">
                            <label class="form-label">Nome do Software</label>
                            <div class="input-group input-group-flat">
                                <input type="text" value="<?php if (!empty($ClienteData['name'])) echo $ClienteData['name']; ?>" name="name" class="form-control ps-1" placeholder="Nome do software">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-6">
                            <label class="form-label">Email</label>
                            <div class="input-group input-group-flat">
                                <input type="text" value="<?php if (!empty($ClienteData['email'])) echo $ClienteData['email']; ?>" name="email" class="form-control ps-1" placeholder="Email">
                            </div>
                        </div>
                        <div class="mb-3 col-6">
                            <label class="form-label">Endereço</label>
                            <div class="input-group input-group-flat">
                                <input type="text" value="<?php if (!empty($ClienteData['endereco'])) echo $ClienteData['endereco']; ?>" name="endereco" class="form-control ps-1" placeholder="Endereço">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-6">
                            <label class="form-label">Telefone</label>
                            <div class="input-group input-group-flat">
                                <input type="text" value="<?php if (!empty($ClienteData['telefone'])) echo $ClienteData['telefone']; ?>" name="telefone" class="form-control ps-1" placeholder="Telefone">
                            </div>
                        </div>
                        <div class="mb-3 col-6">
                            <label class="form-label">Website</label>
                            <div class="input-group input-group-flat">
                                <input type="text" value="<?php if (!empty($ClienteData['website'])) echo $ClienteData['website']; ?>" name="website" class="form-control ps-1" placeholder="Website">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-6">
                            <label class="form-label">Nº de Certificado AGT</label>
                            <div class="input-group input-group-flat">
                                <input type="text" value="<?php if (!empty($ClienteData['agt'])) echo $ClienteData['agt']; ?>" name="agt" class="form-control ps-1" placeholder="Nº de Certificado AGT">
                            </div>
                        </div>
                        <div class="mb-3 col-6">
                            <label class="form-label">Nº de Certificado ISO</label>
                            <div class="input-group input-group-flat">
                                <input type="text" value="<?php if (!empty($ClienteData['iso'])) echo $ClienteData['iso']; ?>" name="iso" class="form-control ps-1" placeholder="Nº de Certificado ISO">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-6">
                            <label class="form-label">Nº da Versão do Software</label>
                            <div class="input-group input-group-flat">
                                <input type="text" value="<?php if (!empty($ClienteData['versao'])) echo $ClienteData['versao']; ?>" name="versao" class="form-control ps-1" placeholder="Nº da Versão do Software">
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
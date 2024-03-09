<?php
use League\Csv\Reader;
use League\Csv\Whiter;
require "vendor/autoload.php";

if(!class_exists('login')):
    header("index.php");
    die();
endif;

if($level >= 4): $n =  '&id_db_settings='.$id_db_settings; else: $n = null; endif;

if($userlogin['level'] < 1):
    header("location: panel.php?exe=default/index".$n);
endif;
?>
<div class="row gx-lg-4">
    <?php require_once("_disk/IncludesApp/MenuSettings.inc.php"); ?>
    <div class="col-lg-9">
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <div class="page-pretitle">
                        Kwanzar
                    </div>
                    <h2 class="page-title">
                        Exportaçāo de dados
                    </h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="import.php?action=client&postId=<?= $id_db_settings; ?>" class="btn btn-primary btn-sm d-sm-inline-block">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M19 18a3.5 3.5 0 0 0 0 -7h-1a5 4.5 0 0 0 -11 -2a4.6 4.4 0 0 0 -2.1 8.4" /><line x1="12" y1="13" x2="12" y2="22" /><polyline points="9 19 12 22 15 19" /></svg>
                            Clientes</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h5 class="modal-title">Importaçāo de dados</h5>
            </div>
            <div class="card-body">
                <div id="getResult">
                    <?php
                    $ClienteData = filter_input_array(INPUT_POST, FILTER_DEFAULT);
                    $userId = filter_input(INPUT_GET, 'postid', FILTER_VALIDATE_INT);
                    if ($ClienteData && $ClienteData['SendPostForm']):
                        $logoty['files'] = ($_FILES['files']['tmp_name'] ? $_FILES['files'] : null);

                        $Count = new Customer();
                        $Count->ExeImport($logoty, $id_db_settings);

                        if($Count->getResult()):
                            $Read = new Read();
                            $Read->ExeRead("cv_customer_import", "WHERE id_db_settings=:i ORDER BY id DESC LIMIT 1", "i={$id_db_settings}");

                            if($Read->getResult()):
                                $csv = $Read->getResult()[0]['files'];

                                $stream = fopen("uploads/{$csv}", "r");
                                $cvs = Reader::createFromStream($stream);

                                $cvs->setDelimiter(";");
                                $cvs->setOffset(0);

                                foreach ($cvs as $user):
                                    $Data['endereco'] = strip_tags(trim($user[4]));
                                    $Data['telefone'] = strip_tags(trim($user[3]));
                                    $Data['email'] = strip_tags(trim($user[2]));
                                    $Data['nif'] = strip_tags(trim($user[1]));
                                    $Data['nome'] = strip_tags(trim($user[0]));

                                    $Data["type"]          = "Consumidor final";
                                    $Data["addressDetail"] = "Consumidor final";
                                    $Data["city"]          = "Consumidor final";
                                    $Data["country"]       = "AO";
                                    $Data["status"]        = 3;

                                    $cover['logotype'] = null;

                                    $Customer = new Customer();
                                    $Customer->ExeCreate($cover, $Data, $id_db_settings);

                                    if($Customer->getResult()):
                                        WSError($Customer->getError()[0], $Customer->getError()[1]);
                                    else:
                                        WSError($Customer->getError()[0], $Customer->getError()[1]);
                                    endif;
                                endforeach;
                            endif;
                        else:
                            WSError($Count->getError()[0], $Count->getError()[1]);
                        endif;
                    endif;
                    ?>
                </div>
                <form method="post" name="SendPostForm" action="" enctype="multipart/form-data">
                    <div class="form-group">
                        <label class="form-label">Importaçāo de dados</label>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-5">
                            <span>Tipo de dados</span>
                            <select class="form-control" id="type" name="type">
                                <option>Clientes</option>
                            </select>
                        </div>
                        <div class="col-sm-5">
                            <span>Ficheiro csv</span>
                            <input type="file" required name="files" id="files" accept="text/csv" class="form-control"/>
                        </div>
                        <div class="col-sm-2">
                            <span>Açāo</span>
                            <input type="submit" name="SendPostForm" class="btn btn-primary" value="Importar">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
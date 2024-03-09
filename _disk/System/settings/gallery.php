<?php
if(!class_exists('login')):
    header("index.php");
    die();
endif;

if($level >= 4): $n =  '&id_db_settings='.$id_db_settings; else: $n = null; endif;

if($userlogin['level'] < 3):
    header("location: painel.php?exe=default/index".$n);
endif;

?>
<div class="page-header d-print-none">
    <div class="row align-items-center">
        <div class="col">
            <h2 class="page-title">
                Configurações
            </h2>
        </div>
    </div>
</div>
<div class="row gx-lg-4">
    <?php require_once("_disk/IncludesApp/MenuSettings.inc.php"); ?>
    <div class="col-lg-9">
        <div class="card">
            <div class="card-header">
                <h5 class="modal-title">Galeria de imagens</h5>
            </div>
            <div class="card-body">
                <?php
                    $ClienteData = filter_input_array(INPUT_POST, FILTER_DEFAULT);
                    if ($ClienteData && $ClienteData['SendPostForm']):
                        $BR = new DBKwanzar();
                        $BR->gbSend($_FILES['gallery'], $id_db_settings, $id_db_kwanzar);

                        if($BR->getResult()):
                            WSError($BR->getError()[0], $BR->getError()[1]);
                        else:
                            WSError($BR->getError()[0], $BR->getError()[1]);
                        endif;
                    endif;
                ?>
                <form method="post" action="" name = "SendPostForm"  enctype="multipart/form-data">
                    <div class="form-group">
                        <div class="mb-3">
                            <label class="form-label">Imagem (.jpg ou .png )</label>
                            <input type="file" multiple name="gallery[]" accept=".jpg, .png, .jpeg" class="form-control" placeholder="">
                        </div>
                    </div>
                    <hr/>
                    <div class="form-group row">
                        <div class="col-sm-10">
                            <input type="submit" name="SendPostForm" class="btn btn-primary btn-sm" value="Salvar"/>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
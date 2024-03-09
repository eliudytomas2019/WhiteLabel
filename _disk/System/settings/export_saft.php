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
                <h5 class="modal-title">Exportar SAF-T</h5>
            </div>
            <div class="card-body">
                <form method="post" action="saf-t.php" target="_blank">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label class="form-label">Download do ficheiro SAF-T para comunicar à AGT mensalmente os documentos emitidos.</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Exportar SAF-T.</label>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-5">
                            <label>Data Inicial</label>
                            <input type="hidden" name="id_db_settings" id="id_db_settings" value="<?= $id_db_settings; ?>"/>
                            <input type="date" required name="dataInicial" class="form-control"/>
                        </div>
                        <div class="col-sm-5">
                            <label>Data Final</label>
                            <input type="date" required name="dataFinal" class="form-control"/>
                        </div>
                        <div class="col-sm-2">
                            <br/>
                            <input type="submit" name="SendPostForm" class="btn btn-primary" value="Gerar SAFT">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
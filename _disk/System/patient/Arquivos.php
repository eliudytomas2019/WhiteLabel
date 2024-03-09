<?php
require_once("_disk/IncludesApp/PatientUsers.inc.php");
?>
<br/><div class="row gx-lg-4">
    <?php require_once("_disk/IncludesApp/MenuPatient.inc.php"); ?>
    <div class="col-lg-9">
        <div class="card">
            <div class="card-header">
                <h5 class="modal-title">Arquivos</h5>
            </div>
            <div class="card-body">
                <div id="getResult"></div>
                <div class="col-lg-12">
                    <?php
                    $ClienteData = filter_input_array(INPUT_POST, FILTER_DEFAULT);
                    if ($ClienteData && $ClienteData['SendPostForm']):
                        $logoty['gallery'] = ($_FILES['gallery']['tmp_name'] ? $_FILES['gallery'] : null);
                        $BR = new KwanzarDental();
                        $BR->gbSend($logoty, $id_db_settings, $postid);

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
                                <label class="form-label">Ficheiros</label>
                                <input type="file" name="gallery" accept=".jpg, .png, .jpeg, .docx, .doc, .pdf" class="form-control" placeholder="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-10">
                                <input type="submit" name="SendPostForm" class="btn btn-primary" value="Salvar"/>
                            </div>
                        </div>
                    </form>
                    <hr/>

                    <div class="table">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Type</th>
                                    <th>Data</th>
                                    <th>Hora</th>
                                    <th>-</th>
                                </tr>
                            </thead>
                            <tbody id="TheBox">
                                <?php
                                    require_once("_disk/SystemClinic/Arq.inc.php");
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
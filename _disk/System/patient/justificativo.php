<?php
require_once("_disk/IncludesApp/PatientUsers.inc.php");
?>
<br/><div class="row gx-lg-4">
    <?php require_once("_disk/IncludesApp/MenuPatient.inc.php"); ?>
    <div class="col-lg-9">
        <div class="card">
            <div class="card-header">
                <h5 class="modal-title">Novo Atestado</h5>
            </div>
            <div class="card-body">
                <div class="col-lg-12">
                    <div id="getResult">
                        <?php
                        $ClienteData = filter_input_array(INPUT_POST, FILTER_DEFAULT);
                        $userId = filter_input(INPUT_GET, 'postid', FILTER_VALIDATE_INT);
                        if ($ClienteData && $ClienteData['SendPostFormL']):

                            $Count = new KwanzarDental();
                            $Count->CreateJustificativo($ClienteData, $id_db_settings, $id_user, $postid);

                            if($Count->getResult()):
                                WSError($Count->getError()[0], $Count->getError()[1]);
                            else:
                                WSError($Count->getError()[0], $Count->getError()[1]);
                            endif;
                        endif;
                        ?>
                    </div>
                    <form method="post" action="" name="SendPostFormL"  enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-4">
                                <label>Data da Emissão</label>
                                <input type="date" name="data_emissao" id="data_emissao" value="<?php if(!empty($ClienteData['data_emissao'])): echo $ClienteData['data_emissao']; else: echo date('Y-m-d'); endif; ?>" class="form-control"/>
                            </div>
                            <div class="col-4">
                                <label>Quantidade de dias</label>
                                <input type="number" min="1" max="160" name="dias" id="dias" value="<?php if (!empty($ClienteData['dias'])) echo $ClienteData['dias']; else echo 1; ?>" class="form-control" placeholder=""/>
                            </div>
                            <div class="col-4">
                                <label>CID</label>
                                <input type="number" min="1" name="cid" id="cid" value="<?php if (!empty($ClienteData['cid'])) echo $ClienteData['cid']; else echo 1; ?>" class="form-control" placeholder=""/>
                            </div>
                        </div>

                        <?php if($userlogin['level'] == 3 || $userlogin['level'] >= 4): ?>
                            <div class="modal-footer">
                                <input type="submit" name="SendPostFormL" class="btn btn-primary ms-auto" value="Salvar"/>
                            </div>
                        <?php endif; ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
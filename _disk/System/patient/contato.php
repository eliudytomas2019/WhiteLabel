<?php
require_once("_disk/IncludesApp/PatientUsers.inc.php");
?>
<br/><div class="row gx-lg-4">
    <?php require_once("_disk/IncludesApp/MenuPatient.inc.php"); ?>
    <div class="col-lg-9">
        <div class="card">
            <div class="card-header">
                <h5 class="modal-title">Contato de Emergência</h5>
            </div>
            <div class="card-body">
                <div id="getResult"></div>
                <div class="col-lg-12">
                    <?php
                    $ClienteData = filter_input_array(INPUT_POST, FILTER_DEFAULT);
                    if ($ClienteData && $ClienteData['SendPostForm']):
                        $Count = new KwanzarDental();
                        $Count->ContactCustomer($postid, $ClienteData, $id_db_settings);

                        if($Count->getResult()):
                            WSError($Count->getError()[0], $Count->getError()[1]);

                            $ReadUser = new Read;
                            $ReadUser->ExeRead("cv_customer_contact", "WHERE id_paciente=:userid AND id_db_settings=:i", "userid={$postid}&i={$id_db_settings}");
                            if ($ReadUser->getResult()):
                                $ClienteData = $ReadUser->getResult()[0];
                            endif;
                        else:
                            WSError($Count->getError()[0], $Count->getError()[1]);
                        endif;
                    else:
                        $ReadUser = new Read;
                        $ReadUser->ExeRead("cv_customer_contact", "WHERE id_paciente=:userid AND id_db_settings=:i", "userid={$postid}&i={$id_db_settings}");
                        if ($ReadUser->getResult()):
                            $ClienteData = $ReadUser->getResult()[0];
                        endif;
                    endif;
                    ?>
                    <form  method="post" action="" name = "SendPostForm"  enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label class="form-label">Nome</label>
                                    <input name="nome" id="nome" class="form-control" placeholder="Nome"  value="<?php if (!empty($ClienteData['nome'])) echo $ClienteData['nome']; ?>" type="text">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">Telefone</label>
                                    <input type="text" id="telefone" class="form-control" placeholder="Telefone" name="telefone" value="<?php if (!empty($ClienteData['telefone'])) echo $ClienteData['telefone']; ?>">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">E-mail</label>
                                    <input type="email" id="email" class="form-control " placeholder="Telefone" name="email" value="<?php if (!empty($ClienteData['email'])) echo $ClienteData['email']; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="submit" name="SendPostForm" class="btn btn-primary ms-auto" value="Salvar"/>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
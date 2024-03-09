<?php
if(!class_exists('login')):
    header("index.php");
    die();
endif;

if($level >= 4): $n =  '&id_db_settings='.$id_db_settings; else: $n = null; endif;
$postId = filter_input(INPUT_GET, "postid", FILTER_VALIDATE_INT);
?>
<div class="page-header d-print-none">
    <div class="row align-items-center">
        <div class="col">
            <h2 class="page-title">
                Administração
            </h2>
        </div>
    </div>
</div>
<div class="row gx-lg-4">
    <?php require_once("_disk/IncludesApp/MenuDefinitions.inc.php"); ?>
    <div class="col-lg-9">
        <div class="row align-items-center">
            <div class="col">
                <div class="page-pretitle">
                    <?= $Index['name']; ?>
                </div>
                <h2 class="page-title">
                    Inventário dos Materiais Fixos
                </h2>
            </div>
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    <a href="panel.php?exe=fixos/indexx<?= $n; ?>" class="btn btn-primary">
                        Voltar</a>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h5 class="modal-title">Inventário dos Materias Fixos</h5>&nbsp;
            </div>
            <div class="card-body">
                <form class="form-horizontal" method="post" action="" name="SendPostFormL"  enctype="multipart/form-data">
                    <div class="card-body">
                        <div id="getResult">
                            <?php
                            $ClienteData = filter_input_array(INPUT_POST, FILTER_DEFAULT);
                            $userId = filter_input(INPUT_GET, 'postid', FILTER_VALIDATE_INT);
                            if ($ClienteData && $ClienteData['SendPostFormL']):

                                $Count = new KwanzarDental();
                                $Count->ExeUpdate($userId, $ClienteData, $id_db_settings);

                                if($Count->getResult()):
                                    WSError($Count->getError()[0], $Count->getError()[1]);
                                else:
                                    WSError($Count->getError()[0], $Count->getError()[1]);
                                endif;
                            else:
                                $ReadUser = new Read;
                                $ReadUser->ExeRead("cv_clinic_product", "WHERE id=:userid AND id_db_settings=:id", "userid={$userId}&id={$id_db_settings}");
                                if (!$ReadUser->getResult()):

                                else:
                                    $ClienteData = $ReadUser->getResult()[0];
                                endif;
                            endif;
                            ?>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label class="form-label">Descrição</label>
                                    <input type="text" name = "name" id="name" value="<?php if (!empty($ClienteData['name'])) echo $ClienteData['name']; ?>" class="form-control"  placeholder="Descrição"/>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label class="form-label">Código/Ref.</label>
                                    <input type="text" name = "codigo" id="codigo" value="<?php if (!empty($ClienteData['codigo'])) echo $ClienteData['codigo']; ?>" class="form-control"  placeholder="Código">
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label class="form-label">Unidade</label>
                                    <select name="type" id="v" class="form-control">
                                        <option value = "uni" <?php if (isset($ClienteData['type']) && $ClienteData['type'] == "uni") echo 'selected="selected"'; ?>>Unidade (uni)</option>
                                        <option value = "kg" <?php if (isset($ClienteData['type']) && $ClienteData['type'] == "kg") echo 'selected="selected"'; ?>>Kilograma (kg)</option>
                                        <option value = "L" <?php if (isset($ClienteData['type']) && $ClienteData['type'] == "L") echo 'selected="selected"'; ?>>Litro (L)</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" name="SendPostFormL" class="btn btn-primary ms-auto" value="Salvar"/>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
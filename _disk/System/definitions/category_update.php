<?php
if(!class_exists('login')):
    header("index.php");
    die();
endif;

if($level >= 4): $n =  '&id_db_settings='.$id_db_settings; else: $n = null; endif;
require_once("_disk/IncludesApp/Modal-porcentagem-de-ganho.inc.php");
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
            <?php require_once("btnBreak.inc.php");  ?>
            <div class="col">
                <div class="page-pretitle">
                    <?= $Index['name']; ?>
                </div>
                <h2 class="page-title">
                    Atualizar categoria
                </h2>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h5 class="modal-title">Atualizar categoria</h5>
            </div>
            <div class="card-body">
                <form  class="form-horizontal" method="post" action="" name = "SendPostForm"  enctype="multipart/form-data">
                    <div class="card-body">
                        <div class="mb-3">
                            <div id="getResult">
                                <?php
                                $ClienteData = filter_input_array(INPUT_POST, FILTER_DEFAULT);
                                $userId = filter_input(INPUT_GET, 'postid', FILTER_VALIDATE_INT);
                                if ($ClienteData && $ClienteData['SendPostForm']):
                                    $Count = new Category();
                                    $Count->ExeUpdate($userId, $ClienteData, $id_db_settings);

                                    if($Count->getResult()):
                                        WSError($Count->getError()[0], $Count->getError()[1]);
                                    else:
                                        WSError($Count->getError()[0], $Count->getError()[1]);
                                    endif;
                                else:
                                    $ReadUser = new Read;
                                    $ReadUser->ExeRead("cv_category", "WHERE id = :userid AND id_db_settings=:i", "userid={$userId}&i={$id_db_settings}");
                                    if (!$ReadUser->getResult()):

                                    else:
                                        $ClienteData = $ReadUser->getResult()[0];
                                    endif;
                                endif;
                                ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label class="form-label">Categoria</label>
                                    <input type="text"  class="form-control " placeholder="Categoria" name="category_title" id="category_title" value="<?php if (!empty($ClienteData['category_title'])) echo $ClienteData['category_title']; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label class="form-label">Descrição</label>
                                    <textarea name="category_content" id="category_content" class="form-control" placeholder="Observações"><?php if (!empty($ClienteData['category_content'])) echo $ClienteData['category_content']; ?></textarea>
                                </div>
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
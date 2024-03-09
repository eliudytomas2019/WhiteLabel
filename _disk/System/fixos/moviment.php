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
                <h5 class="modal-title">Inventário dos Materiais Fixos</h5>&nbsp;
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
                                    $Count->Moviment($ClienteData, $id_db_settings, $postId, $id_user);

                                    if($Count->getResult()):
                                        WSError($Count->getError()[0], $Count->getError()[1]);
                                    else:
                                        WSError($Count->getError()[0], $Count->getError()[1]);
                                    endif;
                                endif;
                            ?>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label class="form-label">* Quantidade</label>
                                    <input type="number" min="1" name = "qtd" id="qtd" value="<?php if (!empty($ClienteData['qtd'])) echo $ClienteData['qtd']; else echo "1"; ?>" class="form-control"  placeholder=""/>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label class="form-label">* Unidades</label>
                                    <input type="number" min="1" name = "unidades" id="unidades" value="<?php if (!empty($ClienteData['unidades'])) echo $ClienteData['unidades']; else echo "1"; ?>" class="form-control"  placeholder=""/>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label class="form-label">* Movimento</label>
                                    <select name="movimento" id="movimento" class="form-control">
                                        <option value="">-- Seleciona o movimento --</option>
                                        <option value = "entrada" <?php if (isset($ClienteData['movimento']) && $ClienteData['movimento'] == "entrada") echo 'selected="selected"'; ?>>Entrada</option>
                                        <option value = "saida" <?php if (isset($ClienteData['movimento']) && $ClienteData['movimento'] == "saida") echo 'selected="selected"'; ?>>Saída</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-3">
                                <label>Descrição</label>
                                <textarea name="content" id="content" class="form-control"><?php if (!empty($ClienteData['content'])) echo $ClienteData['content']; ?></textarea>
                            </div>
                        </div>
                    </div>
                    <hr/>
                    <div class="modal-footer">
                        <input type="submit" name="SendPostFormL" class="btn btn-primary ms-auto" value="Salvar"/>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
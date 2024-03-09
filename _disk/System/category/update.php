<?php
if(!class_exists('login')):
    header("index.php");
    die();
endif;

if($level >= 4): $n =  '&id_db_settings='.$id_db_settings; else: $n = null; endif;

if($userlogin['level'] < 1):
    header("location: panel.php?exe=default/index".$n);
endif;

$postId = filter_input(INPUT_GET, "postid", FILTER_VALIDATE_INT);
?>
<div class="page-header d-print-none">
    <div class="row align-items-center">

        <div class="col-auto ms-auto d-print-none">
            <div class="btn-list">
                <a href="panel.php?exe=category/index<?= $n; ?>" class="btn btn-primary d-none d-sm-inline-block">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 13l-4 -4l4 -4m-4 4h11a4 4 0 0 1 0 8h-1" /></svg>
                    Voltar
                </a>
            </div>
        </div>
        <div class="col">
            <div class="page-pretitle">
                <?= $Index['name']; ?>
            </div>
            <h2 class="page-title">
                Categorias
            </h2>
        </div>
    </div>
</div>


<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h5 class="modal-title">Atualizar ficha de categorias</h5>
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
                                    $ReadUser->ExeRead("cv_category", "WHERE id_xxx = :userid AND id_db_settings=:i", "userid={$userId}&i={$id_db_settings}");
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


                    <div class="row">
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label class="form-label">Porcentagem de Lucro</label>
                                <input type="text"  class="form-control " placeholder="Porcentagem de Lucro" name="porcentagem_ganho" id="porcentagem_ganho" value="<?php if (!empty($ClienteData['porcentagem_ganho'])) echo $ClienteData['porcentagem_ganho']; ?>">
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
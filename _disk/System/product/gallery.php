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
                <a href="panel.php?exe=product/index<?= $n; ?>" class="btn btn-primary">
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
                Itens
            </h2>
        </div>
    </div>
</div>

<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h5 class="modal-title">Galeria de imagens</h5>
        </div>
        <div class="card-body">
            <form class="form-horizontal" method="post" action="" name = "SendPostForm"  enctype="multipart/form-data">
                <div class="card-body">
                    <div id="getResult">
                        <?php
                            $ClienteData = filter_input_array(INPUT_POST, FILTER_DEFAULT);
                            if ($ClienteData && $ClienteData['SendPostForm']):
                                //$logotype['cover'] = ($_FILES['cover']['tmp_name'] ? $_FILES['cover'] : null);

                                $BR = new Product();
                                $BR->gbSend($_FILES['gallery'], $ClienteData, $postId, $id_db_settings);

                                if($BR->getResult()):
                                    WSError($BR->getError()[0], $BR->getError()[1]);
                                else:
                                    WSError($BR->getError()[0], $BR->getError()[1]);
                                endif;
                            else:
                                $ReadUser = new Read;
                                $ReadUser->ExeRead("cv_product", "WHERE id=:id AND id_db_settings=:i", "id={$postId}&i={$id_db_settings}");
                                if($ReadUser->getResult()):
                                    $ClienteData = $ReadUser->getResult()[0];
                                endif;
                            endif;
                        ?>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Titulo</label>
                                <input type="text" name="title" value="<?php if (!empty($ClienteData['product'])) echo $ClienteData['product']; ?>" class="form-control" placeholder="Produto">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Imagem (.jpg ou .png )</label>
                                <input type="file" multiple name="gallery[]" class="form-control" placeholder="">
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-12">
                        <?php
                            $delete = filter_input(INPUT_GET, 'delete', FILTER_VALIDATE_INT);

                            if($delete):
                                $Br = new Product();
                                $Br->gbRemove($delete);

                                WSError($Br->getError()[0], $Br->getError()[1]);
                            endif;
                        ?>
                        <div class="row">
                            <div class="col-md-12 col-xl-6">
                                <div class="mb-3">
                                    <label class="form-label">Imagens da galeria</label>
                                    <div class="row g-2">
                                        <?php
                                            $read->ExeRead("cv_gallery_product", "WHERE  id_db_settings=:ip AND id_cv_product=:i", "ip={$id_db_settings}&i={$postId}");
                                            if($read->getResult()):
                                                foreach($read->getResult() as $key):
                                                    extract($key);
                                                    ?>
                                                    <div class="col-6 col-sm-4">
                                                        <label class="form-imagecheck mb-2">
                                                            <img src="uploads/<?= $key['cover']; ?>" alt="Breakfast served with tea, bread and eggs" class="form-imagecheck-image">
                                                            <a href="<?= HOME; ?>panel.php?exe=product/gallery<?= $n; ?>&postid=<?= $postId; ?>&delete=<?= $key['id']; ?>" class="btn btn-icon btn-danger btn-round btn-xs">Apagar
                                                            </a>
                                                        </label>
                                                    </div>
                                                    <?php
                                                endforeach;
                                            endif;
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <input type="submit" name="SendPostForm" class="btn btn-primary ms-auto" value="Adicionar item"/>
                </div>
            </form>
        </div>
    </div>
</div>
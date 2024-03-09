<?php
/**
 * Created by PhpStorm.
 * User: Kwanzar Soft
 * Date: 15/10/2020
 * Time: 13:06
 */

if(!class_exists('login')):
    header("index.php");
    die();
endif;

if($level >= 4): $n =  '&id_db_settings='.$id_db_settings; else: $n = null; endif;

if($userlogin['level'] < 2):
    header("location: panel.php?exe=default/index".$n);
endif;

$postId = filter_input(INPUT_GET, "postid", FILTER_VALIDATE_INT);

?>

<div class="row page-titles mx-0">
    <div class="col p-md-0">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= HOME; ?>panel.php?exe=default/home<?php if($level >= 4): echo '&id_db_settings='.$id_db_settings; endif; ?>">Painel de controle</a></li>
            <li class="breadcrumb-item active"><a href="<?= HOME; ?>panel.php?exe=product/index<?php if($level >= 4): echo '&id_db_settings='.$id_db_settings; endif; ?>">Produto/Serviços</a></li>
        </ol>
    </div>
</div><br/>

<div class="container-fluid">
    <div class="page-inner mt--5">
        <div class="row mt--2">

            <div id="styles">
                <a href="<?= HOME; ?>panel.php?exe=product/index<?= $n; ?>" class="btn btn-primary btn-icon-split btn-sm">
                    <span class="text">Voltar</span>
                </a>
            </div>

            <div class="col-md-12">
                <div class="card full-height">
                    <div class="card-body">
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
                        <form class="form-horizontal" method="post" action="" name = "SendPostForm"  enctype="multipart/form-data">
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <span>Titulo</span>
                                    <input type="text" name="title" value="<?php if (!empty($ClienteData['product'])) echo $ClienteData['product']; ?>" class="form-control" placeholder="Produto">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-12 mb-3 mb-sm-0">
                                    <span>Imagem (.jpg ou .png )</span>
                                    <input type="file" multiple name="gallery[]" class="form-control" placeholder="">
                                </div>
                            </div>

                            <?php
                            $delete = filter_input(INPUT_GET, 'delete', FILTER_VALIDATE_INT);

                            if($delete):
                                $Br = new Product();
                                $Br->gbRemove($delete);

                                WSError($Br->getError()[0], $Br->getError()[1]);
                            endif;
                            ?>

                            <div class="card-list">
                                <?php
                                $read->ExeRead("cv_gallery_product", "WHERE  id_db_settings=:ip AND id_cv_product=:i", "ip={$id_db_settings}&i={$postId}");
                                if($read->getResult()):
                                    foreach($read->getResult() as $key):
                                        extract($key);
                                        ?>
                                        <div class="item-list">
                                            <div class="avatar">
                                                <img src="uploads/<?= $key['cover']; ?>" class="avatar-img rounded-circle">
                                            </div>&nbsp;
                                            <a href="<?= HOME; ?>panel.php?exe=product/gallery<?= $n; ?>&postid=<?= $postId; ?>&delete=<?= $key['id']; ?>" class="btn btn-icon btn-danger btn-round btn-xs">
                                                <i class="fas fa-window-close"></i>
                                            </a>
                                        </div>
                                        <?php
                                    endforeach;
                                endif;
                                ?>
                            </div>

                            <hr>
                            <input type="submit" name="SendPostForm" class="btn btn-primary btn-sm" value="Salvar"/>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
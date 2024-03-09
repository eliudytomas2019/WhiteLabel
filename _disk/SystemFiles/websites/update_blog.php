<div class="page-header d-print-none">
    <div class="row align-items-center">
        <div class="col">
            <div class="page-pretitle">
                ProSmart
            </div>
            <h2 class="page-title">
                Websites Blog
            </h2>
        </div>
        <div class="col-auto ms-auto d-print-none">
            <div class="btn-list">
                <a href="Admin.php?exe=websites/blog" class="btn btn-warning d-none d-sm-inline-block">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 13l-4 -4l4 -4m-4 4h11a4 4 0 0 1 0 8h-1" /></svg>
                    Voltar
                </a>
            </div>
        </div>
    </div>
</div>

<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h5 class="modal-title">Adicionar Item</h5>
        </div>
        <div class="card-body">
            <form class="form-horizontal" method="post" action="" name="SendPostFormL"  enctype="multipart/form-data">
                <div class="card-body">
                    <div id="getResult">
                        <?php
                        $postId = filter_input(INPUT_GET, "postId", FILTER_VALIDATE_FLOAT);
                        $ClienteData = filter_input_array(INPUT_POST, FILTER_DEFAULT);
                        $userId = filter_input(INPUT_GET, 'postid', FILTER_VALIDATE_INT);
                        if ($ClienteData && $ClienteData['SendPostFormL']):

                            $logotype['logotype'] = ($_FILES['logotype']['tmp_name'] ? $_FILES['logotype'] : null);
                            $Count = new Websites();
                            $Count->UpdateBlog($logotype, $ClienteData, $postId);

                            WSError($Count->getError()[0], $Count->getError()[1]);
                        else:
                            $Read = new Read();
                            $Read->ExeRead("website_blog", "WHERE id=:i", "i={$postId}");
                            if($Read->getResult()):
                                $ClienteData = $Read->getResult()[0];
                            endif;
                        endif;
                        ?>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label class="form-label">Titulo</label>
                                <input type="text" name="titulo" id="titulo" value="<?php if (!empty($ClienteData['titulo'])) echo $ClienteData['titulo']; ?>" class="form-control"  placeholder="Titulo"/>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label class="form-label">Autor</label>
                                <select name="id_author" id="id_author" class="form-control">
                                    <option value = "">-- Selecione o autor --</option>
                                    <?php
                                    $read = new Read();
                                    $read->ExeRead("website_author", "ORDER BY name ASC");

                                    if($read->getResult()):
                                        foreach ($read->getResult() as $key):
                                            extract($key);

                                            ?>
                                            <option value = "<?= $key['id']; ?>" <?php if (isset($ClienteData['id_author']) && $ClienteData['id_author'] == $key['id']) echo 'selected="selected"'; ?>><?= $key['name']; ?></option>
                                        <?php
                                        endforeach;
                                    endif;
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label class="form-label">Categoria</label>
                                <select name="id_category" id="id_category"   class="form-control">
                                    <option value = "">-- Selecione a categoria --</option>
                                    <?php
                                    $read = new Read();
                                    $read->ExeRead("website_category", "ORDER BY name ASC");

                                    if($read->getResult()):
                                        foreach ($read->getResult() as $key):
                                            extract($key);

                                            ?>
                                            <option value = "<?= $key['id']; ?>" <?php if (isset($ClienteData['id_category']) && $ClienteData['id_category'] == $key['id']) echo 'selected="selected"'; ?>><?= $key['name']; ?></option>
                                        <?php
                                        endforeach;
                                    endif;
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label class="form-label">Imagem (.jpg ou .png)</label>
                                <input type="file" name="logotype" class="form-control" placeholder="" value="">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label class="form-label">Subititulo</label>
                                <input type="text" name="subtitulo" id="subtitulo" value="<?php if (!empty($ClienteData['subtitulo'])) echo $ClienteData['subtitulo']; ?>" class="form-control"  placeholder="Subtitulo">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label class="form-label">Hora</label>
                                <input type="time" name="hora" id="hora" value="<?php if (empty($ClienteData['hora'])): echo date('H:i', time()); else: echo $ClienteData['hora']; endif; ?>" class="form-control"  placeholder="Hora">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label class="form-label">Data</label>
                                <input type="date" name="data" id="data" value="<?php if (!empty($ClienteData['data'])): echo $ClienteData['data']; else: echo date('Y-m-d'); endif; ?>" class="form-control"  placeholder="Data">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label class="form-label">Descrição</label>
                                <textarea placeholder="Descrição" class="form-control" name="content" id="content"><?php if (!empty($ClienteData['content'])) echo htmlspecialchars($ClienteData['content']); ?></textarea>
                            </div>
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
    <br/>
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
                            $BR = new Websites();
                            $BR->gbSend($_FILES['gallery'], $postId);

                            if($BR->getResult()):
                                WSError($BR->getError()[0], $BR->getError()[1]);
                            else:
                                WSError($BR->getError()[0], $BR->getError()[1]);
                            endif;
                        endif;
                        ?>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label class="form-label">Imagem (.jpg ou .png )</label>
                                <input type="file" multiple name="gallery[]" class="form-control" placeholder="">
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
    <br/>
    <div class="row row-cards">
    <?php
        $database = "website_blog_gallery";
        $id = filter_input(INPUT_GET, "id", FILTER_DEFAULT);
        if(isset($id) || $id != null):
            $Read = new Read();
            $Update = new Update();
            $action = filter_input(INPUT_GET, "action", FILTER_DEFAULT);
            switch ($action):
                case "delete":
                    $Delete = new Delete();
                    $Delete->ExeDelete($database, "WHERE id=:i", "i={$id}");
                    if($Delete->getResult() || $Delete->getRowCount()):
                        WSError("Publicaçāo apagada com sucesso!", WS_ACCEPT);
                    else:
                        WSError("Ops: aconteceu um erro inesperado ao apagar a publicaçāo!", WS_ERROR);
                    endif;
                    break;
                default:
                    WSError("Ops: nāo encontramos a açāo desejada!", WS_INFOR);
            endswitch;
        endif;

        $read = new Read();
        $read->ExeRead($database, "WHERE id_blog=:i", "i={$postId}");
        if($read->getResult()):
            foreach ($read->getResult() as $key):
                ?>
                <div class="col-sm-6 col-lg-4">
                    <div class="card card-sm">
                        <a href="#" class="d-block"><img src="uploads/<?php if($key["cover"] != '' || !empty($key['cover'])): echo $key["cover"]; else: echo 'default.jpg'; endif; ?>" class="card-img-top"></a>
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="ms-auto">
                                    <a href="Admin.php?exe=websites/update_blog&postId=<?= $postId; ?>&id=<?= $key['id']; ?>&action=delete" class="btn btn-sm btn-danger">Apagar</a>&nbsp;
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            endforeach;
        endif;
    ?>
    </div>
</div>
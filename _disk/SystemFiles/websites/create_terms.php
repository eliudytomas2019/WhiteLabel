<div class="page-header d-print-none">
    <div class="row align-items-center">
        <div class="col">
            <div class="page-pretitle">
                ProSmart
            </div>
            <h2 class="page-title">
                Websites Termos de uso
            </h2>
        </div>
        <div class="col-auto ms-auto d-print-none">
            <div class="btn-list">
                <a href="Admin.php?exe=websites/index_terms" class="btn btn-warning d-none d-sm-inline-block">
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
            <h5 class="modal-title">Criar Termos de uso</h5>
        </div>
        <div class="card-body">
            <form class="form-horizontal" method="post" action="" name="SendPostFormL"  enctype="multipart/form-data">
                <div class="card-body">
                    <div id="getResult">
                        <?php
                        $ClienteData = filter_input_array(INPUT_POST, FILTER_DEFAULT);
                        $userId = filter_input(INPUT_GET, 'postid', FILTER_VALIDATE_INT);
                        if ($ClienteData && $ClienteData['SendPostFormL']):
                            $Count = new Websites();
                            $Count->ExeTerms($ClienteData);

                            WSError($Count->getError()[0], $Count->getError()[1]);
                        endif;
                        ?>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label class="form-label">Titulo</label>
                                <input type="text" name="title" id="title" value="<?php if (!empty($ClienteData['title'])) echo $ClienteData['title']; ?>" class="form-control"  placeholder="Nome"/>
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
</div>
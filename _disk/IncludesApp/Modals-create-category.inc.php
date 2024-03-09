<div class="modal modal-blur fade" id="modalCategory" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <form method="post" action="" name="FormCategory"  enctype="multipart/form-data" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Adicionar nova categoria</h5>
                <a href="#" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></a>
            </div>
            <div class="modal-body">
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
                <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">Cancelar</a>
                <button type="submit" name="SendPostForm" class="btn btn-primary ms-auto">Adicionar nova categoria</button>
            </div>
        </form>
    </div>
</div>
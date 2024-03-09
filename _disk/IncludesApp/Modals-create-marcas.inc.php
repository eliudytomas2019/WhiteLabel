<div class="modal modal-blur fade" id="modalMarca" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <form method="post" action="" name="FormMarca"  enctype="multipart/form-data" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Adicionar nova Marca</h5>
                <a href="#" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></a>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="mb-3">
                            <label class="form-label">Marca</label>
                            <input type="text"  class="form-control " placeholder="Marca" name="marca" id="marca" value="<?php if (!empty($ClienteData['marca'])) echo $ClienteData['marca']; ?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="mb-3">
                            <label class="form-label">Descrição</label>
                            <textarea name="content" id="content" class="form-control" placeholder="Observações"><?php if (!empty($ClienteData['content'])) echo $ClienteData['content']; ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <hr/>
            <div class="modal-footer">
                <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">Cancelar</a>
                <button type="submit" name="SendPostForm" class="btn btn-primary ms-auto">Salvar</button>
            </div>
        </form>
    </div>
</div>
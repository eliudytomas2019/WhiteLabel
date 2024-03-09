<div class="modal modal-blur fade" id="modalObs" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <form method="post" action="" name = "FormCreateObs"  enctype="multipart/form-data" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Criar nova Observação</h5>
                <a href="#" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></a>
            </div>
            <div class="modal-body">
                <div class="mb-3"><div id="getResult"></div></div>
                <div class="col-md-12">
                    <div class="mb-3">
                        <label class="form-label">Cliente</label>
                        <input name="nomeS" id="nomeS" class="form-control" placeholder="Observação"  value="<?php if (!empty($ClienteData['nomeS'])) echo $ClienteData['nomeS']; ?>" type="text">
                    </div>
                </div>
            </div>
            <hr/>
            <div class="modal-footer">
                <button type="submit" name="SendPostForm" class="btn btn-primary ms-auto">Salvar</button>
            </div>
        </form>
    </div>
</div>
<div class="modal modal-blur fade" tabindex="-1" role="dialog" aria-hidden="true" id="mesas">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Adicionar novo local</h5>
                <a href="#" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></a>
            </div>
            <div class="modal-body">
                <div id="getResult"></div>
                <form method="post" action="" name="FormCreateMesa">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label class="form-label">Local</label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Local"/>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label class="form-label">Localização</label>
                                <input type="text" name="localizacao" id="localizacao" class="form-control" placeholder="Localização"/>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label class="form-label">Capacidade</label>
                                <input type="text" name="capacidade" id="capacidade" class="form-control" placeholder="Capacidade"/>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label class="form-label">Observações</label>
                                <textarea name="obs" id="obs" class="form-control" placeholder="Observações"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

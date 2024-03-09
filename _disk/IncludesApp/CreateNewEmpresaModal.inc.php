<div class="modal modal-blur fade" id="modal-report" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <form id="formulario"  name="form_register" action="#" method="post" enctype="multipart/form-data" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Registrar nova Empresa</h5>
                <a href="#" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></a>
            </div>
            <div class="modal-body">
                <div class="mb-3"><div id="getResult"></div></div>
                <div class="mb-3">
                    <label class="form-label">Empresa</label>
                    <input type="text" class="form-control" name="empresa" id="empresa" placeholder="Nome da empresa">
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label class="form-label">NIF</label>
                            <input type="text" name="nif" id="nif" class="form-control" placeholder="NIF">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label class="form-label">Telefone</label>
                            <input type="text" name="telefone" id="telefone" class="form-control" placeholder="Telefone">
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label class="form-label">E-mail</label>
                            <input type="text" name="email" id="email" class="form-control" placeholder="E-mail">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label class="form-label">Endereço</label>
                            <input type="text" name="endereco" id="endereco" class="form-control" placeholder="Endereço">
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label class="form-label">Módulos</label>
                            <select id="atividade" name="atividade" class="form-control">
                                <option value="1" selected>Facturação & Stock</option>
                                <option value="19">Gestão Clínica</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <hr/>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary ms-auto">
                   Salvar
                </button>
            </div>
        </form>
    </div>
</div>
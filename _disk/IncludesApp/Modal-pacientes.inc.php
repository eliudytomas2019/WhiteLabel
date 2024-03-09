<div class="modal modal-blur fade" id="modal-pacientes" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Adicionar Paciente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="Kialumingo"></div>
                <form method="post" action="" enctype="multipart/form-data">
                    <div class="col-lg-12">
                        <div class="col-lg-12">
                            <span>Nome</span>
                            <input type="text" class="form-control" name="nome" id="nome" placeholder="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <span>Nº de Identificação</span>
                            <input type="text" class="form-control" name="nif" id="nif" placeholder="">
                        </div>
                        <div class="col-lg-6">
                            <span>Telefone</span>
                            <input type="text" class="form-control" name="telefone" id="telefone" placeholder="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <span>E-mail</span>
                            <input type="text" class="form-control" name="email" id="email" placeholder="">
                        </div>
                        <div class="col-lg-6">
                            <span>Endereço</span>
                            <input type="text" class="form-control" name="endereco" id="endereco" placeholder="">
                        </div>
                    </div>
                    <hr/>
                    <button type="button" onclick="SalvePaciente();" class="btn btn-primary">Salvar</button>
                </form>
            </div>
        </div>
    </div>
</div>
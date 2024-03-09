<?php
/**
 * Created by PhpStorm.
 * User: Kwanzar Soft
 * Date: 16/08/2020
 * Time: 15:10
 */
?>
<div class="modal modal-blur fade" tabindex="-1" role="dialog" aria-hidden="true" id="garcom">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Adicionar novo operador</h5>
                <a href="#" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></a>
            </div>
            <div class="modal-body">
                <div id="getResult"></div>
                <form method="post" action="" name="FormCreateGarcom">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label class="form-label">Operador</label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Operador"/>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label class="form-label">Telefone</label>
                                <input type="text" name="telefone" id="telefone" class="form-control" placeholder="Telefone"/>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label class="form-label">Porcentagem</label>
                                <input type="text" name="porcentagem" id="porcentagem" class="form-control" placeholder="Porcentagem"/>
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

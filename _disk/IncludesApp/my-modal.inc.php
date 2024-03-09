<div class="modal modal-blur fade" id="ConfigLocal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <form method="post" action="" name = "FormCreateCustomer"  enctype="multipart/form-data" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Configurações de local</h5>
                <a href="#" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></a>
            </div>
            <div class="modal-body">
                <form method="post" action="">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label class="form-label">Local</label>
                                <select id="idMesa" class="form-control">
                                    <?php
                                    $Read = new Read();
                                    $Read->ExeRead("cv_mesas", "WHERE id_db_settings=:i ORDER BY id ASC", "i={$id_db_settings}");

                                    if($Read->getResult()):
                                        foreach($Read->getResult() as $key):
                                            extract($key);
                                            ?>
                                            <option value="<?= $key['id'] ?>"><?= $key['name']; ?></option>
                                        <?php
                                        endforeach;
                                    endif;
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label class="form-label">Ação</label>
                                <select id="optionMesa" class="form-control">
                                    <option value="1">Livre</option>
                                    <option value="2">Em uso</option>
                                    <option value="3">Reservada</option>
                                    <option value="4">Em manutenção</option>
                                </select>
                            </div>
                        </div>
                        <a href="javascript:void()" onclick="OptionMesa()" class="btn btn-primary">Salvar</a>
                    </div>
                </form>
            </div>
        </form>
    </div>
</div>
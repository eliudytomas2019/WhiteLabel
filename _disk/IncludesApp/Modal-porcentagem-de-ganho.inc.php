<div class="modal modal-blur fade" id="modal-porcentagem-de-ganho" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Porcentagem de Ganho</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="getResult"></div>
                <form method="post" action="" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-6">
                            <span>Médico</span>
                            <select name="id_userx" id="id_userx" class="form-control">
                                <option>--- Seleciona o Médico ---</option>
                                <?php
                                $lv = 3;
                                $status = 1;
                                $Read = new Read();
                                $Read->ExeRead("db_users", "WHERE id_db_settings=:i AND level=:lv AND status=:st ", "i={$id_db_settings}&lv={$lv}&st={$status}");

                                if($Read->getResult()):
                                    foreach ($Read->getResult() as $key):
                                        ?>
                                        <option value="<?= $key['id']; ?>"><?= $key['name']." ({$key['username']})"; ?></option>
                                    <?php
                                    endforeach;
                                endif;
                                ?>
                            </select>
                        </div>
                        <div class="col-6">
                            <span>Porcentagem de Ganho</span>
                            <input type="number" value="0" min="0" max="100" name="porcentagem" id="porcentagem" class="form-control" placeholder="Porcentagem"/>
                        </div>
                    </div>
                    <hr/>
                    <button type="button" onclick="PorcentagemGanhos();" class="btn btn-primary">Salvar</button>
                </form>
            </div>
        </div>
    </div>
</div>
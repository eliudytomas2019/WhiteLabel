<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Relatório de oficina</h3>&nbsp;
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-3">
                    <div class="mb-3">
                        <span>Data Inicial</span>
                        <input type="date" id="date_i" class="form-control" placeholder=""/>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="mb-3">
                        <span>Data Final</span>
                        <input type="date" id="date_f" class="form-control" placeholder=""/>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="mb-3">
                        <span>Pesuisar</span>
                        <input type="text" id="pesquisar" class="form-control" placeholder="Pesquisar por: Matricula, Modelo, Cliente e NIF...">
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="mb-3">
                        <span>Mêcanico</span>
                        <select class="form-control" id="id_users">
                            <?php if($level >= 3): ?>
                                <option value="all">Todos Mêcanico</option>
                                <?php
                                $read->ExeRead("db_users", "WHERE id_db_settings=:i AND level='1' ORDER BY name ASC", "i={$id_db_settings}");
                                if($read->getResult()):
                                    foreach($read->getResult() as $key):
                                        extract($key);
                                        ?>
                                        <option value="<?= $key['id']; ?>"><?= $key['name']; ?></option>
                                    <?php
                                    endforeach;
                                endif;
                                ?>
                            <?php else: ?>
                                <option value="<?= $id_user; ?>">Minhas Reparações</option>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="mb-3">
                        <span></span>
                        <button type="submit" onclick="BioloRapido();" style="border-radius: 2px!important;" class="btn btn-primary">Pesquisar</button>
                    </div>
                </div>
            </div>

            <div class="table table-responsive" id="BioloRapido">

            </div>
        </div>
    </div>
</div>
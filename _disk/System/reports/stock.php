<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Mapa de Stock</h3>&nbsp;
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-3">
                    <div class="mb-3">
                        <label class="form-label">Categoria</label>
                        <select class="form-control" id="Categories_id">
                            <option value="all">Todas Categorias</option>
                            <?php
                            $read = new Read();
                            $read->ExeRead("cv_category", "WHERE id_db_settings=:i ORDER BY category_title ASC", "i={$id_db_settings}");
                            if($read->getResult()):
                                foreach($read->getResult() as $key):
                                    extract($key);
                                    ?>
                                    <option value="<?= $key['id']; ?>"><?= $key['category_title']; ?></option>
                                <?php
                                endforeach;
                            endif;
                            ?>
                        </select>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="mb-3">
                        <label class="form-label">T. Itens</label>
                        <select class="form-control" id="Itens_type">
                            <option value = "all">todos tipos de itens</option>
                            <option value = "P">Produto</option>
                            <option value = "S">Serviço</option>
                            <option value = "O">Outros (portes, adiantamentos, etc)</option>
                        </select>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="mb-3">
                        <label class="form-label">Imposto</label>
                        <select class="form-control" name="id_iva" id="id_iva">
                            <option value="all">Todas as Taxas de Imposto</option>
                            <?php
                                $read->ExeRead("db_taxtable", "WHERE id_db_settings=:id ORDER BY taxPercentage ASC, taxCode ASC", "id={$id_db_settings}");

                                if($read->getResult()):
                                    foreach ($read->getResult() as $key):
                                        extract($key);
                                        ?>
                                        <option value="<?= $key['taxtableEntry']; ?>" <?php if(isset($ClienteData['id_iva']) && $ClienteData['id_iva'] == $key['taxtableEntry']) echo "selected='selected'" ?>>
                                            <?= $key['taxCode']." - ".$key['taxType']." (".$key['taxPercentage']."%) "; ?>
                                        </option>
                                    <?php
                                    endforeach;
                                endif;
                            ?>
                        </select>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="mb-3">
                        <label class="form-label">Locatização do Item</label>
                        <select class="form-control" name="ILoja" id="ILoja">
                            <option value="all">Todos os Itens</option>
                            <option value="2" <?php if (isset($ClienteData['ILoja']) && $ClienteData['ILoja'] == 2) echo 'selected="selected"'; ?>>Visiveis no Front</option>
                            <option value="1"  <?php if (isset($ClienteData['ILoja']) && $ClienteData['ILoja'] == 1) echo 'selected="selected"'; ?>>Visiveis no BackOffice</option>
                        </select>
                    </div>
                </div>
            </div>

            <a href="javascript:void()" onclick="ProSmatDocsOne();" class="btn btn-primary">
                Pesquisar
            </a>
        </div>
        <div class="body-content-index" id="getResult">
        </div>
    </div>
</div>
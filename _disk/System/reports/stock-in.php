<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Movimentos de Stock</h3>&nbsp;
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-3">
                    <div class="mb-3">
                        <label class="form-label">Data Inicio</label>
                        <?php $null = array(); $read->ExeRead("db_kwanzar", "WHERE id=:id", "id={$id_db_kwanzar}"); if($read->getResult()):$null = $read->getResult()[0];endif; ?>
                        <input type="date" id="dateI" class="form-control" value="<?= date('Y-m-d'); ?>" placeholder="Data Fnicial"/>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="mb-3">
                        <label class="form-label">Data Final</label>
                        <input type="date" id="dateF" class="form-control" value="<?= date('Y-m-d'); ?>" placeholder="Data Final"/>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="mb-3">
                        <label class="form-label">Movimento</label>
                        <select name="operacao" id="operacao" class="form-control">
                            <option value="all">Todos Movimentos</option>
                            <option value="Entrada" <?php if (isset($ClienteData['operacao']) && $ClienteData['operacao'] == "Entrada") echo 'selected="selected"'; ?>>Entrada</option>
                            <option value="Saída"  <?php if (isset($ClienteData['operacao']) && $ClienteData['operacao'] == "Saída") echo 'selected="selected"'; ?>>Saída</option>
                            <option value="Rectificaçāo"  <?php if (isset($ClienteData['operacao']) && $ClienteData['operacao'] == "Rectificaçāo") echo 'selected="selected"'; ?>>Rectificaçāo</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="mb-3">
                        <br/>
                        <a href="javascript:void()" onclick="WhitelabelDocsOne();" class="btn btn-primary">
                            Pesquisar
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="body-content-index" id="getResult">
        </div>
    </div>
</div>
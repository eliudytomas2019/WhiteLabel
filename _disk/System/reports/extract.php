<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Extrato de Conta</h3>&nbsp;
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-3">
                    <div class="mb-3">
                        <label class="form-label">Data Inicio</label>
                        <?php $null = array(); $read->ExeRead("db_kwanzar", "WHERE id=:id", "id={$id_db_kwanzar}"); if($read->getResult()):$null = $read->getResult()[0];endif; ?>
                        <input type="date" id="dateI" class="form-control" placeholder="Data Fnicial"/>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="mb-3">
                        <label class="form-label">Data Final</label>
                        <input type="date" id="dateF" class="form-control" placeholder="Data Final"/>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="mb-3">
                        <label class="form-label">Cliente</label>
                        <select class="form-control" id="Customers_id">
                            <option value="all">Todos Clientes </option>
                            <?php
                            $read->ExeRead("cv_customer", "WHERE id_db_settings=:i ORDER BY nome ASC", "i={$id_db_settings}");
                            if($read->getResult()):
                                foreach($read->getResult() as $key):
                                    extract($key);
                                    ?>
                                    <option value="<?= $key['id']; ?>"><?= $key['nome']; ?></option>
                                <?php
                                endforeach;
                            endif;
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="mb-3">
                        <label class="form-label">Metodos de pagamento</label>
                        <select class="form-control" id="method_id">
                            <option selected value="all">todos metodos de pagamento</option>
                            <option value="CD">Cartão de Debito</option>
                            <option value="NU">Numerário</option>
                            <option value="TB">Transferência Bancária</option>
                            <option value="MB">Referência de pagamentos para Multicaixa</option>
                            <option value="OU">Outros Meios Aqui não Assinalados</option>
                        </select>
                    </div>
                </div>
            </div>

            <a href="javascript:void()" onclick="ExtractCustomer();" class="btn btn-primary">
                Pesquisar
            </a>

            <hr/>

            <div id="getResult"></div>
        </div>
    </div>
</div>
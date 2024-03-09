<div class="page-header d-print-none">
    <div class="row align-items-center">
        <div class="col">
            <div class="page-pretitle">
                <?= $Index['name']; ?>
            </div>
            <h2 class="page-title">
                Operações Patrimonial
            </h2>
        </div>
        <div class="col-auto ms-auto d-print-none">
            <div class="btn-list">

            </div>
        </div>
    </div>
</div>
<div class="row row-cards">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="modal-title">Operações Patrimonial</h5>
            </div>
            <div class="card-body" id="AdilsonTomas">
                <div id="Obama"></div>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label>Patrimonio</label>
                            <select class="form-control" name="id_table" id="id_table">
                                <?php
                                    $Read = new Read();
                                    $Read->ExeRead("p_table", "ORDER BY nome ASC");
                                    if($Read->getResult()):
                                        foreach ($Read->getResult() as $key):
                                            ?>
                                            <option value="<?= $key['id']; ?>"><?= $key['nome']; ?></option>
                                            <?php
                                        endforeach;
                                    endif;
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label>Local de Armazenamento</label>
                            <select class="form-control" name="id_local" id="id_local">
                                <?php
                                $Read = new Read();
                                $Read->ExeRead("p_local", "ORDER BY  nome ASC");
                                if($Read->getResult()):
                                    foreach ($Read->getResult() as $key):
                                        ?>
                                        <option value="<?= $key['id']; ?>"><?= $key['nome']; ?></option>
                                        <?php
                                    endforeach;
                                endif;
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label>Funcionário</label>
                            <select class="form-control" name="id_funcionario" id="id_funcionario">
                                <?php
                                $Read = new Read();
                                $Read->ExeRead("p_funcionario", "ORDER BY nome ASC");
                                if($Read->getResult()):
                                    foreach ($Read->getResult() as $key):
                                        ?>
                                        <option value="<?= $key['id']; ?>"><?= $key['nome']; ?></option>
                                        <?php
                                    endforeach;
                                endif;
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-12 mb-6">
                        <div class="form-group">
                            <label>Descrição</label>
                            <textarea class="form-control" id="descricao" placeholder="Observações"><?php if(isset($ClienteData['descricao'])) echo $ClienteData['descricao']; ?></textarea>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-8 mb-3">

                    </div>
                    <div class="col-md-4 mb-3">
                        <button type="submit" class="btn btn-primary" onclick="OperacaoPatrimonial()">Salvar</button>
                    </div>
                </div>
                <div class="form-row mb-3 float-right">

                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5 class="modal-title">Histórico de Atribuições</h5>
            </div>
            <div class="card-body" id="sd_billing">
                <div class="col-auto ms-auto d-print-none">
                    <div class="d-flex">
                        <input type="search" class="form-control d-inline-block w-9 me-3" id="AbiudyTomas" placeholder="Pesquisar Atribuições"/>
                    </div>
                </div><br/>

                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nº</th>
                                <th>Data</th>
                                <th>Doc.</th>
                                <th>-</th>
                            </tr>
                        </thead>
                        <tbody id="CamiloMiguel">
                            <?php
                                $Read = new Read();
                                $Read->ExeRead("p_atribuicoes", "WHERE id_db_settings=:i ORDER BY id DESC LIMIT 10", "i={$id_db_settings}");

                                if($Read->getResult()):
                                    foreach ($Read->getResult() as $key):
                                        ?>
                                        <tr>
                                            <td><?= $key['id']; ?></td>
                                            <td><?= $key['data']." ".$key['hora']; ?></td>
                                            <td><?= "P".$key['id']."/".date('Y'); ?></td>
                                            <td><a href="print.php?&number=19&action=19&id_db_settings=<?= $id_db_settings; ?>&postId=<?= $key['id']; ?>" class="btn btn-default btn-sm" target="_blank">Imprimir</a>
                                                <?php
                                                if($key['status'] == 1):
                                                    ?>
                                                    <a href="#" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#ModalDefault" onclick="EditarAtribuicao(<?= $key['id']; ?>)">Editar</a>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <?php
                                    endforeach;
                                endif;
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
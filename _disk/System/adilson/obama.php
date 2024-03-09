<div class="page-header d-print-none">
    <div class="row align-items-center">
        <div class="col">
            <div class="page-pretitle">
                <?= $Index['name']; ?>
            </div>
            <h2 class="page-title">
                Balanço Patrimonial
            </h2>
        </div>
        <div class="col-auto ms-auto d-print-none">
            <div class="btn-list">

            </div>
        </div>
    </div>
</div>
<div class="row row-cards">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5 class="modal-title">Balanço Patrimonial</h5>
            </div>
            <div class="card-body">
                <a href="print.php?&number=18&action=18&id_db_settings=<?= $id_db_settings; ?>" class="btn btn-default" target="_blank">Imprimir</a><br/><br/>
                <div class="row">
                    <div class="table table-responsive">
                        <table class="table table-responsive">
                            <thead>
                                <tr>
                                    <th>Nº</th>
                                    <th>NOME</th>
                                    <th>TIPO DE PATRIMONIO</th>
                                    <th>REFEFENCIA</th>
                                    <th>MARCA</th>
                                    <th>MODELO</th>
                                    <th>DATA COMPRA</th>
                                    <th>DATA-HORA DE REGISTRO</th>
                                    <th>ESTADO</th>
                                    <th>STATUS</th>
                                    <th>PREÇO</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $number = 0;
                                    $activo = 0;
                                    $passivo = 0;
                                    $total = 0;

                                    $Read = new Read();
                                    $Read->ExeRead("p_table", "WHERE id_db_settings=:i ORDER BY nome ASC", "i={$id_db_settings}");

                                    if($Read->getResult()):
                                        foreach ($Read->getResult() as $key):
                                            $okay = new Read();
                                            $okay->ExeRead("p_type", "WHERE id=:i AND id_db_settings=:ip", "i={$key['id_type']}&ip={$id_db_settings}");
                                            if($okay->getResult()): $key['type'] = $okay->getResult()[0]['nome']; else: $key['type'] = null; endif;

                                            $data_inicial = $key['time_last'];
                                            $data_final = $key['data_last'];
                                            $diferenca = strtotime($data_final) - strtotime($data_inicial);
                                            $dias = floor($diferenca / (60 * 60 * 24));

                                            if($dias >= 1):
                                                $estado = "Operacional";
                                            else:
                                                $estado = "Depreciado";
                                            endif;

                                            if($key['status'] == null || !isset($key['status'])): $key['status'] = 0; endif;
                                            $Status = ["Activo", "Activo", "Roubado", "Danificado", "Estragado", "Dado por Emprestimo", "Depreciado"];

                                            if($dias <= 0 || $key['status'] >= 2):
                                                $passivo += $key['preco'];
                                            else:
                                                $activo += $key['preco'];
                                            endif;

                                            $total += $key['preco'];
                                            $number += 1;
                                            ?>
                                            <tr>
                                                <td><?= $number; ?></td>
                                                <td><?= $key['nome']; ?></td>
                                                <td><?= $key['type']; ?></td>
                                                <td><?= $key['referencia']; ?></td>
                                                <td><?= $key['marca']; ?></td>
                                                <td><?= $key['modelo']; ?></td>
                                                <td><?= $key['data_last']; ?></td>
                                                <td><?= $key['data']." ".$key['hora']; ?></td>
                                                <td><?= $estado; ?></td>
                                                <td><?= $Status[$key['status']]; ?></td>
                                                <td><?= str_replace(",", ".", number_format($key['preco'], 2)); ?></td>
                                            </tr>
                                            <?php
                                        endforeach;
                                    endif;
                                ?>
                            </tbody>
                            <tfoot style="text-transform: uppercase!important;">
                                <tr>
                                    <th colspan="9" style="text-align: right!important;">PASSIVO</th>
                                    <th>ACTIVO</th>
                                    <th>TOTAL</th>
                                </tr>
                                <tr>
                                    <td colspan="9" style="text-align: right!important;"><?= str_replace(",", ".", number_format($passivo, 2)); ?></td>
                                    <td><?= str_replace(",", ".", number_format($activo, 2)); ?></td>
                                    <td><?= str_replace(",", ".", number_format($total, 2)); ?> AOA</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
if(!class_exists('login')):
    header("index.php");
    die();
endif;

if($level >= 4): $n =  '&id_db_settings='.$id_db_settings; else: $n = null; endif;

if($userlogin['level'] < 1):
    header("location: panel.php?exe=default/home".$n);
endif;
?>
<div class="page-header d-print-none">
    <div class="row align-items-center">
        <div class="col">
            <div class="page-pretitle">
                <?= $Index['name']; ?>
            </div>
            <h2 class="page-title">
                Veiculos
            </h2>
        </div>
        <div class="col-auto ms-auto d-print-none">
            <div class="btn-list">
                <a href="#" class="btn btn-primary d-none d-sm-inline-block" data-bs-toggle="modal" data-bs-target="#ModalDefault" onclick="CreateVeiculos(<?= $id_db_settings; ?>)">
                    Adicionar novo
                </a>
            </div>
        </div>
    </div>
</div>

<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Veiculos</h3>
        </div>
        <div id="aPaulo"></div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Cliente</th>
                        <th>Veiculo</th>
                        <th>Placa</th>
                        <th>KM Atual</th>
                        <th>Data Entrada</th>
                        <th>Data Saída</th>
                        <th>-</th>
                    </tr>
                </thead>
                <tbody id="ReadVeiculo">
                <?php
                $posti = 0;
                $getPage = filter_input(INPUT_GET, 'page',FILTER_VALIDATE_INT);
                $Pager = new Pager("panel.php?exe=cadastro/fabricante/index{$n}&page=");
                $Pager->ExePager($getPage, 10);

                $gQtd = null;
                $tTotal = null;
                $qTotal = null;

                $Read = new Read();
                $Read->ExeRead("i_veiculos", "WHERE id_db_settings=:i ORDER BY veiculo ASC LIMIT :limit OFFSET :offset", "i={$id_db_settings}&limit={$Pager->getLimit()}&offset={$Pager->getOffset()}");

                if($Read->getResult()):
                    foreach ($Read->getResult() as $item):
                        ?>
                        <tr>
                            <td><?= $item['id']; ?></td>
                            <td><?php $Read->ExeRead("cv_customer", "WHERE id=:i", "i={$item['id_cliente']}"); if($Read->getResult()): echo $Read->getResult()[0]['nome']; endif; ?></td>
                            <td><?= $item['veiculo']; ?></td>
                            <td><?= $item['placa']; ?></td>
                            <td><?= $item['km_atual']; ?></td>
                            <td><?= $item['data_entrada']; ?></td>
                            <td><?= $item['data_saida']; ?></td>
                            <td>
                                <a href="#" class="btn btn-sm btn-warning"  data-bs-toggle="modal" data-bs-target="#ModalDefault" onclick="VeiculoUpdate(<?= $item['id']; ?>);">Editar</a>&nbsp;
                                <a href="#" onclick="DeleteVeiculo(<?= $item['id']; ?>)" class="btn btn-sm btn-danger">Apagar</a>&nbsp;
                            </td>
                        </tr>
                    <?php
                    endforeach;
                endif;
                ?>
                </tbody>
            </table>
        </div>
        <div class="card-footer d-flex align-items-center">
            <?php
            $Pager->ExePaginator("i_veiculos", "WHERE id_db_settings=:id ORDER BY veiculo ASC", "id={$id_db_settings}");
            echo $Pager->getPaginator();
            ?>
        </div>
    </div>
</div>
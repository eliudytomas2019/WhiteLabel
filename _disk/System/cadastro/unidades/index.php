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
                Unidades
            </h2>
        </div>
        <div class="col-auto ms-auto d-print-none">
            <div class="btn-list">
                <a href="#" class="btn btn-primary d-none d-sm-inline-block" data-bs-toggle="modal" data-bs-target="#ModalDefault" onclick="CreateUnidades(<?= $id_db_settings; ?>)">
                    Adicionar nova
                </a>
            </div>
        </div>
    </div>
</div>

<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Unidades</h3>
        </div>
        <div id="aPaulo"></div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Categoria</th>
                    <th>Descrição</th>
                    <th>-</th>
                </tr>
                </thead>
                <tbody id="ReadUnidade">
                <?php
                $posti = 0;
                $getPage = filter_input(INPUT_GET, 'page',FILTER_VALIDATE_INT);
                $Pager = new Pager("panel.php?exe=cadastro/unidades/index{$n}&page=");
                $Pager->ExePager($getPage, 5);

                $Read = new Read();
                $Read->ExeRead("i_unidade", "WHERE id_db_settings=:i ORDER BY unidade ASC LIMIT :limit OFFSET :offset", "i={$id_db_settings}&limit={$Pager->getLimit()}&offset={$Pager->getOffset()}");

                if($Read->getResult()):
                    foreach($Read->getResult() as $item):
                        ?>
                        <tr>
                            <td><?= $item['id']; ?></td>
                            <td><?= $item['unidade']; ?></td>
                            <td><?= $item['simbolo']; ?></td>
                            <td>
                                <a class="btn btn-warning" href="#" data-bs-toggle="modal" data-bs-target="#ModalDefault" onclick="UnidadeUpdate(<?= $item['id']; ?>);">Editar</a>&nbsp;
                                <a class="btn btn-danger" href="#" onclick="DeleteUnidade(<?= $item['id']; ?>)">Eliminar</a>
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
            $Pager->ExePaginator("i_unidade", "WHERE id_db_settings=:id ORDER BY unidade ASC", "id={$id_db_settings}");
            echo $Pager->getPaginator();
            ?>
        </div>
    </div>
</div>
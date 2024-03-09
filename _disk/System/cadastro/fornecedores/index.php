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
                Fornecedores
            </h2>
        </div>
        <div class="col-auto ms-auto d-print-none">
            <div class="btn-list">
                <a href="#" class="btn btn-primary d-none d-sm-inline-block" data-bs-toggle="modal" data-bs-target="#ModalDefault" onclick="CreateFornecedores(<?= $id_db_settings; ?>)">
                    Adicionar novo
                </a>
            </div>
        </div>
    </div>
</div>

<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Fornecedores</h3>
        </div>
        <div id="aPaulo"></div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>NIF</th>
                    <th>E-mail</th>
                    <th>Telefone</th>
                    <th>Endereço</th>
                    <th>-</th>
                </tr>
                </thead>
                <tbody id="ReadFornecedores">
                <?php
                $posti = 0;
                $getPage = filter_input(INPUT_GET, 'page',FILTER_VALIDATE_INT);
                $Pager = new Pager("panel.php?exe=cadastro/fornecedores/index{$n}&page=");
                $Pager->ExePager($getPage, 5);

                $Read = new Read();
                $Read->ExeRead("i_fornecedores", "WHERE id_db_settings=:i ORDER BY name ASC LIMIT :limit OFFSET :offset", "i={$id_db_settings}&limit={$Pager->getLimit()}&offset={$Pager->getOffset()}");

                if($Read->getResult()):
                    foreach($Read->getResult() as $item):

                        if(empty($item['nif']) || $item['nif'] == null || $item['nif'] == "999999999"): $item['nif'] = "Consumidor final"; endif;
                        ?>
                        <tr>
                            <td><?= $item['id']; ?></td>
                            <td><?= $item['name']; ?></td>
                            <td><?= $item['nif']; ?></td>
                            <td><?= $item['email']; ?></td>
                            <td><?= $item['telefone']; ?></td>
                            <td><?= $item['endereco']; ?></td>
                            <td>
                                <a class="btn btn-sm btn-warning" href="#" data-bs-toggle="modal" data-bs-target="#ModalDefault" onclick="FornecedoresUpdate(<?= $item['id']; ?>);">Editar</a>&nbsp;
                                <a class="btn btn-sm btn-danger" href="#" onclick="DeleteFornecedores(<?= $item['id']; ?>)">Eliminar</a>
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
            $Pager->ExePaginator("i_fornecedores", "WHERE id_db_settings=:id ORDER BY name ASC", "id={$id_db_settings}");
            echo $Pager->getPaginator();
            ?>
        </div>
    </div>
</div>
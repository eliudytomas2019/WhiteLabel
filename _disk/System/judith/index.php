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
                Tipo de patrimonio
            </h2>
        </div>
        <div class="col-auto ms-auto d-print-none">
            <div class="btn-list">
                <a href="#" class="btn btn-primary d-none d-sm-inline-block" data-bs-toggle="modal" data-bs-target="#ModalDefault" onclick="TypePatrimonio(<?= $id_db_settings; ?>)">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg>
                    Registrar novo Tipo de Patrimonio
                </a>
            </div>
        </div>
    </div>
</div>

<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Tipo de Patrimonio</h3>
        </div><br/>
        <div class="col-auto ms-auto d-print-none">
            <div class="d-flex">
                <span>Pesquisar Tipo de Patrimonio</span>
                <input type="search" class="form-control d-inline-block w-9 me-3" id="AuriaRafaela" placeholder="Pesquisar Tipo de Patrimonio"/>
            </div>
        </div><br/>
        <div id="aPaulo"></div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th></th>
                </tr>
                </thead>
                <tbody id="ReadTipoPatrimonio">
                <?php
                $posti = 0;
                $getPage = filter_input(INPUT_GET, 'page',FILTER_VALIDATE_INT);
                $Pager = new Pager("panel.php?exe=judith/index{$n}&page=");
                $Pager->ExePager($getPage, 7);

                $read = new Read();
                $read->ExeRead("p_type", "WHERE id_db_settings=:id ORDER BY id DESC LIMIT :limit OFFSET :offset", "id={$id_db_settings}&limit={$Pager->getLimit()}&offset={$Pager->getOffset()}");
                if($read->getResult()):
                    foreach ($read->getResult() as $item):
                        ?>
                        <tr>
                            <td><?= $item['nome']; ?></td>
                            <td><?= $item['descricao']; ?></td>
                            <td>
                                <a href="#" class="btn btn-sm btn-warning"  data-bs-toggle="modal" data-bs-target="#ModalDefault" onclick="TipoPatrimonioUpdate(<?= $item['id']; ?>);">Editar</a>&nbsp;
                                <a href="#" onclick="DeleteTipoPatrimonio(<?php if(isset($item['id'])) echo $item['id']; ?>)" class="btn btn-sm btn-danger">Apagar</a>&nbsp;
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
            $Pager->ExePaginator("p_type", "WHERE id_db_settings=:id ORDER BY id DESC", "id={$id_db_settings}");
            echo $Pager->getPaginator();
            ?>
        </div>
    </div>
</div>
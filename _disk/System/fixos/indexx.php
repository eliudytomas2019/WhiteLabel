<?php
if(!class_exists('login')):
    header("index.php");
    die();
endif;

if($level >= 4): $n =  '&id_db_settings='.$id_db_settings; else: $n = null; endif;
?>
<div class="page-header d-print-none">
    <div class="row align-items-center">
        <div class="col">
            <h2 class="page-title">
                Administração
            </h2>
        </div>
    </div>
</div>
<div class="row gx-lg-4">
    <?php require_once("_disk/IncludesApp/MenuDefinitions.inc.php"); ?>
    <div class="col-lg-9">
        <div class="row align-items-center">
            <div class="col">
                <div class="page-pretitle">
                    <?= $Index['name']; ?>
                </div>
                <h2 class="page-title">
                    Inventário dos Materiais Fixos
                </h2>
            </div>
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    <a href="panel.php?exe=fixos/createx<?= $n; ?>" class="btn btn-primary">
                        Criar Inventário</a>
                    <a href="print_dental.php?action=1965&id_db_settings=<?= $id_db_settings; ?>" target="_blank" class="btn btn-default">Imprimir</a>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h5 class="modal-title">Inventário dos Materiais Fixos</h5>&nbsp;
                <div class="form-group d-none d-sm-inline-block form-inline mr-auto ml-md-4 my-3 my-md-0 mw-100 navbar-search">
                    <div class="input-group">
                        <input type="text" id="searchProductx" class="form-control bg-light border-0 small" placeholder="Pesquisar"  aria-label="Search" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <input class="btn btn-primary" name="searchProductx" type="submit" value="Pesquisar">
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div id="getResult"></div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Descrição</th>
                            <th>Qtd</th>
                            <th>Unidades</th>
                            <th>Tipo</th>
                            <th>-</th>
                        </tr>
                        </thead>
                        <tbody id="DaSo">
                            <?php require_once("KwanzarApp/SystemFiles/search-product-and-services-clinic.inc.php"); ?>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer d-flex align-items-center">
                    <?php
                    $Pager->ExePaginator("cv_clinic_product", "WHERE id_db_settings=:id ORDER BY id DESC", "id={$id_db_settings}");
                    echo $Pager->getPaginator();
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
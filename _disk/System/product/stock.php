<?php
if(!class_exists('login')):
    header("index.php");
    die();
endif;

$Read = new Read();
$Read->ExeRead("db_config", "WHERE id_db_settings=:i ", "i={$id_db_settings}");
if(!$Read->getResult() || !$Read->getRowCount()):
    header("Location: panel.php?exe=settings/System_Settings{$n}");
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
                Control de Stock
            </h2>
        </div>
        <div class="col-auto ms-auto d-print-none">
            <div class="btn-list">
                <a href="panel.php?exe=product/create<?= $n; ?>" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg>
                    Adicionar novo Produto
                </a>
            </div>
        </div>
    </div>
</div>

<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Control de Stock</h3>&nbsp;&nbsp;&nbsp;
            <div class="form-group d-none d-sm-inline-block form-inline mr-auto ml-md-4 my-3 my-md-0 mw-100 navbar-search">
                <div class="input-group">
                    <input type="text" id="QuandoOKumbuCair" class="form-control bg-light border-0 small" placeholder="Buscar Produto"  aria-label="Search" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                        <input class="btn btn-primary" name="searchProduct" type="submit" value="Pesquisar">
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div id="aPaulo"></div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>PRODUTO</th>
                        <th>CÓDIGO DE BARRAS</th>
                        <th>DATA DE EXPIRAÇÃO</th>
                        <th>QUANTIDADE</th>
                        <th>CUSTO DE COMPRA</th>
                        <th>PREÇO VENDA</th>
                        <th>LUCRO</th>
                        <th>-</th>
                    </tr>
                    </thead>
                    <tbody id="getResult">
                    <?php
                        require_once("KwanzarApp/SystemFiles/search-product-user.inc.php");
                    ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th colspan="3" style="text-align: right!important;">TOTAL ==></th>
                        <th><?= number_format($qtd, 2); ?></th>
                        <th><?= number_format($custo_total, 2); ?></th>
                        <th></th>
                        <th colspan="3"><?= str_replace(",", ".", number_format($lucro_total, 2)); ?> AOA</th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="card-footer d-flex align-items-center">
            <?php
                $Pager->ExePaginator("cv_product", "WHERE id_db_settings=:id AND type=:t ORDER BY id DESC", "id={$id_db_settings}&t={$type}");
                echo $Pager->getPaginator();
            ?>
        </div>
    </div>
</div>
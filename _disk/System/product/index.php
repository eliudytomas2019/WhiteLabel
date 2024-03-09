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
                Itens
            </h2>
        </div>
        <div class="col-auto ms-auto d-print-none">
            <div class="btn-list">
                <a href="panel.php?exe=product/create<?= $n; ?>" class="btn btn-primary btn-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg>
                    Adicionar Item
                </a>
                <?php
                    if($level >= 3):
                        ?>
                        <a href="panel.php?exe=product/import<?= $n; ?>" class="btn btn-default btn-sm">
                            <!-- Download SVG icon from http://tabler-icons.io/i/award -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="9" r="6" /><polyline points="9 14.2 9 21 12 19 15 21 15 14.2" transform="rotate(-30 12 9)" /><polyline points="9 14.2 9 21 12 19 15 21 15 14.2" transform="rotate(30 12 9)" /></svg>
                            Importação de Dados
                        </a>
                        <a href="export/index.php?postId=<?= $id_db_settings; ?>" id="Rualidade" target="_blank" class="btn btn-default btn-sm">
                            <!-- Download SVG icon from http://tabler-icons.io/i/cloud-download -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M19 18a3.5 3.5 0 0 0 0 -7h-1a5 4.5 0 0 0 -11 -2a4.6 4.4 0 0 0 -2.1 8.4" /><line x1="12" y1="13" x2="12" y2="22" /><polyline points="9 19 12 22 15 19" /></svg>
                            Exportação de Dados
                        </a>

                        <a href="export/stock.php?postId=<?= $id_db_settings; ?>" id="Fama" target="_blank" class="btn btn-primary btn-sm">
                            <!-- Download SVG icon from http://tabler-icons.io/i/cloud-download -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M19 18a3.5 3.5 0 0 0 0 -7h-1a5 4.5 0 0 0 -11 -2a4.6 4.4 0 0 0 -2.1 8.4" /><line x1="12" y1="13" x2="12" y2="22" /><polyline points="9 19 12 22 15 19" /></svg>
                            Zerar o Stock
                        </a>
                        <?php
                    endif; ?>
                <a href="print.php?action=2023<?= $n; ?>" target="_blank" class="btn btn-primary btn-sm">
                    <!-- Download SVG icon from http://tabler-icons.io/i/calculator -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><rect x="4" y="3" width="16" height="18" rx="2" /><rect x="8" y="7" width="8" height="3" rx="1" /><line x1="8" y1="14" x2="8" y2="14.01" /><line x1="12" y1="14" x2="12" y2="14.01" /><line x1="16" y1="14" x2="16" y2="14.01" /><line x1="8" y1="17" x2="8" y2="17.01" /><line x1="12" y1="17" x2="12" y2="17.01" /><line x1="16" y1="17" x2="16" y2="17.01" /></svg>
                    Lista de preços
                </a>
            </div>
        </div>
    </div>
</div>

<div class="page-header d-print-none">
    <div class="row align-items-center">
        <div class="col-auto ms-auto d-print-none">
            <a href="panel.php?exe=product/index_front<?= $n; ?>" class="btn btn-warning btn-sm">
                <!-- Download SVG icon from http://tabler-icons.io/i/chart-dots -->
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 3v18h18" /><circle cx="9" cy="9" r="2" /><circle cx="19" cy="7" r="2" /><circle cx="14" cy="15" r="2" /><line x1="10.16" y1="10.62" x2="12.5" y2="13.5" /><path d="M15.088 13.328l2.837 -4.586" /></svg>
                Disponível no Front
                <?php
                    $is = 2;

                    $Read = new Read();
                    $Read->ExeRead("cv_product", "WHERE id_db_settings=:id AND ILoja=:is", "id={$id_db_settings}&is={$is}");

                    if($Read->getResult()): echo "({$Read->getRowCount()})"; endif;
                ?>
            </a>&nbsp;
            <a href="panel.php?exe=product/index_stock<?= $n; ?>" class="btn btn-warning btn-sm">
                <!-- Download SVG icon from http://tabler-icons.io/i/chart-bubble -->
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="6" cy="16" r="3" /><circle cx="16" cy="19" r="2" /><circle cx="14.5" cy="7.5" r="4.5" /></svg>
                Disponível apenas em Stock
                <?php
                    $ip = 1;

                    $Read = new Read();
                    $Read->ExeRead("cv_product", "WHERE id_db_settings=:id AND ILoja=:is", "id={$id_db_settings}&is={$ip}");

                    if($Read->getResult()): echo "({$Read->getRowCount()})"; endif;
                ?>
            </a>&nbsp;
            <a href="panel.php?exe=reports/stock<?= $n; ?>" class="btn btn-default btn-sm">
                <!-- Download SVG icon from http://tabler-icons.io/i/chart-infographic -->
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="7" cy="7" r="4" /><path d="M7 3v4h4" /><line x1="9" y1="17" x2="9" y2="21" /><line x1="17" y1="14" x2="17" y2="21" /><line x1="13" y1="13" x2="13" y2="21" /><line x1="21" y1="12" x2="21" y2="21" /></svg>
                Relatórios
            </a>&nbsp;
        </div>
    </div>
</div><br/>

<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Itens</h3>&nbsp;&nbsp;&nbsp;
            <div class="form-group d-none d-sm-inline-block form-inline mr-auto ml-md-4 my-3 my-md-0 mw-100 navbar-search">
                <div class="input-group">
                    <input type="text" id="searchProductTxt" class="form-control bg-light border-0 small" placeholder="Buscar Produto/Serviço"  aria-label="Search" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                        <input class="btn btn-primary" name="searchProduct" type="submit" value="Pesquisar">
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div id="aPaulo"></div>
            <div class="table">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Imagem</th>
                            <th>Descrição</th>
                            <th>Codigo de barras</th>
                            <td>Quantidade</td>
                            <th>Preço</th>
                            <th>Localização</th>
                            <th>Remarks</th>
                            <th>-</th>
                        </tr>
                    </thead>
                    <tbody id="getResult">
                        <?php require_once("KwanzarApp/SystemFiles/search-product-and-services-user.inc.php"); ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer d-flex align-items-center">
            <?php
                $Pager->ExePaginator("cv_product", "WHERE id_db_settings=:id ORDER BY id DESC", "id={$id_db_settings}");
                echo $Pager->getPaginator();
            ?>
        </div>
    </div>
</div>
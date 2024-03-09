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
                Clientes
            </h2>
        </div>
        <div class="col-auto ms-auto d-print-none">
            <div class="btn-list">
                <a href="#" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modal">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg>
                    Novo Cliente
                </a>
                <a href="_disk/_help/export.inc.e.php?postId=<?= $id_db_settings; ?>" target="_blank" class="btn btn-default btn-sm">
                    <!-- Download SVG icon from http://tabler-icons.io/i/cloud-download -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M19 18a3.5 3.5 0 0 0 0 -7h-1a5 4.5 0 0 0 -11 -2a4.6 4.4 0 0 0 -2.1 8.4" /><line x1="12" y1="13" x2="12" y2="22" /><polyline points="9 19 12 22 15 19" /></svg>
                    Exportação de Dados
                </a>
            </div>
        </div>
    </div>
</div>

<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Clientes</h3>&nbsp;&nbsp;&nbsp;
            <div class="form-group d-none d-sm-inline-block form-inline mr-auto ml-md-4 my-3 my-md-0 mw-100 navbar-search">
                <div class="input-group">
                    <input type="text" id="searchCustommersTxt" class="form-control bg-light border-0 small" placeholder="Buscar Clientes"  aria-label="Search" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                        <input class="btn btn-primary" name="searchCustommers" type="submit" value="Pesquisar">
                    </div>
                </div>
            </div>
        </div>
        <div id="aPaulo"></div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th style="max-width: 200px!important;">ID</th>
                        <th style="max-width: 200px!important;">Cover</th>
                        <th style="max-width: 200px!important;">Nome</th>
                        <th style="max-width: 200px!important;">NIF</th>
                        <th style="max-width: 200px!important;">Telefone</th>
                        <th style="max-width: 200px!important;">E-mail</th>
                        <th style="max-width: 200px!important;">Endereço</th>
                        <th>-</th>
                    </tr>
                </thead>
                <tbody id="Vuvu">
                <?php
                    require_once("KwanzarApp/SystemFiles/DripDosPais.inc.php");
                ?>
                </tbody>
            </table>
        </div>
        <div class="card-footer d-flex align-items-center">
            <?php
                $Pager->ExePaginator("cv_customer", "WHERE id_db_settings=:id ORDER BY id DESC", "id={$id_db_settings}");
                echo $Pager->getPaginator();
            ?>
        </div>
    </div>
</div>
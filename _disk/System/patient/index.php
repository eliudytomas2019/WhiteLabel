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
                Pacientes
            </h2>
        </div>
        <?php if($level == 1 || $level >= 4):  ?>
        <div class="col-auto ms-auto">
            <div class="btn-list">
                <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-pacientes">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg>
                    Adicionar Novo Paciente
                </a>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Pacientes</h3>&nbsp;&nbsp;&nbsp;
            <div class="form-group d-none d-sm-inline-block form-inline mr-auto ml-md-4 my-3 my-md-0 mw-100 navbar-search">
                <div class="input-group">
                    <input type="text" id="searchPacientes" class="form-control bg-light border-0 small" placeholder="Buscar Pacientes"  aria-label="Search" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                        <input class="btn btn-primary" name="searchPacientes" type="submit" value="Pesquisar">
                    </div>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <div id="eTomas"></div>
            <table class="table">
                <thead>
                <tr>
                    <th style="max-width: 200px!important;">ID</th>
                    <th style="max-width: 200px!important;">Cover</th>
                    <th style="max-width: 200px!important;">Nome</th>
                    <th style="max-width: 200px!important;">Data de Nas.</th>
                    <th style="max-width: 200px!important;">Idade</th>
                    <th style="max-width: 200px!important;">Sexo</th>
                    <th style="max-width: 200px!important;">Nº Indentificação</th>
                    <th style="max-width: 200px!important;">Telefone</th>
                    <th style="max-width: 200px!important;">E-mail</th>
                    <th style="max-width: 200px!important;">Endereço</th>
                    <th>-</th>
                </tr>
                </thead>
                <tbody id="TheBox">
                <?php
                    require_once("_disk/SystemClinic/Lutchiana.inc.php");
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
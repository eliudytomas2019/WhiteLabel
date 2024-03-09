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
                    Relatório dos Materiais Fixos
                </h2>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h5 class="modal-title">Relatório dos Materiais Fixos</h5>&nbsp;
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label class="form-label">Data Inicio</label>
                            <?php $null = array(); $read->ExeRead("db_kwanzar", "WHERE id=:id", "id={$id_db_kwanzar}"); if($read->getResult()):$null = $read->getResult()[0];endif; ?>
                            <input type="date" id="dateI" class="form-control" placeholder="Data Fnicial"/>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label class="form-label">Data Final</label>
                            <input type="date" id="dateF" class="form-control" placeholder="Data Final"/>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label class="form-label">Materiais</label>
                            <select class="form-control" id="product_x">
                                <option value="all">Todos os materiais </option>
                                <?php
                                $read->ExeRead("cv_clinic_product", "WHERE id_db_settings=:i ORDER BY id ASC", "i={$id_db_settings}");
                                if($read->getResult()):
                                    foreach($read->getResult() as $key):
                                        ?>
                                        <option value="<?= $key['id']; ?>"><?= $key['name']; ?></option>
                                        <?php
                                    endforeach;
                                endif;
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label class="form-label">Tipo de movimento</label>
                            <select class="form-control" id="moviment_x">
                                <option selected value="entrada">Entrada</option>
                                <option value="saida">Saída</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label class="form-label">Usuários</label>
                            <select class="form-control" id="users_id_x">
                                <option value="all">Todos usuários </option>
                                <?php
                                $read->ExeRead("db_users", "WHERE id_db_settings=:i ORDER BY id ASC", "i={$id_db_settings}");
                                if($read->getResult()):
                                    foreach($read->getResult() as $key):
                                        if($key['level'] == 2 || $key['level'] >= 4):
                                            ?>
                                            <option value="<?= $key['id']; ?>"><?= $key['name']; ?></option>
                                            <?php
                                        endif;
                                    endforeach;
                                endif;
                                ?>
                            </select>
                        </div>
                    </div>
                </div>

                <a href="javascript:void()" onclick="KwanzarDentalDocs();" class="btn btn-primary">
                    Pesquisar
                </a>
                <div id="getResult"></div>
            </div>
        </div>
    </div>
</div>
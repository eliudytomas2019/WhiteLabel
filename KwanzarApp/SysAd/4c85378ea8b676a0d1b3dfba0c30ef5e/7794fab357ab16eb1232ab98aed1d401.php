<?php
/**
 * Created by PhpStorm.
 * User: Kwanzar Soft
 * Date: 06/06/2020
 * Time: 16:30
 */

if(!class_exists('login')):
    header("index.php");
    die();
endif;

$id_db_k = (int) strip_tags(trim($_GET['id_db_']));

$System = new Read();
?>

<div class="panel-header bg-primary-gradient">
    <div class="page-inner py-5">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
            <div>
                <h2 class="text-white pb-2 fw-bold">Ativação de licença</h2>
                <h5 class="text-white op-7 mb-2">Activar a licença das empresas</h5>
            </div>
            <div class="ml-md-auto py-2 py-md-0">
                <a href="<?= HOME; ?>Br.inc.php?exe=4c85378ea8b676a0d1b3dfba0c30ef5e/03b8e389068f06106a1fc841a8d4b545" class="btn btn-secondary btn-round">Dashboard</a>
            </div>
        </div>
    </div>
</div>
<div class="page-inner mt--5">
    <div class="row mt--2">
        <div class="col-md-6">
            <div class="card full-height">
                <div class="card-body">
                    <div class="row py-1">
                        <h2 class="card-title">Tempo de actividade</h2>
                        <input type="date" name="times" id="times" class="form-control" placeholder="Data de fim de actividade"/>
                    </div>
                    <div class="row py-1">
                        <h2 class="card-title">Postos de trabalho</h2>
                        <input type="number" min="1" value="1" max="50" name="postos" id="postos" class="form-control" placeholder="Nº Postos de trabalho"/>
                    </div>
                    <div class="row py-1">
                        <h2 class="card-title">Usuários</h2>
                        <input type="number" min="5" value="5" max="1000" name="users" id="users" class="form-control" placeholder="Nº de usuários"/>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card full-height">
                <div class="card-body">
                    <div id="getResult"></div>
                    <div class="row py-1">
                        <h2 class="card-title">Plano</h2>
                        <select name="ps3" id="ps3" class="form-control">
                            <option value="1">Trial</option>
                            <option value="2" selected>Basic</option>
                            <option value="3">Medium</option>
                            <option value="4">Premium</option>
                        </select>
                    </div>
                    <div class="row py-1">
                        <a href="javascript:void" onclick="Licenca(<?= $id_db_k; ?>)" class="btn btn-primary">Salvar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

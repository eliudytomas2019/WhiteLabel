<?php
/**
 * Created by PhpStorm.
 * User: Kwanzar Soft
 * Date: 28/08/2020
 * Time: 22:53
 */

if(!class_exists('login')):
    header("index.php");
    die();
endif;

if($level >= 4): $n =  '&id_db_settings='.$id_db_settings; else: $n = null; endif;

if($userlogin['level'] < 2):
    header("location: panel.php?exe=default/index".$n);
endif;

include_once("_rh_includes/my-modal-rh-grau-settings.inc.php");
?>

<div class="row page-titles mx-0">
    <div class="col p-md-0">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= HOME; ?>panel.php?exe=default/home<?php if($level >= 4): echo '&id_db_settings='.$id_db_settings; endif; ?>">Painel de controle</a></li>
            <li class="breadcrumb-item active"><a href="<?= HOME; ?>panel.php?exe=rh/index<?php if($level >= 4): echo '&id_db_settings='.$id_db_settings; endif; ?>">Grau de Instrução</a></li>
        </ol>
    </div>
</div>

<div class="container-fluid">
    <div class="styles">
        <a href="javascript:void()" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#Grau">
            CRIAR NOVA
        </a>&nbsp;
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive" id="getResult">
                        <?php require_once("_rh_includes/body-grau-settings.inc.php"); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
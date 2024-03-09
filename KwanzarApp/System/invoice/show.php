<?php
/**
 * Created by PhpStorm.
 * User: Kwanzar Soft
 * Date: 20/06/2020
 * Time: 17:28
 */

if(!class_exists('login')):
    header("index.php");
    die();
endif;

if($level >= 4): $n =  '&id_db_settings='.$id_db_settings; else: $n = null; endif;
?>
<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Documentos comercial</h4>
        <ul class="breadcrumbs">
            <li class="nav-home">
                <a href="<?= HOME; ?>panel.php?exe=default/home<?= $n; ?>">
                    <i class="flaticon-home"></i>
                </a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="<?= HOME; ?>Pos.php?<?= $n; ?>">Terminal de Vendas</a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="<?= HOME; ?>panel.php?exe=invoice/show<?= $n; ?>">Documentos comercial</a>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Documentos comercial</h4>
                </div>
                <div class="card-body">
                    <div class="search-content-modal">
                        <input type="search" class="form-control" id="SearchDocuments" placeholder="Buscar por número"/>
                        <input type="hidden" id="level" value="<?= $level; ?>"/>
                    </div>
                    <div class="table-responsive" id="King">
                        <?php require_once("./_requires/table-documents-settings.inc.php"); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
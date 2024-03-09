<?php
/**
 * Created by PhpStorm.
 * User: Kwanzar Soft
 * Date: 11/06/2020
 * Time: 13:23
 */

if(!class_exists('login')):
    header("index.php");
    die();
endif;

if($level >= 4): $n =  '&id_db_settings='.$id_db_settings; else: $n = null; endif;
?>

<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Exportação de dados</h4>
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
                <a href="<?= HOME; ?>Pos.php?<?= $n; ?>">Facturação</a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="<?= HOME; ?>panel.php?exe=invoice/create<?= $n; ?>">Exportação de dados</a>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Exportação de dados</div>
                </div>
                <form method="post" name="ExportDocuments" target="_blank" action="exporters.php" enctype="multipart/form-data">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 col-lg-4">
                                <div class="form-group">
                                    <label for="hDateI">Data Inicial</label>
                                    <input type="date" class="form-control" id="hDateI" name="hDateI" placeholder="Enter Email">
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <div class="form-group">
                                    <label for="hDateF">Data Final</label>
                                    <input type="date"  class="form-control" id="hDateF" name="hDateF" placeholder="Enter Email">
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <div class="form-group">
                                    <label for="TypeDocument">Tipo de documento</label>
                                    <select class="form-control" id="TypeDocument" name="TypeDocument">
                                        <option selected value="CO">Documentos comercial</option>
                                        <option value="RT">Documentos de retificação</option>
                                        <option value="TM">Todos os documentos juntos</option>
                                        <optgroup label="Modo especialista">
                                            <option value="FR">Factura-recibo</option>
                                            <option value="FT">Factura</option>
                                            <option value="NC">Nota de credito</option>
                                            <option value="ND">Nota de debito</option>
                                            <option value="RE">Recibo</option>
                                        </optgroup>
                                    </select>
                                    <input type="hidden" value="<?= $id_db_settings; ?>" name="id_db_settings" id="id_db_settings"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-action">
                        <input type="submit" class="btn btn-success btn-sm" name="ExportDocuments" value="Exportar"/>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
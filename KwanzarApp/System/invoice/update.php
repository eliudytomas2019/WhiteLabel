<?php
/**
 * Created by PhpStorm.
 * User: Kwanzar Soft
 * Date: 14/06/2020
 * Time: 00:30
 */

if(!class_exists('login')):
    header("index.php");
    die();
endif;

if($level >= 4): $n =  '&id_db_settings='.$id_db_settings; else: $n = null; endif;


if($userlogin['level'] < 2):
    header("location: panel.php?exe=default/index".$n);
endif;
?>
<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Relatório de Estoque</h4>
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
                <a href="<?= HOME; ?>panel.php?exe=purchase/index?<?= $n; ?>">Estoque</a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="<?= HOME; ?>panel.php?exe=invoice/update<?= $n; ?>">Relatório de Estoque</a>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Relatório de Estoque</div>
                </div>
                <form method="post"  enctype="multipart/form-data">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 col-lg-4">
                                <div class="form-group">
                                    <label for="DateI">Data Inicial</label>
                                    <input type="date" class="form-control" id="DateI" name="DateI" placeholder="Enter Email">
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <div class="form-group">
                                    <label for="DateF">Data Final</label>
                                    <input type="date"  class="form-control" id="DateF" name="DateF" placeholder="Enter Email">
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <div class="form-group">
                                    <label>-</label><br/>
                                    <a href="javascript:void " class="btn btn-success btn-sm" onclick="SearchDays()">Pesquisar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-action">

                    </div>
                </form>
                <div class="card-body" id="pResult">

                </div>
            </div>
        </div>
    </div>
</div>

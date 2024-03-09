<?php
/**
 * Created by PhpStorm.
 * User: Kwanzar Soft
 * Date: 20/09/2020
 * Time: 00:11
 */

if(!class_exists('login')):
    header("index.php");
    die();
endif;

if($level >= 4): $n =  '&id_db_settings='.$id_db_settings; else: $n = null; endif;

if($userlogin['level'] < 2):
    header("location: panel.php?exe=default/index".$n);
endif;

$postid = filter_input(INPUT_GET, 'postid', FILTER_VALIDATE_INT);
?>

<div class="page-inner">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Entrada de Estoque</div>
                </div>
                <div class="card-body">
                    <div id="BillieJean"></div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col">
                                <span>Quantidade</span>
                                <input type="hidden" class="id_product" id="id_product" name="id_product" value="<?= $postid; ?>"/>
                                <input type="number" min="1" value="1" max="100000000000000" name="quantidade" id="quantidade" class="form-control" placeholder=""/>
                            </div>
                            <div class="col">
                                <span>Unidades</span>
                                <input type="number" min="1" value="1" max="10000000" name="unidade" id="unidade" class="form-control" placeholder=""/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-action">
                    <button class="btn btn-success btn-sm" title="Salvar" onclick="OnPurchase()"><i class="far fa-save"></i></button>
                    <a href="<?= HOME; ?>panel.php?exe=product/index<?= $n; ?>" class="btn btn-danger btn-sm" title="Voltar"><i class="fas fa-chevron-left"></i> </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
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
<div class="page-header d-print-none">
    <div class="row align-items-center">

        <div class="col-auto ms-auto d-print-none">
            <div class="btn-list">
                <a href="panel.php?exe=product/index<?= $n; ?>" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 13l-4 -4l4 -4m-4 4h11a4 4 0 0 1 0 8h-1" /></svg>
                    Voltar
                </a>
            </div>
        </div>
        <div class="col">
            <div class="page-pretitle">
                <?= $Index['name']; ?>
            </div>
            <h2 class="page-title">
                Entrada de estoque
            </h2>
        </div>
    </div>
</div>

<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h5 class="modal-title">Entrada de estoque</h5>
        </div>
        <div class="card-body">
            <form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
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
                    </div><br/>
                    <div class="card-action">
                        <button class="btn btn-primary" title="Salvar" onclick="OnPurchase()">Salvar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
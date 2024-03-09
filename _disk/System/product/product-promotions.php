<?php
if(!class_exists('login')):
    header("index.php");
    die();
endif;

if($level >= 4): $n =  '&id_db_settings='.$id_db_settings; else: $n = null; endif;

if($userlogin['level'] < 1):
    header("location: panel.php?exe=default/index".$n);
endif;

$postId = filter_input(INPUT_GET, "postid", FILTER_VALIDATE_INT);
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
                Itens
            </h2>
        </div>
    </div>
</div>


<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h5 class="modal-title">Adicionar Item</h5>
        </div>
        <div class="card-body">
            <form class="form-horizontal" method="post" action="" name = "SendPostForm"  enctype="multipart/form-data">
                <div class="card-body">
                    <div id="getResult">
                        <?php
                        $userId = filter_input(INPUT_GET, 'postid', FILTER_VALIDATE_INT);

                        $delete = filter_input(INPUT_GET, 'Sodoma', FILTER_VALIDATE_INT);
                        if ($delete):
                            $Delete = new Product();
                            $Delete->ExeDeletePromotions($delete, $id_db_settings);

                            if($Delete->getResult()):
                                WSError($Delete->getError()[0], $Delete->getError()[1]);
                            else:
                                WSError($Delete->getError()[0], $Delete->getError()[1]);
                            endif;
                        endif;

                        $ClienteData = filter_input_array(INPUT_POST, FILTER_DEFAULT);
                        if ($ClienteData && $ClienteData['SendPostFormLLL']):
                            $Count = new Product();
                            $Count->ExePromotions($userId, $ClienteData, $id_db_settings);

                            if($Count->getResult()):
                                WSError($Count->getError()[0], $Count->getError()[1]);
                            else:
                                WSError($Count->getError()[0], $Count->getError()[1]);
                            endif;
                        else:
                            $ReadUser = new Read;
                            $ReadUser->ExeRead("cv_product", "WHERE id=:userid AND id_db_settings=:id", "userid={$userId}&id={$id_db_settings}");
                            if (!$ReadUser->getResult()):

                            else:
                                $ClienteData = $ReadUser->getResult()[0];
                                if($ClienteData['preco_promocao'] != '' && $ClienteData['preco_promocao'] != null && !empty($ClienteData['preco_promocao'])):
                                    ?>
                                    <a href="<?= HOME; ?>panel.php?exe=product/product-promotions<?= $n; ?>&postid=<?= $userId ?>&Sodoma=<?= $userId ?>" class="btn btn-outline-danger">Remover Promoção</a>
                                <?php
                                endif;
                            endif;
                        endif;

                        ?>
                    </div>
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="mb-3">
                                <label class="form-label">Data inicial da promoção</label>
                                <input type="date" name = "data_promocao" value="<?php if (!empty($ClienteData['data_promocao'])) echo $ClienteData['data_promocao']; ?>" class="form-control"  placeholder="Data Inicio da Promoção">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="mb-3">
                                <label class="form-label">Data final da promoção</label>
                                <input type="date" name = "data_fim_promocao" value="<?php if (!empty($ClienteData['data_fim_promocao'])) echo $ClienteData['data_fim_promocao']; ?>" class="form-control"  placeholder="Data Fim de Promoção">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="mb-3">
                                <label class="form-label">Preço promocional</label>
                                <input type="text" name = "preco_promocao" value="<?php if (!empty($ClienteData['preco_promocao'])) echo $ClienteData['preco_promocao'];  ?>" class="form-control"  placeholder="Preço Promocional">
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <div class="mb-3">
                                <label class="form-label">% Promoção</label>
                                <input type="number" min="0" max="100" name = "porcentagem_promocao" value="<?php if (!empty($ClienteData['porcentagem_promocao'])): echo $ClienteData['porcentagem_promocao']; else: echo "0"; endif; ?>" class="form-control"  placeholder="% Promoção">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" name="SendPostFormLLL" class="btn btn-primary ms-auto" value="Salvar"/>
                </div>
            </form>
        </div>
    </div>
</div>
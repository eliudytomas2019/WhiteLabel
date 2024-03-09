<?php
/**
 * Created by PhpStorm.
 * User: Kwanzar Soft
 * Date: 16/05/2020
 * Time: 00:45
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

<div class="row page-titles mx-0">
    <div class="col p-md-0">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= HOME; ?>panel.php?exe=default/home<?php if($level >= 4): echo '&id_db_settings='.$id_db_settings; endif; ?>">Painel de controle</a></li>
            <li class="breadcrumb-item active"><a href="<?= HOME; ?>panel.php?exe=product/index<?php if($level >= 4): echo '&id_db_settings='.$id_db_settings; endif; ?>">Produto/Serviços</a></li>
        </ol>
    </div>
</div>

<div class="container-fluid">
    <div class="styles">
        <a href="<?= HOME; ?>panel.php?exe=product/index<?= $n; ?>" class="btn btn-primary btn-sm">
            Voltar
        </a>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Promoção de Produtos</h4>
                    <div class="basic-form">
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
                        <form class="form-horizontal" method="post" action="" name = "SendPostFormLLL"  enctype="multipart/form-data">
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <span>Data inicial da promoção</span>
                                    <input type="date" name = "data_promocao" value="<?php if (!empty($ClienteData['data_promocao'])) echo $ClienteData['data_promocao']; ?>" class="form-control"  placeholder="Data Inicio da Promoção">
                                </div>
                                <div class="form-group col-md-3">
                                    <span>Data final da promoção</span>
                                    <input type="date" name = "data_fim_promocao" value="<?php if (!empty($ClienteData['data_fim_promocao'])) echo $ClienteData['data_fim_promocao']; ?>" class="form-control"  placeholder="Data Fim de Promoção">
                                </div>
                                <div class="form-group col-md-3">
                                    <span>Preço promocional</span>
                                    <input type="text" name = "preco_promocao" value="<?php if (!empty($ClienteData['preco_promocao'])) echo $ClienteData['preco_promocao']; ?>" class="form-control"  placeholder="Preço Promocional">
                                </div>

                                <div class="form-group col-md-3">
                                    <span>% Promoção</span>
                                    <input type="text" name = "porcentagem_promocao" value="<?php if (!empty($ClienteData['porcentagem_promocao'])) echo $ClienteData['porcentagem_promocao']; ?>" class="form-control"  placeholder="% Promoção">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-10">
                                    <input type="submit" name="SendPostFormLLL" class="btn btn-primary btn-sm" value="Guardar"/>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

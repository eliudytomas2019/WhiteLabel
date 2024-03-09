<?php
/**
 * Created by PhpStorm.
 * User: Kwanzar Soft
 * Date: 02/11/2020
 * Time: 23:50
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

    <div class="styles">
        <p>E-commerce é um método que a <strong>Kwanzar</strong> desenvolveu para ajudar a melhorar as tuas vendas de productos e serviços; é bastante simples e fácil de usar, basta activar a opção <strong>Incluír no E-Commerce</strong> no acto de cadastramento de produtos/serviços e nós faremos todo resto. Terás uma despesa de 15% no valor de cada producto/serviço vendido pelo <strong>E-commerce</strong>. Para mais informações contacte a <strong>Kwanzar</strong>... <br/><br/> Podes visitar a página do <strong>E-commerce</strong> clicando <a href="<?= HOME; ?>e/index.php?exe=default/index" target="_blank">aqui</a> e podes compartilhar o link com sua rede de contato! </p>
    </div><br/>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Cliente</th>
                                <th>Produto</th>
                                <th>Quantidade</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php
                                $status = 2;
                                $Read->FullRead("SELECT db_users.name FROM db_users, cv_product INNER JOIN br_cart ON cv_product.id_db_settings={$id_db_settings} AND cv_product.id=br_cart.id_cv_product AND br_cart.status={$status}");

                                if($Read->getResult()):
                                    $iInfo = $Read->getResult()[0];

                                    ?>
                                    <tr>
                                        <td colspan="3" style="font-size: 14pt!important;"><?= $iInfo['name']; ?></td>
                                    </tr>
                                    <?php

                                    $Read->FullRead("SELECT cv_product.product, br_cart.qtd, cv_product.id   FROM cv_product INNER JOIN br_cart ON cv_product.id_db_settings={$id_db_settings} AND cv_product.id=br_cart.id_cv_product AND br_cart.status={$status}");

                                    if($Read->getResult()):
                                        foreach($Read->getResult() as $key):
                                            ?>
                                            <tr>
                                                <td></td>
                                                <td><?= $key['product']; ?></td>
                                                <td><?= $key['qtd']; ?></td>
                                            </tr>
                                            <?php
                                        endforeach;
                                    endif;
                                endif;
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
/**
 * Created by PhpStorm.
 * User: Kwanzar Soft
 * Date: 16/05/2020
 * Time: 00:04
 */

if(!class_exists('login')):
    header("index.php");
    die();
endif;

if($level >= 4): $n =  '&id_db_settings='.$id_db_settings; else: $n = null; endif;

if($userlogin['level'] < 2):
    header("location: panel.php?exe=default/index".$n);
endif;

//include_once("../../../_includes/my-modal-product-and-services-settings.inc.php");
?>


<div class="page-inner">

    <div class="styles">
        <a href="<?= HOME; ?>panel.php?exe=product/create<?= $n; ?>" class="btn btn-primary btn-sm">
            <?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "CRIAR NOVO PRODUTO"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "创建新产品"; endif; ?>
        </a>&nbsp;
        <a class="btn btn-sm btn-default" href="<?= HOME; ?>panel.php?exe=product/pedido-estoque<?= $n; ?>">
            <?php
            $Read = new Read();
            $Read->ExeRead("cv_pedido_product", "WHERE id_db_settings=:i AND status='1' ", "i={$id_db_settings}");

            if($Read->getRowCount() > 99): $pc = "99+"; else: $pc = $Read->getRowCount(); endif;
            ?>
            (<span class="notification"><?= $pc; ?></span>)
            &nbsp;
            Pedido da Loja
        </a>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="form-group d-none d-sm-inline-block form-inline mr-auto ml-md-4 my-3 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" id="searchProductTxt" class="form-control bg-light border-0 small" placeholder="Buscar Produto/Serviço"  aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <input class="btn btn-primary" name="searchProduct" type="submit" value="Pesquisar">
                            </div>
                        </div>
                    </div>

                    <div id="aPaulo"></div>

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th style="width: 20px!important"><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Imagem"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "Cover"; endif; ?></th>
                                <th style="width: 80px!important"><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Descriminação"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "产品/服务"; endif; ?></th>
                                <td style="width: 20px!important">Qtd/Loja</td>
                                <th style="width: 20px!important"><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Preço/Venda"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "销售价格"; endif; ?></th>
                                <th style="width: 50px!important"><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Qtd/Stock"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "数量"; endif; ?></th>
                                <th>-</th>
                            </tr>
                            </thead>
                            <tbody id="getResult">
                                <?php require_once("KwanzarApp/SystemFiles/search-product-and-services-user.inc.php"); ?>
                            </tbody>
                        </table>

                        <?php
                        $Pager->ExePaginator("cv_product");
                        echo $Pager->getPaginator();
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
/**
 * Created by PhpStorm.
 * User: Kwanzar Soft
 * Date: 16/05/2020
 * Time: 00:53
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
    <div id="styles">
        <a href="<?= HOME; ?>panel.php?exe=product/index<?= $n; ?>" class="btn btn-primary btn-icon-split btn-sm">
            <span class="text">Voltar</span>
        </a>
    </div>

    <form class="form-horizontal" method="post" action="" name="SendPostFormL"  enctype="multipart/form-data">
        <?php
        $ClienteData = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        $userId = filter_input(INPUT_GET, 'postid', FILTER_VALIDATE_INT);
        if ($ClienteData && $ClienteData['SendPostFormL']):

            $logoty['logotype'] = ($_FILES['logotype']['tmp_name'] ? $_FILES['logotype'] : null);
            $Count = new Product();
            $Count->ExeUpdate($userId, $logoty, $ClienteData, $id_db_settings);

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
            endif;
        endif;
        ?>

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <span><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Produto/Serviço"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "产品名称/服务 "; endif; ?></span>
                            <input type="text" name = "product" id="product" value="<?php if (!empty($ClienteData['product'])) echo $ClienteData['product']; ?>" class="form-control"  placeholder="<?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Nome do produto/serviço"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "产品名称/服务 "; endif; ?>">
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <span><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Referência"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "参考"; endif; ?></span>
                                    <input type="text" name = "codigo" id="codigo" value="<?php if (!empty($ClienteData['codigo'])) echo $ClienteData['codigo']; ?>" class="form-control"  placeholder="<?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Referência"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "参考"; endif; ?>">
                                </div>
                                <div class="col-md-6">
                                    <span><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Codigo de Barras"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "条形码"; endif; ?></span>
                                    <input type="text" name = "codigo_barras" id="codigo_barras" value="<?php if (!empty($ClienteData['codigo_barras'])) echo $ClienteData['codigo_barras']; ?>" class="form-control"  placeholder="<?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Codigo de Barras"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "条形码"; endif; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <span><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Descrição do produto/serviço, elementos associados"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "产品描述/服务 相关食物 "; endif; ?></span>
                            <textarea placeholder="<?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Descrição do produto/serviço, elementos associados"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "产品描述/服务 相关食物 "; endif; ?>" class="form-control" name="Description" id="Description"><?php if (!empty($ClienteData['Description'])) echo htmlspecialchars($ClienteData['Description']); ?></textarea>
                        </div>
                        <div class="form-group">
                            <span>Imagem [.jpg ou .png {maximo 5MB}]</span>
                            <input type="file" name="logotype" class="form-control" placeholder="" value="">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="col">
                                    <span><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Categoria"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "类别"; endif; ?></span>
                                    <select name="id_category" id="id_category"   class="form-control">
                                        <option value = "">-- Selecione a categoria --</option>
                                        <?php
                                        $nA = "Activo";
                                        $read->ExeRead("cv_category", "WHERE id_db_settings=:id ORDER BY category_title ASC", "id={$id_db_settings}");

                                        if($read->getResult()):
                                            foreach ($read->getResult() as $key):
                                                extract($key);

                                                ?>
                                                <option value = "<?= $key['id']; ?>" <?php if (isset($ClienteData['id_category']) && $ClienteData['id_category'] == $key['id']) echo 'selected="selected"'; ?>><?= $key['category_title']; ?></option>
                                                <?php
                                            endforeach;
                                        endif;
                                        ?>
                                    </select>
                                </div>
                                <div class="col">
                                    <span><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Tipo"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "类型"; endif; ?></span>
                                    <select name="type" id="type" class="form-control">
                                        <option value = "">-- <?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Selecione o Tipo"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "类型"; endif; ?> --</option>
                                        <option value = "P" <?php if (isset($ClienteData['type']) && $ClienteData['type'] == "P") echo 'selected="selected"'; ?>><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Produto"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "产品"; endif; ?></option>
                                        <option value = "S" <?php if (isset($ClienteData['type']) && $ClienteData['type'] == "S") echo 'selected="selected"'; ?>><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Serviço"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "服务"; endif; ?></option>
                                        <option value = "O" <?php if (isset($ClienteData['type']) && $ClienteData['type'] == "O") echo 'selected="selected"'; ?>><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Outros (portes, adiantamentos, etc)"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "其他"; endif; ?></option>
                                        <option value = "E" <?php if (isset($ClienteData['type']) && $ClienteData['type'] == "E") echo 'selected="selected"'; ?>>Impostos Especiais de consumo (IABA; ISP e IT)</option>
                                        <option value = "T" <?php if (isset($ClienteData['type']) && $ClienteData['type'] == "T") echo 'selected="selected"'; ?>>Impostos (excepto IVA e IS) ou Encargo Parafiscal</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col">
                                    <span><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Unidade"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "单位"; endif; ?></span>
                                    <select name="unidade_medida" id="unidade_medida" class="form-control">
                                        <option value = "">-- Selecione a unidade --</option>
                                        <option value = "Kg" <?php if (isset($ClienteData['unidade_medida']) && $ClienteData['unidade_medida'] == "Kg") echo 'selected="selected"'; ?>><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Kg"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "公斤"; endif; ?></option>
                                        <option value = "m" <?php if (isset($ClienteData['unidade_medida']) && $ClienteData['unidade_medida'] == "m") echo 'selected="selected"'; ?>><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Metro"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "米"; endif; ?></option>
                                        <option value = "Uni" <?php if (isset($ClienteData['unidade_medida']) && $ClienteData['unidade_medida'] == "Uni") echo 'selected="selected"'; ?>><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Unidade"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "单位"; endif; ?></option>
                                        <option value = "Cx" <?php if (isset($ClienteData['unidade_medida']) && $ClienteData['unidade_medida'] == "Cx") echo 'selected="selected"'; ?>><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Caixa"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "收银员"; endif; ?></option>
                                    </select>
                                </div>
                                <div class="col">
                                    <span><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Imposto"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "税"; endif; ?></span>
                                    <select class="form-control" name="iva" id="iva">
                                        <option value="">-- OPÇÕES DE <?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Imposto"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "税"; endif; ?> --</option>
                                        <?php
                                        $read->ExeRead("db_taxtable", "WHERE id_db_settings=:id", "id={$id_db_settings}");

                                        if($read->getResult()):
                                            foreach ($read->getResult() as $key):
                                                extract($key);
                                                ?>
                                                <option value="<?= $key['taxPercentage'] ?>:<?= $key['taxtableEntry']; ?>" <?php if(isset($ClienteData['id_iva']) && $ClienteData['id_iva'] == $key['taxtableEntry']) echo "selected='selected'" ?>>
                                                    <?= $key['taxCode']." - ".$key['taxType']." (".$key['taxPercentage']."%) "; ?>
                                                </option>
                                                <?php
                                            endforeach;
                                        endif;
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <span>Incluír na Loja</span>
                                    <select class="form-control" name="ILoja" id="ILoja">
                                        <option value="2" selected <?php if (isset($ClienteData['ILoja']) && $ClienteData['ILoja'] == 2) echo 'selected="selected"'; ?>>Sim</option>
                                        <option value="1"  <?php if (isset($ClienteData['ILoja']) && $ClienteData['ILoja'] == 1) echo 'selected="selected"'; ?>>Não</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <span>Incluír no E-Commerce</span>
                                    <select class="form-control" name="IE_commerce" id="IE_commerce">
                                        <option value="1" <?php if(DBKwanzar::CheckConfig($id_db_settings) == null || DBKwanzar::CheckConfig($id_db_settings)['ECommerce'] == 2): ?>selected<?php endif; ?>   <?php if (isset($ClienteData['IE_commerce']) && $ClienteData['IE_commerce'] == 1) echo 'selected="selected"'; ?>>Não</option>
                                        <option value="2" <?php if(DBKwanzar::CheckConfig($id_db_settings)['ECommerce'] == 1): ?>selected<?php endif; ?>  <?php if (isset($ClienteData['IE_commerce']) && $ClienteData['IE_commerce'] == 2) echo 'selected="selected"'; ?>>Sim</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4">
                                    <span>Custo de compra</span>
                                    <input type="text" id="CustoCompraP" class="form-control" placeholder="Custo de compra"/>
                                </div>
                                <div class="col-md-3">
                                    <span>Porcentagem</span>
                                    <input type="text" id="PorcentagemP" class="form-control" placeholder="Porcentagem"/>
                                </div>
                                <div class="col-md-5">
                                    <span><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Preço de venda"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "销售价格"; endif; ?></span>
                                    <input type="text" name = "preco_venda" id="preco_venda" value="<?php if (!empty($ClienteData['preco_venda'])) echo $ClienteData['preco_venda']; ?>" class="form-control"  placeholder="<?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Preço de venda"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "销售价格"; endif; ?>">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-10">
                                <input type="submit" name="SendPostFormL" class="btn btn-primary btn-sm" value="<?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Salvar"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "保护"; endif; ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
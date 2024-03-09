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
            <h5 class="modal-title">Atualizar Item</h5>
        </div>
        <div class="card-body">
            <form class="form-horizontal" method="post" action="" name="SendPostFormL"  enctype="multipart/form-data">
                <div class="card-body">
                    <div id="getResult">
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
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label class="form-label">Descrição</label>
                                <input type="text" name = "product" id="product" value="<?php if (!empty($ClienteData['product'])) echo $ClienteData['product']; ?>" class="form-control"  placeholder="Descrição"/>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-3">
                            <div class="mb-3">
                                <label class="form-label">Código/Ref.</label>
                                <input type="text" name = "codigo" id="codigo" value="<?php if (!empty($ClienteData['codigo'])) echo $ClienteData['codigo']; ?>" class="form-control"  placeholder="Código">
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <div class="mb-3">
                                <label class="form-label">Marcas</label>
                                <select name="id_marca" id="id_marca" onchange="MarcaSelect();"  class="form-control">
                                    <option value = "">-- Selecione a Marca --</option>
                                    <?php
                                    $nA = "Activo";
                                    $read = new Read();
                                    $read->ExeRead("cv_marcas", "WHERE id_db_settings=:id ORDER BY marca ASC", "id={$id_db_settings}");

                                    if($read->getResult()):
                                        foreach ($read->getResult() as $key):
                                            extract($key);

                                            ?>
                                            <option value = "<?= $key['id']; ?>" <?php if (isset($ClienteData['id_marca']) && $ClienteData['id_marca'] == $key['id']) echo 'selected="selected"'; ?>><?= $key['marca']; ?></option>
                                        <?php
                                        endforeach;
                                    endif;
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <div class="mb-3">
                                <label class="form-label">Código de Barras</label>
                                <input type="text" name = "codigo_barras" id="codigo_barras" value="<?php if (!empty($ClienteData['codigo_barras'])) echo $ClienteData['codigo_barras']; ?>" class="form-control"  placeholder="Código de Barras">
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <div class="mb-3">
                                <label class="form-label">Unidade</label>
                                <select name="unidade_medida" id="unidade_medida" class="form-control">
                                    <option value = "Uni" <?php if (isset($ClienteData['unidade_medida']) && $ClienteData['unidade_medida'] == "Uni") echo 'selected="selected"'; ?>>Unidade</option>
                                    <option value = "Kg" <?php if (isset($ClienteData['unidade_medida']) && $ClienteData['unidade_medida'] == "Kg") echo 'selected="selected"'; ?>>Kg</option>
                                    <option value = "m" <?php if (isset($ClienteData['unidade_medida']) && $ClienteData['unidade_medida'] == "m") echo 'selected="selected"'; ?>>Metro</option>
                                    <option value = "Cx" <?php if (isset($ClienteData['unidade_medida']) && $ClienteData['unidade_medida'] == "Cx") echo 'selected="selected"'; ?>>Caixa</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-3">
                            <div class="mb-3">
                                <label class="form-label">Categoria</label>
                                <select name="id_category" id="id_category" onchange="CategorySelect();"   class="form-control">
                                    <option value = "">-- Selecione a categoria --</option>
                                    <?php
                                    $nA = "Activo";
                                    $read->ExeRead("cv_category", "WHERE id_db_settings=:id ORDER BY category_title ASC", "id={$id_db_settings}");

                                    if($read->getResult()):
                                        foreach ($read->getResult() as $key):
                                            extract($key);

                                            ?>
                                            <option value = "<?= $key['id_xxx']; ?>" <?php if (isset($ClienteData['id_category']) && $ClienteData['id_category'] == $key['id_xxx']) echo 'selected="selected"'; ?>><?= $key['category_title']; ?></option>
                                        <?php
                                        endforeach;
                                    endif;
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <div class="mb-3">
                                <label class="form-label">Tipo de item</label>
                                <select name="type" id="type" class="form-control">
                                    <option value = "P" <?php if (isset($ClienteData['type']) && $ClienteData['type'] == "P") echo 'selected="selected"'; ?>>Produto</option>
                                    <option value = "S" <?php if (isset($ClienteData['type']) && $ClienteData['type'] == "S") echo 'selected="selected"'; ?>>Serviço</option>
                                    <option value = "O" <?php if (isset($ClienteData['type']) && $ClienteData['type'] == "O") echo 'selected="selected"'; ?>>Outros (portes, adiantamentos, etc)</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <div class="mb-3">
                                <label class="form-label">Imagem (.jpg ou .png)</label>
                                <input type="file" name="logotype" class="form-control" placeholder="" value="">
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <div class="mb-3">
                                <label class="form-label">Remarks</label>
                                <input type="text" name = "remarks" id="remarks" value="<?php if(!empty($ClienteData['remarks'])): echo $ClienteData['remarks']; endif; ?>" class="form-control"  placeholder="Remarks">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-3">
                            <div class="mb-3">
                                <label class="form-label">Imposto</label>
                                <select class="form-control" name="iva" id="iva">
                                    <?php
                                    $read->ExeRead("db_taxtable", "WHERE id_db_settings=:id ORDER BY taxPercentage ASC, taxCode ASC", "id={$id_db_settings}");

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

                        <div class="col-lg-3">
                            <div class="mb-3">
                                <label class="form-label">Disponível no Front</label>
                                <select class="form-control" name="ILoja" id="ILoja">
                                    <option value="2" selected <?php if (isset($ClienteData['ILoja']) && $ClienteData['ILoja'] == 2) echo 'selected="selected"'; ?>>Sim</option>
                                    <option value="1"  <?php if (isset($ClienteData['ILoja']) && $ClienteData['ILoja'] == 1) echo 'selected="selected"'; ?>>Não</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="mb-3">
                                <label class="form-label">Incluír no E-Commerce</label>
                                <select class="form-control" name="IE_commerce" id="IE_commerce">
                                    <option value="1" <?php if(DBKwanzar::CheckConfig($id_db_settings) == null || DBKwanzar::CheckConfig($id_db_settings)['ECommerce'] == 2): ?>selected<?php endif; ?>   <?php if (isset($ClienteData['IE_commerce']) && $ClienteData['IE_commerce'] == 1) echo 'selected="selected"'; ?>>Não</option>
                                    <option value="2" <?php if(DBKwanzar::CheckConfig($id_db_settings)['ECommerce'] == 1): ?>selected<?php endif; ?>  <?php if (isset($ClienteData['IE_commerce']) && $ClienteData['IE_commerce'] == 2) echo 'selected="selected"'; ?>>Sim</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <div class="mb-3">
                                <label class="form-label">Local de Armazenamento</label>
                                <input type="text" name = "local_product" id="local_product" value="<?php if(!empty($ClienteData['local_product'])): echo $ClienteData['local_product']; endif; ?>" class="form-control"  placeholder="Local de Armazenamento">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-3">
                            <div class="mb-3">
                                <label class="form-label">Desconto</label>
                                <input type="number" name = "desconto" id="desconto" value="<?php if(!empty($ClienteData['desconto'])): echo $ClienteData['desconto']; else: echo "0"; endif; ?>" class="form-control"  placeholder="Desconto">
                            </div>
                        </div>
                        <div class="col-lg-3" >
                            <div class="mb-3">
                                <label class="form-label">Custo de compra</label>
                                <input type="text" id="custo_compra" value="<?php if (!empty($ClienteData['custo_compra'])) echo $ClienteData['custo_compra']; ?>" name="custo_compra" class="form-control" placeholder="Custo de compra"/>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="mb-3">
                                <label class="form-label">Percentagem</label>
                                <input type="text" id="PorcentagemP" name="PorcentagemP" value="<?php if (!empty($ClienteData['PorcentagemP'])) echo $ClienteData['PorcentagemP']; ?>" class="form-control" placeholder="Porcentagem"/>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="mb-3">
                                <label class="form-label">Preço</label>
                                <input type="text" name = "preco_venda" id="preco_venda" value="<?php if (!empty($ClienteData['preco_venda'])) echo $ClienteData['preco_venda']; ?>" class="form-control"  placeholder="Preço de venda">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label class="form-label">Descrição</label>
                                <textarea placeholder="Descrição" class="form-control" name="Description" id="Description"><?php if (!empty($ClienteData['Description'])) echo htmlspecialchars($ClienteData['Description']); ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" name="SendPostFormL" class="btn btn-primary ms-auto" value="Salvar"/>
                </div>
            </form>
        </div>
    </div>
</div>
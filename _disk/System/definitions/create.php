<?php
if(!class_exists('login')):
    header("index.php");
    die();
endif;

if($level >= 4): $n =  '&id_db_settings='.$id_db_settings; else: $n = null; endif;
?>
<div class="page-header d-print-none">
    <div class="row align-items-center">
        <div class="col">
            <h2 class="page-title">
                Administração
            </h2>
        </div>
    </div>
</div>
<div class="row gx-lg-4">
    <?php require_once("_disk/IncludesApp/MenuDefinitions.inc.php"); ?>
    <div class="col-lg-9">
        <div class="row align-items-center">
            <?php require_once("btnBreak.inc.php");  ?>
            <div class="col">
                <div class="page-pretitle">
                    <?= $Index['name']; ?>
                </div>
                <h2 class="page-title">
                    Procedimentos
                </h2>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h5 class="modal-title">Procedimentos</h5>
            </div>
            <div class="card-body">
                <form class="form-horizontal" method="post" action="" name="SendPostFormL"  enctype="multipart/form-data">
                    <div class="card-body">
                        <div id="getResult">
                            <?php
                            $Read = new Read();
                            $Read->ExeRead("cv_product", "WHERE id_db_settings=:i", "i={$id_db_settings}");

                            if($Read->getResult() || $Read->getRowCount()):
                                $Code = $Read->getRowCount() + 1;
                            else:
                                $Code = 1;
                            endif;

                            $ClienteData = filter_input_array(INPUT_POST, FILTER_DEFAULT);
                            $userId = filter_input(INPUT_GET, 'postid', FILTER_VALIDATE_INT);
                            if ($ClienteData && $ClienteData['SendPostFormL']):

                                $logoty['logotype'] = ($_FILES['logotype']['tmp_name'] ? $_FILES['logotype'] : null);
                                $Count = new Product();
                                $Count->ExeCreate($logoty, $ClienteData, $id_db_settings);

                                if($Count->getResult()):
                                    WSError($Count->getError()[0], $Count->getError()[1]);

                                    $Read->ExeRead("cv_product", "WHERE id_db_settings=:i", "i={$id_db_settings}");
                                    if($Read->getResult() || $Read->getRowCount()):
                                        $Code = $Read->getRowCount() + 1;
                                    else:
                                        $Code = 1;
                                    endif;
                                else:
                                    WSError($Count->getError()[0], $Count->getError()[1]);
                                endif;
                            endif;
                            ?>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label class="form-label">Descrição</label>
                                    <input type="text" name = "product" id="product" value="<?php if (!empty($ClienteData['product'])) echo $ClienteData['product']; ?>" class="form-control"  placeholder="Descrição"/>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label class="form-label">Código/Ref.</label>
                                    <input type="text" name = "codigo" id="codigo" value="<?php echo $Code; ;?>" class="form-control"  placeholder="Código">
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label class="form-label">Código de Barras</label>
                                    <input type="text" name = "codigo_barras" id="codigo_barras" value="<?php if (!empty($ClienteData['codigo_barras'])) echo $ClienteData['codigo_barras']; ?>" class="form-control"  placeholder="Código de Barras">
                                </div>
                            </div>
                        </div>
                        <div class="row" hidden>
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label class="form-label">Unidade</label>
                                    <select name="unidade_medida" id="unidade_medida" class="form-control">
                                        <option value = "Uni" <?php if (isset($ClienteData['unidade_medida']) && $ClienteData['unidade_medida'] == "Uni") echo 'selected="selected"'; ?>>Unidade</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label class="form-label">Categoria</label>
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
                            </div>

                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label class="form-label">Tipo de item</label>
                                    <select name="type" id="type" class="form-control">
                                        <option value = "P" <?php if (isset($ClienteData['type']) && $ClienteData['type'] == "P") echo 'selected="selected"'; ?>>Produto</option>
                                        <option value = "S" <?php if (isset($ClienteData['type']) && $ClienteData['type'] == "S") echo 'selected="selected"'; ?>>Serviço</option>
                                        <option value = "O" <?php if (isset($ClienteData['type']) && $ClienteData['type'] == "O") echo 'selected="selected"'; ?>>Outros (portes, adiantamentos, etc)</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label class="form-label">Imagem (.jpg ou .png)</label>
                                    <input type="file" name="logotype" class="form-control" placeholder="" value="">
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
                            <div class="col-lg-3" hidden>
                                <div class="mb-3">
                                    <label class="form-label">Incluír no E-Commerce</label>
                                    <select class="form-control" name="IE_commerce" id="IE_commerce">
                                        <option value="1" <?php if(DBKwanzar::CheckConfig($id_db_settings) == null || DBKwanzar::CheckConfig($id_db_settings)['ECommerce'] == 2): ?>selected<?php endif; ?>   <?php if (isset($ClienteData['IE_commerce']) && $ClienteData['IE_commerce'] == 1) echo 'selected="selected"'; ?>>Não</option>
                                        <option value="2" <?php if(DBKwanzar::CheckConfig($id_db_settings)['ECommerce'] == 1): ?>selected<?php endif; ?>  <?php if (isset($ClienteData['IE_commerce']) && $ClienteData['IE_commerce'] == 2) echo 'selected="selected"'; ?>>Sim</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-3" hidden>
                                <div class="mb-3">
                                    <label class="form-label">Custo de compra</label>
                                    <input type="text" id="CustoCompraP" class="form-control" placeholder="Custo de compra"/>
                                </div>
                            </div>
                            <div class="col-lg-3" hidden>
                                <div class="mb-3">
                                    <label class="form-label">Percentagem</label>
                                    <input type="text" id="PorcentagemP" class="form-control" placeholder="Porcentagem"/>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="mb-3">
                                    <label class="form-label">Desconto</label>
                                    <input type="number" name = "desconto" id="desconto" value="<?php if(!empty($ClienteData['desconto'])): echo $ClienteData['desconto']; else: echo "0"; endif; ?>" class="form-control"  placeholder="Desconto">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="mb-3">
                                    <label class="form-label">Preço</label>
                                    <input type="text" name = "preco_venda" id="preco_venda" value="<?php if (!empty($ClienteData['preco_venda'])) echo $ClienteData['preco_venda']; ?>" class="form-control"  placeholder="Preço">
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
</div>
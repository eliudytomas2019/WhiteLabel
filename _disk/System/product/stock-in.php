<?php
if(!class_exists('login')):
    header("index.php");
    die();
endif;

if($level >= 4): $n =  '&id_db_settings='.$id_db_settings; else: $n = null; endif;

if($userlogin['level'] < 1):
    header("location: panel.php?exe=default/index".$n);
endif;

$userId = filter_input(INPUT_GET, 'postid', FILTER_VALIDATE_INT);
$postId = filter_input(INPUT_GET, "postid", FILTER_VALIDATE_INT);

$Products = null;

$Read = new Read();
$Read->ExeRead("cv_product", "WHERE id=:i", "i={$postId}");
if($Read->getResult()):
    $Products = $Read->getResult()[0];
endif;
?>
<div class="page-header d-print-none">
    <div class="row align-items-center">

        <div class="col-auto ms-auto d-print-none">
            <div class="btn-list">
                <a href="panel.php?exe=product/stock<?= $n; ?>" class="btn btn-primary">
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
                Movimentação de Stock
            </h2>
        </div>
    </div>
</div>

<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h5 class="modal-title"><?= $Products['product']; ?></h5>
        </div>
        <div class="card-body">
            <form class="form-horizontal" method="post" action="" name="SendPostFormL"  enctype="multipart/form-data">
                <div class="card-body">
                    <div id="getResult">
                        <?php
                        $ClienteData = filter_input_array(INPUT_POST, FILTER_DEFAULT);
                        if ($ClienteData && $ClienteData['SendPostFormL']):
                            $Count = new Product();
                            $Count->ExeStock($ClienteData, $id_db_settings, $postId, $id_user);

                            if($Count->getResult()):
                                WSError($Count->getError()[0], $Count->getError()[1]);
                            else:
                                WSError($Count->getError()[0], $Count->getError()[1]);
                            endif;
                        endif;
                        ?>
                    </div>

                    <div class="row">
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label class="form-label">Movimento</label>
                                <select name="operacao" id="operacao" class="form-control">
                                    <option value="Entrada" <?php if (isset($ClienteData['operacao']) && $ClienteData['operacao'] == "Entrada") echo 'selected="selected"'; ?>>Entrada</option>
                                    <option value="Saída"  <?php if (isset($ClienteData['operacao']) && $ClienteData['operacao'] == "Saída") echo 'selected="selected"'; ?>>Saída</option>
                                    <option value="Rectificaçāo"  <?php if (isset($ClienteData['operacao']) && $ClienteData['operacao'] == "Rectificaçāo") echo 'selected="selected"'; ?>>Rectificaçāo</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label class="form-label">Natureza</label>
                                <select name="natureza" id="natureza" class="form-control">
                                    <option value="Compra" <?php if (isset($ClienteData['natureza']) && $ClienteData['natureza'] == "Compra") echo 'selected="selected"'; ?>>Compra</option>
                                    <option value="Envio ao Fronte" <?php if (isset($ClienteData['natureza']) && $ClienteData['natureza'] == "Envio ao Fronte") echo 'selected="selected"'; ?>>Envio ao Fronte</option>
                                    <option value="Erro de regístro"  <?php if (isset($ClienteData['natureza']) && $ClienteData['natureza'] == "Erro de regístro") echo 'selected="selected"'; ?>>Erro de regístro</option>
                                    <option value="Saída"  <?php if (isset($ClienteData['natureza']) && $ClienteData['natureza'] == "Saída") echo 'selected="selected"'; ?>>Saída</option>
                                    <option value="Produto danificado"  <?php if (isset($ClienteData['natureza']) && $ClienteData['natureza'] == "") echo 'selected="selected"'; ?>>Produto danificado</option>
                                    <option value="Produto caducado"  <?php if (isset($ClienteData['natureza']) && $ClienteData['natureza'] == "Produto caducado") echo 'selected="selected"'; ?>>Produto caducado</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label class="form-label">Custo de compra</label>
                                <input type="text" class="form-control" id="custo_compra" value="<?php if (!empty($ClienteData['custo_compra'])): echo $ClienteData['custo_compra']; else: echo $Products["custo_compra"]; endif; ?>" name="custo_compra" placeholder="Custo de compra"/>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label class="form-label">Quantidade</label>
                                <input type="number" min="0" value="<?php if (!empty($ClienteData['quantidade'])): echo $ClienteData['quantidade']; else: echo 1; endif; ?>" name="quantidade" id="quantidade"  class="form-control"  placeholder="Quantidade">
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label class="form-label">Unidades/Peças</label>
                                <input type="number" min="1" name="unidades" id="unidades" value="<?php if (!empty($ClienteData['unidades'])): echo $ClienteData['unidades']; else: echo "1"; endif; ?>" class="form-control"  placeholder="Unidades">
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label class="form-label">Data da Operaçāo</label>
                                <input type="date" value="<?= date('Y-m-d'); ?>" class="form-control" id="data_operacao" name="data_operacao">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label class="form-label">Descrição</label>
                                <textarea placeholder="Descrição" class="form-control" name="descricao" id="descricao"><?php if (!empty($ClienteData['descricao'])) echo htmlspecialchars($ClienteData['descricao']); ?></textarea>
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
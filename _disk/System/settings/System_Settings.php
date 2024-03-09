<?php
if(!class_exists('login')):
    header("index.php");
    die();
endif;

if($level >= 4): $n =  '&id_db_settings='.$id_db_settings; else: $n = null; endif;

if($userlogin['level'] < 3):
    header("location: painel.php?exe=default/index".$n);
endif;

?>
<div class="page-header d-print-none">
    <div class="row align-items-center">
        <div class="col">
            <h2 class="page-title">
                Configurações
            </h2>
        </div>
    </div>
</div>
<div class="row gx-lg-4">
    <?php require_once("_disk/IncludesApp/MenuSettings.inc.php"); ?>
    <div class="col-lg-9">
        <div class="card">
            <div class="card-header">
                <h5 class="modal-title">Configurações da conta</h5>
            </div>
            <div class="card-body">
                <div class="aPaulo" id="aPaulo"></div>
                <form method="post" action="" name="FormConfig">
                    <?php
                    $Dt = filter_input(INPUT_POST, FILTER_DEFAULT);
                    $read = new Read();
                    $read->ExeRead("db_config", "WHERE id_db_kwanzar=:i AND id_db_settings=:ip", "i={$id_db_kwanzar}&ip={$id_db_settings}");

                    if($read->getResult()):
                        $Dt = $read->getResult()[0];
                    endif;
                    ?>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label class="form-label">Modo de funcionamento do Software</label>
                                <div class="col-sm-12">
                                    <select name="JanuarioSakalumbu" id="JanuarioSakalumbu" class="form-control">
                                        <option value="3" <?php  if (isset($Dt['JanuarioSakalumbu']) && $Dt['JanuarioSakalumbu'] == 3): echo 'selected="selected"'; endif; ?>>Modo Funcionamento Normal</option>
                                        <!---option value="2" <?php  if (isset($Dt['JanuarioSakalumbu']) && $Dt['JanuarioSakalumbu'] == 2): echo 'selected="selected"'; endif; ?>>Modo Teste</option--->
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label class="form-label">Moeda</label>
                                <div class="col-sm-12">
                                    <select name="moeda" id="moeda" class="form-control">
                                        <option value="AOA" <?php  if (isset($Dt['moeda']) && $Dt['moeda'] == 'AOA'): echo 'selected="selected"'; endif; ?>>AOA</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label class="form-label">Stock Mínimo dos Productos</label>
                                <div class="col-sm-12">
                                    <input type="number" min="0" name="estoque_minimo" id="estoque_minimo" class="form-control" value="<?php if (isset($Dt['estoque_minimo'])): echo $Dt['estoque_minimo'] ; endif;?>" placeholder="Estoque Minimo">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label class="form-label">Código Sequencial dos documentos</label>
                                <div class="col-sm-12">
                                    <input type="text" name="sequencialCode" id="sequencialCode" class="form-control" value="<?php if(isset($Dt['sequencialCode'])): echo $Dt['sequencialCode']; endif; ?>" placeholder="Código Sequencial">
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label class="form-label">Largura do logotipo nos documentos</label>
                                <div class="col-sm-12">
                                    <input type="number" min="40" max="200" name="WidthLogotype" id="WidthLogotype" class="form-control" value="<?php if (isset($Dt['WidthLogotype'])): echo $Dt['WidthLogotype']; endif;  ?>" placeholder="Largura da Logo-marca">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label class="form-label">Altura do logotipo nos documentos</label>
                                <div class="col-sm-12">
                                    <input type="number" min="40" max="200" name="HeightLogotype" id="HeightLogotype" class="form-control" value="<?php if (isset($Dt['HeightLogotype'])): echo $Dt['HeightLogotype']; endif; ?>" placeholder="Altura da Logo-marca">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label class="form-label">Permissão de Stock</label>
                                <div class="col-sm-12">
                                    <select name="HeliosPro" id="HeliosPro" class="form-control">
                                        <option value="1" <?php  if (isset($Dt['HeliosPro']) && $Dt['HeliosPro'] == '1'): echo 'selected="selected"'; endif; ?>>Vendas liberadas</option>
                                        <option value="2" <?php  if (isset($Dt['HeliosPro']) && $Dt['HeliosPro'] == '2'): echo 'selected="selected"'; endif; ?>>Controle de Stock</option>
                                        <option value="3" <?php  if (isset($Dt['HeliosPro']) && $Dt['HeliosPro'] == '3'): echo 'selected="selected"'; endif; ?>>Equilibrado</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label class="form-label">Percentagem da Retenção de Fonte</label>
                                <div class="col-sm-12">
                                    <input type="text" name="RetencaoDeFonte" id="RetencaoDeFonte" class="form-control" value="<?php if (isset($Dt['RetencaoDeFonte'])): echo $Dt['RetencaoDeFonte']; endif; ?>" placeholder="Porcentagem da Retenção de Fonte">
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label class="form-label">Incluir Retenção de Fonte no documento?</label>
                                <div class="col-sm-12">
                                    <select name="IncluirNaFactura" id="IncluirNaFactura" class="form-control">
                                        <option value="1" <?php  if (isset($Dt['IncluirNaFactura']) && $Dt['IncluirNaFactura'] == '1'): echo 'selected="selected"'; endif; ?>>Não</option>
                                        <option value="2" <?php  if (isset($Dt['IncluirNaFactura']) && $Dt['IncluirNaFactura'] == '2'): echo 'selected="selected"'; endif; ?>>Sim</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label class="form-label">Incluir o logotipo nos documentos?</label>
                                <div class="col-sm-12">
                                    <select name="IncluirCover" id="IncluirCover" class="form-control">
                                        <option value="2" <?php  if (isset($Dt['IncluirCover']) && $Dt['IncluirCover'] == '2'): echo 'selected="selected"'; endif; ?>>Sim</option>
                                        <option value="1" <?php  if (isset($Dt['IncluirCover']) && $Dt['IncluirCover'] == '1'): echo 'selected="selected"'; endif; ?>>Não</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label class="form-label">Método de pagamento padrāo</label>
                                <div class="col-sm-12">
                                    <select name="MethodDefault" id="MethodDefault" class="form-control">
                                        <option value="2" <?php  if (isset($Dt['MethodDefault']) && $Dt['MethodDefault'] == '2'): echo 'selected="selected"'; endif; ?>>Cartão de Débito</option>
                                        <option value="1" <?php  if (isset($Dt['MethodDefault']) && $Dt['MethodDefault'] == '1'): echo 'selected="selected"'; endif; ?>>Numerário</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label class="form-label">Incluir os productos no E-Commerce?</label>
                                <div class="col-sm-12">
                                    <select name="ECommerce" id="ECommerce" class="form-control">
                                        <option value="2" <?php  if (isset($Dt['ECommerce']) && $Dt['ECommerce'] == '2'): echo 'selected="selected"'; endif; ?>>Não</option>
                                        <option value="1" <?php  if (isset($Dt['ECommerce']) && $Dt['ECommerce'] == '1'): echo 'selected="selected"'; endif; ?>>Sim</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label class="form-label">Modelo de Factura A4</label>
                                <div class="col-sm-12">
                                    <select name="DocModel" id="DocModel" class="form-control">
                                        <option value="1" <?php  if (isset($Dt['DocModel']) && $Dt['DocModel'] == '1'): echo 'selected="selected"'; endif; ?>>Modelo A (Padrão)</option>
                                        <option value="2" <?php  if (isset($Dt['DocModel']) && $Dt['DocModel'] == '2'): echo 'selected="selected"'; endif; ?>>Modelo B (Moderna)</option>
                                        <!---option value="3" <?php  if (isset($Dt['DocModel']) && $Dt['DocModel'] == '3'): echo 'selected="selected"'; endif; ?>>Modelo C (Oficina Mecânica)</option>
                                        <option value="4" <?php  if (isset($Dt['DocModel']) && $Dt['DocModel'] == '4'): echo 'selected="selected"'; endif; ?>>Modelo D (Gestão de Marcas)</option--->
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label class="form-label">Regime de IVA</label>
                                <div class="col-sm-12">
                                    <select name="regimeIVA" id="regimeIVA" class="form-control">
                                        <option value="Regime geral" <?php  if (isset($Dt['regimeIVA']) && $Dt['regimeIVA'] == 'Regime geral'): echo 'selected="selected"'; endif; ?>>Regime Geral</option>
                                        <option value="Regime simplificado" <?php  if (isset($Dt['regimeIVA']) && $Dt['regimeIVA'] == 'Regime simplificado'): echo 'selected="selected"'; endif; ?>>Regime simplificado</option>
                                        <option value="Regime de exclusão" <?php  if (isset($Dt['regimeIVA']) && $Dt['regimeIVA'] == 'Regime de exclusão'): echo 'selected="selected"'; endif; ?>>Regime de exclusão</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label class="form-label">Padrão AGT</label>
                                <div class="col-sm-12">
                                    <select name="PadraoAGT" id="PadraoAGT" class="form-control">
                                        <option value="2" <?php  if (isset($Dt['PadraoAGT']) && $Dt['PadraoAGT'] == '2'): echo 'selected="selected"'; endif; ?>>Sim</option>
                                        <?php if($level == 5): ?><option value="1" <?php  if (isset($Dt['PadraoAGT']) && $Dt['PadraoAGT'] == '1'): echo 'selected="selected"'; endif; ?>>Não</option><?php endif; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr/>

                    <div class="row">
                        <div class="col-lg-2">
                            <div class="mb-3">
                                <label class="form-label">Idioma</label>
                                <select class="form-control" name="Idioma" id="Idioma">
                                    <option value="Inglês" <?php  if (isset($Dt['Idioma']) && $Dt['Idioma'] == 'Inglês'): echo 'selected="selected"'; endif; ?>>Inglês</option>
                                    <option value="Português" <?php  if (isset($Dt['Idioma']) && $Dt['Idioma'] == 'Português'): echo 'selected="selected"'; endif; ?>>Português</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="mb-3">
                                <label class="form-label">Taxa de Imposto Preferêncial</label>
                                <select class="form-control" name="taxa_preferencial" id="taxa_preferencial">
                                    <?php
                                    $read->ExeRead("db_taxtable", "WHERE id_db_settings=:id ORDER BY taxPercentage ASC, taxCode ASC", "id={$id_db_settings}");

                                    if($read->getResult()):
                                        foreach ($read->getResult() as $key):
                                            ?>
                                            <option value="<?= $key['taxtableEntry'] ?>" <?php if(isset($Dt['taxa_preferencial']) && $Dt['taxa_preferencial'] == $key['taxtableEntry']) echo "selected='selected'" ?>>
                                                <?= $key['taxCode']." - ".$key['taxType']." (".$key['taxPercentage']."%) "; ?>
                                            </option>
                                            <?php
                                        endforeach;
                                    endif;
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="mb-3">
                                <label class="form-label">Câmbio Atual</label>
                                <input type="text" name="cambio_atual" id="cambio_atual" class="form-control" value="<?php if (isset($Dt['cambio_atual'])): echo $Dt['cambio_atual']; endif; ?>" placeholder="Câmbio Atual">
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="mb-3">
                                <label class="form-label">Atualizar os preços o Câmbio?</label>
                                <select name="cambio_x_preco" id="cambio_x_preco" class="form-control">
                                    <option value="2" <?php  if (isset($Dt['cambio_x_preco']) && $Dt['cambio_x_preco'] == '2'): echo 'selected="selected"'; endif; ?>>Não</option>
                                    <option value="1" <?php  if (isset($Dt['cambio_x_preco']) && $Dt['cambio_x_preco'] == '1'): echo 'selected="selected"'; endif; ?>>Sim</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="mb-3">
                                <label class="form-label">% de lucro pelo Câmbio</label>
                                <input type="text" name="porcentagem_x_cambio" id="porcentagem_x_cambio" class="form-control" value="<?php if (isset($Dt['porcentagem_x_cambio'])): echo $Dt['porcentagem_x_cambio']; endif; ?>" placeholder="% de lucro pelo Câmbio">
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Salvar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
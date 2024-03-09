<?php
if(!class_exists('login')):
    header("index.php");
    die();
endif;

if($level >= 4): $n =  '&id_db_settings='.$id_db_settings; else: $n = null; endif;

if($userlogin['level'] < 3):
    header("location: panel.php?exe=default/home".$n);
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
        <div class="page-header d-print-none">
            <div class="row align-items-center">

                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="panel.php?exe=settings/taxtable<?= $n; ?>" class="btn btn-primary d-none d-sm-inline-block">
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
                        Taxa de imposto
                    </h2>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h5 class="modal-title">Taxas de imposto</h5>
            </div>
            <div class="card-body">
                <?php
                $ClienteData = filter_input_array(INPUT_POST, FILTER_DEFAULT);
                $userId = filter_input(INPUT_GET, 'userid', FILTER_VALIDATE_INT);
                if ($ClienteData && $ClienteData['SendPostForm']):
                    $Cadastrar = new TaxTable();
                    $Cadastrar->ExeUpdate($userId, $ClienteData, $id_db_settings);

                    if($Cadastrar->getResult()):
                        WSError($Cadastrar->getError()[0], $Cadastrar->getError()[1]);
                    else:
                        WSError($Cadastrar->getError()[0], $Cadastrar->getError()[1]);
                    endif;
                else:
                    $ReadUser = new Read;
                    $ReadUser->ExeRead("db_taxtable", "WHERE taxtableEntry=:userid AND id_db_settings=:i", "userid={$userId}&i={$id_db_settings}");
                    if (!$ReadUser->getResult()):

                    else:
                        $ClienteData = $ReadUser->getResult()[0];
                    endif;
                endif;
                ?>
                <form class="form-horizontal" method="post" action="" name = "SendPostForm"  enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label class="form-label">Código do modelo de impostos</label>
                                <select name="taxType"   class="form-control">
                                    <option value = "">Código do modelo de impostos</option>
                                    <option value = "IVA" <?php if (isset($ClienteData['taxType']) && $ClienteData['taxType'] == 'IVA') echo 'selected="selected"'; ?>>IVA - Imposto sobre valor acrescentado</option>
                                    <option value = "15" <?php if (isset($ClienteData['taxType']) && $ClienteData['taxType'] == '15') echo 'selected="selected"'; ?>>15 - Imposto de selo</option>
                                    <option value = "NS" <?php if (isset($ClienteData['taxType']) && $ClienteData['taxType'] == 'NS') echo 'selected="selected"'; ?>>NS - Não sujeição a IVA ou IS - Isento</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label class="form-label">Código do impostos</label>
                                <select name="taxCode"   class="form-control">
                                    <option value = "">Código do impostos</option>
                                    <optgroup label="IVA">
                                        <option value = "NOR" <?php if (isset($ClienteData['taxCode']) && $ClienteData['taxCode'] == 'NOR') echo 'selected="selected"'; ?>>NOR - Normal</option>
                                        <option value = "ISE" <?php if (isset($ClienteData['taxCode']) && $ClienteData['taxCode'] == 'ISE') echo 'selected="selected"'; ?>>ISE - Isenta</option>
                                        <option value = "OUT" <?php if (isset($ClienteData['taxCode']) && $ClienteData['taxCode'] == 'OUT') echo 'selected="selected"'; ?>>OUT - Outros</option>
                                    </optgroup>

                                    <optgroup label="IS">
                                        <option value = "ISE" <?php if (isset($ClienteData['taxCode']) && $ClienteData['taxCode'] == 'ISE') echo 'selected="selected"'; ?>>ISE - Isento</option>
                                        <option value = "NS" <?php if (isset($ClienteData['taxCode']) && $ClienteData['taxCode'] == 'NS') echo 'selected="selected"'; ?>>NS - Não sujeição</option>
                                    </optgroup>

                                    <optgroup label="NA">
                                        <option value = "NA" <?php if (isset($ClienteData['taxCode']) && $ClienteData['taxCode'] == 'NA') echo 'selected="selected"'; ?>>NA - Emitidos em impostos</option>
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label class="form-label">Descrição</label>
                                <input type="text" name="description" class="form-control" value="<?php if (!empty($ClienteData['description'])) echo $ClienteData['description']; ?>" placeholder="Descrição">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label class="form-label">Porcentagem da Taxa</label>
                                <input type="text" min="0" max="100" name="taxPercentage" class="form-control" value="<?php if (!empty($ClienteData['taxPercentage'])) echo $ClienteData['taxPercentage']; ?>" placeholder="Porcentagem da Taxa">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label class="form-label">Montante de imposto</label>
                                <input type="text" name="taxAmount" class="form-control" value="<?php if (!empty($ClienteData['taxAmount'])) echo $ClienteData['taxAmount']; ?>" placeholder="Montante de Imposto">
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label class="form-label">País ou região do imposto</label>
                                <input type="text" name="TaxCountryRegion" class="form-control" value="<?php if (!empty($ClienteData['TaxCountryRegion'])) echo $ClienteData['TaxCountryRegion']; ?>" placeholder="País ou Região do Imposto">
                            </div>
                        </div>
                    </div>


                    <div class="mb-3">
                        <label class="form-label">Motivo Predefinido de Isenção</label>
                        <select name="TaxExemptionReason" class="form-control">
                            <option value="M00 - Regime Transitório" <?php if (isset($ClienteData['TaxExemptionReason']) && $ClienteData['TaxExemptionReason'] == 'M00 - Regime Transitório') echo 'selected="selected"'; ?>>Regime Transitório</option>
                            <option value="M02 - Transmissão de bens e serviço não sujeita" <?php if (isset($ClienteData['TaxExemptionReason']) && $ClienteData['TaxExemptionReason'] == 'M02 - Transmissão de bens e serviço não sujeita') echo 'selected="selected"'; ?>>Transmissão de bens e serviço não sujeita</option>
                            <option value="M04 - Regime de não sujeição" <?php if (isset($ClienteData['TaxExemptionReason']) && $ClienteData['TaxExemptionReason'] == 'M04 - Regime de não sujeição') echo 'selected="selected"'; ?>>IVA – Regime de não sujeição</option>
                            <option value="M10 - Isento nos termos da alínea a) do nº1 do artigo 12.º do CIVA" <?php if (isset($ClienteData['TaxExemptionReason']) && $ClienteData['TaxExemptionReason'] == 'M10 - Isento nos termos da alínea a) do nº1 do artigo 12.º do CIVA') echo 'selected="selected"'; ?>>Isento nos termos da alínea a) do nº1 do artigo 12.º do CIVA</option>
                            <option value="M11 - Isento nos termos da alínea b) do nº1 do artigo 12.º do CIVA" <?php if (isset($ClienteData['TaxExemptionReason']) && $ClienteData['TaxExemptionReason'] == 'M11 - Isento nos termos da alínea b) do nº1 do artigo 12.º do CIVA') echo 'selected="selected"'; ?>>Isento nos termos da alínea b) do nº1 do artigo 12.º do CIVA</option>
                            <option value="M12 - Isento nos termos da alínea c) do nº1 do artigo 12.º do CIVA" <?php if (isset($ClienteData['TaxExemptionReason']) && $ClienteData['TaxExemptionReason'] == 'M12 - Isento nos termos da alínea c) do nº1 do artigo 12.º do CIVA') echo 'selected="selected"'; ?>>Isento nos termos da alínea c) do nº1 do artigo 12.º do CIVA</option>
                            <option value="M13 - Isento nos termos da alínea d) do nº1 do artigo 12.º do CIVA" <?php if (isset($ClienteData['TaxExemptionReason']) && $ClienteData['TaxExemptionReason'] == 'M13 - Isento nos termos da alínea d) do nº1 do artigo 12.º do CIVA') echo 'selected="selected"'; ?>>Isento nos termos da alínea d) do nº1 do artigo 12.º do CIVA</option>
                            <option value="M14 - Isento nos termos da alínea e) do nº1 do artigo 12.º do CIVA" <?php if (isset($ClienteData['TaxExemptionReason']) && $ClienteData['TaxExemptionReason'] == 'M14 - Isento nos termos da alínea e) do nº1 do artigo 12.º do CIVA') echo 'selected="selected"'; ?>>Isento nos termos da alínea e) do nº1 do artigo 12.º do CIVA</option>
                            <option value="M15 - Isento nos termos da alínea f) do nº1 do artigo 12.º do CIVA" <?php if (isset($ClienteData['TaxExemptionReason']) && $ClienteData['TaxExemptionReason'] == 'M15 - Isento nos termos da alínea f) do nº1 do artigo 12.º do CIVA') echo 'selected="selected"'; ?>>Isento nos termos da alínea f) do nº1 do artigo 12.º do CIVA</option>
                            <option value="M16 - Isento nos termos da alínea g) do nº1 do artigo 12.º do CIVA" <?php if (isset($ClienteData['TaxExemptionReason']) && $ClienteData['TaxExemptionReason'] == 'M16 - Isento nos termos da alínea g) do nº1 do artigo 12.º do CIVA') echo 'selected="selected"'; ?>>Isento nos termos da alínea g) do nº1 do artigo 12.º do CIVA</option>
                            <option value="M17 - Isento nos termos da alínea h) do nº1 do artigo 12.º do CIVA" <?php if (isset($ClienteData['TaxExemptionReason']) && $ClienteData['TaxExemptionReason'] == 'M17 - Isento nos termos da alínea h) do nº1 do artigo 12.º do CIVA') echo 'selected="selected"'; ?>>Isento nos termos da alínea h) do nº1 do artigo 12.º do CIVA</option>
                            <option value="M18 - Isento nos termos da alínea i) do nº1 do artigo 12.º do CIVA" <?php if (isset($ClienteData['TaxExemptionReason']) && $ClienteData['TaxExemptionReason'] == 'M18 - Isento nos termos da alínea i) do nº1 do artigo 12.º do CIVA') echo 'selected="selected"'; ?>>Isento nos termos da alínea i) do nº1 do artigo 12.º do CIVA</option>
                            <option value="M19 - Isento nos termos da alínea j) do nº1 do artigo 12.º do CIVA" <?php if (isset($ClienteData['TaxExemptionReason']) && $ClienteData['TaxExemptionReason'] == 'M19 - Isento nos termos da alínea j) do nº1 do artigo 12.º do CIVA') echo 'selected="selected"'; ?>>Isento nos termos da alínea j) do nº1 do artigo 12.º do CIVA</option>
                            <option value="M20 - Isento nos termos da alínea k) do nº1 do artigo 12.º do CIVA" <?php if (isset($ClienteData['TaxExemptionReason']) && $ClienteData['TaxExemptionReason'] == 'M20 - Isento nos termos da alínea k) do nº1 do artigo 12.º do CIVA') echo 'selected="selected"'; ?>>Isento nos termos da alínea k) do nº1 do artigo 12.º do CIVA</option>
                            <option value="M21 - Isento nos termos da alínea l) do nº1 do artigo 12.º do CIVA" <?php if (isset($ClienteData['TaxExemptionReason']) && $ClienteData['TaxExemptionReason'] == 'M21 - Isento nos termos da alínea l) do nº1 do artigo 12.º do CIVA') echo 'selected="selected"'; ?>>Isento nos termos da alínea l) do nº1 do artigo 12.º do CIVA</option>
                            <option value="M22 - Isento nos termos da alínea m) do nº1 do artigo 12.º do CIVA" <?php if (isset($ClienteData['TaxExemptionReason']) && $ClienteData['TaxExemptionReason'] == 'M22 - Isento nos termos da alínea m) do nº1 do artigo 12.º do CIVA') echo 'selected="selected"'; ?>>Isento nos termos da alínea m) do nº1 do artigo 12.º do CIVA</option>
                            <option value="M23 - Isento nos termos da alínea n) do nº1 do artigo 12.º do CIVA" <?php if (isset($ClienteData['TaxExemptionReason']) && $ClienteData['TaxExemptionReason'] == 'M23 - Isento nos termos da alínea n) do nº1 do artigo 12.º do CIVA') echo 'selected="selected"'; ?>>Isento nos termos da alínea n) do nº1 do artigo 12.º do CIVA</option>
                            <option value="M24 - Isento nos termos da alínea o) do nº1 do artigo 12.º do CIVA" <?php if (isset($ClienteData['TaxExemptionReason']) && $ClienteData['TaxExemptionReason'] == 'M24 - Isento nos termos da alínea o) do nº1 do artigo 12.º do CIVA') echo 'selected="selected"'; ?>>Isento nos termos da alínea o) do nº1 do artigo 12.º do CIVA</option>

                            <option value="M82 - Isento nos termos da alinea c) do nº1 do artigo 14.º" <?php if (isset($ClienteData['TaxExemptionReason']) && $ClienteData['TaxExemptionReason'] == 'M82 - Isento nos termos da alinea c) do nº1 do artigo 14.º') echo 'selected="selected"'; ?>>Isento nos termos da alinea c) do nº1 do artigo 14.º</option>
                            <option value="M83 - Isento nos termos da alinea d) do nº1 do artigo 14.º" <?php if (isset($ClienteData['TaxExemptionReason']) && $ClienteData['TaxExemptionReason'] == 'M83 - Isento nos termos da alinea d) do nº1 do artigo 14.º') echo 'selected="selected"'; ?>>Isento nos termos da alinea d) do nº1 do artigo 14.º</option>
                            <option value="M84 - Isento nos termos da alínea e) do nº1 do artigo 14.º" <?php if (isset($ClienteData['TaxExemptionReason']) && $ClienteData['TaxExemptionReason'] == 'M84 - Isento nos termos da alínea e) do nº1 do artigo 14.º') echo 'selected="selected"'; ?>>Isento nos termos da alínea e) do nº1 do artigo 14.º</option>
                            <option value="M85 - Isento nos termos da alinea a) do nº2 do artigo 14.º" <?php if (isset($ClienteData['TaxExemptionReason']) && $ClienteData['TaxExemptionReason'] == 'M85 - Isento nos termos da alinea a) do nº2 do artigo 14.º') echo 'selected="selected"'; ?>>Isento nos termos da alinea a) do nº2 do artigo 14.º</option>
                            <option value="M86 - Isento nos termos da alinea b) do nº2 do artigo 14.º" <?php if (isset($ClienteData['TaxExemptionReason']) && $ClienteData['TaxExemptionReason'] == 'M86 - Isento nos termos da alinea b) do nº2 do artigo 14.º') echo 'selected="selected"'; ?>>Isento nos termos da alinea b) do nº2 do artigo 14.º</option>

                            <option value="M30 - Isento nos termos da alínea a) do artigo 15.º do CIVA" <?php if (isset($ClienteData['TaxExemptionReason']) && $ClienteData['TaxExemptionReason'] == 'M30 - Isento nos termos da alínea a) do artigo 15.º do CIVA') echo 'selected="selected"'; ?>>Isento nos termos da alínea a) do artigo 15.º do CIVA</option>
                            <option value="M31 - Isento nos termos da alínea b) do artigo 15.º do CIVA" <?php if (isset($ClienteData['TaxExemptionReason']) && $ClienteData['TaxExemptionReason'] == 'M31 - Isento nos termos da alínea b) do artigo 15.º do CIVA') echo 'selected="selected"'; ?>>Isento nos termos da alínea b) do artigo 15.º do CIVA</option>
                            <option value="M32 - Isento nos termos da alínea c) do artigo 15.º do CIVA" <?php if (isset($ClienteData['TaxExemptionReason']) && $ClienteData['TaxExemptionReason'] == 'M32 - Isento nos termos da alínea c) do artigo 15.º do CIVA') echo 'selected="selected"'; ?>>Isento nos termos da alínea c) do artigo 15.º do CIVA</option>
                            <option value="M33 - Isento nos termos da alínea d) do artigo 15.º do CIVA" <?php if (isset($ClienteData['TaxExemptionReason']) && $ClienteData['TaxExemptionReason'] == 'M33 - Isento nos termos da alínea d) do artigo 15.º do CIVA') echo 'selected="selected"'; ?>>Isento nos termos da alínea d) do artigo 15.º do CIVA</option>
                            <option value="M34 - Isento nos termos da alínea e) do artigo 15.º do CIVA" <?php if (isset($ClienteData['TaxExemptionReason']) && $ClienteData['TaxExemptionReason'] == 'M34 - Isento nos termos da alínea e) do artigo 15.º do CIVA') echo 'selected="selected"'; ?>>Isento nos termos da alínea e) do artigo 15.º do CIVA</option>
                            <option value="M35 - Isento nos termos da alínea f) do artigo 15.º do CIVA" <?php if (isset($ClienteData['TaxExemptionReason']) && $ClienteData['TaxExemptionReason'] == 'M35 - Isento nos termos da alínea f) do artigo 15.º do CIVA') echo 'selected="selected"'; ?>>Isento nos termos da alínea f) do artigo 15.º do CIVA</option>
                            <option value="M36 - Isento nos termos da alínea g) do artigo 15.º do CIVA" <?php if (isset($ClienteData['TaxExemptionReason']) && $ClienteData['TaxExemptionReason'] == 'M36 - Isento nos termos da alínea g) do artigo 15.º do CIVA') echo 'selected="selected"'; ?>>Isento nos termos da alínea g) do artigo 15.º do CIVA</option>
                            <option value="M37 - Isento nos termos da alínea h) do artigo 15.º do CIVA" <?php if (isset($ClienteData['TaxExemptionReason']) && $ClienteData['TaxExemptionReason'] == 'M37 - Isento nos termos da alínea h) do artigo 15.º do CIVA') echo 'selected="selected"'; ?>>Isento nos termos da alínea h) do artigo 15.º do CIVA</option>
                            <option value="M38 - Isento nos termos da alínea i) do artigo 15.º do CIVA" <?php if (isset($ClienteData['TaxExemptionReason']) && $ClienteData['TaxExemptionReason'] == 'M38 - Isento nos termos da alínea i) do artigo 15.º do CIVA') echo 'selected="selected"'; ?>>Isento nos termos da alínea i) do artigo 15.º do CIVA</option>

                            <option value="M90 - Isento nos termos da alinea a) do nº1 do artigo 16.º" <?php if (isset($ClienteData['TaxExemptionReason']) && $ClienteData['TaxExemptionReason'] == 'M90 - Isento nos termos da alinea a) do nº1 do artigo 16.º') echo 'selected="selected"'; ?>>Isento nos termos da alinea a) do nº1 do artigo 16.º</option>
                            <option value="M91 - Isento nos termos da alinea b) do nº1 do artigo 16.º" <?php if (isset($ClienteData['TaxExemptionReason']) && $ClienteData['TaxExemptionReason'] == 'M91 - Isento nos termos da alinea b) do nº1 do artigo 16.º') echo 'selected="selected"'; ?>>Isento nos termos da alinea b) do nº1 do artigo 16.º</option>
                            <option value="M92 - Isento nos termos da alinea c) do nº1 do artigo 16.º" <?php if (isset($ClienteData['TaxExemptionReason']) && $ClienteData['TaxExemptionReason'] == 'M92 - Isento nos termos da alinea c) do nº1 do artigo 16.º') echo 'selected="selected"'; ?>>Isento nos termos da alinea c) do nº1 do artigo 16.º</option>
                            <option value="M93 - Isento nos termos da alinea d) do nº1 do artigo 16.º" <?php if (isset($ClienteData['TaxExemptionReason']) && $ClienteData['TaxExemptionReason'] == 'M93 - Isento nos termos da alinea d) do nº1 do artigo 16.º') echo 'selected="selected"'; ?>>Isento nos termos da alinea d) do nº1 do artigo 16.º</option>
                            <option value="M94 - Isento nos termos da alinea e) do nº1 do artigo 16.º" <?php if (isset($ClienteData['TaxExemptionReason']) && $ClienteData['TaxExemptionReason'] == 'M94 - Isento nos termos da alinea e) do nº1 do artigo 16.º') echo 'selected="selected"'; ?>>Isento nos termos da alinea e) do nº1 do artigo 16.º</option>
                        </select>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-10">
                            <input type="submit" name="SendPostForm" class="btn btn-primary" value="Atualizar"/>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
if(!class_exists('login')):
    header("index.php");
    die();
endif;

if($level >= 4): $n =  '&id_db_settings='.$id_db_settings; else: $n = null; endif;

if($userlogin['level'] < 1):
    header("location: panel.php?exe=default/index".$n);
endif;
?>

<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <div class="page-pretitle">
                <?= $Index['name']; ?>
            </div>
            <h2 class="page-title">
                Entrada e Saída
            </h2>
        </div>
        <div class="col-auto ms-auto">
            <div class="btn-list">

            </div>
        </div>
    </div>
</div>


<div class="row row-cards">
    <div class="col-12">
        <form action="" method="post" class="card">
            <div class="card-header">
                <h4 class="card-title">Entrada e Saída</h4>
            </div>
            <div class="card-body">
                <div id="getResult">
                    <?php
                    $ClienteData = filter_input_array(INPUT_POST, FILTER_DEFAULT);
                    if ($ClienteData && $ClienteData['SendPostFormL']):
                        $Count = new Caixa();
                        $Count->Entrada_E_Saida($ClienteData, $id_db_settings, $id_user);

                        if($Count->getResult()):
                            WSError($Count->getError()[0], $Count->getError()[1]);
                        else:
                            WSError($Count->getError()[0], $Count->getError()[1]);
                        endif;
                    endif;
                    ?>
                </div>

                <div class="row">
                    <div class="col-lg-3">
                        <div class="mb-3">
                            <label class="form-label">Valor</label>
                            <input type="text" name = "valor" id="valor" value="<?php if (!empty($ClienteData['valor'])) echo $ClienteData['valor']; ?>" class="form-control"  placeholder="Valor">
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="mb-3">
                            <label class="form-label">Cliente</label>
                            <select id="id_customer" name="id_customer" class="form-control">
                                <?php
                                $read = new Read();
                                $read->ExeRead("cv_customer", "WHERE id_db_settings=:i ORDER BY id ASC", "i={$id_db_settings}");
                                if($read->getResult()):
                                    foreach ($read->getResult() as $Supplier):
                                        ?>
                                        <option value="<?= $Supplier['id']; ?>" <?php if(isset($DataSupplier['id_customer']) && $DataSupplier['id_customer'] == $Supplier['id']) echo 'selected="selected"'; ?>><?= $Supplier['nome']; ?></option>
                                    <?php
                                    endforeach;
                                else:
                                    WSError("Oppsss! Não encontramos nenhum Cliente, cadastre um para prosseguir!", WS_ALERT);
                                endif;
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="mb-3">
                            <label class="form-label">Movimento</label>
                            <select class="form-control" id="type" name="type">
                                <option value="Entrada" <?php if(isset($DataSupplier['type']) && $DataSupplier['type'] == "Entrada") echo 'selected="selected"'; ?>>Entrada</option>
                                <option value="Saida" <?php if(isset($DataSupplier['type']) && $DataSupplier['type'] == "Saida") echo 'selected="selected"'; ?>>Saida</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="mb-3">
                            <label class="form-label">Metodo de Pagamento</label>
                            <select class="form-control" id="method" name="method">
                                <option value="CD" <?php if(isset($DataSupplier['method']) && $DataSupplier['method'] == "CD"): echo 'selected="selected"'; elseif(DBKwanzar::CheckConfig($id_db_settings)['MethodDefault'] == null || isset(DBKwanzar::CheckConfig($id_db_settings)['MethodDefault']) && DBKwanzar::CheckConfig($id_db_settings)['MethodDefault'] == 2): echo "selected"; endif; ?>>Cartão de Debito</option>
                                <option value="NU" <?php if(isset($DataSupplier['method']) && $DataSupplier['method'] == "NU"): echo 'selected="selected"'; elseif(DBKwanzar::CheckConfig($id_db_settings)['MethodDefault'] == null || isset(DBKwanzar::CheckConfig($id_db_settings)['MethodDefault']) && DBKwanzar::CheckConfig($id_db_settings)['MethodDefault'] == 1): echo "selected"; endif; ?>>Numerário</option>
                                <option value="TB" <?php if(isset($DataSupplier['method']) && $DataSupplier['method'] == "TB") echo 'selected="selected"'; ?>>Transferência Bancária</option>
                                <option value="MB" <?php if(isset($DataSupplier['method']) && $DataSupplier['method'] == "MB") echo 'selected="selected"'; ?>>Referência de pagamentos para Multicaixa</option>
                                <option value="OU" <?php if(isset($DataSupplier['method']) && $DataSupplier['method'] == "OU") echo 'selected="selected"'; ?>>Outros Meios Aqui não Assinalados</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="mb-3">
                            <label class="form-label">Descrição</label>
                            <textarea placeholder="Descrição" class="form-control" name="description" id="description"><?php if (!empty($ClienteData['description'])) echo htmlspecialchars($ClienteData['description']); ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-end">
                <div class="d-flex">
                    <input type="submit" name="SendPostFormL" class="btn btn-primary" value="Salvar"/>
                </div>
            </div>
        </form>
    </div>
</div>


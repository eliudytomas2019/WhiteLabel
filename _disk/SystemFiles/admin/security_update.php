<div class="page-header d-print-none">
    <div class="row align-items-center">

        <div class="col-auto ms-auto d-print-none">
            <div class="btn-list">
                <a href="Admin.php?exe=admin/security" class="btn btn-primary d-none d-sm-inline-block">
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
                Configurações de Segurança e Licença
            </h2>
        </div>
    </div>
</div>

<div class="page-wrapper">
    <div class="container-xl">
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="card">
                    <h2 class="card-header">
                        Configurações de Segurança e Licença
                    </h2>
                    <div class="card-body">
                        <div id="getResult">
                            <?php
                            $postId = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
                            $ClienteData = filter_input_array(INPUT_POST, FILTER_DEFAULT);
                            if ($ClienteData && $ClienteData['SendPostFormL']):
                                $Satan = new SatanIsGod();
                                $Satan->UpdateSecurity($postId, $ClienteData);
                                if($Satan->getResult()):
                                    WSError($Satan->getError()[0], $Satan->getError()[1]);
                                else:
                                    WSError($Satan->getError()[0], $Satan->getError()[1]);
                                endif;
                            else:
                                $Read = new Read();
                                $Read->ExeRead("z_security", "WHERE id=:i", "i={$postId}");

                                if($Read->getResult() || $Read->getRowCount()):
                                    $ClienteData = $Read->getResult()[0];
                                endif;
                            endif;
                            ?>
                        </div>
                        <form method="post" action="" name="SendPostFormL" enctype="multipart/form-data">
                            <div class="row">
                                <div class="mb-3 col-6">
                                    <label class="form-label">Plano (nome)</label>
                                    <div class="input-group input-group-flat">
                                        <input type="text" value="<?php if (!empty($ClienteData['plano'])) echo $ClienteData['plano']; ?>" class="form-control ps-1" name="plano" placeholder="Plano (nome)">
                                    </div>
                                </div>
                                <div class="mb-3 col-6">
                                    <label class="form-label">Documentos mensal</label>
                                    <div class="input-group input-group-flat">
                                        <input type="text" value="<?php if (!empty($ClienteData['documentos'])) echo $ClienteData['documentos']; ?>" class="form-control ps-1" name="documentos" placeholder="Nº de Documentos mensal">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3 col-6">
                                    <label class="form-label">Usuários</label>
                                    <div class="input-group input-group-flat">
                                        <input type="text" value="<?php if (!empty($ClienteData['usuarios'])) echo $ClienteData['usuarios']; ?>" class="form-control ps-1" name="usuarios" placeholder="Nº de Usuários">
                                    </div>
                                </div>
                                <div class="mb-3 col-6">
                                    <label class="form-label">Módulos</label>
                                    <div class="input-group input-group-flat">
                                        <select id="modulos" name="modulos" class="form-control">
                                            <option value="" selected>-- SELECIONE O MÓDULO --</option>
                                            <option value="1" <?php if (isset($ClienteData['modulos']) && $ClienteData['modulos'] == 1) echo 'selected="selected"'; ?>>Facturação & Stock</option>
                                            <option value="2" <?php if (isset($ClienteData['modulos']) && $ClienteData['modulos'] == 2) echo 'selected="selected"'; ?>>Restaurantes</option>
                                            <option value="3" <?php if (isset($ClienteData['modulos']) && $ClienteData['modulos'] == 3) echo 'selected="selected"'; ?>>Facturação</option>
                                            <option value="4" <?php if (isset($ClienteData['modulos']) && $ClienteData['modulos'] == 4) echo 'selected="selected"'; ?>>Gestão Mecânica</option>
                                            <option value="5" <?php if (isset($ClienteData['modulos']) && $ClienteData['modulos'] == 5) echo 'selected="selected"'; ?>>Gestão de Patrimonio</option>
                                            <option value="9" <?php if (isset($ClienteData['modulos']) && $ClienteData['modulos'] == 9) echo 'selected="selected"'; ?>>Facturação & Stock + Extras</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3 col-6">
                                    <label class="form-label">Empresas/Negócios</label>
                                    <div class="input-group input-group-flat">
                                        <input type="text" value="<?php if (!empty($ClienteData['empresas'])) echo $ClienteData['empresas']; ?>" class="form-control ps-1" name="empresas" placeholder="Empresas/Negócios">
                                    </div>
                                </div>
                                <div class="mb-3 col-6">
                                    <label class="form-label">Valor Mensal</label>
                                    <div class="input-group input-group-flat">
                                        <input type="text" value="<?php if (!empty($ClienteData['valor'])) echo $ClienteData['valor']; ?>" class="form-control ps-1" name="valor" placeholder="Valor Mensal">
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="btn-list justify-content-end">
                                    <input type="submit" name="SendPostFormL" class="btn btn-primary" value="Salvar">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
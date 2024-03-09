<?php
    $Read = new Read();
    $Read->ExeRead("db_config", "WHERE id_db_settings=:i ", "i={$id_db_settings}");
    if(!$Read->getResult() || !$Read->getRowCount()):
        header("Location: panel.php?exe=settings/System_Settings{$n}");
    endif;
?>
<div class="page-header d-print-none">
    <div class="row align-items-center">
        <div class="col">
            <div class="page-pretitle">
                <?= $Index['name']; ?>
            </div>
            <h2 class="page-title">
                Folha de obra
            </h2>
        </div>
        <div class="col-auto ms-auto d-print-none">
            <div class="btn-list">
                <a href="javascript:void" class="btn btn-primary d-none d-sm-inline-block" onclick="ReadDocuments(<?= $id_db_settings.", ".$id_user;  ?>)" data-bs-toggle="modal" data-bs-target="#ModalDefault">
                    Documentos
                </a>
                <a href="javascript:void()" onclick="WhatsApp(<?= $id_db_settings;  ?>)" class="btn btn-default d-none d-sm-inline-block" data-bs-toggle="modal" data-bs-target="#ModalDefault">
                    Adicionar Itens
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row row-cards">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5 class="modal-title">Emissão de documentos comercial</h5>
            </div>
            <div class="card-body" id="RealNigga">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <span>Cliente</span>
                        <select class="form-control" id="id_cliente" onclick="SelectVeiculos()" onselect="SelectVeiculos()" onchange="SelectVeiculos()">
                            <?php
                            $Read = new Read();
                            $Read->ExeRead("cv_customer", "WHERE id_db_settings=:i ORDER BY id ASC ", "i={$id_db_settings}");

                            if($Read->getResult()):
                                foreach ($Read->getResult() as $item):
                                    ?>
                                    <option value="<?= $item['id']; ?>" <?php if(isset($ClienteData['id_cliente']) && $ClienteData['id_cliente'] == $item['id']) echo "selected";  ?>><?= $item['nome']; ?></option>
                                <?php
                                endforeach;
                            endif;
                            ?>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <span>Veiculo</span>
                        <select class="form-control" id="id_veiculo" name="id_veiculo" onclick="SelectPlaca()" onselect="SelectPlaca()" onchange="SelectPlaca()">
                        </select>
                        <input type="hidden" id="kilometragem" name="kilometragem"/>
                        <input type="hidden" id="fo_data_entrada" name="fo_data_entrada"/>
                    </div>
                    <div class="col-md-3 mb-3">
                        <span>Matricula</span>
                        <input type="text" disabled class="form-control" id="matricula" name="matricula">
                    </div>
                    <div class="col-md-3 mb-3">
                        <span>Mêcanico</span>
                        <select class="form-control" id="id_mecanico" name="id_mecanico">
                            <?php
                            if($userlogin['level'] == 1):
                                ?>
                                <option value="<?= $userlogin['id']; ?>" <?php if(isset($ClienteData['id_mecanico']) && $ClienteData['id_mecanico'] == $userlogin['id']) echo "selected";  ?>><?= $userlogin['name']; ?></option>
                            <?php
                            else:
                                $lv = 1;
                                $Read = new Read();
                                $Read->ExeRead("db_users", "WHERE id_db_settings=:i AND level=:lv ORDER BY id ASC ", "i={$id_db_settings}&lv={$lv}");
                                if($Read->getResult()):
                                    foreach ($Read->getResult() as $item):
                                        ?>
                                        <option value="<?= $item['id']; ?>" <?php if(isset($ClienteData['id_mecanico']) && $ClienteData['id_mecanico'] == $item['id']) echo "selected";  ?>><?= $item['name']; ?></option>
                                    <?php
                                    endforeach;
                                endif;
                            endif;
                            ?>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-6">
                        <span>Descrição do Problema</span>
                        <textarea name="fo_problema" id="fo_problema" class="form-control"><?php if(isset($ClienteData['fo_problema'])) echo $ClienteData['fo_problema']; ?></textarea>
                    </div>
                    <div class="col-md-6 mb-6">
                        <span>Laudo Técnico</span>
                        <textarea name="fo_laudo" id="fo_laudo" class="form-control"><?php if(isset($ClienteData['fo_laudo'])) echo $ClienteData['fo_laudo']; ?></textarea>
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-md-12 mb-6">
                        <span>Observações</span>
                        <textarea name="fo_observacoes" id="fo_observacoes" class="form-control"><?php if(isset($ClienteData['fo_observacoes'])) echo $ClienteData['fo_observacoes']; ?></textarea>
                    </div>
                </div>
                <br/>
                <div class="table-responsive" id="RealNiggaII">
                    <?php require_once("_disk/AppFiles/list_itens_of.inc.php"); ?>
                </div>

                <div class="form-row">
                    <div class="col-md-5 mb-3">
                        <input type="hidden" id="document" value="FO"/>
                        <button type="submit" class="btn btn-primary" onclick="FinishII(<?= $id_db_settings; ?>)">Salvar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
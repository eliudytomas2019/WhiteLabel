<?php
if(!class_exists('login')):
    header("index.php");
    die();
endif;

if($level >= 4): $n =  '&id_db_settings='.$id_db_settings; else: $n = null; endif;

if($userlogin['level'] < 3):
    header("Location: painel.php?exe=default/index".$n);
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
                <h5 class="modal-title">Dados da empresa</h5>
            </div>
            <div class="card-body">
                <div id="StayStrong"></div>
                <form method="post" action="#StayStrong" name="form_settings_update" enctype="multipart/form-data">
                    <?php
                    $ClienteData = filter_input(INPUT_POST, FILTER_DEFAULT);
                    $read = new Read();
                    $read->ExeRead("db_settings", "WHERE id=:id AND id_db_kwanzar=:io", "id={$id_db_settings}&io={$id_db_kwanzar}");

                    if($read->getResult()):
                        $ClienteData = $read->getResult()[0];
                    else:
                        unset($_SESSION['userlogin']);
                        header('Location: index.php?exe=restrito');
                    endif;
                    ?>
                    <div class="row">
                        <div class="col">
                            <label class="form-label">Empresa</label>
                            <input type="text" class="form-control" name="empresa" id="empresa" value="<?php if (!empty($ClienteData['empresa'])) echo $ClienteData['empresa']; ?>" placeholder="Empresa"/>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <label class="form-label">NIF</label>
                            <input type="text" class="form-control" name="nif" id="nif" value="<?php if (!empty($ClienteData['nif'])) echo $ClienteData['nif']; ?>" placeholder="NIF"/>
                        </div>

                        <div class="col">
                            <label class="form-label">Email</label>
                            <input type="text" name="email" id="email" class="form-control" value="<?php if(!empty($ClienteData['email'])) echo $ClienteData['email']; ?>" placeholder="email">
                        </div>
                    </div>

                    <br/>
                    <div class="row">
                        <div class="col">
                            <label class="form-label">Telefone</label>
                            <input type="text" class="form-control" name="telefone" id="telefone" value="<?php if (!empty($ClienteData['telefone'])) echo $ClienteData['telefone']; ?>" placeholder="Telefone"/>
                        </div>
                        <div class="col">
                            <label class="form-label">Endereço</label>
                            <input type="text" class="form-control" name="endereco" id="endereco" value="<?php if (!empty($ClienteData['endereco'])) echo $ClienteData['endereco']; ?>" placeholder="Endereço"/>
                        </div>
                    </div>
                    <br/>
                    <div class="row">
                        <div class="col">
                            <label class="form-label">Website</label>
                            <input type="text" class="form-control" name="website" id="website" value="<?php if (!empty($ClienteData['website'])) echo $ClienteData['website']; ?>" placeholder="Website"/>
                        </div>

                            <div class="col">
                                <label class="form-label">Módulos</label>
                                <select id="atividade" name="atividade" class="form-control">
                                    <option value="1" <?php if (isset($ClienteData['atividade']) && $ClienteData['atividade'] == 1) echo 'selected="selected"'; ?>>Facturação & Stock</option>
                                    <option value="19" <?php if (isset($ClienteData['atividade']) && $ClienteData['atividade'] == 19) echo 'selected="selected"'; ?>>Gestão Clínica</option>
                                </select>
                            </div>

                    </div>
                    <br/>
                    <div class="row">
                        <!--- div class="col">
                            <label class="form-label">Rodapé da factura</label>
                            <input type="text" class="form-control" name="makeUp" id="makeUp" value="<?php if (!empty($ClienteData['makeUp'])) echo $ClienteData['makeUp']; ?>" placeholder="Rodapé da factura"/>
                        </div--->
                    </div>
                    <hr/>
                    <div class="row">
                        <div class="col"><button type="submit" name="btb" class="btn btn-primary">Salvar dados</button></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
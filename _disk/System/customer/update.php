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
                <a href="panel.php?exe=customer/index<?= $n; ?>" class="btn btn-primary">
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
                Clientes
            </h2>
        </div>
    </div>
</div>

<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h5 class="modal-title">Atualizar ficha de cliente</h5>
        </div>
        <div class="card-body">
            <form  method="post" action="" name = "SendPostForm"  enctype="multipart/form-data">
                <div class="card-body">
                    <div class="mb-3"><div id="getResult">
                            <?php
                                $ClienteData = filter_input_array(INPUT_POST, FILTER_DEFAULT);
                                $userId = filter_input(INPUT_GET, 'postid', FILTER_VALIDATE_INT);
                                if ($ClienteData && $ClienteData['SendPostForm']):
                                    $logoty['logotype'] = ($_FILES['logotype']['tmp_name'] ? $_FILES['logotype'] : null);
                                    $Count = new Customer;
                                    $Count->ExeUpdate($userId, $logoty, $ClienteData, $id_db_settings);

                                    if($Count->getResult()):
                                        WSError($Count->getError()[0], $Count->getError()[1]);

                                        $ReadUser = new Read;
                                        $ReadUser->ExeRead("cv_customer", "WHERE id = :userid AND id_db_settings=:i", "userid={$userId}&i={$id_db_settings}");
                                        if ($ReadUser->getResult()):
                                            $ClienteData = $ReadUser->getResult()[0];
                                        endif;
                                    else:
                                        WSError($Count->getError()[0], $Count->getError()[1]);
                                    endif;
                                else:
                                    $ReadUser = new Read;
                                    $ReadUser->ExeRead("cv_customer", "WHERE id = :userid AND id_db_settings=:i", "userid={$userId}&i={$id_db_settings}");
                                    if (!$ReadUser->getResult()):

                                    else:
                                        $ClienteData = $ReadUser->getResult()[0];
                                    endif;
                                endif;
                            ?>
                        </div></div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Cliente</label>
                                <input name="nome" id="nome" class="form-control" placeholder="Cliente"  value="<?php if (!empty($ClienteData['nome'])) echo $ClienteData['nome']; ?>" type="text">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Logotipo</label>
                                <input type="file" name="logotype" class="form-control" placeholder="" value="">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <?php if($ClienteData['nif'] == "999999999" || $ClienteData['nif'] == null): ?>
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label class="form-label">NIF</label>
                                    <input type="text" id="nif"  class="form-control " placeholder="NIF" name="nif" value="<?php if (!empty($ClienteData['nif'])) echo $ClienteData['nif']; ?>">
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label class="form-label">NIF</label>
                                    <input type="text" id="nif" disabled  class="form-control " placeholder="NIF" name="nif" value="<?php if (!empty($ClienteData['nif'])) echo $ClienteData['nif']; ?>">
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label class="form-label">Telefone</label>
                                <input type="text" id="telefone" class="form-control" placeholder="Telefone" name="telefone" value="<?php if (!empty($ClienteData['telefone'])) echo $ClienteData['telefone']; ?>">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label class="form-label">E-mail</label>
                                <input type="email" id="email" class="form-control " placeholder="Telefone" name="email" value="<?php if (!empty($ClienteData['email'])) echo $ClienteData['email']; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label class="form-label">Endereço</label>
                                <input type="text"  id="endereco" class="form-control " placeholder="Endereço" name="endereco" value="<?php if (!empty($ClienteData['endereco'])) echo $ClienteData['endereco']; ?>">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label class="form-label">Província</label>
                                <select name="city" id="city" class="form-control">
                                    <option value="Bengo"  <?php if (isset($ClienteData['city']) && $ClienteData['city'] == 'Bengo') echo 'selected="selected"'; ?>>Bengo</option>
                                    <option value="Benguela"  <?php if (isset($ClienteData['city']) && $ClienteData['city'] == 'Benguela') echo 'selected="selected"'; ?>>Benguela</option>
                                    <option value="Bié"  <?php if (isset($ClienteData['city']) && $ClienteData['city'] == 'Bié') echo 'selected="selected"'; ?>>Bié</option>
                                    <option value="Cabinda"  <?php if (isset($ClienteData['city']) && $ClienteData['city'] == 'Cabinda') echo 'selected="selected"'; ?>>Cabinda</option>
                                    <option value="Cuando Cubango"  <?php if (isset($ClienteData['city']) && $ClienteData['city'] == 'Cuando Cubango') echo 'selected="selected"'; ?>>Cuando Cubango</option>
                                    <option value="Cunene"  <?php if (isset($ClienteData['city']) && $ClienteData['city'] == 'Cunene') echo 'selected="selected"'; ?>>Cunene</option>
                                    <option value="Huambo"  <?php if (isset($ClienteData['city']) && $ClienteData['city'] == 'Huambo') echo 'selected="selected"'; ?>>Huambo</option>
                                    <option value="Huíla"  <?php if (isset($ClienteData['city']) && $ClienteData['city'] == 'Huíla') echo 'selected="selected"'; ?>>Huíla</option>
                                    <option value="Kwanza Sul"  <?php if (isset($ClienteData['city']) && $ClienteData['city'] == 'Kwanza Sul') echo 'selected="selected"'; ?>>Kwanza Sul</option>
                                    <option value="Kwanza Norte"  <?php if (isset($ClienteData['city']) && $ClienteData['city'] == 'Kwanza Norte') echo 'selected="selected"'; ?>>Kwanza Norte</option>
                                    <option value="Kwanza Norte"  <?php if (isset($ClienteData['city']) && $ClienteData['city'] == 'Kwanza Norte') echo 'selected="selected"'; ?>>Kwanza Norte</option>
                                    <option value="Luanda" selected <?php if (isset($ClienteData['city']) && $ClienteData['city'] == 'Luanda') echo 'selected="selected"'; ?>>Luanda</option>
                                    <option value="Lunda Norte"  <?php if (isset($ClienteData['city']) && $ClienteData['city'] == 'Lunda Norte') echo 'selected="selected"'; ?>>Lunda Norte</option>
                                    <option value="Lunda Sul"  <?php if (isset($ClienteData['city']) && $ClienteData['city'] == 'Lunda Sul') echo 'selected="selected"'; ?>>Lunda Sul</option>
                                    <option value="Malanje"  <?php if (isset($ClienteData['city']) && $ClienteData['city'] == 'Malanje') echo 'selected="selected"'; ?>>Malanje</option>
                                    <option value="Moxico"  <?php if (isset($ClienteData['city']) && $ClienteData['city'] == 'Moxico') echo 'selected="selected"'; ?>>Moxico</option>
                                    <option value="Namibe"  <?php if (isset($ClienteData['city']) && $ClienteData['city'] == 'Namibe') echo 'selected="selected"'; ?>> Namibe</option>
                                    <option value="Uíge"  <?php if (isset($ClienteData['city']) && $ClienteData['city'] == 'Uíge') echo 'selected="selected"'; ?>>Uíge</option>
                                    <option value="Zaire"  <?php if (isset($ClienteData['city']) && $ClienteData['city'] == 'Zaire') echo 'selected="selected"'; ?>>Zaire</option>
                                </select>

                            </div>
                        </div>


                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label class="form-label">Tipo de cadastro</label>
                                <select name="type" id="type" class="form-control">
                                    <option value="Pessoa Física" <?php if (isset($ClienteData['type']) && $ClienteData['type'] == 'Pessoa Física') echo 'selected="selected"'; ?>>Pessoa Física</option>
                                    <option value="Pessoa Jurídica" <?php if (isset($ClienteData['type']) && $ClienteData['type'] == 'Pessoa Jurídica') echo 'selected="selected"'; ?>>Pessoa Jurídica</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Observações</label>
                                    <textarea name="obs" id="obs" class="form-control" placeholder="Observações"><?php if (!empty($ClienteData['obs'])) echo $ClienteData['obs']; ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" name="SendPostForm" class="btn btn-primary ms-auto" value="Salvar"/>
                </div>
            </form>
        </div>
    </div>
</div>
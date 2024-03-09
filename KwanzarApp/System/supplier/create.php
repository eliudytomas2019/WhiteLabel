<?php

if(!class_exists('login')):
    header("index.php");
    die();
endif;

if($level >= 4): $n =  '&id_db_settings='.$id_db_settings; else: $n = null; endif;

if($userlogin['level'] < 2):
    header("location: panel.php?exe=default/index".$n);
endif;

?>
<div class="row page-titles mx-0">
    <div class="col p-md-0">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= HOME; ?>panel.php?exe=default/home<?php if($level >= 4): echo '&id_db_settings='.$id_db_settings; endif; ?>">  <?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Painel de controle"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "控制面板"; endif; ?></a></li>
            <li class="breadcrumb-item active"><a href="<?= HOME; ?>panel.php?exe=supplier/index<?php if($level >= 4): echo '&id_db_settings='.$id_db_settings; endif; ?>"><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Fornecedores"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "供应商"; endif; ?></a></li>
        </ol>
    </div>
</div>

<div class="container-fluid">
    <div id="styles">
        <a href="<?= HOME; ?>panel.php?exe=supplier/index<?= $n; ?>" class="btn btn-primary btn-sm">
            <span class="text"><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Voltar"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "回传"; endif; ?></span>
        </a>&nbsp;
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title"> <?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "CRIAR NOVO FORNECEDOR"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "创建一个新的供应商"; endif; ?></h4>
                    <div class="basic-form">
                        <form class="form-horizontal" method="post" action="" name = "SendPostForm"  enctype="multipart/form-data">
                            <?php
                            $ClienteData = filter_input_array(INPUT_POST, FILTER_DEFAULT);
                            if ($ClienteData && $ClienteData['SendPostForm']):

                                $logoty['logotype'] = ($_FILES['logotype']['tmp_name'] ? $_FILES['logotype'] : null);
                                $Count = new Supplier();
                                $Count->ExeCreate($logoty, $ClienteData, $id_db_settings);

                                if($Count->getResult()):
                                    WSError($Count->getError()[0], $Count->getError()[1]);
                                else:
                                    WSError($Count->getError()[0], $Count->getError()[1]);
                                endif;
                            endif;
                            ?>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input name="nome" class="form-control" placeholder="<?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Fornecedor"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "供应商"; endif; ?>"  value="<?php if (!empty($ClienteData['nome'])) echo $ClienteData['nome']; ?>" type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <input type="text"  class="form-control " placeholder="NIF" name="nif" value="<?php if (!empty($ClienteData['nif'])) echo $ClienteData['nif']; ?>">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="<?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "TELEFONE"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "电话 "; endif; ?>" name="telefone" value="<?php if (!empty($ClienteData['telefone'])) echo $ClienteData['telefone']; ?>">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <input type="email" class="form-control " placeholder="<?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "E-MAIL"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "电子邮件"; endif; ?>" name="email" value="<?php if (!empty($ClienteData['email'])) echo $ClienteData['email']; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <input type="text" name="addressDetail" class="form-control" value="<?php if (!empty($ClienteData['addressDetail'])) echo $ClienteData['addressDetail']; ?>" placeholder="<?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Endereço Detalhes"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "地址详细信息"; endif; ?>">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <input type="text" name="city" class="form-control" value="<?php if (!empty($ClienteData['city'])) echo $ClienteData['city']; ?>" placeholder="<?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Cidade"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "城市"; endif; ?>">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <input type="text" name="country" class="form-control" value="<?php if (!empty($ClienteData['country'])) echo $ClienteData['country']; ?>" placeholder="<?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "País"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "国家"; endif; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <input type="text"  class="form-control " placeholder="<?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Endereço"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "地址"; endif; ?>" name="endereco" value="<?php if (!empty($ClienteData['endereco'])) echo $ClienteData['endereco']; ?>">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <input type="file" name="logotype" class="form-control" placeholder="" value="">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <select name="type" class="form-control">
                                            <option><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Selecione o Tipo de Cliente"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "选择客户端类型"; endif; ?></option>
                                            <option value="Pessoa Física" <?php if (isset($ClienteData['type']) && $ClienteData['type'] == 'Pessoa Física') echo 'selected="selected"'; ?>><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Pessoa Física"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "物理人"; endif; ?></option>
                                            <option value="Pessoa Jurídica" <?php if (isset($ClienteData['type']) && $ClienteData['type'] == 'Pessoa Jurídica') echo 'selected="selected"'; ?>><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Pessoa Jurídica"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "法人"; endif; ?></option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <textarea name="obs" class="form-control" placeholder="<?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Observações"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "观察"; endif; ?>"><?php if (!empty($ClienteData['obs'])) echo $ClienteData['obs']; ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-10">
                                    <input type="submit" name="SendPostForm" class="btn btn-primary btn-sm" value="<?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Registrar"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "注册"; endif; ?>"/>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
/**
 * Created by PhpStorm.
 * User: Kwanzar Soft
 * Date: 16/05/2020
 * Time: 01:41
 */

if(!class_exists('login')):
    header("index.php");
    die();
endif;

if($level >= 4): $n =  '&id_db_settings='.$id_db_settings; else: $n = null; endif;

if($userlogin['level'] < 1):
    header("location: panel.php?exe=default/index".$n);
endif;
?>
<div class="row page-titles mx-0">
    <div class="col p-md-0">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= HOME; ?>panel.php?exe=default/home<?php if($level >= 4): echo '&id_db_settings='.$id_db_settings; endif; ?>"><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Painel de controle"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "控制面板"; endif; ?></a></li>
            <li class="breadcrumb-item active"><a href="<?= HOME; ?>panel.php?exe=customer/index<?php if($level >= 4): echo '&id_db_settings='.$id_db_settings; endif; ?>"><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Clientes"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "客户端"; endif; ?></a></li>
        </ol>
    </div>
</div>

<div class="container-fluid">
    <div id="styles">
        <a href="<?= HOME; ?>panel.php?exe=customer/index<?= $n; ?>" class="btn btn-primary btn-icon-split btn-sm">
            <span class="text"><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Voltar"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "回传"; endif; ?></span>
        </a>&nbsp;
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Atualizar dados do Cliente</h4>
                    <div class="basic-form">
                        <form class="form-horizontal" method="post" action="" name = "SendPostForm"  enctype="multipart/form-data">
                            <?php
                            $ClienteData = filter_input_array(INPUT_POST, FILTER_DEFAULT);
                            $userId = filter_input(INPUT_GET, 'postid', FILTER_VALIDATE_INT);
                            if ($ClienteData && $ClienteData['SendPostForm']):

                                $logoty['logotype'] = ($_FILES['logotype']['tmp_name'] ? $_FILES['logotype'] : null);
                                $Count = new Customer;
                                $Count->ExeUpdate($userId, $logoty, $ClienteData, $id_db_settings);

                                if($Count->getResult()):
                                    WSError($Count->getError()[0], $Count->getError()[1]);
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

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <span><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Clientes"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "客户端"; endif; ?></span>
                                        <input name="nome" class="form-control" placeholder="<?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Clientes"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "客户端"; endif; ?>"  value="<?php if (!empty($ClienteData['nome'])) echo $ClienteData['nome']; ?>" type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <?php if($ClienteData['nif'] == '999999999' || $ClienteData['nif'] == '' || $ClienteData['nif'] == null): ?>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <span>* NIF (Caso não tenha, deixe em branco)</span>
                                            <input type="text"  class="form-control " placeholder="NIF" name="nif" value="<?php if (!empty($ClienteData['nif'])) echo $ClienteData['nif']; ?>">
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <span><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "TELEFONE"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "电话 "; endif; ?></span>
                                        <input type="text" class="form-control" placeholder="<?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "TELEFONE"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "电话 "; endif; ?>" name="telefone" value="<?php if (!empty($ClienteData['telefone'])) echo $ClienteData['telefone']; ?>">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <span><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "E-MAIL"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "电子邮件"; endif; ?></span>
                                        <input type="email" class="form-control " placeholder="<?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "E-MAIL"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "电子邮件"; endif; ?>" name="email" value="<?php if (!empty($ClienteData['email'])) echo $ClienteData['email']; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <span><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Endereço"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "地址"; endif; ?></span>
                                        <input type="text"  class="form-control " placeholder="<?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Endereço"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "地址"; endif; ?>" name="endereco" value="<?php if (!empty($ClienteData['endereco'])) echo $ClienteData['endereco']; ?>">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <span>Logotipo [imagem .jpg ou .png]</span>
                                        <input type="file" name="logotype" class="form-control" placeholder="" value="">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <span><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo " Tipo de Cliente"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "客户类型"; endif; ?></span>
                                        <select name="type" class="form-control">
                                            <option><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Selecione o Tipo de Cliente"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "选择客户端类型"; endif; ?></option>
                                            <option value="Pessoa Física" <?php if (isset($ClienteData['type']) && $ClienteData['type'] == 'Pessoa Física') echo 'selected="selected"'; ?>><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Pessoa Física"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "物理人"; endif; ?></option>
                                            <option value="Pessoa Jurídica" <?php if (isset($ClienteData['type']) && $ClienteData['type'] == 'Pessoa Jurídica') echo 'selected="selected"'; ?>><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Pessoa Jurídica"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "法人"; endif; ?></option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <span><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Endereço Detalhes"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "地址详细信息"; endif; ?></span>
                                        <input type="text" name="addressDetail" class="form-control" value="<?php if (!empty($ClienteData['addressDetail'])) echo $ClienteData['addressDetail']; ?>" placeholder="<?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Endereço Detalhes"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "地址详细信息"; endif; ?>">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <span><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Cidade"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "城市"; endif; ?></span>
                                        <input type="text" name="city" class="form-control" value="<?php if (!empty($ClienteData['city'])) echo $ClienteData['city']; ?>" placeholder="<?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Cidade"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "城市"; endif; ?>">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <span><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "País Exemplo: AO, PT, BR..."; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "国家例如"; endif; ?></span>
                                        <select name="country" id="country" class="form-control">
                                            <option value="AO" selected <?php if (isset($ClienteData['country']) && $ClienteData['country'] == 'AO') echo 'selected="selected"'; ?>>Angola</option>
                                            <option value="BR" <?php if (isset($ClienteData['country']) && $ClienteData['country'] == 'BR') echo 'selected="selected"'; ?>>Brasil</option>
                                            <option value="PT" <?php if (isset($ClienteData['country']) && $ClienteData['country'] == 'PT') echo 'selected="selected"'; ?>>Portugual</option>
                                            <option value="EUA" <?php if (isset($ClienteData['country']) && $ClienteData['country'] == 'EUA') echo 'selected="selected"'; ?>>Estados unidos da America</option>
                                            <option value="MZ" <?php if (isset($ClienteData['country']) && $ClienteData['country'] == 'MZ') echo 'selected="selected"'; ?>>Moçambique</option>
                                            <option value="CV" <?php if (isset($ClienteData['country']) && $ClienteData['country'] == 'CV') echo 'selected="selected"'; ?>>Cabo verde</option>
                                            <option value="ST" <?php if (isset($ClienteData['country']) && $ClienteData['country'] == 'ST') echo 'selected="selected"'; ?>>São tome e príncipe</option>
                                            <option value="OUT" <?php if (isset($ClienteData['country']) && $ClienteData['country'] == 'OUT') echo 'selected="selected"'; ?>>Outros</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <span><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Observações"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "观察"; endif; ?></span>
                                        <textarea name="obs" class="form-control" placeholder="<?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Observações"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "观察"; endif; ?>"><?php if (!empty($ClienteData['obs'])) echo $ClienteData['obs']; ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <hr/>
                            <div class="form-group row">
                                <div class="col-sm-10">
                                    <input type="submit" name="SendPostForm" class="btn btn-primary btn-sm" value="Atualizar dados"/>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


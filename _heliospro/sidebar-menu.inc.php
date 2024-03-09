<?php
/**
 * Created by PhpStorm.
 * User: Kwanzar Soft
 * Date: 04/06/2020
 * Time: 23:54
 */
?>
<div class="sidebar sidebar-style-2">
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <div class="user">
                <div class="avatar-sm float-left mr-2">
                    <img src="<?= HOME; ?>uploads/<?php if($userlogin['cover'] != null || $userlogin['cover'] != ''): echo $userlogin['cover']; else: echo 'user.png'; endif; ?>" alt="..." class="avatar-img rounded-circle">
                </div>
                <div class="info">
                    <a data-toggle="collapse" href="#collapseExample" aria-expanded="true">
                        <span>
                            <?php
                                $lv = ["", "Usuário", "Gestor", "Administrador", "Root", "Desenvolvidor"];
                                $name = explode(" ", $userlogin['name']);
                            ?>
                            <?= $name[0]." ".end($name); ?>
                            <span class="user-level"><?= $lv[$userlogin['level']]; ?></span>
                            <span class="caret"></span>
                        </span>
                    </a>
                    <div class="clearfix"></div>



                    <div class="collapse in" id="collapseExample">
                        <ul class="nav">
                            <li>
                                <a href="<?= HOME; ?>panel.php?exe=users/profile<?php if($level >= 4): echo '&id_db_settings='.$id_db_settings; endif; ?>">
                                    <span class="link-collapse">Meu perfil</span>
                                </a>
                            </li>
                            <?php if($level >= 4 || $level == 3): ?>
                                <li>
                                    <a href="<?= HOME; ?>panel.php?exe=settings/index<?php if($level >= 4): echo '&id_db_settings='.$id_db_settings; endif; ?>">
                                        <span class="link-collapse">Definições</span>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
            <ul class="nav nav-primary">
                <li class="nav-item li<?php if (in_array('default', $linkto)) echo ' active';  ?>">
                    <a href="<?= HOME; ?>panel.php?exe=default/home<?= $n; ?>" >
                        <i class="fas fa-home"></i>
                        <p>Resumo comercial</p>
                    </a>
                </li>

                <li class="nav-item li<?php if(in_array('supplier', $linkto)) echo ' active'; elseif(in_array('users', $linkto)) echo ' active'; elseif(in_array('mesas', $linkto)) echo ' active';  elseif(in_array('customer', $linkto)) echo ' active';  ?>">
                    <a data-toggle="collapse" href="#formsAllOveYou">
                        <i class="fas fa-edit"></i>
                        <p>Cadastro</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="formsAllOveYou">
                        <ul class="nav nav-collapse">
                            <?php if($level >= 3): ?>
                                <li><a href="<?= HOME; ?>panel.php?exe=users/index<?= $n; ?>"><span class="sub-item"><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Usuários"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "Usuários ()"; endif; ?> </span></a></li>
                            <?php endif; ?>
                            <?php if($DB->CheckCpanelAndSettings($id_db_settings, $id_db_kwanzar)['atividade'] == 2): ?>
                                <li>
                                    <a href="<?= HOME; ?>panel.php?exe=mesas/index<?= $n; ?>">
                                        <span class="sub-item">Mesas</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= HOME; ?>panel.php?exe=garcom/index<?= $n; ?>">
                                        <span class="sub-item">Garçom</span>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <!---li>
                                <a href="javascript:void()"  data-toggle="modal" data-target="#customer">
                                    <span class="sub-item">Criar novo cliente</span>
                                </a>
                            </li---->
                            <li>
                                <a href="<?= HOME; ?>panel.php?exe=customer/index<?= $n; ?>">
                                    <span class="sub-item"><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Clientes"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "客户管理"; endif; ?></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <?php if($userlogin['level'] >= 2): ?>
                    <li class="nav-item li<?php if (in_array('purchase', $linkto)) echo ' active'; elseif(in_array('product', $linkto)) echo ' active'; elseif(in_array('category', $linkto)) echo ' active'; ?>">
                        <a data-toggle="collapse" href="#formsOne">
                            <i class="fas fa-dolly"></i>
                            <p><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Produtos & Estoque"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "产品/股票"; endif; ?></p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse" id="formsOne">
                            <ul class="nav nav-collapse">
                                <li>
                                    <a href="<?= HOME; ?>panel.php?exe=category/index<?= $n; ?>">
                                        <span  class="sub-item"><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Categorias"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "类别"; endif; ?></span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= HOME; ?>panel.php?exe=product/index<?= $n; ?>">
                                        <span class="sub-item"><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Produtos/Serviços"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "产品/服务"; endif; ?></span>
                                    </a>
                                </li>
                                <!---li>
                                    <a href="<?= HOME; ?>panel.php?exe=purchase/index<?= $n; ?>">
                                        <span class="sub-item"><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Gestão de Estoque"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "股票"; endif; ?></span>
                                    </a>
                                </li---->
                                <li>
                                    <a data-toggle="collapse" href="#subnav1">
                                        <span class="sub-item"><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Relatórios"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "报告"; endif; ?></span>
                                        <span class="caret"></span>
                                    </a>
                                    <div class="collapse" id="subnav1">
                                        <ul class="nav nav-collapse subnav">
                                            <li>
                                                <a href="<?= HOME; ?>panel.php?exe=invoice/alert<?= $n; ?>">
                                                    <span class="sub-item"><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Inventário de Estoque"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "库存库存"; endif; ?></span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?= HOME; ?>panel.php?exe=invoice/warning<?= $n; ?>">
                                                    <span class="sub-item"><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Inventário da Loja"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "商店库存"; endif; ?></span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </li>
                <?php endif; ?>

                <?php if($DB->CheckCpanelAndSettings($id_db_settings, $id_db_kwanzar)['atividade'] == 2): ?>
                    <li class="nav-item">
                        <a href="<?= HOME; ?>Res.php?<?= $n; ?>">
                            <i class="fas fa-shopping-cart"></i>
                            <p>PDV</p>
                        </a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a href="<?= HOME; ?>Pos.php?<?= $n; ?>">
                            <i class="fas fa-store-alt"></i>
                            <p><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "POS"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "结算"; endif; ?></p>
                        </a>
                    </li>
                <?php endif; ?>

                <?php if($level >= 4 || $level == 3): ?>
                    <li class="nav-item li<?php if (in_array('settings', $linkto)) echo ' active'; elseif(in_array('taxtable', $linkto)) echo ' active';  ?>">
                        <a data-toggle="collapse" href="#sidebarLayouts">
                            <i class="fas fa-cogs"></i>
                            <p><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Configurações"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "定义"; endif; ?></p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse" id="sidebarLayouts">
                            <ul class="nav nav-collapse">
                                <li><a href="<?= HOME; ?>panel.php?exe=settings/index<?= $n; ?>"><span class="sub-item"><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Definições"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "定义"; endif; ?></span></a></li>
                                <?php if($Config->CheckLicence($userlogin['id_db_kwanzar'])['ps3'] != 1): ?>
                                    <li><a href="<?= HOME; ?>panel.php?exe=taxtable/taxtable<?= $n; ?>"><span class="sub-item"><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Taxa de Impostos"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "税率"; endif; ?></span></a></li>
                                <?php endif; ?>
                                <li><a href="<?= HOME; ?>panel.php?exe=settings/active/index<?= $n; ?>"><span class="sub-item">Motivo de documentos de retificação</span></a></li>
                                <?php if($level >= 4): ?>
                                    <li><a href="<?= HOME; ?>panel.php?exe=settings/active<?= $n; ?>"><span class="sub-item">Histórico de actividades</span></a></li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</div>

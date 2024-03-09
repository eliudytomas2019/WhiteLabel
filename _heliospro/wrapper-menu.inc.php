<?php
/**
 * Created by PhpStorm.
 * User: Kwanzar Soft
 * Date: 04/06/2020
 * Time: 23:18
 */

if($level >= 4): $n =  '&id_db_settings='.$id_db_settings; $gp = $id_db_settings; else: $n = null; $gp = null; endif;

?>
<div class="main-header">
    <!-- Logo Header -->
    <div class="logo-header" style="background: #b72025!important;">
        <a href="<?= HOME; ?>panel.php?exe=default/home<?= $n; ?>">
            <img src="images/logotype.png" class="brand-logotype">
        </a>
        <button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse" data-target="collapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon">
                <i class="icon-menu"></i>
            </span>
        </button>
        <button class="topbar-toggler more"><i class="icon-options-vertical"></i></button>
        <div class="nav-toggle">
            <button class="btn btn-toggle <?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['positionMenu'] == 1): echo "toggle-sidebar"; else: echo "sidenav-overlay-toggler"; endif; ?>">
                <i class="icon-menu"></i>
            </button>
        </div>
    </div>

    <nav class="navbar navbar-header navbar-expand-lg" style="background: #b72025!important;">
        <div class="container-fluid">
            <div class="collapse" id="search-nav">
                <form class="navbar-left navbar-form nav-search mr-md-3" method="get" action="search.php">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <button type="submit" class="btn btn-search pr-1">
                                <i class="fa fa-search search-icon"></i>
                            </button>
                        </div>
                        <input type="text" name="h" value="<?php if(isset($h) && !empty($h)): echo $h; endif; ?>" placeholder="Procurar..." class="form-control">
                        <input type="hidden" name="id_db_settings" value="<?= $gp; ?>"/>
                    </div>
                </form>
            </div>

            <ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
                <li class="nav-item dropdown hidden-caret" id="All-msg">
                    <?php require_once("_heliospro/all-msg.inc.php"); ?>
                </li>

                <li class="nav-item dropdown hidden-caret">
                    <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
                        <i class="fas fa-layer-group"></i>
                    </a>
                    <div class="dropdown-menu quick-actions quick-actions-info animated fadeIn">
                        <div class="quick-actions-header">
                            <span class="title mb-1">Funcionalidades</span>
                            <span class="subtitle op-8">Rápida</span>
                        </div>
                        <div class="quick-actions-scroll scrollbar-outer">
                            <div class="quick-actions-items">
                                <div class="row m-0">
                                    <a class="col-6 col-md-4 p-0" href="<?= HOME; ?>Pos.php?<?= $n; ?>">
                                        <div class="quick-actions-item">
                                            <i class="flaticon-file-1"></i>
                                            <span class="text">Nova venda</span>
                                        </div>
                                    </a>
                                    <?php if($level >= 4 || $level == 3): ?>
                                        <a class="col-6 col-md-4 p-0" href="<?= HOME; ?>panel.php?exe=settings/index<?= $n; ?>">
                                            <div class="quick-actions-item">
                                                <i class="flaticon-database"></i>
                                                <span class="text">Definições</span>
                                            </div>
                                        </a>
                                    <?php endif; ?>
                                    <a class="col-6 col-md-4 p-0" href="<?= HOME; ?>panel.php?exe=product/index<?= $n; ?>">
                                        <div class="quick-actions-item">
                                            <i class="flaticon-pen"></i>
                                            <span class="text">Produtos</span>
                                        </div>
                                    </a>
                                    <a class="col-6 col-md-4 p-0" href="<?= HOME; ?>panel.php?exe=customer/index<?= $n; ?>">
                                        <div class="quick-actions-item">
                                            <i class="flaticon-interface-1"></i>
                                            <span class="text">Clientes</span>
                                        </div>
                                    </a>
                                    <?php if($level >= 4 || $level == 3): ?>
                                        <?php if($Config->CheckLicence($userlogin['id_db_kwanzar'])['ps3'] != 1): ?>
                                            <a class="col-6 col-md-4 p-0" href="<?= HOME; ?>panel.php?exe=taxtable/taxtable<?= $n; ?>">
                                                <div class="quick-actions-item">
                                                    <i class="flaticon-list"></i>
                                                    <span class="text">Impostos</span>
                                                </div>
                                            </a>
                                        <?php endif; ?>
                                        <a class="col-6 col-md-4 p-0" href="<?= HOME; ?>panel.php?exe=users/index<?= $n; ?>">
                                            <div class="quick-actions-item">
                                                <i class="flaticon-file"></i>
                                                <span class="text">Usuários</span>
                                            </div>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="nav-item dropdown hidden-caret">
                    <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#" aria-expanded="false">
                        <div class="avatar-sm">
                            <img src="<?= HOME; ?>uploads/<?php if($userlogin['cover'] != null || $userlogin['cover'] != ''): echo $userlogin['cover']; else: echo 'user.png'; endif; ?>" alt="..." class="avatar-img rounded-circle">
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-user animated fadeIn">
                        <div class="dropdown-user-scroll scrollbar-outer">
                            <li>
                                <div class="user-box">
                                    <div class="avatar-lg"><img src="<?= HOME; ?>uploads/<?php if($userlogin['cover'] != null || $userlogin['cover'] != ''): echo $userlogin['cover']; else: echo 'user.png'; endif; ?>" alt="image profile" class="avatar-img rounded"></div>
                                    <div class="u-text">
                                        <?php $name = explode(" ", $userlogin['name']); ?>
                                        <h4><?= $name[0]." ".end($name); ?></h4>
                                        <p class="text-muted"><?= $userlogin['username']; ?></p>
                                        <a href="<?= HOME; ?>panel.php?exe=users/profile<?php if($level >= 4): echo '&id_db_settings='.$id_db_settings; endif; ?>" class="btn btn-xs btn-secondary btn-sm">Perfil</a>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="<?= HOME; ?>panel.php?exe=users/profile<?php if($level >= 4): echo '&id_db_settings='.$id_db_settings; endif; ?>">Perfil de usuário</a>
                                <a class="dropdown-item" href="<?= HOME; ?>password-users.php">Atualizar senha</a>
                                <?php if($level >= 4 || $level == 3): ?>
                                    <a class="dropdown-item" href="<?= HOME; ?>panel.php?exe=settings/index<?php if($level >= 4): echo '&id_db_settings='.$id_db_settings; endif; ?>">Definições e privacidade</a>
                                <?php endif; ?>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="javascript:void" data-toggle="modal" data-target="#UsersConfig">Configurações da conta</a>
                                <?php if($level >= 4):  ?>
                                    <a class="dropdown-item" href="<?= HOME; ?>cPanel.php">Painel de control</a>
                                <?php endif; ?>
                                <a class="dropdown-item" href="<?= HOME; ?>panel.php?exe=default/home<?= $n; ?>&lock=screen">Bloqueio de tela</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="?logoff=true">Terminar sessão</a>
                            </li>
                        </div>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
    <!-- End Navbar -->
</div>

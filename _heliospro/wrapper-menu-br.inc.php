<?php
/**
 * Created by PhpStorm.
 * User: Kwanzar Soft
 * Date: 01/10/2020
 * Time: 21:30
 */
?>
<div class="main-header">
    <div class="logo-header" style="background: #b72025!important;">
        <a href="<?= HOME; ?>Br.inc.php">
            <img src="images/logotype.png" class="brand-logotype">
        </a>
        <button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse" data-target="collapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon">
                <i class="icon-menu"></i>
            </span>
        </button>
        <button class="topbar-toggler more"><i class="icon-options-vertical"></i></button>
        <div class="nav-toggle">
            <button class="btn btn-toggle toggle-sidebar">
                <i class="icon-menu"></i>
            </button>
        </div>
    </div>

    <nav class="navbar navbar-header navbar-expand-lg" style="background: #b72025!important;">
        <div class="container-fluid">
            <ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
                <li class="nav-item dropdown hidden-caret">
                    <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#" aria-expanded="false">
                        <div class="avatar-sm">
                            <img src="<?= HOME; ?>uploads/<?php if($userlogin['cover'] != null || $userlogin['cover'] != ''): echo $userlogin['cover']; else: echo 'user.png'; endif; ?>" alt="..." class="avatar-img rounded-circle">
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-user animated fadeIn">
                        <div class="dropdown-user-scroll scrollbar-outer">
                            <li>
                                <a class="dropdown-item" href="<?= HOME; ?>password-users.php">Atualizar senha</a>
                                <a class="dropdown-item" href="<?= HOME; ?>cPanel.php">Painel de control</a>
                                <a class="dropdown-item" href="<?= HOME; ?>Br.inc.php?lock=screen">Bloqueio de tela</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="?logoff=true">Terminar sessão</a>
                            </li>
                        </div>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</div>

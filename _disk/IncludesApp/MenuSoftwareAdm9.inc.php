<div class="navbar-expand-md">
    <div class="collapse navbar-collapse" id="navbar-menu">
        <div class="navbar navbar-light" style="background: <?= $Index['color_2']; ?>!important; color: <?= $Index['color_41']; ?>!important;">
            <div class="container-xl">
                <ul class="navbar-nav">
                    <!-- <li class="nav-item li<?php if (in_array('welcome', $linkto)) echo ' active';  ?>"><a href="Admin.php?exe=bemvindo/welcome" style="color: <?= $Index['color_41']; ?>!important;" class="nav-link">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 14h14v-9h-14v16" /></svg> Bem-vindo</a></li> -->

                    <li class="nav-item li<?php if (in_array('default', $linkto)) echo ' active';  ?>"><a href="Admin.php?exe=default/home" style="color: <?= $Index['color_41']; ?>!important;" class="nav-link"><!-- Download SVG icon from http://tabler-icons.io/i/folders -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 4h3l2 2h5a2 2 0 0 1 2 2v7a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-9a2 2 0 0 1 2 -2" /><path d="M17 17v2a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-9a2 2 0 0 1 2 -2h2" /></svg> Empresas que Geres</a></li>

                    <?php if($level != 5 && WSKwanzar::CheckLicence($id_db_kwanzar)['postos'] > DBKwanzar::CheckSettings($id_db_kwanzar)): ?>
                        <li class="nav-item li"><a href="#" style="color: <?= $Index['color_41']; ?>!important;"  data-bs-toggle="modal" data-bs-target="#modal-report" class="nav-link"><!-- Download SVG icon from http://tabler-icons.io/i/file-upload -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" /><line x1="12" y1="11" x2="12" y2="17" /><polyline points="9 14 12 11 15 14" /></svg> Adicionar nova Empresa</a></li>
                    <?php endif; ?>
                    <?php if($level == 5): ?>
                        <li class="nav-item li"><a href="#" style="color: <?= $Index['color_41']; ?>!important;"  data-bs-toggle="modal" data-bs-target="#modal-report" class="nav-link"><!-- Download SVG icon from http://tabler-icons.io/i/file-upload -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" /><line x1="12" y1="11" x2="12" y2="17" /><polyline points="9 14 12 11 15 14" /></svg> Adicionar nova Empresa</a></li>
                        <li class="nav-item dropdown li<?php if (in_array('admin', $linkto) || in_array('statistic', $linkto)) echo ' active';  ?>">
                            <a class="nav-link dropdown-toggle" style="color: <?= $Index['color_41']; ?>!important;" href="#navbar-base" data-bs-toggle="dropdown" role="button" aria-expanded="false" >
                            <span class="nav-link-title">
                                <!-- Download SVG icon from http://tabler-icons.io/i/package -->
	<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><polyline points="12 3 20 7.5 20 16.5 12 21 4 16.5 4 7.5 12 3" /><line x1="12" y1="12" x2="20" y2="7.5" /><line x1="12" y1="12" x2="12" y2="21" /><line x1="12" y1="12" x2="4" y2="7.5" /><line x1="16" y1="5.25" x2="8" y2="9.75" /></svg> Definições
                            </span>
                            </a>
                            <div class="dropdown-menu">
                                <div class="dropdown-menu-columns">
                                    <div class="dropdown-menu-column">
                                        <a class="dropdown-item" style="color: <?= $Index['color_42']; ?>!important;" href="Admin.php?exe=admin/config"><span class="nav-link-title">Aspeto</span></a>
                                        <a class="dropdown-item" style="color: <?= $Index['color_42']; ?>!important;" href="Admin.php?exe=admin/security"><span class="nav-link-title">Licença e Segurança</span></a>
                                        <a class="dropdown-item" style="color: <?= $Index['color_42']; ?>!important;" href="Admin.php?exe=admin/empresa"><span class="nav-link-title">Operações Empresarial</span></a>
                                        <a class="dropdown-item" style="color: <?= $Index['color_42']; ?>!important;" href="Admin.php?exe=admin/eliudy"><span class="nav-link-title">Painel Estatistico</span></a>
                                        <a class="dropdown-item" style="color: <?= $Index['color_42']; ?>!important;" href="Admin.php?exe=statistic/company"><span class="nav-link-title">Registro de Todas Empresas</span></a>
                                    </div>
                                </div>
                            </div>
                        </li>

                        <!---li class="nav-item dropdown li">
                            <a class="nav-link dropdown-toggle" style="color: <?= $Index['color_41']; ?>!important;" href="#navbar-base" data-bs-toggle="dropdown" role="button" aria-expanded="false" >
                            <span class="nav-link-title">
                                Website
                            </span>
                            </a>
                            <div class="dropdown-menu">
                                <div class="dropdown-menu-columns">
                                    <div class="dropdown-menu-column">
                                        <a href="Admin.php?exe=websites/index_home" class="dropdown-item" style="color: <?= $Index['color_42']; ?>!important;">Home</a>
                                        <a href="Admin.php?exe=websites/index_about" class="dropdown-item" style="color: <?= $Index['color_42']; ?>!important;">Sobre</a>
                                        <a href="Admin.php?exe=websites/index_services" class="dropdown-item" style="color: <?= $Index['color_42']; ?>!important;">Serviços</a>
                                        <a href="Admin.php?exe=websites/gallery" class="dropdown-item" style="color: <?= $Index['color_42']; ?>!important;">Galeria</a>
                                        <a href="Admin.php?exe=websites/blog" class="dropdown-item" style="color: <?= $Index['color_42']; ?>!important;">Blog</a>
                                        <a href="Admin.php?exe=websites/index_author" class="dropdown-item" style="color: <?= $Index['color_42']; ?>!important;">Autor</a>
                                        <a href="Admin.php?exe=websites/index_category" class="dropdown-item" style="color: <?= $Index['color_42']; ?>!important;">Categoria</a>
                                        <a href="Admin.php?exe=websites/index_pricing" class="dropdown-item" style="color: <?= $Index['color_42']; ?>!important;">Preços</a>
                                        <a href="Admin.php?exe=websites/index_team" class="dropdown-item" style="color: <?= $Index['color_42']; ?>!important;">Team</a>
                                        <a href="Admin.php?exe=websites/index_faq" class="dropdown-item" style="color: <?= $Index['color_42']; ?>!important;">Faq</a>
                                    </div>
                                </div>
                            </div>
                        </li--->
                    <?php endif; ?>
                <ul/>
            </div>
        </div>
    </div>
</div>
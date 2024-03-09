<div class="page-header d-print-none">
    <div class="row align-items-center">
        <div class="col">
            <h2 class="page-title" style="color: <?= $Index['color_41']; ?>!important;">
                Definições
            </h2>
        </div>
    </div>
</div>

<div class="d-lg-block col-lg-3">
    <ul class="nav nav-pills nav-vertical">
        <li class="nav-item"><a href="Admin.php?exe=admin/config" class="nav-link" style="color: <?= $Index['color_41']; ?>!important;">Aspecto</a></li>
        <li class="nav-item"><a href="Admin.php?exe=admin/security" class="nav-link" style="color: <?= $Index['color_41']; ?>!important;">Licença e Segurança</a></li>
        <li class="nav-item"><a href="Admin.php?exe=admin/empresa" class="nav-link" style="color: <?= $Index['color_41']; ?>!important;">Operações Empresarial</a></li>
        <li class="nav-item"><a href="Admin.php?exe=admin/eliudy" class="nav-link" style="color: <?= $Index['color_41']; ?>!important;">Painel Estatistico</a></li>
        <li class="nav-item"><a href="Admin.php?exe=statistic/company" class="nav-link" style="color: <?= $Index['color_41']; ?>!important;">Registro de Todas Empresas (<?php
                $read = new Read();
                $read->ExeRead("db_settings");
                echo $result = $read->getRowCount();
                ?>)</a></li>
        <li class="nav-item"><a href="Admin.php?exe=admin/management" class="nav-link" style="color: <?= $Index['color_41']; ?>!important;">Gestão e Marketing</a></li>
        <li class="nav-item"><a href="Admin.php?exe=admin/testemunial" class="nav-link" style="color: <?= $Index['color_41']; ?>!important;">Testemunhos
                <?php
                $status = 0;
                $Read = new Read();
                $Read->ExeRead("db_users_commint", "WHERE status=:st ORDER BY id DESC LIMIT 6", "st={$status}");
                ?>
                (<?php if($Read->getResult()): echo $Read->getRowCount(); endif;?>)</a></li>
        <li class="nav-item">
            <a href="#menu-content" class="nav-link" data-bs-toggle="collapse" aria-expanded="false" style="color: <?= $Index['color_41']; ?>!important;">
               Website
                <span class="nav-link-toggle"></span>
            </a>
            <ul class="nav nav-pills collapse" id="menu-content">
                <li class="nav-item"><a href="Admin.php?exe=websites/index_home" class="nav-link" style="color: <?= $Index['color_42']; ?>!important;">Home</a></li>
                <li class="nav-item"><a href="Admin.php?exe=websites/index_about" class="nav-link" style="color: <?= $Index['color_42']; ?>!important;">Sobre</a></li>
                <li class="nav-item"><a href="Admin.php?exe=websites/index_services" class="nav-link" style="color: <?= $Index['color_42']; ?>!important;">Serviços</a></li>
                <li class="nav-item"><a href="Admin.php?exe=websites/gallery" class="nav-link" style="color: <?= $Index['color_42']; ?>!important;">Galeria</a></li>
                <li class="nav-item"><a href="Admin.php?exe=websites/blog" class="nav-link" style="color: <?= $Index['color_42']; ?>!important;">Blog</a></li>
                <li class="nav-item"><a href="Admin.php?exe=websites/index_author" class="nav-link" style="color: <?= $Index['color_42']; ?>!important;">Autor</a></li>
                <li class="nav-item"><a href="Admin.php?exe=websites/index_category" class="nav-link" style="color: <?= $Index['color_42']; ?>!important;">Categoria</a></li>
                <li class="nav-item"><a href="Admin.php?exe=websites/index_pricing" class="nav-link" style="color: <?= $Index['color_42']; ?>!important;">Preços</a></li>
                <li class="nav-item"><a href="Admin.php?exe=websites/index_team" class="nav-link" style="color: <?= $Index['color_42']; ?>!important;">Team</a></li>
                <li class="nav-item"><a href="Admin.php?exe=websites/index_faq" class="nav-link" style="color: <?= $Index['color_42']; ?>!important;">Faq</a></li>
                <li class="nav-item"><a href="Admin.php?exe=websites/index_terms" class="nav-link" style="color: <?= $Index['color_42']; ?>!important;">Termos de uso</a></li>
            </ul>
        </li>
        <li class="nav-item">
            <a href="?logoff=true" class="nav-link active">
                Terminar sessão
            </a>
        </li>
    </ul>
</div>
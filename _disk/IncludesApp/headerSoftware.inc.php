<header class="navbar navbar-expand-md navbar-light d-print-none" style="background: <?= $Index['color_1']; ?>!important;">
    <?php
        $DB = new DBKwanzar();
        if(!isset($id_db_settings)): $id_db_settings = null; endif;
    ?>
    <div class="container-xl">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
            <a href="">
                <?php if(isset($DB->CheckCpanelAndSettings($id_db_settings, $id_db_kwanzar)['atividade']) && $DB->CheckCpanelAndSettings($id_db_settings, $id_db_kwanzar)['atividade'] == 19): ?>
                    <img src="uploads/k_dental.png" width="110" height="32" alt="ProSmart" class="navbar-brand-image">
                <?php else: ?>
                    <img src="uploads/<?= $Index['logotype']; ?>" width="110" height="32" alt="ProSmart" class="navbar-brand-image">
                <?php endif; ?>
            </a>
        </h1>
        <div class="navbar-nav flex-row order-md-last">
            <?php require_once("_disk/IncludesApp/superacao.inc.php"); ?>
        </div>
    </div>
</header>
<aside class="navbar navbar-vertical navbar-expand-lg" style="background: <?= $Index['color_1']; ?>!important;">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <h1 class="navbar-brand navbar-brand-autodark">
            <a href="">
                <?php if(isset($DB->CheckCpanelAndSettings($id_db_settings, $id_db_kwanzar)['atividade']) && $DB->CheckCpanelAndSettings($id_db_settings, $id_db_kwanzar)['atividade'] == 19): ?>
                    <img src="uploads/k_dental.png" width="110" height="32" alt="ProSmart" class="navbar-brand-image">
                <?php else: ?>
                    <img src="uploads/<?= $Index['logotype']; ?>" width="110" height="32" alt="ProSmart" class="navbar-brand-image">
                <?php endif; ?>
            </a>
        </h1>
        <div class="navbar-nav flex-row d-lg-none">
            <?php require_once("_disk/IncludesApp/superacao.inc.php"); ?>
        </div>
        <div class="collapse navbar-collapse" id="navbar-menu">
            <ul class="navbar-nav pt-lg-3">
                <?php require_once("_disk/IncludesApp/links.inc.php"); ?>
            </ul>
        </div>
    </div>
</aside>
<div class="content">
    <div class="panel-header bg-primary-gradient">
        <div class="page-inner py-5">
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                <div>
                    <h2 class="text-white pb-2 fw-bold"><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Painel de control"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "服务控制面板"; endif; ?></h2>
                    <?php
                    $Ready = new Read();
                    $Ready->ExeRead("db_settings", "WHERE id=:i AND id_db_kwanzar=:is", "i={$id_db_settings}&is={$id_db_kwanzar}");

                    if($Ready->getResult()):
                        $ky = $Ready->getResult()[0];
                        ?>
                        <h5 class="text-white op-7 mb-2"><?= $ky['empresa']; ?></h5>
                        <h6 class="text-white op-8 mb-2"><strong>NIF:</strong> <?= $ky['nif']; ?></h6>
                        <?php
                    endif;
                    ?>
                </div>
                <?php if($level >= 4 || $level == 3): ?>
                    <div class="ml-md-auto py-2 py-md-0">
                        <a href="<?= HOME; ?>panel.php?exe=settings/index<?= $n; ?>" class="btn btn-white btn-border btn-round mr-2"><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Definições"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "定义"; endif; ?></a>
                        <?php if($level >= 4): ?>
                            <a href="<?= HOME; ?>panel.php?exe=settings/active<?= $n; ?>" class="btn btn-primary btn-round">Histórico de actividades</a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="page-inner">
    <h4 class="page-title"><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Estatística"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "统计"; endif; ?></h4>
    <?php
        if($level >= 3):
            require_once("_heliospro/money-home-charts.inc.php");
        endif;
        require_once("_heliospro/default-home-charts.inc.php");
    ?>
</div>
    <div class="card-body">
        <div class="row align-items-center">
            <?php
                $posti = 0;
                $getPage = filter_input(INPUT_GET, 'page',FILTER_VALIDATE_INT);
                $Pager = new Pager("Admin.php?exe=default/home&page=");
                $Pager->ExePager($getPage, 4);

                $Data = ["Ativar", "Suspender", "Suspender"];
                $read = new Read();
                $read->ExeRead("db_settings", "WHERE id_db_kwanzar=:id ORDER BY id ASC LIMIT :limit OFFSET :offset", "id={$id_db_kwanzar}&limit={$Pager->getLimit()}&offset={$Pager->getOffset()}");

                if($read->getResult()):
                    foreach($read->getResult() as $key):
                        extract($key);
                        ?>
                        <div class="col-md-6 col-xl-3" style="height: 330px!important;">
                            <div class="card" style="height: 330px!important;">
                                <div class="card-body text-center">
                                    <div class="mb-3">
                                        <a href="panel.php?exe=default/home&id_db_settings=<?= $key['id']; ?>"><span class="avatar avatar-xl avatar-rounded"><img style="border-radius: 50%!important;" src="uploads/<?php if($key['logotype'] != null || $key['logotype'] != ''): echo $key['logotype']; else: echo 'logotype.jpg'; endif; ?>"/></span></a>
                                    </div>
                                    <a href="panel.php?exe=default/home&id_db_settings=<?= $key['id']; ?>"><div class="card-title mb-1"><?= $key['empresa']; ?></div></a>
                                    <div class="text-muted" style="color: <?= $Index['color_41']; ?>!important;"><?= $key['nif'] ?>/<?= $key['id'] ?></div>
                                </div>
                                <?php if($level == 5): ?>
                                    <a href="javascript:void()" onclick="SuspanseL(<?= $key['id']; ?>)" title="<?php if($key['status'] != null): echo $Data[$key['status']]; else: echo "Suspender"; endif; ?>" class="card-btn"><?= $Data[$key["status"]]; ?></a>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php
                    endforeach;
                endif;
            ?>
        </div>
        <br/>
        <?php
            $Pager->ExePaginator("db_settings", "WHERE id_db_kwanzar=:id ORDER BY id DESC", "id={$id_db_kwanzar}");
            echo $Pager->getPaginator();
        ?><br/>
    </div>
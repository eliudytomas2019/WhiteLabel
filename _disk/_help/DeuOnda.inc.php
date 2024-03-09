<?php
$Data = ["Ativar", "Suspender", "Suspender"];
if($read->getResult()):
    foreach ($read->getResult() as $key):
        ?>
        <div class="col-md-6 col-lg-3">
            <div class="card" style="height: 400px!important;">
                <div class="card-body p-4 text-center">
                    <a href="Admin.php?exe=statistic/views&postId=<?= $key['id']; ?>"><span class="avatar avatar-xl mb-3 avatar-rounded"><img style="border-radius: 50%!important;" src="<?= HOME; ?>uploads/<?php if($key['logotype'] != null || $key['logotype'] != ''): echo $key['logotype']; else: echo 'logotype.jpg'; endif; ?>"/></span></a>
                    <a href="Admin.php?exe=statistic/views&postId=<?= $key['id']; ?>"><h3 class="m-0 mb-1"><?= $key['empresa']; ?></h3></a>
                    <div class="mt-3">
                        <span class="badge bg-purple-lt"><?= $key['nif'] ?></span>
                    </div>
                </div>
                <div class="d-flex">
                    <a href="javascript:void()" onclick="Suspanse(<?= $key['id']; ?>)" title="<?php if($key['status'] != null): echo $Data[$key['status']]; else: echo "Suspender"; endif; ?>" class="card-btn"><?= $Data[$key["status"]]; ?></a>

                    <a href="javascript:void()" onclick="Excluded(<?= $key['id']; ?>)" class="card-btn btn-danger">Excluir</a>
                </div>
            </div>
        </div>
    <?php
    endforeach;
endif;
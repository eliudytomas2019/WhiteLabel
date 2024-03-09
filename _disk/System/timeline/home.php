<div class="container-xl">
    <div class="row">
        <div class="col-3">
            <div class="subheader mb-2" style="color: <?= $Index['color_41']; ?>!important;">MENU</div>
            <div class="list-group list-group-transparent mb-3">
                <?php
                    if($level == 5): ?>
                        <a style="color: <?= $Index['color_41']; ?>!important;" class="list-group-item list-group-item-action d-flex align-items-center" href="panel.php?exe=timeline/whatsapp/index<?= $n; ?>">Mensagens pelo WhatsApp</a>
                    <?php endif;
                ?>

                <a style="color: <?= $Index['color_41']; ?>!important;" class="list-group-item list-group-item-action d-flex align-items-center" href="#"></a>
            </div>
        </div>
        <div class="col-9">
            <div class="row">
                <div class="NGA col-12" id="NGA"></div>
                <?php
                    $read = new Read();
                    $read->ExeRead("ads_whatsapp", "ORDER BY id DESC LIMIT 12");
                    if($read->getResult()):
                        foreach ($read->getResult() as $key):
                            ?>
                            <tr>
                            <div class="col-sm-6 col-lg-4">
                                <div class="card card-sm">
                                    <a onclick="AdsMsg(<?= $key['id']; ?>)" href="<?= $key['link'] ?>" target="_blank" class="d-block"><img src="uploads/<?php if($key["cover"] != '' || !empty($key['cover'])): echo $key["cover"]; else: echo 'default.jpg'; endif; ?>" class="card-img-top"></a>
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <div><?= $key['titulo']; ?></div>
                                                <div class="text-muted" style="color: <?= $Index['color_41']; ?>!important;"><?= $key['content']; ?></div>
                                            </div>
                                            <a href="<?= $key['link'] ?>" onclick="AdsMsg(<?= $key['id']; ?>)" target="_blank" class="avatar me-3 rounded">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 21l1.65 -3.8a9 9 0 1 1 3.4 2.9l-5.05 .9" /><path d="M9 10a0.5 .5 0 0 0 1 0v-1a0.5 .5 0 0 0 -1 0v1a5 5 0 0 0 5 5h1a0.5 .5 0 0 0 0 -1h-1a0.5 .5 0 0 0 0 1" /></svg></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        endforeach;
                    endif;
                ?>
            </div>
        </div>
    </div>
</div>
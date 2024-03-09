<?php
/**
 * Created by PhpStorm.
 * User: Kwanzar Soft
 * Date: 05/06/2020
 * Time: 00:26
 */

$Read = new Read();
$Read->ExeRead("db_users", "WHERE id!={$userlogin['id']} AND level='5'");

if($Read->getResult()):
    $WiFi = $Read->getResult()[0];

    $blocks = explode(', ', $WiFi['blocks']);
    $agora  = date('Y-m-d H:i:s');

    if(!in_array($userlogin['id'], $blocks)):
        $status = 'on';

        if($agora >= $WiFi['limite']):
            $status = 'off';
        endif;
        ?>
        <!--- <input type="hidden" name="id_conversa" id="id_conversa" value="<?= $WiFi['id']; ?>"> --->
        <div class="custom-template" id="janela_<?= $WiFi['id']; ?>">
            <div class="title">
                <img src="<?= HOME; ?>uploads/<?php if($WiFi['cover'] != null || $WiFi['cover'] != ''): echo $WiFi['cover']; else: echo 'user.png'; endif; ?>" class="PhotoUser"/>
                <div class="ForOurFive">
                    <label><?= $WiFi['name']; ?></label>
                    <span class="status <?= $status; ?>"></span>
                </div>
            </div>
            <div class="custom-content">
                <div class="body">
                    <div class="mensagens">
                        <ul id="HPForLife">

                        </ul>
                    </div>
                    <div class="send_message">
                        <input type="text" id="<?= $userlogin['id'].":".$WiFi['id']; ?>" class="msg" placeholder="Aa"/>
                    </div>
                </div>
            </div>
            <div class="custom-toggle" onclick="Disney(<?= $WiFi['id'].", ".$userlogin['id']; ?>)">
                <i class="flaticon-settings"></i>
            </div>
        </div>
        <?php
    endif;
endif;

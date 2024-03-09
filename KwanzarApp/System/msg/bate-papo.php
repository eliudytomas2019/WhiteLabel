<?php
/**
 * Created by PhpStorm.
 * User: Kwanzar Soft
 * Date: 09/08/2020
 * Time: 18:57
 */
?>


<div id="bate-papo">
    <div id="chats">
        <div class="mms">
            <h2>Mensagens</h2>
            <form class="navbar-left navbar-form nav-search mr-md-3" method="get" action="">
                <input type="text" name=""  placeholder="Pesquisar mensagens" class="form-control">
            </form>
        </div>
        <div id="ChatsMsg">
            <?php
            $Read->ExeRead("db_users", "WHERE id!={$userlogin['id']}");
            if($Read->getResult()):
                foreach($Read->getResult() as $key):
                    //extract($key);

                    $blocks = explode(', ', $key['blocks']);
                    $agora  = date('Y-m-d H:i:s');

                    if(!in_array($userlogin['id'], $blocks)):
                        $status = 'on';

                        if($agora >= $key['limite']):
                            $status = 'off';
                        endif;

                        $Read->ExeRead("ws_msg", "WHERE para=:i AND de=:ip ORDER BY id DESC LIMIT 1", "i={$userlogin['id']}&ip={$key['id']}");
                        if($Read->getResult()):
                            foreach($Read->getResult() as $row):
                                //extract($row);

                                $emotions = array(':)', ':b', ':a', ':c', ':d', ':e', ':f', ':g', ':h', '(:', ':]', '[:', ':@', ':!', ':a)');
                                $imgs     = array('<img src="uploads/01.png" width="14">', '<img src="uploads/02.png" width="14">', '<img src="uploads/03.png" width="14">', '<img src="uploads/04.png" width="14">', '<img src="uploads/05.png" width="14">', '<img src="uploads/06.png" width="14">','<img src="uploads/07.png" width="14">', '<img src="uploads/08.png" width="14">', '<img src="uploads/09.png" width="14">', '<img src="uploads/10.png" width="14">','<img src="uploads/11.png" width="14">','<img src="uploads/12.png" width="14">','<img src="uploads/13.png" width="14">','<img src="uploads/14.png" width="14">','<img src="uploads/15.png" width="14">');
                                $msg      = str_replace($emotions, $imgs, $row['msg']);

                                ?>
                                <div class="ppp">
                                    <a href="<?= HOME; ?>panel.php?exe=msg/bate-papo&from=<?= $key['id']; ?><?= $n; ?>" onclick="Disney(<?= $key['id'].", ".$userlogin['id']; ?>)">
                                        <img src="<?= HOME; ?>uploads/<?php if($key['cover'] != null || $key['cover'] != ''): echo $key['cover']; else: echo 'user.png'; endif; ?>" class="mel">
                                        <div class="pppHeader">
                                            <h2><?= $key['name']; ?> <span class="status <?= $status; ?>"></span></h2>
                                            <span><?= Check::Words($msg, 5); ?></span>
                                            <span class="hr"><?= $row["data"]." ".$row['hora']; ?></span>
                                        </div>
                                    </a>
                                </div>
                                <?php
                            endforeach;
                        endif;
                    endif;
                endforeach;
            endif;
            ?>
        </div>
    </div>

    <div class="bate-papo-body">
        <?php
            $from = filter_input(INPUT_GET, "from", FILTER_VALIDATE_INT);

            if(isset($from)):
                $Read = new Read();
                $Read->ExeRead("db_users", "WHERE id={$from}");

                if($Read->getResult()):
                    $WiFi = $Read->getResult()[0];

                    $blocks = explode(', ', $WiFi['blocks']);
                    $agora  = date('Y-m-d H:i:s');

                    if(!in_array($userlogin['id'], $blocks)):
                        $status = 'on';

                        if($agora >= $WiFi['limite']):
                            $status = 'off';
                        endif;
                    endif;

                    ?>
                    <div class="papo-body">
                        <div class="sms">
                            <ul id="HPForLife">

                            </ul>
                        </div>
                        <div class="send_message_one">
                            <input type="text" class="msg" id="<?= $userlogin['id'].":".$WiFi['id']; ?>" onmousedown="Disney(<?= $WiFi['id'].", ".$userlogin['id']; ?>)" onmouseover="Disney(<?= $WiFi['id'].", ".$userlogin['id']; ?>)" onclick="Disney(<?= $WiFi['id'].", ".$userlogin['id']; ?>)" placeholder="Aa"/>
                        </div>
                    </div>
                    <?php
                endif;
            endif;
            ?>
    </div>
</div>

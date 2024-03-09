<?php
/**
 * Created by PhpStorm.
 * User: Kwanzar Soft
 * Date: 09/08/2020
 * Time: 18:36
 */

//if($level >= 4): $n =  '&id_db_settings='.$id_db_settings; else: $n = null; endif;
?>
<a class="nav-link dropdown-toggle" href="#" id="messageDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <i class="fa fa-envelope"></i>
    <?php
    $Read = new Read();
    $Read->ExeRead("ws_msg", "WHERE para=:i AND lido='1' ", "i={$userlogin['id']}");

    if($Read->getRowCount() > 99): $pFc = "99+"; else: $pFc = $Read->getRowCount(); endif;
    ?>
    <span class="notification"><?= $pFc; ?></span>
</a>
<ul class="dropdown-menu messages-notif-box animated fadeIn" aria-labelledby="messageDropdown">
    <li>
        <div class="dropdown-title d-flex justify-content-between align-items-center">
            Mensagens
            <a href="javascript:void()" class="small" onclick="Channel(<?= $userlogin['id']; ?>)">Marca todas como lida</a>
        </div>
    </li>
    <li>
        <div class="message-notif-scroll scrollbar-outer">
            <div class="notif-center">
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

                            $Read->ExeRead("ws_msg", "WHERE para=:i AND de=:ip AND lido='1' ORDER BY id DESC LIMIT 1", "i={$userlogin['id']}&ip={$key['id']}");
                            if($Read->getResult()):
                                foreach($Read->getResult() as $row):
                                    //extract($row);

                                    $emotions = array(':)', ':b', ':a', ':c', ':d', ':e', ':f', ':g', ':h', '(:', ':]', '[:', ':@', ':!', ':a)');
                                    $imgs     = array('<img src="uploads/01.png" width="14">', '<img src="uploads/02.png" width="14">', '<img src="uploads/03.png" width="14">', '<img src="uploads/04.png" width="14">', '<img src="uploads/05.png" width="14">', '<img src="uploads/06.png" width="14">','<img src="uploads/07.png" width="14">', '<img src="uploads/08.png" width="14">', '<img src="uploads/09.png" width="14">', '<img src="uploads/10.png" width="14">','<img src="uploads/11.png" width="14">','<img src="uploads/12.png" width="14">','<img src="uploads/13.png" width="14">','<img src="uploads/14.png" width="14">','<img src="uploads/15.png" width="14">');
                                    $msg      = str_replace($emotions, $imgs, $row['msg']);

                                    ?>
                                    <a href="<?= HOME; ?>panel.php?exe=msg/bate-papo&from=<?= $key['id']; ?><?= $n; ?>">
                                        <div class="notif-img">
                                            <img src="<?= HOME; ?>uploads/<?php if($key['cover'] != null || $key['cover'] != ''): echo $key['cover']; else: echo 'user.png'; endif; ?>" alt="Img Profile">
                                        </div>
                                        <div class="notif-content">
                                            <span class="subject"><?= $key['name']; ?> <span class="status <?= $status; ?>"></span></span>
                                            <span class="block">
                                                <?= $msg; ?>
                                            </span>
                                            <span class="time"><?= $row["data"]." ".$row['hora']; ?></span>
                                        </div>
                                    </a>
                                    <?php
                                endforeach;
                            endif;
                        endif;
                    endforeach;
                endif;
                ?>
            </div>
        </div>
    </li>
    <li>
        <a class="see-all" href="<?= HOME; ?>panel.php?exe=msg/bate-papo<?= $n; ?>">Lêr todas mensagens<i class="fa fa-angle-right"></i> </a>
    </li>
</ul>

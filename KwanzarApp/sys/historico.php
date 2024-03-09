<?php
/**
 * Created by PhpStorm.
 * User: Kwanzar Soft
 * Date: 09/08/2020
 * Time: 01:00
 */

if(isset($_POST['conversacom'])):
    $msgs        = array();
    $id_conversa = (int) $_POST['conversacom'];
    $online      = (int) $_POST['online'];

    require_once("../../Config.inc.php");

    $read = new Read();
    $read->ExeRead("ws_msg", "WHERE (de=:de AND para=:para) OR (de=:para AND para=:de) ORDER BY id ASC", "de={$online}&para={$id_conversa}");

    if($read->getResult()):
        foreach($read->getResult() as $key):
            extract($key);

            $emotions = array(':)', ':b', ':a', ':c', ':d', ':e', ':f', ':g', ':h', '(:', ':]', '[:', ':@', ':!', ':a)');
            $imgs     = array('<img src="uploads/01.png" width="14">', '<img src="uploads/02.png" width="14">', '<img src="uploads/03.png" width="14">', '<img src="uploads/04.png" width="14">', '<img src="uploads/05.png" width="14">', '<img src="uploads/06.png" width="14">','<img src="uploads/07.png" width="14">', '<img src="uploads/08.png" width="14">', '<img src="uploads/09.png" width="14">', '<img src="uploads/10.png" width="14">','<img src="uploads/11.png" width="14">','<img src="uploads/12.png" width="14">','<img src="uploads/13.png" width="14">','<img src="uploads/14.png" width="14">','<img src="uploads/15.png" width="14">');
            $msg      = str_replace($emotions, $imgs, $key['msg']);

            if($online == $key['de']):
                $janela_de = $key['para'];
                ?>
                <li class="eu"><?= $msg; ?></li>
                <?php
            else:
                ?>
                <li><?= $msg; ?></li>
                <?php
                $janela_de = $key['de'];
            endif;

            /*$msgs[] = array(
                'id'        => $key['id'],
                'mensagem'  => $key['msg'],
                'de'        => $key['de'],
                'para'      => $key['para'],
                'janela_de' => $janela_de
            );*/
        endforeach;
    endif;
endif;
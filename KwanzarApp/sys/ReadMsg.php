<?php
/**
 * Created by PhpStorm.
 * User: Kwanzar Soft
 * Date: 09/08/2020
 * Time: 22:40
 */

require_once("../../Config.inc.php");
$online      = (int) $_POST['online'];
$id_conversa = (int) $_POST['id_conversa'];

$Dating['lido'] = 2;

$Update = new Update();
$Update->ExeUpdate("ws_msg", $Dating, "WHERE para=:i AND de=:p", "i={$online}&p={$id_conversa}");

if($Update->getResult()):
    $userlogin['id'] = $online;
    require_once("../../_heliospro/all-msg.inc.php");
else:
    WSError("Ops: aconteceu um erro inesperado ao atualizar a caixa de entrada!", WS_ERROR);
endif;
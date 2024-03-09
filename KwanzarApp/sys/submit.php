<?php
/**
 * Created by PhpStorm.
 * User: Kwanzar Soft
 * Date: 09/08/2020
 * Time: 00:04
 */

$de   = filter_input(INPUT_POST, "de", FILTER_VALIDATE_INT);
$para = filter_input(INPUT_POST, "para", FILTER_VALIDATE_INT);
$msg  = strip_tags(filter_input(INPUT_POST, "mensagem", FILTER_DEFAULT));

require_once("../../Config.inc.php");

$Data['hora'] = date('H:i');
$Data['data'] = date('d-m-Y');
$Data['de']   = $de;
$Data['para'] = $para;
$Data['msg']  = $msg;
$Data['lido'] = 1;

$Data['dia']  = date('d');
$Data['mes']  = date('m');
$Data['ano']  = date('Y');
$Data['min']  = date('i');
$Data['seg']  = date('s');
$Data['hor']  = date('H');

$Create = new Create();
$Create->ExeCreate("ws_msg", $Data);

if($Create->getResult()):
    echo "ok";
else:
    echo "erro";
endif;
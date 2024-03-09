<?php
require_once("Config.inc.php");
$acao = strip_tags(trim(filter_input(INPUT_GET, 'action')));
if($acao):
    $postId = filter_input(INPUT_GET, "postId", FILTER_VALIDATE_FLOAT);
    switch ($acao):
        case 'client':
            $Export = new Export();
            $Export->Clientes($postId);
            break;
        case 'itens':
            $Export = new Export();
            $Export->Itens($postId);
            var_dump($Export->Itens($postId));
            break;
        default:
            WSError("Ops: não encontramos a ação desejada!", WS_INFOR);
    endswitch;
endif;

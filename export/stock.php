<?php
require_once("../Config.inc.php");

$postId = filter_input(INPUT_GET, "postId", FILTER_VALIDATE_INT);
if(isset($_GET['link'])): $link = strip_tags(trim(htmlspecialchars($_GET['link']))); else: $link = null; endif;

$Dados['quantidade'] = 0;

$Update = new Update();
$Update->ExeUpdate("cv_product", $Dados,  "WHERE id_db_settings=:i AND product LIKE '%' :link '%' ", "i={$postId}&link={$link}");

if($Update->getResult()):
    WSError("O Stock foi zerado com sucesso! Cat: {$link}", WS_ACCEPT);
    exit(0);
else:
    WSError("Aconteceu um erro inesperado ao zerar o stock, atualize a página e tente novamente!", WS_ALERT);
endif;
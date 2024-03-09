<?php

$type = "P";
$posti = 0;
$getPage = filter_input(INPUT_GET, 'page',FILTER_VALIDATE_INT);
$Pager = new Pager("panel.php?exe=product/stock{$n}&page=");
$Pager->ExePager($getPage, 20);

$Read = new Read();
$Read->ExeRead("cv_product", "WHERE id_db_settings=:id AND type=:t ORDER BY product ASC LIMIT :limit OFFSET :offset", "id={$id_db_settings}&t={$type}&limit={$Pager->getLimit()}&offset={$Pager->getOffset()}");

$qtd = 0;
$uni = 0;
$custo_total = 0;
$preco_total = 0;
$lucro_total = 0;

if($Read->getResult()):
    foreach ($Read->getResult() as $key):

        $Product = new Product();

        if(!empty($key['data_expiracao'])):
            $Product->VerificarExpiracao($key['data_expiracao'], $key['id'], $key['product'], $id_db_settings);
        else:
            $Product->AlertEmpty($id_db_settings);
        endif;

        $qtd += $key["quantidade"];
        $uni += $key["quantidade"] * $key["unidades"];
        $custo_total += $key["custo_compra"];
        $preco_total += $key["preco_venda"];

        $NnM = $key['quantidade'];

        $in_total = ($NnM * $key["preco_venda"]) - $key["custo_compra"];
        $lucro_total += $in_total;
        require("_disk/AppData/PauloRikardo2.inc.php");
    endforeach;
endif;
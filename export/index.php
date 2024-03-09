<?php
$postId = filter_input(INPUT_GET, "postId", FILTER_VALIDATE_INT);
require_once("../Config.inc.php");

use League\Csv\Writer;
require "../vendor/autoload.php";

$csv = Writer::createFromString("");
$csv->setDelimiter(";");

if(isset($_GET['link'])): $link = strip_tags(trim(htmlspecialchars($_GET['link']))); else: $link = null; endif;


$Read = new Read();
$Read->ExeRead("cv_product", "WHERE id_db_settings=:i AND product LIKE '%' :link '%' ", "i={$postId}&link={$link}");

if($Read->getResult()):
    foreach ($Read->getResult() as $product):
        $csv->insertOne([
            $product["codigo"],
            $product["codigo_barras"],
            $product["product"],
            $product['quantidade'],
            $product['preco_venda'],
            $product['local_product'],
            $product['custo_compra'],
            $product['remarks']
        ]);
    endforeach;

    $csv->output("products_".time().".csv");

    exit();
endif;
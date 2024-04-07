<?php
$taxa = (87000 * 30) / 100;
$Data['preco_venda'] = 6000 + $taxa;

echo "Novo preço de venda: R$ " . number_format($Data['preco_venda'], 2);
?>


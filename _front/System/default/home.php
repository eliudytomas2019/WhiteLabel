<?php
$title = "Início - {$Index['name']}";

$Seo = new SEO($title, $Index['content'], "Vendus, PHC, Software de facturação, Programa de faturação, AGT, Software Grátis, Kwanzar, Kwanza, Licenciado AGT, Licença, Factura, Restaurantes, Restaurante, Bar", "index, follow", "{$_SERVER['REQUEST_URI']}}", "Eliúdy Tomás");
$Seo->metaTags();

include("_front/Includes/About.inc.php");
include("_front/Includes/Funcionalidades.inc.php");
?>

<?php
include("_front/Includes/counts.inc.php");
include("_front/Includes/slider.inc.php");
include("_front/Includes/subscribe.inc.php");
?>
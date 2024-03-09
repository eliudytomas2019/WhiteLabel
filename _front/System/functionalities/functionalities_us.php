<?php
$title = "Funcionalidades - {$Index['name']}";

$Seo = new SEO($title, $Index['content'], "Vendus, PHC, Software de facturação, Programa de faturação, AGT, Software Grátis, Kwanzar, Kwanza, Licenciado AGT, Licença, Factura, Restaurantes, Restaurante, Bar", "index, follow", "{$_SERVER['REQUEST_URI']}}", "Eliúdy Tomás");
$Seo->metaTags();

$yX = explode("-", $title);
include("_front/Includes/Section.inc.php");
include("_front/Includes/Container.inc.php");
include("_front/Includes/Funcionalidades.inc.php");
include("_front/Includes/counts.inc.php");
?>
<div class="container-xxl py-5">
    <div class="container">
        <div class="mx-auto text-center mb-5" style="max-width: 900px;">
            <h5 class="section-title px-3">Começa hoje mesmo a facturar!</h5>
            <h1 class="mb-0">4 motivos para escolher o Kwanzar!</h1>
        </div>
        <div class="row g-4">
            <?php
                $status = 1;

                $Read = new Read();
                $Read->ExeRead("website_blog", "WHERE id!=:idd AND status=:st ORDER BY id ASC LIMIT 4", "idd={$euclides_xxx}&st={$status}");

                if($Read->getResult()):
                    foreach ($Read->getResult() as $key):
                    ?>
                    <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="service-item text-center pt-3">
                            <div class="p-4">
                                <h5 class="mb-3"><?= $key['titulo']; ?></h5>
                                <?= $key['content']; ?>
                            </div>
                        </div>
                    </div>
                    <?php
                    endforeach;
                endif;
            ?>
        </div>
    </div>
</div>


<?php
include("_front/Includes/slider.inc.php");
include("_front/Includes/subscribe.inc.php");
?>

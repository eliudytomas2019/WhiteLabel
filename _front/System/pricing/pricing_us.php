<?php
$title = "Preços - {$Index['name']}";

$Seo = new SEO($title, $Index['content'], "Vendus, PHC, Software de facturação, Programa de faturação, AGT, Software Grátis, Kwanzar, Kwanza, Licenciado AGT, Licença, Factura, Restaurantes, Restaurante, Bar", "index, follow", "{$_SERVER['REQUEST_URI']}}", "Eliúdy Tomás");
$Seo->metaTags();

$yX = explode("-", $title);
include("_front/Includes/Section.inc.php");
?>

    <div class="container-fluid container-service py-5">
        <div class="container pt-5">
            <div class="text-center mx-auto wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
            <h1 class="mb-3">Planos e Preços para Software de Faturação</h1>
            <p class="mb-1">Escolha o plano que melhor se adapta às suas actuais necessidades. Com o tempo poderá mudar de plano, pois o Kwanzar adapta-se ao ritmo do seu negócio.</p>
        </div>
        <br/><div class="row g-4">
            <?php
            $status = 1;

            $Read = new Read();
            $Read->ExeRead("website_pricing", "WHERE status=:st ORDER BY id ASC LIMIT 6", "st={$status}");

            if($Read->getResult()):
                foreach ($Read->getResult() as $key):
                    ?>
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.2s">
                        <div class="position-relative shadow rounded border-top border-5 border-primary">
                            <div class="d-flex align-items-center justify-content-center position-absolute top-0 start-50 translate-middle bg-primary rounded-circle" style="width: 45px; height: 45px; margin-top: -3px;">
                                <i class="fa fa-paypal text-white"></i>
                            </div>
                            <div class="text-center border-bottom p-4 pt-5">
                                <h4 class="fw-bold"><?= $key['pacote']; ?></h4>
                            </div>
                            <div class="text-center border-bottom p-4">
                                <h1 class="mb-3">
                                    <small class="align-top" style="font-size: 22px; line-height: 45px;">Kz</small><?= number_format($key['preco'], 2, ",", "."); ?><small
                                        class="align-bottom" style="font-size: 16px; line-height: 40px;">/ Mês</small>
                                </h1>
                                <a class="btn btn-primary px-4 py-2" href="_register.php">Experimentar Grátis</a>
                            </div>
                            <div class="p-4">
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
include("_front/Includes/subscribe.inc.php");
?>
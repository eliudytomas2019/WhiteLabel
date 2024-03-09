<?php
$title = "Faq's - {$Index['name']}";

$Seo = new SEO($title, $Index['content'], "Vendus, PHC, Software de facturação, Programa de faturação, AGT, Software Grátis, Kwanzar, Kwanza, Licenciado AGT, Licença, Factura, Restaurantes, Restaurante, Bar", "index, follow", "{$_SERVER['REQUEST_URI']}}", "Eliúdy Tomás");
$Seo->metaTags();

$yX = explode("-", $title);
include("_front/Includes/Section.inc.php");;
?>
<div class="faqs">
    <div class="container">
        <div class="text-center mx-auto wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
            <h1 class="display-6 mb-3">Perguntas Frequentes sobre o Kwanzar</h1>
            <p class="mb-5">Se tiver dúvidas ou questões, <a href="index.php?exe=contact/contact_us">fale connosco</a>.</p>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div id="accordion-2">
                    <?php
                        $status = 1;

                        $Read = new Read();
                        $Read->ExeRead("website_faq", "WHERE status=:st ORDER BY id ASC LIMIT 60", "st={$status}");

                        if($Read->getResult()):
                            foreach ($Read->getResult() as $key):
                                ?>
                                <div class="card wow fadeInRight" data-wow-delay="0.<?= $key['id']; ?>s">
                                    <div class="card-header">
                                        <a class="card-link collapsed_<?= $key['id']; ?>" data-toggle="collapse" href="#collapseSix<?= $key['id']; ?>">
                                            <?= $key['titulo']; ?>
                                        </a>
                                    </div>
                                    <div id="collapseSix<?= $key['id']; ?>" class="collapse_<?= $key['id']; ?>" data-parent="#accordion-<?= $key['id']; ?>">
                                        <div class="card-body">
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
    </div>
</div>
<?php
include("_front/Includes/subscribe.inc.php");
?>


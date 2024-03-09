<div class="hero-wrap">
    <div class="home-slider owl-carousel">
        <?php
        $Read = new Read();
        $Read->ExeRead("website_home", "ORDER BY id DESC LIMIT 3");

        if($Read->getResult()):
            foreach ($Read->getResult() as $key):
                ?>
                <div class="slider-item" style="background-image:url(uploads/<?= $key['logotype']; ?>);">
                    <div class="overlay"></div>
                    <div class="container">
                        <div class="row no-gutters slider-text align-items-center justify-content-center">
                            <div class="col-md-8 ftco-animate">
                                <div class="text w-100 text-center">
                                    <h2><?= $key['titulo']; ?></h2>
                                    <h1 class="what_about_us"><?= $key['subtitulo']; ?></h1>
                                    <p class="us">Crie já a sua conta e experimente durante 30 dias sem compromisso.</p>
                                    <p><a href="_register.php" class="btn btn-abut">Experimente Grátis</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            endforeach;
        endif;
        ?>
    </div>
</div>

<?php
require_once("_front/extra.inc.php");
require_once("_front/services.nc.php");
require_once("_front/planos.inc.php");
require_once("_front/testemunhos.inc.php");
require_once("_front/pricing.inc.php");
?>
<section class="hero-wrap hero-wrap-2" style="background-image: url('uploads/1.png');" data-stellar-background-ratio="0.5">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text align-items-end">
            <div class="col-md-9 ftco-animate pb-5">
                <p class="breadcrumbs mb-2"><span class="mr-2"><a href="?exe=home">Home <i class="ion-ios-arrow-forward"></i></a></span> <span>Sobre <i class="ion-ios-arrow-forward"></i></span></p>
                <h1 class="mb-0 bread">Sobre Nós</h1>
            </div>
        </div>
    </div>
</section>

<section class="ftco-section ftco-no-pt bg-light">
    <div class="container">
        <div class="row d-flex no-gutters">
            <?php
            $status = 1;
            $Read = new Read();
            $Read->ExeRead("website_about", "WHERE status=:st ORDER BY id ASC LIMIT 1", "st={$status}");

            if($Read->getResult()):
            foreach ($Read->getResult() as $key):
            ?>
            <div class="col-md-6 d-flex">
                <div class="img img-video d-flex align-self-stretch align-items-center justify-content-center justify-content-md-center mb-4 mb-sm-0" style="background-image:url(uploads/<?php if($key['logotype'] == "" || $key['logotype'] == null): echo "logotype.jpg"; else: echo $key['logotype']; endif; ?>);">
                </div>
            </div>
            <div class="col-md-6 pl-md-5 py-md-5">
                <div class="heading-section pl-md-4 pt-md-5">
                    <span class="subheading">Bem vindo ao ProSmart</span>
                    <h2 class="mb-4">Software de Gestão Comercial</h2>
                    <?= $key['content']; ?>
                </div>
            </div>
            <?php
            endforeach;
            endif;
            ?>
        </div>
    </div>
</section>

<?php
require_once("_front/planos.inc.php");
require_once("_front/testemunhos.inc.php");
?>
<?php
$title = "Kwanzar Dental - {$Index['name']}";

$Seo = new SEO($title, $Index['content'], "Vendus, PHC, Software de facturação, Programa de faturação, AGT, Software Grátis, Kwanzar, Kwanza, Licenciado AGT, Licença, Factura, Restaurantes, Restaurante, Bar", "index, follow", "{$_SERVER['REQUEST_URI']}}", "Eliúdy Tomás");
$Seo->metaTags();
?>

<div class="carousel-header">
    <div id="carouselId" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner" role="listbox">
            <?php

            $Read = new Read();
            $Read->ExeRead("website_about", "ORDER BY id DESC LIMIT 1");

            if($Read->getResult()):
                $key = $Read->getResult()[0];
                ?>
                <div class="carousel-item active">
                    <img src="uploads/<?= $Read->getResult()[0]['logotype']; ?>" class="img-fluid" alt="Image">
                    <div class="carousel-caption">
                        <div class="p-3" style="max-width: 900px;">
                            <h4 class="text-white text-uppercase fw-bold mb-4" style="letter-spacing: 3px;"></h4>
                            <h1 class="display-2 text-white mb-4"><?= $key['titulo']; ?></h1>
                            <p class="mb-5 fs-5"><?= $key['content']; ?>
                            </p>
                            <div class="d-flex align-items-center justify-content-center">
                                <a class="btn-hover-bg btn btn-primary rounded-pill text-white py-3 px-5" href="_register.php">Experimente Grátis</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            endif;
            ?>
        </div>
    </div>
</div>

<div class="container-fluid container-service py-5">
    <div class="container pt-5">
        <div class="text-center mx-auto wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
            <h1 class="display-6 mb-3">Organize seu consultório</h1>
            <p class="mb-5">Esqueça tudo que você já viu sobre software odontológico. O Kwanzar Dental vai te ajudar desde a organização do seu pequeno consultório, até a gestão de clínicas odontológicas, sem deixar de lado a simplicidade e praticidade.</p>
        </div>
        <div class="row g-4">
            <?php
                $status = 1;

                $Read = new Read();
                $Read->ExeRead("website_category", "WHERE status=:st ORDER BY id ASC LIMIT 6", "st={$status}");

                if($Read->getResult()):
                    foreach ($Read->getResult() as $key):
                        ?>
                        <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.<?= $key['id']; ?>s">
                            <div class="service-item">
                                <div class="icon-box-primary mb-4">
                                    <img src="uploads/<?= $key['logotype']; ?>" style="max-height: 220px!important;max-width: 260px!important;">
                                </div>
                                <h5 class="mb-3"><?= $key['name']; ?></h5>
                                <p class="mb-4"><?= $key['content']; ?></p>
                            </div>
                        </div>
                        <?php
                    endforeach;
                endif;
            ?>
        </div>
    </div>
</div>
<?php include("_front/Includes/counts.inc.php"); ?>
    <div class="container-fluid container-team py-5">
        <div class="container pb-5">
            <div class="row g-5 align-items-center mb-5">
                <div class="col-md-6 wow fadeIn" data-wow-delay="0.3s">
                    <img class="img-fluid w-100" src="uploads/dental.png" alt="">
                </div>
                <div class="col-md-6 wow fadeIn" data-wow-delay="0.5s">
                    <h1 class="display-6 mb-3">Acessível de qualquer lugar</h1>
                    <p class="mb-5">Um conjunto de recursos incríveis para a gestão de consultório odontológico. Um software para dentistas, priorizando a simplicidade, para que o foco esteja naquilo que realmente importa: seus pacientes.</p>

                    <h3 class="mb-3">Acesse sua agenda</h3>
                    <p class="mb-4">Navegue facilmente pela sua agenda, veja quantas marcações tem a cada dia, os status da consulta, os compromissos e as horas livres entre uma consulta e outra.</p>

                    <h3 class="mb-3">Acesse o prontuário</h3>
                    <p class="mb-4">Veja as informações principais de cada paciente, adicione evoluções, confira pagamentos, históricos de consulta, anamneses e muito mais!</p>

                    <h3 class="mb-3">Tire fotos</h3>
                    <p class="mb-4">Utilize a câmera do seu celular para fotografar e anexar ao prontuário do paciente.</p>
                </div>
            </div>
        </div>
    </div>
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center mx-auto wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                <h1 class="display-6 mb-3">O que mais o Kwanzar oferece?</h1>
                <p class="mb-5">Um conjunto de recursos que te tornam mais competitivo. Soluções pensadas de dentista para dentista, priorizando a simplicidade, para que o foco esteja naquilo que realmente importa: seus pacientes.</p>
            </div>
            <div class="row g-4">
                <?php
                $status = 1;

                $Read = new Read();
                $Read->ExeRead("website_author", "WHERE status=:st ORDER BY id ASC LIMIT 6", "st={$status}");

                if($Read->getResult()):
                    foreach ($Read->getResult() as $key):
                        ?>
                        <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.1s">
                            <div class="service-item text-center pt-3">
                                <div class="p-4">
                                    <h5 class="mb-3"><?= $key['name']; ?></h5>
                                    <p><?= $key['content']; ?></p>
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
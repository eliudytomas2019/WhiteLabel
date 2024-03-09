<div class="container-fluid position-relative p-0">
    <nav class="navbar navbar-expand-lg navbar-light px-4 px-lg-5 py-3 py-lg-0">
        <a href="" class="navbar-brand p-0">
            <img src="uploads/<?= $Index['logotype']; ?>" alt="<?= $Index['name']; ?>">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="fa fa-bars"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto py-0">
                <a href="index.php?exe=default/home" class="nav-item nav-link li<?php if (in_array('default', $linkto)) echo ' active';  ?>">Início</a>
                <!--- a href="index.php?exe=about/about_us" class="nav-item nav-link li<?php if (in_array('about', $linkto)) echo ' active';  ?>">Sobre</a --->
                <a href="index.php?exe=functionalities/functionalities_us" class="nav-item nav-link li<?php if (in_array('functionalities', $linkto)) echo ' active';  ?>">Facturação & Stock</a>
                <a href="index.php?exe=dental/dental_us" class="nav-item nav-link li<?php if (in_array('dental', $linkto)) echo ' active';  ?>">Clinica Dentária</a>
                <a href="index.php?exe=pricing/pricing_us" class="nav-item nav-link li<?php if (in_array('pricing', $linkto)) echo ' active';  ?>">Preços</a>
                <a href="index.php?exe=faq/faq_us" class="nav-item nav-link li<?php if (in_array('faq', $linkto)) echo ' active';  ?>">Faq's</a>
                <a href="index.php?exe=contact/contact_us" class="nav-item nav-link li<?php if (in_array('contact', $linkto)) echo ' active';  ?>">Suporte ao Cliente</a>
            </div>
        </div>
    </nav>

    <?php if(isset($page_found) && $page_found == "default"): ?>
        <div class="carousel-header">
        <div id="carouselId" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner" role="listbox">
                <?php
                    $dataText = [];
                    $viewText = [];

                    $Read = new Read();
                    $Read->ExeRead("website_home", "ORDER BY id ASC");

                    if($Read->getResult()):
                        $key = $Read->getResult()[0];
                        foreach ($Read->getResult() as $item):
                            $dataText[] = $item['titulo'];
                        endforeach;
                        $viewText = $dataText;
                        ?>
                        <div class="carousel-item active">
                            <img src="uploads/<?= $Read->getResult()[0]['logotype']; ?>" class="img-fluid" alt="Image">
                            <div class="carousel-caption">
                                <div class="p-3" style="max-width: 900px;">
                                    <h4 class="text-white text-uppercase fw-bold mb-4" style="letter-spacing: 3px;">Software de Gestão Online</h4>
                                    <h1 class="display-2 text-white mb-4"> Software de
                                        Gestão <br/>Para: <span id="xXx"></span></h1>
                                    <p class="mb-5 fs-5">O Kwanzar é um software online que regista e controla as tuas vendas em segundos. Factura online no computador, tablet ou telemóvel.
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
    <?php endif; ?>
</div>
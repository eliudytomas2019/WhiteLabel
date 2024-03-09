<div class="container-fluid footer py-5">
    <div class="container py-5">
        <div class="row g-5">
            <div class="col-md-6 col-lg-6 col-xl-3">
                <div class="footer-item d-flex flex-column">
                    <h4 class="mb-4 text-white"><img src="uploads/<?= $Index['logotype']; ?>" alt="<?= $Index['name']; ?>" style="max-height: 60px!important;" /></h4>
                    <a href=""><i class="fas fa-home me-2"></i> <?= $Index['endereco']; ?></a>
                    <a href=""><i class="fas fa-envelope me-2"></i> <?= $Index['email']; ?></a>
                    <a href=""><i class="fas fa-phone me-2"></i> <?= $Index['telefone']; ?></a>
                    <div class="d-flex align-items-center">
                        <i class="fas fa-share fa-2x text-white me-2"></i>
                        <a class="btn-square btn primary-14 rounded-circle mx-1" href="<?= $Index['facebook']; ?>" target="_blank"><i class="fab fa-facebook-f"></i></a>
                        <a class="btn-square btn primary-14 rounded-circle mx-1" href="<?= $Index['twitter']; ?>" target="_blank"><i class="fab fa-twitter"></i></a>
                        <a class="btn-square btn primary-14 rounded-circle mx-1" href="<?= $Index['instagram']; ?>" target="_blank"><i class="fab fa-instagram"></i></a>
                        <a class="btn-square btn primary-14 rounded-circle mx-1" href="<?= $Index['linkedin']; ?>" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                        <a class="btn-square btn primary-14 rounded-circle mx-1" href="<?= $Index['youtube']; ?>" target="_blank"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-6 col-xl-3">
                <div class="footer-item d-flex flex-column">
                    <h4 class="mb-4 text-white">Negócios</h4>
                    <a href="index.php?exe=functionalities/functionalities_us"><i class="fas fa-angle-right me-2"></i> Funcionalidade</a>
                    <a href="index.php?exe=dental/dental_us"><i class="fas fa-angle-right me-2"></i> Kwanzar Dental</a>
                    <a href="index.php?exe=pricing/pricing_us"><i class="fas fa-angle-right me-2"></i> Preços</a>
                </div>
            </div>
            <div class="col-md-6 col-lg-6 col-xl-3">
                <div class="footer-item d-flex flex-column">
                    <h4 class="mb-4 text-white">Suporte</h4>
                    <a href="index.php?exe=faq/faq_us"><i class="fas fa-angle-right me-2"></i> Faq's</a>
                    <a href="_terms-of-service.php"><i class="fas fa-angle-right me-2"></i> Termos de uso</a>
                    <a href="index.php?exe=contact/contact_us"><i class="fas fa-angle-right me-2"></i> Contactos</a>
                </div>
            </div>
            <div class="col-md-6 col-lg-6 col-xl-3">
                <div class="footer-item d-flex flex-column">
                    <h4 class="mb-4 text-white">Conta</h4>
                    <a href="_register.php" target="_blank"><i class="fas fa-angle-right me-2"></i> Criar conta</a>
                    <a href="_login.php" target="_blank"><i class="fas fa-angle-right me-2"></i> Login</a>
                    <a href="_terms-of-service.php" target="_blank"><i class="fas fa-angle-right me-2"></i> Termos e condições</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid copyright text-body py-4">
    <div class="container">
        <div class="row g-4 align-items-center">
            <div class="col-md-9 text-center text-md-end mb-md-0">
                2019 - <?= date('Y'); ?> | <i class="fas fa-copyright me-2"></i><a class="text-white" href="#"> <?= $Index['name']; ?></a>, Todos os direitos reservados.
            </div>
            <div class="col-md-3 text-center text-md-start">
                <a class="text-white" href="_terms-of-service.php" target="_blank">Termos e condições de uso.</a>
            </div>
        </div>
    </div>
</div>

<a href="#" class="btn btn-primary btn-primary-outline-0 btn-md-square back-to-top"><i class="fa fa-arrow-up"></i></a>


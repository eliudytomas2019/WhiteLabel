<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-5">
            <?php
            $status = 1;
            $euclides_xxx = null;

            $Read = new Read();
            $Read->ExeRead("website_blog", "WHERE status=:st ORDER BY id ASC LIMIT 1", "st={$status}");

            if($Read->getResult()):
                $euclides_xxx = $Read->getResult()[0]['id'];
                foreach ($Read->getResult() as $key):
                    ?>
                    <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s" style="min-height: 400px;">
                        <div class="position-relative h-100">
                            <img class="img-fluid position-absolute w-100 h-100" src="uploads/<?= $key['logotype']; ?>" alt="<?= $key['titulo']; ?>" style="object-fit: cover;background-size: 100% 100%!important;">
                        </div>
                    </div>
                    <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.3s">
                        <h6 class="section-title bg-white text-start text-primary pe-3"><?= $key['subtitulo']; ?></h6>
                        <h1 class="mb-4"><?= $key['titulo']; ?></h1>
                        <?= $key['content']; ?>
                    </div>
                <?php
                endforeach;
            endif;
            ?>
        </div>
    </div>
</div>
<div class="container-fluid about py-5">
    <div class="container py-5">
        <div class="row g-5 align-items-center">
            <?php
            $status = 1;

            $Read = new Read();
            $Read->ExeRead("website_about", "WHERE status=:st ORDER BY id ASC LIMIT 1", "st={$status}");

            if($Read->getResult()):
                foreach ($Read->getResult() as $key):
                    ?>
                    <div class="col-lg-5">
                        <div class="h-100">
                            <img src="uploads/<?= $key['logotype']; ?>" class="img-fluid w-100 h-100" alt="<?= $key['titulo']; ?>">
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <h5 class="section-about-title pe-3"><?= $key['titulo']; ?></h5>
                        <h1 class="mb-4"><?= $key['subtitulo']; ?></h1>
                        <?= $key['content']; ?>
                    </div>
                    <?php
                endforeach;
            endif;
            ?>
        </div>
    </div>
</div>
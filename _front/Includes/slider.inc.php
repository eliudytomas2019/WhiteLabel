<div class="container-xxl py-5 wow fadeInUp" data-wow-delay="0.1s">
    <div class="container px-lg-5">
        <div class="owl-carousel testimonial-carousel">
            <?php
            $Read = new Read();
            $Read->ExeRead("db_settings", "ORDER BY id ASC");

            if($Read->getResult()):
                foreach ($Read->getResult() as $key):
                    if(!empty($key['logotype']) || isset($key['logotype'])):
                        ?>
                        <div class="testimonial-item rounded p-4 mt-4">
                            <div class="d-flex align-items-center">
                                <img  alt="<?= $key['empresa']; ?>" class="img-fluid flex-shrink-0" src="uploads/<?= $key['logotype']; ?>" style="max-width: 215px!important;max-height: 120px!important;">
                            </div>
                        </div>
                    <?php
                    endif;
                endforeach;
            endif;
            ?>
        </div>
    </div>
</div>
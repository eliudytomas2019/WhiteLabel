<div class="container-fluid bg-light service py-5">
    <div class="container py-5">
        <div class="mx-auto text-center mb-5" style="max-width: 900px;">
            <h5 class="section-title px-3">Começa hoje mesmo a facturar!</h5>
            <h1 class="mb-0">Funciona em Windows, Mac, Linux, Android, IOS, no portátil, telemóvel e tablet. Compatível com impressoras de talões e impressoras A4.</h1>
        </div>
        <div class="row">
            <div class="col-lg-12 g-4">
                <div class="row g-4" style="display: flex!important;flex-direction: row!important;justify-content: space-between!important; margin: 5px!important;">
                    <?php
                    $n = null;
                    $Array = ["", "fa-fast-forward", "fa-cash-register", "fa-arrow-alt-circle-up", "fa-cloud-sun-rain", "", ""];
                    $status = 1;
                    $Read = new Read();
                    $Read->ExeRead("website_services", "WHERE status=:st ORDER BY id ASC LIMIT 6", "st={$status}");

                    if($Read->getResult()):
                        foreach ($Read->getResult() as $key):
                            $n += 1;
                            ?>
                            <div class="col-lg-4">
                                <div class="card-body">
                                    <h5 class="card-title"><?= $key['titulo']; ?></h5>
                                    <p><?= $key['content']; ?></p>
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
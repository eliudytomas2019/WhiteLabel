<div class="accordion" id="accordion-example">
    <div class="accordion-item">
        <h2 class="accordion-header" id="heading-1">
            <button class="accordion-button " type="button" data-bs-toggle="collapse" data-bs-target="#collapse-1" aria-expanded="true">
                ODONTOGRAMA (Permanentes)
            </button>
        </h2>
        <div id="collapse-1" class="accordion-collapse collapse show" data-bs-parent="#accordion-example">
            <div class="col-lg-12">
                <div class="odontograma_permanentes">
                    <div class="odontograma_permanentes_header">
                        <?php
                        $modelo = "permanentes";
                        $arcada = "arcada_superior";

                        $Read = new Read();
                        $Read->ExeRead("cv_customer_odontograma", "WHERE id_paciente=:i AND id_db_settings=:st AND arcada=:ix AND modelo=:sty ORDER BY id ASC ", "i={$postid}&st={$id_db_settings}&ix={$arcada}&sty={$modelo}");

                        if($Read->getResult()):
                            foreach ($Read->getResult() as $key):
                                ?>
                                <a href="#" onclick="Marmelada(<?= $key['id']; ?>, <?= $postid; ?>);" data-bs-toggle="modal" data-bs-target="#modal-odontograma"><div class="odontograma_dentes">
                                        <?php if($key['status'] == 4): ?><span class="none_dente">X</span><?php endif; ?>
                                        <img class="odontograma_img" src="uploads/odontograma/<?= $key['dente']; ?>.png"/>
                                        <div class="odontograma_number statys_<?= $key['status']; ?>"><?= $key['dente']; ?></div>
                                    </div></a>
                            <?php
                            endforeach;
                        endif;
                        ?>
                    </div>
                    <div class="odontograma_permanentes_body">
                        <?php
                        $modelo1 = "permanentes";
                        $arcada1 = "arcada_inferior";

                        $Read = new Read();
                        $Read->ExeRead("cv_customer_odontograma", "WHERE id_paciente=:i AND id_db_settings=:st AND arcada=:ix AND modelo=:sty ORDER BY id ASC ", "i={$postid}&st={$id_db_settings}&ix={$arcada1}&sty={$modelo1}");

                        if($Read->getResult()):
                            foreach ($Read->getResult() as $key):
                                ?>
                                <a href="#" onclick="Marmelada(<?= $key['id']; ?>, <?= $postid; ?>);" data-bs-toggle="modal" data-bs-target="#modal-odontograma">
                                    <div class="odontograma_dentes">
                                        <div class="odontograma_number statys_<?= $key['status']; ?>"><?= $key['dente']; ?></div>
                                        <?php if($key['status'] == 4): ?><span class="none_dente">X</span><?php endif; ?>
                                        <img class="odontograma_img" src="uploads/odontograma/<?= $key['dente']; ?>.png"/>
                                    </div>
                                </a>
                            <?php
                            endforeach;
                        endif;
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="accordion-item">
        <h2 class="accordion-header" id="heading-2">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-2" aria-expanded="false">
                ODONTOGRAMA (Decidous)
            </button>
        </h2>
        <div id="collapse-2" class="accordion-collapse collapse" data-bs-parent="#accordion-example">
            <div class="col-lg-12">
                <div class="odontograma_permanentes">
                    <div class="odontograma_permanentes_header">
                        <?php
                        $modelo2 = "decidous";
                        $arcada2 = "arcada_superior";

                        $Read = new Read();
                        $Read->ExeRead("cv_customer_odontograma", "WHERE id_paciente=:i AND id_db_settings=:st AND arcada=:ix AND modelo=:sty ORDER BY id ASC ", "i={$postid}&st={$id_db_settings}&ix={$arcada2}&sty={$modelo2}");

                        if($Read->getResult()):
                            foreach ($Read->getResult() as $key):
                                ?>
                                <a href="#" onclick="Marmelada(<?= $key['id']; ?>, <?= $postid; ?>);" data-bs-toggle="modal" data-bs-target="#modal-odontograma"><div class="odontograma_dentes">
                                        <?php if($key['status'] == 4): ?><span class="none_dente">X</span><?php endif; ?>
                                        <img class="odontograma_img" src="uploads/odontograma/<?= $key['dente']; ?>.png"/>
                                        <div class="odontograma_number statys_<?= $key['status']; ?>"><?= $key['dente']; ?></div>
                                    </div></a>
                            <?php
                            endforeach;
                        endif;
                        ?>
                    </div>
                    <div class="odontograma_permanentes_body">
                        <?php
                        $modelo3 = "decidous";
                        $arcada3 = "arcada_inferior";

                        $Read = new Read();
                        $Read->ExeRead("cv_customer_odontograma", "WHERE id_paciente=:i AND id_db_settings=:st AND arcada=:ix AND modelo=:sty ORDER BY id ASC ", "i={$postid}&st={$id_db_settings}&ix={$arcada3}&sty={$modelo3}");

                        if($Read->getResult()):
                            foreach ($Read->getResult() as $key):
                                ?>
                                <a href="#" onclick="Marmelada(<?= $key['id']; ?>, <?= $postid; ?>);" data-bs-toggle="modal" data-bs-target="#modal-odontograma">
                                    <div class="odontograma_dentes">
                                        <div class="odontograma_number statys_<?= $key['status']; ?>"><?= $key['dente']; ?></div>
                                        <?php if($key['status'] == 4): ?><span class="none_dente">X</span><?php endif; ?>
                                        <img class="odontograma_img" src="uploads/odontograma/<?= $key['dente']; ?>.png"/>
                                    </div>
                                </a>
                            <?php
                            endforeach;
                        endif;
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
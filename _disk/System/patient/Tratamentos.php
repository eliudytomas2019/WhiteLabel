<?php
require_once("_disk/IncludesApp/PatientUsers.inc.php");
?>
<br/><div class="row gx-lg-4">
    <?php require_once("_disk/IncludesApp/MenuPatient.inc.php"); ?>
    <div class="col-lg-9">
        <div class="card">
            <div class="card-header">
                <h5 class="modal-title">Tratamento</h5>
            </div>
            <div class="card-body">
                <div id="Gulheirmina">
                    <?php require_once("_disk/SystemClinic/Odontograma.inc.php"); ?>
                </div>

                <br/><div class="col-lg-12">
                    <div id="TiPaulito"></div>
                    <form method="post" action="" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-lg-6">
                                <label>Dente</label>
                                <select name="dente" id="dente" class="form-control">
                                    <option value="">-- Selecione se Houver --</option>
                                    <?php
                                        for($in = 1; $in <= 52; $in++):
                                            ?>
                                            <option value="<?= $ArrayOdontograma[$in]; ?>"><?= $ArrayOdontograma[$in]; ?></option>
                                            <?php
                                        endfor;
                                    ?>
                                    <option value="arcada_superior">Arcada Superior</option>
                                    <option value="arcada_inferior">Arcada Inferior</option>
                                </select>
                            </div>
                            <div class="col-lg-6">
                                <label>Face</label>
                                <select name="face" id="face" class="form-control">
                                    <option value="">-- Selecione se Houver --</option>
                                    <option value="M">M</option>
                                    <option value="O/I">O/I</option>
                                    <option value="D">D</option>
                                    <option value="V">V</option>
                                    <option value="L/P">L/P</option>
                                    <option value="T">T</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <label>Procedimento</label>
                                <select name="id_procedimento" id="id_procedimento" class="form-control">
                                    <option value="">-- Selecione se Houver --</option>
                                    <?php
                                        $Read = new Read;
                                        $Read->ExeRead("cv_product", "WHERE id_db_settings=:st ", "st={$id_db_settings}");

                                        if($Read->getResult()):
                                            foreach ($Read->getResult() as $key):
                                                ?>
                                                <option value="<?= $key['id']; ?>"><?= $key['product']; ?></option>
                                                <?php
                                            endforeach;
                                        endif;
                                    ?>
                                </select>
                            </div>
                            <div class="col-lg-3">
                                <label>Data</label>
                                <input type="date" class="form-control" id="data" name="data" value="<?= date('Y-m-d'); ?>"/>
                            </div>
                            <div class="col-lg-3">
                                <label>Hora</label>
                                <input type="time" class="form-control" id="hora" name="hora" value="<?= date('H:i'); ?>"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <label>Descrição/Observação</label>
                                <textarea name="content_data" id="content_data" placeholder="Descrição" class="form-control"></textarea>
                            </div>
                        </div>
                        <?php if($level == 3 || $level >= 4): ?>
                            <br/><div class="modal-footer">
                                <button type="button" class="btn btn-primary" onclick="Tratamento(<?= $postid; ?>, <?= $id_user; ?>, <?= $id_db_settings; ?>);">Adicionar tratamento</button>
                            </div>
                        <?php endif; ?>
                    </form>
                </div>

                <br/><div class="col-lg-12">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Data</th>
                            <th>Procedimento</th>
                            <th>Dente(s)</th>
                            <th>Face(s)</th>
                            <th>Médico</th>
                            <th>-</th>
                        </tr>
                        </thead>
                        <tbody id="OFilme">
                            <?php require_once("_disk/SystemClinic/OFilme.inc.php"); ?>
                        </tbody>
                    </table>
                    <div class="card-footer d-flex align-items-center">
                        <?php
                        $Pager->ExePaginator("cv_customer_tratamento", "WHERE id_paciente=:i AND id_db_settings=:id ORDER BY id DESC", "i={$postid}&id={$id_db_settings}");
                        echo $Pager->getPaginator();
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
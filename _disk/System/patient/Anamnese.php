<?php
require_once("_disk/IncludesApp/PatientUsers.inc.php");
?>
<br/><div class="row gx-lg-4">
    <?php require_once("_disk/IncludesApp/MenuPatient.inc.php"); ?>
    <div class="col-lg-9">
        <div class="card">
            <div class="card-header">
                <h5 class="modal-title">Anamnese</h5>
            </div>
            <div class="card-body">
                <?php
                $ClienteData = filter_input_array(INPUT_POST, FILTER_DEFAULT);
                if ($ClienteData && $ClienteData['SendPostForm']):
                    $Count = new KwanzarDental();
                    $Count->Anamnese($postid, $ClienteData, $id_db_settings);

                    if($Count->getResult()):
                        WSError($Count->getError()[0], $Count->getError()[1]);

                        $ReadUser = new Read;
                        $ReadUser->ExeRead("cv_customer_anamnese", "WHERE id_paciente=:userid AND id_db_settings=:i", "userid={$postid}&i={$id_db_settings}");
                        if ($ReadUser->getResult()):
                            $ClienteData = $ReadUser->getResult()[0];
                        endif;
                    else:
                        WSError($Count->getError()[0], $Count->getError()[1]);
                    endif;
                else:
                    $ReadUser = new Read;
                    $ReadUser->ExeRead("cv_customer_anamnese", "WHERE id_paciente=:userid AND id_db_settings=:i", "userid={$postid}&i={$id_db_settings}");
                    if ($ReadUser->getResult()):
                        $ClienteData = $ReadUser->getResult()[0];
                    endif;
                endif;
                ?>
                <div id="getResult"></div>

                <div class="col-lg-12">
                    <?php if(isset($ClienteData['id']) && !empty($ClienteData['id'])): ?>
                        <div class="row align-items-center">
                            <div class="col-auto ms-auto">
                                <div class="btn-list">
                                    <a href="print_dental.php?<?= $n; ?>&postId=<?= $ClienteData['id']; ?>&id_paciente=<?= $postid; ?>&action=01" target="_blank" class="btn btn-primary"><!-- Download SVG icon from http://tabler-icons.io/i/receipt -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 21v-16a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v16l-3 -2l-2 2l-2 -2l-2 2l-2 -2l-3 2m4 -14h6m-6 4h6m-2 4h2" /></svg> Imprimir</a>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <br/><form method="post" action="" enctype="multipart/form-data">
                        <div class="col-md-12">
                            <div class="card" style="height: calc(24rem + 10px)">
                                <div class="card-body card-body-scrollable card-body-scrollable-shadow">
                                    <div class="divide-y">
                                        <div>
                                            <?php
                                                for($i = 1; $i <= 68; $i++):
                                                    ?>
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <h3><?= $Anamnese[$i]; ?></h3>
                                                            <div class="col-lg-12">
                                                                <label class="form-check">
                                                                    <input class="form-check-input" <?php if(isset($ClienteData["anamnese_{$i}"]) && $ClienteData["anamnese_{$i}"] == "Sim") echo "checked"; ?> value="Sim" name="anamnese_<?= $i; ?>" id="anamnese_<?= $i; ?>" type="radio" >
                                                                    <span class="form-check-label">Sim</span>
                                                                </label>
                                                                <label class="form-check">
                                                                    <input class="form-check-input" <?php if(isset($ClienteData["anamnese_{$i}"]) && $ClienteData["anamnese_{$i}"] == "Não") echo "checked"; ?> value="Não" name="anamnese_<?= $i; ?>" id="anamnese_<?= $i; ?>" type="radio">
                                                                    <span class="form-check-label">Não</span>
                                                                </label>
                                                                <label class="form-check">
                                                                    <input class="form-check-input" <?php if(isset($ClienteData["anamnese_{$i}"]) && $ClienteData["anamnese_{$i}"] == "Não sei") echo "checked"; ?> value="Não sei" name="anamnese_<?= $i; ?>" id="anamnese_<?= $i; ?>" type="radio">
                                                                    <span class="form-check-label">Não sei</span>
                                                                </label>
                                                                <label class="form-check">
                                                                    <input class="form-control" value="<?php if (!empty($ClienteData["anamnese_{$i}_{$i}"])) echo $ClienteData["anamnese_{$i}_{$i}"]; ?>" name="anamnese_<?= $i; ?>_<?= $i; ?>" id="anamnese_<?= $i; ?>_<?= $i; ?>" placeholder="Informações adicionais" type="text">
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                endfor;
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <br/><div class="col-lg-12">
                            <input type="submit" name="SendPostForm" class="btn btn-primary ms-auto" value="Salvar"/>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
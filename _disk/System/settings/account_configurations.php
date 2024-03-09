
<?php
if(!class_exists('login')):
    header("index.php");
    die();
endif;

if($level >= 4): $n =  '&id_db_settings='.$id_db_settings; else: $n = null; endif;
?>
<div class="page-header d-print-none">
    <div class="row align-items-center">
        <div class="col">
            <h2 class="page-title">
                Configurações
            </h2>
        </div>
    </div>
</div>
<div class="row gx-lg-4">
    <?php require_once("_disk/IncludesApp/MenuSettings.inc.php"); ?>
    <div class="col-lg-9">
        <div class="card">
            <div class="card-header">
                <h5 class="modal-title">Configurações da conta</h5>
            </div>
            <div class="card-body">
                <div id="getError"></div>
                <form method="post" action="" name="FormConfig">
                    <?php
                    /**
                     * Created by PhpStorm.
                     * User: Kwanzar Soft
                     * Date: 31/05/2020
                     * Time: 15:32
                     */

                    $ClienteData = filter_input(INPUT_POST, FILTER_DEFAULT);
                    if ($ClienteData && $ClienteData['SendPostForm']):

                    else:
                        $ReadUser = new Read;
                        $ReadUser->ExeRead("db_users_settings", "WHERE session_id= :userid", "userid={$id_user}");
                        if (!$ReadUser->getResult()):
                        else:
                            $ClienteData = $ReadUser->getResult()[0];
                        endif;
                    endif;
                    ?>

                    <div class="row">
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label class="form-label">Modelo de impressora</label>
                                <select name="Impression" id="Impression" class="form-control">
                                    <option value="">-- Selecione o modelo de impressora --</option>
                                    <option value="A4" <?php if (isset($ClienteData['Impression']) && $ClienteData['Impression'] == 'A4') echo 'selected="selected"'; ?>>A4</option>
                                    <option value="72" <?php if (isset($ClienteData['Impression']) && $ClienteData['Impression'] == '72') echo 'selected="selected"'; ?>>72mm/48 colunas</option>
                                    <option value="58" <?php if (isset($ClienteData['Impression']) && $ClienteData['Impression'] == '58') echo 'selected="selected"'; ?>>58mm/32 colunas</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label class="form-label">Número de páginas</label>
                                <select class="form-control" name="NumberOfCopies" id="NumberOfCopies">
                                    <option value="">-- Selecione o número de páginas --</option>
                                    <option value="1" <?php if (isset($ClienteData['NumberOfCopies']) && $ClienteData['NumberOfCopies'] == '1') echo 'selected="selected"'; ?>>Original</option>
                                    <option value="2" <?php if (isset($ClienteData['NumberOfCopies']) && $ClienteData['NumberOfCopies'] == '2') echo 'selected="selected"'; ?>>Duplicado</option>
                                    <option value="3" <?php if (isset($ClienteData['NumberOfCopies']) && $ClienteData['NumberOfCopies'] == '3') echo 'selected="selected"'; ?>>Triplicado</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-4" hidden>
                            <div class="mb-3">
                                <label class="form-label">Pergunta de recuperação de senha</label>
                                <select class="form-control" name="PRecuvaPassword" id="PRecuvaPassword">
                                    <option value="">-- Selecione a pergunta de recuperação de senha --</option>
                                    <option value="1" <?php if (isset($ClienteData['PRecuvaPassword']) && $ClienteData['PRecuvaPassword'] == '1') echo 'selected="selected"'; ?>>Qual é a escola onde fiz o ensimo primario?</option>
                                    <option value="2" <?php if (isset($ClienteData['PRecuvaPassword']) && $ClienteData['PRecuvaPassword'] == '2') echo 'selected="selected"'; ?>>Qual é o nome do meu animal de estimação?</option>
                                    <option value="3" <?php if (isset($ClienteData['PRecuvaPassword']) && $ClienteData['PRecuvaPassword'] == '3') echo 'selected="selected"'; ?>>Qual a minha cor favorita?</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-4" hidden>
                            <div class="mb-3">
                                <label class="form-label">Resposta a pergunta de verificação de senha</label>
                                <input type="text" name="RecuvaPassword" id="RecuvaPassword" value="<?php if (!empty($ClienteData['RecuvaPassword'])) echo $ClienteData['RecuvaPassword']; ?>" class="form-control" placeholder="Resposta a pergunta de verificação de senha"/>
                            </div>
                        </div>

                        <div class="col-lg-4" hidden>
                            <div class="mb-3">
                                <label class="form-label">Idioma do software</label>
                                <select class="form-control" name="Language" id="Language">
                                    <option value="">-- Selecione o idioma do software --</option>
                                    <option value="1" <?php if (isset($ClienteData['Language']) && $ClienteData['Language'] == '1') echo 'selected="selected"'; ?>>Português</option>
                                    <option value="2" <?php if (isset($ClienteData['Language']) && $ClienteData['Language'] == '2') echo 'selected="selected"'; ?>>Inglês</option>
                                    <option value="3" <?php if (isset($ClienteData['Language']) && $ClienteData['Language'] == '3') echo 'selected="selected"'; ?>>Chinês</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label class="form-label">Orientação do menu</label>
                                <select name="positionMenu" id="positionMenu" class="form-control">
                                    <option value="">-- Selecione orientação do menu --</option>
                                    <option value="1" <?php if (isset($ClienteData['positionMenu']) && $ClienteData['positionMenu'] == '1') echo 'selected="selected"'; ?>>Vertical</option>
                                    <option value="2" <?php if (isset($ClienteData['positionMenu']) && $ClienteData['positionMenu'] == '2') echo 'selected="selected"'; ?>>Horizontal</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <a href="javascript:void" onclick="ConfigUsers()"  class="btn btn-primary">Salvar</a>
                </form>
            </div>
        </div>
    </div>
</div>
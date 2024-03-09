<?php
if(!class_exists('login')):
    header("index.php");
    die();
endif;

if($level >= 4): $n =  '&id_db_settings='.$id_db_settings; else: $n = null; endif;

if($userlogin['level'] < 1):
    header("location: panel.php?exe=default/home".$n);
endif;
?>
<div class="page-header d-print-none">
    <div class="row align-items-center">

        <div class="col-auto ms-auto d-print-none">
            <div class="btn-list">
                <a href="panel.php?exe=local/index<?= $n; ?>" class="btn btn-primary d-none d-sm-inline-block">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 13l-4 -4l4 -4m-4 4h11a4 4 0 0 1 0 8h-1" /></svg>
                    Voltar
                </a>
            </div>
        </div>
        <div class="col">
            <div class="page-pretitle">
                <?= $Index['name']; ?>
            </div>
            <h2 class="page-title">
                Local
            </h2>
        </div>
    </div>
</div>

<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h5 class="modal-title">Atualizar local</h5>
        </div>
        <div class="card-body">
            <form  method="post" action="" name = "SendPostForm"  enctype="multipart/form-data">
                <div class="card-body">
                    <div class="mb-3">
                        <?php
                            $userId = filter_input(INPUT_GET, 'postid', FILTER_VALIDATE_INT);
                            $ClienteData = filter_input_array(INPUT_POST, FILTER_DEFAULT);
                            if ($ClienteData && $ClienteData['SendPostForm']):
                                $Count = new Mesas();
                                $Count->ExeUpdate($userId, $ClienteData, $id_db_settings);

                                if($Count->getResult()):
                                    WSError($Count->getError()[0], $Count->getError()[1]);
                                else:
                                    WSError($Count->getError()[0], $Count->getError()[1]);
                                endif;
                            else:
                                $ReadUser = new Read;
                                $ReadUser->ExeRead("cv_mesas", "WHERE id = :userid AND id_db_settings=:i", "userid={$userId}&i={$id_db_settings}");
                                if (!$ReadUser->getResult()):

                                else:
                                    $ClienteData = $ReadUser->getResult()[0];
                                endif;
                            endif;
                        ?>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label class="form-label">Local</label>
                                    <input type="text" name="name" class="form-control" value="<?php if (!empty($ClienteData['name'])) echo $ClienteData['name']; ?>" placeholder="Local"> </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label class="form-label">Capacidade</label>
                                    <input type="text" name="capacidade" class="form-control" value="<?php if (!empty($ClienteData['capacidade'])) echo $ClienteData['capacidade']; ?>" placeholder="Quantidade de Cadeiras"> </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label class="form-label">Localização</label>
                                    <input type="text" name="localizacao" class="form-control" value="<?php if (!empty($ClienteData['localizacao'])) echo $ClienteData['localizacao']; ?>" placeholder="Localização"> </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label class="form-label">Observações</label>
                                    <textarea name="obs" class="form-control" placeholder="Descrição"><?php if (!empty($ClienteData['obs'])) echo $ClienteData['obs']; ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" name="SendPostForm" class="btn btn-primary ms-auto" value="Salvar"/>
                </div>
            </form>
        </div>
    </div>
</div>
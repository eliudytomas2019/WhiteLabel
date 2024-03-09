<?php
if(!class_exists('login')):
    header("index.php");
    die();
endif;

if($level >= 4): $n =  '&id_db_settings='.$id_db_settings; else: $n = null; endif;

if($userlogin['level'] < 1):
    header("location: panel.php?exe=default/index".$n);
endif;

$postId = filter_input(INPUT_GET, "postid", FILTER_VALIDATE_INT);
?>
<div class="page-header d-print-none">
    <div class="row align-items-center">

        <div class="col-auto ms-auto d-print-none">
            <div class="btn-list">
                <a href="panel.php?exe=customer/index<?= $n; ?>" class="btn btn-primary">
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
                Clientes
            </h2>
        </div>
    </div>
</div>

<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h5 class="modal-title">Limite de Crédito</h5>
        </div>
        <div class="card-body">
            <form  method="post" action="" name = "SendPostForm"  enctype="multipart/form-data">
                <div class="card-body">
                    <div class="mb-3"><div id="getResult">
                            <?php
                            $ClienteData = filter_input_array(INPUT_POST, FILTER_DEFAULT);
                            $userId = filter_input(INPUT_GET, 'postid', FILTER_VALIDATE_INT);
                            if ($ClienteData && $ClienteData['SendPostForm']):
                                $Count = new Customer;
                                $Count->ExeCredito($userId, $ClienteData, $id_db_settings);

                                if($Count->getResult()):
                                    WSError($Count->getError()[0], $Count->getError()[1]);

                                    $ReadUser = new Read;
                                    $ReadUser->ExeRead("cv_customer_credito", "WHERE id_customer = :userid AND id_db_settings=:i", "userid={$userId}&i={$id_db_settings}");
                                    if ($ReadUser->getResult()):
                                        $ClienteData = $ReadUser->getResult()[0];
                                    endif;
                                else:
                                    WSError($Count->getError()[0], $Count->getError()[1]);
                                endif;
                            else:
                                $ReadUser = new Read;
                                $ReadUser->ExeRead("cv_customer_credito", "WHERE id_customer= :userid AND id_db_settings=:i", "userid={$userId}&i={$id_db_settings}");

                                if ($ReadUser->getResult()):
                                    $ClienteData = $ReadUser->getResult()[0];
                                endif;
                            endif;
                            ?>
                        </div></div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label class="form-label">Valor do Crédito</label>
                                <input name="credito" id="credito" class="form-control" placeholder="Valor do Crédito"  value="<?php if (!empty($ClienteData['credito'])) echo $ClienteData['credito']; ?>" type="text">
                            </div>
                        </div>
                    </div>
                </div>
                <hr/>
                <div class="modal-footer">
                    <input type="submit" name="SendPostForm" class="btn btn-primary ms-auto" value="Salvar"/>
                </div>
            </form>
        </div>
    </div>
</div>
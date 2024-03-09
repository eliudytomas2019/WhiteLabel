<?php
if(!class_exists('login')):
    header("index.php");
    die();
endif;

if($level >= 4): $n =  '&id_db_settings='.$id_db_settings; else: $n = null; endif;

if($userlogin['level'] < 1):
    header("location: panel.php?exe=default/index".$n);
endif;
?>

<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <div class="page-pretitle">
                <?= $Index['name']; ?>
            </div>
            <h2 class="page-title">
                Sangrar o Caixa
            </h2>
        </div>
        <div class="col-auto ms-auto">
            <div class="btn-list">

            </div>
        </div>
    </div>
</div>


<div class="row row-cards">
    <div class="col-12">
        <form action="" method="post" class="card">
            <div class="card-header">
                <h4 class="card-title"> Sangrar o Caixa</h4>
            </div>
            <div class="card-body">
                <div id="getResult">
                    <?php
                    $ClienteData = filter_input_array(INPUT_POST, FILTER_DEFAULT);
                    if ($ClienteData && $ClienteData['SendPostFormL']):
                        $Count = new Caixa();
                        $Count->Sangrar($ClienteData, $id_db_settings, $id_user);

                        if($Count->getResult()):
                            WSError($Count->getError()[0], $Count->getError()[1]);
                        else:
                            WSError($Count->getError()[0], $Count->getError()[1]);
                        endif;
                    endif;
                    ?>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="mb-3">
                            <label class="form-label">Valor</label>
                            <input type="text" name = "valor" id="valor" value="<?php if (!empty($ClienteData['valor'])) echo $ClienteData['valor']; ?>" class="form-control"  placeholder="Valor">
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="mb-3">
                            <label class="form-label">Descrição</label>
                            <textarea placeholder="Descrição" class="form-control" name="description" id="description"><?php if (!empty($ClienteData['description'])) echo htmlspecialchars($ClienteData['description']); ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-end">
                <div class="d-flex">
                    <input type="submit" name="SendPostFormL" class="btn btn-primary" value="Salvar"/>
                </div>
            </div>
        </form>
    </div>
</div>


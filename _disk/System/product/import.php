<?php
use League\Csv\Reader;
use League\Csv\Whiter;
require "vendor/autoload.php";

if(!class_exists('login')):
    header("index.php");
    die();
endif;

if($level >= 4): $n =  '&id_db_settings='.$id_db_settings; else: $n = null; endif;

if($userlogin['level'] < 1):
    header("location: panel.php?exe=default/index".$n);
endif;
?>
<div class="page-header d-print-none">
    <div class="row align-items-center">

        <div class="col-auto ms-auto d-print-none">
            <div class="btn-list">
                <a href="panel.php?exe=product/index<?= $n; ?>" class="btn btn-primary">
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
                Importar Itens
            </h2>
        </div>
    </div>
</div>

<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h5 class="modal-title">Importação de dados</h5>
        </div>
        <div class="card-body">
            <form class="form-horizontal" method="post" action="" name="SendPostFormL"  enctype="multipart/form-data">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label class="form-label">* Poderá importar ficheiros até 5 mil linhas, faça download do modelo: <a href="download.php" target="_blank">Modelo de Itens</a> </label>
                                <label class="form-label"><strong>Tenha atenção ao seguinte:</strong></label>
                                <label class="form-label">- Formato do ficheiro deve ser .csv</label>
                                <label class="form-label">- E os campos devem estar delimitado com <strong>ponto e vírgula</strong></label>
                            </div>
                        </div>
                    </div>
                    <div id="getResult">
                        <?php
                        $ClienteData = filter_input_array(INPUT_POST, FILTER_DEFAULT);
                        $userId = filter_input(INPUT_GET, 'postid', FILTER_VALIDATE_INT);
                        if ($ClienteData && $ClienteData['SendPostFormL']):
                            $logoty['file'] = ($_FILES['file']['tmp_name'] ? $_FILES['file'] : null);

                            $Count = new Product();
                            $Count->ExeImport($logoty, $id_db_settings);

                            if($Count->getResult()):
                                $Read = new Read();
                                $Read->ExeRead("cv_product_import", "WHERE id_db_settings=:i ORDER BY id DESC LIMIT 1", "i={$id_db_settings}");

                                if($Read->getResult()):
                                    $csv = $Read->getResult()[0]['file'];

                                    $stream = fopen("uploads/{$csv}", "r");
                                    $cvs = Reader::createFromStream($stream);

                                    $cvs->setDelimiter(";");
                                    $cvs->setOffset(0);

                                    foreach ($cvs as $user):
                                        $Data['codigo']        = strip_tags(trim(htmlspecialchars($user[0])));
                                        $Data['codigo_barras'] = strip_tags(trim(htmlspecialchars($user[1])));
                                        $Data['product']       = strip_tags(trim(htmlspecialchars($user[2])));

                                        if(isset($user[3])): $Data['quantidade']     = abs($user[3]); endif;
                                        if(isset($user[4])): $Data['preco_venda']    =  abs($user[4]); endif;
                                        if(isset($user[5])): $Data['local_product']  = strip_tags(trim(htmlspecialchars($user[5]))); endif;
                                        if(isset($user[6])): $Data['custo_compra']   = abs($user[6]); endif;
                                        if(isset($user[7])): $Data['remarks'] = strip_tags(trim(htmlspecialchars($user[7]))); endif;

                                        $tax = DBKwanzar::CheckConfig($id_db_settings)['taxa_preferencial'];
                                        $read = new Read();
                                        $read->ExeRead("db_taxtable", "WHERE taxtableEntry=:idd AND id_db_settings=:id ORDER BY taxPercentage ASC, taxCode ASC", "idd={$tax}&id={$id_db_settings}");

                                        if($read->getResult()):
                                            foreach ($read->getResult() as $key):
                                                $Data['iva'] = $key['taxPercentage'];
                                                $Data['id_iva'] = $key['taxtableEntry'];
                                            endforeach;
                                        endif;

                                        $Data['id_db_settings'] = $id_db_settings;
                                        $Data['type'] = "P";
                                        $Data['ILoja'] = 2;

                                        $Count->ExeCreateII($Data);

                                        if($Count->getResult()):
                                            WSError($Count->getError()[0], $Count->getError()[1]);
                                        else:
                                            WSError($Count->getError()[0], $Count->getError()[1]);
                                        endif;
                                    endforeach;
                                endif;
                            else:
                                WSError($Count->getError()[0], $Count->getError()[1]);
                            endif;
                        endif;
                        ?>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label class="form-label">Ficheiro (.csv ou .txt)</label>
                                <input type="file" name="file" id="file" accept=".csv, .txt" class="form-control" placeholder="" value="">
                            </div>
                        </div>
                    </div>
                </div>

                <hr/>
                <div class="modal-footer">
                    <input type="submit" name="SendPostFormL" class="btn btn-primary ms-auto" value="Salvar"/>
                </div>
            </form>
        </div>
    </div>
</div>
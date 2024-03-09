<?php
/**
 * Created by PhpStorm.
 * User: Kwanzar Soft
 * Date: 20/09/2020
 * Time: 23:47
 */

if(!class_exists('login')):
    header("index.php");
    die();
endif;

if($level >= 4): $n =  '&id_db_settings='.$id_db_settings; else: $n = null; endif;

if($userlogin['level'] < 2):
    header("location: panel.php?exe=default/index".$n);
endif;

$postid = filter_input(INPUT_GET, 'postid', FILTER_VALIDATE_INT);
?>

<div class="container">

    <div class="styles">
        <a href="<?= HOME; ?>panel.php?exe=product/index<?= $n; ?>" class="btn btn-primary btn-sm">
           Voltar
        </a>&nbsp;
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="form-group d-none d-sm-inline-block form-inline mr-auto ml-md-4 my-3 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" id="searchProductInfo" class="form-control bg-light border-0 small" placeholder="Buscar Produto/Serviço"  aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <input class="btn btn-primary" name="searchProductInfo" type="submit" value="Pesquisar">
                            </div>
                        </div>
                    </div>

                    <div id="aPaulo"></div>

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>PRODUTO</th>
                                    <th>QTD/LOJA.</th>
                                    <th>QTD/PEDIDA.</th>
                                    <th>QTD/STOCK.</th>
                                    <th>QTD/TRANS.</th>
                                    <th>-</th>
                                </tr>
                            </thead>
                            <tbody id="getResult">
                                <?php
                                    $st = 1;

                                    $Read = new Read();
                                    $Read->ExeRead("cv_pedido_product", "WHERE id_db_settings=:i AND status=:ip ORDER BY qtdOne DESC", "i={$id_db_settings}&ip={$st}");

                                    if($Read->getResult()):
                                        foreach($Read->getResult() as $key):
                                            //extract($key);
                                            $read->ExeRead("cv_product", "WHERE id=:i AND id_db_settings=:ip", "i={$key['id_product']}&ip={$id_db_settings}");
                                            if($read->getResult()):
                                                $DB = new DBKwanzar();
                                                if($DB->CheckCpanelAndSettings($id_db_settings)['atividade'] != 1):
                                                    $NnM = $read->getResult()[0]['unidades'];
                                                else:
                                                    $NnM = $read->getResult()[0]['quantidade'];
                                                endif;
                                                 ?>
                                                <tr>
                                                    <td><?= $read->getResult()[0]['id'];  ?></td>
                                                    <td><?= $read->getResult()[0]['product'];  ?></td>
                                                    <td><?= number_format($NnM, 2);  ?></td>
                                                    <td><?= number_format($key['qtdOne'], 2);  ?></td>
                                                    <?php
                                                        $s = 1;
                                                        $read = new Read();
                                                        $read->ExeRead("sd_purchase", "WHERE id_db_settings=:id AND id_product=:ipp AND status=:s ORDER BY id  DESC", "id={$id_db_settings}&ipp={$key['id_product']}&s={$s}");
                                                        if($read->getResult()):
                                                            foreach ($read->getResult() as $info):
                                                                //extract($info);
                                                                ?>
                                                                <td><?= number_format($info['quantidade'], 2); ?>
                                                                <td>
                                                                    <input type="hidden" name="unidade" id="unidade" class="unidade" value="<?= $info['unidade']; ?>"/>
                                                                    <input type="number" value="<?= $key['qtdOne']; ?>" min="1" class="form-control" placeholder="QTD" name="qtdOne_<?= $info['id']; ?>" id="qtdOne_<?= $info['id']; ?>"/>
                                                                </td>
                                                                <td><a href="javascript:void()" onclick="ForPurchase(<?= $info['id']; ?>)" class="btn btn-sm btn-primary"><i class="far fa-paper-plane"></i></a></td>
                                                                <?php
                                                            endforeach;
                                                        else:
                                                            ?><td><?= number_format(0, 2); ?></td><?php
                                                        endif;
                                                    ?>
                                                </tr>
                                                 <?php
                                            endif;
                                        endforeach;
                                    endif;
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

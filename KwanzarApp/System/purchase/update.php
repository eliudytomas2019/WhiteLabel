<?php
/**
 * Created by PhpStorm.
 * User: Kwanzar Soft
 * Date: 24/08/2020
 * Time: 14:54
 */

if(!class_exists('login')):
    header("index.php");
    die();
endif;

if($userlogin['level'] < 2):
    header("location: panel.php?exe=default/index".$n);
endif;

$postid = filter_input(INPUT_GET, 'postid', FILTER_VALIDATE_INT);
if($level >= 4): $n =  '&id_db_settings='.$id_db_settings; else: $n = null; endif;
?>

<div class="container-fluid">
    <div class="styles">
        <a href="<?= HOME; ?>panel.php?exe=purchase/index<?= $n; ?>" class="btn btn-primary btn-sm">
            VOLTAR
        </a>&nbsp;
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h4>Reajuste de Estoque</h4>
                    </div>
                    <div id="getInfo"></div>
                    <div class="form-group">
                        <?php
                        $read->ExeRead("sd_purchase", "WHERE id=:i AND id_db_settings=:ip", "i={$postid}&ip={$id_db_settings}");

                        if($read->getResult()):
                            foreach($read->getResult() as $key):
                                extract($key);
                                ?>
                                <div class="row">
                                    <div class="col">
                                        <span>Quantidade</span>
                                        <input type="number" value="1" min="0" max="<?= $key['quantidade']; ?>" name="quantidade" id="quantidade" class="form-control" placeholder=""/>
                                    </div>
                                    <div class="col">
                                        <span>Unidades</span>
                                        <input type="number" disabled value="<?= $key['unidade']; ?>" name="unidade" id="unidade" class="form-control" placeholder=""/>
                                    </div>
                                    <div class="col">
                                        <span>Tipo</span>
                                        <select class="form-control" id="Type" name="Type">
                                            <option value="S" selected>Saída</option>
                                        </select>
                                    </div>
                                </div>
                                <hr/>
                                <div class="form-group row">
                                    <div class="col-sm-10">
                                        <a  href="javascript:void" class="btn btn-primary btn-sm" onclick="TreePurchase(<?= $postid; ?>)">Reajustar</a>
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
</div>
<?php
/**
 * Created by PhpStorm.
 * User: Kwanzar Soft
 * Date: 15/08/2020
 * Time: 19:11
 */

$Read = new Read();
$Read->ExeRead("cv_product", "WHERE id_db_settings=:i", "i={$id_db_settings}");

if($Read->getResult()):
    foreach($Read->getResult() as $key):
        if($key['ILoja'] == null || $key['ILoja'] == '' || $key['ILoja'] != 1):

            $promocao = explode("-", $key['data_fim_promocao']);
            if($promocao[0] >= date('Y')):
                if($promocao[1] >= date('m')):
                    if($promocao[2] >= date('d')):
                        $preco = $key['preco_promocao'];
                    else:
                        $preco = $key['preco_promocao'];
                    endif;
                else:
                    $preco = $key['preco_promocao'];
                endif;
            elseif($promocao[0] < date('Y')):
                $preco = $key['preco_venda'];
            endif;

            if($key['type'] != 'P'):
                ?>
                <a href="#" onclick="AddMesa(<?= $id_db_settings.", ".$id_user.", ".$id_mesa.", ".$key['id'] ?>)">
                    <li>
                        <span class="my"><?= number_format($preco, 2); ?></span>
                        <img src="uploads/<?php if($key['cover'] != '' || $key['cover'] != null): echo $key['cover']; else: echo 'default.jpg'; endif; ?>"/>
                        <span class="wy"><?= Check::Words($key['product'], 3); ?></span>
                    </li>
                </a>
                <?php
            else:
                if(DBKwanzar::CheckConfig($id_db_settings) == true && DBKwanzar::CheckConfig($id_db_settings)['HeliosPro'] == 1):
                    ?>
                    <a href="#" onclick="AddMesa(<?= $id_db_settings.", ".$id_user.", ".$id_mesa.", ".$key['id'] ?>)">
                        <li>
                            <span class="my"><?= number_format($preco, 2); ?></span>
                            <img src="uploads/<?php if($key['cover'] != '' || $key['cover'] != null): echo $key['cover']; else: echo 'default.jpg'; endif; ?>"/>
                            <span class="wy"><?= Check::Words($key['product'], 3); ?></span>
                        </li>
                    </a>
                    <?php
                else:
                    if($DB->CheckCpanelAndSettings($id_db_settings, $id_db_kwanzar)['atividade'] != 1):
                        if(DBKwanzar::CheckConfig($id_db_settings) == true && ($key['unidades'] > DBKwanzar::CheckConfig($id_db_settings)['estoque_minimo'])):
                            ?>
                            <a href="#" onclick="AddMesa(<?= $id_db_settings.", ".$id_user.", ".$id_mesa.", ".$key['id'] ?>)">
                                <li>
                                    <span class="my"><?= number_format($preco, 2); ?></span>
                                    <img src="uploads/<?php if($key['cover'] != '' || $key['cover'] != null): echo $key['cover']; else: echo 'default.jpg'; endif; ?>"/>
                                    <span class="wy"><?= Check::Words($key['product'], 3); ?></span>
                                </li>
                            </a>
                            <?php
                        endif;
                    else:
                        if($key['quantidade'] > DBKwanzar::CheckConfig($id_db_settings)['estoque_minimo']):
                            ?>
                            <a href="#" onclick="AddMesa(<?= $id_db_settings.", ".$id_user.", ".$id_mesa.", ".$key['id'] ?>)">
                                <li>
                                    <span class="my"><?= number_format($preco, 2); ?></span>
                                    <img src="uploads/<?php if($key['cover'] != '' || $key['cover'] != null): echo $key['cover']; else: echo 'default.jpg'; endif; ?>"/>
                                    <span class="wy"><?= Check::Words($key['product'], 3); ?></span>
                                </li>
                            </a>
                            <?php
                        endif;
                    endif;
                endif;
            endif;
        endif;
    endforeach;
endif;
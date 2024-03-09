<?php
/**
 * Created by PhpStorm.
 * User: Kwanzar Soft
 * Date: 12/08/2020
 * Time: 17:53
 */

$acao = strip_tags((filter_input(INPUT_POST, 'acao', FILTER_DEFAULT)));

if($acao):
    require_once("../../Config.inc.php");
    if(isset($_POST['id_db_kwanzar'])):  $id_db_kwanzar   = (int) $_POST['id_db_kwanzar']; endif;
    if(isset($_POST['id_db_settings'])): $id_db_settings  = (int) $_POST['id_db_settings']; endif;
    if(isset($_POST['id_mesa'])):        $id_mesa         = (int) $_POST['id_mesa']; endif;
    if(isset($_POST['id_user'])):        $userlogin['id'] = (int) $_POST['id_user']; $id_user = (int) $_POST['id_user']; endif;
    if(isset($_POST['level'])):          $level           = (int) $_POST['level']; endif;

    switch ($acao):
        case 'FinishPDV':
            $data['TaxPointDate']         = strip_tags(trim($_POST['TaxPointDate']));
            $data['customer']          = strip_tags(trim($_POST['id_customer']));
            $data['InvoiceType']          = strip_tags(trim($_POST['InvoiceType']));
            $data['method']               = strip_tags(trim($_POST['method']));
            $data['settings_desc_financ'] = strip_tags(trim($_POST['settings_desc_financ']));
            $data['id_garcom']            = (int) $_POST['id_garcom'];
            $data['troco']                =  $_POST['troco'];
            $data['pagou']                =  $_POST['pagou'];

            $PDV = new PDV();
            $PDV->FinishPDV($data, $id_db_settings, $id_user, $id_mesa);

            if(!$PDV->getResult()):
                WSError($PDV->getError()[0], $PDV->getError()[1]);
            endif;

            break;
        case 'valuePagou':
            $valueTotal = $_POST['valueTotal'];
            $valuePagou = $_POST['valuePagou'];

            $valueTroco = $valuePagou - $valueTotal;

            echo number_format($valueTroco, 2);

            break;
        case 'CancelMesa':
            $PDV = new PDV();
            $PDV->CancelMesa($id_db_settings, $id_user, $id_mesa);

            WSError($PDV->getError()[0], $PDV->getError()[1]);

            break;
        case 'RemoveMesa':
            $id    = (int) $_POST['id'];

            $PDV = new PDV();
            $PDV->RemoveMesa($id_db_settings, $id_user, $id_mesa, $id);

            WSError($PDV->getError()[0], $PDV->getError()[1]);

            break;
        case 'Qtds':
            $value = (int) $_POST['value'];
            $id    = (int) $_POST['id'];

            $PDV = new PDV();
            $PDV->Qtds($id_db_settings, $id_user, $id_mesa, $id, $value);

            WSError($PDV->getError()[0], $PDV->getError()[1]);

            break;
        case 'Down':
            $value = strip_tags(trim($_POST['value']));

            $Read = new Read();
            $Read->ExeRead("cv_product", "WHERE (id_db_settings=:i AND product LIKE '%' :link '%') OR (id_db_settings=:i AND codigo_barras LIKE '%' :link '%') OR (id_db_settings=:i AND codigo LIKE '%' :link '%') ", "i={$id_db_settings}&link={$value}");

            $DB = new DBKwanzar();

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

            break;
        case 'MesaInfo':
            require_once("../../_System4Life/Calc-Product-mesa-info.inc.php");
            break;
        case 'AddMesa':
            $id = (int) $_POST['id'];

            $PDV = new PDV();
            $PDV->AddMesa($id_db_settings, $id_user, $id_mesa, $id);

            WSError($PDV->getError()[0], $PDV->getError()[1]);

            break;
        case 'Transfer':
            $idDe     = (int) $_POST['idDe'];
            $idPara   = (int) $_POST['idPara'];

            $PDV = new PDV();
            $PDV->Transfer($idDe, $idPara, $id_db_settings);

            WSError($PDV->getError()[0], $PDV->getError()[1]);

            break;
        case 'Option':
            $idMesa     = (int) $_POST['idMesa'];
            $optionMesa = (int) $_POST['optionMesa'];

            $PDV = new PDV();
            $PDV->ExeOptions($idMesa, $optionMesa, $id_db_settings);

            WSError($PDV->getError()[0], $PDV->getError()[1]);
            break;
        default:
            WSError("Ops: não encontramos a ação desejada!", WS_INFOR);
    endswitch;
endif;
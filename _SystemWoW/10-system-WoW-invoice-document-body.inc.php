<?php
/**
 * Created by PhpStorm.
 * User: Kwanzar Soft
 * Date: 19/07/2020
 * Time: 16:42
 */

$st2 = 2;
$Read = new Read();
$Read->ExeRead("sd_box", "WHERE id=:ix AND id_db_settings=:i AND session_id=:ip AND status=:st1", "ix={$Number}&i={$id_db_settings}&ip={$id_user}&st1={$st2}");

if($Read->getResult()):
    $fn1 = $Read->getResult()[0];
    ?>
    <div id="Box-close">
        <div class="Text-box-close">
            <p>situação:</p>
            <span>FECHADO</span>
        </div>
        <div class="Text-box-close">
            <p>aberto em:</p>
            <span><?= $fn1['abertura']; ?></span>
        </div>
        <div class="Text-box-close">
            <p>fechado em:</p>
            <span><?= $fn1['fecho']; ?></span>
        </div>
        <div class="Text-box-close">
            <p>saldo inicial:</p>
            <span><?= number_format($fn1['value_open'], 2); ?></span>
        </div>
        <div class="Text-box-close">
            <p>saldo a credito:</p>
            <span><?= number_format($fn1['value_credit'], 2); ?></span>
        </div>
        <div class="Text-box-close">
            <p>saldo anulado:</p>
            <span><?= number_format($fn1['value_null'], 2); ?></span>
        </div>
        <div class="Text-box-close">
            <p>saldo sangriado:</p>
            <span><?= number_format($fn1['value_sangria'], 2); ?></span>
        </div>
        <div class="Text-box-close">
            <p>saldo ativo:</p>
            <span><?= number_format($fn1['value_finish'], 2); ?></span>
        </div>
        <?php
        $eTomas  = ($fn1['value_open'] + $fn1['value_finish']);
        $tEliudy = ($fn1['value_sangria'] + $fn1['value_null']);
        $cTomas  = ($eTomas - $tEliudy);
        ?>
        <div class="Infor"></div>
        <div class="Text-box-close">
            <p>saldo final:</p>
            <span><?= number_format($cTomas, 2); ?></span>
        </div>
        <div class="Text-box-close">
            <p>funcionário:</p>
            <span><?= DBKwanzar::ViewsUsers($fn1['session_id'])['name']; ?></span>
        </div>
    </div>
    <?php
endif;
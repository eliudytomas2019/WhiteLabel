<?php
/**
 * Created by PhpStorm.
 * User: Kwanzar Soft
 * Date: 17/08/2020
 * Time: 11:14
 */
?>
<div class="my-modal">
    <div class="header_my_modal">
        <a href="javascript:void()" class="close_header">X</a>
    </div>
    <div id="assim">
        <div id="getReturn"></div>
        <form method="post" action="">
            <h2>Opções de mesa</h2>
            <div class="porq_assim">
                <div class="two2option">
                    <label>Mesas</label>
                    <select id="idMesa" class="form-jah">
                        <?php
                        $Read = new Read();
                        $Read->ExeRead("cv_mesas", "WHERE id_db_settings=:i ORDER BY id ASC", "i={$id_db_settings}");

                        if($Read->getResult()):
                            foreach($Read->getResult() as $key):
                                extract($key);
                                ?>
                                <option value="<?= $key['id'] ?>"><?= $key['name']; ?></option>
                                <?php
                            endforeach;
                        endif;
                        ?>
                    </select>
                </div>
                <div class="two2option">
                    <label>Ação</label>
                    <select id="optionMesa" class="form-jah">
                        <option value="1">Livre</option>
                        <option value="2">Em uso</option>
                        <option value="3">Reservada</option>
                        <option value="4">Em manutenção</option>
                    </select>
                </div>
                <a href="javascript:void()" onclick="OptionMesa()" class="tdn status-off-1">Salvar</a>
            </div>
        </form>
        <form method="post" action="">
            <h2>Transfêrencia de pedidos</h2>
            <div class="porq_assim">
                <div class="two2option">
                    <label>De</label>
                    <select id="idDe" class="form-jah">
                        <?php
                        $Read = new Read();
                        $Read->ExeRead("cv_mesas", "WHERE id_db_settings=:i ORDER BY id ASC", "i={$id_db_settings}");

                        if($Read->getResult()):
                            foreach($Read->getResult() as $key):
                                extract($key);
                                ?>
                                <option value="<?= $key['id'] ?>"><?= $key['name']; ?></option>
                                <?php
                            endforeach;
                        endif;
                        ?>
                    </select>
                </div>
                <div class="two2option">
                    <label>Para</label>
                    <select id="idPara" class="form-jah">
                        <?php
                        $Read = new Read();
                        $Read->ExeRead("cv_mesas", "WHERE id_db_settings=:i ORDER BY id ASC", "i={$id_db_settings}");

                        if($Read->getResult()):
                            foreach($Read->getResult() as $key):
                                extract($key);
                                ?>
                                <option value="<?= $key['id'] ?>"><?= $key['name']; ?></option>
                                <?php
                            endforeach;
                        endif;
                        ?>
                    </select>
                </div>
                <a href="javascript:void()" onclick="Transfer()" class="tdn status-off-1">Efectuar</a>
            </div>
        </form>
    </div>
</div>

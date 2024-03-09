<?php
$read->ExeRead("db_settings", "WHERE id=:i", "i={$id_db_settings}");
if($read->getResult()):
    $k = $read->getResult()[0];
    ?>
    <nav class="A4-reader">
    <div class="A4-reader-two">
        <div class="A4-invoice">
            <?php if(!isset(DBKwanzar::CheckConfig($id_db_settings)['IncluirCover']) || empty(DBKwanzar::CheckConfig($id_db_settings)['IncluirCover']) || DBKwanzar::CheckConfig($id_db_settings)['IncluirCover'] == null || DBKwanzar::CheckConfig($id_db_settings)['IncluirCover'] == 2): ?><img src="./uploads/<?php if($k['logotype'] == null || $k['logotype'] == null): echo $Index['logotype']; else: echo $k['logotype']; endif;  ?>" class="logotype-invoice" height="100" width="200"/><?php endif; ?>
            <h2><?= $k['empresa']; ?></h2>
            <p><span>NIF:</span> <?= $k['nif']; ?></p>
            <p class="website"><span>Website:</span> <?= $k['website']; ?></p>
            <p><span>E-MAIL:</span> <?= $k['email']; ?></p>
            <p><span>Endereço:</span> <?= $k['endereco']; ?></p>
            <p><span>Telefone:</span> <?= $k['telefone']; ?></p>
        </div>

        <div class="A4-customer">
            <?php
                $Read = new Read();
                $Read->ExeRead("cv_customer", "WHERE id=:i ", "i={$id_paciente}");

                if($Read->getResult()):
                    $customer = $Read->getResult()[0];
                else:
                    $customer = null;
                endif;
            ?>
            <h4>Dados do paciente</h4>
            <p><?= $customer['nome'] ?></p>
            <p><?php if($customer['nif'] == null || $customer['nif'] == '' || $customer['nif'] == '999999999'): echo "Consumidor final"; else: echo $customer['nif']; endif; ?></p>
            <p><?= $customer['endereco'] ?></p>
        </div>
    </nav>
    <div class="heliospro">
        <div id="xuxu">
            <h1 class="header-one pussy">Ficha de Anamnese</h1></div>
    </div>

    <div class="jugadores">
        <div class="jugadores_01">
            <h2>Perguntas</h2>
            <?php
                //include("Anamnese.inc.php");
                for($iy = 1; $iy <= 68; $iy++):
                    ?><h3><?= $Anamnese[$iy]; ?></h3><?php
                endfor;;
            ?>
        </div>
        <div class="jugadores_02">
            <h2>Respostas</h2>
            <?php
                $Read->ExeRead("cv_customer_anamnese", "WHERE id_paciente=:userid AND id_db_settings=:i", "userid={$id_paciente}&i={$id_db_settings}");

                if($Read->getResult()):
                    foreach ($Read->getResult() as $key):
                        for($i = 1; $i <= 68; $i++):
                            ?><h3><?= $key["anamnese_{$i}"]; ?> / <?= $key["anamnese_{$i}_{$i}"]; ?></h3><?php
                        endfor;
                    endforeach;
                endif;
            ?>
        </div>
    </div>

    <div class="cybernetica">
        <h6>Assino este declarando verdadeiras as informações ditas acima</h6>
        <label>_____________________________</label>
        <span>Assinatura do paciente</span>
        <p><?= $customer['nome']; ?></p>
    </div>
<?php endif; ?>
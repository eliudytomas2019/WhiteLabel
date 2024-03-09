<div class="newA4">
    <?php
    $read = new Read();
    $read->ExeRead("ii_billing, ii_billing_pmp", "WHERE ii_billing.id=:i AND ii_billing.numero=:y AND ii_billing.InvoiceType=:t AND ii_billing_pmp.id_invoice=ii_billing.id AND ii_billing_pmp.InvoiceType=:t", "i={$postId}&y={$Number}&t={$InvoiceType}");

    if($read->getResult()):
        $k = $read->getResult()[0];
        Mecanica::Timer($postId, $k['numero'], $InvoiceType);
        ?>
        <title><?= $k['InvoiceType']." ".$k['mes'].$k['Code'].$k['ano']."_".$k['numero'];  ?></title>
        <div class="newA4reader">
            <img src="./uploads/<?php if($k['system_logotype'] == null || $k['system_logotype'] == null): echo "logotype.jpg"; else: echo $k['system_logotype']; endif;  ?>" class="logotype-invoice" style="max-height: 100px!important;max-width: 180px!important;"/>
            <div class="A4-getMe">
                <div class="A4-left">
                    <h2><?= $k['system_name']; ?></h2>
                    <p><span>Endereço:</span> <?= $k['system_endereco']; ?></p>
                    <p><span>Contribuinte:</span> <?= $k['system_nif']; ?></p>
                    <p><span>Telefone:</span> <?= $k['system_telefone']; ?></p>
                    <p><span>Email:</span> <?= $k['system_email']; ?></p>
                </div>
                <div class="A4-right">
                    <h4>Exmo.(s) Sr.(s)</h4>
                    <span><?= $k['customer_name'] ?></span>
                    <span>Contribuinte: <?php if($k['customer_nif'] == null || $k['customer_nif'] == '' || $k['customer_nif'] == '999999999'): echo "Consumidor final"; else: echo $k['customer_nif']; endif; ?></span>
                    <span>Endereço: <?= $k['customer_endereco'] ?></span>
                </div>
            </div>

            <div class="Yolanda">
                <?php $Data = ["", "Original", "Duplicado", "Triplicado"]; ?>
                <h1 class="header-one pussy"><?php echo "Folha de obra"; ?>
                    <?= $k['InvoiceType']." ".$k['mes'].$k['Code'].$k['ano']."/".$k['numero']; if(Mecanica::Config($id_db_settings)['JanuarioSakalumbu'] == 1 || Mecanica::Config($id_db_settings)['JanuarioSakalumbu'] == '' || Mecanica::Config($id_db_settings)['JanuarioSakalumbu'] == null): echo '&nbsp;MODO DE INSTRUÇÃO, ESSE DOCUMENTO NÃO É VÁLIDO'; endif; ?> </h1>


                <?php if($k['timer'] == null || $k['timer'] == '' || $k['timer'] < 3): ?><p class="Lu">Moeda: (<?= $k['config_moeda']; ?>) <?= $Data[$i]; ?></p><?php else: ?><p class="Luzineth">Moeda: (<?= $k['config_moeda']; ?>) 2ª via em conformidade com a original</p><?php endif; ?>
            </div>

            <table class="DomingosTomas">
                <thead>
                <tr>
                    <th>Data de emissão</th>
                    <th>Hora de emissão</th>
                    <th>Emitida por</th>
                    <th>Página</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td><?= $k['ano']."-".$k['mes']."-".$k['dia'] ?></td>
                    <td><?= $k['hora'] ?></td>
                    <td><?= $k['username'] ?></td>
                    <td>1 de 1</td>
                </tr>
                </tbody>
            </table>
        </div>
        <?php include ("_SystemWoW/all_docs_fo.inc.php"); ?>
    <?php
    endif;
    ?>
</div>
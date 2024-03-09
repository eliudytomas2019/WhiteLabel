<?php
$file = "Extract_".time();

$read = new Read();
$read->ExeRead("db_settings", "WHERE id=:i", "i={$id_db_settings}");

if($read->getResult()):
    $k = $read->getResult()[0];
    ?>

    <div class="header">
        <img src="./uploads/<?php if($k['logotype'] == null || $k['logotype'] == null): echo $Index['logotype']; else: echo $k['logotype']; endif;  ?>" class="img-silvio"/>
        <div class="header-silvio">
            <div class="header-silvio-a">
                <div class="A4-left">
                    <h2><?= $k['empresa']; ?></h2>
                    <p><span>NIF:</span> <?= $k['nif']; ?></p>
                    <p class="website"><span>Website:</span> <?= $k['website']; ?></p>
                    <p><span>E-MAIL:</span> <?= $k['email']; ?></p>
                    <p><span>Endereço:</span> <?= $k['endereco']; ?></p>
                    <p><span>Telefone:</span> <?= $k['telefone']; ?></p>
                </div>
            </div>
            <div class="header-silvio-b">
                <h4>Exmo.(s) Sr.(s)</h4>
                <?php

                    $Read = new Read();
                    $Read->ExeRead("cv_customer", "WHERE id=:i ", "i={$postId}");

                    if($Read->getResult()):
                        $customer = $Read->getResult()[0];
                        ?>
                        <span><?= $customer['nome']; ?></span>
                        <span><?php if($customer['nif'] == null || $customer['nif'] == '' || $customer['nif'] == '999999999'): echo "Consumidor final"; else: echo $customer['nif']; endif; ?></span>
                        <span><?= $customer['endereco'] ?></span>
                        <span><?= $customer['addressDetail'] ?></span>
                    <?php
                    endif;


                    $n1 = "av_entrada_e_saida";

                    $read = new Read();
                    $read->ExeRead("{$n1}", "WHERE {$n1}.id=:id AND {$n1}.id_db_settings=:i ", "id={$Number}&i={$id_db_settings}");

                    $key = $read->getResult()[0];
                ?>
            </div>
        </div>
        <div class="limpopo-silvio">
            <h1>Entrada/Saída de Caixa nº <?= $key['mes'].$key['ano']."_".$key['id']; ?></h1>

            <span></span>
        </div>
        <table class="">
            <thead>
            <tr>
                <th>Moeda</th>
                <th>Data de Emissão</th>
                <th>Hora de Emissão</th>
                <th>Metodo de Pagamento</th>
                <th>Operador</th>
                <th>Página</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td><?= DBKwanzar::CheckConfig($id_db_settings)['moeda']; ?></td>
                <td><?= $key['ano']."-".$key['mes']."-".$key['dia'] ?></td>
                <td><?= $key['hora'] ?></td>
                <td><?php if($key['method'] == 'CC'): echo 'Cartão de Credito'; elseif($key['method'] == 'CD'): echo 'Cartão de Debito'; elseif($key['method'] == 'CH'): echo 'Cheque Bancário'; elseif($key['method'] == 'NU'): echo 'Numerário'; elseif ($key['method'] == 'TB'): echo 'Transferência Bancária'; elseif($key['method'] == 'OU'): echo 'Outros Meios Aqui não Assinalados'; endif; ?>
                </td>
                <td><?php $Read->ExeRead("db_users", "WHERE id=:i", "i={$invoice_id}"); if($Read->getResult()): echo $Read->getResult()[0]['name']; endif; ?></td>
                <td><span class="page"></span></td>
            </tr>
            </tbody>
        </table>
    </div>

    <div class="table-silvio">
        <?php

        if($read->getResult()):
            foreach ($read->getResult() as $key):
                ?>
                <div class="GotMe">

                    <p class="smile"><?php if($key['type'] == "Entrada"): ?>Recebemos do(s) <?php else: ?> Entregamos ao(s) <?php endif; ?> Exmo.(s) Sr.(s) <strong><?= $customer['nome']; ?></strong>, a quantia de <?= str_replace(",", ".", number_format($key['valor'], 2)); ?> <?= DBKwanzar::CheckConfig($id_db_settings)['moeda']; ?> através de
                        <?php if($key['method'] == 'CC'): echo 'Cartão de Credito'; elseif($key['method'] == 'CD'): echo 'Cartão de Debito'; elseif($key['method'] == 'CH'): echo 'Cheque Bancário'; elseif($key['method'] == 'NU'): echo 'Numerário'; elseif ($key['method'] == 'TB'): echo 'Transferência Bancária'; elseif($key['method'] == 'OU'): echo 'Outros Meios Aqui não Assinalados'; endif; ?>. pelo motivo: <?= $key['description']; ?></p>

                    <div class="limpopo-silvio-2">
                    <span><?php
                        if(DBKwanzar::CheckConfig($id_db_settings) == false || DBKwanzar::CheckConfig($id_db_settings)['PadraoAGT'] == null || DBKwanzar::CheckConfig($id_db_settings)['PadraoAGT'] == 2):
                            require("./_SystemWoW/footer-invoice-geral-w.inc.php");
                        endif;
                    ?></span>
                    </div>
                </div>
                <?php
            endforeach;
        endif;
        ?>
    </div>
    <div class="footer-small">
        <div class="all-porn">
            <p class="porn-1">
                ___________________________<br/>
                Assinatura do vendedor
            </p>

            <p class="porn-2">
                ___________________________<br/>
                Assinatura do cliente
            </p>
        </div>
    </div>
<?php endif;

$file = $key['mes'].$key['ano']."_".$key['id'];
?>

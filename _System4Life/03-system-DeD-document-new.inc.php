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

    <div class="jugadoresI">
        <h1>Atestado</h1>
        <?php
        $Read->ExeRead("cv_clinic_justificativo", "WHERE id_paciente=:userid AND id_db_settings=:i AND id=:ui ", "userid={$id_paciente}&i={$id_db_settings}&ui={$postId}");

        $keys = null;

        if($Read->getResult()):
            foreach ($Read->getResult() as $key):
                $keys = $key;
                ?>

                <p>Atesto, com o fim específico de dispensa de atividades trabalhistas (ou escolares, ou judiciárias),
                    que <strong><?= $customer['nome']; ?></strong>, portador(a) do BI/NIF: <strong><?= $customer['nif']; ?></strong> esteve sob meus cuidados
                    profissionais no dia <?= $key['data_emissao']; ?> devendo permanecer em repouso por <strong><?= $key['dias']; ?></strong> dia(s).</p>

                <p>Eu,__________________________________________ autorizo que meu diagnostico (CID) esteja presente neste atestado. CID: <strong><?= $key['cid']; ?></strong></p>
                <?php
            endforeach;
        endif;
        ?>
    </div>

    <div class="cybernetica">
        <label>_____________________________</label>
        <span><?php $Read->ExeRead("db_users", "WHERE id=:i ", "i={$keys['id_user']}"); if($Read->getResult()): echo $Read->getResult()[0]['name']; endif; ?></span>
        <p><?= $keys['data_emissao']; ?></p>
    </div>
<?php endif; ?>
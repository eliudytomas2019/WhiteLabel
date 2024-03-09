<div class="Ack">
    <?php
        $read = new Read();
        $Read = new Read();

        $info = null;
        $user = null;
        $funcionario = null;
        $patrimonio = null;
        $empresa = null;

        $Read->ExeRead("p_atribuicoes", "WHERE id=:a1 AND id_db_settings=:a2", "a1={$postId}&a2={$id_db_settings}");
        if($Read->getResult()):
            $info = $Read->getResult()[0];
        endif;

        $read->ExeRead("p_table", "WHERE id=:a1 AND id_db_settings=:a2", "a1={$info['id_table']}&a2={$id_db_settings}");
        if($read->getResult()):
            $patrimonio = $read->getResult()[0];
        endif;

        $read->ExeRead("p_funcionario", "WHERE id=:a1 AND id_db_settings=:a2", "a1={$info['id_funcionario']}&a2={$id_db_settings}");
        if($read->getResult()):
            $funcionario = $read->getResult()[0];
        endif;

        $read->ExeRead("db_settings", "WHERE id=:a1", "a1={$id_db_settings}");
        if($read->getResult()):
            $empresa = $read->getResult()[0];
        endif;

        $read->ExeRead("db_users", "WHERE id=:a1", "a1={$info['session_id']}");
        if($read->getResult()):
            $user = $read->getResult()[0];
        endif;
    ?>
    <title><?= "P".$info['id']."/".date('Y'); ?></title>
    <div class="GangstaLuv">
        <p class="smiles">Eu <strong><?= $funcionario['nome']; ?></strong>, portador do BI/NIF: <strong><?= $funcionario['bi']; ?></strong>, residente em: <strong><?= $funcionario['endereco']; ?></strong> funcionário da empresa: <strong><?= $empresa['empresa']; ?></strong>, legalmente estabelecida, portadora do NIF: <strong><?= $empresa['nif']; ?></strong>, confirmo a recepção de um/a: <strong><?= $patrimonio['nome']; ?></strong>, marca: <strong><?= $patrimonio['marca']; ?></strong>, modelo: <strong><?= $patrimonio['modelo']; ?></strong>, meio patrimonial da empresa sitada acima. O ato aconteceu na data/hora:  <strong><?= $info['data']." ".$info['hora']; ?></strong>.</p>

        <p class="smiles">O/a <strong><?= $patrimonio['nome']; ?></strong>, me foi atribuido para realização dos serviços  da empresa o estravio ou danificação do mesmo sem justa causa trará consequências com base as leis trabalhisticas vigente no País.</p>

        <p class="smiles">Algumas observações feitas no ato da entrega do meio: <strong><?= $info['descricao']; ?></strong></p>

        <p class="smiles">Imprenso aos <?= date('d/m/Y H:i:s'); ?></p>
    </div>

    <div class="Ack-2">
        <div class="A4-getMe">
            <div class="footer-left">
                <p class="porn">
                    &nbsp;&nbsp;&nbsp;Entreguei
                    <br/>______________________________<br/>
                    <?= $user['name']; ?>
                </p>
            </div>

            <div class="footer-right">
                <p class="porn">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Recebi
                    <br/>______________________________<br/>
                    <?= $funcionario['nome']; ?>
                </p>
            </div>
        </div>
    </div>
</div>
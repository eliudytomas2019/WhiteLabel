<table class="DomingosTomas">
    <thead>
    <tr>
        <th>Matricula</th>
        <th>Cor</th>
        <th>Motor</th>
        <th>Chassi</th>
        <th>Marca/Modelo</th>
        <th>Kilometragem</th>
        <th>Mecanico</th>
        <th>Data de Entrada</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td><?= $k['matricula']; ?></td>
        <td><?= $k['cor']; ?></td>
        <td><?= $k['motor']; ?></td>
        <td><?= $k['chassi']; ?></td>
        <td><?= $k['v_modelo']; ?></td>
        <td><?= $k['kilometragem']; ?></td>
        <td><?= $k['mecanico']; ?></td>
        <td><?= $k['fo_data_entrada']; ?></td>
    </tr>
    </tbody>
</table>
<div class="newA4-body">
    <div class="chupetox">
        <div class="TudoSeResolve">
            <h2>Descrição do problema</h2>
            <p><?= $k['fo_problema']; ?></p>
        </div>
        <div class="TudoSeResolve">
            <h2>Laudo Técnico</h2>
            <p><?= $k['fo_laudo']; ?></p>
        </div>
    </div>
    <div class="Lifes">
        <h2>Observações</h2>
        <p><?= $k['fo_observacoes']; ?></p>
    </div>
    <table>
        <thead>
        <tr>
            <th>Código</th>
            <th>Descriminação</th>
            <th>Qtd</th>
        </tr>
        </thead>
        <tbody>
        <?php
        if($read->getResult()):
            foreach ($read->getResult() as $key):
                ?>
                <tr>
                    <td><?= $key['product_code']; ?></td>
                    <td><?= $key['product']; ?></td>
                    <td><?= $key['qtd_pmp']; ?></td>
                </tr>
            <?php
            endforeach;
        endif;
        ?>
        </tbody>
    </table>
</div>

<div class="newA4-footer">
    <div class="A4-getMe">
        <div class="footer-left">
            <?php
            require("_SystemWoW/Obs.invoice.inc.php");
            ?>
        </div>

        <div class="footer-right">
            <?php
            require("_SystemWoW/footer-invoice-geral.inc.php");
            ?>
        </div>
    </div>
</div>
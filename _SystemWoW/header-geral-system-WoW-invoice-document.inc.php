<?php
/**
 * Created by PhpStorm.
 * User: Kwanzar Soft
 * Date: 04/06/2020
 * Time: 22:39
 */

$read->ExeRead("db_settings", "WHERE id=:i", "i={$id_db_settings}");

if($read->getResult()):
$k = $read->getResult()[0];
?>
<nav class="A4-reader">
    <div class="A4-reader-two">
        <div class="A4-invoice">
            <?php if(!isset(DBKwanzar::CheckConfig($id_db_settings)['IncluirCover']) || empty(DBKwanzar::CheckConfig($id_db_settings)['IncluirCover']) || DBKwanzar::CheckConfig($id_db_settings)['IncluirCover'] == null || DBKwanzar::CheckConfig($id_db_settings)['IncluirCover'] == 2): ?><img src="./uploads/<?php if($k['logotype'] == null || $k['logotype'] == null): echo $Index['logotype']; else: echo $k['logotype']; endif;  ?>" class="logotype-invoice" height="100" width="200"/><?php endif; ?>
            <h2><?= $k['empresa']; ?></h2>
            <p><span>Endereço:</span> <?= $k['endereco']; ?></p>
            <p><span>Contribuinte:</span> <?= $k['nif']; ?></p>
            <p><span>Telefone:</span> <?= $k['telefone']; ?></p>
            <p><span>Email:</span> <?= $k['email']; ?></p>
        </div>

        <div class="A4-customer">

        </div>
    </div>
</nav>
<?php endif; ?>
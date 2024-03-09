<?php
$read = new Read();
$read->ExeRead("cv_customer", "WHERE id_db_settings=:i ORDER BY id ASC", "i={$id_db_settings}");
if($read->getResult()):
    foreach ($read->getResult() as $Supplier):
        extract($Supplier);
        ?>
        <option value="<?= $Supplier['id']; ?>" <?php if(isset($DataSupplier['id_customer']) && $DataSupplier['id_customer'] == $Supplier['id']) echo 'selected="selected"'; ?>><?= $Supplier['nome']; ?></option>
    <?php
    endforeach;
else:
    WSError("Oppsss! Não encontramos nenhum Cliente, cadastre um para prosseguir!", WS_ALERT);
endif;
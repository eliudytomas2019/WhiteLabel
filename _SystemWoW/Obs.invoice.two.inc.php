<?php
/**
 * Created by PhpStorm.
 * User: Kwanzar Soft
 * Date: 11/07/2020
 * Time: 23:44
 */
?>
<p class="jud">
    <?php if($k['InvoiceType'] == 'NC'): ?>
        <strong><?= $k['settings_info']; ?></strong>,
    <?php endif; ?>
    referente a <strong><?= $k['Invoice'] ?></strong> emitida em <strong><?= $k['InvoiceDate'] ?></strong>.</p>
<p class="porn">
    _________________________<br/>
    Assinatura
</p>
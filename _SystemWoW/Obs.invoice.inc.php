<?php
if(isset($k['InvoiceType']) && $k['InvoiceType'] != 'PP' || isset($k['InvoiceType']) && $k['InvoiceType'] != 'FO'):
    ?>
    <p class="jud">
        <?php if($k['InvoiceType'] == 'NC'  || $k['InvoiceType'] == 'RG'): ?>
            <strong>Rectificação</strong><br/>
            Motivo de: <?php if($k['InvoiceType'] == 'NC' || $k["InvoiceType"] == 'RG'):  echo $k['settings_doctype'].". "; endif; ?><br/>
            Referente a <strong><?= $k['Invoice'] ?></strong> emitida em <strong><?= $k['InvoiceDate'] ?></strong>
        <?php elseif($k['InvoiceType'] == "FT" || $k["InvoiceType"] == "FR"): ?>
            Os bens/serviços foram colocados a disposição do adquirente na data do documento.
        <?php endif; ?>
    </p>
    <?php
else:
    ?>
    <p class="jud">Este documento não serve de factura</p>
    <?php
endif;

if(!isset($k['InvoiceType']) || $k['InvoiceType'] == "FO" || $k['InvoiceType'] == "PP" ||  $k['InvoiceType'] == "GT"  ||!isset($k['InvoiceType']) || $k['InvoiceType'] == null || empty($k['InvoiceType'])):
    ?>
    <p class="jud">Este documento não serve de factura</p>
    <?php
endif;
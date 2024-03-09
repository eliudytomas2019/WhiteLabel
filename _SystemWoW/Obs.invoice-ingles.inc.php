<?php
if(isset($k['InvoiceType']) && $k['InvoiceType'] != 'PP' || isset($k['InvoiceType']) && $k['InvoiceType'] != 'FO'):
    ?>
    <p class="jud">
        <?php if($k['InvoiceType'] == 'NC'  || $k['InvoiceType'] == 'RG'): ?>
            <strong>Rectification</strong><br/>
            Reason for: <?php if($k['InvoiceType'] == 'NC' || $k["InvoiceType"] == 'RG'):  echo $k['settings_doctype'].". "; endif; ?><br/>
            Regarding <strong><?= $k['Invoice'] ?></strong> issued on <strong><?= $k['InvoiceDate'] ?></strong>
        <?php elseif($k['InvoiceType'] == "FT" || $k["InvoiceType"] == "FR"): ?>
            The goods/services were made available to the purchaser on the date of the document.
        <?php endif; ?>
    </p>
<?php
else:
    ?>
    <p class="jud">This document does not serve as an invoice</p>
<?php
endif;

if(!isset($k['InvoiceType']) || $k['InvoiceType'] == "FO" || $k['InvoiceType'] == "PP" ||  $k['InvoiceType'] == "GT"  ||!isset($k['InvoiceType']) || $k['InvoiceType'] == null || empty($k['InvoiceType'])):
    ?>
    <p class="jud">This document does not serve as an invoice</p>
<?php
endif;
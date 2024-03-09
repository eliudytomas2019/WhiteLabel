<table class="table" style="text-align: left!important;align-content: flex-start!important;align-items: flex-start!important;">
    <thead>
    <tr>
        <th>Número</th>
        <th>Nº do Documento</th>
        <th>Operador</th>
        <th>Cliente</th>
        <th>Data</th>
        <th>Documento</th>
        <th style="width: 350px!important">-</th>
        <th>ID</th>
    </tr>
    </thead>
    <tbody>
    <?php
    if(DBKwanzar::CheckConfig($id_db_settings) == false || Strong::Config($id_db_settings)['JanuarioSakalumbu'] == 3 || Strong::Config($id_db_settings)['JanuarioSakalumbu'] == '' || Strong::Config($id_db_settings)['JanuarioSakalumbu'] == null):
        $st = 3;
    else:
        $st = 2;
    endif;

    $s = 0;
    $posti = 0;
    $getPage = filter_input(INPUT_GET, 'page',FILTER_VALIDATE_INT);
    $Pager = new Pager('painel.php?exe=proforma/proforma&page=');
    $Pager->ExePager($getPage, 20);

    $n1 = "sd_billing";
    $n3 = "sd_billing_pmp";
    $PPs = "PP";

    if($level >= 3):
        $CristoBody = null;
        $CristoHeader = null;
    else:
        $CristoHeader = " AND {$n1}.session_id=:id ";
        $CristoBody = " &id={$id_user} ";
    endif;

    $read = new Read();
    $read->ExeRead("{$n1}", "WHERE ({$n1}.id_db_settings=:i AND {$n1}.InvoiceType='{$PPs}' {$CristoHeader} AND {$n1}.status=:st AND {$n1}.suspenso={$s}) ORDER BY {$n1}.id DESC LIMIT 20", "i={$id_db_settings}{$CristoBody}&st={$st}");
    if($read->getResult()):
        foreach ($read->getResult() as $key):
            require("_disk/AppData/ResultDocumentsProformas.inc.php");
        endforeach;
    endif;
    ?>
    </tbody>
</table>
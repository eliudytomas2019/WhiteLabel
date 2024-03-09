<?php
$Read = new Read();
$Read->ExeRead("db_settings");
if($Read->getResult()): $single = $Read->getRowCount(); else: $single = 0; endif;

$posti = 0;
$getPage = filter_input(INPUT_GET, 'page',FILTER_VALIDATE_INT);
$Pager = new Pager("Admin.php?exe=statistic/company&page=");
$Pager->ExePager($getPage, 20);

$read = new Read();
$read->ExeRead("db_settings", "ORDER BY id DESC LIMIT :limit OFFSET :offset", "limit={$Pager->getLimit()}&offset={$Pager->getOffset()}");
$result = $read->getRowCount();
?>


<div class="page-header d-print-none">
    <div class="row align-items-center">
        <div class="col">
            <h2 class="page-title">
                Todas Empresas Registradas
            </h2>
            <div class="text-muted mt-1" style="color: <?= $Index['color_41']; ?>!important;" id="Ack"><?= $result; ?> de <?= $single; ?> empresas</div>
        </div>

        <div class="col-auto ms-auto d-print-none">
            <div class="d-flex">
                <input type="search" class="form-control d-inline-block w-9 me-3" id="eliudyTomas" placeholder="Pesquisar Empresa"/>
            </div>
        </div>
    </div>
</div>
<br/>
<div id="Farao"></div>
<div class="row row-cards" id="IsabelDavid">
    <?php require_once("_disk/_help/DeuOnda.inc.php"); ?>
</div>
<div class="d-flex mt-4">
    <?php
    $Pager->ExePaginator("db_settings", "ORDER BY empresa ASC");
    echo $Pager->getPaginator();
?>
</div>
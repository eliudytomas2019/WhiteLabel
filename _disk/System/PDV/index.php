<?php
    $Read = new Read();
    $Read->ExeRead("db_config", "WHERE id_db_settings=:i ", "i={$id_db_settings}");
    if(!$Read->getResult() || !$Read->getRowCount()):
        header("Location: panel.php?exe=settings/System_Settings{$n}");
    endif;
?>


<div class="row row-cards" id="PDV" onload="ReadPDV(<?= $id_user; ?>)">
    <div class="col-md-4 col-xl-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title ml-2">Menu</h3>
            </div>
            <div class="card">
                <div class="card-body">
                    <?php require_once("_disk/AppFiles/DataPDV.inc.php"); ?>
                    <div id="EndFamily">
                        <?php require_once("_disk/AppFiles/EndFamily.inc.php"); ?>
                    </div>
                </div>
                <div class="card-footer border-0">
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-8 col-xl-8">
        <div class="mb-3 p-3 bg-white">
            <div class="row g-2">
                <div class="col">
                    <input type="text" class="form-control" name="searchPDV" id="searchPDV" placeholder="Procurar por produtos ou serviços…">
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title ml-2">Produtos & Factura</h3>
            </div>
            <div class="card-body">
                <div class="mb-10">
                    <label class="form-label">Adicione os Itens na factura.</label>
                    <div id="right-PDV" onload="loadingPDV(<?= $id_user; ?>)">
                        <ul id="list-itens">
                            <?php
                                $read = new Read();
                                $read->ExeRead("cv_product", "WHERE id_db_settings=:i ORDER BY product ASC LIMIT 12", "i={$id_db_settings}");
                                require_once("_disk/AppFiles/ReadPDV.inc.php");
                            ?>
                        </ul>
                    </div>
                </div>
                <div id="kebrada">

                </div>
            </div>
        </div>
    </div>
</div>
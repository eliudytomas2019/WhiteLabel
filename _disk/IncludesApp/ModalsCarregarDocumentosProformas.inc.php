<div class="modal modal-blur fade" id="ModalsCarregarDocumentosProformas" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-full-width modal-dialog-centered" role="document">
        <form method="post" action="" name = "FormCreateCustomer"  enctype="multipart/form-data" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Documentos</h5>
                <a href="#" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></a>
            </div>
            <div class="modal-body">
                <div class="search-content-modal">
                    <input type="search" class="form-control" id="SearchDocumentsProformas" placeholder="Buscar por número"/>
                </div><br/>
                <input type="hidden" id="level" value="<?= $level; ?>"/>
                <div class="body-content-modal" id="Kings">
                    <?php require_once("_disk/Helps/table-documents-settingsProformas.inc.php"); ?>
                </div>
            </div>
        </form>
    </div>
</div>
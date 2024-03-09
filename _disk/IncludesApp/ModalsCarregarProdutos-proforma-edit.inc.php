<div class="modal modal-blur fade" id="ModalsCarregarProdutos" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-full-width modal-dialog-centered" role="document">
        <form method="post" action="" name = "FormCreateCustomer"  enctype="multipart/form-data" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Adicionar itens factura</h5>
                <a href="#" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></a>
            </div>
            <div class="modal-body">
                <div class="search-content-modal" style="display:flex!important;flex-direction: row!important;justify-content: space-between!important;">
                    <input type="search" class="form-control" id="SearchProductxxx00" style="width: 30%!important;" placeholder="Buscar por código, código de barras."/>
                    <input type="search" class="form-control" id="SearchProductxxx" style="width: 69%!important;" placeholder="Buscar por designação"/>
                </div><br/>
                <table class="table">
                    <thead>
                    <tr>
                        <th>Codigo</th>
                        <th>Item</th>
                        <th>Codigo de Barras</th>
                        <th>Desconto(%)</th>
                        <th>Taxa(%)</th>
                        <th>Preço Uni.</th>
                        <th>Qtd</th>
                        <th></th>
                        <th></th>
                        <th>Localização</th>
                        <th>Remarks</th>
                        <th>-</th>
                    </tr>
                    </thead>
                    <tbody id="POSETX">

                    </tbody>
                </table>
            </div>
        </form>
    </div>
</div>
<div class="row align-items-center">
    <div class="col">
        <h2 class="page-title">
            Definições
        </h2>
        <div class="text-muted mt-1" style="color: <?= $Index['color_42']; ?>!important;">Operações empresarial</div>
    </div>
    <div class="col-auto ms-auto d-print-none">
        <div class="text-muted mt-1" style="color: <?= $Index['color_42']; ?>!important;">Eliminar factura com erro</div>
        <div id="AnaJulia"></div>
        <div class="d-flex">
            <input type="text" id="EliminarFacturaID" class="form-control d-inline-block w-9 me-3" placeholder="ID do documento"/>
            <a href="javascript:void()" onclick="EliminarFactura();" class="btn btn-primary">
                Eliminar
            </a>
        </div>
    </div>
</div>

<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <div class="card-title" style="color: <?= $Index['color_42']; ?>!important;">Empresas</div>
            <div class="col-auto ms-auto d-print-none">
                <input type="text" placeholder="Pesquisar..." id="FormEmpresas" class="form-control">
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div id="getError"></div>
                <table class="table">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>EMPRESA</th>
                        <th>NIF</th>
                        <th>TELEFONE</th>
                        <th>E-MAIL</th>
                        <th style="width: 220px!important;">-</th>
                    </tr>
                    </thead>
                    <tbody id="WriteT">

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<br/>
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <div class="card-title">Usuários</div>
            <div class="col-auto ms-auto d-print-none">
                <input type="text" placeholder="Pesquisar usuários" id="FormAdminUsers" class="form-control">
            </div>
        </div>
        <div class="card-body">
            <div id="getFake"></div>
            <div class="row">
                <table class="table">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>NOME</th>
                        <th>USERNAME</th>
                        <th>TELEFONE</th>
                        <th>DATA DE REGISTRO</th>
                        <th>NIVEL DE ACESSO</th>
                        <th>EMPRESA</th>
                        <th style="width: 250px!important;">-</th>
                    </tr>
                    </thead>
                    <tbody id="WriteF">

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
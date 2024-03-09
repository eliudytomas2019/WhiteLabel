
<?php if($level >= 5): ?>
    <div class="col-auto ms-auto">
        <div id="getAlert"></div>
        <div class="d-flex">
            <input type="text" id="EliminarFacturaID" class="form-control d-inline-block w-9 me-3" placeholder="ID do documento"/>
            <a href="javascript:void()" onclick="EliminarFactura();" class="btn btn-primary">
                Limpar
            </a>
        </div>
    </div>
<?php endif; ?>
<!---
<div class="mb-3">
    <div>
        <label class="row">
            <span class="col">Impostos (On/Off)</span>
            <span class="col-auto">
                <label class="form-check form-check-single form-switch">
                  <input class="form-check-input" name="SalesType" id="SalesType" onclick="MyCheckBox()" type="checkbox" <?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['SalesType'] == 1): echo "checked"; endif; ?>/>
                </label>
            </span>
        </label>
    </div>
</div>
--->
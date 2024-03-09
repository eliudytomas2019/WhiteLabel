<?php
if(isset($_POST['id_mesa'])): $id_mesa = $_POST['id_mesa']; else: $id_mesa = null; endif;
$suspenso = 0;
$status = 1;

$read = new Read();
$read->ExeRead("sd_billing", "WHERE id_db_settings=:i AND session_id=:ses AND id_mesa=:igg AND suspenso=:s AND status=:st", "i={$id_db_settings}&ses={$id_user}&igg={$id_mesa}&s={$suspenso}&st={$status}");

if($read->getResult()):
    if($read->getResult()[0]['method'] == 'NU' && $read->getResult()[0]['InvoiceType'] != 'PP'):
        ?>
        <div class="col-lg-12">
            <div class="mb-3">
                <label class="form-label">Pagou</label>
                <input type="text" id="pagou" class="form-control calc" placeholder="Pagou">
            </div>
            <div class="mb-3" id="RapCosciente">

            </div>
            <?php
    else:
            ?>
            <input type="hidden" id="pagou" value="0">
            <input type="hidden" id="troco" value="0">
        </div>
        <?php
    endif;
    ?>
    <div class="PDV-left-buttom">
        <a href="javascript:void()"  data-bs-toggle="modal" data-bs-target="#ModalsCarregarDocumentos" class="btn btn-default d-none d-sm-inline-block">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M19 18a3.5 3.5 0 0 0 0 -7h-1a5 4.5 0 0 0 -11 -2a4.6 4.4 0 0 0 -2.1 8.4" /><line x1="12" y1="13" x2="12" y2="22" /><polyline points="9 19 12 22 15 19" /></svg>
            Imprimir
        </a>&nbsp;
        <a href="javascript:void" class="btn btn-success" onclick="AllPDV()">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 12l2 2l4 -4" /><path d="M12 3a12 12 0 0 0 8.5 3a12 12 0 0 1 -8.5 15a12 12 0 0 1 -8.5 -15a12 12 0 0 0 8.5 -3" /></svg>
            Salvar
        </a>
    </div>
<?php
else:
    ?>
    <div class="PDV-left-buttom">

        <a href="javascript:void()"  data-bs-toggle="modal" data-bs-target="#ModalsCarregarDocumentos" class="btn btn-default d-none d-sm-inline-block">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M19 18a3.5 3.5 0 0 0 0 -7h-1a5 4.5 0 0 0 -11 -2a4.6 4.4 0 0 0 -2.1 8.4" /><line x1="12" y1="13" x2="12" y2="22" /><polyline points="9 19 12 22 15 19" /></svg>
            Imprimir
        </a>&nbsp;
        <a href="javascript:void()" onclick="DataPDV()" class="btn btn-primary d-none d-sm-inline-block">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 12l2 2l4 -4" /><path d="M12 3a12 12 0 0 0 8.5 3a12 12 0 0 1 -8.5 15a12 12 0 0 1 -8.5 -15a12 12 0 0 0 8.5 -3" /></svg>
            Processar
        </a>
    </div>
<?php
endif;
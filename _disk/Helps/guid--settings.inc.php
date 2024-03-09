<?php
$s  = 0;
$st = 1;

$read = new Read();

$read->ExeRead("sd_billing",  "WHERE id=:i AND id_db_settings=:sp", "i={$Number}&sp={$id_db_settings}");
if($read->getResult()):
    $dating = $read->getResult()[0];

    $n1 = "sd_billing";
    $n3 = "sd_billing_pmp";
    $n2 = "sd_guid";
    $n4 = "sd_guid_pmp";

    $Cochi = $dating['InvoiceType']." ".$dating['mes'].$dating['Code'].$dating['ano']."/".$dating['numero'];
else:
    header("index.php");
    die();
endif;
?>

<div class="col-md-12">
    <div class="row">
        <div class="col-lg-4">
            <div class="mb-3">
                <label class="form-label">Data de emissão</label>
                <input type="date" id="TaxPointDate" value="<?= date('Y-m-d'); ?>" class="form-control">
            </div>
        </div>
        <div class="col-lg-4">
            <div class="mb-3">
                <label class="form-label">Modelo de documento</label>
                <select class="form-control" id="InvoiceType">
                    <option value="GT">GUIA DE TRANSPORTE</option>
                </select>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="mb-3">
                <label class="form-label">Informações do documento</label>
                <select class="form-control" id="method">
                    <option value="CC">Cartão de Credito</option>
                    <option selected value="CD">Cartão de Debito</option>
                    <option value="CH">Cheque Bancário</option>
                    <option value="NU">Numerário</option>
                    <option value="TB">Transferência Bancária</option>
                    <option value="MB">Referência de pagamentos para Multicaixa</option>
                    <option value="OU">Outros Meios Aqui não Assinalados</option>
                </select>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <div class="mb-3">
                <label class="form-label">Nome do entregador</label>
                <input type="text" class="form-control" id="guid_name" placeholder="Nome do entregador"/>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="mb-3">
                <label class="form-label">Matrícula do veiculo</label>
                <input type="text" class="form-control" id="guid_matricula" placeholder="Matrícula do veiculo"/>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="mb-3">
                <label class="form-label">Observações</label>
                <input type="text" class="form-control" id="guid_obs" placeholder="Observações"/>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <div class="mb-3">
                <label class="form-label">Endereço do cliente</label>
                <input type="text" id="guid_endereco" class="form-control" placeholder="ENDEREÇO"/>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="mb-3">
                <label class="form-label">Cidade</label>
                <input type="text" id="guid_city" class="form-control" placeholder="CIDADE"/>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="mb-3">
                <label class="form-label">Caixa postal</label>
                <input type="text" id="guid_postal" class="form-control" placeholder="CAIXA POSTAL"/>
            </div>
        </div>
    </div>

    <a href="javascript:void" onclick="Guid(<?= $Number; ?>, '<?= $Commic; ?>')" class="btn btn-primary">Processar</a>
    <hr/>
</div>

<div class="Aleluya">
    <?php
    $sL = 1;
    $q  = 0;
    $read->ExeRead("sd_guid", "WHERE id_db_settings=:i AND status=:st", "i={$id_db_settings}&st={$sL}");
    if($read->getResult()):
        ?>
        <form method="post" action="" enctype="multipart/form-data">
            <div id="getAlert"></div>
            <table class="table">
                <thead>
                <tr>
                    <th>Item</th>
                    <th>Quantidade</th>
                    <th>Ação</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $read->ExeRead("sd_billing_pmp", "WHERE id_db_settings=:i AND numero=:iS AND InvoiceType=:ip AND product_type='P' ", "i={$id_db_settings}&iS={$dating['numero']}&ip={$Commic}");
                if($read->getResult()):
                    foreach($read->getResult() as $key):

                        ?>
                        <tr>
                            <td>
                                <?= $key['product_name'] ?>
                                <input type="hidden" id="id_db_settings_<?= $key['id']; ?>" value="<?= $id_db_settings; ?>"/>
                                <input type="hidden" id="id_user_<?= $key['id']; ?>" value="<?= $id_user;?>"/>
                                <input type="hidden" id="idd_<?= $key['id']; ?>" value="<?= $key['id_product'];?>"/>
                                <input type="hidden" id="status_<?= $key['id']; ?>" value="<?= $key['status']; ?>"/>
                            </td>
                            <td><input type="number" min="0" value="<?= $key['quantidade_pmp']; ?>" class="form-control" id="quantidade_<?= $key['id']; ?>" max="<?= $key['quantidade_pmp']; ?>" placeholder="Quantidade"></td>
                            <td><a href="javascript:void" onclick="AddGuid(<?= $key['id']; ?>, '<?= $Commic; ?>')" class="btn btn-default"><svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" /><line x1="12" y1="11" x2="12" y2="17" /><line x1="9" y1="14" x2="15" y2="14" /></svg></a></td>
                        </tr>

                    <?php
                    endforeach;
                endif;
                ?>
                </tbody>
            </table>
        </form>
        <i class="col-line"></i>
        <a href="javascript:void()" onclick="GuidFinish('<?= $Commic; ?>', <?= $Number; ?>)" class="btn btn-primary">Finalizar</a>
        <br/>
    <?php
    endif;
    ?>
</div>
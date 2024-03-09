<?php
$date_i = strip_tags(trim($_GET['date_i']));
$date_f = strip_tags(trim($_GET['date_f']));
$pesquisar = strip_tags(trim($_GET['pesquisar']));
$id_users = strip_tags(trim($_GET['id_users']));
if (isset($_GET['id_db_settings'])): $id_db_settings = strip_tags(trim($_GET['id_db_settings'])); endif;
if(strlen($date_i) <= 0 || empty($date_i)): $date_i = date('Y-m-d'); endif;
if(strlen($date_f) <= 0 || empty($date_f)): $date_f = date('Y-m-d'); endif;

$data_inicial = explode("-", $date_i);
$data_final   = explode("-", $date_f);
?>
    <title>Relatório da Oficina de <?= $date_i ?> à <?= $date_f ?></title>
    <div class="MAT">
        <div class="Yolanda">
            <h1 class="header-one pussy">Relatório da Oficina de <?= $date_i ?> à <?= $date_f ?></h1>
            <p class="Luzineth">Moeda: (AOA) </p>
        </div>
        <table class="Pai">
            <thead>
            <tr>
                <th>Data de emissão</th>
                <th>Hora de emissão</th>
                <th>Emitida por</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td><?= date('d-m-Y'); ?></td>
                <td><?= date('H:i:s'); ?></td>
                <td><?= $userlogin['name'] ?></td>
            </tr>
            </tbody>
        </table>
    </div>

    <table class="table text-center">
        <thead>
        <tr>
            <th>Nº</th>
            <th>Documento</th>
            <th>Hora & Data</th>
            <th>Cliente/<br/>NIF/<br/>Endereço</th>
            <th>VEICULO<br/>/Observações</th>
            <th>Matricula</th>
            <th>LAUDO TÉNICO/<br/>DESCRIÇÃO DO PROBLEMA<br/>/OBSERVAÇÕES</th>
            <th>Itens adicionados</th>
            <th>Quantidade</th>
            <th>Mêcanico</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $status = 3;
        $documents = "FO";

        $ids = " ii_billing.id_db_settings={$id_db_settings} AND ii_billing_pmp.id_db_settings={$id_db_settings} AND ";
        $datas = " AND ii_billing.dia BETWEEN {$data_inicial[2]} AND {$data_final[2]} AND ii_billing.mes BETWEEN {$data_inicial[1]} AND {$data_final[1]} AND ii_billing.ano BETWEEN {$data_inicial[0]} AND {$data_final[0]} ";
        if($id_users == "all"):  $usuarios = ""; else: $usuarios = " AND ii_billing.id_mecanico='{$id_users}' "; endif;
        //$docs = " AND ii_billing.InvoiceType='{$documents}' AND ii_billing_pmp.InvoiceType='{$documents}' ";
        if($pesquisar == "" || $pesquisar == '' || empty($pesquisar) || $pesquisar == null || !isset($pesquisar)):
            $link = $documents;
            $search = " AND ii_billing.InvoiceType=:link AND ii_billing_pmp.InvoiceType=:link ";
        else:
            $link = $pesquisar;
            $search = " AND (ii_billing.customer_name LIKE '%' :link '%' AND ii_billing.InvoiceType='{$documents}' AND ii_billing_pmp.InvoiceType='{$documents}' ) OR (ii_billing.customer_nif LIKE '%'  :link  '%' AND  ii_billing.InvoiceType='{$documents}' AND ii_billing_pmp.InvoiceType='{$documents}') OR (ii_billing.customer_endereco LIKE '%' :link '%' AND ii_billing.InvoiceType='{$documents}' AND ii_billing_pmp.InvoiceType='{$documents}') OR (ii_billing.kilometragem LIKE '%'  :link  '%' AND ii_billing.InvoiceType='{$documents}' AND ii_billing_pmp.InvoiceType='{$documents}' ) OR (ii_billing.matricula LIKE '%' :link  '%' AND ii_billing.InvoiceType='{$documents}' AND ii_billing_pmp.InvoiceType='{$documents}') OR (ii_billing.v_modelo LIKE '%'  :link  '%' AND ii_billing.InvoiceType='{$documents}' AND ii_billing_pmp.InvoiceType='{$documents}')";
        endif;

        $n = 0;
        $Read = new Read();
        $Read->ExeRead("ii_billing, ii_billing_pmp", "WHERE {$ids} ii_billing_pmp.id_invoice=ii_billing.id AND ii_billing.status={$status} {$search} {$datas} ", "link={$link}");
        if($Read->getResult()):
            foreach ($Read->getResult() as $key):
                $n += 1;
                ?>
                <tr>
                    <td><?= $n; ?></td>
                    <td><?= $key['InvoiceType']." ".$key['mes'].$key['Code'].$key['ano']."/".$key['numero']; ?></td>
                    <td><?= $key["dia"]."/".$key["mes"]."/".$key["ano"]." ".$key["hora"]; ?></td>
                    <td><?= $key['customer_name']; ?><br/><?= $key['customer_nif']; ?><br/><?= $key['customer_endereco']; ?></td>
                    <td><?= $key['v_modelo']; ?><br/><?php $Read->ExeRead("i_veiculos", "WHERE id_db_settings={$id_db_settings} AND id={$key['id_veiculo']}"); if($Read->getResult()): echo $Read->getResult()[0]['content']; endif; ?></td>
                    <td><?= $key['matricula']; ?></td>
                    <td><?= $key['fo_laudo']; ?><br><?= $key['fo_problema']; ?><br/><?= $key['fo_observacoes']; ?></td>
                    <td><?= $key['product']; ?></td>
                    <td><?= $key['qtd_pmp']; ?></td>
                    <td><?php if(!empty($key['id_mecanico'])): $Read->ExeRead("db_users", "WHERE id_db_settings={$id_db_settings} AND id={$key['id_mecanico']}"); if($Read->getResult()): echo $Read->getResult()[0]['name']; endif; endif; ?></td>
                </tr>
            <?php
            endforeach;
        endif;
        ?>
        </tbody>
    </table>
<?php
require("_SystemWoW/footer-invoice-geral.inc.php");
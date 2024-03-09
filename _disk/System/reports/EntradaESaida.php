<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Entrada e Saída de Valores</h3>&nbsp;
        </div>
        <div class="card-body">
            <table class="table" style="text-align: left!important;align-content: flex-start!important;align-items: flex-start!important;">
                <thead>
                <tr>
                    <th>Número</th>
                    <th>Nº do Documento</th>
                    <th>Cliente</th>
                    <th>Forma de Pagamento</th>
                    <th>Data</th>
                    <th>-</th>
                </tr>
                </thead>
                <tbody>
                <?php

                $s = 0;
                $posti = 0;
                $getPage = filter_input(INPUT_GET, 'page',FILTER_VALIDATE_INT);
                $Pager = new Pager("painel.php?exe=reports/EntradaESaida{$n}&page=");
                $Pager->ExePager($getPage, 20);

                $n1 = "av_entrada_e_saida";

                $read = new Read();
                $read->ExeRead("{$n1}", "WHERE {$n1}.id_db_settings=:i ORDER BY {$n1}.id DESC LIMIT 10", "i={$id_db_settings}");
                if($read->getResult()):
                    foreach ($read->getResult() as $key):
                        include("_disk/AppData/ResultDocuments.inc.php");
                    endforeach;
                endif;
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
/**
 * Created by PhpStorm.
 * User: Kwanzar Soft
 * Date: 23/06/2020
 * Time: 14:50
 */
?>
<div class="card-header">
    <h4>Control de vendas a crédito</h4>
</div>
<div class="card-body">
    <div class="table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th>CLIENTE</th>
                <th>Nº DE DOC.</th>
                <th>VALOR</th>
                <th>LIQUIDADO</th>
                <th>DIFERENÇA</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $Ln1 = 0;
            $Ln2 = 0;
            $Ln3 = 0;

            $Read = new Read();
            $Read->ExeRead("cv_customer", "WHERE id_db_settings=:i ORDER BY nome ASC", "i={$id_db_settings}");


            if($Read->getResult()):
                foreach($Read->getResult() as $key):
                    extract($key);
                    $doc = 0;
                    $To1 = 0;
                    $To2 = 0;

                    $Read->ExeRead("sd_billing", "WHERE id_db_settings=:i AND id_customer=:ip AND InvoiceType='FT' ", "i={$id_db_settings}&ip={$key['id']}");
                    if($Read->getResult()):
                        $doc += $Read->getRowCount();
                        foreach($Read->getResult() as $k):
                            $s = 0;
                            $Read->ExeRead("sd_billing_pmp", "WHERE id_db_settings=:i AND numero=:n AND suspenso=:s", "i={$id_db_settings}&n={$k['numero']}&s={$s}");
                            if($Read->getResult()):
                                foreach($Read->getResult() as $non):
                                    extract($non);
                                    $value = $non['quantidade_pmp'] * $non['preco_pmp'];
                                    $taxa = ($value * $non['taxa']) / 100;
                                    if($non['desconto_pmp'] >= 100):
                                        $desconto = $non['desconto_pmp'];
                                    else:
                                        $desconto = ($value * $non['desconto_pmp']) / 100;
                                    endif;
                                    //$desconto = ($value * $non['desconto_pmp']) / 100;

                                    $To1 += ($value - $desconto) + $taxa;
                                endforeach;
                            endif;

                            $Invoice = $k['InvoiceType']." ".$k['mes'].$k['Code'].$k['ano']."/".$k['numero'];

                            $Read->ExeRead("sd_retification, sd_retification_pmp", "WHERE sd_retification.id_db_settings=:i AND sd_retification.Invoice=:in AND sd_retification_pmp.numero=sd_retification.numero AND sd_retification_pmp.id_db_settings=:i", "i={$id_db_settings}&in={$Invoice}");

                            if($Read->getResult()):
                                foreach($Read->getResult() as $f):
                                    extract($f);
                                    $value = $f['quantidade_pmp'] * $f['preco_pmp'];
                                    $taxa = ($value * $f['taxa']) / 100;
                                    if($f['desconto_pmp'] >= 100):
                                        $desconto = $f['desconto_pmp'];
                                    else:
                                        $desconto = ($value * $f['desconto_pmp']) / 100;
                                    endif;
                                    //$desconto = ($value * $f['desconto_pmp']) / 100;

                                    $To2 += ($value - $desconto) + $taxa;
                                endforeach;
                            endif;
                        endforeach;
                    endif;


                    $Df = $To1 - $To2;
                    $Ln1 += $To1;
                    $Ln2 += $To2;
                    $Ln3 += $Df;
                    ?>
                    <tr>
                        <td><?= $key['nome']; ?></td>
                        <td><?= $doc; ?></td>
                        <td><?= number_format($To1, 2)." ".DBKwanzar::CheckConfig($id_db_settings)['moeda']; ?></td>
                        <td><?= number_format($To2, 2)." ".DBKwanzar::CheckConfig($id_db_settings)['moeda']; ?></td>
                        <td><?= number_format($Df, 2)." ".DBKwanzar::CheckConfig($id_db_settings)['moeda']; ?></td>
                    </tr>
                    <?php
                endforeach;
            endif;
            ?>
            </tbody>
            <tfoot>
            <tr>
                <th></th>
                <th>Totais:</th>
                <th><?= number_format($Ln1, 2)." ".DBKwanzar::CheckConfig($id_db_settings)['moeda']; ?></th>
                <th><?= number_format($Ln2, 2)." ".DBKwanzar::CheckConfig($id_db_settings)['moeda']; ?></th>
                <th><?= number_format($Ln3, 2)." ".DBKwanzar::CheckConfig($id_db_settings)['moeda']; ?></th>
            </tr>
            </tfoot>
        </table>
    </div>
</div>

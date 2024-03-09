<?php
/**
 * Created by PhpStorm.
 * User: Kwanzar Soft
 * Date: 17/06/2020
 * Time: 17:37
 */

if(!class_exists('login')):
    header("index.php");
    die();
endif;

if($level >= 4): $n =  '&id_db_settings='.$id_db_settings; else: $n = null; endif;
?>

<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">KWANZAR</h4>
        <ul class="breadcrumbs">
            <li class="nav-home">
                <a href="<?= HOME; ?>panel.php?exe=default/home<?= $n; ?>">
                    <i class="flaticon-home"></i>
                </a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="<?= HOME; ?>panel.php?exe=purchase/index<?= $n; ?>">Estoque</a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="<?= HOME; ?>panel.php?exe=invoice/alert<?= $n; ?>">Inventário de Estoque</a>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Inventário de Estoque</h4>
                </div>
                <div class="card-body">
                    <div class="card-sub">
                        para imprimir click em <a href="<?= HOME; ?>print.php?action=07<?= $n; ?>" target="_blank">Imprimir</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Artigo</th>
                                    <th>Descrição</th>
                                    <th>Estoque atual</th>
                                    <th>Un.</th>
                                    <th>Preço</th>
                                    <th>Valor</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $tQ = 0;
                                    $tV = 0;
                                    $read = new Read();
                                    $read->ExeRead("cv_product", "WHERE id_db_settings=:i AND type='P'", "i={$id_db_settings}");

                                    if($read->getResult()):
                                        foreach($read->getResult() as $key):
                                            extract($key);
                                            $i0 = 0;
                                            $o0 = 0;
                                            $st = 1;

                                            $read->ExeRead("sd_purchase", "WHERE id_db_settings=:i AND id_product=:ip AND status={$st}", "i={$id_db_settings}&ip={$key['id']}");
                                            if($read->getResult()):
                                                foreach($read->getResult() as $k):
                                                    extract($k);


                                                    if(DBKwanzar::CheckSettingsII($id_db_settings)['atividade'] == 1):
                                                        $qtd = $k['quantidade'];
                                                    else:
                                                        $qtd = $k['quantidade'] * $k['unidade'];
                                                    endif;

                                                    $i0 += $qtd;
                                                    $o0 += $qtd * $key['preco_venda'];
                                                endforeach;
                                            endif;

                                            $tQ += $i0;
                                            $tV += $o0;
                                            ?>
                                            <tr>
                                                <td><?= $key['codigo']; ?></td>
                                                <td><?= $key['product']; ?></td>
                                                <td><?= number_format($i0, 2); ?></td>
                                                <td><?= $key['unidade_medida']; ?></td>
                                                <td><?= number_format($key['preco_venda'], 2); ?></td>
                                                <td><?= number_format($o0, 2); ?></td>
                                            </tr>
                                            <?php
                                        endforeach;
                                    endif;
                                ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th>Totais</th>
                                    <th><?= number_format($tQ, 2); ?></th>
                                    <th></th>
                                    <th></th>
                                    <th><?= number_format($tV, 2); ?>&nbsp;<?php if(DBKwanzar::CheckConfig($id_db_settings) != false): echo DBKwanzar::CheckConfig($id_db_settings)['moeda']; endif; ?></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
/**
 * Created by PhpStorm.
 * User: Kwanzar Soft
 * Date: 30/07/2020
 * Time: 00:03
 */

if(!class_exists('login')):
    header("index.php");
    die();
endif;

if($level >= 4): $n =  '&id_db_settings='.$id_db_settings; else: $n = null; endif;

if($userlogin['level'] < 3):
    header("location: panel.php?exe=default/index".$n);
endif;

?>
<div class="page-inner">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Histórico de Actividades do presente ano.</div>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="htmlLegendsChart05"></canvas>
                    </div>
                    <div id="myChartLegend05"></div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table mt-3">
                            <thead>
                            <tr>
                                <th>Usuário</th>
                                <th style="width: 70px!important;">Página</th>
                                <th>IP</th>
                                <th style="width: 70px!important;">Sistema</th>
                                <th>Hora e Data</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php

                            $posti = 0;
                            $getPage = filter_input(INPUT_GET, 'page',FILTER_VALIDATE_INT);
                            $Pager = new Pager("panel.php?exe=settings/active{$n}&page=");
                            $Pager->ExePager($getPage, 10);

                            $read->ExeRead("db_users_active_store", "WHERE id_db_settings=:id ORDER BY id DESC LIMIT :limit OFFSET :offset", "id={$id_db_settings}&limit={$Pager->getLimit()}&offset={$Pager->getOffset()}");
                            if($read->getResult()):
                                foreach ($read->getResult() as $key):
                                    extract($key);
                                    ?>
                                    <tr>
                                        <td><?= DBKwanzar::ViewsUsers($key['session_id'])["name"]; ?></td>
                                        <td style="width: 70px!important;"><?= $key["page"]; ?></td>
                                        <td><?= $key["user_ip"]; ?></td>
                                        <td style="width: 70px!important;"><?= $key["system"]; ?></td>
                                        <td><?= $key["hora"]." ".$key["data"]; ?></td>
                                    </tr>
                                    <?php
                                endforeach;
                            endif;
                            ?>
                            </tbody>
                        </table>
                        <?php
                        $Pager->ExePaginator("db_users_active_store");
                        echo $Pager->getPaginator();
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
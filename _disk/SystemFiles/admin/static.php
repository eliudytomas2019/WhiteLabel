<?php

$Read = new Read();
$Reads = new Read();
?>

<div class="row row-deck row-cards">
    <div class="card-body">
        <?php
        if(!class_exists('login')):
            header("index.php");
            die();
        endif;

        if($userlogin['level'] <= 4):
            header("location: panel.php?exe=default/index".$n);
        endif;
        ?>

        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex">
                        <h3 class="card-title">Estatísticas de acesso mensal</h3>
                    </div>
                    <div id="chart-social-referrals"></div>
                </div>
            </div>
        </div>
        <br/>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex">
                        <h3 class="card-title">Estatísticas de acesso anual</h3>
                    </div>
                    <div id="02-admin-static-charts"></div>
                </div>
            </div>
        </div>
        <br/>
        <div class="row">
            <div class="col-lg-8 col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex">
                            <h3 class="card-title">Navegadores mais usados</h3>
                        </div>
                        <div id="03-admin-static"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex">
                            <h3 class="card-title">Usuários frequente</h3>
                        </div>
                        <div id="04-admin-static"></div>
                    </div>
                </div>
            </div>
        </div>
        <br/>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex">
                        <h3 class="card-title">Empresas frequente</h3>
                    </div>
                    <div id="15-admin-static"></div>
                </div>
            </div>
        </div>
        <br/>
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="modal-title">Registro de atividades</h5>
                </div>
                <div class="card-body">
                    <div class="divide-y">
                        <?php
                        $posti = 0;
                        $getPage = filter_input(INPUT_GET, 'page',FILTER_VALIDATE_INT);
                        $Pager = new Pager("Admin.php?exe=admin/static&page=");
                        $Pager->ExePager($getPage, 5);

                        $Read = new Read();
                        $Reads = new Read();
                        $Read->ExeRead("db_users_active_store", "ORDER BY id DESC LIMIT :limit OFFSET :offset", "limit={$Pager->getLimit()}&offset={$Pager->getOffset()}");
                        if($Read->getResult()):
                            foreach ($Read->getResult() as $key):
                                $Reads->ExeRead("db_users", "WHERE id=:i ", "i={$key['session_id']}");
                                if($Reads->getResult()): $use = $Reads->getResult()[0]; else: $use = null; endif;
                                ?>
                                <div>
                                    <div class="row">
                                        <div class="col-auto">
                                            <span class="avatar" style="background-image: url(./uploads/<?php if($use['cover'] == "" || $use['cover'] == null): echo "user.png"; else: echo $use['cover']; endif; ?>)"></span>
                                        </div>
                                        <div class="col">
                                            <div class="text-truncate">
                                                <strong><?= $use["name"]; ?></strong> acessou: <strong>"<?= $key["page"]; ?>"</strong>
                                            </div>
                                            <div class="text-muted" style="color: #313030!important;">pelo navegador: <strong><?= $key["browser"]; ?></strong>, data de navegaçāo: <strong><?= $key["data"]; ?></strong>, com o endereço de IP: <strong><?= $key["user_ip"]; ?></strong>, usando o sistema operacional: <strong><?= $key["system"]; ?></strong>, <strong><?= $key["x"]; ?></strong>x</div>
                                        </div>
                                        <div class="col-auto align-self-center">
                                            <div class="badge bg-primary"></div>
                                        </div>
                                    </div>
                                </div>
                            <?php
                            endforeach;
                        endif;

                        $Pager->ExePaginator("db_users_active_store", "ORDER BY id DESC");
                        echo $Pager->getPaginator();
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
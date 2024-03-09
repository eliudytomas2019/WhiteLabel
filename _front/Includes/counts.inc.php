<div class="fact">
    <div class="container-fluid">
        <?php
        $Read = new Read();

        $Read->ExeRead("db_settings");
        if($Read->getRowCount()):
            $Empresas = $Read->getRowCount();
        endif;


        $Read->ExeRead("db_users");
        if($Read->getRowCount()):
            $Usuarios = $Read->getRowCount();
        endif;

        $Read->ExeRead("cv_customer");
        if($Read->getRowCount()):
            $Clientes = $Read->getRowCount();
        endif;

        $Read->ExeRead("sd_billing");
        if($Read->getRowCount()):
            $Documentos = $Read->getRowCount();
        endif;
        ?>
        <div class="row counters">
            <div class="col-md-6 fact-left wow slideInLeft">
                <div class="row">
                    <div class="col-6">
                        <div class="fact-icon">
                        </div>
                        <div class="fact-text">
                            <h2 data-toggle="counter-up"><?= $Empresas; ?></h2>
                            <p>Empresas</p>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="fact-icon">
                        </div>
                        <div class="fact-text">
                            <h2 data-toggle="counter-up"><?= $Usuarios; ?></h2>
                            <p>Usuários</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 fact-right wow slideInRight">
                <div class="row">
                    <div class="col-6">
                        <div class="fact-icon">
                        </div>
                        <div class="fact-text">
                            <h2 data-toggle="counter-up"><?= $Clientes; ?></h2>
                            <p>Clientes</p>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="fact-icon">
                        </div>
                        <div class="fact-text">
                            <h2 data-toggle="counter-up"><?= $Documentos; ?></h2>
                            <p>Facturas feitas</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
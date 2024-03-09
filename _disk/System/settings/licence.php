<?php
if(!class_exists('login')):
    header("index.php");
    die();
endif;

if($level >= 4): $n =  '&id_db_settings='.$id_db_settings; else: $n = null; endif;

if($userlogin['level'] < 3):
    header("Location: painel.php?exe=default/index".$n);
endif;


$st = 1;
$times = null;
$Datatime = ["", "Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"];

$read = new Read();
$read->ExeRead("ws_times", "WHERE id_db_kwanzar=:i AND status=:st", "i={$userlogin['id_db_kwanzar']}&st={$st}");
if($read->getResult()):
    $times = $read->getResult()[0];
    $ps3 = $times['plano'];
    $data_inicial = date('Y-m-d');
    $data_final = $times['times'];
    $diferenca = strtotime($data_final) - strtotime($data_inicial);
    $dias = floor($diferenca / (60 * 60 * 24));
else:
    unset($_SESSION['userlogin']);
    header('Location: _login.php?exe=restrito');
endif;
?>
<div class="page-header d-print-none">
    <div class="row align-items-center">
        <div class="col">
            <h2 class="page-title">
                Configurações
            </h2>
        </div>
    </div>
</div>
<div class="row gx-lg-4">
    <?php
        require_once("_disk/IncludesApp/MenuSettings.inc.php");
        $fim = explode("-", $times['times']);
        if($fim[1] <= "09"):
            $ips = (int) $fim[1];
            $fim[1] = $ips;
        endif;

        if($times["mes"] <= "09"):
            $opp = (int) $times["mes"];
            $times["mes"] = $opp;
        endif;
    ?>
    <div class="col-lg-9">
        <div class="card">
            <div class="card-header">
                <h5 class="modal-title">Saldo de conta</h5>
            </div>
            <div class="card-body">
                <div class="markdown">
                    <p>De <?= $times['dia']." de ".$Datatime[$times['mes']]." de ".$times['ano']; ?> à <?= $fim[2]." de ".$Datatime[$fim[1]]." de ".$fim[0]; ?>.</p>
                    <h2 id="supported-browsers">CONTA EM MODO - <?= $ps3; ?></h2>
                    <table>
                        <thead>
                            <tr>
                                <th>Conta</th>
                                <th>Saldo mensal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Plano: <?= $ps3; ?> (<?= number_format($times['pricing'], 2);  ?> Kz / mês)</td>
                                <td>Documentos: <?= $times['documentos_feito']." / ".$times['documentos']; ?></td>
                            </tr>
                            <tr>
                                <td>Saldo: <?= $dias; ?> dia(s)</td>
                                <td>Utilizadores: <?= $times['users_de']." / ".$times['users']; ?></td>
                            </tr>
                            <tr>
                                <td>Válido até: <?= $fim[2]." de ".$Datatime[$fim[1]]." de ".$fim[0]; ?></td>
                                <td>Total pago: <?= number_format($times['total'], 2); ?> Kz</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
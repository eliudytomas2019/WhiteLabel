<?php
if(!class_exists('login')):
    header("index.php");
    die();
endif;

if($level >= 4): $n =  '&id_db_settings='.$id_db_settings; else: $n = null; endif;
$postid = filter_input(INPUT_GET, "postid", FILTER_VALIDATE_INT);

$Read = new Read();
$Read->ExeRead("cv_customer", "WHERE id=:i AND id_db_settings=:st ", "i={$postid}&st={$id_db_settings}");

if($Read->getResult()):
    $CustomerData = $Read->getResult()[0];
else:
    $CustomerData = null;
endif;

if(!empty($CustomerData['ano'])): $dateY = date('Y') - $CustomerData['ano']; else: $dateY = null; endif;

$ArrayOdontograma = ["", "18", "17", "16", "15", "14", "13", "12", "11", "21", "22", "23", "24", "25", "26", "27", "28", "48", "47", "46", "45", "44", "43", "42", "41", "31", "32", "33", "34", "35", "36", "37", "38", "55", "54", "53", "52", "51", "61", "62", "63", "64", "65", "85", "84", "83", "82", "81", "71", "72", "73", "74", "75"];

$Read->ExeRead("cv_customer_odontograma", "WHERE id_paciente=:i AND id_db_settings=:st ", "i={$postid}&st={$id_db_settings}");
if(!$Read->getResult()):
    for($ig = 1; $ig <= 52; $ig++):
        $Data['dente'] = $ArrayOdontograma[$ig];

        if($ArrayOdontograma[$ig] >= 11 && $ArrayOdontograma[$ig] <= 28):
            $Data['arcada'] = "arcada_superior";
            $Data['modelo'] = "permanentes";
        elseif($ArrayOdontograma[$ig] >= 31 && $ArrayOdontograma[$ig] <= 48):
            $Data['arcada'] = "arcada_inferior";
            $Data['modelo'] = "permanentes";
        elseif($ArrayOdontograma[$ig] >= 51 && $ArrayOdontograma[$ig] <= 55):
            $Data['arcada'] = "arcada_superior";
            $Data['modelo'] = "decidous";
        elseif($ArrayOdontograma[$ig] >= 71 && $ArrayOdontograma[$ig] <= 85):
            $Data['arcada'] = "arcada_inferior";
            $Data['modelo'] = "decidous";
        endif;

        $Data['status'] = 1;

        $Dental = new KwanzarDental();
        $Dental->CreateOdontograma($id_db_settings, $postid, $Data);

        if(!$Dental->getResult()):
            WSError($Dental->getError()[0], $Dental->getError()[1]);
        endif;
    endfor;
endif;

require_once("_disk/IncludesApp/Modal-odontograma.inc.php");
?>
<div class="page-header">
    <div class="row align-items-center">
        <div class="row">
            <div class="col-auto">
                <img src="./uploads/<?php if($CustomerData['cover'] != ''): echo $CustomerData['cover']; else: echo 'default.jpg'; endif;  ?>" style="max-width: 80px!important;max-height: 80px!important;border-radius: 4px!important;margin-right: 20px!important;"/>
            </div>
            <div class="col">
                <div class="text-truncate">
                    <h2><?= $CustomerData['nome']; ?></h2>
                </div>
                <div><?= $CustomerData["email"]; ?> | +244 <?= $CustomerData["telefone"]; ?> | <?= $CustomerData["nif"]; ?> | <?= $dateY; ?> anos</div>
            </div>
            <div class="col-auto align-self-center">
                <a href="panel.php?exe=patient/update<?= $n; ?>&postid=<?= $postid; ?>" class="btn btn-warning">Editar paciente</a>
                <?php if($level >= 4): ?>
                    <a href="javascript:void" onclick="DeletePaciente(<?= $postid; ?>)" title="Deletar" class="btn btn-danger">Apagar</a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php
        $Read = new Read();
        $Read->ExeRead("cv_customer_anamnese", "WHERE id_paciente=:userid AND id_db_settings=:i", "userid={$postid}&i={$id_db_settings}");
        if ($Read->getResult()):
            $Alerts = $Read->getResult()[0];
        else:
            $Alerts = null;
        endif;

        $alerts = null;
        $Jugadores = [];

        if(isset($Alerts['anamnese_4'])  && $Alerts['anamnese_4'] == "Sim" || isset($Alerts['anamnese_7'])  && $Alerts['anamnese_7'] == "Sim" || isset($Alerts['anamnese_8'])  && $Alerts['anamnese_8'] == "Sim" || isset($Alerts['anamnese_9'])  && $Alerts['anamnese_9'] == "Sim" || isset($Alerts['anamnese_10'])  && $Alerts['anamnese_10'] == "Sim" || isset($Alerts['anamnese_11'])  && $Alerts['anamnese_11'] == "Sim" || isset($Alerts['anamnese_12'])  && $Alerts['anamnese_12'] == "Sim" || isset($Alerts['anamnese_13'])  && $Alerts['anamnese_13'] == "Sim" || isset($Alerts['anamnese_14'])  && $Alerts['anamnese_14'] == "Sim" || isset($Alerts['anamnese_15'])  && $Alerts['anamnese_15'] == "Sim" || isset($Alerts['anamnese_16'])  && $Alerts['anamnese_16'] == "Sim" || isset($Alerts['anamnese_17'])  && $Alerts['anamnese_17'] == "Sim" || isset($Alerts['anamnese_18'])  && $Alerts['anamnese_18'] == "Sim" || isset($Alerts['anamnese_37'])  && $Alerts['anamnese_37'] == "Sim" || isset($Alerts['anamnese_54'])  && $Alerts['anamnese_54'] == "Sim"):
            if(isset($Alerts['anamnese_4'])): $alerts += 1; $ax = explode("?", $Anamnese[4]); $Jugadores[] = $ax[0]; endif;
            if(isset($Alerts['anamnese_7'])): $alerts += 1; $ax = explode("?", $Anamnese[7]); $Jugadores[]  = $ax[0]; endif;
            if(isset($Alerts['anamnese_8'])): $alerts += 1; $ax = explode("?", $Anamnese[8]); $Jugadores[]  = $ax[0]; endif;
            if(isset($Alerts['anamnese_9'])): $alerts += 1; $ax = explode("?", $Anamnese[9]); $Jugadores[]  = $ax[0]; endif;
            if(isset($Alerts['anamnese_10'])): $alerts += 1; $ax = explode("?", $Anamnese[10]); $Jugadores[]  = $ax[0]; endif;
            if(isset($Alerts['anamnese_11'])): $alerts += 1; $ax = explode("?", $Anamnese[11]); $Jugadores[]  = $ax[0]; endif;
            if(isset($Alerts['anamnese_12'])): $alerts += 1; $ax = explode("?", $Anamnese[12]); $Jugadores[]  = $ax[0]; endif;
            if(isset($Alerts['anamnese_13'])): $alerts += 1; $ax = explode("?", $Anamnese[13]); $Jugadores[]  = $ax[0]; endif;
            if(isset($Alerts['anamnese_14'])): $alerts += 1; $ax = explode("?", $Anamnese[14]); $Jugadores[]  = $ax[0]; endif;
            if(isset($Alerts['anamnese_15'])): $alerts += 1; $ax = explode("?", $Anamnese[15]); $Jugadores[]  = $ax[0]; endif;
            if(isset($Alerts['anamnese_16'])): $alerts += 1; $ax = explode("?", $Anamnese[16]); $Jugadores[]  = $ax[0]; endif;
            if(isset($Alerts['anamnese_17'])): $alerts += 1; $ax = explode("?", $Anamnese[17]); $Jugadores[]  = $ax[0]; endif;
            if(isset($Alerts['anamnese_18'])): $alerts += 1; $ax = explode("?", $Anamnese[18]); $Jugadores[]  = $ax[0]; endif;
            if(isset($Alerts['anamnese_37'])): $alerts += 1; $ax = explode("?", $Anamnese[37]); $Jugadores[]  = $ax[0]; endif;
            if(isset($Alerts['anamnese_54'])): $alerts += 1; $ax = explode("?", $Anamnese[54]); $Jugadores[]  = $ax[0]; endif;

            ?>
            <div class="alert alert-warning" role="alert">
                <a href="#" class="alert-link"><!-- Download SVG icon from http://tabler-icons.io/i/alert-triangle -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 9v2m0 4v.01" /><path d="M5 19h14a2 2 0 0 0 1.84 -2.75l-7.1 -12.25a2 2 0 0 0 -3.5 0l-7.1 12.25a2 2 0 0 0 1.75 2.75" /></svg> <?= $alerts; ?> alerta(s) de saúde</a>

                <small><?php for($it = 0; $it <= $alerts-1; $it++): echo "[".$Jugadores[$it]."], "; endfor; ?></small>
            </div>
            <?php
        endif;
    ?>
    <hr/>
</div>

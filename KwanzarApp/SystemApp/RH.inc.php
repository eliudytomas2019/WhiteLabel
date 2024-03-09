<?php
/**
 * Created by PhpStorm.
 * User: Kwanzar Soft
 * Date: 28/08/2020
 * Time: 19:22
 */

$acao = strip_tags((filter_input(INPUT_POST, 'acao', FILTER_DEFAULT)));

if($acao):
    require_once("../../Config.inc.php");
    if(isset($_POST['id_db_kwanzar'])):  $id_db_kwanzar   = (int) $_POST['id_db_kwanzar']; endif;
    if(isset($_POST['id_db_settings'])): $id_db_settings  = (int) $_POST['id_db_settings']; endif;
    if(isset($_POST['id_user'])):        $userlogin['id'] = (int) $_POST['id_user']; $id_user = (int) $_POST['id_user']; endif;
    if(isset($_POST['level'])):          $level           = (int) $_POST['level']; endif;

    switch ($acao):
        case 'DeleteHorarios':
            $id          = strip_tags(trim($_POST['id']));

            $RH = new RH();
            $RH->DeleteHorarios($id, $id_db_settings);

            if($RH->getResult()):
                require_once("../../_rh_includes/body-horarios-settings.inc.php");
            else:
                WSError($RH->getError()[0], $RH->getError()[1]);
            endif;

            break;
        case 'Horarios':
            $Data['horario'] = strip_tags(trim($_POST['horario']));
            $Data['entrada'] = strip_tags(trim($_POST['entrada']));
            $Data['almoco']  = strip_tags(trim($_POST['almoco']));
            $Data['saida']   = strip_tags(trim($_POST['saida']));
            $Data['dias']    = strip_tags(trim($_POST['dias']));

            $RH = new RH();
            $RH->Horarios($id_db_settings, $Data);

            if($RH->getResult()):
                require_once("../../_rh_includes/body-horarios-settings.inc.php");
            else:
                WSError($RH->getError()[0], $RH->getError()[1]);
            endif;

            break;
        case 'DeleteDescontos':
            $id          = strip_tags(trim($_POST['id']));

            $RH = new RH();
            $RH->DeleteDescontos($id, $id_db_settings);

            if($RH->getResult()):
                require_once("../../_rh_includes/body-descontos-settings.inc.php");
            else:
                WSError($RH->getError()[0], $RH->getError()[1]);
            endif;

            break;
        case 'Descontos':
            $desconto  = strip_tags(trim($_POST['desconto']));
            $descricao = strip_tags(trim($_POST['descricao']));

            $Data['desconto']  = $desconto;
            $Data['descricao'] = $descricao;

            $RH = new RH();
            $RH->Descontos($id_db_settings, $Data);

            if($RH->getResult()):
                require_once("../../_rh_includes/body-descontos-settings.inc.php");
            else:
                WSError($RH->getError()[0], $RH->getError()[1]);
            endif;

            break;
        case 'DeleteSubsidios':
            $id          = strip_tags(trim($_POST['id']));

            $RH = new RH();
            $RH->DeleteSubsidios($id, $id_db_settings);

            if($RH->getResult()):
                require_once("../../_rh_includes/body-subsidios-settings.inc.php");
            else:
                WSError($RH->getError()[0], $RH->getError()[1]);
            endif;

            break;
        case 'Subsidios':
            $subsidio  = strip_tags(trim($_POST['subsidio']));
            $descricao = strip_tags(trim($_POST['descricao']));

            $Data['subsidio']  = $subsidio;
            $Data['descricao'] = $descricao;

            $RH = new RH();
            $RH->Subsidios($id_db_settings, $Data);

            if($RH->getResult()):
                require_once("../../_rh_includes/body-subsidios-settings.inc.php");
            else:
                WSError($RH->getError()[0], $RH->getError()[1]);
            endif;

            break;
        case 'Vinculo':
            $Data['capital']   = strip_tags(trim($_POST['capital']));
            $Data['valor']     = strip_tags(trim($_POST['valor']));
            $Data['admissao']  = strip_tags(trim($_POST['admissao']));
            $Data['tipo']      = strip_tags(trim($_POST['tipo']));
            $Data['status']    = strip_tags(trim($_POST['status']));
            $id                = (int) $_POST['id'];

            $RH = new RH();
            $RH->Vinculo($id_db_settings, $Data, $id);

            WSError($RH->getError()[0], $RH->getError()[1]);

            break;
        case 'DeleteSocios':
            $id          = strip_tags(trim($_POST['id']));

            $RH = new RH();
            $RH->DeleteSocios($id, $id_db_settings);

            if($RH->getResult()):
                require_once("../../_rh_includes/body-socios-settings.inc.php");
            else:
                WSError($RH->getError()[0], $RH->getError()[1]);
            endif;

            break;
        case 'Socios':
            $Data['nome']               = strip_tags(trim($_POST['nome']));
            $Data['nif']                = strip_tags(trim($_POST['nif']));
            $Data['sexo']               = strip_tags(trim($_POST['sexo']));
            $Data['data_nascimento']    = strip_tags(trim($_POST['data_nascimento']));
            $Data['nacionalidade']      = strip_tags(trim($_POST['nacionalidade']));
            $Data['estado_civil']       = strip_tags(trim($_POST['estado_civil']));
            $Data['regime_matrimonial'] = strip_tags(trim($_POST['regime_matrimonial']));
            $Data['raca_cor']           = strip_tags(trim($_POST['raca_cor']));
            $Data['dificiencia']        = strip_tags(trim($_POST['dificiencia']));
            $Data['grau_instrucao']     = strip_tags(trim($_POST['grau_instrucao']));
            $Data['nome_pai']           = strip_tags(trim($_POST['nome_pai']));
            $Data['nome_mae']           = strip_tags(trim($_POST['nome_mae']));
            $Data['nome_conjuge']       = strip_tags(trim($_POST['nome_conjuge']));
            $Data['pais_nacionalidade'] = strip_tags(trim($_POST['pais_nacionalidade']));
            $Data['herdeiro_legal']     = strip_tags(trim($_POST['herdeiro_legal']));
            $Data['telefone']           = strip_tags(trim($_POST['telefone']));
            $Data['email']              = strip_tags(trim($_POST['email']));
            $Data['endereco']           = strip_tags(trim($_POST['endereco']));
            $Data['profissao']          = strip_tags(trim($_POST['profissao']));
            $Data['descricao']          = strip_tags(trim($_POST['descricao']));

            $RH = new RH();
            $RH->Socios($id_db_settings, $Data);

            WSError($RH->getError()[0], $RH->getError()[1]);

            break;
        case 'Grau':
            $grau        = strip_tags(trim($_POST['grau']));
            $observacoes = strip_tags(trim($_POST['observacoes']));

            $Data['grau']        = $grau;
            $Data['observacoes'] = $observacoes;

            $RH = new RH();
            $RH->Grau($id_db_settings, $Data);

            if($RH->getResult()):
                require_once("../../_rh_includes/body-grau-settings.inc.php");
            else:
                WSError($RH->getError()[0], $RH->getError()[1]);
            endif;

            break;
        case 'DeleteGrau':
            $id          = strip_tags(trim($_POST['id']));

            $RH = new RH();
            $RH->DeleteGrau($id, $id_db_settings);

            if($RH->getResult()):
                require_once("../../_rh_includes/body-grau-settings.inc.php");
            else:
                WSError($RH->getError()[0], $RH->getError()[1]);
            endif;

            break;
        case 'DeleteDificiencia':
            $id          = strip_tags(trim($_POST['id']));

            $RH = new RH();
            $RH->DeleteDificiencia($id, $id_db_settings);

            if($RH->getResult()):
                require_once("../../_rh_includes/body-dificiencia-settings.inc.php");
            else:
                WSError($RH->getError()[0], $RH->getError()[1]);
            endif;

            break;
        case 'Dificiencia':
            $dificiencia = strip_tags(trim($_POST['dificiencia']));
            $observacoes = strip_tags(trim($_POST['observacoes']));

            $Data['dificiencia'] = $dificiencia;
            $Data['observacoes'] = $observacoes;

            $RH = new RH();
            $RH->Dificiencia($id_db_settings, $Data);

            if($RH->getResult()):
                require_once("../../_rh_includes/body-dificiencia-settings.inc.php");
            else:
                WSError($RH->getError()[0], $RH->getError()[1]);
            endif;

            break;
        case 'DeleteNacionalidade':
            $id          = strip_tags(trim($_POST['id']));

            $RH = new RH();
            $RH->DeleteNacionalidade($id, $id_db_settings);

            if($RH->getResult()):
                require_once("../../_rh_includes/body-nacionalidades-settings.inc.php");
            else:
                WSError($RH->getError()[0], $RH->getError()[1]);
            endif;

            break;
        case 'Nacionalidades':
            $nacionalidade = strip_tags(trim($_POST['nacionalidade']));
            $pais          = strip_tags(trim($_POST['pais']));

            $Data['nacionalidade'] = $nacionalidade;
            $Data['pais']          = $pais;

            $RH = new RH();
            $RH->Nacionalidades($id_db_settings, $Data);

            if($RH->getResult()):
                require_once("../../_rh_includes/body-nacionalidades-settings.inc.php");
            else:
                WSError($RH->getError()[0], $RH->getError()[1]);
            endif;

            break;
        default:
            WSError("Ops: não encontramos a ação desejada!", WS_INFOR);
    endswitch;
endif;
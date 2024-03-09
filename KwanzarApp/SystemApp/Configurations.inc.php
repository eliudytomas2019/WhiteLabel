<?php
/**
 * Created by PhpStorm.
 * User: Kwanzar Soft
 * Date: 09/05/2020
 * Time: 11:54
 */

$acao = strip_tags((filter_input(INPUT_POST, 'acao', FILTER_DEFAULT)));

if($acao):
    require_once("../../Config.inc.php");
    if(isset($_POST['id_db_kwanzar'])): $id_db_kwanzar = (int) $_POST['id_db_kwanzar']; endif;

    switch ($acao):
        case 'MarcaSelect':
            $id_marca = strip_tags(trim($_POST['id_marca']));
            $id_db_settings = strip_tags(trim($_POST['id_db_settings']));

            $read = new Read();
            $read->ExeRead("cv_marcas", "WHERE id=:i AND id_db_settings=:id ", "i={$id_marca}&id={$id_db_settings}");

            if($read->getResult()):
                echo " ".$read->getResult()[0]['marca'];
            endif;

            break;
        case 'CategorySelectII':
            $id_category = strip_tags(trim($_POST['id_category']));
            $id_db_settings = strip_tags(trim($_POST['id_db_settings']));

            $read = new Read();
            $read->ExeRead("cv_category", "WHERE id_xxx=:i AND id_db_settings=:id ", "i={$id_category}&id={$id_db_settings}");

            if($read->getResult()):
                echo $read->getResult()[0]['porcentagem_ganho'];
            endif;

            break;
        case 'CategorySelect':
            $id_category = strip_tags(trim($_POST['id_category']));
            $id_db_settings = strip_tags(trim($_POST['id_db_settings']));

            $read = new Read();
            $read->ExeRead("cv_category", "WHERE id_xxx=:i AND id_db_settings=:id ", "i={$id_category}&id={$id_db_settings}");

            if($read->getResult()):
                echo $read->getResult()[0]['category_title']." ";
            endif;

            break;
        case 'ReadExluded':
            $posti = 0;
            $getPage = filter_input(INPUT_GET, 'page',FILTER_VALIDATE_INT);
            $Pager = new Pager("Admin.php?exe=statistic/company&page=");
            $Pager->ExePager($getPage, 20);

            $read = new Read();
            $read->ExeRead("db_settings", "ORDER BY id DESC LIMIT :limit OFFSET :offset", "limit={$Pager->getLimit()}&offset={$Pager->getOffset()}");

            include_once("../../_disk/_help/DeuOnda.inc.php");

            break;
        case 'Excluded':
            $id_db_settingsX = strip_tags(trim($_POST['id']));

            $Delete = new Delete();
            $Delete->ExeDelete("db_settings", "WHERE id=:i LIMIT 1 ", "i={$id_db_settingsX}");

            if($Delete->getResult() || $Delete->getRowCount()):
                WSError("A empresa selecionada foi exluida do registro!", WS_ACCEPT);
            endif;

            break;
        case 'SettingsTransfer':
            $IDEmpresa = strip_tags(trim(filter_input(INPUT_POST, "IDEmpresa", FILTER_VALIDATE_INT)));
            $IDcPanel  = strip_tags(trim(filter_input(INPUT_POST, "IDcPanel", FILTER_VALIDATE_INT)));

            $Create = new DBKwanzar();
            $Create->SettingsTransfer($IDEmpresa, $IDcPanel);

            if($Create->getResult()):
                WSError($Create->getError()[0], $Create->getError()[1]);
                echo "<script>reload();</script>";
            else:
                WSError($Create->getError()[0], $Create->getError()[1]);
            endif;

            break;
        case 'Suspanse':
            $id = (int) strip_tags(($_POST['id']));

            $Create = new DBKwanzar();
            $Create->Suspanse($id);

            if($Create->getResult()):
                WSError($Create->getError()[0], $Create->getError()[1]);
                echo "<script>level();</script>";
            else:
                WSError($Create->getError()[0], $Create->getError()[1]);
            endif;

            break;
        case 'SuspanseL':
            $id = (int) strip_tags(($_POST['id']));

            $Create = new DBKwanzar();
            $Create->Suspanse($id);

            if($Create->getResult()):
                WSError($Create->getError()[0], $Create->getError()[1]);
                echo "<script>Ls();</script>";
            else:
                WSError($Create->getError()[0], $Create->getError()[1]);
            endif;

            break;
        case '08':
            $read = new Read();
            $read->FullRead("SELECT email, empresa FROM db_settings WHERE email!=''");

            if($read->getResult()):
                foreach($read->getResult() as $key):
                    extract($key);

                    $read->FullRead("SELECT email_settings FROM ws_alerts");
                    $emails = $read->getResult()[0]['email_settings'];

                    $Contato['RemetenteEmail'] =  'suporte@kwanzar.net';
                    $Contato['RemetenteNome'] = 'KWANZAR SOFTWARE DE GESTÃO COMERCIAL';
                    $Contato['Mensagem'] = $emails;
                    $Contato['Assunto'] = "NOVIDADES - KWANZAR";
                    $Contato['DestinoNome'] =  $key['empresa'];
                    $Contato['DestinoEmail'] = $key['email'];

                    $SendMail = new Email();
                    $SendMail->Enviar($Contato);

                    if($SendMail->getResult()):
                        WSError($SendMail->getError()[0], $SendMail->getError()[1]);
                    endif;
                endforeach;
            endif;

            break;
        case '07':
            $read = new Read();
            $read->FullRead("SELECT username, name FROM db_users WHERE username!=''");

            if($read->getResult()):
                foreach($read->getResult() as $key):
                    extract($key);

                    $read->FullRead("SELECT email_users FROM ws_alerts");
                    $emails = $read->getResult()[0]['email_users'];

                    $Contato['RemetenteEmail'] =  'suporte@kwanzar.net';
                    $Contato['RemetenteNome'] = 'KWANZAR SOFTWARE DE GESTÃO COMERCIAL';
                    $Contato['Mensagem'] = $emails;
                    $Contato['Assunto'] = "NOVIDADES - KWANZAR";
                    $Contato['DestinoNome'] =  $key['name'];
                    $Contato['DestinoEmail'] = $key['username'];

                    $SendMail = new Email();
                    $SendMail->Enviar($Contato);

                    if($SendMail->getResult()):
                        WSError($SendMail->getError()[0], $SendMail->getError()[1]);
                    endif;
                endforeach;
            endif;

            break;
        case '06':
            $read = new Read();
            $read->FullRead("SELECT email, nome FROM cv_supplier WHERE email!=''");

            if($read->getResult()):
                foreach($read->getResult() as $key):
                    extract($key);

                    $read->FullRead("SELECT email_suppliers FROM ws_alerts");
                    $emails = $read->getResult()[0]['email_suppliers'];

                    $Contato['RemetenteEmail'] =  'suporte@kwanzar.net';
                    $Contato['RemetenteNome'] = 'KWANZAR SOFTWARE DE GESTÃO COMERCIAL';
                    $Contato['Mensagem'] = $emails;
                    $Contato['Assunto'] = "NOVIDADES - KWANZAR";
                    $Contato['DestinoNome'] =  $key['nome'];
                    $Contato['DestinoEmail'] = $key['email'];

                    $SendMail = new Email();
                    $SendMail->Enviar($Contato);

                    if($SendMail->getResult()):
                        WSError($SendMail->getError()[0], $SendMail->getError()[1]);
                    endif;
                endforeach;
            endif;

            break;
        case '05':
            $read = new Read();
            $read->FullRead("SELECT email, nome FROM cv_customer WHERE email!=''");

            if($read->getResult()):
                foreach($read->getResult() as $key):
                    extract($key);

                    $read->FullRead("SELECT email_customers FROM ws_alerts");
                    $emails = $read->getResult()[0]['email_customers'];

                    $Contato['RemetenteEmail'] =  'suporte@kwanzar.net';
                    $Contato['RemetenteNome'] = 'KWANZAR SOFTWARE DE GESTÃO COMERCIAL';
                    $Contato['Mensagem'] = $emails;
                    $Contato['Assunto'] = "NOVIDADES - KWANZAR";
                    $Contato['DestinoNome'] =  $key['nome'];
                    $Contato['DestinoEmail'] = $key['email'];

                    $SendMail = new Email();
                    $SendMail->Enviar($Contato);

                    if($SendMail->getResult()):
                        WSError($SendMail->getError()[0], $SendMail->getError()[1]);
                    endif;
                endforeach;
            endif;

            break;
        case 'RecuvaPassword':
            $username = strip_tags(($_POST['username']));
            $PRecuvaPassword = strip_tags(($_POST['PRecuvaPassword']));
            $pw0 = strip_tags(($_POST['pw0']));
            $password = strip_tags(($_POST['password']));
            $replace_password = strip_tags(($_POST['replace_password']));

            $Read = new Read();
            $Read->ExeRead("db_users", "WHERE username=:i", "i={$username}");

            if($Read->getResult()):
                $key = $Read->getResult()[0];
                $Read->ExeRead("db_users_settings", "WHERE session_id=:i", "i={$key['id']}");

                if($Read->getResult()):
                    $FF = $Read->getResult()[0];

                    if($FF['PRecuvaPassword'] == $PRecuvaPassword):
                        if($FF['RecuvaPassword'] == $pw0):

                            $Data['password'] = $password;
                            $Data['replace_password'] = $replace_password;

                            $Users = new DBKwanzar();
                            $Users->RecoverPassword($Data, $key['id']);

                            if($Users->getResult()):
                                WSError($Users->getError()[0], $Users->getResult()[1]);
                            else:
                                WSError($Users->getError()[0], $Users->getResult()[1]);
                            endif;
                        else:
                            WSError("Ops: resposta de recuperação inválida!", WS_ERROR);
                        endif;
                    else:
                        WSError("Ops: pergunta de recuperação de senha inválida!", WS_ALERT);
                    endif;
                endif;
            else:
                WSError("Ops: não encontramos nenhum usuário!", WS_INFOR);
            endif;

            break;
        case 'FormPassword':
            $Data['password_atual'] = strip_tags(($_POST['password_atual']));
            $Data['password'] = strip_tags(($_POST['password']));
            $Data['replace_password'] = strip_tags(($_POST['replace_password']));
            $Session = (int) $_POST['Session_id'];


            $Users = new DBKwanzar();
            $Users->ExePassword($Data, $Session);

            if($Users->getResult()):
                WSError($Users->getError()[0], $Users->getError()[1]);
                echo "<script>leva();</script>";
            else:
                WSError($Users->getError()[0], $Users->getError()[1]);
            endif;

            break;
        case 'FormLockScreen':
            $Password = strip_tags(($_POST['pass']));

            if(!empty($Password)):
                $id = (int) $_POST['Session_id'];
                $Login = new Login(1);
                $Login->LockScreen($id, $Password);

                if($Login->getResult()):
                    WSError($Login->getError()[0], $Login->getError()[1]);
                    echo "<script>leva();</script>";
                else:
                    WSError($Login->getError()[0], $Login->getError()[1]);
                endif;
            else:
                WSError("Ops: preencha todos os campos para prosseguir com o processo!", WS_INFOR);
            endif;

            break;
        case 'nif':
            $Data['nif'] = strip_tags(($_POST['nif']));

            $Read = new Read();
            $Read->ExeRead("db_settings", "WHERE id_db_kwanzar !={$id_db_kwanzar} AND nif=:emp", "emp={$Data['nif']}");

            if($Read->getResult()):
                WSError("Ops: o NIF: <strong>{$Data['nif']}</strong>, já encontra-se em uso!", WS_INFOR);
            endif;

            break;
        case 'empresa':
            $Data['empresa'] = strip_tags(($_POST['empresa']));

            $Read = new Read();
            $Read->ExeRead("db_settings", "WHERE id_db_kwanzar !={$id_db_kwanzar} AND empresa=:emp", "emp={$Data['empresa']}");

            if($Read->getResult()):
                WSError("Ops: a empresa <strong>{$Data['empresa']}</strong>, já encontra-se em uso!", WS_INFOR);
            endif;

            break;
        case 'Settings':
            $id_db_kwanzar = filter_input(INPUT_POST, 'id_db_kwanzar', FILTER_VALIDATE_INT);
             $Data['empresa'] = strip_tags(($_POST['empresa']));
             $Data['nif'] = strip_tags(($_POST['nif']));
            if(!empty($_POST['telefone'])):$Data['telefone'] = strip_tags(($_POST['telefone'])); endif;
            if(!empty($_POST['website'])):$Data['website'] = strip_tags(($_POST['website'])); endif;
            if(!empty($_POST['email'])):$Data['email'] = strip_tags(($_POST['email'])); endif;
            $Data['endereco'] = strip_tags(($_POST['endereco']));
            if(!empty($_POST['addressDetail'])):$Data['addressDetail'] = strip_tags(($_POST['addressDetail'])); endif;
            $Data['city'] = strip_tags(($_POST['city']));
            if(!empty($_POST['BuildingNumber'])):$Data['BuildingNumber'] = strip_tags(($_POST['BuildingNumber'])); endif;
            $Data['country'] = strip_tags(($_POST['country']));
            $Data['taxEntity'] = strip_tags(($_POST['taxEntity']));
            $Data['typeVenda'] = strip_tags(($_POST['typeVenda']));
            $Data['atividade'] = strip_tags(($_POST['atividade']));

            $Create = new DBKwanzar();
            $Create->CreateSettings($Data, $id_db_kwanzar);

            if($Create->getResult()):
                WSError($Create->getError()[0], $Create->getError()[1]);
                echo "<script>leva();</script>";
            else:
                WSError($Create->getError()[0], $Create->getError()[1]);
            endif;

            break;
        case 'Login':
            $user   = strip_tags(($_POST['user']));
            $pass   = strip_tags(($_POST['pass']));

            $Data = ['user' => $user, 'pass' => $pass];

            $Login = new Login(1);
            $Login->ExeLogin($Data);

            if($Login->getResult()):
                WSError($Login->getError()[0], $Login->getError()[1]);
                echo "<script>leva();</script>";
            else:
                WSError($Login->getError()[0], $Login->getError()[1]);
            endif;

            break;
        case 'replace_password':
            if(isset($_POST['password'])): $Data['password'] = strip_tags(($_POST['password'])); endif;
            if(isset($_POST['replace_password'])): $Data['replace_password'] = strip_tags(($_POST['replace_password'])); endif;

            /*$Create = new DBKwanzar();
            $Create->Checking($Data);

            if(!$Create->getResult()):
                WSError($Create->getError()[0], $Create->getError()[1]);
            endif;*/

            if($Data['password'] != $Data['replace_password']):
                WSError("Ops: o campo de verificação de senha tem que ser igual ao campo senha!", WS_ALERT);
            endif;

            break;
        case 'password':
            $Data['password'] = strip_tags(($_POST['password']));

            $Create = new DBKwanzar();
            $Create->Checking($Data);

            if(!$Create->getResult()):
                WSError($Create->getError()[0], $Create->getError()[1]);
            endif;

            break;
        case 'username':
            $Data['username'] = strip_tags(($_POST['username']));

            $Create = new DBKwanzar();
            $Create->Checking($Data);

            if(!$Create->getResult()):
                WSError($Create->getError()[0], $Create->getError()[1]);
            endif;

            $Create->CheckUsers($Data['username']);
            if(!$Create->getResult()):
                WSError($Create->getError()[0], $Create->getError()[1]);
            endif;

            break;
        case 'CreateAccounting':
            $Data['name'] = strip_tags(($_POST['name']));
            $Data['username'] = strip_tags(($_POST['username']));
            $Data['password'] = strip_tags(($_POST['password']));
            $Data['replace_password'] = strip_tags(($_POST['replace_password']));

            $Create = new DBKwanzar();

            $Create->CreateAccounting($Data);
            WSError($Create->getError()[0], $Create->getError()[1]);

            break;
        case 'RemetenteEmail':
            $RemetenteEmail = strip_tags((filter_input(INPUT_POST, 'RemetenteEmail', FILTER_DEFAULT)));

            if(!Check::Email($RemetenteEmail)):
                WSError("Ops: introduza um endereço de E-mail válido!", WS_INFOR);
            endif;

            break;
        case 'SendEmail':
            $Contato['RemetenteEmail'] = strip_tags(($_POST['RemetenteEmail']));
            $Contato['RemetenteNome'] = strip_tags(($_POST['RemetenteName']));
            $Contato['Mensagem'] = strip_tags(($_POST['RemetenteMensagem']));
            $Contato['Assunto'] = strip_tags(($_POST['RemetenteAssunto']));
            $Contato['DestinoNome'] = 'Suporte técnico - KWANZAR SOFTWARE DE GESTÃO COMERCIAL';
            $Contato['DestinoEmail'] = 'suporte@kwanzar.net';

            $SendMail = new Email();
            $SendMail->Enviar($Contato);

            if($SendMail->getResult()):
                WSError($SendMail->getError()[0], $SendMail->getError()[1]);
            endif;

            //WSError("Operação realizada com sucesso!", WS_INFOR);
            break;
        default:
            WSError("Ops: não encontramos a ação desejada!", WS_INFOR);
    endswitch;
endif;
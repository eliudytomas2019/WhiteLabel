<?php
/**
 * Created by PhpStorm.
 * User: Kwanzar Soft
 * Date: 06/06/2020
 * Time: 15:44
 */


if(strip_tags(trim($_POST['acao']))):
    $acao = $_POST['acao'];
    require_once("../../Config.inc.php");
    $read = new Read();

    if(isset($_POST['id'])):             $id             = (int) strip_tags(trim($_POST['id'])); endif;
    if(isset($_POST['value'])):          $value          = strip_tags(trim($_POST['value'])); endif;
    if(isset($_POST['level'])):          $level          = (int) strip_tags(trim($_POST['level'])); endif;
    if(isset($_POST['id_user'])):        $id_user        = (int) strip_tags(trim($_POST['id_user'])); endif;
    if(isset($_POST['id_db_settings'])): $id_db_settings = (int) strip_tags(trim($_POST['id_db_settings'])); endif;

    switch ($acao):
        case '09':
            $t     = strip_tags(trim($_POST['tp']));
            $value = strip_tags(trim($_POST['value']));

            $FACE = new FACE();
            $FACE->Operation($t, $value);

            WSError($FACE->getError()[0], $FACE->getError()[1]);

            break;
        case '08':
            $EliminarFacturaID = strip_tags(trim(filter_input(INPUT_POST, "EliminarFacturaID", FILTER_VALIDATE_INT)));

            $POS = new POS();
            $POS->EliminarFactura($EliminarFacturaID);

            WSError($POS->getError()[0], $POS->getError()[1]);

            break;
        case '07':
            $Db = new DBKwanzar();
            $Db->SuspenderConta($id);

            WSError($Db->getError()[0], $Db->getError()[1]);

            break;
        case '06':
            $DB = new DBKwanzar();
            $DB->ExeRestored($id);

            WSError($DB->getError()[0], $DB->getError()[1]);

            break;
        case '05':
            $read->ExeRead("db_users", "WHERE (id=:link) OR (username LIKE '%' :link '%') OR (name LIKE '%' :link '%') ORDER BY id DESC", "link={$value}");

            $lv = ["", "Usuário", "Gestor", "Administrador", "Root", "Desenvolvidor"];
            if($read->getResult()):
                foreach($read->getResult() as $key):
                    extract($key);
                    ?>
                    <tr>
                        <td><?= $key['id']; ?></td>
                        <td><?= $key['name']; ?></td>
                        <td><?= $key['username']; ?></td>
                        <td><?= $key['telefone']; ?></td>
                        <td><?= $key['registration']; ?></td>
                        <td><?= $lv[$key['level']]; ?></td>
                        <td>
                            <?php
                                if($key['id_db_settings'] != null || !empty($key['id_db_settings'])):
                                    $Read = new Read();
                                    $Read->ExeRead("db_settings", "WHERE id=:i", "i={$key['id_db_settings']}");
                                    if($Read->getResult()):
                                        echo $Read->getResult()[0]['empresa'];
                                    endif;
                                else:
                                    $Read = new Read();
                                    $Read->ExeRead("db_settings", "WHERE id_db_kwanzar=:i ORDER BY id ASC", "i={$key['id_db_kwanzar']}");
                                    if($Read->getResult()):
                                        echo $Read->getResult()[0]['empresa'];
                                    endif;
                                endif;
                            ?>
                        </td>
                        <td>
                            <a href="javascript:void" onclick="AdminSusPassword(<?= $key['id']; ?>)" class="btn btn-sm btn-primary">Repor password</a>&nbsp;
                            <a href="javascript:void" onclick="AdminSusUsers(<?= $key['id']; ?>)" class="btn btn-sm btn-warning">Suspender</a>&nbsp;
                            <!---a href="javascript:void" onclick="" class="btn btn-sm btn-danger">Eliminar</a--->&nbsp;
                        </td>
                    </tr>
                    <?php
                endforeach;
            endif;

            break;
        case '04':
            if(isset($_POST['email_settings'])):  $Data['email_settings']  = strip_tags(trim($_POST['email_settings']));  endif;
            if(isset($_POST['email_suppliers'])): $Data['email_suppliers'] = strip_tags(trim($_POST['email_suppliers'])); endif;
            if(isset($_POST['email_customers'])): $Data['email_customers'] = strip_tags(trim($_POST['email_customers'])); endif;
            if(isset($_POST['email_users'])):     $Data['email_users']     = strip_tags(trim($_POST['email_users']));     endif;

            $WSEmail = new WSEmail();
            $WSEmail->Alerts($Data);

            WSError($WSEmail->getError()[0], $WSEmail->getError()[1]);

            break;
        case '03':
            $Delete = new Delete();
            $Delete->ExeDelete("sd_billing_pmp", "WHERE id_db_settings=:i", "i={$id_db_settings}");
            $Delete->ExeDelete("sd_retification_pmp", "WHERE id_db_settings=:i", "i={$id_db_settings}");
            $Delete->ExeDelete("sd_retification", "WHERE id_db_settings=:i", "i={$id_db_settings}");
            $Delete->ExeDelete("sd_billing_tmp", "WHERE id_db_settings=:i", "i={$id_db_settings}");
            $Delete->ExeDelete("sd_billing", "WHERE id_db_settings=:i", "i={$id_db_settings}");

            if($Delete->getResult() || $Delete->getRowCount()):
                WSError("As vendas da presente empresa foram repostos!", WS_INFOR);
            else:
                WSError("Ops: aconteceu um erro inesperado ao repor os dados da empresa!", WS_ERROR);
            endif;

            break;
        case '02':
            $Data['times'] = strip_tags(trim($_POST['times']));
            //$Data['postos'] = strip_tags(trim($_POST['postos']));
            //$Data['users'] = strip_tags(trim($_POST['users']));
            $Data['ps3'] = strip_tags(trim($_POST['ps3']));
            $id_db_kwanzar = (int) strip_tags(trim($_POST['id_db_kwanzar']));

            $HeliosPro = new HeliosPro();
            $HeliosPro->ExeLicence($Data, $id_db_kwanzar, $id_user);

            WSError($HeliosPro->getError()[0], $HeliosPro->getError()[1]);

            break;
        case '01':
            $read->ExeRead("db_settings", "WHERE (id=:i) OR (empresa LIKE '%' :i '%') OR (nif LIKE '%' :i '%') ", "i={$value}");

            if($read->getResult()):
                foreach($read->getResult() as $key):
                    extract($key);
                    ?>
                    <tr>
                        <td><?= $key['id'] ?></td>
                        <td><?= $key['empresa'] ?></td>
                        <td><?= $key['nif'] ?></td>
                        <td><?= $key['telefone'] ?></td>
                        <td><?= $key['email'] ?></td>
                        <td>
                            <a href="Admin.php?exe=admin/licence&id_db_=<?= $key['id_db_kwanzar'] ?>" class=" btn btn-primary btn-sm">Licença</a>
                            <a href="javascript:void" class=" btn btn-danger btn-sm" onclick="Linc(<?= $key['id']; ?>)">Repor dados</a>
                            <a href="Admin.php?exe=admin/users&postId=<?= $key['id'] ?>&id_db_=<?= $key['id_db_kwanzar'] ?>" class=" btn btn-primary btn-sm">Criar usuário</a>
                        </td>
                    </tr>
                    <?php
                endforeach;
            endif;

            break;
        default:
            WSError("Ops: não encontramos nenhuma ação!", WS_INFOR);
    endswitch;
endif;
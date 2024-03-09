<?php
require_once("Config.inc.php");
$read   = new Read();
$create = new Create();
$update = new Update();
$delete = new Delete();

$sessao = new Session();
if(!isset($_SESSION['userlogin'])):
    unset($_SESSION['userlogin']);
    header('Location: _login.php?exe=restrito');
endif;

$level = $_SESSION['userlogin']['level'];
Check::UserOnline();

if($level == 5):
    $login = new Login(5);
    if (!$login->CheckLogin()):
        unset($_SESSION['userlogin']);
        header('Location: _login.php?exe=restrito');
    else:
        $userlogin = $_SESSION['userlogin'];
        $id_db_kwanzar = $userlogin['id_db_kwanzar'];
        $id_user = $userlogin['id'];
    endif;

    if($userlogin['id_db_settings'] == null || $userlogin['id_db_settings'] == '' || $userlogin['id_db_settings'] == 0):
        $id_db_settings = filter_input(INPUT_GET, 'id_db_settings', FILTER_VALIDATE_INT);
        $read->ExeRead("db_settings", "WHERE id=:i ", "i={$id_db_settings}");
        if($read->getResult()):
            $GongaSebastiao = $read->getResult()[0];
            if($GongaSebastiao['id_db_kwanzar'] != $id_db_kwanzar):
                unset($_SESSION['userlogin']);
                header('Location: _login.php?exe=logoff');
            else:
                if($level < 4 && $id_db_settings != $userlogin['id_db_settings']):
                    unset($_SESSION['userlogin']);
                    header('Location: _login.php?exe=logoff');
                endif;
            endif;
        else:
            unset($_SESSION['userlogin']);
            header('Location: _login.php?exe=logoff');
        endif;
    else:
        $id_db_settings = $userlogin['id_db_settings'];
    endif;
elseif($level <= 4):

    if($level == 4):
        $login = new Login(4);
    elseif($level == 3):
        $login = new Login(3);
    elseif($level == 2):
        $login = new Login(2);
    else:
        $login = new Login(1);
    endif;

    if (!$login->CheckLogin()):
        unset($_SESSION['userlogin']);
        header('Location: _login.php?exe=restrito');
    else:
        $userlogin = $_SESSION['userlogin'];
        $id_db_kwanzar = $userlogin['id_db_kwanzar'];
        $id_user = $userlogin['id'];
    endif;

    if($userlogin['id_db_settings'] == null || $userlogin['id_db_settings'] == ''):
        $id_db_settings = filter_input(INPUT_GET, 'id_db_settings', FILTER_VALIDATE_INT);
        $read->ExeRead("db_settings", "WHERE id=:i ", "i={$id_db_settings}");
        if($read->getResult()):
            $GongaSebastiao = $read->getResult()[0];
            if($GongaSebastiao['id_db_kwanzar'] != $id_db_kwanzar):
                unset($_SESSION['userlogin']);
                header('Location: _login.php?exe=logoff');
            else:
                if($level < 4 && $id_db_settings != $userlogin['id_db_settings']):
                    unset($_SESSION['userlogin']);
                    header('Location: _login.php?exe=logoff');
                endif;
            endif;
        else:
            unset($_SESSION['userlogin']);
            header('Location: _login.php?exe=logoff');
        endif;
    else:
        $id_db_settings = $userlogin['id_db_settings'];
    endif;

    $Config = new WSKwanzar();
    if(!$Config->CheckTimes($userlogin['id_db_kwanzar'])):
        unset($_SESSION['userlogin']);
        header('Location: _login.php?exe=restrito');
    endif;
endif;

$logoff = filter_input(INPUT_GET, 'logoff', FILTER_VALIDATE_BOOLEAN);
$getexe = filter_input(INPUT_GET, 'exe', FILTER_DEFAULT);
$lock = filter_input(INPUT_GET, 'lock', FILTER_DEFAULT);

if($logoff):
    unset($_SESSION['userlogin']);
    header('Location: _login.php?exe=logoff');
endif;

if($level >= 4): $n =  '&id_db_settings='.$id_db_settings; else: $n = null; endif;

if($lock):
    $Users = new DBKwanzar();
    $Users->LockScreen($userlogin['id'], $id_db_kwanzar);
    if($Users->getResult()):
        header("location: _lock-screen.php");
    endif;
endif;

$DB = new DBKwanzar();
if(!$DB->CheckCpanelAndSettings($id_db_settings, $id_db_kwanzar)):
    unset($_SESSION['userlogin']);
    header('Location: _login.php?exe=logoff');
endif;

$read->ExeRead("db_users", "WHERE id=:i ", "i={$userlogin['id']}");
if($read->getResult()):
    if($read->getResult()[0]['block'] == 0):
        header("location: _lock-screen.php");
    endif;

    if($read->getResult()[0]['st'] == null || $read->getResult()[0]['st'] == 0):
        header("location: password-users.php");
    endif;
endif;

$read->ExeRead("db_settings", "WHERE id=:i ", "i={$id_db_settings}");
if($read->getResult()):
    $Pro2Da = $read->getResult()[0];

    if($Pro2Da['status'] == "0"):
        unset($_SESSION['userlogin']);
        header('Location: _login.php?exe=accounting');
    endif;
endif;

$Beautiful = null;
$st = 1;
$read = new Read();
$read->ExeRead("ws_times", "WHERE id_db_kwanzar=:i AND status=:st", "i={$userlogin['id_db_kwanzar']}&st={$st}");
if($read->getResult()):
    $Beautiful = $read->getResult()[0];
else:
    unset($_SESSION['userlogin']);
    header('Location: _login.php?exe=restrito');
endif;


$read = new Read();
$read->ExeRead("db_users", "WHERE id=:ip ", "ip={$_SESSION['userlogin']['id']}");
if($read->getResult()):
    if(date('Y-m-d H:i:s') > $read->getResult()[0]['session_end']):
        unset($_SESSION['userlogin']);
        header('Location: _login.php?exe=session_end');
    endif;
endif;
?>
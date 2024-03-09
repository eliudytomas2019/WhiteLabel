<?php
$sessao = new Session();
$level = $_SESSION['userlogin']['level'];

if(!isset($_SESSION["userlogin"])):
    unset($_SESSION['userlogin']);
    header('Location: _login.php?exe=session_off');
else:
    if($level == 5):
        $Login = new Login(5);
        if (!$Login->CheckLogin()):
            unset($_SESSION['userlogin']);
            header('Location: _login.php?exe=restrito');
        else:
            $userlogin      = $_SESSION['userlogin'];
            $id_user        = $userlogin['id'];
            $id_db_kwanzar  = $userlogin['id_db_kwanzar'];
        endif;
    else:
        if($level < 4):
            header("location: panel.php?exe=default/home");
        elseif($level == 4):
            $Login = new Login(4);
        endif;

        if (!$Login->CheckLogin()):
            unset($_SESSION['userlogin']);
            header('Location: _login.php?exe=restrito');
        else:
            $userlogin      = $_SESSION['userlogin'];
            $id_user        = $userlogin['id'];
            $id_db_kwanzar  = $userlogin['id_db_kwanzar'];
            $id_db_settings = $userlogin['id_db_settings'];
        endif;

        $Config = new WSKwanzar();
        if($level <= 4):
            if(!$Config->CheckTimes($userlogin['id_db_kwanzar'])):
                unset($_SESSION['userlogin']);
                header('Location: _login.php?exe=accounting');
                WSError($Config->getError()[0], $Config->getError()[1]);
            endif;
        endif;
    endif;
endif;

$logoff = filter_input(INPUT_GET, 'logoff', FILTER_VALIDATE_BOOLEAN);
$getexe = filter_input(INPUT_GET, 'exe', FILTER_DEFAULT);
$lock = filter_input(INPUT_GET, 'lock', FILTER_DEFAULT);

if($lock):
    $Users = new DBKwanzar();
    $Users->LockScreen($userlogin['id'], $id_db_kwanzar);
    if($Users->getResult()):
        header("location: _lock-screen.php");
    endif;
endif;

if($logoff):
    unset($_SESSION['userlogin']);
    session_destroy();
    header('Location: _login.php?exe=logoff');
endif;

$read = new Read();
$read->ExeRead("db_users", "WHERE id=:i ", "i={$userlogin['id']}");
if($read->getResult()):
    if($read->getResult()[0]['block'] == 0):
        header("location: _lock-screen.php");
    endif;
endif;
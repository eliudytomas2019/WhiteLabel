<?php
ob_start();
require_once("Config.inc.php");

$sessao = new Session();
$level = $_SESSION['userlogin']['level'];
if(!isset($_SESSION["userlogin"])):
    unset($_SESSION['userlogin']);
    header('Location: _login.php?exe=restrito');
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
        if($level == 4):
            $Login = new Login(4);
        elseif($level == 3):
            $Login = new Login(3);
        elseif($level == 2):
            $Login = new Login(2);
        else:
            $Login = new Login(1);
        endif;

        if (!$Login->CheckLogin()):
            unset($_SESSION['userlogin']);
            header('Location: _login.php?exe=restrito');
        else:
            $userlogin      = $_SESSION['userlogin'];
            $id_user        = $userlogin['id'];
            $id_db_kwanzar  = $userlogin['id_db_kwanzar'];
        endif;

        $Config = new WSKwanzar();
        if($level <= 4):
            if(!$Config->CheckTimes($userlogin['id_db_kwanzar'])):
                unset($_SESSION['userlogin']);
                header('Location: _login.php?exe=restrito');
                WSError($Config->getError()[0], $Config->getError()[1]);
            endif;
        endif;
    endif;
endif;

$logoff = filter_input(INPUT_GET, 'logoff', FILTER_VALIDATE_BOOLEAN);
$getexe = filter_input(INPUT_GET, 'exe', FILTER_DEFAULT);

if($logoff):
    unset($_SESSION['userlogin']);
    session_destroy();
    header('Location: _login.php?exe=logoff');
endif;
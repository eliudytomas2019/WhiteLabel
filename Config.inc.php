<?php
define('MailHost', "mail.kwanzar.ao");
define('Email', "online@kwanzar.ao");
define('SenhaEmail', "##k@167435");
define('PortaEmail', "465");
define('EmailName', "A Equipe Kwanzar");


define("API", "https://galeranerd.kwanzar.ao/api.php/");

// BASE DO PROGRAMA #####
// DIREÇÕES DE BASE DO PROGRAMA #####
define('HOME', 'http://localhost/prosmart/');
define("THEME","prosmart/");
define("INCLUDE_PATH", HOME . 'themes' . THEME);
define("REQUIRE_PATH", 'theme'.DIRECTORY_SEPARATOR.THEME);

define('HOST', "localhost");
define('USER', "root");
define('PASS', "");
define('DBSA', "prosmart");


// CLASSE AUTOLOAD, A CLASSE QUE VAI SOBREVOAR AS PASTAS ##########
//A CLASSE QUE TAMBÉM FAZ A ORGANIZAÇÃO E SOBREVOA AS SUBPASTAS ########
spl_autoload_register(function ($Class){
    $cDir = ['Conn', 'Config', 'AppData', '2022', '2023', '2024'];
    $iDir = null;

    foreach($cDir as $dirName):
        if(!$iDir && file_exists(__DIR__.DIRECTORY_SEPARATOR."_app".DIRECTORY_SEPARATOR."{$dirName}".DIRECTORY_SEPARATOR."{$Class}.class.php") && !is_dir(__DIR__.DIRECTORY_SEPARATOR."{$dirName}".DIRECTORY_SEPARATOR."{$Class}.class.php")):
            include_once(__DIR__.DIRECTORY_SEPARATOR."_app".DIRECTORY_SEPARATOR."{$dirName}".DIRECTORY_SEPARATOR."{$Class}.class.php");
            $iDir = true;
        endif;
    endforeach;

    if(!$iDir):
        trigger_error("Não foi possível incluir a {$Class}.class.php", E_USER_ERROR);
    endif;
});
// TRATAMENTO DE ERROS DE MODO PERSONALIZADO NO SISTEMA #############
// DEFINIÇÕES DE ERRO ######
define('WS_ACCEPT', 'accept');
define('WS_INFOR', 'infor');
define('WS_ALERT', 'alert');
define('WS_ERROR', 'error');

// WSErroR :: EXIBE OS ERROS :: FRONT
function WSError($ErrMsg, $ErrNo, $ErrDie = null){
    $CssClass = ($ErrNo == E_USER_NOTICE ? WS_INFOR : ($ErrNo == E_USER_WARNING ? WS_ACCEPT : ($ErrNo == E_USER_ERROR ? WS_ERROR : $ErrNo)));

    echo "<p class=\"trigger {$CssClass}\">{$ErrMsg}<span class=\"ajax_close\"></span></p>";

    if($ErrDie):
        die;
    endif;
}
// PHPErro :: PERSONALIZA O GATILHO DE ERROS DO PHP
function PHPError($ErrNo, $ErrMsg, $ErrFile, $ErrLine){
    $CssClass = ($ErrNo == E_USER_NOTICE ? WS_INFOR : ($ErrNo == E_USER_WARNING ? WS_ALERT : WS_ERROR));

    echo "<p class=\"trigger{$CssClass}\">";
    echo "<b> Erro na linha: # {$ErrLine} ::</b> {$ErrMsg} <br/>";
    echo "<small>{$ErrFile}</small>";
    echo "<span class=\"ajax_close\"></span></p>";

    if($ErrNo == E_USER_ERROR):
        die;
    endif;
}
set_error_handler('PHPError');
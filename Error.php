<?php
    require_once("_app/Conn/SatanIsGod.class.php");
    require_once("database.php");
    $index = explode(";", $var);

    $HOST = strip_tags(trim($index[0]));
    $USER = strip_tags(trim($index[1]));
    $PASS = strip_tags(trim($index[2]));
    $DBSA = strip_tags(trim($index[3]));

    $Satan = new SatanIsGod();
    $Satan->EliminarErros($HOST, $USER, $DBSA, $PASS);

    if($Satan->getResult()):
        echo $Satan->getError();
        echo $Satan->getResult();
        exit();
    else:
        echo $Satan->getError();
        echo $Satan->getResult();
    endif;

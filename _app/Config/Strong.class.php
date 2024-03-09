<?php
/**
 * Created by PhpStorm.
 * User: Kwanzar Soft
 * Date: 02/04/2020
 * Time: 00:10
 */

class Strong{
    private static $Date, $Result, $Error, $Data, $Session;
    const
        times = "db_times",
        definitions = "db_users_settings",
        config = 'db_config',
        settings = 'db_settings';

    public static function getError(){
        return self::$Error;
    }

    // Serial
    public static function Serial($id_db_settings){
        $anoAtual = date('Y');
        $mesAtual = date('m');
        $diaAtual = date('d');

        $read = new Read();
        $read->ExeRead(self::times, "WHERE id_db_settings=:idd", "idd={$id_db_settings}");

        if($read->getResult()):
            $date = explode("-", $read->getResult()[0]['times']);
            self::$Data = $read->getResult()[0];
            self::$Date = $date;

            if($anoAtual >= self::$Date[0] || self::$Date[0] >= $anoAtual):
                if($mesAtual == self::$Date[1]):
                    if($diaAtual >= self::$Date[2]):
                        self::Kwanzar();
                        if(self::$Result):
                            self::$Error = ["Ops!!! A sua licença do Software expirou, contate o administrador.", WS_ALERT];
                            header("location: ./times.php");
                        endif;
                    else:
                        return $read->getResult()[0];
                    endif;
                else:
                    return $read->getResult()[0];
                endif;
            else:
                return "Aqui";
            endif;
        else:
            self::Kwanzar();
            self::$Error = ["Ops!!! A sua licença do Kwanzar expirou, contate o administrador.", WS_ALERT];
            header("location: ./index.php?exe=times");
        endif;
    }

    // Quantidade de Usuários
    public static function Users($id){
        $Read = new Read();
        $Read->ExeRead("db_users", "WHERE id_db_settings=:id", "id={$id}");

        if(!$Read->getResult()):
            return header("location: index.php");
        endif;
    }

    // Status do Usuário
    public static function MoDred($id, $settings){
        self::$Data = $id;
        $Read = new Read;
        $Read->ExeRead("db_users", "WHERE id=:id AND id_db_settings=:i", "id={$id}&i={$settings}");
        if($Read->getResult()):
            return $Read->getResult()[0];
        endif;
    }

    // Apagar a licença
    private static function Kwanzar($id){
        $id = self::$Data['id'];
        $Delete = new Delete();
        $Delete->ExeDelete(self::times, "WHERE id=:id AND id_db_settings=:i", "id={$id}&i={$id}");
        if($Delete->getRowCount()):
            self::$Result = true;
        else:
            self::$Error = ["Ops! Aconteceu um erro inesperado ao Eliminar o processo.", WS_ERROR];
            self::$Result = false;
        endif;
    }

    // Definições
    public static function Settings($id, $session){
        $Read = new Read();
        $Read->ExeRead(self::definitions, "WHERE id_db_settings=:id AND id_users=:u", "id={$id}&u={$session}");

        if($Read->getResult()):
            return $Read->getResult()[0];
        else:
            $a['Impression'] = 'A4';
            $a['NumberOfCopies'] = 1;
            return $a;
        endif;
    }

    public static function Config($id){
        $Read = new Read();
        $Read->ExeRead(self::config, "WHERE id_db_settings=:id", "id={$id}");

        if($Read->getResult()):
            return $Read->getResult()[0];
        endif;
    }

    public static function Sett($id){
        $Read = new Read();
        $Read->ExeRead(self::settings, "WHERE id=:id", "id={$id}");

        if($Read->getResult()):
            return $Read->getResult()[0];
        endif;
    }

    // Logs
    const Log = "log";
    public static function Logs(array $data){
        self::$Date = $data;

        if(!in_array('', self::$Date)):
            $Create = new Create();
            $Create->ExeCreate(self::Log, self::$Date);
        endif;
    }

    public static function CheckLogs($id){
        self::$Session = $id;
        $Read = new Read();
        $Read->ExeRead(self::Log, "WHERE id_users=:id", "id={$id}");

        if($Read->getRowCount() >= 5):
            unset($_SESSION['userlogin']);
            header('Location: index.php?exe=logs');
        endif;
    }

    public static function CleanLogs($id_user){
        $Delete = new Delete();
        $Delete->ExeDelete(self::Log, "WHERE id_users=:id", "id={$id_user}");

        if($Delete->getRowCount()):
            self::$Error = ["Logs do sistema limpado com successo!", WS_INFOR];
        else:
            self::$Error = ["Ops! Aconteceu um erro ao limpar os Logs do sistema, atualize a página e tente novamente.", WS_ERROR];
        endif;
    }
}
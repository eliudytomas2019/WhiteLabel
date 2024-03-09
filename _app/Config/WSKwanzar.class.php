<?php
/**
 * Created by PhpStorm.
 * User: Kwanzar Soft
 * Date: 10/05/2020
 * Time: 18:28
 */

class WSKwanzar{
    private $Error, $Result, $Data, $id_db_kwanzar;

    const
        users = "db_users",
        Entity = 'ws_times';

    public function getError(){return $this->Error;}
    public function getResult(){return $this->Result;}

    function __construct(){
        $Read = new Read();
        $AllRead = new Read();
        $Read->ExeRead(self::users);
        if($Read->getResult()):
            foreach ($Read->getResult() as $key):
                if($key["id_db_kwanzar"] != '' && $key["id_db_settings"] == null || !empty($key["id_db_kwanzar"]) && $key["id_db_settings"] == ''):
                    $AllRead->ExeRead(self::Entity, "WHERE id_db_kwanzar=:i", "i={$key['id_db_kwanzar']}");
                    if(!$AllRead->getResult()):
                        $this->Times($key["id_db_kwanzar"]);
                    endif;
                endif;
            endforeach;
        endif;
    }

    /**
     * @param array|null $data
     * @param $id_db_kwanzar
     */
    public function Times($id_db_kwanzar, array $data = null){
        $this->Data = $data;
        $this->id_db_kwanzar = $id_db_kwanzar;

        if(!isset($this->Data)):
            if(date('m') == 12):
                $mes = '01';
                $anos = date('Y') + 1;
                $day = date('d');
            else:
                $mes = date('m') + 1;
                $anos = date('Y');
                $day = date('d');
            endif;

            $this->Data['times']  = $anos."-".$mes."-".$day;
            $this->Data['ps3']    = 0;
            $this->Data['postos'] = 1;
            $this->Data['users']  = 1;
            $this->Data['users_de']  = 1;

            $data_inicial = date('Y-m-d');
            $data_final = $this->Data['times'];
            $diferenca = strtotime($data_final) - strtotime($data_inicial);
            $this->Data['saldo'] = floor($diferenca / (60 * 60 * 24));

            $this->Data['plano'] = "Experimental";
            $this->Data['documentos'] = 10;
            $this->Data['pricing'] = 0;

            //$mes = 1;
            if($mes == 0 || $mes == null):
                $this->Data['total'] = $this->Data['pricing'];
            else:
                if($mes == 1 && $this->Data['saldo'] > 30):
                    $this->Data['total'] = 2 * $this->Data['pricing'];
                else:
                    $this->Data['total'] = $mes * $this->Data['pricing'];
                endif;
            endif;
        endif;

        $this->Data['id_db_kwanzar'] = $this->id_db_kwanzar;
        $this->Data['dia']    = date('d');
        $this->Data['mes']    = date('m');
        $this->Data['ano']    = date('Y');
        $this->Data['status'] = 1;

        $this->ActiveTimes();
    }

    /**
     *
     */
    private function ActiveTimes(){
        $Create = new Create();
        $Create->ExeCreate(self::Entity, $this->Data);

        if($Create->getResult()):
            $this->Result = true;
        else:
            $this->Result = false;
        endif;
    }

    public function CheckTimes($id_db_kwanzar){
        $this->id_db_kwanzar = $id_db_kwanzar;
        $st = 1;

        $read = new Read();
        $read->ExeRead(self::Entity, "WHERE id_db_kwanzar=:i AND status=:st", "i={$this->id_db_kwanzar}&st={$st}");
        if($read->getResult()):
            $day = date('d');
            $mondy = date('m');
            $year = date('Y');
            $license = $read->getResult()[0]['times'];
            $license = explode('-', $license);

            if($license[0] > $year):
                $this->Error = ["01", WS_INFOR];
                return true;
            elseif($license[0] == $year):
                if($license[1] >= $mondy):
                    if($license[1] == $mondy):
                        if($license[2] >= $day):
                            $this->Error = ["02", WS_INFOR];
                            return true;
                        else:
                            $this->RemoveTimes();
                        endif;
                    else:
                        $this->Error = ["03", WS_INFOR];
                        return true;
                    endif;
                else:
                    $this->RemoveTimes();
                endif;
            elseif($license[0] < $year):
                $this->RemoveTimes();
            endif;
        else:
            $read->ExeRead(self::Entity, "WHERE id_db_kwanzar='' AND status=:st", "st={$st}");
            if($read->getResult()):
                $this->DeteleTimes();
            endif;

            $this->RemoveTimes();
            $this->Error = ["04", WS_INFOR];
            return false;
        endif;
    }

    /**
     * @return bool
     */
    private function RemoveTimes(){
        $date["status"] = 0;

        $Update = new Update();
        $Update->ExeUpdate(self::Entity, $date, "WHERE id_db_kwanzar=:i", "i={$this->id_db_kwanzar}");

        if($Update->getResult()):
            return true;
        else:
            $this->Error  = ["Ops: aconteceu um erro inesperado ao revogar a licença!", WS_ALERT];
            return false;
        endif;
    }

    private function DeteleTimes(){
        $st = '' || null;
        $Delete = new Delete();
        $Delete->ExeDelete(self::Entity, "WHERE id_db_kwanzar=:st ", "st={$st}");

        if($Delete->getResult() || $Delete->getRowCount()):
            return true;
        else:
            $this->Error  = ["Ops: aconteceu um erro inesperado ao revogar a licença!", WS_ALERT];
            return false;
        endif;
    }

    /**
     * @param $id_db_kwanzar
     * @return bool
     */
    public static function CheckLicence($id_db_kwanzar){
        $st = 1;
        $Read = new Read();
        $Read->ExeRead(self::Entity, "WHERE id_db_kwanzar=:i AND status=:a", "i={$id_db_kwanzar}&a={$st}");

        if($Read->getResult()):
            return $Read->getResult()[0];
        else:
            return false;
        endif;
    }
}
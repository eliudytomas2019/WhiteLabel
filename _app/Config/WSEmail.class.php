<?php
/**
 * Created by PhpStorm.
 * User: Kwanzar Soft
 * Date: 17/06/2020
 * Time: 00:31
 */

class WSEmail{
    private $Data, $ID, $Result, $Error, $Alert;
    const
        ws_alerts = "ws_alerts";

    public function getError(){return $this->Error;}
    public function getResult(){return $this->Result;}

    /**
     * @param array $data
     */
    public function Alerts(array $data){
        $this->Data = $data;

        if(in_array('', $this->Data)):
            $this->Error  = ["Ops: preencha todos os campos para prosseguir com o processo!", WS_INFOR];
            $this->Result = false;
        else:
            $Read = new Read();
            $Read->ExeRead(self::ws_alerts);

            if($Read->getResult()):
                $this->ID = $Read->getResult()[0]['id'];
                $this->UpdateAlerts();
            else:
                $this->CreateAlerts();
            endif;
        endif;
    }

    private function CreateAlerts(){
        $Create = new Create();
        $Create->ExeCreate(self::ws_alerts, $this->Data);

        if($Create->getResult()):
            $this->Error  = ["Operação realizada com sucesso!", WS_ACCEPT];
            $this->Result = true;
        else:
            $this->Error  = ["Ops: aconteceu um erro inesperado aos escrever os email's, atualize a página e tente novamente;", WS_ERROR];
            $this->Result = false;
        endif;
    }

    private function UpdateAlerts(){
        $Update = new Update();
        $Update->ExeUpdate(self::ws_alerts, $this->Data, "WHERE id=:i", "i={$this->ID}");

        if($Update->getResult()):
            $this->Error  = ["Operação realizada com sucesso!", WS_ACCEPT];
            $this->Result = true;
        else:
            $this->Error  = ["Ops: aconteceu um erro inesperado aos escrever os email's, atualize a página e tente novamente;", WS_ERROR];
            $this->Result = false;
        endif;
    }
}
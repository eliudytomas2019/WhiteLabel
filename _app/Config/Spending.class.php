<?php
/**
 * Created by PhpStorm.
 * User: Kwanzar Soft
 * Date: 15/06/2020
 * Time: 03:28
 */

class Spending{
    private $Data, $Error, $Result, $Altert, $Info, $ID, $id_db_settings, $Session;
    const
        sd_spending = "sd_spending";

    public function getError(){return $this->Error;}
    public function getResult(){return $this->Result;}

    /**
     * @param array $data
     * @param $id_db_settings
     * @param $id_user
     */
    public function ExeSpending(array $data, $id_db_settings, $id_user){
        $this->Data = $data;
        $this->id_db_settings = $id_db_settings;
        $this->Session = $id_user;

        if(in_array('', $this->Data)):
            $this->Error  = ["Ops: preencha todos os campos para prosseguir com o processo!", WS_ALERT];
            $this->Result = false;
        else:
            $this->Spendings();
        endif;
    }

    private function Spendings(){
        $this->Data['id_db_settings'] = $this->id_db_settings;
        $this->Data['session_id'] = $this->Session;
        $this->Data['dia'] = date('d');
        $this->Data['mes'] = date('m');
        $this->Data['ano'] = date('Y');
        $this->Data['hora'] = date('H:i:s');


        $Create = new Create();
        $Create->ExeCreate(self::sd_spending, $this->Data);

        if($Create->getResult()):
            $this->Error  = ["Operação realizada com sucesso!", WS_ACCEPT];
            $this->Result = true;
        else:
            $this->Error  = ["Ops: aconteceu um erro inesperado ao criar a despesa;", WS_ERROR];
            $this->Result = false;
        endif;
    }

    public function ExeDelete($id, $id_db_settings){
        $this->ID = $id;
        $this->id_db_settings = $id_db_settings;


        $Delete = new Delete();
        $Delete->ExeDelete(self::sd_spending, "WHERE id=:i AND id_db_settings=:ip", "i={$this->ID}&ip={$this->id_db_settings}");

        if($Delete->getResult() || $Delete->getRowCount()):
            $this->Error  = ["Ops: despesa deletada com successo!", WS_INFOR];
            $this->Result = true;
        else:
            $this->Error  = ["Ops: aconteceu um erro inesperado ao deletar a despesas"];
            $this->Result = false;
        endif;
    }
}
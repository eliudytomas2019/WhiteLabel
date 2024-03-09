<?php
/**
 * Created by PhpStorm.
 * User: Kwanzar Soft
 * Date: 16/08/2020
 * Time: 15:18
 */

class Garcom{
    private $Data, $Result, $Error, $id_db_settings, $ID, $Settings;
    const Entity = "cv_garcom";

    public function getResult(){return $this->Result;}
    public function getError() {return $this->Error;}

    /**
     * @param array $data
     * @param $id_db_settings
     */
    public function ExeCreate(array $data, $id_db_settings){
        $this->Data = $data;
        $this->id_db_settings = $id_db_settings;

        if(in_array('', $this->Data)):
            $this->Error  = ["Ops: preencha todos os campos para prosseguir com o processo!", WS_INFOR];
            $this->Result = false;
        else:
            $this->CheckGarcom();
            if($this->Result):
                $this->Data['id_db_settings'] = $this->id_db_settings;
                $this->Data['status'] = 1;
                $this->Create();
            endif;
        endif;
    }

    private function CheckGarcom(){
        $Read = new Read();
        $Read->ExeRead(self::Entity, "WHERE id_db_settings=:ip AND name=:n AND porcentagem=:cap", "ip={$this->id_db_settings}&n={$this->Data['name']}&cap={$this->Data['porcentagem']}");

        if($Read->getResult()):
            $this->Error  = ["Ops: o garcom <strong>{$this->Data['name']}</strong> já encontra-se registrada no Kwanzar!", WS_INFOR];
            $this->Result = false;
        else:
            $this->Result = true;
        endif;
    }

    private function Create(){
        $Create = new Create();
        $Create->ExeCreate(self::Entity, $this->Data);

        if($Create->getResult()):
            $this->Error  = ["Operação realizada com sucesso!", WS_ACCEPT];
            $this->Result = true;
        else:
            $this->Error  = ["Ops: aconteceu um erro inesperado ao cadastrar o garçom <strong>{$this->Data['name']}</strong>.!", WS_ALERT];
            $this->Result = false;
        endif;
    }

    public function ExeDelete($id, $id_db_kwanzar){
        $this->ID = $id;
        $this->id_db_settings = $id_db_kwanzar;

        $Delete = new Delete();
        $Delete->ExeDelete(self::Entity, "WHERE id=:i AND id_db_settings=:ip", "i={$this->ID}&ip={$this->id_db_settings}");

        if($Delete->getResult() || $Delete->getRowCount()):
            $this->Error  = ["Garçom deletado com sucesso!", WS_INFOR];
            $this->Result = true;
        else:
            $this->Error  = ["Ops: aconteceu um erro inesperado ao eliminar a mesa!", WS_ERROR];
            $this->Result = false;
        endif;
    }

    /**
     * @param $id
     * @param array $data
     * @param $Settings
     */
    public function ExeUpdate($id, array $data, $Settings){
        $this->Data = $data;
        $this->ID = $id;
        $this->Settings = $Settings;

        if(!in_array('', $this->Data)):
            $this->Update();
        else:
            $this->Error = ["Ops! Preencha todos os campos para prosseguir com o processo.", WS_INFOR];
            $this->Result = false;
        endif;
    }

    private function Update(){
        unset($this->Data['SendPostForm']);

        $Update = new Update();
        $Update->ExeUpdate(self::Entity, $this->Data, "WHERE id=:id AND id_db_settings=:i", "id={$this->ID}&i={$this->Settings}");

        if($Update->getResult()):
            $this->Error = ["Operação realizada com sucesso!", WS_ACCEPT];
            $this->Result = true;
        else:
            $this->Error = ["Ops! Aconteceu um erro inesperado ao terminar o processo.", WS_ERROR];
            $this->Result = false;
        endif;
    }
}
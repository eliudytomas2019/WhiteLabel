<?php
class Marcas{
    private $Dados, $Result, $Error, $Customer, $IDEmpresa, $ID, $Data;
    const Entity = "cv_marcas";

    public function ExeCreate(array $Dados, $id){
        $this->Dados = $Dados;
        $this->IDEmpresa = $id;
        $this->Dados['data'] = date('d-m-Y H:i:s');
        $this->CheckCustomer();

        if($this->Result):
            if(in_array('', $this->Dados)):
                $this->Error = ["Opsss!!! Preencha todos campos.", WS_ALERT];
                $this->Result = false;
            else:
                $this->Create();
            endif;
        endif;
    }

    public function ExeUpdate($IdUser, array $Dados, $id){
        $this->Dados = $Dados;
        $this->Customer = $IdUser;
        $this->IDEmpresa = $id;

        if(in_array('', $this->Dados)):
            $this->Error = ["Opsss!!! Preencha todos campos.", WS_ALERT];
            $this->Result = false;
        else:
            $this->Update();
        endif;
    }

    public function ExeDelete($UserId){
        $this->Customer = (int) $UserId;
        $this->Delete();
    }

    public function getResult(){
        return $this->Result;
    }

    public function getError(){
        return $this->Error;
    }

    private function CheckCustomer(){
        $ReadCheck = new Read;
        $ReadCheck->ExeRead(self::Entity, "WHERE id_db_settings=:id AND marca=:Nc", "id={$this->IDEmpresa}&Nc={$this->Dados['marca']}");

        if($ReadCheck->getResult()):
            $this->Customer = $ReadCheck->getResult()[0]['id'];
            $this->Error = ["Opsss! Categoria: <b>{$ReadCheck->getResult()[0]['marca']}</b> já está registrada", WS_INFOR];
            $this->Result = false;
        else:
            $this->Result = true;
        endif;
    }

    private function Create(){
        $Dados = [
            'id_db_settings' => $this->IDEmpresa,
            'marca' => $this->Dados['marca'],
            'content' => $this->Dados['content'],
            'data'  => $this->Dados['data']
        ];

        $Create = new Create;
        $Create->ExeCreate(self::Entity, $Dados);

        if($Create->getResult()):
            $this->Error = ["A Categoria <b>{$this->Dados['marca']}</b> foi cadastrado com sucesso!", WS_ACCEPT];
            $this->Result = $Create->getResult();
        endif;
    }

    private function Update(){
        $Dados = [
            'marca' => $this->Dados['marca'],
            'content' => $this->Dados['content']
        ];

        $Update = new Update();
        $Update->ExeUpdate(self::Entity, $Dados, "WHERE id=:J AND id_db_settings=:id", "J={$this->Customer}&id={$this->IDEmpresa}");

        if($Update->getResult()):
            $this->Error = ["A Categoria <b>{$this->Dados['marca']}</b> foi atualizado com sucesso!", WS_ACCEPT];
            $this->Result = $Update->getResult();
        endif;
    }

    private function Delete(){
        $Delete = new Delete;
        $Delete->ExeDelete(self::Entity, "WHERE id= :id", "id={$this->Customer}");

        if($Delete->getResult() || $Delete->getRowCount()):
            $this->Error  = ["A Categoria foi eliminada com sucesso!", WS_ACCEPT];
            $this->Result = true;
        endif;
    }

    public function AddViews($postId){
        $this->ID = $postId;

        $Read = new Read();
        $Read->ExeRead(self::Entity, "WHERE id=:i", "i={$this->ID}");

        if($Read->getResult()):
            $this->Data['views'] = $Read->getResult()[0]['views'] + 1;
        else:
            $this->Data['views'] = 1;
        endif;

        $this->Views();
    }

    private function Views(){
        $Update = new Update();
        $Update->ExeUpdate(self::Entity, $this->Data, "WHERE id=:i", "i={$this->ID}");

        if($Update->getResult()):
            $this->Result = true;
        else:
            $this->Error  = ["Ops: aconteceu um erro inesperado ao adiconar a view a categoria!", WS_ERROR];
            $this->Result = false;
        endif;
    }
}
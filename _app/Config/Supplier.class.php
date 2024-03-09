<?php
/**
 * Created by PhpStorm.
 * User: Kwanzar Soft
 * Date: 01/04/2020
 * Time: 16:53
 */

class Supplier{
    private $Dados, $Result, $Error, $Customer, $Cover, $IDEmpresa;

    const Entity = "cv_supplier";

    public function ExeCreate(array $Cover, array $Dados, $id){
        $this->Cover = $Cover;
        $this->Dados = $Dados;
        $this->IDEmpresa = $id;

        $this->CheckCustomer();

        if($this->Result):
            if(!in_array('', $this->Cover)):
                $this->SendLogotype();
            else:
                $this->Cover['logotype'] = '';
            endif;

            if(in_array('', $this->Dados)):
                $this->Error = ["Opsss!!! Preencha todos campos.", WS_ALERT];
                $this->Result = false;
            elseif(!Check::Email($this->Dados['email'])):
                $this->Error = ['Introduza um E-mail Válido!', WS_INFOR];
                $this->Result = false;
            elseif(strlen($this->Dados['country']) < 2 || strlen($this->Dados['country']) > 2):
                $this->Error = ["Ops: o país tem que estar no intervalo de dois caractéres, exemplo: <strong>AO, PT ou BR...</strong>", WS_ALERT];
                $this->Result = false;
            else:
                $this->Create();
            endif;
        endif;
    }

    public function ExeUpdate($IdUser, array $Cover, array $Dados, $id){
        $this->Cover = $Cover;
        $this->Dados = $Dados;
        $this->Customer = $IdUser;
        $this->IDEmpresa = $id;

        if(!in_array('', $this->Cover)):
            $this->SendLogotype();
        endif;

        if(in_array('', $this->Dados)):
            $this->Error = ["Opsss!!! Preencha todos campos.", WS_ALERT];
            $this->Result = false;
        elseif(!Check::Email($this->Dados['email'])):
            $this->Error = ['Introduza um E-mail Válido!', WS_INFOR];
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

    private function SendLogotype(){
        if(!empty($this->Cover['logotype']['tmp_name'])):
            //$this->CheckCover();
            $Upload = new Upload;
            $Upload->Image($this->Cover['logotype']);

            if($Upload->getError()):
                $this->Error = $Upload->getError();
                $this->Result = false;
            else:
                $this->Cover['logotype'] = $Upload->getResult();
                $this->Result = true;
            endif;
        endif;
    }

    private function CheckCover(){
        $ReadCover = new Read;
        $ReadCover->FullRead("SELECT cover FROM customer WHERE id=:id", "id={$this->Customer}");

        if($ReadCover->getRowCount()):
            $delCover = $ReadCover->getResult()[0]['cover'];
            if(file_exists("./uploads/{$delCover}") && !is_dir("./uploads/{$delCover}")):
                unlink("./uploads/{$delCover}");
            endif;
        endif;
    }

    private function CheckCustomer(){
        $ReadCheck = new Read;
        $ReadCheck->ExeRead(self::Entity, "WHERE id_db_settings=:id AND nome=:Nc AND nif=:Fc", "id={$this->IDEmpresa}&Nc={$this->Dados['nome']}&Fc={$this->Dados['nif']}");

        if($ReadCheck->getResult()):
            $this->Customer = $ReadCheck->getResult()[0]['id'];
            $this->Error = ["Opsss! Fornecedor: <b>{$ReadCheck->getResult()[0]['nome']} - {$ReadCheck->getResult()[0]['nif']}</b>", WS_INFOR];
            $this->Result = false;
        else:
            $this->Result = true;
        endif;
    }

    private function Create(){
        $Dados = [
            'id_db_settings' => $this->IDEmpresa,
            'nome' => $this->Dados['nome'],
            'type' => $this->Dados['type'],
            'nif'  => $this->Dados['nif'],
            'email' => $this->Dados['email'],
            'telefone' => $this->Dados['telefone'],
            'endereco' => $this->Dados['endereco'],
            'addressDetail' => $this->Dados['addressDetail'],
            'city' => $this->Dados['city'],
            'country' => $this->Dados['country'],
            'accountID' => 32,
            'cover'    => $this->Cover['logotype'],
            'obs'      => $this->Dados['obs'],
            'status'   => 3
        ];

        $Create = new Create;
        $Create->ExeCreate(self::Entity, $Dados);

        if($Create->getResult()):
            $this->Error = ["O Fornecedor <b>{$this->Dados['nome']}</b> foi cadastrado com sucesso!", WS_ACCEPT];
            $this->Result = $Create->getResult();
        endif;
    }

    private function Update(){
        if($this->Cover['logotype'] != ''):
            $Dados = [
                'nome' => $this->Dados['nome'],
                'type' => $this->Dados['type'],
                'nif'  => $this->Dados['nif'],
                'email' => $this->Dados['email'],
                'telefone' => $this->Dados['telefone'],
                'endereco' => $this->Dados['endereco'],
                'addressDetail' => $this->Dados['addressDetail'],
                'city' => $this->Dados['city'],
                'country' => $this->Dados['country'],
                'cover'    => $this->Cover['logotype'],
                'obs'      => $this->Dados['obs']
            ];
        else:
            $Dados = [
                'nome' => $this->Dados['nome'],
                'type' => $this->Dados['type'],
                'nif'  => $this->Dados['nif'],
                'email' => $this->Dados['email'],
                'telefone' => $this->Dados['telefone'],
                'endereco' => $this->Dados['endereco'],
                'addressDetail' => $this->Dados['addressDetail'],
                'city' => $this->Dados['city'],
                'country' => $this->Dados['country'],
                'obs'      => $this->Dados['obs']
            ];
        endif;

        $Update = new Update();
        $Update->ExeUpdate(self::Entity, $Dados, "WHERE id_db_settings=:id AND id=:J", "id={$this->IDEmpresa}&J={$this->Customer}");

        if($Update->getResult()):
            $this->Error = ["O Fornecedor <b>{$this->Dados['nome']}</b> foi atualizado com sucesso!", WS_ACCEPT];
            $this->Result = $Update->getResult();
        endif;
    }

    private function Delete(){
        $Delete = new Delete;
        $Delete->ExeDelete(self::Entity, "WHERE id= :id", "id={$this->Customer}");

        if($Delete->getResult()):
            $this->Error = ["A conta foi Deletada com sucesso!", WS_ACCEPT];
            $this->Result = $Delete->getResult();
        endif;
    }
}
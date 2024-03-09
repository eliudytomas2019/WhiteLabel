<?php
class Customer{
    private $Dados, $Result, $Error, $Customer, $Cover, $Empresa, $id_db_settings, $id_customer, $File, $Data;

    const
        Entity = "cv_customer",
        Obs = "cv_obs",
        import = "cv_customer_import",
        credito = "cv_customer_credito";

    public function ExeCreateObs(array $Dados, $id){
        $this->Dados = $Dados;
        $this->Empresa = $id;

        $this->CheckObs();
        if($this->Result):
            if(in_array('', $this->Dados)):
                $this->Error = ["Ops! Preencha todos campos para prosseguir.", WS_ALERT];
                $this->Result = false;
            else:
                $this->CreateObs();
            endif;
        endif;
    }

    public function ExeCreate(array $Cover = null, array $Dados, $id){
        $this->Cover = $Cover;
        $this->Dados = $Dados;
        $this->Empresa = $id;

        $this->CheckCustomer();
        if($this->Result):
            if(!in_array('', $this->Cover)):
                $this->SendLogotype();
            else:
                $this->Cover['logotype'] = '';
            endif;

            if(empty($this->Dados['telefone'])):      $this->Dados['telefone'] = " "; endif;
            if(empty($this->Dados['addressDetail'])): $this->Dados['addressDetail'] = " "; endif;
            if(empty($this->Dados['obs'])):           $this->Dados['obs'] = " "; endif;
            if(empty($this->Dados['email'])):         $this->Dados['email'] = " "; endif;
            if(empty($this->Dados['addressDetail'])): $this->Dados['addressDetail'] = " "; endif;
            if(empty($this->Dados['endereco'])): $this->Dados['endereco'] = " "; endif;

            if($this->Dados['nif'] == ''):
                $this->Dados['nif'] = '999999999';

                if(in_array('', $this->Dados)):
                    $this->Error = ["Ops! Preencha todos campos para prosseguir.", WS_ALERT];
                    $this->Result = false;
                elseif(!empty($this->Dados['nif']) && (strlen($this->Dados['nif']) < 9 || strlen($this->Dados['nif']) > 35)):
                    $this->Error = ["Ops! Introduza um NIF válido para prosseguir com o cadastramento", WS_ALERT];
                    $this->Result = false;
                elseif(!empty($this->Dados['email']) && $this->Dados['email'] != ' ' && !Check::Email($this->Dados['email'])):
                    $this->Error = ['Introduza um E-mail Válido!', WS_INFOR];
                    $this->Result = false;
                else:
                    $this->Create();
                endif;
            else:
                if(in_array('', $this->Dados)):
                    $this->Error = ["Ops! Preencha todos campos para prosseguir.", WS_ALERT];
                    $this->Result = false;
                elseif(!empty($this->Dados['nif']) && (strlen($this->Dados['nif']) < 9 || strlen($this->Dados['nif']) > 35)):
                    $this->Error = ["Ops! Introduza um NIF válido para prosseguir com o cadastramento", WS_ALERT];
                    $this->Result = false;
                elseif(!empty($this->Dados['email']) && $this->Dados['email'] != ' ' && !Check::Email($this->Dados['email'])):
                    $this->Error = ['Introduza um E-mail Válido!', WS_INFOR];
                    $this->Result = false;
                else:
                    $this->Create();
                endif;
            endif;
        endif;
    }

    public function ExeUpdate($IdUser, array $Cover, array $Dados, $id){
        $this->Cover = $Cover;
        $this->Dados = $Dados;
        $this->Customer = $IdUser;
        $this->Empresa = $id;

        unset($this->Dados['SendPostForm']);

        if(!in_array('', $this->Cover)):
            $this->SendLogotype();
            if($this->Result):
                $this->Dados['cover'] = $this->Cover['logotype'];
            endif;
        endif;

        if(empty($this->Dados['telefone'])): $this->Dados['telefone'] = " "; endif;
        if(empty($this->Dados['obs'])): $this->Dados['obs'] = " "; endif;
        if(empty($this->Dados['email'])): $this->Dados['email'] = " "; endif;


        //if($this->Dados['nif'] != '999999999' || $this->Dados['nif'] != '' || $this->Dados['nif'] != null): unset($this->Dados['nif']); endif;

        if(in_array('', $this->Dados)):
            $this->Error = ["Opsss!!! Preencha todos campos.", WS_ALERT];
            $this->Result = false;
        elseif(!empty($this->Dados['email']) && $this->Dados['email'] != ' ' && !Check::Email($this->Dados['email'])):
            $this->Error = ['Introduza um E-mail Válido!', WS_INFOR];
            $this->Result = false;
        else:
            $this->Update();
        endif;
    }

    public function ExeUpdateObs($IdUser, array $Dados, $id){
        $this->Dados = $Dados;
        $this->Customer = $IdUser;
        $this->Empresa = $id;

        if(in_array('', $this->Dados)):
            $this->Error = ["Opsss: Preencha todos campos.", WS_ALERT];
            $this->Result = false;
        else:
            $this->UpdateObs();
        endif;
    }

    public function ExeDelete($UserId){
        $this->Customer = (int) $UserId;
        $this->Delete();
    }

    public function ExeCredito($id_customer, array $Dados, $id_db_settings){
        $this->Dados = $Dados;
        $this->id_db_settings = $id_db_settings;
        $this->id_customer = $id_customer;

        unset($this->Dados['SendPostForm']);

        if(!empty($this->Dados['credito']) && is_numeric($this->Dados['credito'])):
            $Read = new Read();
            $Read->ExeRead(self::credito, "WHERE id_customer=:id AND id_db_settings=:set ", "id={$this->id_customer}&set={$this->id_db_settings}");

            if($Read->getResult()):
                $this->UpdateCredito();
            else:
                $this->CreateCredito();
            endif;
        else:
            $this->Error = ["Preencha o campo crédito para finalizar o processo!", WS_ERROR];
            $this->Result = false;
        endif;
    }

    private function UpdateCredito(){
        $Update = new Update();
        $Update->ExeUpdate(self::credito,  $this->Dados, "WHERE id_customer=:id AND id_db_settings=:set ", "id={$this->id_customer}&set={$this->id_db_settings}");

        if($Update->getResult()):
            $this->Result = true;
            $this->Error = ["Limite de crédito atualizado com sucesso!", WS_ACCEPT];
        else:
            $this->Error = ["Aconteceu um erro ao atualizar o limite de crédito!", WS_ERROR];
            $this->Result = false;
        endif;
    }

    private function CreateCredito(){
        $this->Dados['id_db_settings'] = $this->id_db_settings;
        $this->Dados['id_customer'] = $this->id_customer;
        $this->Dados['status'] = 1;

        $Create = new Create();
        $Create->ExeCreate(self::credito, $this->Dados);

        if($Create->getResult()):
            $this->Result = true;
            $this->Error = ["Limite de Crédito Criado com sucesso!", WS_ACCEPT];
        else:
            $this->Error = ["Aconteceu um erro ao criar o limite de crédito!", WS_ERROR];
            $this->Result = false;
        endif;
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
        $ReadCheck->ExeRead(self::Entity, "WHERE id_db_settings=:id AND nome=:Nc AND nif=:Fc", "id={$this->Empresa}&Nc={$this->Dados['nome']}&Fc={$this->Dados['nif']}");

        if($ReadCheck->getResult()):
            $this->Customer = $ReadCheck->getResult()[0]['id'];
            $this->Error = ["Opsss! Cliente: <b>{$ReadCheck->getResult()[0]['nome']} - {$ReadCheck->getResult()[0]['nif']}</b> já encontra-se registrado!", WS_INFOR];
            $this->Result = false;
        else:
            $this->Result = true;
        endif;
    }

    private function CheckObs(){
        $ReadCheck = new Read;
        $ReadCheck->ExeRead(self::Obs, "WHERE id_db_settings=:id AND nome=:Nc", "id={$this->Empresa}&Nc={$this->Dados['nome']}");

        if($ReadCheck->getResult()):
            $this->Customer = $ReadCheck->getResult()[0]['id'];
            $this->Error = ["Opsss! A Observação: <b>{$ReadCheck->getResult()[0]['nome']}</b> já encontra-se registrado!", WS_INFOR];
            $this->Result = false;
        else:
            $this->Result = true;
        endif;
    }

    private function Create(){
        $Dados = [
            'id_db_settings' => $this->Empresa,
            'nome' => $this->Dados['nome'],
            'type' => $this->Dados['type'],
            'nif'  => $this->Dados['nif'],
            'email' => $this->Dados['email'],
            'telefone' => $this->Dados['telefone'],
            'endereco' => $this->Dados['endereco'],
            'addressDetail' => $this->Dados['addressDetail'],
            'city' => $this->Dados['city'],
            'country' => $this->Dados['country'],
            'accountID' => 31,
            'cover'    => $this->Cover['logotype'],
            'obs'      => $this->Dados['obs'],
            'status'   => 3
        ];

        $Create = new Create;
        $Create->ExeCreate(self::Entity, $Dados);

        if($Create->getResult()):
            $this->Error = ["O Cliente <b>{$this->Dados['nome']}</b> foi cadastrado com sucesso!", WS_ACCEPT];
            $this->Result = $Create->getResult();
        endif;
    }

    private function CreateObs(){
        $Dados = [
            'id_db_settings' => $this->Empresa,
            'nome' => $this->Dados['nome'],
            'data'      => date('d-m-Y H:i:s'),
            'status'   => 1
        ];

        $Create = new Create;
        $Create->ExeCreate(self::Obs, $Dados);

        if($Create->getResult()):
            $this->Error = ["A Observação <b>{$this->Dados['nome']}</b> foi cadastrado com sucesso!", WS_ACCEPT];
            $this->Result = $Create->getResult();
        endif;
    }

    private function Update(){


        $Update = new Update();
        $Update->ExeUpdate(self::Entity, $this->Dados, "WHERE id=:J AND id_db_settings=:i", "J={$this->Customer}&i={$this->Empresa}");

        if($Update->getResult()):
            $this->Error = ["O Cliente atualizado com sucesso!", WS_ACCEPT];
            $this->Result = $Update->getResult();
        endif;
    }

    private function UpdateObs(){

        $Dados = [
            'nome' => $this->Dados['nome']
        ];

        $Update = new Update();
        $Update->ExeUpdate(self::Obs, $Dados, "WHERE id=:J AND id_db_settings=:i", "J={$this->Customer}&i={$this->Empresa}");

        if($Update->getResult()):
            $this->Error = ["A Observação atualizado com sucesso!", WS_ACCEPT];
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

    public function ExeImport($logoty, $id_db_settings){
        $this->File     = $logoty;
        $this->id_db_settings = (int) $id_db_settings;

        if(!in_array('', $this->File)):
            $this->SendFile();
            $this->Import();
        else:
            $this->Result = false;
            $this->Error = ["Carregue o ficheiro para continuar com a importação de dados!", WS_ALERT];
        endif;
    }

    private function SendFile(){
        if(!empty($this->File['files']['tmp_name'])):
            $Upload = new Upload;
            $Upload->File($this->File['files']);

            if($Upload->getError()):
                $this->Error = ["Aconteceu um erro inesperado ao enviar o ficheiro!", WS_ERROR];
                $this->Result = false;
            else:
                $this->Data['files'] = $Upload->getResult();
                $this->Result = true;
            endif;
        endif;
    }

    private function Import(){
        $this->Data['id_db_settings'] = $this->id_db_settings;
        //$this->Data['files'] = $this->File['files'];
        $this->Data['data'] = date('d-m-Y');
        $this->Data['hora'] = date('H:i:s');
        $this->Data['status'] = 1;

        $Create = new Create();
        $Create->ExeCreate(self::import, $this->Data);

        if($Create->getResult()):
            $this->Result = true;
        else:
            $this->Error = ["Ops: aconteceu um erro inesperado ao importar o arquivo!", WS_ERROR];
            $this->Result = false;
        endif;
    }
}
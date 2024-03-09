<?php
class Oficina{
    private $Data, $Info, $sPro, $Error, $Result, $CheckBox, $id_user, $Id, $id_db_settings, $Licence, $logotype, $postId, $level;
    const
        product = "cv_product",
        unidade = "i_unidade",
        clientes = "i_clientes",
        fornecedores = "i_fornecedores",
        fabricante = "i_fabricante",
        veiculos = "i_veiculos",
        system  = "db_settings";

    public function getResult(){return $this->Result;}
    public function getError(){return $this->Error;}

    public function UnidadeCreate(array $data, $id_db_settings){
        $this->id_db_settings = (int) $id_db_settings;
        $this->Data = $data;

        if(empty($this->Data['unidade']) || empty($this->Data['unidade'])):
            $this->Error  = ["Ops: preencha o campo unidade para prosseguir com o processo!", WS_ALERT];
            $this->Result = false;
        elseif(isset($this->Data['simbolo']) && strlen($this->Data['simbolo']) >= 10):
            $this->Result = false;
            $this->Error  = ["Ops: o campo descriação da unidade tem que ter o máximo 9 caracteres!.", WS_ALERT];
        else:
            $Read = new Read();
            $Read->ExeRead(self::unidade, "WHERE id_db_settings=:i AND unidade=:y", "i={$this->id_db_settings}&y={$this->Data['unidade']}");

            if($Read->getResult()):
                $this->Result = false;
                $this->Error  = ["Ops: a unidade <strong>{$this->Data['unidade']}</strong> já encontra-se em uso no sistema!", WS_ALERT];
            else:
                $this->Data['id_db_settings'] = $id_db_settings;
                $this->Unidade();
            endif;
        endif;
    }

    private function Unidade(){
        $Create = new Create();
        $Create->ExeCreate(self::unidade, $this->Data);

        if($Create->getResult()):
            $this->Result = true;
            $this->Error  = ["Unidade adicionada com sucesso!", WS_ACCEPT];
        else:
            $this->Result = false;
            $this->Error  = ["Ops: aconteceu um erro inesperado ao adicionar a unidade!", WS_ERROR];
        endif;
    }

    public function UpdateUnidade(array $data, $id_db_settings, $postId){
        $this->Data = $data;
        $this->id_db_settings = (int) $id_db_settings;
        $this->postId = (int) $postId;

        if(empty($this->Data['unidade']) || empty($this->Data['unidade'])):
            $this->Error  = ["Ops: preencha o campo unidade para prosseguir com o processo!", WS_ALERT];
            $this->Result = false;
        elseif(isset($this->Data['simbolo']) && strlen($this->Data['simbolo']) >= 10):
            $this->Result = false;
            $this->Error  = ["Ops: o campo descriação da unidade tem que ter o máximo 9 caracteres!.", WS_ALERT];
        else:
            $this->UnidadeUpdate();
        endif;
    }

    private function UnidadeUpdate(){
        $Update = new Update();
        $Update->ExeUpdate(self::unidade, $this->Data, "WHERE id=:i AND id_db_settings=:y", "i={$this->postId}&y={$this->id_db_settings}");

        if($Update->getResult()):
            $this->Result = true;
            $this->Error  = ["Unidade atualizada com sucesso!", WS_ACCEPT];
        else:
            $this->Result = false;
            $this->Error  = ["Ops: aconteceu um erro ao atualizar a unidade", WS_ERROR];
        endif;
    }

    public function DeleteUnidade($postId){
        $this->postId = (int) $postId;

        $Read = new Read();
        $Read->ExeRead(self::product, "WHERE id_unidade=:i", "i={$this->postId}");

        if($Read->getResult()):
            $this->Result = false;
            $this->Error  = ["Ops: não conseguimos deletar a unidade porque encontra-se associada a um Item.", WS_ERROR];
        else:
            $Delete = new Delete();
            $Delete->ExeDelete(self::unidade, "WHERE id=:y", "y={$this->postId}");

            if($Delete->getResult() || $Delete->getRowCount()):
                $this->Result = true;
                $this->Error  = ["Unidade deletada com sucesso!", WS_ACCEPT];
            else:
                $this->Error  = ["Ops: aconteceu um erro inesperado ao deletar a unidade!", WS_ERROR];
                $this->Result = false;
            endif;
        endif;
    }

    public function Fornecedores($data, $id_db_settings){
        $this->id_db_settings = (int) $id_db_settings;
        $this->Data = $data;

        if(!isset($this->Data['name']) && !isset($this->Data['endereco'])):
            $this->Error  = ["Ops: preencha os campos Fornecedor & endereço!", WS_ERROR];
            $this->Result = false;
        elseif(isset($this->Data['email']) && !empty($this->Data['email']) && !Check::Email($this->Data['email'])):
            $this->Result = false;
            $this->Error  = ["Ops: introduza endereço de email válido", WS_ALERT];
        elseif(isset($this->Data['nif']) && !empty($this->Data['nif']) && strlen($this->Data['nif']) < 9 || isset($this->Data['nif']) && !empty($this->Data['nif']) && strlen($this->Data['nif']) > 25):
            $this->Result = false;
            $this->Error  = ["Ops: introduza um NIF válido!", WS_ALERT];
        else:
            $Read = new Read();
            $Read->ExeRead(self::fornecedores, "WHERE id_db_settings=:i AND name=:y", "i={$this->id_db_settings}&y={$this->Data['name']}");

            if($Read->getResult()):
                $this->Result = false;
                $this->Error  = ["Ops: o fornecedor <strong>{$this->Data['name']}</strong>, já encontra-se registrado!", WS_INFOR];
            else:
                if(isset($this->Data['nif']) && !empty($this->Data['nif'])):
                    $Read->ExeRead(self::fornecedores, "WHERE id_db_settings=:i AND nif=:y", "i={$this->id_db_settings}&y={$this->Data['nif']}");

                    if($Read->getResult()):
                        $this->Result = false;
                        $this->Error  = ["Ops: o nif: <strong>{$this->Data['nif']}</strong>, já encontra-se em uso no sistema!", WS_INFOR];
                    endif;
                else:
                    if(empty($this->Data['nif']) || !isset($this->Data['nif'])): $this->Data['nif'] = "999999999"; endif;
                endif;
                if(empty($this->Data['country']) || !isset($this->Data['country'])): $this->Data['country'] = "AO"; endif;
                if(empty($this->Data['city']) || !isset($this->Data['city'])): $this->Data['city'] = "Luanda"; endif;
                if(empty($this->Data['obs']) || !isset($this->Data['obs'])): unset($this->Data['obs']); endif;

                $this->Data['id_db_settings'] = $this->id_db_settings;
                $this->CreateFornecedores();
            endif;
        endif;
    }

    private function CreateFornecedores(){
        $Create = new Create();
        $Create->ExeCreate(self::fornecedores, $this->Data);

        if($Create->getResult()):
            $this->Result = true;
            $this->Error  = ["Fornecedor registrado com sucesso!", WS_ACCEPT];
        else:
            $this->Error  = ["Ops: aconteceu um erro inesperado ao registrar o fornecedor", WS_ERROR];
            $this->Result = false;
        endif;
    }

    public function UpdatesFornecedores(array $data, $id_db_settings, $postId){
        $this->Data = $data;
        $this->postId = (int) $postId;
        $this->id_db_settings = (int) $id_db_settings;

        if(!isset($this->Data['name']) && !isset($this->Data['endereco'])):
            $this->Error  = ["Ops: preencha os campos Fornecedor & endereço!", WS_ERROR];
            $this->Result = false;
        elseif(isset($this->Data['email']) && !empty($this->Data['email']) && !Check::Email($this->Data['email'])):
            $this->Result = false;
            $this->Error  = ["Ops: introduza endereço de email válido", WS_ALERT];
        elseif(isset($this->Data['nif']) && !empty($this->Data['nif']) && strlen($this->Data['nif']) < 9 || isset($this->Data['nif']) && !empty($this->Data['nif']) && strlen($this->Data['nif']) > 25):
            $this->Result = false;
            $this->Error  = ["Ops: introduza um NIF válido!", WS_ALERT];
        else:
            if(empty($this->Data['country']) || !isset($this->Data['country'])): $this->Data['country'] = "AO"; endif;
            if(empty($this->Data['city']) || !isset($this->Data['city'])): $this->Data['city'] = "Luanda"; endif;
            if(empty($this->Data['obs']) || !isset($this->Data['obs'])): unset($this->Data['obs']); endif;

            $this->UpdateFornecedores();
        endif;
    }

    private function UpdateFornecedores(){
        $Update = new Update();
        $Update->ExeUpdate(self::fornecedores, $this->Data, "WHERE id=:i AND id_db_settings=:y", "i={$this->postId}&y={$this->id_db_settings}");

        if($Update->getResult()):
            $this->Result = true;
            $this->Error  = ["Ficha de fornecedor atualizada com sucesso!", WS_ACCEPT];
        else:
            $this->Result = false;
            $this->Error  = ["Ops: aconteceu um erro inesperado ao atualizar a ficha de fornecedor!", WS_ERROR];
        endif;
    }

    public function CreateFabricante(array $data, $id_db_settings){
        $this->id_db_settings = (int) $id_db_settings;
        $this->Data = $data;

        if(empty($this->Data['name'])):
            $this->Error  = ["Ops: preencha o campo nome para prosseguir com o processo!", WS_ALERT];
            $this->Result = false;
        elseif(!isset($this->id_db_settings) || empty($this->id_db_settings)):
            $this->Error  = ["Ops: introduza o ID da empresa!", WS_ALERT];
            $this->Result = false;
        elseif(isset($this->Data['content']) && strlen($this->Data['content']) >= 500):
            $this->Result = false;
            $this->Error  = ["Ops: o campo descriação da fabricante tem que ter o máximo 499 caracteres!.", WS_ALERT];
        else:
            $Read = new Read();
            $Read->ExeRead(self::fabricante, "WHERE id_db_settings=:i AND name=:y", "i={$this->id_db_settings}&y={$this->Data['name']}");

            if($Read->getResult()):
                $this->Result = false;
                $this->Error  = ["Ops: o fabricante <strong>{$this->Data['name']}</strong> já encontra-se em uso no sistema!", WS_ALERT];
            else:
                $this->Data['id_db_settings'] = $this->id_db_settings;
                $this->Fabricante();
            endif;
        endif;
    }

    private function Fabricante(){
        $Create = new Create();
        $Create->ExeCreate(self::fabricante, $this->Data);

        if($Create->getResult()):
            $this->Result = true;
            $this->Error  = ["Fabricante adicionada com sucesso!", WS_ACCEPT];
        else:
            $this->Result = false;
            $this->Error  = ["Ops: aconteceu um erro inesperado ao adicionar o fabricante!", WS_ERROR];
        endif;
    }

    public function UpdateFabricante(array $data, $id_db_settings, $postId){
        $this->Data = $data;
        $this->id_db_settings = (int) $id_db_settings;
        $this->postId = (int) $postId;

        if(empty($this->Data['name'])):
            $this->Error  = ["Ops: preencha o campo nome para prosseguir com o processo!", WS_ALERT];
            $this->Result = false;
        elseif(isset($this->Data['content']) && strlen($this->Data['content']) >= 500):
            $this->Result = false;
            $this->Error  = ["Ops: o campo descriação da fabricante tem que ter o máximo 499 caracteres!.", WS_ALERT];
        else:
            $this->FabricanteUpdate();
        endif;
    }

    private function FabricanteUpdate(){
        $Update = new Update();
        $Update->ExeUpdate(self::fabricante, $this->Data, "WHERE id=:i AND id_db_settings=:y", "i={$this->postId}&y={$this->id_db_settings}");

        if($Update->getResult()):
            $this->Result = true;
            $this->Error  = ["Fabricante atualizado com sucesso!", WS_ACCEPT];
        else:
            $this->Result = false;
            $this->Error  = ["Ops: aconteceu um erro ao atualizar o fabricante", WS_ERROR];
        endif;
    }

    public function DeleteFabricante($postId){
        $this->postId = (int) $postId;

        $Read = new Read();
        $Read->ExeRead(self::veiculos, "WHERE id_fabricante=:i", "i={$this->postId}");

        if($Read->getResult()):
            $this->Result = false;
            $this->Error  = ["Ops: não conseguimos deletar o fabricante porque encontra-se associada a um documento comercial.", WS_ERROR];
        else:
            $Delete = new Delete();
            $Delete->ExeDelete(self::fabricante, "WHERE id=:y", "y={$this->postId}");

            if($Delete->getResult() || $Delete->getRowCount()):
                $this->Result = true;
                $this->Error  = ["Fabricante deletado com sucesso!", WS_ACCEPT];
            else:
                $this->Error  = ["Ops: aconteceu um erro inesperado ao deletar o fabricante!", WS_ERROR];
                $this->Result = false;
            endif;
        endif;
    }

    public function Veiculo(array $data, $id_db_settings){
        $this->id_db_settings = (int) $id_db_settings;
        $this->Data = $data;

        if(empty($this->Data['veiculo']) || empty($this->Data['id_cliente']) || empty($this->Data['placa']) || empty($this->Data['modelo']) || empty($this->Data['km_atual'])):
            $this->Result = false;
            $this->Error  = ["Ops: preecha os campos <strong>Veiculo, Placa, Modelo, Cliente, Kilometragem & Data de entrada</strong> para prosseguir com o processo!", WS_ALERT];
        elseif(isset($this->Data['content']) && strlen($this->Data['content']) > 2999):
            $this->Result = false;
            $this->Error  = ["Ops: o campo descrição do item deve conter no máximo 2999 caractéres!", WS_INFOR];
        else:
            if(isset($this->Data['id_fabricante']) && $this->Data['id_fabricante'] == ""):unset($this->Data['id_fabricante']); endif;

            $Read = new Read();
            $Read->ExeRead(self::veiculos, "WHERE id_db_settings=:y AND placa=:i", "y={$this->id_db_settings}&i={$this->Data['placa']}");

            if($Read->getResult()):
                $this->Result = false;
                $this->Error  = ["Ops: o veiculo com a placa <strong>{$this->Data['placa']}</strong>, já encontra-se em uso no sistema!", WS_INFOR];
            else:
                $this->Data['id_db_settings'] = $this->id_db_settings;
                $this->Data['dia'] = date('d');
                $this->Data['mes'] = date('m');
                $this->Data['ano'] = date('Y');
                $this->Data['data_registro'] = date('d-m-Y H:i:s');
                $this->CreateVeiculo();
            endif;
        endif;
    }

    private function CreateVeiculo(){
        $Create = new Create();
        $Create->ExeCreate(self::veiculos, $this->Data);

        if($Create->getResult()):
            $this->Result = true;
            $this->Error  = ["O Veiculo <strong>{$this->Data['veiculo']}</strong> registrado com sucesso!", WS_ACCEPT];
        else:
            $this->Result = false;
            $this->Error  = ["Ops: aconteceu um erro inesperado ao registrar o veiculo <strong>{$this->Data['veiculo']}</strong>!", WS_ERROR];
        endif;
    }

    public function UpdateVeiculo(array $data, $id_db_settings, $postId){
        $this->Data = $data;
        $this->postId = (int) $postId;
        $this->id_db_settings = (int) $id_db_settings;

        if(empty($this->Data['veiculo']) || empty($this->Data['id_cliente']) || empty($this->Data['placa']) || empty($this->Data['modelo']) || empty($this->Data['km_atual'])):
            $this->Result = false;
            $this->Error  = ["Ops: preecha os campos <strong>Veiculo, Placa, Modelo, Cliente, Kilometragem & Data de entrada</strong> para prosseguir com o processo!", WS_ALERT];
        elseif(isset($this->Data['content']) && strlen($this->Data['content']) > 2999):
            $this->Result = false;
            $this->Error  = ["Ops: o campo descrição do item deve conter no máximo 2999 caractéres!", WS_INFOR];
        else:
            if(isset($this->Data['id_fabricante']) && $this->Data['id_fabricante'] == ""):unset($this->Data['id_fabricante']); endif;
            $this->VeiculoUpdate();
        endif;
    }

    private function VeiculoUpdate(){
        $Update = new Update();
        $Update->ExeUpdate(self::veiculos, $this->Data, "WHERE id=:i AND id_db_settings=:y", "i={$this->postId}&y={$this->id_db_settings}");

        if($Update->getResult()):
            $this->Result = true;
            $this->Error  = ["Veiculo <strong>{$this->Data['veiculo']}</strong>, foi atualizado com sucesso!", WS_ACCEPT];
        else:
            $this->Result = false;
            $this->Error  = ["Ops: aconteceu um erro inesperado ao atualizar o veiculo  <strong>{$this->Data['veiculo']}</strong>!...", WS_ERROR];
        endif;
    }

    public function DeleteVeiculo($postId){
        $this->postId = (int) $postId;

        $Delete = new Delete();
        $Delete->ExeDelete(self::veiculos, "WHERE id=:y", "y={$this->postId}");

        if($Delete->getResult() || $Delete->getRowCount()):
            $this->Result = true;
            $this->Error  = ["Veiculo deletado com sucesso!", WS_ACCEPT];
        else:
            $this->Error  = ["Ops: aconteceu um erro inesperado ao deletar o veiculo!", WS_ERROR];
            $this->Result = false;
        endif;
    }

    public function DeleteFornecedores($postId){
        $this->postId = (int) $postId;

        $Delete = new Delete();
        $Delete->ExeDelete(self::fornecedores, "WHERE id=:y", "y={$this->postId}");

        if($Delete->getResult() || $Delete->getRowCount()):
            $this->Result = true;
            $this->Error  = ["Fornecedor deletado com sucesso!", WS_ACCEPT];
        else:
            $this->Error  = ["Ops: aconteceu um erro inesperado ao deletar o veiculo!", WS_ERROR];
            $this->Result = false;
        endif;
    }
}
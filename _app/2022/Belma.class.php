<?php
class Belma{
    private $Data, $Error, $Result,  $id_user, $id_db_settings, $logotype, $postId;
    const system  = "db_settings", type = "p_type", patrimonio = "p_table", atribuicoes = "p_atribuicoes", local = "p_local", funcionario = "p_funcionario";

    public function getResult(){return $this->Result;}
    public function getError(){return $this->Error;}

    public function OperacaoPatrimonial($data, $id_db_settings, $id_user){
        $this->Data = $data;
        $this->id_db_settings = (int) strip_tags(trim($id_db_settings));
        $this->id_user = (int) strip_tags(trim($id_user));

        if(in_array("", $this->Data)):
            $this->Error = ["Opsss: preencha todos os campos para prosseguir com o processo!", WS_INFOR];
            $this->Result = false;
        else:
            $status = 1;

            $Read = new Read();
            $Read->ExeRead(self::atribuicoes, "WHERE id_db_settings=:a1 AND id_table=:a2 AND id_funcionario=:a3 AND status=:a4", "a1={$this->id_db_settings}&a2={$this->Data['id_table']}&a3={$this->Data['id_funcionario']}&a4={$status}");

            if($Read->getResult()):
                $this->Result = false;
                $this->Error = ["Opsss: o patrimonio selecionado, já encontra-se atribuido!", WS_ALERT];
            else:
                $this->Data['data'] = date('d-m-Y');
                $this->Data['hora'] = date('H:i:s');
                $this->Data['session_id'] = $id_user;
                $this->Data['status'] = 1;

                $this->Create(self::atribuicoes, $this->Data, $id_db_settings);
            endif;
        endif;
    }

    public function Type($data, $id_db_settings){
        $this->Data = $data;
        $this->id_db_settings = (int) strip_tags(trim($id_db_settings));

        if(in_array("", $this->Data)):
            $this->Error = ["Opsss: preencha todos os campos para prosseguir com o processo!", WS_INFOR];
            $this->Result = false;
        else:
            $Read = new Read();
            $Read->ExeRead(self::type, "WHERE nome=:i AND id_db_settings=:i2", "i={$this->Data['nome']}&i2={$this->id_db_settings}");
            if($Read->getResult()):
                $this->Result = false;
                $this->Error = ["Opsss: o tipo de patrimonio: <strong>{$Read->getResult()[0]['nome']}</strong>, já encontra-se registrado!", WS_ALERT];
            else:
                $this->Create(self::type, $this->Data, $id_db_settings);
            endif;
        endif;
    }

    public function Local($data, $id_db_settings){
        $this->Data = $data;
        $this->id_db_settings = (int) strip_tags(trim($id_db_settings));

        if(in_array("", $this->Data)):
            $this->Error = ["Opsss: preencha todos os campos para prosseguir com o processo!", WS_INFOR];
            $this->Result = false;
        else:
            $Read = new Read();
            $Read->ExeRead(self::local, "WHERE nome=:i AND id_db_settings=:i2", "i={$this->Data['nome']}&i2={$this->id_db_settings}");
            if($Read->getResult()):
                $this->Result = false;
                $this->Error = ["Opsss: o Local: <strong>{$Read->getResult()[0]['nome']}</strong>, já encontra-se registrado!", WS_ALERT];
            else:
                $this->Create(self::local, $this->Data, $id_db_settings);
            endif;
        endif;
    }

    public function Patrimonio($data, $id_db_settings){
        $this->Data = $data;
        $this->id_db_settings = (int) strip_tags(trim($id_db_settings));

        if(in_array("", $this->Data)):
            $this->Error = ["Opsss: preencha todos os campos para prosseguir com o processo!", WS_INFOR];
            $this->Result = false;
        elseif(!is_numeric($this->Data['preco'])):
            $this->Error = ["Opsss: o preço tem de ser do tipo númerico, sem espaços e virgulas!", WS_ALERT];
            $this->Result = false;
        else:
            $Read = new Read();
            $Read->ExeRead(self::patrimonio, "WHERE nome=:i AND id_db_settings=:i2", "i={$this->Data['nome']}&i2={$this->id_db_settings}");
            if($Read->getResult()):
                $this->Result = false;
                $this->Error = ["Opsss: o patrimonio: <strong>{$Read->getResult()[0]['nome']}</strong>, já encontra-se registrado!", WS_ALERT];
            else:
                $this->Data['data'] = date('d-m-Y');
                $this->Data['hora'] = date('H:i:s');
                $this->Data['status'] = 1;
                $this->Create(self::patrimonio, $this->Data, $id_db_settings);
            endif;
        endif;
    }

    public function Funcionario($data, $id_db_settings){
        $this->Data = $data;
        $this->id_db_settings = (int) strip_tags(trim($id_db_settings));

        if(in_array("", $this->Data)):
            $this->Error = ["Opsss: preencha todos os campos para prosseguir com o processo!", WS_INFOR];
            $this->Result = false;
        elseif(strlen($this->Data['bi']) < 9 || strlen($this->Data['bi']) > 25):
            $this->Error = ["Opsss: Introduza um NIF ou B.I válido!", WS_ALERT];
            $this->Result = false;
        elseif(!is_numeric($this->Data['telefone'])):
            $this->Error = ["Opsss: os terminais telefonicos apenas devem ser preenchidos com números!", WS_INFOR];
            $this->Result = false;
        elseif(strlen($this->Data['telefone']) < 9 || strlen($this->Data['telefone']) > 14):
            $this->Error = ["Opsss: Introduza um número de telefone válido!", WS_ALERT];
            $this->Result = false;
        elseif(!Check::Email($this->Data['email'])):
            $this->Error = ["Opsss: o endereço de email {$this->Data['email']} não é válido!", WS_ALERT];
            $this->Result = false;
        else:
            $Read = new Read();
            $Read->ExeRead(self::funcionario, "WHERE bi=:i AND id_db_settings=:i2", "i={$this->Data['bi']}&i2={$this->id_db_settings}");
            if($Read->getResult()):
                $this->Result = false;
                $this->Error = ["Opsss: o patrimonio: <strong>{$Read->getResult()[0]['nome']}</strong>, já encontra-se registrado!", WS_ALERT];
            else:
                $this->Create(self::funcionario, $this->Data, $id_db_settings);
            endif;
        endif;
    }

    private function Create($table, $data, $id_db_settings){
        $love = $data;
        $love['id_db_settings'] = $id_db_settings;
        if($table == "p_atribuicoes"): unset($love['nome']); endif;

        $Create = new Create();
        $Create->ExeCreate($table, $love);

        if($Create->getResult()):
            if($table == "p_atribuicoes"): $love['nome'] = "Operação"; endif;
            if(!isset($love['nome']) || empty($love['nome']) || $love['nome'] == null): $love['nome'] = "Operação"; endif;

            $this->Error = ["<strong>{$love['nome']}</strong>, foi registrado com sucesso!", WS_ACCEPT];
            $this->Result = false;
        else:
            $this->Result = false;
            $this->Error = ["Opsss: aconteceu um erro inesperado ao registrar <strong>{$love['nome']}</strong>, atualize a página e tente novamente!", WS_ERROR];
        endif;
    }

    public function DeletePatrimonio($postId){
        $this->postId = (int) strip_tags(trim($postId));

        $Read = new Read();
        $Read->ExeRead(self::atribuicoes, "WHERE id_table=:i", "i={$this->postId}");

        if($Read->getResult()):
            $Read->ExeRead(self::patrimonio, "WHERE id=:i", "i={$this->postId}");
            if($Read->getResult()):
                $this->Result = false;
                $this->Error = ["Opsss: não foi possivel Deletar o Patrimonio, porque já encontra-se atribuido!", WS_ALERT];
            else:
                $this->Error = ["Opsss: aconteceu um erro inesperado ao deletar o Patrimonio, atualize a página e tente novamente!", WS_ALERT];
                $this->Result = false;
            endif;
        else:
            $Delete = new Delete();
            $Delete->ExeDelete(self::patrimonio, "WHERE id=:y", "y={$this->postId}");

            if($Delete->getResult() || $Delete->getRowCount()):
                $this->Result = true;
                $this->Error  = ["Patrimonio deletado com sucesso!", WS_ACCEPT];
            else:
                $this->Error  = ["Ops: aconteceu um erro inesperado ao deletar o Patrimonio!", WS_ERROR];
                $this->Result = false;
            endif;
        endif;
    }

    public function DeleteFuncionario($postId){
        $this->postId = (int) strip_tags(trim($postId));

        $Read = new Read();
        $Read->ExeRead(self::atribuicoes, "WHERE id_funcionario=:i", "i={$this->postId}");

        if($Read->getResult()):
            $Read->ExeRead(self::funcionario, "WHERE id=:i", "i={$this->postId}");
            if($Read->getResult()):
                $this->Result = false;
                $this->Error = ["Opsss: não foi possivel Deletar o Funcionário: <strong>{$Read->getResult()[0]['name']}</strong>, porque encontra-se com um meio atribuido!", WS_ALERT];
            else:
                $this->Error = ["Opsss: aconteceu um erro inesperado ao deletar o Funcionário, atualize a página e tente novamente!", WS_ALERT];
                $this->Result = false;
            endif;
        else:
            $Delete = new Delete();
            $Delete->ExeDelete(self::funcionario, "WHERE id=:y", "y={$this->postId}");

            if($Delete->getResult() || $Delete->getRowCount()):
                $this->Result = true;
                $this->Error  = ["Funcionário deletado com sucesso!", WS_ACCEPT];
            else:
                $this->Error  = ["Ops: aconteceu um erro inesperado ao deletar o Funcionário!", WS_ERROR];
                $this->Result = false;
            endif;
        endif;
    }

    public function DeleteTipoPatrimonio($postId){
        $this->postId = (int) $postId;

        $Delete = new Delete();
        $Delete->ExeDelete(self::type, "WHERE id=:y", "y={$this->postId}");

        if($Delete->getResult() || $Delete->getRowCount()):
            $this->Result = true;
            $this->Error  = ["Tipo de patrimonio deletado com sucesso!", WS_ACCEPT];
        else:
            $this->Error  = ["Ops: aconteceu um erro inesperado ao deletar o tipo de patrimonio!", WS_ERROR];
            $this->Result = false;
        endif;
    }

    public function UpdateType(array $data, $id_db_settings, $postId){
        $this->Data = $data;
        $this->postId = (int) $postId;
        $this->id_db_settings = (int) $id_db_settings;

        if(empty($this->Data['nome']) || empty($this->Data['descricao'])):
            $this->Result = false;
            $this->Error  = ["Ops: preecha os campos <strong>todos</strong> para prosseguir com o processo!", WS_ALERT];
        else:
            $this->TypeUpdate();
        endif;
    }

    public function UpdatePatrimonio($data, $id_db_settings, $postId){
        $this->Data = $data;
        $this->postId = (int) $postId;
        $this->id_db_settings = (int) $id_db_settings;

        if(in_array("", $this->Data)):
            $this->Error = ["Opsss: preencha todos os campos para prosseguir com o processo!", WS_INFOR];
            $this->Result = false;
        elseif(!is_numeric($this->Data['preco'])):
            $this->Error = ["Opsss: o preço tem de ser do tipo númerico, sem espaços e virgulas!", WS_ALERT];
            $this->Result = false;
        else:
            $this->PatrimonioUpdate();
        endif;
    }

    private function PatrimonioUpdate(){
        $Update = new Update();
        $Update->ExeUpdate(self::patrimonio, $this->Data, "WHERE id=:i AND id_db_settings=:y", "i={$this->postId}&y={$this->id_db_settings}");

        if($Update->getResult()):
            $this->Result = true;
            $this->Error  = ["Patrimonio <strong>{$this->Data['nome']}</strong>, foi atualizado com sucesso!", WS_ACCEPT];
        else:
            $this->Result = false;
            $this->Error  = ["Ops: aconteceu um erro inesperado ao atualizar o Patrimonio  <strong>{$this->Data['nome']}</strong>!...", WS_ERROR];
        endif;
    }

    private function TypeUpdate(){
        $Update = new Update();
        $Update->ExeUpdate(self::type, $this->Data, "WHERE id=:i AND id_db_settings=:y", "i={$this->postId}&y={$this->id_db_settings}");

        if($Update->getResult()):
            $this->Result = true;
            $this->Error  = ["Tipo de Patrimonio <strong>{$this->Data['nome']}</strong>, foi atualizado com sucesso!", WS_ACCEPT];
        else:
            $this->Result = false;
            $this->Error  = ["Ops: aconteceu um erro inesperado ao atualizar o Tipo de Patrimonio  <strong>{$this->Data['nome']}</strong>!...", WS_ERROR];
        endif;
    }

    public function UpdateLocal($data, $id_db_settings, $postId){
        $this->Data = $data;
        $this->postId = (int) $postId;
        $this->id_db_settings = (int) $id_db_settings;

        if(in_array("", $this->Data)):
            $this->Error = ["Opsss: preencha todos os campos para prosseguir com o processo!", WS_INFOR];
            $this->Result = false;
        else:
            $this->LocalUpdate();
        endif;
    }

    private function LocalUpdate(){
        $Update = new Update();
        $Update->ExeUpdate(self::local, $this->Data, "WHERE id=:i AND id_db_settings=:y", "i={$this->postId}&y={$this->id_db_settings}");

        if($Update->getResult()):
            $this->Result = true;
            $this->Error  = ["Local <strong>{$this->Data['nome']}</strong>, foi atualizado com sucesso!", WS_ACCEPT];
        else:
            $this->Result = false;
            $this->Error  = ["Ops: aconteceu um erro inesperado ao atualizar o Local  <strong>{$this->Data['nome']}</strong>!...", WS_ERROR];
        endif;
    }

    public function UpdateFuncionario($data, $id_db_settings, $postId){
        $this->Data = $data;
        $this->postId = (int) $postId;
        $this->id_db_settings = (int) $id_db_settings;

        if(in_array("", $this->Data)):
            $this->Error = ["Opsss: preencha todos os campos para prosseguir com o processo!", WS_INFOR];
            $this->Result = false;
        elseif(strlen($this->Data['bi']) < 9 || strlen($this->Data['bi']) > 25):
            $this->Error = ["Opsss: Introduza um NIF ou B.I válido!", WS_ALERT];
            $this->Result = false;
        elseif(!is_numeric($this->Data['telefone'])):
            $this->Error = ["Opsss: os terminais telefonicos apenas devem ser preenchidos com números!", WS_INFOR];
            $this->Result = false;
        elseif(strlen($this->Data['telefone']) < 9 || strlen($this->Data['telefone']) > 14):
            $this->Error = ["Opsss: Introduza um número de telefone válido!", WS_ALERT];
            $this->Result = false;
        elseif(!Check::Email($this->Data['email'])):
            $this->Error = ["Opsss: o endereço de email {$this->Data['email']} não é válido!", WS_ALERT];
            $this->Result = false;
        else:
            $this->FuncionarioUpdate();
        endif;
    }

    private function FuncionarioUpdate(){
        $Update = new Update();
        $Update->ExeUpdate(self::funcionario, $this->Data, "WHERE id=:i AND id_db_settings=:y", "i={$this->postId}&y={$this->id_db_settings}");

        if($Update->getResult()):
            $this->Result = true;
            $this->Error  = ["A ficha do Funcionário: <strong>{$this->Data['nome']}</strong>, foi atualizado com sucesso!", WS_ACCEPT];
        else:
            $this->Result = false;
            $this->Error  = ["Ops: aconteceu um erro inesperado ao atualizar a ficha do Funcionário:  <strong>{$this->Data['nome']}</strong>!...", WS_ERROR];
        endif;
    }

    public function OperacaoPatrimonialSatus($data, $id_db_settings, $postId){
        $this->Data = $data;
        $this->postId = (int) $postId;
        $this->id_db_settings = (int) $id_db_settings;

        if(in_array("", $this->Data)):
            $this->Error = ["Opsss: preencha todos os campos para prosseguir com o processo!", WS_INFOR];
            $this->Result = false;
        else:
            $this->OperacaoPatrimonialSatusUpdate();
        endif;
    }

    private function OperacaoPatrimonialSatusUpdate(){
        $Update = new Update();
        $Update->ExeUpdate(self::atribuicoes, $this->Data, "WHERE id=:i AND id_db_settings=:y", "i={$this->postId}&y={$this->id_db_settings}");

        if($Update->getResult()):
            $this->Result = true;
            $this->Error  = ["Atribuição de meios, foi atualizado com sucesso!", WS_ACCEPT];
        else:
            $this->Result = false;
            $this->Error  = ["Ops: aconteceu um erro inesperado ao atualizar o documento de atribuição de meios!...", WS_ERROR];
        endif;
    }
}
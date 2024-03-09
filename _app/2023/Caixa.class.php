<?php
class Caixa{
    private $Dados, $Result, $Error, $Data, $id_db_settings, $postId, $id_user;
    const
        caixa = "av_caixa",
        entrada_e_saida = "av_entrada_e_saida";

    public function getResult(){
        return $this->Result;
    }

    public function getError(){
        return $this->Error;
    }

    public function Sangrar($Data, $id_db_settings, $id_user){
        $this->Data = $Data;
        $this->id_db_settings = strip_tags(trim(abs($id_db_settings)));
        $this->id_user = strip_tags(trim(abs($id_user)));

        unset($this->Data['SendPostFormL']);


        if(in_array("", $this->Data)):
            $this->Result = false;
            $this->Error = ["Preencha todos os campos para finalizar o processo!", WS_ALERT];
        elseif(isset($this->Data['valor']) && !is_numeric($this->Data['valor']) || isset($this->Data['valor']) && !abs($this->Data['valor'])):
            $this->Error = ["Introduza valores válido para finalizar o processo!", WS_INFOR];
            $this->Result = false;
        else:
            $this->Data['dia'] = date('d');
            $this->Data['mes'] = date('m');
            $this->Data['ano'] = date('Y');
            $this->Data['hora'] = date('H:i');
            $this->Data['id_db_settings'] = $this->id_db_settings;
            $this->Data['id_user'] = $this->id_user;
            $this->Data['status'] = 1;

            $this->SalveCaixa();
        endif;
    }

    private function SalveCaixa(){
        $Create = new Create;
        $Create->ExeCreate(self::caixa, $this->Data);

        if($Create->getResult()):
            $this->Error = ["Saída de Caixa executada com sucesso!", WS_ACCEPT];
            $this->Result = true;
        else:
            $this->Error = ["Aconteceu um erro ao executar a saída de caixa, atualize a página e tente novamente!", WS_ERROR];
            $this->Result = false;
        endif;
    }

    public function Entrada_E_Saida($ClienteData, $id_db_settings, $id_user){
        $this->Data = $ClienteData;
        $this->id_db_settings = strip_tags(trim(abs($id_db_settings)));
        $this->id_user = strip_tags(trim(abs($id_user)));

        unset($this->Data['SendPostFormL']);

        if(in_array("", $this->Data)):
            $this->Result = false;
            $this->Error = ["Preencha todos os campos para finalizar o processo!", WS_ALERT];
        elseif(isset($this->Data['valor']) && !is_numeric($this->Data['valor']) || isset($this->Data['valor']) && !abs($this->Data['valor'])):
            $this->Error = ["Introduza valores válido para finalizar o processo!", WS_INFOR];
            $this->Result = false;
        else:
            $this->Data['dia'] = date('d');
            $this->Data['mes'] = date('m');
            $this->Data['ano'] = date('Y');
            $this->Data['hora'] = date('H:i');
            $this->Data['id_db_settings'] = $this->id_db_settings;
            $this->Data['id_user'] = $this->id_user;
            $this->Data['status'] = 1;

            $this->EntradaESaidaDeCaixa();
        endif;
    }

    private function EntradaESaidaDeCaixa(){
        $Create = new Create;
        $Create->ExeCreate(self::entrada_e_saida, $this->Data);

        if($Create->getResult()):
            $this->Error = ["Movimento de caixa executada com sucesso!", WS_ACCEPT];
            $this->Result = true;
        else:
            $this->Error = ["Aconteceu um erro ao executar o movimento de caixa, atualize a página e tente novamente!", WS_ERROR];
            $this->Result = false;
        endif;
    }
}
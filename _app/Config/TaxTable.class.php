<?php
/**
 * Created by PhpStorm.
 * User: Eliúdy Tomás
 * Date: 24/11/2019
 * Time: 17:50
 */

class TaxTable{

    private $Data, $TaxTable, $Result, $Error, $ID;
    const Entity = "db_taxtable";

    public function getResult(){
        return $this->Result;
    }

    public function getError(){
        return $this->Error;
    }

    public function ExeCreate(array $data, $id){
        $this->Data = $data;
        $this->ID = $id;

        if(!in_array('', $this->Data)):
            $this->CheckTaxTable();
            if($this->Result):
                $x = explode("-", $this->Data['TaxExemptionReason']);
                htmlspecialchars(trim($this->Data['TaxExemptionCode'] = $x[0]));
                htmlspecialchars(trim($this->Data['TaxExemptionReason'] = $x[1]));
                $this->Create();
            endif;
        elseif(strlen($this->Data['TaxCountryRegion']) > 2):
            $this->Error = ["Ops: a região de imposto tem que ter apenas 2 caractéres!", WS_ALERT];
            $this->Result = false;
        else:
            $this->Error = ["Opsss! Preencha todos os campos para prosseguir.", WS_ALERT];
            $this->Result = false;
        endif;
    }

    private function CheckTaxTable(){
        $Read = new Read();
        $Read->ExeRead(self::Entity, "WHERE id_db_settings=:i AND description=:desc AND taxCode=:cod ", "i={$this->ID}&desc={$this->Data['description']}&cod={$this->Data['taxCode']}");

        if($Read->getResult()):
            $this->TaxTable = $Read->getResult()[0];
            $this->Error = ["Oppsss! Já existe nos nossos registros o imposto: <b>{$this->TaxTable['description']}</b>, na categoria: <b>{$this->TaxTable['taxCode']}</b>", WS_INFOR];
            $this->Result = false;
        else:
            $this->Result = true;
        endif;
    }

    private function Create(){
        $Dados = [
            'id_db_settings' => $this->ID,
            'taxType' => $this->Data['taxType'],
            'taxCode' => $this->Data['taxCode'],
            'description' => $this->Data['description'],
            'taxPercentage' => $this->Data['taxPercentage'],
            'taxAmount' => $this->Data['taxAmount'],
            'TaxCountryRegion' => $this->Data['TaxCountryRegion'],
            'TaxExemptionReason' => $this->Data['TaxExemptionReason'],
            'TaxExemptionCode' => $this->Data['TaxExemptionCode']
        ];

        $Create = new Create();
        $Create->ExeCreate(self::Entity, $Dados);

        if($Create->getResult()):
            $this->Error = ["Operação realizada com sucesso!", WS_ACCEPT];
            $this->Result = true;
        else:
            $this->Error = ["Oppsss! Aconteceu um erro ao finalizar o processo!", WS_ERROR];
            $this->Result = false;
        endif;
    }

    /** @var Update */
    public function ExeUpdate($id, array $data, $idd){
        $this->TaxTable = $id;
        $this->Data = $data;
        $this->ID = $idd;

        if(!in_array('', $this->Data)):
            $x = explode("-", $this->Data['TaxExemptionReason']);
            htmlspecialchars(trim($this->Data['TaxExemptionCode'] = $x[0]));
            Check::Name($this->Data['TaxExemptionCode']);
            htmlspecialchars(trim($this->Data['TaxExemptionReason'] = $x[1]));
            $this->Update();
        elseif(strlen($this->Data['TaxCountryRegion']) > 2):
            $this->Error = ["Ops: a região de imposto tem que ter apenas 2 caractéres!", WS_ALERT];
            $this->Result = false;
        else:
            $this->Error = ["Oppsss! Preencha todos os campos para prosseguir.", WS_ALERT];
            $this->Result = false;
        endif;
    }

    private function Update(){

        $Dados = [
            'taxType' => $this->Data['taxType'],
            'taxCode' => $this->Data['taxCode'],
            'description' => $this->Data['description'],
            'taxPercentage' => $this->Data['taxPercentage'],
            'taxAmount' => $this->Data['taxAmount'],
            'TaxCountryRegion' => $this->Data['TaxCountryRegion'],
            'TaxExemptionReason' => $this->Data['TaxExemptionReason'],
            'TaxExemptionCode' => $this->Data['TaxExemptionCode']
        ];

        $Update = new Update();
        $Update->ExeUpdate(self::Entity, $Dados, "WHERE taxtableEntry=:id AND id_db_settings=:i", "id={$this->TaxTable}&i={$this->ID}");

        if($Update->getResult()):
            $this->Error = ["Operação realizada com sucesso!", WS_ACCEPT];
            $this->Result = false;
        else:
            $this->Error = ["Oppsss! Aconteceu um erro ao finalizar o processo!", WS_ERROR];
            $this->Result = false;
        endif;
    }

    /** @var Delete; */
    public function ExeDelete($id){
        $this->TaxTable = $id;
        $this->Delete();
    }

    private function Delete(){
        $Delete = new Delete();
        $Delete->ExeDelete(self::Entity, "WHERE taxtableEntry=:id ", "id={$this->TaxTable}");

        if($Delete->getRowCount() || $Delete->getResult()):
            $this->Error  = ["Registro deletado com sucesso!", WS_INFOR];
            $this->Result = true;
        else:
            $this->Error  = ["Oppsss! Aconteceu um erro inesperado ao Deletar o arquivo", WS_ERROR];
            $this->Result = false;
        endif;
    }
}
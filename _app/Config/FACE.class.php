<?php
/**
 * Created by PhpStorm.
 * User: Kwanzar Soft
 * Date: 01/10/2020
 * Time: 23:47
 */

class FACE{
    private $Data, $Result, $Error, $Info, $Number, $Face;

    const
        ec_face    = "ec_face",
        ec_saldos  = "ec_saldos";

    /**
     * @return mixed
     */
    public function getResult(){return $this->Result;}

    /**
     * @return mixed
     */
    public function getError(){return $this->Error;}

    /**
     * @param $t
     * @param $value
     */
    public function Operation($t, $value){
        $this->Info   = $t;
        $this->Number = $value;

        if(empty($this->Info) && empty($this->Number)):
            $this->Error  = ["Ops: preencha correctamente todos os campos, para prosseguir com a operação!", WS_INFOR];
            $this->Result = false;
        elseif(!is_numeric($this->Number)):
            $this->Error  = ["Ops: O <strong>Valor</strong>, tem que ser do tipo númerico e sem virgulas, obedecendo ao acordo ortográfico Americano!", WS_ALERT];
            $this->Result = false;
        elseif($this->Info != "ENTRADA" && $this->Info != "SAIDA" && $this->Info != "FACE"):
            $this->Error  = ["Ops: Tipo de operação não encontrada!", WS_ALERT];
            $this->Result = false;
        else:
            $this->ExeOperation();
        endif;
    }

    private function ExeOperation(){
        $this->Data['dia'] = date('d');
        $this->Data['mes'] = date('m');
        $this->Data['ano'] = date('Y');
        $this->Data['hora'] = date('H:i:s');
        $this->Data['t']   = $this->Info;
        $this->Data['value'] = $this->Number;

        $Create = new Create();
        $Create->ExeCreate(self::ec_face, $this->Data);

        if($Create->getResult()):
            $Read = new Read();
            $Read->ExeRead(self::ec_saldos);

            if($Read->getResult()):
                if($this->Info != "ENTRADA"):
                    $this->Face["ENTRADA"]       = $Read->getResult()[0]["ENTRADA"] - $this->Number;
                    $this->Face["{$this->Info}"] = $Read->getResult()[0]["{$this->Info}"] + $this->Number;
                else:
                    $this->Face["{$this->Info}"] = $Read->getResult()[0]["{$this->Info}"] + $this->Number;
                endif;

                $Update = new Update();
                $Update->ExeUpdate(self::ec_saldos, $this->Face, "WHERE id=:i", "i={$Read->getResult()[0]['id']}");

                if($Update->getResult()):
                    $this->Error  = ["Operação realizada com sucesso, <strong>{$this->Info}</strong>: <strong>{$this->Number}</strong>", WS_ACCEPT];
                    $this->Result = true;
                else:
                    $this->Error  = ["Ops: aconteceu um erro inesperado ao alterar o histórico da operação!", WS_ERROR];
                    $this->Result = false;
                endif;
            else:
                $this->Face["{$this->Info}"] = $this->Number;

                $Create->ExeCreate(self::ec_saldos, $this->Face);

                if($Create->getResult()):
                    $this->Error  = ["Operação realizada com sucesso, <strong>{$this->Info}</strong>: <strong>{$this->Number}</strong>", WS_ACCEPT];
                    $this->Result = true;
                else:
                    $this->Error  = ["Ops: aconteceu um erro inesperado ao salvar o histórico da operação!", WS_ERROR];
                    $this->Result = false;
                endif;
            endif;
        else:
            $this->Error  = ["Ops: aconteceu um erro inesperado ao salvar a operação!", WS_ERROR];
            $this->Result = false;
        endif;
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: Kwanzar Soft
 * Date: 14/06/2020
 * Time: 22:59
 */

class Purchase{
    private $Data, $Error, $Result, $Info, $id_db_settings, $id_product, $Session, $ID, $Alert, $Power;
    const
        cv_pedido_product = "cv_pedido_product",
        sd_purchase       = "sd_purchase",
        cv_product        = "cv_product",
        cv_supplier       = "cv_supplier",
        sd_purchase_story = "sd_purchase_story";

    public function getError(){return $this->Error;}
    public function getResult(){return $this->Result;}

    /**
     * @param array $data
     * @param $id_db_settings
     * @param null $session_id
     */
    public function ExePurchase(array $data, $id_db_settings, $session_id = null){
        $this->Data = $data;
        $this->id_db_settings = $id_db_settings;
        $this->Session = $session_id;

        //if(!empty($this->Data['id_product']) && !empty($this->Data['quantidade']) && !empty($this->Data['preco_compra']) && !empty($this->Data['unidade']) && !empty($this->Data['dateF']) && !empty($this->Data['dateEx'])):
            $this->CheckProduct();
            if($this->Result):
                //$this->CheckDataExpiraction();
                //if($this->Result):
                    $Read = new Read();
                    $Read->ExeRead(self::sd_purchase, "WHERE id_db_settings=:i AND id_product=:ip", "i={$this->id_db_settings}&ip={$this->id_product}");

                    if($Read->getResult()):
                        $this->Power = $Read->getResult()[0];
                        $this->Update();
                    else:
                        $this->Create();
                    endif;
               //endif;
            endif;
        /*else:
            $this->Error  = ["Ops: preencha os campos <strong>Produto, Quantidade, Unidade, Preço, Data de Fabrico e Data de Expiração</strong>, porque são de extrema importância; ", WS_INFOR];
            $this->Result = false;
        endif;*/
    }

    private function Update(){
        unset($this->Data['id_db_settings']);
        unset($this->Data['id_product']);
        $this->Data['quantidade'] = $this->Data['quantidade'] + $this->Power['quantidade'];


        $Update = new Update();
        $Update->ExeUpdate(self::sd_purchase, $this->Data, "WHERE id_db_settings=:i AND id_product=:ip", "i={$this->id_db_settings}&ip={$this->id_product}");

        if($Update->getResult()):
            $this->Error  = ["Operação realizada com sucesso! (1)", WS_ACCEPT];
            $this->Result = true;
        else:
            $this->Error  = ["Ops: aconteceu um erro inesperado ao dar entreda de estoque (1)", WS_ERROR];
            $this->Result = false;
        endif;
    }

    private function CheckProduct(){
        $t = "P";
        $this->id_product = $this->Data['id_product'];

        $Read = new Read();
        $Read->ExeRead(self::cv_product, "WHERE id=:i AND id_db_settings=:ip AND type=:t", "i={$this->id_product}&ip={$this->id_db_settings}&t={$t}");

        if($Read->getResult()):
            $this->Info   = $Read->getResult()[0];
            $this->Result = true;
        else:
            $this->Error  = ["Ops: não encontramos nenhum produto, atualize a página e tente novamente;", WS_INFOR];
            $this->Result = false;
        endif;
    }

    /**
     *
     */
    private function CheckDataExpiraction(){
        $d = explode("-", $this->Data['dateEx']);

        $l = $d[1] - date('m');

        if($d[0] >= date('Y')):
            if($d[0] > date('Y')):
                $this->Result = true;
            elseif($d[0] == date('Y')):
                if($d[1] >= date('m')):
                    if($l >= 3):
                        $this->Result = true;
                    else:
                        $this->Error  = ["Ops: não é permitido lançar no sistema produtos com a data expiração inferior a 3 meses de válidade; ", WS_INFOR];
                        $this->Result = false;
                    endif;
                else:
                    $this->Error  = ["Ops: não é permitido fazer o laçamento de produtos com a data de expiração vencida no sistema!", WS_ALERT];
                    $this->Result = false;
                endif;
            endif;
        elseif($d[0] < date('Y')):
            $this->Error  = ["Ops: não é permitido fazer o laçamento de produtos com a data de expiração vencida no sistema!", WS_ALERT];
            $this->Result = false;
        endif;
    }

    private function Create(){
        if(!isset($this->Data['id_supplier']) || empty($this->Data['id_supplier'])): $this->Data['id_supplier'] = null; endif;
        $this->Data['id_db_settings'] = $this->id_db_settings;
        $this->Data['session_id'] = $this->Session;
        $this->Data['dia'] = date('d');
        $this->Data['mes'] = date('m');
        $this->Data['ano'] = date('Y');
        $this->Data['status'] = 1;
        $this->Data['hora'] = date('H:i:s');

        $Create = new Create();
        $Create->ExeCreate(self::sd_purchase, $this->Data);

        if($Create->getResult()):
            $this->Error  = ["Operação realizada com sucesso!", WS_ACCEPT];
            $this->Result = true;
        else:
            $this->Error  = ["Ops: aconteceu um erro inesperado ao dar entreda de estoque", WS_ERROR];
            $this->Result = false;
        endif;
    }

    /**
     * @param array $data
     * @param $id
     * @param $id_db_settings
     * @param $session
     */
    public function TreePurchase(array $data, $id, $id_db_settings, $session){
        $this->Session = $session;
        $this->id_db_settings = $id_db_settings;
        $this->Data = $data;
        $this->ID = $id;

        $this->CheckPurchase();
        if($this->Result):
            $this->UpdatePurchase();
        endif;
    }

    public function ExeExport(array $data, $id, $id_db_settings, $session){
        $this->Session = $session;
        $this->id_db_settings = $id_db_settings;
        $this->Data = $data;
        $this->ID = $id;

        $this->CheckPurchase();
        if($this->Result):
            $this->Move();
            if($this->Result):
                $this->UpdatePurchase();
            endif;
        endif;
    }

    public function ExeExportTwo(array $data, $id, $id_db_settings, $session){
        $this->Session = $session;
        $this->id_db_settings = $id_db_settings;
        $this->Data = $data;
        $this->ID = $id;

        $this->CheckPurchase();
        if($this->Result):
            $this->Move();
            if($this->Result):
                $this->UpdatePurchase();
                if($this->Result):
                    $this->PProduct();
                endif;
            endif;
        endif;
    }

    private function PProduct(){
        $ipp = 1;

        $Read = new Read();
        $Read->ExeRead(self::cv_pedido_product, "WHERE id_db_settings=:i AND id_product=:ip AND status=:ipp ", "i={$this->id_db_settings}&ip={$this->Alert['id']}&ipp={$ipp}");

        if($Read->getResult()):
            $Data['status'] = 2;

            $Update = new Update();
            $Update->ExeUpdate(self::cv_pedido_product, $Data, "WHERE id_db_settings=:i AND id_product=:ip AND status=:ipp ", "i={$this->id_db_settings}&ip={$this->Alert['id']}&ipp={$ipp}");

            if($Update->getResult()):
                $this->Error  = ["Operação realizada com sucesso, o producto: <strong>{$this->Alert['product']}</strong> foi enviado pra loja com sucesso!", WS_ACCEPT];
                $this->Result = true;
            else:
                $this->Error  = ["Ops: aconteceu um erro ao atualizar a lista de productos!", WS_ERROR];
                $this->Result = false;
            endif;
        else:
            $this->Error  = ["Ops: não encontramos nenhum pedido em aberto!", WS_INFOR];
            $this->Result = false;
        endif;
    }

    private function CheckPurchase(){
        $Read = new Read();
        $Read->ExeRead(self::sd_purchase, "WHERE id=:i AND id_db_settings=:ip ", "i={$this->ID}&ip={$this->id_db_settings}");

        if($Read->getResult()):
            $this->Info = $Read->getResult()[0];

            if($this->Data['quantidade'] > $this->Info['quantidade']):
                $this->Error  = ["Ops: não existe quantidade suficiênte no estoque, por favor atualize a página e tente novamente!", WS_INFOR];
                $this->Result = false;
            else:
                $this->Result = true;
            endif;
        endif;
    }

    private function Move(){
        $Read = new Read();
        $Read->ExeRead(self::cv_product, "WHERE id=:i AND id_db_settings=:ip", "i={$this->Info['id_product']}&ip={$this->id_db_settings}");

        if($Read->getResult()):
            $this->Alert = $Read->getResult()[0];
            $Data['quantidade'] = $this->Data['quantidade'] + $this->Alert['quantidade'];
            $Data['unidades']   = ($this->Data['quantidade'] * $this->Data['unidade']) + $this->Alert['unidades'];

            $Update = new Update();
            $Update->ExeUpdate(self::cv_product, $Data, "WHERE id=:i AND id_db_settings=:ip", "i={$this->Info['id_product']}&ip={$this->id_db_settings}");

            if($Update->getResult()):
                $this->Result = true;
            else:
                $this->Error  = ["Ops: aconteceu um erro inesperado ao atualizar o produto; ", WS_ERROR];
                $this->Result = false;
            endif;
        endif;
    }

    private function UpdatePurchase(){
        if($this->Info['quantidade'] - $this->Data['quantidade'] <= 0): $Data['status'] = 0; endif;
        $Data['quantidade'] = $this->Info['quantidade'] - $this->Data['quantidade'];


        $Update = new Update();
        $Update->ExeUpdate(self::sd_purchase, $Data, "WHERE id=:i AND id_db_settings=:ip", "i={$this->ID}&ip={$this->id_db_settings}");

        if($Update->getResult()):
            $N['id_db_settings'] = $this->id_db_settings;
            $N['id_sd_purchase'] = $this->ID;
            $N['qtd'] = $this->Data['quantidade'];
            $N['unidades'] = $this->Data['unidade'];
            $N['type'] = "S";
            $N['date'] = date('Y-m-d');
            $N['session_id'] = $this->Session;

            $Create = new Create();
            $Create->ExeCreate(self::sd_purchase_story, $N);

            if($Create->getResult()):
                $this->Error  = ["Operação realizada com sucesso!", WS_ACCEPT];
                $this->Result = true;
            else:
                $this->Error  = ["Ops: aconteceu um erro inesperado ao salvar os dados, atualize a página e tente novamente; ", WS_INFOR];
                $this->Result = false;
            endif;
        else:
            $this->Error  = ["Ops: aconteceu um erro inesperado ao atualizar as informações", WS_ERROR];
            $this->Result = false;
        endif;
    }
}
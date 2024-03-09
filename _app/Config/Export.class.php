<?php
class Export{
    private $Data, $Error, $Result, $postId, $File;
    const
        produtos = "cv_product",
        clientes = "cv_customer";

    public function getResult(){return $this->Result;}
    public function getError(){return $this->Error;}

    public function Import($logotype, $ClienteData = null, $id_db_settings = null){
        $this->Data["type"] = strip_tags(trim($ClienteData["type"]));
        $this->postId = strip_tags(trim($id_db_settings));
        $this->File = $logotype;


    }

    public function Itens($postId){
        $this->postId = strip_tags(trim($postId));
        $this->File = "Produtos.csv";

        $Read = new Read();
        $Read->ExeRead(self::produtos, "WHERE id_db_settings=:i", "i={$this->postId}");
        if($Read->getResult()):
            foreach ($Read->getResult() as $key):
                $this->Data .= $key['codigo'].';'.$key['codigo_barras'].';'.$key['product'].';'.$key['preco_venda'].';'.$key['quantidade'].';'.$key['unidades'].';'.$key['type']."\n";
            endforeach;
        endif;

        header("Content-Description: PHP Generated Data");
        header("Content-Type: application/xml");
        header("Content-Disposition: attachment; filename=\"{$this->File}\"");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Pragma: no-cache");
        echo $this->Data;
        exit();
    }

    public function Clientes($postId){
        $this->postId = strip_tags(trim($postId));
        $this->File = "Clientes_".time().".csv";

        $Read = new Read();
        $Read->ExeRead(self::clientes, "WHERE id_db_settings=:i", "i={$this->postId}");
        if($Read->getResult()):
            foreach ($Read->getResult() as $key):
               $this->Data .= $key["nome"].';'.$key["nif"].';'.$key["email"].';'.$key["telefone"].';'.$key["endereco"]."\n";
            endforeach;
        endif;

        header("Content-Description: PHP Generated Data");
        header("Content-Type: application/xml");
        header("Content-Disposition: attachment; filename=\"{$this->File}\"");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Pragma: no-cache");
        echo $this->Data;
        exit();
    }
}
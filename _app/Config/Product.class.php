<?php
class Product{
    private $Product, $Cover, $Dados, $Result, $Error, $IDEmpresa, $Data, $ID, $File, $id_db_settings, $postId, $Shut_up;
    const
        gallery = "cv_gallery_product",
        stock = "cv_operation",
        import = "cv_product_import",
        Entity  = "cv_product";

    public function getResult(){
        return $this->Result;
    }

    public function getError(){
        return $this->Error;
    }

    public function ExeUpdateCambio($id_db_settings){
        $this->id_db_settings = strip_tags(trim($id_db_settings));

        $taxa = (DBKwanzar::CheckConfig($id_db_settings)['cambio_atual'] * DBKwanzar::CheckConfig($id_db_settings)['porcentagem_x_cambio'] / 100);

        $Read = new Read();
        $Read->ExeRead(self::Entity, "WHERE id_db_settings=:id ", "id={$this->id_db_settings}");

        if($Read->getResult()):
            foreach ($Read->getResult() as $key):
                if(empty($key['custo_compra'])):
                    $this->Data['preco_venda'] = $taxa * 2;
                else:
                    $this->Data['preco_venda'] = ($key['custo_compra'] + ($key['custo_compra'] * $key['PorcentagemP']) / 100) + $taxa;
                endif;

                if($key['preco_venda'] != $this->Data['preco_venda']):
                    $this->ID = $key['id'];
                    $this->UpdateCambio();
                else:
                    $this->Result = true;
                endif;
            endforeach;
        else:
            $this->Result = true;
        endif;
    }

    public function ExeUpdateCambioII($id_db_settings){
        $this->id_db_settings = strip_tags(trim($id_db_settings));
        $Read = new Read();
        $Read->ExeRead(self::Entity, "WHERE id_db_settings=:id ", "id={$this->id_db_settings}");

        if($Read->getResult()):
            foreach ($Read->getResult() as $key):
                if(!empty($key['custo_compra'])):
                    $this->Data['preco_venda'] = ($key['custo_compra'] + ($key['custo_compra'] * $key['PorcentagemP']) / 100);
                else:
                    $this->Data['preco_venda'] = $key['preco_venda'];
                endif;

                if($key['preco_venda'] != $this->Data['preco_venda']):
                    $this->ID = $key['id'];
                    $this->UpdateCambio();
                else:
                    $this->Result = true;
                endif;
            endforeach;
        else:
            $this->Result = true;
        endif;
    }

    private function UpdateCambio(){
        $Update = new Update();
        $Update->ExeUpdate(self::Entity, $this->Data, "WHERE id=:J AND id_db_settings=:id", "J={$this->ID}&id={$this->id_db_settings}");

        if($Update->getResult()):
            $this->Error  = ["O Produto/Serviço foi atualizado com sucesso!", WS_ACCEPT];
            $this->Result = $Update->getResult();
        else:
            $this->Error  = ["Ops: aconteceu um erro inesperado ao editar o produto.", WS_ERROR];
            $this->Result = false;
        endif;
    }

    public function ExeStock(array $ClienteData, $id_db_settings, $postId, $id_user){
        $this->Dados = $ClienteData;
        $this->id_db_settings = $id_db_settings;
        $this->postId = $postId;
        $this->Dados['id_user'] = $id_user;

        unset($this->Dados['SendPostFormL']);
        unset($this->Dados['descricao']);

        if(empty($this->Dados['custo_compra'])): unset($this->Dados['custo_compra']); endif;

        if(in_array("", $this->Dados)):
            $this->Error = ["Ops: preencha todos os campos para prosseguir com o processo!", WS_ALERT];
            $this->Result = false;
        else:
            $this->Dados['descricao'] = $ClienteData['descricao'];
            if(!isset($this->Dados['custo_compra'])):  $this->Dados['custo_compra'] = 0; endif;

            $Read = new Read();
            $Read->ExeRead(self::Entity, "WHERE id_db_settings=:id AND id=:i", "id={$this->id_db_settings}&i={$this->postId}");
            if($Read->getResult()):
                $key = $Read->getResult()[0];
                if($key["unidades"] > $this->Dados['unidades']):
                    $this->Error = ["Ops: encontramos uma descrepancia, o carregamento passado indicava um numero maior de unidades;", WS_ALERT];
                    $this->Result = false;
                elseif($this->Dados["operacao"] != "Entrada"):
                    if($this->Dados["quantidade"] > $key["quantidade"]):
                        $this->Error = ["Ops: nāo existe quantidade suficiente em estoque para realizar a presente operaçāo!", WS_INFOR];
                        $this->Result = false;
                    else:
                        $this->DontGoYe();
                    endif;
                else:
                    $this->DontGoYe();
                endif;
            else:
                $this->Error = ["Ops: nāo encontramos o produto selecionado!", WS_ALERT];
                $this->Result = false;
            endif;
        endif;
    }

    private function DontGoYe(){
        if($this->Dados["operacao"] == "Entrada" && $this->Dados["natureza"] == "Envio ao Fronte" || $this->Dados["operacao"] == "Entrada" && $this->Dados["natureza"] == "Erro de regístro" || $this->Dados["operacao"] == "Entrada" && $this->Dados["natureza"] == "Produto danificado" || $this->Dados["operacao"] == "Entrada" && $this->Dados["natureza"] == "Produto caducado"):
            $this->Error = ["Ops: a operaçāo nāo condiz com a natureza!", WS_ALERT];
            $this->Result = false;
        elseif($this->Dados["operacao"] == "Saída" && $this->Dados["natureza"] == "Compra" || $this->Dados["operacao"] == "Rectificaçāo" && $this->Dados["natureza"] == "Compra"):
            $this->Error = ["Ops: a operaçāo nāo condiz com a natureza!", WS_ALERT];
            $this->Result = false;
        else:
            $Read = new Read();
            $Read->ExeRead(self::Entity, "WHERE id_db_settings=:id AND id=:i", "id={$this->id_db_settings}&i={$this->postId}");
            if($Read->getResult()):
                $key = $Read->getResult()[0];

                if($this->Dados["operacao"] == "Saída" && $this->Dados["natureza"] == "Envio ao Fronte" || $this->Dados["operacao"] == "Rectificaçāo" && $this->Dados["natureza"] == "Envio ao Fronte"):
                    $sum = ($this->Dados["quantidade"] * $this->Dados["unidades"]);
                    $this->Data["gQtd"] = $key["gQtd"] = $sum;
                    $this->Data["quantidade"] = $key["quantidade"] - $this->Dados["quantidade"];
                    $this->Dados["olds_unidades_loja"] = $key["gQtd"];
                elseif($this->Dados["operacao"] == "Entrada" && $this->Dados["natureza"] == "Compra"):
                    $this->Data["quantidade"] = $key["quantidade"] + $this->Dados["quantidade"];
                    $this->Data["unidades"] = $this->Dados["unidades"];
                    $this->Data["custo_compra"] = $this->Dados["custo_compra"];
                else:
                    $this->Data["quantidade"] = $key["quantidade"] - $this->Dados["quantidade"];
                endif;

                $this->Dados["olds_caixas"] = $key["quantidade"];
                $this->Dados["olds_unidades"] = $key["unidades"];
                $this->Dados["novas_caixas"] = $this->Dados["quantidade"];
                $this->Dados["novas_unidades"] = $this->Dados["unidades"];
                $this->Dados["status"] = 1;
                $this->Dados["data_emissao"] = date("d-m-Y H:i:s");
                $this->Dados['id_product'] = $this->postId;
                $this->Dados['id_db_settings'] = $this->id_db_settings;

                $Create = new Create();
                $Create->ExeCreate(self::stock, $this->Dados);

                if($Create->getResult()):
                    $Update = new Update();
                    $Update->ExeUpdate(self::Entity, $this->Data, "WHERE id_db_settings=:id AND id=:i", "id={$this->id_db_settings}&i={$this->postId}");
                    if($Update->getResult()):
                        $this->Error = ["Movimento de estoque efectuado com sucesso!", WS_ACCEPT];
                        $this->Result = true;
                    else:
                        $this->Result = false;
                        $this->Error = ["Ops: aconteceu um erro inesperado ao salvar o movimento de estoque!", WS_ERROR];
                    endif;
                else:
                    $this->Result = false;
                    $this->Error = ["Ops: aconteceu um erro inesperado ao fazer o movimento de estoque!", WS_ERROR];
                endif;
            endif;
        endif;
    }


    /**
     * @param array $Image
     * @param $data
     * @param $id
     * @param $id_db_settings
     */
    public function gbSend(array $Image, $data, $id, $id_db_settings){
        $this->File = $Image;
        $this->Data = $data;
        $this->ID = $id;
        $this->id_db_settings = $id_db_settings;

        $this->Data['time']           = time();
        $this->Data['id_cv_product']  = $this->ID;
        $this->Data['id_db_settings'] = $this->id_db_settings;

        unset($this->Data['SendPostForm']);
        //$this->Post = (int) $PostId;

        //$a = explode(".", $this->File);

        $ImageName = "br-br-br";

        $gbFiles = array();
        $gbCount = Count($this->File['tmp_name']);
        $gbKeys  = array_keys($this->File);
        for($gb = 0; $gb < $gbCount; $gb++):
            foreach($gbKeys as $Keys):
                $gbFiles[$gb][$Keys] = $this->File[$Keys][$gb];
            endforeach;
        endfor;

        $gbSend = new Upload('uploads/');

        $i = 0;
        $u = 0;

        foreach($gbFiles as $gbUpload):
            $i++;

            $format = array();
            $format['a'] = '\\|§$%&/()=?»£€{[]}´*+*ª^_.:-;,~´`áàâãéèêóòôõíìîúùûç';
            $format['b'] = '                                                    ';

            $ImgNames = strtr(utf8_decode($ImageName), $format['a'], $format['b']);

            $ImgNameL = "{$ImgNames}-gb-{$ImgNames}". (substr(md5(time() + $i), 0,5));
            $gbSend->Image($gbUpload, $ImgNameL, 0,'gallery');

            if($gbSend->getResult()):
                $gbImage = $gbSend->getResult();
                $this->Data['cover'] = $gbImage;
                /*$gbCreate = [
                    'title' => $ImageName,
                    'cover' => $gbImage,
                ];*/

                $insertGb = new Create;
                $insertGb->ExeCreate(self::gallery, $this->Data);
                $u++;
            endif;
        endforeach;

        if($u > 1):
            $this->Error = ["Galleria atualizada com sucesso, foram enviadas {$u} imagens para galeria.", WS_ACCEPT];
            $this->Result  = true;
        endif;

    }

    /**
     * @param $GbImageId
     */
    public function gbRemove($GbImageId) {
        $this->ID = (int) $GbImageId;
        $readGb = new Read;
        $readGb->ExeRead(self::gallery, "WHERE id = :gb", "gb={$this->ID}");
        if ($readGb->getResult()):
            $Imagem = './uploads/' . $readGb->getResult()[0]['cover'];

            if (file_exists($Imagem) && !is_dir($Imagem)):
                unlink($Imagem);
            endif;

            $Deleta = new Delete;
            $Deleta->ExeDelete(self::gallery, "WHERE id=:id", "id={$this->ID}");

            if ($Deleta->getResult() || $Deleta->getRowCount()):
                $this->Error  = ["A imagem foi removida com sucesso da galeria!", WS_ACCEPT];
                $this->Result = true;
            else:
                $this->Error  = ["Ops: aconteceu um erro inesperado ao deletar a imagem na galeria", WS_ERROR];
                $this->Result = false;
            endif;
        endif;
    }

    public function ExeCreate(array $Cover, array $Dados, $Id){
        $this->Cover     = $Cover;
        $this->Dados     = $Dados;
        $this->IDEmpresa = $Id;

        unset($this->Dados['SendPostFormL']);
        //unset($this->Dados['PorcentagemP']);

        $this->CheckProduct();

        if($this->Result):
            if(!in_array('', $this->Cover)):
                $this->SendLogotype();
            else:
                $this->Cover['logotype'] = '';
            endif;

            if(empty($this->Dados['product']) || empty($this->Dados['type']) || empty($this->Dados['iva']) || empty($this->Dados['preco_venda'])):
                $this->Error = ["Ops: Preencha os campos: Tipo de item, Descrição, Preço e Imposto para prosseguir com o processo.", WS_ALERT];
                $this->Result = false;
            elseif(isset($this->Dados['preco_venda']) && $this->Dados['preco_venda'] <= 0 || isset($this->Dados['preco_venda']) && !is_numeric($this->Dados['preco_venda'])):
                $this->Result = false;
                $this->Error  = ["Oops: não é permitido inserir preços negtivos!", WS_ERROR];
            elseif(isset($this->Dados['desconto']) && $this->Dados['desconto'] < 0 || isset($this->Dados['desconto']) && $this->Dados['desconto'] > 100):
                $this->Error = ["Preencha correctamente o campo <strong>Desconto</strong>, não é permitido valores abaixo de 0 ou maior que 100!", WS_ALERT];
                $this->Result = false;
            else:
                if(empty($this->Dados['id_category'])): $this->Dados['id_category'] = 0; endif;
                if(empty($this->Dados['id_marca'])): $this->Dados['id_marca'] = 0; endif;
                if(empty($this->Dados['codigo_barras'])): $this->Dados['codigo_barras'] = " "; endif;
                if(empty($this->Dados['remarks'])): $this->Dados['remarks'] = " "; endif;
                if(empty($this->Dados['Description'])): $this->Dados['Description'] = " "; endif;
                if(empty($this->Dados['custo_compra'])): $this->Dados['custo_compra'] = 0; endif;
                if(empty($this->Dados['PorcentagemP'])): $this->Dados['PorcentagemP'] = 0; endif;

                if(!isset(Strong::Config($this->IDEmpresa)['estoque_minimo']) || empty(Strong::Config($this->IDEmpresa)['estoque_minimo']) || Strong::Config($this->IDEmpresa)['estoque_minimo'] == null || Strong::Config($this->IDEmpresa)['estoque_minimo'] == ''):
                    $this->Dados['estoque_minimo'] = '0';
                else:
                    $this->Dados['estoque_minimo'] = Strong::Config($this->IDEmpresa)['estoque_minimo'];
                endif;

                $this->Create();
            endif;
        endif;
    }

    public function ExeUpdate($IdUser, array $Cover, array $Dados, $Id){
        $this->Cover = $Cover;
        $this->Dados = $Dados;
        $this->Product = $IdUser;
        $this->IDEmpresa = $Id;

        unset($this->Dados['SendPostFormL']);

        if(!in_array('', $this->Cover)):
            $this->SendLogotype();
        endif;

        if(empty($this->Dados['product']) || empty($this->Dados['codigo']) || empty($this->Dados['type']) || empty($this->Dados['unidade_medida']) || empty($this->Dados['iva']) || empty($this->Dados['preco_venda'])):
            $this->Error = ["Ops!!! Preencha todos campos para prosseguir com o processo.", WS_ALERT];
            $this->Result = false;
        elseif(isset($this->Dados['preco_venda']) && $this->Dados['preco_venda'] <= 0 || isset($this->Dados['preco_venda']) && !is_numeric($this->Dados['preco_venda'])):
            $this->Result = false;
            $this->Error  = ["Oops: não é permitido inserir preços negtivos!", WS_ERROR];
        elseif(isset($this->Dados['desconto']) && $this->Dados['desconto'] < 0 || isset($this->Dados['desconto']) && $this->Dados['desconto'] > 100):
            $this->Error = ["Preencha correctamente o campo <strong>Desconto</strong>, não é permitido valores abaixo de 0 ou maior que 100!", WS_ALERT];
            $this->Result = false;
        else:
            if(empty($this->Dados['id_category'])): $this->Dados['id_category'] = 0; endif;
            if(empty($this->Dados['id_marca'])): $this->Dados['id_marca'] = 0; endif;
            if(empty($this->Dados['codigo_barras'])): $this->Dados['codigo_barras'] = " "; endif;
            if(empty($this->Dados['remarks'])): $this->Dados['remarks'] = " "; endif;
            if(empty($this->Dados['Description'])): $this->Dados['Description'] = " "; endif;
            if(empty($this->Dados['local_product'])): $this->Dados['local_product'] = " "; endif;
            if(empty($this->Dados['custo_compra']) || !isset($this->Dados['custo_compra'])): $this->Dados['custo_compra'] = 0; endif;
            if(empty($this->Dados['PorcentagemP']) || !isset($this->Dados['PorcentagemP'])): $this->Dados['PorcentagemP'] = 0; endif;

            if(Strong::Config($this->IDEmpresa)['estoque_minimo'] == null || Strong::Config($this->IDEmpresa)['estoque_minimo'] == ''):
                $this->Dados['estoque_minimo'] = '0';
            else:
                $this->Dados['estoque_minimo'] = Strong::Config($this->IDEmpresa)['estoque_minimo'];
            endif;

            $this->Update();
        endif;
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
        $ReadCover->FullRead("SELECT cover FROM cv_product WHERE id=:id AND id_db_settings=:i", "id={$this->Product}&i={$this->IDEmpresa}");

        if($ReadCover->getRowCount()):
            $delCover = $ReadCover->getResult()[0]['cover'];
            if(file_exists("./uploads/{$delCover}") && !is_dir("./uploads/{$delCover}")):
                unlink("./uploads/{$delCover}");
            endif;
        endif;
    }

    private function CheckCustomer(){
        $ReadCheck = new Read;
        $ReadCheck->ExeRead(self::Entity, "WHERE id_db_settings=:id AND product=:Nc AND type=:Fc AND Description=:dd", "id={$this->IDEmpresa}&Nc={$this->Dados['product']}&Fc={$this->Dados['type']}&dd={$this->Dados['Description']}");

        if($ReadCheck->getResult()):
            $this->Product = $ReadCheck->getResult()[0]['id'];
            $this->Error = ["Oops! Cliente: <b>{$ReadCheck->getResult()[0]['product']} - {$ReadCheck->getResult()[0]['type']}</b>", WS_INFOR];
            $this->Result = false;
        else:
            $this->Result = true;
        endif;
    }

    private function CheckProduct(){
        $ReadCheck = new Read;
        $ReadCheck->ExeRead(self::Entity, "WHERE id_db_settings=:id AND product=:Nc AND type=:Fc AND Description=:dd", "id={$this->IDEmpresa}&Nc={$this->Dados['product']}&Fc={$this->Dados['type']}&dd={$this->Dados['Description']}");

        if($ReadCheck->getResult()):
            $this->Product = $ReadCheck->getResult()[0]['id'];
            $this->Error = ["O Item: <strong>{$ReadCheck->getResult()[0]['product']}</strong> do tipo <strong>{$ReadCheck->getResult()[0]['type']}</strong>, já encontra-se registrado!", WS_INFOR];
            $this->Result = false;
        else:
            $this->Result = true;
        endif;
    }

    private function Create(){
        $iva = explode(":", $this->Dados['iva']);
        $Dados = [
            'id_db_settings' => $this->IDEmpresa,
            'id_category' => $this->Dados['id_category'],
            'codigo' => $this->Dados['codigo'],
            'codigo_barras' => $this->Dados['codigo_barras'],
            'product' => $this->Dados['product'],
            'preco_venda' => $this->Dados['preco_venda'],
            'preco_venda_ii' => 0,
            'preco_promocao' => 0,
            'quantidade' => 0,
            'unidades' => 0,
            'iva' => $iva[0],
            'id_iva' => $iva[1],
            'unidade_medida' => $this->Dados['unidade_medida'],
            'estoque_minimo' => $this->Dados['estoque_minimo'],
            'type' => $this->Dados['type'],
            'peso_liquido' => '',
            'peso_bruto' => '',
            'cover' => $this->Cover['logotype'],
            'data_promocao' => '',
            'data_fim_promocao' => '',
            'status' => 3,
            'Description' => $this->Dados['Description'],
            'gQtd' => 0,
            'IE_commerce' => $this->Dados['IE_commerce'],
            'ILoja' => $this->Dados['ILoja']
        ];

        unset($this->Dados['iva']);
        $this->Dados['id_db_settings'] = $this->IDEmpresa;
        $this->Dados['cover'] = $this->Cover['logotype'];
        $this->Dados['iva'] = $iva[0];
        $this->Dados['id_iva'] = $iva[1];
        $this->Dados['status'] = 3;
        //$Dados['desconto'] = $this->Dados['desconto'];

        $Create = new Create;
        $Create->ExeCreate(self::Entity, $this->Dados);

        if($Create->getResult()):
            $this->Error = ["O Produto/Serviço <b>{$this->Dados['product']}</b> foi cadastrado com sucesso!", WS_ACCEPT];
            $this->Result = $Create->getResult();
        endif;
    }

    private function Update(){
        $iva = explode(":", $this->Dados['iva']);
        if($this->Cover['logotype'] != ''):
            $Dados = [
                'id_category' => $this->Dados['id_category'],
                'codigo' => $this->Dados['codigo'],
                'codigo_barras' => $this->Dados['codigo_barras'],
                'product' => $this->Dados['product'],
                'preco_venda' => $this->Dados['preco_venda'],
                'iva' => $iva[0],
                'id_iva' => $iva[1],
                'unidade_medida' => $this->Dados['unidade_medida'],
                'estoque_minimo' => $this->Dados['estoque_minimo'],
                'type' => $this->Dados['type'],
                'cover' => $this->Cover['logotype'],
                'Description' => $this->Dados['Description'],
                'local_product' => $this->Dados['local_product'],
                'IE_commerce' => $this->Dados['IE_commerce'],
                'ILoja' => $this->Dados['ILoja'],
                'remarks' => $this->Dados['remarks'],
                'id_marca' => $this->Dados['id_marca']
            ];
        else:
            $Dados = [
                'id_category' => $this->Dados['id_category'],
                'codigo' => $this->Dados['codigo'],
                'codigo_barras' => $this->Dados['codigo_barras'],
                'product' => $this->Dados['product'],
                'preco_venda' => $this->Dados['preco_venda'],
                'iva' => $iva[0],
                'id_iva' => $iva[1],
                'unidade_medida' => $this->Dados['unidade_medida'],
                'estoque_minimo' => $this->Dados['estoque_minimo'],
                'type' => $this->Dados['type'],
                'Description' => $this->Dados['Description'],
                'local_product' => $this->Dados['local_product'],
                'IE_commerce' => $this->Dados['IE_commerce'],
                'ILoja' => $this->Dados['ILoja'],
                'remarks' => $this->Dados['remarks'],
                'id_marca' => $this->Dados['id_marca']
            ];
        endif;

        $Dados['desconto'] = $this->Dados['desconto'];
        $Dados['custo_compra'] = $this->Dados['custo_compra'];
        $Dados['PorcentagemP'] = $this->Dados['PorcentagemP'];

        $Update = new Update();
        $Update->ExeUpdate(self::Entity, $Dados, "WHERE id=:J AND id_db_settings=:id", "J={$this->Product}&id={$this->IDEmpresa}");

        if($Update->getResult()):
            $this->Error  = ["O Produto/Serviço <b>{$this->Dados['product']}</b> foi atualizado com sucesso!", WS_ACCEPT];
            $this->Result = $Update->getResult();
        else:
            $this->Error  = ["Ops: aconteceu um erro inesperado ao editar o produto <b>{$this->Dados['product']}</b>.", WS_ERROR];
            $this->Result = false;
        endif;
    }

    /** ADICIONAR - PROMOÇÕES DE PRODUTOS E SERVIÇOS
     * @param $idProduct
     * @param array $Dados
     * @param $id
     */
    public function ExePromotions($idProduct, array $Dados, $id){
        $this->Dados     = $Dados;
        $this->Product   = $idProduct;
        $this->IDEmpresa = $id;

        unset($this->Dados['SendPostFormLLL']);

        if(in_array('', $this->Dados)):
            $this->Error = ["Opsss!!! Preencha todos campos.", WS_ALERT];
            $this->Result = false;
        elseif($this->Dados['porcentagem_promocao'] < 0 || $this->Dados['porcentagem_promocao'] > 100):
            $this->Error  = ["Ops: a porcentagem do desconto promocional não pode ser menor que 0, ou maior que 100", WS_ALERT];
            $this->Result = false;
        else:
            $this->CheckPromotions();

            if($this->Result):
                $this->Promotions();
            endif;
        endif;
    }

    private function CheckPromotions(){
        $ReadPromotions = new Read;
        $ReadPromotions->ExeRead(self::Entity, "WHERE id=:i AND id_db_settings=:id", "i={$this->Product}&id={$this->IDEmpresa}");

        if($ReadPromotions->getResult()):
            $this->Dados['product'] = $ReadPromotions->getResult()[0]['product'];
            if($ReadPromotions->getResult()[0]['data_promocao'] != '' || $ReadPromotions->getResult()[0]['data_fim_promocao'] != ''):
                $this->Error = ["Ops: O produto <b>{$this->Dados['product']}</b> já encontra-se em promoção!!!", WS_ALERT];
                $this->Result = false;
            else:
                $this->Result = true;
            endif;
        endif;
    }

    private function Promotions(){
        $Update = new Update();
        $Update->ExeUpdate(self::Entity,  $this->Dados, "WHERE id=:i AND id_db_settings=:id", "i={$this->Product}&id={$this->IDEmpresa}");

        if($Update->getResult()):
            $this->Error = ["O produto <b>{$this->Dados['product']}</b> foi adionado na promoção!", WS_ACCEPT];
            $this->Result = true;
        endif;
    }

    /** VERIFICAR SE HÁ PROMOÇÕES E SE JÁ ESPEIROU */

    public function ExeCheckPromotions(){
        $this->Check10();

        if($this->Result):
            $this->RemovePromotions();
        endif;
    }

    public function ExeDeletePromotions($idProduct, $id){
        $this->Product   = $idProduct;
        $this->IDEmpresa = $id;

        $Read10 = new Read();
        $Read10->ExeRead(self::Entity, "WHERE id=:i AND id_db_settings=:id", "i={$this->Product}&id={$this->IDEmpresa}");

        if($Read10->getResult()):
            $this->Dados['product'] = $Read10->getResult()[0]['product'];
            $this->RemovePromotions();
        endif;
    }

    private function Check10(){
        $Read10 = new Read();
        $Read10->ExeRead(self::Entity, "WHERE id=:i AND id_db_settings=:id", "i={$this->Product}&id={$this->IDEmpresa}");

        if($Read10->getResult()):
            foreach ($Read10->getResult() as $Key):
                extract($Key);

                $this->Dados['product'] = $Key['product'];

                if($Key['preco_promocao'] != '' && $Key['data_promocao'] != '' &&  $Key['data_fim_promocao'] != ''):
                    $data = explode("-", $Key['data_fim_promocao']);

                    if(date('Y') >= $data[0]):
                        if($data[1]  >= date('M')):
                            if($data[2] >= date('d')):
                                $this->Dados['product'] = $Key['product'];
                                $this->Product = $Key['id'];
                                $this->Result = true;
                            endif;
                        endif;
                    endif;
                endif;
            endforeach;
        endif;
    }

    private function RemovePromotions(){
        $Dados = [
            'preco_promocao'       => 0,
            'data_promocao'        => '',
            'data_fim_promocao'    => '',
            'porcentagem_promocao' => 0
        ];

        $Update = new Update();
        $Update->ExeUpdate(self::Entity,  $Dados, "WHERE id=:Ng AND id_db_settings=:id", "Ng={$this->Product}&id={$this->IDEmpresa}");

        if($Update->getResult()):
            $this->Error  = ["O produto <b>{$this->Dados['product']}</b> foi removido da promoção!", WS_INFOR];
            $this->Result = $Update->getResult();
        endif;
    }

    /** PREÇO EM MOEDA EXTRANGEIRA */

    public function Currency($IdUser, array $Dados, $id){
        $this->Dados = $Dados;
        $this->Product = $IdUser;
        $this->IDEmpresa = $id;

        if(in_array('', $this->Dados)):
            $this->Error = ["Opsss!!! Preencha todos campos.", WS_ALERT];
            $this->Result = false;
        else:
            $this->ExeCurrency();
        endif;
    }

    private function ExeCurrency(){
        $Dados = ['preco_venda_ii' => $this->Dados['preco_venda_ii'] ];

        $Update = new Update();
        $Update->ExeUpdate(self::Entity, $Dados, "WHERE id=:J AND id_db_settings=:i", "J={$this->Product}&i={$this->IDEmpresa}");

        if($Update->getResult()):
            $this->Error = ["A Moeda Extrangeira foi atualizado com sucesso!", WS_ACCEPT];
            $this->Result = $Update->getResult();
        endif;
    }

    /** @Deletar produtos */
    public function ExeDelete($id, $id_db_settings){
        $this->Product = $id;
        $this->IDEmpresa = $id_db_settings;
        $this->Delete();
    }

    private function Delete(){
        $Reade = new Read();
        $Reade->ExeRead("sd_billing_pmp", "WHERE id_db_settings=:i AND id_product=:a", "i={$this->IDEmpresa}&a={$this->Product}");

        if(!$Reade->getResult()):
            $Delete = new Delete();
            $Delete->ExeDelete(self::Entity, "WHERE id=:id", "id={$this->Product}");

            if($Delete->getRowCount() || $Delete->getResult()):
                $this->Error = ["Arquivo apagado com sucesso!", WS_ACCEPT];
                $this->Result = true;
            else:
                $this->Error = ["Ops! Aconteceu um erro inesperado, atualize a página e tente novamente!", WS_ERROR];
                $this->Result = true;
            endif;
        else:
            $this->Error = ["Ops: não foi possivel deletar o produto porque já encontra-se na factura", WS_ERROR];
            $this->Result = false;
        endif;
    }

    // Data de expiração dos produtos
    /**
     * @param $IDProduct
     * @param array $Data
     * @param $id_db_settings
     */
    public function  ExeExpirations($IDProduct, array $Data, $id_db_settings){
        $this->IDEmpresa = $id_db_settings; $this->Dados = $Data; $this->Product = $IDProduct;

        if(in_array('', $this->Dados)):
            $this->Error  = ["Ops: preencha todos os campos para prosseguir com o processo!", WS_INFOR];
            $this->Result = false;
        else:
            $array = explode("-", $this->Dados['data_expiracao']);

            if($array[0] < date('Y')):
                $this->Error  = ["Ops: a data de expiração introduzida já foi vencida!", WS_ALERT];
                $this->Result = false;
            elseif($array[0] == date('Y')):
                if($array[1] < date('m')):
                    $this->Error  = ["Ops: não é permitido adicionar a data de expiração ao produto, a presente data está vencida!", WS_ALERT];
                    $this->Result = false;
                elseif($array[1] == date('m') && $array[2] == date('d')):
                    $this->Error  = ["Ops: não é permitido adicionar a data de expiração ao produto, a presente data está vencida!", WS_ALERT];
                    $this->Result = false;
                else:
                    $this->GeraData();
                endif;
            endif;
        endif;
    }

    private function GeraData(){
        $Data = [
            'data_fabrico' => $this->Dados['data_fabrico'],
            'data_expiracao' => $this->Dados['data_expiracao']
        ];

        $Update = new Update();
        $Update->ExeUpdate(self::Entity, $Data, "WHERE id=:i AND id_db_settings=:ip", "i={$this->Product}&ip={$this->IDEmpresa}");

        if($Update->getResult()):
            $this->Error  = ["Operação realizada com sucesso!", WS_ACCEPT];
            $this->Result = false;
        else:
            $this->Error  = ["Ops: aconteceu um erro inesperado ao adicionar a data de expiração ao produto.", WS_ERROR];
            $this->Result = false;
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
            $this->Error  = ["Ops: aconteceu um erro inesperado ao adiconar a view ao produto!", WS_ERROR];
            $this->Result = false;
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
        if(!empty($this->File['file']['tmp_name'])):
            $Upload = new Upload;
            $Upload->File($this->File['file']);

            if($Upload->getError()):
                $this->Error = $Upload->getError();
                $this->Result = false;
            else:
                $this->File['file'] = $Upload->getResult();
                $this->Result = true;
            endif;
        endif;
    }

    private function Import(){
        $this->Data['id_db_settings'] = $this->id_db_settings;
        $this->Data['file'] = $this->File['file'];
        $this->Data['data'] = date('d-m-Y');
        $this->Data['hora'] = date('H:i:s');
        $this->Data['status'] = 1;

        $Create = new Create();
        $Create->ExeCreate(self::import, $this->Data);

        if($Create->getResult()):
            $this->Result = true;
        else:
            $this->Error = ["Ops: aconteceu um erro inesperado ao importar o arquivo!", WS_ERROR];
        endif;
    }

    public function ExeCreateII(array $Dados){
        $this->Dados = $Dados;

        if(empty($this->Dados['product'])):
            $this->Error = ["Ops: o software não suporta campos vazio na importação de dados!", WS_ERROR];
            $this->Result = false;
        else:
            if(!isset($this->Dados['product']) || !isset($this->Dados['type'])):
                $this->Error = ["Ops: Preencha todos campos, para prosseguir com o processo.", WS_ALERT];
                $this->Result = false;
            else:
                $Read = new Read();
                $Read->ExeRead(self::Entity, "WHERE id_db_settings=:ix AND product='{$this->Dados['product']}' AND codigo='{$this->Dados['codigo']}' ", "ix={$this->Dados['id_db_settings']}");

                if($Read->getResult()):
                    foreach ($Read->getResult() as $keys):
                        $this->Shut_up['quantidade'] = $this->Dados['quantidade']; //$Read->getResult()[0]['quantidade'] + $this->Dados['quantidade'];
                        $this->Shut_up['preco_venda'] = $this->Dados['preco_venda'];
                        $this->Shut_up['codigo_barras'] = $this->Dados['codigo_barras'];
                        $this->Shut_up['codigo'] = $this->Dados['codigo'];
                        $this->Shut_up['custo_compra'] = $this->Dados['custo_compra'];
                        $this->Shut_up['remarks'] = $this->Dados['remarks'];
                        $this->Shut_up['local_product'] = $this->Dados['local_product'];

                        $this->Shut_up['iva'] = $this->Dados['iva'];
                        $this->Shut_up['id_iva'] = $this->Dados['id_iva'];

                        $this->id_db_settings = $keys['id_db_settings']; //$Read->getResult()[0]['id_db_settings'];
                        $this->ID = $keys['id']; //$Read->getResult()[0]['id'];

                        $this->UpdateII();
                    endforeach;
                else:
                    if(!isset(Strong::Config($this->IDEmpresa)['estoque_minimo']) || empty(Strong::Config($this->IDEmpresa)['estoque_minimo']) || Strong::Config($this->IDEmpresa)['estoque_minimo'] == null || Strong::Config($this->IDEmpresa)['estoque_minimo'] == ''):
                        $this->Dados['estoque_minimo'] = '0';
                    else:
                        $this->Dados['estoque_minimo'] = Strong::Config($this->IDEmpresa)['estoque_minimo'];
                    endif;

                    $this->CreateII();
                endif;
            endif;
        endif;
    }

    private function UpdateII(){
        $Update = new Update();
        $Update->ExeUpdate(self::Entity, $this->Shut_up, "WHERE id=:ipp AND id_db_settings=:i", "ipp={$this->ID}&i={$this->id_db_settings}");

        if($Update->getResult()):
            $this->Error  = ["O Item: {$this->Dados['product']} | Código: {$this->Shut_up['codigo']} || Código de barras: {$this->Shut_up['codigo_barras']} || Remarks: {$this->Shut_up['remarks']} || Preço: {$this->Shut_up['preco_venda']} || Localização: {$this->Shut_up['local_product']}, foi atualizado com sucesso!", WS_INFOR];
            $this->Result = true;
        else:
            $this->Error  = ["Ops: aconteceu um erro inesperado ao atualizar o Item: {$this->Dados['product']} | Código: {$this->Shut_up['codigo']} || Código de barras: {$this->Shut_up['codigo_barras']} || Remarks: {$this->Shut_up['remarks']} || Preço: {$this->Shut_up['preco_venda']} || Localização: {$this->Shut_up['local_product']}", WS_ERROR];
            $this->Result = false;
        endif;
    }

    private function CreateII(){
        $Create = new Create;
        $Create->ExeCreate(self::Entity, $this->Dados);

        if($Create->getResult()):
            $this->Error = ["O Item: {$this->Dados['product']} | Código: {$this->Dados['codigo']} || Código de barras: {$this->Dados['codigo_barras']} || Remarks: {$this->Dados['remarks']} || Preço: {$this->Dados['preco_venda']} || Localização: {$this->Dados['local_product']} foi cadastrado com sucesso!", WS_ACCEPT];
            $this->Result = true;
        else:
            $this->Error = ["Aconteceu um erro ao atidicionar o item: {$this->Dados['product']} | Código: {$this->Dados['codigo']} || Código de barras: {$this->Dados['codigo_barras']} || Remarks: {$this->Dados['remarks']} || Preço: {$this->Dados['preco_venda']} || Localização: {$this->Dados['local_product']}", WS_ERROR];
            $this->Result = true;
        endif;
    }

    public function Quantidadex_x($id_db_settings, $id, $value, $id_user){
        $this->id_db_settings = $id_db_settings;
        $this->ID = $id;
        $this->postId = $id_user;

        $this->Data['quantidade'] = $value;

        if($this->Data['quantidade'] < 0):
            $this->Error  = ["Ops: não é permitido adicionar quantidades negativas!", WS_ALERT];
            $this->Result = false;
        else:
            $Read = new Read();
            $Read->ExeRead(self::Entity, "WHERE id=:i AND id_db_settings=:ip ", "i={$this->ID}&ip={$this->id_db_settings}");

            if($Read->getResult()):
                $ArqX = $Read->getResult()[0];
                $this->Dados['olds_caixas'] = $ArqX['quantidade'];
                $this->Dados['novas_caixas'] = $this->Data['quantidade'];
                $this->Dados['quantidade'] = $this->Data['quantidade'];
                $this->Dados['custo_compra'] = $ArqX['custo_compra'];

                $this->Dados['Operacao'] = "Entrada";
                $this->Dados['status'] = 1;
                $this->Dados['id_db_settings'] = $this->id_db_settings;
                $this->Dados['id_user'] = $this->postId;
                $this->Dados['id_product'] = $this->ID;

                $this->Dados['data_operacao'] = date('Y-m-d');
                $this->Dados['data_emissao'] = date('d-m-Y H:i:s');

                $this->CreateOperation();
                if($this->Result):
                    $this->UpdateQtds();
                endif;
            else:
                $this->Result = false;
                $this->Error = ['Não encontramos o item selecionado!', WS_ALERT];
            endif;
        endif;
    }

    private function CreateOperation(){
        $Create = new Create();
        $Create->ExeCreate(self::stock, $this->Dados);

        if($Create->getResult()):
            $this->Result = true;
        else:
            $this->Result = false;
            $this->Error = ["Aconteceu um erro inesperado ao salvar o registro de stock!", WS_ERROR];
        endif;
    }

    private function UpdateQtds(){
        $Update = new Update();
        $Update->ExeUpdate(self::Entity, $this->Data, "WHERE id=:ipp AND id_db_settings=:i", "ipp={$this->ID}&i={$this->id_db_settings}");

        if($Update->getResult()):
            $this->Error  = ["Item foi adicionado a factura com sucesso!", WS_ACCEPT];
            $this->Result = true;
        else:
            $this->Error  = ["Ops: aconteceu um erro inesperado ao adicionar o produto a factura (1)", WS_ERROR];
            $this->Result = false;
        endif;
    }

    public function Custo_compra_x($id_db_settings, $id, $value){
        $this->id_db_settings         = $id_db_settings;
        $this->ID                     = $id;
        $this->Data['custo_compra'] = $value;

        if($this->Data['custo_compra'] < 1 || !is_numeric($this->Data['custo_compra'])) :
            $this->Error  = ["Ops: não é permitido adicionar números negativos!", WS_ALERT];
            $this->Result = false;
        else:
            $this->UpdateCusto();
        endif;
    }

    private function UpdateCusto(){
        $Update = new Update();
        $Update->ExeUpdate(self::Entity, $this->Data, "WHERE id=:ipp AND id_db_settings=:i", "ipp={$this->ID}&i={$this->id_db_settings}");

        if($Update->getResult()):
            $this->Error  = ["Item foi adicionado a factura com sucesso!", WS_ACCEPT];
            $this->Result = true;
        else:
            $this->Error  = ["Ops: aconteceu um erro inesperado ao adicionar o produto a factura (1)", WS_ERROR];
            $this->Result = false;
        endif;
    }


    public function Data_expiracao_x($id_db_settings, $id, $value, $id_user){
        $this->id_db_settings = $id_db_settings;
        $this->ID = $id;
        $this->postId = $id_user;

        $this->Data['data_expiracao'] = $value;

        if(!isset($this->Data['data_expiracao']) || empty($this->Data['data_expiracao'])):
            $this->Error  = ["Ops: não é permitido adicionar data de expiração já vencidas negativas!", WS_ALERT];
            $this->Result = false;
        else:
            $Read = new Read();
            $Read->ExeRead(self::Entity, "WHERE id=:i AND id_db_settings=:ip ", "i={$this->ID}&ip={$this->id_db_settings}");

            if($Read->getResult()):
                $this->Dados = $Read->getResult()[0];
                $this->UpdateDataExpiracao();
            else:
                $this->Result = false;
                $this->Error = ['Não encontramos o item selecionado!', WS_ALERT];
            endif;
        endif;
    }

    private function UpdateDataExpiracao(){
        $Update = new Update();
        $Update->ExeUpdate(self::Entity, $this->Data, "WHERE id=:ipp AND id_db_settings=:i", "ipp={$this->ID}&i={$this->id_db_settings}");

        if($Update->getResult()):
            $this->Error  = ["Data de Expiração do item <strong>{$this->Dados['product']}</strong>, foi atualizada com sucesso!", WS_ACCEPT];
            $this->Result = true;
        else:
            $this->Error  = ["Ops: aconteceu um erro inesperado ao atualizar a data de expiração do item selecionado!", WS_ERROR];
            $this->Result = false;
        endif;
    }

    const alert = "db_alert";

    public function VerificarExpiracao($data_de_expiracao, $id_product, $name, $id_db_settings) {
        $this->Data['id_alert'] = $id_product;
        $this->Data['name'] = $name;
        $this->Data['id_db_settings'] = $id_db_settings;

        $this->Data['title'] = "O produto <strong>{$this->Data['name']}</strong> está prestes ou encontra-se expirado!";

        $expiracao = DateTime::createFromFormat('Y-m-d', $data_de_expiracao);
        $agora = new DateTime();

        $limite = $agora->modify('+3 months');

        if ($expiracao <= $limite):
            $Read = new Read();
            $Read->ExeRead(self::alert, "WHERE title=:i AND id_alert=:id AND id_db_settings=:idd ", "i={$this->Data['title']}&id={$this->Data['id_alert']}&idd={$this->Data['id_db_settings']}");

            if(!$Read->getResult()):
                $this->SalveAlerts();
            endif;
        endif;
    }

    public function AlertEmpty($id_db_settings){
        $this->Data['id_db_settings'] = $id_db_settings;
        $this->Data['title'] = "Encontramos vários produtos sem data de expiração, preencha para ter um controle de Stock eficiênte!";

        $Read = new Read();
        $Read->ExeRead(self::alert, "WHERE title=:i AND id_db_settings=:idd ", "i={$this->Data['title']}&idd={$this->Data['id_db_settings']}");

        if(!$Read->getResult()):
            $this->SalveAlerts();
        endif;
    }

    private function SalveAlerts(){
        $this->Data['dia'] = date('d');
        $this->Data['mes'] = date('m');
        $this->Data['ano'] = date('Y');
        $this->Data['hora'] = date('H:i');
        $this->Data['status'] = 1;

        $Create = new Create();
        $Create->ExeCreate(self::alert, $this->Data);

        if($Create->getResult()):
            $this->Result = true;
        else:
            $this->Result = false;
            $this->Error = ["Aconteceu um erro inesperado ao salvar o sistema de alerta!", WS_ERROR];
        endif;
    }
}
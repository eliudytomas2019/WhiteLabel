<?php

class Mecanica{
    private $Error, $Result, $Data, $id_product, $id_db_settings, $id_user, $quantidade, $desconto, $preco, $taxa, $Info, $Config, $desconto_financeiro, $document, $method, $Numero, $pagou, $troco, $id_cliente, $Hash, $HashControl, $ID, $Helio, $System, $sPro, $postId, $InvoiceType, $Rectification, $Static;

    const
        users       = "db_users",
        config      = "db_config",
        system      = "db_settings",
        cliente     = "cv_customer",
        product     = "cv_product",
        unidade     = "i_unidade",
        billing     = "ii_billing",
        veiculos    = "i_veiculos",
        taxtable    = "db_taxtable",
        billing_ac  = "ii_billing_ac",
        billing_pmp = "ii_billing_pmp",
        billing_tmp = "ii_billing_tmp",
        billing_story = "ii_billing_story",
        static_cars = "iii_static_cars",
        static_users = "iii_static_users",
        static_product = "iii_static_product",
        static_clientes = "iii_static_clientes",
        static_kilape   = "iii_static_kilape";

    public function getResult(){return $this->Result;}
    public function getError(){return $this->Error;}

    public function CheckConfig($id_db_settings){
        $Read = new Read();
        $Read->ExeRead(self::config, "WHERE id_db_settings=:i", "i={$id_db_settings}");

        if($Read->getResult()):
            $this->Result = true;
            $this->Config = $Read->getResult()[0];
        else:
            $this->Result = false;
        endif;
    }

    public function adicionar($id_db_settings, $id_user, $postId, $quantidade, $desconto = null){
        $this->id_db_settings = (int) $id_db_settings;
        $this->id_user = (int) $id_user;
        $this->id_product = (int) $postId;
        $this->quantidade = $quantidade;
        $this->desconto = $desconto;

        if(!is_numeric($this->id_product) || !is_numeric($this->id_db_settings) || !is_numeric($this->quantidade) || isset($this->desconto) && !is_numeric($this->desconto) || !is_numeric($this->id_user)):
            $this->Error  = ["Ops: os dados enviado náo são de acordo com as especificações do sistema!", WS_ERROR];
            $this->Result = false;
        elseif(isset($this->desconto) && $this->desconto > 100 || isset($this->desconto) && $this->desconto < 0):
            $this->Error  = ["Ops: o desconto aplicado não deve ser maior que 100% e nem menor que 0%!", WS_ALERT];
            $this->Result = false;
        elseif(isset($this->quantidade) && $this->quantidade < 0):
            $this->Result = false;
            $this->Error  = ["Ops: a quantidade dos itens adicionado não deve ser menor que 0!", WS_ERROR];
        else:
            $Read = new Read();
            $Read->ExeRead(self::product, "WHERE id=:i AND id_db_settings=:y", "i={$this->id_product}&y={$this->id_db_settings}");

            if($Read->getResult()):
                $this->Info = $Read->getResult()[0];

                if($this->Info['type'] == "P"):
                    $this->CheckConfig($this->id_db_settings);
                    if($this->Result):
                        $this->Data['system_module'] = $this->Config['JanuarioSakalumbu'];
                        if($this->Config['HeliosPro'] == 1):
                            /*if($this->Info['qQtd'] == null || $this->Info['qQtd'] == "" || empty($this->Info['qQtd']) || $this->Info['qQtd'] < 1):
                                $this->Result = false;
                                $this->Error  = ["Ops: não existe quantidade suficiente para executar essa venda!", WS_ALERT];
                            elseif(isset($this->Info['qQtd']) && $this->Info['qQtd'] < $this->quantidade):
                                $this->Result = false;
                                $this->Error  = ["Ops: não existe quantidade suficiênte em estoque!", WS_ALERT];
                            else:*/
                                $Read->ExeRead(self::billing_tmp, "WHERE id_db_settings=:i AND id_user=:y AND id_product=:ip", "i={$this->id_db_settings}&y={$this->id_user}&ip={$this->id_product}");
                                if($Read->getResult()):
                                    $this->Data = $Read->getResult()[0];
                                    unset($this->Data['id']);
                                    $this->Data['qtd_tmp'] = $this->Data['qtd_tmp'] + $this->quantidade;
                                    $this->Data['desconto_tmp'] = $this->desconto;
                                    $this->Data['preco_tmp'] = $this->Info['preco_venda'];
                                    $this->Data['taxa_tmp'] = $this->Info['iva'];

                                    $this->AtualizarItem();
                                else:
                                    $Read->ExeRead(self::billing_tmp, "WHERE id_db_settings=:i AND id_user=:y", "i={$this->id_db_settings}&y={$this->id_user}");

                                    if($Read->getRowCount() >= 22):
                                        $this->Result = false;
                                        $this->Error  = ["Ops: limite de itens adicionado no documento foi atingido!", WS_ALERT];
                                    else:
                                        $this->Data['qtd_tmp'] =$this->quantidade;
                                        $this->Data['desconto_tmp'] = $this->desconto;
                                        $this->Data['preco_tmp'] = $this->Info['preco_venda'];
                                        $this->Data['taxa_tmp'] = $this->Info['iva'];
                                        $this->Data['product_type'] = $this->Info['type'];
                                        $this->Data['product_code'] = $this->Info['codigo'];
                                        $this->Data['product_code_bars'] = $this->Info['codigo_barras'];
                                        $this->Data['product_list'] = $this->Info['Description'];
                                        $this->Data['id_category'] = $this->Info['id_category'];
                                        $this->Data['product'] = $this->Info['product'];

                                        $Read->ExeRead(self::unidade, "WHERE id=:i AND id_db_settings=:y", "i={$this->Info['id_unidade']}&y={$this->id_db_settings}");
                                        if($Read->getResult()):
                                            $this->Data['product_unidade'] = $Read->getResult()[0]['simbolo'];
                                        endif;

                                        $Read->ExeRead(self::taxtable, "WHERE taxtableEntry=:y AND id_db_settings=:i", "y={$this->Info['id_iva']}&i={$this->id_db_settings}");
                                        if($Read->getResult()):
                                            $this->Data['TaxCode'] = $Read->getResult()[0]['taxCode'];
                                            $this->Data['TaxType'] = $Read->getResult()[0]['taxType'];
                                            $this->Data['ExeReason'] = $Read->getResult()[0]['TaxExemptionReason'];
                                            $this->Data['ExeCode'] = $Read->getResult()[0]['taxCode'];
                                            $this->Data['country'] = $Read->getResult()[0]['TaxCountryRegion'];
                                            $this->Data['id_taxtable'] = $Read->getResult()[0]['taxtableEntry'];
                                        else:
                                            $this->Result = false;
                                            $this->Error  = ["Ops: não encontramos a tabela de impostos!", WS_ALERT];
                                        endif;

                                        $this->Data['id_user'] = $this->id_user;
                                        $this->Data['id_db_settings'] = $this->id_db_settings;
                                        $this->Data['id_product'] = $this->id_product;

                                        $this->AdicionarItem();
                                    endif;
                                endif;
                            //endif;
                        else:
                            $Read->ExeRead(self::billing_tmp, "WHERE id_db_settings=:i AND id_user=:y AND id_product=:ip", "i={$this->id_db_settings}&y={$this->id_user}&ip={$this->id_product}");
                            if($Read->getResult()):
                                $this->Data = $Read->getResult()[0];
                                unset($this->Data['id']);
                                $this->Data['qtd_tmp'] = $this->Data['qtd_tmp'] + $this->quantidade;
                                $this->Data['desconto_tmp'] = $this->desconto;
                                $this->Data['preco_tmp'] = $this->Info['preco_venda'];
                                $this->Data['taxa_tmp'] = $this->Info['imposto'];

                                $this->AtualizarItem();
                            else:
                                $Read->ExeRead(self::billing_tmp, "WHERE id_db_settings=:i AND id_user=:y", "i={$this->id_db_settings}&y={$this->id_user}");

                                if($Read->getRowCount() >= 22):
                                    $this->Result = false;
                                    $this->Error  = ["Ops: limite de itens adicionado no documento foi atingido!", WS_ALERT];
                                else:
                                    $this->Data['qtd_tmp'] =$this->quantidade;
                                    $this->Data['desconto_tmp'] = $this->desconto;
                                    $this->Data['preco_tmp'] = $this->Info['preco_venda'];
                                    $this->Data['taxa_tmp'] = $this->Info['iva'];
                                    $this->Data['product_type'] = $this->Info['type'];
                                    $this->Data['product_code'] = $this->Info['codigo'];
                                    $this->Data['product_code_bars'] = $this->Info['codigo_barras'];
                                    $this->Data['product_list'] = $this->Info['description'];
                                    $this->Data['id_category'] = $this->Info['id_category'];
                                    $this->Data['product'] = $this->Info['product'];

                                    $Read->ExeRead(self::unidade, "WHERE id=:i AND id_db_settings=:y", "i={$this->Info['id_unidade']}&y={$this->id_db_settings}");
                                    if($Read->getResult()):
                                        $this->Data['product_unidade'] = $Read->getResult()[0]['simbolo'];
                                    endif;

                                    $Read->ExeRead(self::taxtable, "WHERE id=:y AND id_db_settings=:i", "y={$this->Info['id_taxtable']}&i={$this->id_db_settings}");

                                    if($Read->getResult()):
                                        $this->Data['TaxCode'] = $Read->getResult()[0]['code'];
                                        $this->Data['TaxType'] = $Read->getResult()[0]['type'];
                                        $this->Data['ExeReason'] = $Read->getResult()[0]['ExeReason'];
                                        $this->Data['ExeCode'] = $Read->getResult()[0]['ExeCode'];
                                        $this->Data['country'] = $Read->getResult()[0]['country'];
                                        $this->Data['id_taxtable'] = $Read->getResult()[0]['id'];
                                    else:
                                        $this->Result = false;
                                        $this->Error  = ["Ops: não encontramos a tabela de impostos!", WS_ALERT];
                                    endif;

                                    $this->Data['id_user'] = $this->id_user;
                                    $this->Data['id_db_settings'] = $this->id_db_settings;
                                    $this->Data['id_product'] = $this->id_product;

                                    $this->AdicionarItem();
                                endif;
                            endif;
                        endif;
                    else:
                        $this->Error  = ["Ops: termine as configurações do sistema!", WS_ALERT];
                        $this->Result = false;
                    endif;
                else:
                    $Read->ExeRead(self::billing_tmp, "WHERE id_db_settings=:i AND id_user=:y AND id_product=:ip", "i={$this->id_db_settings}&y={$this->id_user}&ip={$this->id_product}");
                    if($Read->getResult()):
                        $this->Data = $Read->getResult()[0];
                        unset($this->Data['id']);
                        $this->Data['qtd_tmp'] = $this->Data['qtd_tmp'] + $this->quantidade;
                        $this->Data['desconto_tmp'] = $this->desconto;
                        $this->Data['preco_tmp'] = $this->Info['preco_venda'];
                        $this->Data['taxa_tmp'] = $this->Info['iva'];

                        $this->AtualizarItem();
                    else:
                        $Read->ExeRead(self::billing_tmp, "WHERE id_db_settings=:i AND id_user=:y", "i={$this->id_db_settings}&y={$this->id_user}");

                        if($Read->getRowCount() >= 22):
                            $this->Result = false;
                            $this->Error  = ["Ops: limite de itens adicionado no documento foi atingido!", WS_ALERT];
                        else:
                            $this->Data['qtd_tmp'] =$this->quantidade;
                            $this->Data['desconto_tmp'] = $this->desconto;
                            $this->Data['preco_tmp'] = $this->Info['preco_venda'];
                            $this->Data['taxa_tmp'] = $this->Info['iva'];
                            $this->Data['product_type'] = $this->Info['type'];
                            $this->Data['product_code'] = $this->Info['codigo'];
                            $this->Data['product_code_bars'] = $this->Info['codigo_barras'];
                            $this->Data['product_list'] = $this->Info['Description'];
                            $this->Data['id_category'] = $this->Info['id_category'];
                            $this->Data['product'] = $this->Info['product'];

                            $Read->ExeRead(self::unidade, "WHERE id=:i AND id_db_settings=:y", "i={$this->Info['id_unidade']}&y={$this->id_db_settings}");
                            if($Read->getResult()):
                                $this->Data['product_unidade'] = $Read->getResult()[0]['simbolo'];
                            endif;

                            $Read->ExeRead(self::taxtable, "WHERE taxtableEntry=:y AND id_db_settings=:i", "y={$this->Info['id_iva']}&i={$this->id_db_settings}");

                            if($Read->getResult()):
                                $this->Data['TaxCode'] = $Read->getResult()[0]['taxCode'];
                                $this->Data['TaxType'] = $Read->getResult()[0]['taxType'];
                                $this->Data['ExeReason'] = $Read->getResult()[0]['TaxExemptionReason'];
                                $this->Data['ExeCode'] = $Read->getResult()[0]['TaxExemptionCode'];
                                $this->Data['country'] = $Read->getResult()[0]['TaxCountryRegion'];
                                $this->Data['id_taxtable'] = $Read->getResult()[0]['taxtableEntry'];
                            else:
                                $this->Result = false;
                                $this->Error  = ["Ops: não encontramos a tabela de impostos!", WS_ALERT];
                            endif;

                            $this->Data['id_user'] = $this->id_user;
                            $this->Data['id_db_settings'] = $this->id_db_settings;
                            $this->Data['id_product'] = $this->id_product;

                            $this->AdicionarItem();
                        endif;
                    endif;
                endif;
            else:
                $this->Result = false;
                $this->Error  = ["Ops: não encontramos o item selecionado!", WS_ERROR];
            endif;
        endif;
    }

    private function AdicionarItem(){
        $Create = new Create();
        $Create->ExeCreate(self::billing_tmp, $this->Data);

        if($Create->getResult()):
            $this->Result = true;
        else:
            $this->Result = false;
            $this->Error  = ["Ops: aconteceu um erro inesperado ao adicionar o item!", WS_ERROR];
        endif;
    }

    private function AtualizarItem(){
        $Update = new Update();
        $Update->ExeUpdate(self::billing_tmp, $this->Data, "WHERE id_product=:i AND id_db_settings=:y AND id_user=:ip", "i={$this->id_product}&y={$this->id_db_settings}&ip={$this->id_user}");

        if($Update->getResult()):
            $this->Result = true;
        else:
            $this->Error  = ["Ops: aconteceu um erro inesperado ao atualizar o item!", WS_ERROR];
            $this->Result = false;
        endif;
    }

    public function cancel($id_db_settings, $id_user, $postId){
        $this->id_db_settings = (int)$id_db_settings;
        $this->id_user = (int)$id_user;
        $this->id_product = (int)$postId;

        $Read = new Read();
        $Read->ExeRead(self::billing_tmp, "WHERE id=:i AND id_db_settings=:y AND id_user=:ip", "i={$this->id_product}&y={$this->id_db_settings}&ip={$this->id_user}");

        if($Read->getResult()):
            $Delete = new Delete();
            $Delete->ExeDelete(self::billing_tmp, "WHERE id=:i AND id_db_settings=:y AND id_user=:ip", "i={$this->id_product}&y={$this->id_db_settings}&ip={$this->id_user}");

            if($Delete->getResult() || $Delete->getRowCount()):
                $this->Result = true;
            else:
                $this->Error  = ["Ops: aconteceu um erro inesperado ao eliminar o item selecionado!", WS_ERROR];
                $this->Result = false;
            endif;
        else:
            $this->Result = false;
            $this->Error  = ["Ops: não encontramos o item selecionado!", WS_ERROR];
        endif;
    }

    public function add_qtd($id_db_settings, $id_user, $postId, $quantidade){
        $this->id_db_settings = (int) $id_db_settings;
        $this->id_user = (int) $id_user;
        $this->id_product = (int) $postId;
        $this->quantidade = $quantidade;

        if(!is_numeric($this->id_product) || !is_numeric($this->id_db_settings) || !is_numeric($this->quantidade) || !is_numeric($this->id_user)):
            $this->Error  = ["Ops: os dados enviado náo são de acordo com as especificações do sistema!", WS_ERROR];
            $this->Result = false;
        elseif(isset($this->quantidade) && $this->quantidade < 0):
            $this->Result = false;
            $this->Error  = ["Ops: a quantidade dos itens adicionado não deve ser menor que 0!", WS_ERROR];
        else:
            $st = 1;

            $Read = new Read();
            $Read->ExeRead(self::product, "WHERE id=:i AND id_db_settings=:y AND status=:st", "i={$this->id_product}&y={$this->id_db_settings}&st={$st}");

            if($Read->getResult()):
                $this->Info = $Read->getResult()[0];

                if($this->Info['type'] == "P"):
                    $this->CheckConfig($this->id_db_settings);
                    if($this->Result):
                        if($this->Config['stock'] == 1):
                            if($this->Info['qQtd'] < $this->quantidade):
                                $this->Result = false;
                                $this->Error  = ["Ops: não existe quantidade suficiênte em estoque!", WS_ALERT];
                                $this->Result = false;
                            endif;
                        endif;
                    else:
                        $this->Error  = ["Ops: termine as configurações do sistema!", WS_ALERT];
                        $this->Result = false;
                    endif;
                endif;

                $this->Data['qtd_tmp'] = $this->quantidade;
                $this->AtualizarItem();
            else:
                $this->Result = false;
                $this->Error  = ["Ops: não encontramos o item selecionado!", WS_ERROR];
            endif;
        endif;
    }

    public function Finish($id_db_settings, $id_user, $id_cliente, $document, $desconto_financeiro, $pagou, $troco, $method){
        $this->pagou = $pagou;
        $this->troco = $troco;
        $this->method = $method;
        $this->document = $document;
        $this->id_user = (int) $id_user;
        $this->id_db_settings = (int) $id_db_settings;
        $this->id_cliente = (int) $id_cliente;
        $this->desconto_financeiro = (float) $desconto_financeiro;

        $billing = self::billing;
        $this->Data['dia'] = date('d');
        $this->Data['mes'] = date('m');
        $this->Data['ano'] = date('Y');
        $this->Data['hora'] = date('H:i');

        $Read = new Read();
        $Read->ExeRead(self::config, "WHERE id_db_settings=:i", "i={$this->id_db_settings}");
        if($Read->getResult()):
            $this->Config = $Read->getResult()[0];
            $this->Data['config_moeda'] = $this->Config['moeda'];
            $this->Data['config_module'] = $this->Config['JanuarioSakalumbu'];
            if($this->Config['IncluirNaFactura'] == 1):
                $this->Data['config_retencao_de_fonte'] = $this->Config['RetencaoDeFonte'];
            endif;
        else:
            $this->Result = false;
            $this->Error  = ["Ops: não encontramos as configurações do sistema!", WS_ALERT];
        endif;

        $Read->FullRead("SELECT count(id) AS numeros FROM {$billing} WHERE id_db_settings=:i AND config_module=:y AND InvoiceType=:ip AND ano=:ia", "i={$this->id_db_settings}&y={$this->Config['modulo']}&ip={$this->document}&ia={$this->Data['ano']}");
        if($Read->getResult()): $this->Numero = $Read->getResult()[0]['numeros'] + 1; else: $this->Numero = 1; endif;

        if(isset($this->desconto_financeiro) && $this->desconto_financeiro < 0 || isset($this->desconto_financeiro) && $this->desconto_financeiro > 100):
            $this->Result = false;
            $this->Error  = ["Ops: os desconto não devem ser maior que 100 e nem menor que 0!", WS_ALERT];
        elseif(isset($this->Data['config_retencao_de_fonte']) && $this->Data['config_retencao_de_fonte'] > 100 || isset($this->Data['config_retencao_de_fonte']) && $this->Data['config_retencao_de_fonte'] < 0):
            $this->Result = false;
            $this->Error  = ["Ops: a retenção de fonte foi preenchida em configurações do sistema!", WS_ALERT];
        else:
            $Read->ExeRead(self::billing, "WHERE id_db_settings=:i AND config_module=:y AND InvoiceType=:ip AND ano=:ia ORDER BY id DESC LIMIT 1", "i={$this->id_db_settings}&y={$this->Config['modulo']}&ip={$this->document}&ia={$this->Data['ano']}");
            if($Read->getResult()):
                $this->Info = $Read->getResult()[0];
                if(date('Y') <= $this->Info['ano'] && date('m') < $this->Info['mes'] &&  date('d') < $this->Data['dia'] || date('Y') == $this->Info['ano'] && date('m') == $this->Info['mes'] && date('d') == $this->Data['dia'] && date('H:i') < $this->Info['hora']):
                    $this->Result = false;
                    $this->Error  = ["Ops: ajuste a Data & Hora do sistema!", WS_ALERT];
                else:
                    $this->Result = true;
                endif;
            endif;

            $Read->ExeRead(self::cliente, "WHERE id=:y AND id_db_settings=:i","y={$this->id_cliente}&i={$this->id_db_settings}");
            if($Read->getResult()):
                $this->Data['customer_name'] = $Read->getResult()[0]['name'];
                $this->Data['customer_nif'] = $Read->getResult()[0]['nif'];
                $this->Data['customer_endereco'] = $Read->getResult()[0]['endereco'];
            endif;

            $Read->ExeRead(self::users, "WHERE id=:i AND id_db_settings=:y", "i={$this->id_user}&y={$this->id_db_settings}");
            if($Read->getResult()):
                $this->Data['username'] = $Read->getResult()[0]['name'];
            endif;

            $this->CheckSystem($id_db_settings);
            if($this->Result):
                $this->Data['Code'] = $this->System['id'];
                $this->Data['system_name'] = $this->System['name'];
                $this->Data['system_telefone'] = $this->System['telefone'];
                $this->Data['system_nif'] = $this->System['nif'];
                $this->Data['system_endereco'] = $this->System['endereco'];
                $this->Data['system_website'] = $this->System['website'];
                $this->Data['system_logotype'] = $this->System['logotype'];
                $this->Data['system_banco']        = $this->System['banco'];
                $this->Data['system_city'] = $this->System['city'];
                $this->Data['system_nib'] = $this->System['nib'];
                $this->Data['system_swift'] = $this->System['swift'];
                $this->Data['system_iban'] = $this->System['iban'];
                $this->Data['system_coordenadas'] = $this->System['coordenadas'];
                $this->Data['system_email'] = $this->System['email'];
            endif;

            $this->Data['method'] = $this->method;
            $this->Data['InvoiceType'] = $this->document;
            $this->Data['id_cliente'] = $this->id_cliente;
            $this->Data['id_db_settings'] = $this->id_db_settings;
            $this->Data['id_user'] = $this->id_user;
            $this->Data['desconto_financeiro'] = $this->desconto_financeiro;
            $this->Data['Numero'] = $this->Numero;
            $this->Data['status'] = 3;

            if($this->document == "NU"):
                if(isset($this->pagou) && $this->pagou != null && $this->pagou != ""):  $this->Data['pagou'] = $this->pagou; endif;
                if(isset($this->troco) && $this->troco != null && $this->troco != ""):  $this->Data['troco'] = $this->troco; endif;
            else:
                unset($this->Data['pagou']);
                unset($this->Data['troco']);
            endif;

            $Read->ExeRead(self::billing_tmp, "WHERE id_db_settings=:i AND id_user=:y", "i={$this->id_db_settings}&y={$this->id_user}");
            if($Read->getResult()):
                $this->Helio = $Read->getResult();
                if($this->document != "PP"):  $this->Hash(); endif;
                $this->CreateFinish();
                if($this->Result):
                    $this->FaseII();
                    if($this->Result):
                        if($this->document == "FT"):
                            $Read->ExeRead(self::static_kilape, "WHERE id_db_settings=:i AND postId=:y ", "i={$this->id_db_settings}&y={$this->id_cliente}");
                            if($Read->getResult()):
                                $this->Static['kilape'] = $Read->getResult()[0]['kilape'] + 1;
                                $this->UpdateStatic(self::static_kilape, $this->Static, $this->id_db_settings, $this->id_cliente);
                            else:
                                $this->Static['kilape'] = 1;
                                $this->Static['id_db_settings'] = $this->id_db_settings;
                                $this->Static['postId'] = $this->id_cliente;

                                $this->CreateStatic(self::static_kilape, $this->Static);
                            endif;
                        elseif($this->document == "FR"):
                            $Read->ExeRead(self::static_clientes, "WHERE id_db_settings=:i AND postId=:y ", "i={$this->id_db_settings}&y={$this->id_cliente}");
                            if($Read->getResult()):
                                $this->Static['compra'] = $Read->getResult()[0]['compra'] + 1;
                                $this->UpdateStatic(self::static_clientes, $this->Static, $this->id_db_settings, $this->id_cliente);
                            else:
                                $this->Static['compra'] = 1;
                                $this->Static['id_db_settings'] = $this->id_db_settings;
                                $this->Static['postId'] = $this->id_cliente;

                                $this->CreateStatic(self::static_clientes, $this->Static);
                            endif;
                        endif;

                        if($this->Result):
                            unset($this->Static);
                            if($this->document != "PP"):
                                $Read->ExeRead(self::static_users, "WHERE id_db_settings=:i AND postId=:y", "i={$this->id_db_settings}&y={$this->id_user}");

                                if($Read->getResult()):
                                    $this->Static['sales'] = $Read->getResult()[0]['sales'] + 1;
                                    $this->UpdateStatic(self::static_users, $this->Static, $this->id_db_settings, $this->id_user);
                                else:
                                    $this->Static['sales'] = 1;
                                    $this->Static['id_db_settings'] = $this->id_db_settings;
                                    $this->Static['postId'] = $this->id_user;

                                    $this->CreateStatic(self::static_users, $this->Static);
                                endif;
                            endif;
                        endif;
                    endif;
                endif;
            else:
                $this->Result = false;
                $this->Error  = ["Ops: não encontramos nenhum item no documento!", WS_ERROR];
            endif;
        endif;
    }

    private function CreateStatic($bd, $tab){
        $Create = new Create();
        $Create->ExeCreate("{$bd}", $tab);

        if($Create->getResult()):
            $this->Result = true;
            $this->Error  = ["Documento finalizado com sucesso! (1)", WS_ACCEPT];
        else:
            $this->Result = false;
            $this->Error  = ["Ops: aconteceu um erro inesperado ao finalizar o documento! (1)", WS_ERROR];
        endif;
    }

    private function UpdateStatic($db, $Static, $id_db_settings, $id_cliente){
        $Update = new Update();
        $Update->ExeUpdate("{$db}", $Static, "WHERE id_db_settings=:i AND postId=:y", "i={$id_db_settings}&y={$id_cliente}");

        if($Update->getResult()):
            $this->Result = true;
            $this->Error  = ["Documento finalizado com sucesso! (2)", WS_ACCEPT];
        else:
            $this->Result = false;
            $this->Error  = ["Ops: aconteceu um erro inesperado ao finalizar o documento! (2)", WS_ERROR];
        endif;
    }

    public function FinishII($id_db_settings, $id_user, $id_cliente, $document, array $data){
        $this->Data = $data;
        $this->document = $document;
        $this->id_user = (int) $id_user;
        $this->id_db_settings = (int) $id_db_settings;
        $this->id_cliente = (int) $id_cliente;

        if(!isset($this->Data['id_mecanico']) || empty($this->Data['id_mecanico'])): unset($this->Data['id_mecanico']); endif;

        var_dump($this->Data['fo_problema']);

        if(empty($this->Data['id_veiculo'])|| empty($this->Data['fo_problema']) || empty($this->Data['fo_laudo'])):
            $this->Result = false;
            $this->Error  = ["Preencha todos os campos para finalizar a final o documento!", WS_ALERT];
        else:
            $billing = self::billing;
            $this->Data['dia'] = date('d');
            $this->Data['mes'] = date('m');
            $this->Data['ano'] = date('Y');
            $this->Data['hora'] = date('H:i');

            $Read = new Read();
            $Read->ExeRead(self::config, "WHERE id_db_settings=:i", "i={$this->id_db_settings}");
            if($Read->getResult()):
                $this->Config = $Read->getResult()[0];
                $this->Data['config_moeda'] = $this->Config['moeda'];
                $this->Data['config_module'] = $this->Config['JanuarioSakalumbu'];
                if($this->Config['IncluirNaFactura'] == 1):
                    $this->Data['config_retencao_de_fonte'] = $this->Config['RetencaoDeFonte'];
                endif;
            else:
                $this->Result = false;
                $this->Error  = ["Ops: não encontramos as configurações do sistema!", WS_ALERT];
            endif;

            $Read->FullRead("SELECT count(id) AS numeros FROM {$billing} WHERE id_db_settings=:i AND config_module=:y AND InvoiceType=:ip AND ano=:ia", "i={$this->id_db_settings}&y={$this->Config['JanuarioSakalumbu']}&ip={$this->document}&ia={$this->Data['ano']}");
            if($Read->getResult()): $this->Numero = $Read->getResult()[0]['numeros'] + 1; else: $this->Numero = 1; endif;

            $Read->ExeRead(self::billing, "WHERE id_db_settings=:i AND config_module=:y AND InvoiceType=:ip AND ano=:ia ORDER BY id DESC LIMIT 1", "i={$this->id_db_settings}&y={$this->Config['JanuarioSakalumbu']}&ip={$this->document}&ia={$this->Data['ano']}");
            if($Read->getResult()):
                $this->Info = $Read->getResult()[0];
                if(date('Y') <= $this->Info['ano'] && date('m') < $this->Info['mes'] &&  date('d') < $this->Data['dia'] || date('Y') == $this->Info['ano'] && date('m') == $this->Info['mes'] && date('d') == $this->Data['dia'] && date('H:i') < $this->Info['hora']):
                    $this->Result = false;
                    $this->Error  = ["Ops: ajusta a Data & Hora do sistema!", WS_ALERT];
                else:
                    $this->Result = true;
                endif;
            endif;

            $Read->ExeRead(self::cliente, "WHERE id=:y AND id_db_settings=:i","y={$this->id_cliente}&i={$this->id_db_settings}");
            if($Read->getResult()):
                $this->Data['customer_name'] = $Read->getResult()[0]['nome'];
                $this->Data['customer_nif'] = $Read->getResult()[0]['nif'];
                $this->Data['customer_endereco'] = $Read->getResult()[0]['endereco'];
            endif;

            $Read->ExeRead(self::veiculos, "WHERE id=:y AND id_db_settings=:i","y={$this->Data['id_veiculo']}&i={$this->id_db_settings}");
            if($Read->getResult()):
                $this->Data['v_modelo'] = $Read->getResult()[0]['veiculo']."/".$Read->getResult()[0]['modelo'];
                $this->Data['kilometragem'] = $Read->getResult()[0]['km_atual'];
                $this->Data['fo_data_entrada'] = $Read->getResult()[0]['data_entrada'];
                $this->Data['cor'] = $Read->getResult()[0]['cor'];
                $this->Data['motor'] = $Read->getResult()[0]['motor'];
                $this->Data['chassi'] = $Read->getResult()[0]['chassi'];
            endif;

            $Read->ExeRead(self::users, "WHERE id=:i AND id_db_settings=:y", "i={$this->id_user}&y={$this->id_db_settings}");
            if($Read->getResult()):
                $this->Data['username'] = $Read->getResult()[0]['name'];
            endif;

            if(isset($this->Data['id_mecanico'])):
                $Read->ExeRead(self::users, "WHERE id=:i AND id_db_settings=:y", "i={$this->Data['id_mecanico']}&y={$this->id_db_settings}");
                if($Read->getResult()):
                    $this->Data['mecanico'] = $Read->getResult()[0]['name'];
                endif;
            endif;

            $this->CheckSystem($id_db_settings);
            if($this->Result):
                $this->Data['Code'] = $this->System['id'];
                $this->Data['system_name'] = $this->System['empresa'];
                $this->Data['system_telefone'] = $this->System['telefone'];
                $this->Data['system_nif'] = $this->System['nif'];
                $this->Data['system_endereco'] = $this->System['endereco'];
                $this->Data['system_website'] = $this->System['website'];
                $this->Data['system_logotype'] = $this->System['logotype'];
                $this->Data['system_banco'] = $this->System['banco'];
                $this->Data['system_city'] = $this->System['city'];
                $this->Data['system_nib'] = $this->System['nib'];
                $this->Data['system_swift'] = $this->System['swift'];
                $this->Data['system_iban'] = $this->System['iban'];
                $this->Data['system_coordenadas'] = $this->System['coordenadas'];
                $this->Data['system_email'] = $this->System['email'];
            endif;

            $this->Data['InvoiceType'] = $this->document;
            $this->Data['id_cliente'] = $this->id_cliente;
            $this->Data['id_db_settings'] = $this->id_db_settings;
            $this->Data['id_user'] = $this->id_user;
            $this->Data['Numero'] = $this->Numero;
            $this->Data['status'] = 3;

            $Read->ExeRead(self::billing_tmp, "WHERE id_db_settings=:i AND id_user=:y", "i={$this->id_db_settings}&y={$this->id_user}");
            if($Read->getResult()):
                $this->Helio = $Read->getResult();
                if($this->document != "PP"):  $this->Hash(); endif;
                $this->CreateFinish();
                if($this->Result):
                    $this->FaseII();
                    if($this->Result):
                        if($this->document == "FO"):
                            $Read->ExeRead(self::static_cars, "WHERE id_db_settings=:i AND postId=:y ", "i={$this->id_db_settings}&y={$this->Data['id_veiculo']}");
                            if($Read->getResult()):
                                $this->Static['ordem'] = $Read->getResult()[0]['ordem'] + 1;
                                $this->UpdateStatic(self::static_cars, $this->Static, $this->id_db_settings, $this->id_cliente);
                            else:
                                $this->Static['ordem'] = 1;
                                $this->Static['id_db_settings'] = $this->id_db_settings;
                                $this->Static['id_cliente'] = $this->id_cliente;
                                $this->Static['postId'] = $this->Data['id_veiculo'];

                                $this->CreateStatic(self::static_cars, $this->Static);
                            endif;
                        endif;
                    endif;
                endif;
            else:
                $this->Result = false;
                $this->Error  = ["Ops: não encontramos nenhum item no documento!", WS_ERROR];
            endif;
        endif;
    }

    private function FaseII(){
        $t_desconto = 0;
        $t_total = 0;
        $t_imposto = 0;
        $t_value = 0;

        foreach ($this->Helio as $key):
            $value = $key['qtd_tmp'] * $key['preco_tmp'];
            $desconto = ($value * $key['desconto_tmp']) / 100;
            $imposto = ($value * $key['taxa_tmp']) / 100;
            $total = ($value - $desconto) + $imposto;

            $t_total += $total;
            $t_imposto += $imposto;
            $t_desconto += $desconto;
            $t_value += $value;

            if($this->document != 'PP'):
                $Read = new Read();
                $Read->ExeRead(self::static_product, "WHERE id_db_settings=:i AND postId=:y ", "i={$this->id_db_settings}&y={$key['id_product']}");
                if($Read->getResult()):
                    $this->Static['qtd'] = $Read->getResult()[0]['qtd'] + $key['qtd_tmp'];
                    $this->UpdateStatic(self::static_product, $this->Static, $this->id_db_settings, $key['id_product']);
                    if($this->getResult()):
                        unset($this->Static);
                    endif;
                else:
                    $this->Static['qtd'] = $key['qtd_tmp'];
                    $this->Static['id_db_settings'] = $this->id_db_settings;
                    $this->Static['postId'] = $key['id_product'];

                    $this->CreateStatic(self::static_product, $this->Static);
                    if($this->Result):
                        unset($this->Static);
                    endif;
                endif;
            endif;

            $this->sPro = $key;
            unset($this->sPro['id']);
            unset($this->sPro['qtd_tmp']);
            unset($this->sPro['taxa_tmp']);
            unset($this->sPro['preco_tmp']);
            unset($this->sPro['desconto_tmp']);
            unset($this->sPro['system_module']);

            $this->sPro['qtd_pmp'] = $key['qtd_tmp'];
            $this->sPro['taxa_pmp'] = $key['taxa_tmp'];
            $this->sPro['preco_pmp'] = $key['preco_tmp'];
            $this->sPro['desconto_pmp'] = $key['desconto_tmp'];
            $this->sPro['system_module'] = $this->Config['JanuarioSakalumbu'];
            $this->sPro['InvoiceType'] = $this->document;
            $this->sPro['id_invoice'] = $this->ID;

            $this->CreateBody();
        endforeach;

        if($this->document == "FT"):
            $this->taxa['id_db_settings'] = $this->id_db_settings;
            $this->taxa['id_user'] = $this->id_user;
            $this->taxa['id_cliente'] = $this->id_cliente;
            $this->taxa['id_invoice'] = $this->ID;
            $this->taxa['value'] = $t_value;
            $this->taxa['desconto'] = $t_desconto;
            $this->taxa['imposto'] = $t_imposto;
            $this->taxa['total'] = $t_total;
            $this->taxa['InvoiceType'] = $this->document;
            $this->taxa['dia'] = date('d');
            $this->taxa['mes'] = date('m');
            $this->taxa['ano'] = date('Y');

            $this->CreateStory();
        endif;

        $Delete = new Delete();
        $Delete->ExeDelete(self::billing_tmp, "WHERE id_db_settings=:i AND id_user=:y", "i={$this->id_db_settings}&y={$this->id_user}");

        if($Delete->getResult() || $Delete->getRowCount()):
            $this->Result = true;
            $this->Error  = ["Documento finalizado com sucesso!", WS_ACCEPT];
        else:
            $this->Result = false;
            $this->Error  = ["Ops: aconteceu um erro inesperado ao finalizar o documento!", WS_ERROR];
        endif;
    }

    private function CreateStory(){
        $Create = new Create();
        $Create->ExeCreate(self::billing_story, $this->taxa);

        if($Create->getResult()):
            $this->Result = true;
            $this->ID     = $Create->getResult();
            $this->Error  = ["Sucesso! (3)", WS_ACCEPT];
        else:
            $this->Error  = ["Error! (3)", WS_ERROR];
            $this->Result = false;
        endif;
    }

    private function CreateBody(){
        $Create = new Create();
        $Create->ExeCreate(self::billing_pmp, $this->sPro);

        if($Create->getResult()):
            $this->Result = true;
            $this->Error  = ["Sucesso! (2)", WS_ACCEPT];
        else:
            $this->Error  = ["Error! (2)", WS_ERROR];
            $this->Result = false;
        endif;
    }

    private function CreateFinish(){
        $Create = new Create();
        $Create->ExeCreate(self::billing, $this->Data);

        if($Create->getResult()):
            $this->Result = true;
            $this->ID     = $Create->getResult();
            $this->Error  = ["Sucesso!", WS_ACCEPT];
        else:
            $this->Error  = ["Error", WS_ERROR];
            $this->Result = false;
        endif;
    }

    private function CheckSystem($id_db_settings){
        $Read = new Read();
        $Read->ExeRead(self::system, "WHERE id=:i", "i={$id_db_settings}");

        if($Read->getResult()):
            $this->System = $Read->getResult()[0];
            $this->Result = $Read->getResult()[0];
        else:
            $this->Result = false;
            $this->Error  = ["Ops: não encontramos a empresa selecionada!", WS_ERROR];
        endif;
    }

    private function Hash($db = null){
        $config = array();
        $config['config'] = dirname(__FILE__) . '/openssl.cnf';

        $privateKey = openssl_pkey_new(array(
                'private_key_bits' => 1024,
                'private_key_type' => OPENSSL_KEYTYPE_RSA,
            ) + $config);

        openssl_pkey_export($privateKey, $privkey, "sha512",  $config);
        $publickey = openssl_pkey_get_details($privateKey);
        $publickey = $publickey["key"];

        $pub1 = explode(" ", $publickey);
        $agua = substr($pub1[2], 47, 172);


        $pri2 = explode(" ", $privkey);
        $cerveja = substr($pri2[3], 151, 70);
        //var_dump($agua); echo "\n"; var_dump($cerveja);
        $this->Hash = $agua;
        $this->HashControl = $cerveja;
        $this->Data['hash'] = $this->Hash;
        $this->Data['hashcontrol'] = $this->HashControl;
    }

    public function Rectification($id_db_settings, $id_user,  $document, $method, $postId, $InvoiceType, $Rectification){
        $this->id_db_settings = (int) $id_db_settings;
        $this->id_user = (int) $id_user;
        $this->document = $document;
        $this->method = $method;
        $this->postId = (int) $postId;
        $this->InvoiceType = $InvoiceType;
        $this->Rectification = $Rectification;

        if(!isset($this->id_user) || !isset($this->id_db_settings) || !isset($this->document) || !isset($this->method) || !isset($this->postId) || !isset($this->InvoiceType) || !isset($this->Rectification)):
            $this->Result = false;
            $this->Error  = ["Ops: aconteceu um erro inesperado na recolha de dados!", WS_ERROR];
        else:
            $Read = new Read();
            $Read->ExeRead(self::billing, "WHERE id=:i AND id_db_settings=:y AND InvoiceType=:st", "i={$this->postId}&y={$this->id_db_settings}&st={$this->InvoiceType}");

            if($Read->getResult()):
                $this->Info = $Read->getResult()[0];
                $st = 2;
                $Read->ExeRead(self::billing, "WHERE id_db_settings=:i AND id_invoice=:y AND status=:st", "i={$this->id_db_settings}&y={$postId}&st={$st}");
                if($Read->getResult()):
                    $this->Result = false;
                    $this->Error  = ["Ops: o presente documento já encontra-se aberto no sistema!", WS_ERROR];
                else:
                    $billing = self::billing;
                    $ano = date('Y');

                    $Read = new Read();
                    $Read->ExeRead(self::config, "WHERE id_db_settings=:i", "i={$this->id_db_settings}");
                    if($Read->getResult()):
                        $this->Config = $Read->getResult()[0];
                    else:
                        $this->Result = false;
                        $this->Error  = ["Ops: não encontramos as configurações do sistema!", WS_ALERT];
                    endif;

                    $Read->FullRead("SELECT count(id) AS numeros FROM {$billing} WHERE id_db_settings=:i AND config_module=:y AND InvoiceType=:ip AND ano=:ia", "i={$this->id_db_settings}&y={$this->Config['modulo']}&ip={$this->document}&ia={$ano}");
                    if($Read->getResult()): $this->Numero = $Read->getResult()[0]['numeros'] + 1; else: $this->Numero = 1; endif;

                    $this->Data = $this->Info;
                    $this->Data['InvoiceDate'] = $this->Data['ano']."-".$this->Data['mes']."-".$this->Data['dia'];
                    unset($this->Data['id']);
                    unset($this->Data['numero']);
                    unset($this->Data['hash']);
                    unset($this->Data['hashcontrol']);
                    unset($this->Data['method']);
                    unset($this->Data['InvoiceType']);
                    unset($this->Data['dia']);
                    unset($this->Data['mes']);
                    unset($this->Data['ano']);
                    unset($this->Data['hora']);
                    unset($this->Data['pagou']);
                    unset($this->Data['troco']);
                    unset($this->Data['status']);
                    unset($this->Data['id_user']);
                    unset($this->Data['username']);

                    $this->Data['Invoice'] = $this->InvoiceType." ".$this->Info["mes"].$this->Info['Code'].$this->Info['ano']."/".$this->Info['numero'];
                    $this->Data['id_invoice'] = $this->postId;
                    $this->Data['method'] = $this->method;
                    $this->Data['InvoiceType'] = $this->document;
                    $this->Data['id_user'] = $this->id_user;
                    $this->Data['Numero'] = $this->Numero;
                    $this->Data['Rectification'] = $this->Rectification;
                    if($this->document != "AC"): $this->Data['status'] = 2; else: $this->Data['status'] = 3; endif;
                    $this->Data['dia'] = date('d');
                    $this->Data['mes'] = date('m');
                    $this->Data['ano'] = date('Y');
                    $this->Data['hora'] = date('H:i');
                    $Read->ExeRead(self::users, "WHERE id=:i AND id_db_settings=:y", "i={$this->id_user}&y={$this->id_db_settings}");
                    if($Read->getResult()):
                        $this->Data['username'] = $Read->getResult()[0]['name'];
                    endif;

                    $this->Hash();
                    $this->CreateRectification();
                    if($this->document == "AC"):
                        $this->Pro2Da();
                    endif;
                endif;
            else:
                $this->Result = false;
                $this->Error  = ["Ops: não encontramos o documento a ser rectificado!", WS_ERROR];
            endif;
        endif;
    }

    private function Pro2Da(){
        $Read = new Read();
        $Read->ExeRead(self::billing_story, "WHERE id_db_settings=:i AND id_invoice=:y", "i={$this->id_db_settings}&y={$this->postId}");

        if($Read->getResult()):
            unset($this->Info);
            $this->Info['Invoice'] = $this->Data['Invoice'];
            $this->Info['id_invoice_i'] = $this->postId;
            $this->Info['id_invoice'] = $this->ID;
            $this->Info['value'] = $Read->getResult()[0]['total'];
            $this->Info['data'] = date('d-m-Y');
            $this->Info['id_user'] = $this->id_user;
            $this->Info['id_db_settings'] = $this->id_db_settings;
            $this->Info['InvoiceType'] = $this->document;

            $Create = new Create();
            $Create->ExeCreate(self::billing_ac, $this->Info);

            if($Create->getResult()):
                $this->Error  = ["Aviso de cobrança criado com sucesso!", WS_ACCEPT];
                $this->Result = false;
            else:
                $this->Result = false;
                $this->Error  = ["Ops: aconteceu um erro inesperado ao criar o aviso de cobrança!", WS_ERROR];
            endif;
        else:
            $this->Result = false;
            $this->Error  = ["Ops: não encontramos o histórico da factura! (2)", WS_ERROR];
        endif;
    }

    private function CreateRectification(){
        $Create = new Create();
        $Create->ExeCreate(self::billing, $this->Data);

        if($Create->getResult()):
            if($this->document == "AC"): $this->ID = $Create->getResult(); endif;
            $this->Result = true;
        else:
            $this->Error  = ["Ops: aconteceu um erro inesperado ao criar o documento de rectificação!", WS_ERROR];
            $this->Result = false;
        endif;
    }

    public function BodyRectification($id_db_settings, $id_user, $id_billing_pmp, $id_product, $qtd, $postId, $document){
        $this->id_db_settings = (int) $id_db_settings;
        $this->id_user = (int) $id_user;
        $this->postId = (int) $postId;
        $this->ID = (int) $id_billing_pmp;
        $this->id_product = (int) $id_product;
        $this->quantidade = (int) $qtd;
        $this->document = $document;

        if($this->quantidade <= 0):
            $this->Result = false;
            $this->Error  = ["Ops: não é permitido adicionar quantidade menor ou igual a zero!", WS_ALERT];
        else:
            $Read = new Read();
            $Read->ExeRead(self::billing_pmp, "WHERE id=:ip AND id_db_settings=:i AND id_product=:y", "ip={$this->ID}&i={$this->id_db_settings}&y={$this->id_product}");
            if($Read->getResult()):
                $this->Info = $Read->getResult()[0];
                $this->Data = $Read->getResult()[0];
                $this->Data['id_invoice_i'] = $this->Data['id_invoice'];
                unset($this->Data['id']);
                unset($this->Data['qtd_pmp']);
                unset($this->Data['id_invoice']);
                unset($this->Data['InvoiceType']);
                unset($this->Data['id_user']);

                $st = 2;
                $Read->ExeRead(self::billing, "WHERE id_db_settings=:i AND id_invoice=:y AND status=:st", "i={$this->id_db_settings}&y={$this->postId}&st={$st}");

                if($Read->getResult()):
                    $this->Data['id_invoice'] = $Read->getResult()[0]['id'];
                    $this->Data['qtd_pmp'] = $this->quantidade;
                    $this->Data['InvoiceType'] = $Read->getResult()[0]['InvoiceType'];
                    $this->Data['id_invoice_pmp'] = $this->ID;
                    $this->Data['Invoice'] = $Read->getResult()[0]['Invoice'];
                    $this->Data['id_user'] = $this->id_user;

                    if($this->document == "RE"):
                        $Read->ExeRead(self::billing_story, "WHERE id_db_settings=:i AND id_invoice=:y", "i={$this->id_db_settings}&y={$this->postId}");
                        if($Read->getResult()):
                            $this->taxa = $Read->getResult()[0]["total"];
                            $value = $this->Info['preco_pmp'] * $this->quantidade;
                            $imposto = ($this->Info['taxa_pmp'] * $value) / 100;
                            $desconto = ($this->Info['desconto_pmp'] * $value) / 100;
                            $total = ($value - $desconto) + $imposto;
                            $this->preco['total'] = ($this->taxa - $total);
                        else:
                            $this->Result = false;
                            $this->Error  = ["Ops: não conseguimos encontrar o histórico da divida!", WS_ERROR];
                        endif;
                    endif;

                    if($this->document == "RE"):
                        $this->UpdateStory();
                        if($this->Result):
                            $this->CreateBodyRectification();
                        endif;
                    else:
                        $this->CreateBodyRectification();
                    endif;
                else:
                    $this->Result = false;
                    $this->Error  = ["Ops: não encontramos nenhum documento em aberto!", WS_ERROR];
                endif;
            else:
                $this->Result = false;
                $this->Error  = ["Ops: não encontramos a linha selecionada!", WS_ERROR];
            endif;
        endif;
    }

    private function UpdateStory(){
        $Update = new Update();
        $Update->ExeUpdate(self::billing_story,  $this->preco, "WHERE id_db_settings=:i AND id_invoice=:y", "i={$this->id_db_settings}&y={$this->postId}");

        if($Update->getResult()):
            $this->Result = true;
            $this->Error  = ["Aqui!!!", WS_INFOR];
        else:
            $this->Error  = ["Ops: aconteceu um erro inesperado ao salvar o histórico!", WS_ERROR];
            $this->Result = false;
        endif;
    }

    private function CreateBodyRectification(){
        $Create = new Create();
        $Create->ExeCreate(self::billing_pmp, $this->Data);

        if($Create->getResult()):
            $this->Result = true;
        else:
            $this->Result = false;
            $this->Error  = ["Ops: aconteceu um erro inesperado ao finalizar a operação!", WS_ERROR];
        endif;
    }

    public function FinishRectification($id_db_settings, $id_user, $postId){
        $this->postId = (int) $postId;
        $this->id_db_settings = (int) $id_db_settings;
        $this->id_user = (int) $id_user;

        $st = 2;
        $this->Data['status'] = 3;
        $Update = new Update();
        $Update->ExeUpdate(self::billing, $this->Data, "WHERE id_db_settings=:i AND id_user=:ip AND id_invoice=:y AND status=:st", "i={$this->id_db_settings}&ip={$this->id_user}&y={$postId}&st={$st}");

        if($Update->getResult()):
            $this->Result = false;
            $this->Error  = ["Documento finalizado com sucesso!", WS_ACCEPT];
        else:
            $this->Error  = ["Ops: aconteceu um erro inesperado ao finalizar o documento de rectificação!", WS_ERROR];
            $this->Result = false;
        endif;
    }

    public static function Timer($id, $numero, $invoice){
        $Read = new Read();
        $Read->ExeRead(self::billing, "WHERE id=:y AND  numero=:i AND InvoiceType=:id", "y={$id}&i={$numero}&id={$invoice}");

        if($Read->getResult()):
            $k = $Read->getResult()[0];
            $Data['timer'] = $k['timer'] + 1;

            $Update = new Update();
            $Update->ExeUpdate(self::billing, $Data, "WHERE id=:y AND numero=:i AND InvoiceType=:id", "y={$id}&i={$numero}&id={$invoice}");

            if(!$Update->getResult()):
                return false;
            else:
                return true;
            endif;
        endif;
    }

    public static function Config($id_db_settings){
        $Read = new Read();
        $Read->ExeRead(self::config, "WHERE id_db_settings=:i", "i={$id_db_settings}");

        if($Read->getResult()):
            return $Read->getResult()[0];
        else:
            return false;
        endif;
    }
}
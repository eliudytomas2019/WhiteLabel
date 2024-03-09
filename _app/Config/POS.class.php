<?php
class POS{
    private $Data, $Result, $Error, $Alert, $Info, $Session, $id_db_settings, $ID, $id_mesa, $Finish, $Number, $Hash, $Numero, $Help, $InvoiceType, $id_product, $qtdOne, $HashControl, $Value, $id_garcom, $postId, $Base, $id_db_kwanzar, $Credito, $method;
    const
        cv_pedido_product   = "cv_pedido_product",
        cv_product          = "cv_product",
        db_taxtable         = "db_taxtable",
        sd_billing          = "sd_billing",
        sd_billing_pmp      = "sd_billing_pmp",
        sd_billing_tmp      = "sd_billing_tmp",
        sd_retification     = "sd_retification",
        sd_retification_pmp = "sd_retification_pmp",
        sd_guid             = "sd_guid",
        sd_guid_pmp         = "sd_guid_pmp",
        settings_gallery = "db_settings_gallery",
        credito = "cv_customer_credito",
        ws_times    = "ws_times",
        db_settings = "db_settings",
        cv_customer = "cv_customer",
        db_users    = "db_users",
        sd_box      = "sd_box";

    public function getResult(){return $this->Result;}
    public function getError(){return $this->Error;}

    private $id_customer;

    public function TaxPointDate($Data, $Number, $id_db_settings, $id_user, $postId, $id_db_kwanzar){
        $this->Data  = $Data;
        $this->id_db_settings = $id_db_settings;
        $this->id_user = $id_user;
        $this->postId = $postId;
        $this->id_db_kwanzar = $id_db_kwanzar;
        $this->Number = $Number;


        $xy = explode("-", $Data['TaxPointDate']);
        $this->Data['dia'] = $xy[2];
        $this->Data['mes'] = $xy[1];
        $this->Data['ano'] = $xy[0];

        $this->UpdateTaxPointDate();
    }

    private function UpdateTaxPointDate(){
        $Update = new Update();
        $Update->ExeUpdate(self::sd_billing, $this->Data, "WHERE id=:id AND numero=:i ", "id={$this->postId}&i={$this->Number}");

        if($Update->getResult()):
            $this->Error = ["Atualizamos com sucesso a data da factura!", WS_ACCEPT];
            $this->Result = true;
        else:
            $this->Error = ["Aconteceu um erro inesperado ao atualizar a data da factura!", WS_ERROR];
            $this->Result = false;
        endif;
    }

    public function Conversor(array $data, $id_db_settings, $id_user, $postId, $id_db_kwanzar, $customer, $method){
        $this->Base = $data;
        $this->id_db_settings = $id_db_settings;
        $this->Session = $id_user;
        $this->postId = $postId;
        $this->id_db_kwanzar = $id_db_kwanzar;

        $this->id_customer = $customer;
        $this->method = $method;

        $pp = "PP";

        $Read = new Read();
        $Read->ExeRead(self::sd_billing, "WHERE id_db_settings=:i AND InvoiceType=:iv AND numero=:ibb ORDER BY id DESC LIMIT 1", "i={$this->id_db_settings}&iv={$pp}&ibb={$this->postId}");

        if ($Read->getResult()):
            foreach ($Read->getResult() as $key):
                $this->Data = $key;

                $this->Data['pp_number'] = $this->Data['numero'];

                unset($this->Data['id_customer']);
                unset($this->Data['customer_name']);
                unset($this->Data['customer_nif']);
                unset($this->Data['customer_telefone']);
                unset($this->Data['customer_endereco']);
                unset($this->Data['customer_endereco_final']);

                unset($this->Data['id']);
                unset($this->Data['numero']);
                unset($this->Data['method']);
                unset($this->Data['hash']);
                unset($this->Data['hashcontrol']);
                unset($this->Data['InvoiceType']);
                unset($this->Data['TaxPointDate']);
                unset($this->Data['session_id']);
                unset($this->Data['username']);
                unset($this->Data['status']);
                unset($this->Data['dia']);
                unset($this->Data['mes']);
                unset($this->Data['ano']);
                unset($this->Data['hora']);
                unset($this->Data['date_expiration']);
                unset($this->Data['timer']);
                unset($this->Data['status']);

                unset($this->Data['pagou']);
                unset($this->Data['troco']);
                unset($this->Data['cartao_de_debito']);
                unset($this->Data['transferencia']);
                unset($this->Data['numerario']);
                unset($this->Data['all_total']);

                $this->Data['InvoiceType'] = $this->Base['InvoiceType'];

                $this->Data['pagou'] = $this->Base['pagou'];
                $this->Data['troco'] = $this->Base['troco'];
                $this->Data['cartao_de_debito'] = $this->Base['cartao_de_debito'];
                $this->Data['transferencia'] = $this->Base['transferencia'];
                $this->Data['numerario'] = $this->Base['numerario'];
                $this->Data['all_total'] = $this->Base['all_total'];


                $this->Info = $this->Data;
                $this->Info['status'] = 1;

                $this->Number();
                if ($this->Result):
                    $this->Info['numero'] = $this->Number;
                    $this->Info['method'] = $this->method;
                    $this->DattingCoversor();
                    if ($this->Result):
                        $this->Hash(self::sd_billing);
                        if ($this->Result):
                            $this->CreateFact();

                            if($this->Result):
                                $this->Result = true;
                            endif;
                        endif;
                    endif;
                endif;
            endforeach;
        endif;

        $status = 1;
        $suspenso = 0;

        unset($this->Data);
        unset($this->Info);

        $Read = new Read();
        $Read->ExeRead(self::sd_billing, "WHERE id_db_settings=:st AND session_id=:ses AND status=:p AND suspenso=:sp AND numero=:n1 AND InvoiceType=:iv", "st={$this->id_db_settings}&ses={$this->Session}&p={$status}&sp={$suspenso}&n1={$this->Number}&iv={$this->Base['InvoiceType']}");

        if ($Read->getResult()):
            $this->Sheldon = $Read->getResult()[0];
            //$this->Number  = $Read->getResult()[0]['numero'];
            $this->Help = $Read->getResult()[0]['SourceBilling'];

            if ($Read->getResult()[0]['InvoiceType'] != 'PP'):
                $Read->ExeRead(self::static_customer, "WHERE id_db_settings=:i AND id_cv_customer=:ip", "i={$this->id_db_settings}&ip={$this->Sheldon['id_customer']}");

                if ($Read->getResult()):
                    $cPlus = $Read->getResult()[0]['counting'] + 1;
                    $dPlus = ["counting" => $cPlus];

                    $Update = new Update();
                    $Update->ExeUpdate(self::static_customer, $dPlus, "WHERE id_db_settings=:i AND id_cv_customer=:ip", "i={$this->id_db_settings}&ip={$this->Sheldon['id_customer']}");

                    if (!$Update->getResult()):
                        $this->Error = ["Ops: aconteceu um erro inesperado ao salvar a contagem de clientes;", WS_ERROR];
                        $this->Result = false;
                    endif;
                else:
                    $sPlus = ["id_db_settings" => $this->id_db_settings, "id_cv_customer" => $this->Sheldon['id_customer'], "counting" => 1];

                    $Create = new Create();
                    $Create->ExeCreate(self::static_customer, $sPlus);

                    if (!$Create->getResult()):
                        $this->Error = ["Ops: aconteceu um erro inesperado ao salvar a contagem de clientes;", WS_ERROR];
                        $this->Result = false;
                    endif;
                endif;

                $Read->ExeRead(self::static_users, "WHERE id_db_settings=:i AND id_db_users=:ip", "i={$this->id_db_settings}&ip={$this->Sheldon['session_id']}");

                if ($Read->getResult()):
                    $nPlus = $Read->getResult()[0]['counting'] + 1;
                    $vPlus = ["counting" => $nPlus];

                    $Update = new Update();
                    $Update->ExeUpdate(self::static_users, $vPlus, "WHERE id_db_settings=:i AND id_db_users=:ip", "i={$this->id_db_settings}&ip={$this->Sheldon['session_id']}");

                    if (!$Update->getResult()):
                        $this->Error = ["Ops: aconteceu um erro inesperado ao salvar a contagem de usuário;", WS_ERROR];
                        $this->Result = false;
                    endif;
                else:
                    $mPlus = ["id_db_settings" => $this->id_db_settings, "id_db_users" => $this->Sheldon['session_id'], "counting" => 1];

                    $Create = new Create();
                    $Create->ExeCreate(self::static_users, $mPlus);

                    if (!$Create->getResult()):
                        $this->Error = ["Ops: aconteceu um erro inesperado ao salvar a contagem de usuário;", WS_ERROR];
                        $this->Result = false;
                    endif;
                endif;
            endif;

            $this->DataProductConversor();
            if($this->Result):
                $this->Result = true;
                $this->Error = ["Conversão finalizada com sucesso!", WS_ACCEPT];
            endif;
        else:
            $this->Error = ["Ops: não encontramos nenhum documento em aberto!", WS_INFOR];
            $this->Result = false;
        endif;
    }

    private function DataProductConversor(){
        $suspenso = 0;
        $pp = "PP";

        $Read = new Read();
        $Read->ExeRead(self::sd_billing_pmp, "WHERE id_db_settings=:i AND InvoiceType=:iv AND numero=:ibb", "i={$this->id_db_settings}&iv={$pp}&ibb={$this->postId}");
        if($Read->getResult()):
            foreach($Read->getResult() as $key):
                extract($key);
                $this->Info = $key;
                $this->Data['product_code'] = $this->Info['product_list'];
                $Read->ExeRead(self::cv_product, "WHERE id=:id_product AND id_db_settings=:st", "id_product={$key['id_product']}&st={$this->id_db_settings}");

                if($Read->getResult()):
                    $this->SheldonII = $Read->getResult()[0];
                    if($this->Sheldon['InvoiceType'] != 'PP'):
                        $functions = new Read();

                        $functions->ExeRead(self::static_product, "WHERE id_db_settings=:i AND id_cv_product=:ip", "i={$this->id_db_settings}&ip={$this->SheldonII['id']}");

                        if($functions->getResult()):
                            $cPlus = ["counting" => $functions->getResult()[0]['counting'] + $this->Info['quantidade_pmp']];

                            $Update = new Update();
                            $Update->ExeUpdate(self::static_product, $cPlus, "WHERE id_db_settings=:i AND id_cv_product=:ip", "i={$this->id_db_settings}&ip={$this->SheldonII['id']}");

                            if(!$Update->getResult()):
                                $this->Error  = ["Ops: aconteceu um erro inesperado ao salvar a contagem de produtos/serviços;", WS_ERROR];
                                $this->Result = false;
                            endif;
                        else:
                            $sPlus = ["id_db_settings" => $this->id_db_settings, "id_cv_product" => $this->SheldonII['id'], "counting" => 1];

                            $Create = new Create();
                            $Create->ExeCreate(self::static_product, $sPlus);

                            if(!$Create->getResult()):
                                $this->Error  = ["Ops: aconteceu um erro inesperado ao salvar a contagem de produtos;", WS_ERROR];
                                $this->Result = false;
                            endif;
                        endif;
                    endif;

                    if($Read->getResult()[0]['type'] != 'S'):
                        $this->Alert = $Read->getResult()[0];
                        /**if(DBKwanzar::CheckSettingsII($this->id_db_settings)['atividade'] == 1 || DBKwanzar::CheckSettingsII($this->id_db_settings)['atividade'] == 4):
                            $qtd = $Read->getResult()[0]['quantidade'];
                        else:
                            $qtd = $Read->getResult()[0]['gQtd'];
                        endif;**/

                        $qtd = $Read->getResult()[0]['quantidade'];

                        if(DBKwanzar::CheckConfig($this->id_db_settings) != false):
                            if(DBKwanzar::CheckConfig($this->id_db_settings)['HeliosPro'] == 2 && $qtd <= DBKwanzar::CheckConfig($this->id_db_settings)['estoque_minimo']):
                                $this->Error  = ["Ops: não existe quantatidade suficiente de <strong>{$Read->getResult()[0]['product']}</strong> no estoque!", WS_ALERT];
                                $this->Result = false;
                            elseif(DBKwanzar::CheckConfig($this->id_db_settings)['HeliosPro'] != 1):
                                if($this->Sheldon['InvoiceType'] != 'PP'):
                                    $this->DescontoConversor();
                                endif;
                                $this->ProcessPmPConversor();
                            else:
                                $this->ProcessPmPConversor();
                            endif;
                        else:
                            $this->ProcessPmPConversor();
                        endif;
                    else:
                        $this->ProcessPmPConversor();
                    endif;

                    if($this->Result):
                        $this->DataFinishConversor();
                    endif;
                endif;
            endforeach;
        else:
            $this->Error  = ["Ops: não encontramos itens adicionado na factura.", WS_ALERT];
            $this->Result = false;
        endif;
    }

    private function DescontoConversor(){
        $qtd = $this->Alert['quantidade'] - $this->Info['quantidade_pmp'];
        $Dados['quantidade'] = $qtd;

        $Update = new Update();
        $Update->ExeUpdate(self::cv_product, $Dados, "WHERE id=:id AND id_db_settings=:st", "id={$this->Alert['id']}&st={$this->id_db_settings}");

        if($Update->getResult()):
            $this->Result = true;
        else:
            $this->Error  = ["Ops: aconteceu um erro inesperado ao atualizar o produto/serviço <strong>{$this->Alert['product']}</strong>", WS_INFOR];
            $this->Result = false;
        endif;
    }

    private function ProcessPmPConversor(){
        if(DBKwanzar::CheckConfig($this->id_db_settings) == false || DBKwanzar::CheckConfig($this->id_db_settings)['JanuarioSakalumbu'] == null): $ttt = 2; else: $ttt = DBKwanzar::CheckConfig($this->id_db_settings)['JanuarioSakalumbu']; endif;

        $this->Data['id_db_settings']     = $this->id_db_settings;
        $this->Data['id_product']         = $this->Info['id_product'];
        $this->Data['session_id']         = $this->Info['session_id'];
        $this->Data['id_mesa']            = $this->Info['id_mesa'];
        $this->Data['quantidade_pmp']     = $this->Info['quantidade_pmp'];
        $this->Data['preco_pmp']          = $this->Info['preco_pmp'];
        $this->Data['desconto_pmp']       = $this->Info['desconto_pmp'];
        $this->Data['taxa']               = $this->Info['taxa'];
        $this->Data['TaxExemptionCode']   = $this->Info['TaxExemptionCode'];
        $this->Data['TaxExemptionReason'] = $this->Info['TaxExemptionReason'];
        $this->Data['taxType']            = $this->Info['taxType'];
        $this->Data['taxCode']            = $this->Info['taxCode'];
        $this->Data['TaxCountryRegion']   = $this->Info['TaxCountryRegion'];
        $this->Data['taxAmount']          = $this->Info['taxAmount'];
        $this->Data['description']        = $this->Info['description'];
        $this->Data['product_name']       = $this->Info['product_name'];
        $this->Data['product_code']       = $this->Info['product_code'];
        $this->Data['product_list']       = $this->Info['product_list'];
        $this->Data['product_uni']        = $this->Info['product_uni'];
        $this->Data['product_type']       = $this->Info['product_type'];
        $this->Data['product_id_category']= $this->Info['product_id_category'];
        $this->Data['product_codigo_barras']= $this->Info['product_codigo_barras'];
        $this->Data['InvoiceType']        = $this->Sheldon['InvoiceType'];
        $this->Data['suspenso']           = 0;
        $this->Data['box_in']             = 1;
        $this->Data['numero']             = $this->Number;
        $this->Data['status']             = $ttt;
        $this->Data['SourceBilling']      = $this->Help;

        $Create = new Create();
        $Create->ExeCreate(self::sd_billing_pmp, $this->Data);

        if($Create->getResult()):
            $this->Result = true;
        else:
            $this->Error  = ["Ops: aconteceu um erro inesperado ao adicionar o item <strong>{$this->Data['product_name']}</strong> na factura final!", WS_ALERT];
            $this->Result = false;
        endif;
    }

    private function DataFinishConversor(){
        if(DBKwanzar::CheckConfig($this->id_db_settings) == false || DBKwanzar::CheckConfig($this->id_db_settings)['JanuarioSakalumbu'] == null): $ttt = 2; else: $ttt = DBKwanzar::CheckConfig($this->id_db_settings)['JanuarioSakalumbu']; endif;

        if(isset($this->id_mesa) && !empty($this->id_mesa) || isset($this->id_mesa) && $this->id_mesa != null): $mesa = " AND id_mesa={$this->id_mesa} "; else:  $mesa = null; endif;

        $this->Finish['status'] = $ttt;
        $status = 1;
        $suspenso = 0;

        $Update = new Update();
        $Update->ExeUpdate(self::sd_billing, $this->Finish, "WHERE id_db_settings=:st AND session_id=:ses {$mesa} AND status=:p AND suspenso=:sp ORDER BY id DESC LIMIT 1", "st={$this->id_db_settings}&ses={$this->Session}&p={$status}&sp={$suspenso}");

        if($Update->getResult()):
            $Read = new Read();
            $Read->ExeRead(self::ws_times, "WHERE id_db_kwanzar=:i", "i={$this->id_db_kwanzar}");
            if($Read->getResult()):
                $local['documentos_feito'] = $Read->getResult()[0]['documentos_feito'] + 1;
                $Update = new Update();
                $Update->ExeUpdate(self::ws_times, $local,"WHERE id_db_kwanzar=:i", "i={$this->id_db_kwanzar}");

                if($Update->getResult()):
                    $this->Result = true;
                else:
                    $this->Result = false;
                    $this->Error = ["Oops: aconteceu um erro inesperado ao limitar os documentos emitidos!", WS_ERROR];
                endif;
            endif;
        else:
            $this->Error  = ["Ops: aconteceu um erro inesperado ao finalizar a factura!", WS_ERROR];
            $this->Result = false;
        endif;
    }

    private function DattingCoversor(){
        $Read = new Read();
        $Read->ExeRead(self::db_settings, "WHERE id=:i", "i={$this->id_db_settings}");

        if(DBKwanzar::CheckConfig($this->id_db_settings) == false || DBKwanzar::CheckConfig($this->id_db_settings)['sequencialCode'] == null || DBKwanzar::CheckConfig($this->id_db_settings)['sequencialCode'] == '' || empty(DBKwanzar::CheckConfig($this->id_db_settings)['sequencialCode']) || !isset(DBKwanzar::CheckConfig($this->id_db_settings)['sequencialCode'])): $code = null; else: $code = DBKwanzar::CheckConfig($this->id_db_settings)['sequencialCode']; endif;

        if($Read->getResult()):
            $f = $Read->getResult()[0];

            if(DBKwanzar::CheckConfig($this->id_db_settings) != false): $fe = DBKwanzar::CheckConfig($this->id_db_settings)['moeda']; else:  $fe = "AOA"; endif;

            // Informações da empresa
            $this->Info['settings_empresa']     = $f['empresa'];
            $this->Info['settings_nif']         = $f['nif'];
            $this->Info['settings_telefone']    = $f['telefone'];
            $this->Info['settings_email']       = $f['email'];
            $this->Info['settings_endereco']    = $f['endereco'];
            $this->Info['settings_logotype']    = $f['logotype'];
            $this->Info['settings_rodape']      = $f['makeUp'];

            $this->Info['settings_nib']         = $f['nib'];
            $this->Info['settings_iban']        = $f['iban'];
            $this->Info['settings_banco']        = $f['banco'];
            $this->Info['settings_swift']       = $f['swift'];

            $this->Info['settings_nib1']         = $f['nib1'];
            $this->Info['settings_iban1']        = $f['iban1'];
            $this->Info['settings_banco1']        = $f['banco1'];
            $this->Info['settings_swift1']       = $f['swift1'];

            $this->Info['settings_nib2']         = $f['nib2'];
            $this->Info['settings_iban2']        = $f['iban2'];
            $this->Info['settings_banco2']        = $f['banco2'];
            $this->Info['settings_swift2']       = $f['swift2'];

            $this->Info['settings_website']     = $f['website'];
            $this->Info['settings_city']        = $f['city'];
            $this->Info['settings_taxEntity']   = $f['taxEntity'];
            $this->Info['settings_coordenadas'] = $f['coordenadas'];
            $this->Info['settings_moeda']       = $fe;
        endif;

        // Informações de data e local
        $this->Info['dia']          = date('d');
        $this->Info['mes']          = date('m');
        $this->Info['ano']          = date('Y');
        $this->Info['hora']         = date('H:i:s');
        $this->Info['TaxPointDate'] = date('Y-m-d');
        $this->Info['InvoiceType']  = $this->Data['InvoiceType'];
        $this->Info['Code']         = $code;
        $this->Info['config_regimeIVA']  = DBKwanzar::CheckConfig($this->id_db_settings)['regimeIVA'];

        if(DBKwanzar::CheckConfig($this->id_db_settings) == true && DBKwanzar::CheckConfig($this->id_db_settings)['IncluirNaFactura'] == 2):
            $this->Info['IncluirNaFactura'] = DBKwanzar::CheckConfig($this->id_db_settings)['IncluirNaFactura'];
            $this->Info['RetencaoDeFonte']  = DBKwanzar::CheckConfig($this->id_db_settings)['RetencaoDeFonte'];
        endif;

        $Read->ExeRead(self::cv_customer, "WHERE id=:i AND id_db_settings=:st", "i={$this->id_customer}&st={$this->id_db_settings}");
        if($Read->getResult()):
            $a = $Read->getResult()[0];

            // Informações dos clientes;
            $this->Info['customer_name']     = $a['nome'];
            $this->Info['customer_endereco'] = $a['endereco'];
            $this->Info['customer_telefone'] = $a['telefone'];
            $this->Info['customer_nif']      = $a['nif'];
            $this->Info['id_customer']       = $this->id_customer;
            if($this->Info['customer_name'] != "Consumidor final" && $a['city'] != "Consumidor final"):
                $this->Info['customer_endereco_final'] = $a['city']." - Angola";
            endif;
        endif;

        $Read->FullRead("SELECT name FROM db_users WHERE id=:i ", "i={$this->Session}");
        if($Read->getResult()):
            $this->Info['session_id'] = $this->Session;
            $this->Info['username'] = $Read->getResult()[0]['name'];
        endif;

        $this->Info['box_in'] = 1;
        $this->Result = true;
    }

    public function ProcessPDV($id_db_settings, $id_user, $id_product, $id_mesa){
        $this->id_db_settings = (int) $id_db_settings;
        $this->id_user = (int) $id_user;
        $this->id_mesa = (int) $id_mesa;
        $this->id_product = (int) $id_product;

        $Read = new Read();
        $Read->ExeRead(self::cv_product, "WHERE id=:i", "i={$this->id_product}");
        if($Read->getResult()):
            $key = $Read->getResult()[0];

            $promocao = explode("-", $key['data_fim_promocao']);
            if($promocao[0] >= date('Y')):
                if($promocao[1] >= date('m')):
                    if($promocao[2] >= date('d')):
                        $preco = $key['preco_promocao'];
                    else:
                        $preco = $key['preco_promocao'];
                    endif;
                else:
                    $preco = $key['preco_promocao'];
                endif;
            elseif($promocao[0] < date('Y')):
                $preco = $key['preco_venda'];
            endif;

            $Data['id_product'] = $this->id_product;
            $Data['quantidade'] = 1;
            $Data['preco'] = $preco;
            $Data['taxa'] = $key['id_iva'];
            $Data['desconto'] = 0;

            $this->Add($Data, $this->id_db_settings, $this->id_user, $id_mesa);
        endif;
    }

    public function Add(array $data, $id_db_settings, $id_users, $id_mesa = null){
        unset($this->id_db_settings);
        unset($this->id_mesa);
        if($id_mesa != null): $this->id_mesa = $id_mesa; endif;
        $this->Data = $data;
        $this->id_db_settings = $id_db_settings;
        $this->Session = $id_users;

        if($this->Data['quantidade'] <= 0 || $this->Data['desconto'] < 0 || $this->Data['preco'] <= 0):
            $this->Error  = ["Ops: não é permitido a inserção de válores negativos no documento de venda!", WS_ERROR];
            $this->Result = false;
        elseif($this->Data['desconto'] >= $this->Data['preco']):
            $this->Error  = ["Ops: não é permitido aplicar desconto acima de 100%", WS_ALERT];
            $this->Result = false;
        elseif(!isset($this->Data['page_found']) || empty($this->Data['page_found'])):
            $this->Error = ["Não encontramos a página especifica onde será adicionada o item!", WS_INFOR];
            $this->Result = false;
        else:
            $Read = new Read();
            $Read->ExeRead(self::cv_product, "WHERE id=:i AND id_db_settings=:id", "i={$this->Data['id_product']}&id={$this->id_db_settings}");

            if($Read->getResult()):
                $this->Info = $Read->getResult()[0];
                $PP = $Read->getResult()[0];
                /**if(DBKwanzar::CheckSettingsII($this->id_db_settings)['atividade'] == 1 || DBKwanzar::CheckSettingsII($this->id_db_settings)['atividade'] == 4):
                    $qtd = $PP['quantidade'];
                else:
                    $qtd = $PP['gQtd'];
                endif;**/

                $qtd = $PP['quantidade'];

                if($PP['type'] != 'S'):
                    if(DBKwanzar::CheckConfig($this->id_db_settings) != false):
                        if($qtd <= DBKwanzar::CheckConfig($this->id_db_settings)['estoque_minimo'] && DBKwanzar::CheckConfig($this->id_db_settings)['HeliosPro'] == 2):
                            $this->Error  = ["Ops: quantidade em estoque está insuficiênte!", WS_INFOR];
                            $this->Result = false;
                        else:
                            $this->CheckProduct();
                        endif;
                    else:
                        $this->CheckProduct();
                    endif;
                else:
                    $this->CheckProduct();
                endif;
            else:
                $this->Error  = ["Ops: não encontramos nenhum produto!", WS_INFOR];
                $this->Result = false;
            endif;
        endif;
    }

    private function CheckProduct(){
        $suspenso = 0;
        if(isset($this->id_mesa) && !empty($this->id_mesa) || isset($this->id_mesa) && $this->id_mesa != null): $mesa = " AND id_mesa={$this->id_mesa}"; else: $mesa = null; endif;

        $where = "WHERE id_db_settings={$this->id_db_settings} AND id_product={$this->Data['id_product']} AND session_id={$this->Session} AND page_found='{$this->Data['page_found']}' ".$mesa." AND suspenso={$suspenso}";

        $whe =  "WHERE id_db_settings={$this->id_db_settings} AND session_id={$this->Session} AND page_found='{$this->Data['page_found']}' ".$mesa." AND suspenso={$suspenso}";

        $Read = new Read();
        $Read->ExeRead(self::sd_billing_tmp, $where);

        if($Read->getResult()):
            $this->Alert                    = $Read->getResult()[0];
            $this->Finish['quantidade_tmp'] = $this->Data['quantidade'] + $this->Alert['quantidade_tmp'];
            $this->Finish['desconto_tmp']   = $this->Data['desconto'];
            $this->Finish['page_found']   = $this->Data['page_found'];

            $Read->ExeRead(self::cv_product, "WHERE id=:i", "i={$this->Alert['id_product']}");
            if($Read->getResult()):
                $heliospro = $Read->getResult()[0];
                /**if(DBKwanzar::CheckSettingsII($this->id_db_settings)['atividade'] == 1 || DBKwanzar::CheckSettingsII($this->id_db_settings)['atividade'] == 4):
                    $qtd = $heliospro['quantidade'];
                else:
                    $qtd = $heliospro['gQtd'];
                endif;**/
                $qtd = $heliospro['quantidade'];

                if(DBKwanzar::CheckConfig($this->id_db_settings)['HeliosPro'] == 2 && $qtd <= DBKwanzar::CheckConfig($this->id_db_settings)['estoque_minimo'] || DBKwanzar::CheckConfig($this->id_db_settings)['HeliosPro'] == 2 && $qtd < $this->Finish['quantidade_tmp']):
                    $this->Error  = ["Ops: não existe quantatidade suficiente de <strong>{$heliospro['product']}</strong> no estoque!", WS_ALERT];
                    $this->Result = false;
                else:
                    $this->UpdatePOS();
                endif;
            endif;
        else:
            $Read->ExeRead(self::sd_billing_tmp, $whe);

            if($Read->getResult()):
                $DB = new DBKwanzar();
                if($Read->getRowCount() >= 100 && DBKwanzar::CheckUsersConfig($this->id_db_settings, $this->Session)['Impression'] == 'A4' || $Read->getRowCount() >= 100 && $DB->CheckCpanelAndSettings($this->id_db_settings)['atividade'] != 2 ):
                    $this->Error  = ["Ops: atinguio o máximo de itens que pode ser incorporado na no documento A4", WS_INFOR];
                    $this->Result = false;
                else:

                    if(!isset(DBKwanzar::CheckUsersConfig($this->id_db_settings, $this->Session)['SalesType']) || empty(DBKwanzar::CheckUsersConfig($this->id_db_settings, $this->Session)['SalesType']) || DBKwanzar::CheckUsersConfig($this->id_db_settings, $this->Session)['SalesType'] == 0):
                        $Read->ExeRead(self::db_taxtable, "WHERE id_db_settings=:tc ORDER BY taxPercentage ASC LIMIT 1", "tc={$this->id_db_settings}");
                    else:
                        $Read->ExeRead(self::db_taxtable, "WHERE taxtableEntry=:id AND id_db_settings=:tc", "id={$this->Data['taxa']}&tc={$this->id_db_settings}");
                    endif;

                    if($Read->getResult()):
                        if($Read->getResult()[0]['taxPercentage'] < 0):
                            $this->Error  = ["Ops: não é permitido a inserção de válores negativos no documento de venda!", WS_ERROR];
                            $this->Result = false;
                        elseif($Read->getResult()[0]['taxPercentage'] > 100):
                            $this->Error  = ["Ops: não é permitido aplicar taxa de imposto acima de 100%", WS_ALERT];
                            $this->Result = false;
                        else:
                            // Taxas de imposto;
                            $this->Finish['taxa']               = $Read->getResult()[0]['taxPercentage'];
                            $this->Finish['TaxExemptionCode']   = $Read->getResult()[0]['TaxExemptionCode'];
                            $this->Finish['TaxExemptionReason'] = $Read->getResult()[0]['TaxExemptionReason'];
                            $this->Finish['taxType']            = $Read->getResult()[0]['taxType'];
                            $this->Finish['taxCode']            = $Read->getResult()[0]['taxCode'];
                            $this->Finish['TaxCountryRegion']   = $Read->getResult()[0]['TaxCountryRegion'];
                            $this->Finish['taxAmount']          = $Read->getResult()[0]['taxAmount'];
                            $this->Finish['description']        = $Read->getResult()[0]['description'];

                            // Informações do produto
                            $this->Finish['product_name']        = $this->Info['product'];
                            $this->Finish['product_list']        = $this->Info['Description'];
                            $this->Finish['product_uni']         = $this->Info['unidade_medida'];
                            $this->Finish['product_code']        = $this->Info['codigo'];
                            $this->Finish['product_type']        = $this->Info['type'];
                            $this->Finish['product_id_category'] = $this->Info['id_category'];
                            $this->Finish['product_codigo_barras'] = $this->Data['product_codigo_barras'];

                            // Informações da venda
                            $this->Finish['quantidade_tmp'] = $this->Data['quantidade'];
                            $this->Finish['preco_tmp']      = $this->Data['preco'];
                            $this->Finish['desconto_tmp']   = $this->Data['desconto'];
                            $this->Finish['page_found']   = $this->Data['page_found'];

                            // ID'S
                            if(isset($this->id_mesa) && !empty($this->id_mesa) || isset($this->id_mesa) && $this->id_mesa != null):
                                $this->Finish['id_mesa']    = $this->id_mesa;
                            else:
                                $this->Finish['id_mesa']    = 0;
                            endif;

                            $this->Finish['id_db_settings'] = $this->id_db_settings;
                            $this->Finish['session_id']     = $this->Session;
                            $this->Finish['id_product']     = $this->Data['id_product'];

                            // Suspensão
                            $this->Finish['suspenso'] = 0;

                            $this->CreatePOS();
                        endif;
                    else:
                        $this->Error  = ["Ops: não encontramos nenhuma taxa de imposto cadastrada no sistema!", WS_INFOR];
                        $this->Result = false;
                    endif;
                endif;
            else:
                if(!isset(DBKwanzar::CheckUsersConfig($this->id_db_settings, $this->Session)['SalesType']) || empty(DBKwanzar::CheckUsersConfig($this->id_db_settings, $this->Session)['SalesType']) || DBKwanzar::CheckUsersConfig($this->id_db_settings, $this->Session)['SalesType'] == 0):
                    $Read->ExeRead(self::db_taxtable, "WHERE id_db_settings=:tc ORDER BY taxPercentage ASC LIMIT 1", "tc={$this->id_db_settings}");
                else:
                    $Read->ExeRead(self::db_taxtable, "WHERE taxtableEntry=:id AND id_db_settings=:tc", "id={$this->Data['taxa']}&tc={$this->id_db_settings}");
                endif;

                if($Read->getResult()):
                    if($Read->getResult()[0]['taxPercentage'] < 0):
                        $this->Error  = ["Ops: não é permitido a inserção de válores negativos no documento de venda!", WS_ERROR];
                        $this->Result = false;
                    elseif($Read->getResult()[0]['taxPercentage'] > 100):
                        $this->Error  = ["Ops: não é permitido aplicar taxa de imposto acima de 100%", WS_ALERT];
                        $this->Result = false;
                    else:
                        // Taxas de imposto;
                        $this->Finish['taxa']               = $Read->getResult()[0]['taxPercentage'];
                        $this->Finish['TaxExemptionCode']   = $Read->getResult()[0]['TaxExemptionCode'];
                        $this->Finish['TaxExemptionReason'] = $Read->getResult()[0]['TaxExemptionReason'];
                        $this->Finish['taxType']            = $Read->getResult()[0]['taxType'];
                        $this->Finish['taxCode']            = $Read->getResult()[0]['taxCode'];
                        $this->Finish['TaxCountryRegion']   = $Read->getResult()[0]['TaxCountryRegion'];
                        $this->Finish['taxAmount']          = $Read->getResult()[0]['taxAmount'];
                        $this->Finish['description']        = $Read->getResult()[0]['description'];

                        // Informações do produto
                        $this->Finish['product_name']        = $this->Info['product'];
                        $this->Finish['product_list']        = $this->Info['Description'];
                        $this->Finish['product_uni']         = $this->Info['unidade_medida'];
                        $this->Finish['product_code']        = $this->Info['codigo'];
                        $this->Finish['product_type']        = $this->Info['type'];
                        $this->Finish['product_id_category'] = $this->Info['id_category'];
                        $this->Finish['product_codigo_barras'] = $this->Info['codigo_barras'];

                        // Informações da venda
                        $this->Finish['quantidade_tmp'] = $this->Data['quantidade'];
                        $this->Finish['preco_tmp']      = $this->Data['preco'];
                        $this->Finish['desconto_tmp']   = $this->Data['desconto'];
                        $this->Finish['page_found']   = $this->Data['page_found'];

                        // ID'S
                        if(isset($this->id_mesa) && !empty($this->id_mesa) || isset($this->id_mesa) && $this->id_mesa != null):
                            $this->Finish['id_mesa']    = $this->id_mesa;
                        else:
                            $this->Finish['id_mesa']    = 0;
                        endif;

                        $this->Finish['id_db_settings'] = $this->id_db_settings;
                        $this->Finish['session_id']     = $this->Session;
                        $this->Finish['id_product']     = $this->Data['id_product'];

                        // Suspensão
                        $this->Finish['suspenso'] = 0;

                        $this->CreatePOS();
                    endif;
                else:
                    $this->Error  = ["Ops: não encontramos nenhuma taxa de imposto cadastrada no sistema!", WS_INFOR];
                    $this->Result = false;
                endif;
            endif;
        endif;
    }

    private function CreatePOS(){
        $Create = new Create();
        $Create->ExeCreate(self::sd_billing_tmp, $this->Finish);

        if($Create->getResult()):
            $this->Result = true;
        else:
            $this->Error  = ["Ops: aconteceu um erro inesperado ao adicionar o <strong>Item</strong> ao carrinho!", WS_INFOR];
            $this->Result = false;
        endif;
    }

    private function UpdatePOS(){
        $suspenso = 0;
        if(isset($this->id_mesa) && !empty($this->id_mesa) || isset($this->id_mesa) && $this->id_mesa != null): $mesa = "AND id_mesa=:c"; $me = "&c={$this->id_mesa}"; else: $mesa = null; $me = null; endif;
        $where = "WHERE id_db_settings=:a AND session_id=:b AND page_found=:ppY AND id_product=:e ".$mesa." AND suspenso=:d";
        $Finish = "a={$this->id_db_settings}&b={$this->Session}&ppY={$this->Data['page_found']}&e={$this->Data['id_product']}".$me."&d={$suspenso}";

        $Update = new Update();
        $Update->ExeUpdate(self::sd_billing_tmp, $this->Finish, $where, $Finish);

        if($Update->getResult()):
            $this->Result = true;
        else:
            $this->Error  = ["Ops: aconteceu um erro inesperado ao adicionar o <strong>Item</strong> ao carrinho!", WS_ALERT];
            $this->Result = false;
        endif;
    }

    public function RemovePS($id_product, $id_db_settings, $id_user, $id_mesa = null){
        $this->id_db_settings = $id_db_settings;
        $this->ID = $id_product;
        $this->Session = $id_user;
        $this->id_mesa = $id_mesa;

        $Read = new Read();
        $Read->ExeRead(self::sd_billing_tmp, "WHERE id=:p AND id_db_settings=:st AND session_id=:ses", "p={$this->ID}&st={$this->id_db_settings}&ses={$this->Session}");

        if($Read->getResult()):
            $this->Delete();
        else:
            $this->Error  = ["Ops: não encontramos a ação desejada!", WS_ALERT];
            $this->Result = false;
        endif;
    }

    private function Delete(){
        $Delete = new Delete();
        $Delete->ExeDelete(self::sd_billing_tmp, "WHERE id=:i", "i={$this->ID}");

        if($Delete->getResult() || $Delete->getRowCount()):
            $this->Result = true;
        else:
            $this->Error  = ["Ops: aconteceu um erro inesperado ao remover o <strong>Item</strong> da factura.", WS_ERROR];
            $this->Result = false;
        endif;
    }
    public function Fact(array $data, $id_db_settings, $id_user, $page_found,  $id_mesa = null, $id_garcom = null){
        $this->Data = $data;
        $this->id_db_settings = $id_db_settings;
        $this->Session = $id_user;

        $this->PageFound = strip_tags(trim($page_found));
        $this->id_mesa = (int) $id_mesa;
        if(isset($id_garcom)): $this->id_garcom = (int) $id_garcom; else: $this->id_garcom = null; endif;


        if(!empty($this->Data['settings_desc_financ']) && $this->Data['settings_desc_financ'] < 0 || !empty($this->Data['settings_desc_financ']) && $this->Data['settings_desc_financ'] > 100):
            $this->Error  = ["Ops: os descontos Financeiros não podem ser menor que 0 e nem maior que 100. Atualize a página e tente novamente!", WS_ALERT];
            $this->Result = false;
        else:
            if(DBKwanzar::CheckConfig($this->id_db_settings) == false || DBKwanzar::CheckConfig($this->id_db_settings)['JanuarioSakalumbu'] == null): $ttt = 2; else: $ttt = DBKwanzar::CheckConfig($this->id_db_settings)['JanuarioSakalumbu']; endif;

            $sp = 0;
            $this->Info['status'] = 1;
            $this->Info['suspenso'] = $sp;

            $Read = new Read();
            $Read->ExeRead(self::sd_billing, "WHERE id_db_settings=:st  AND id_mesa=:igg AND session_id=:ses AND page_found=:ppY AND status=:ttt AND suspenso=:sp", "st={$this->id_db_settings}&igg={$this->id_mesa}&ses={$this->Session}&ppY={$this->PageFound}&ttt={$this->Info['status']}&sp={$sp}");

            if($Read->getResult()):
                $this->Datting();
                if($this->Result):
                    $this->Info['settings_desc_financ'] = $this->Data['settings_desc_financ'];
                    $this->Info['method']               = $this->Data['method'];
                    $this->Info['id_garcom']            = $this->id_garcom;
                    $this->Info['id_veiculos']        = $this->Data['id_veiculos'];
                    $this->Info['matriculas'] = $this->Data['matriculas'];
                    $this->Info['id_fabricante'] = $this->Data['id_fabricante'];
                    $this->Info['referencia'] = $this->Data['referencia'];
                    $this->Info['id_obs'] = $this->Data['id_obs'];

                    $this->Info['page_found'] = $this->PageFound;

                    $this->UpdateFact();
                endif;
            else:
                $this->Number();
                if($this->Result):
                    $this->Datting();
                    if($this->Result):
                        $this->Hash(self::sd_billing);
                        if($this->Result):
                            $this->Info['id_garcom']            = $this->id_garcom;
                            $this->Info['id_mesa']              = $this->id_mesa;
                            $this->Info['id_db_settings']       = $this->id_db_settings;
                            $this->Info['method']               = $this->Data['method'];
                            $this->Info['numero']               = $this->Number;
                            $this->Info['session_id']           = $this->Session;
                            $this->Info['SourceBilling']        = $this->Data['SourceBilling'];
                            $this->Info['settings_desc_financ'] = $this->Data['settings_desc_financ'];
                            $this->Info['referencia'] = $this->Data['referencia'];
                            if(isset($this->Data['id_obs'])): $this->Info['id_obs'] = $this->Data['id_obs']; endif;

                            $this->Info['page_found'] = $this->PageFound;

                            if(isset($this->Data['id_veiculos'])):
                                $Read = new Read();
                                $Read->ExeRead("i_veiculos", "WHERE id=:i", "i={$this->Data['id_veiculos']}");
                                if($Read->getResult()):
                                    $this->Info['id_veiculos'] = $Read->getResult()[0]['veiculo'];
                                endif;
                            endif;

                            $ln = 0;
                            $Read->ExeRead(self::settings_gallery, "WHERE id_db_settings=:i ORDER BY id DESC LIMIT 6", "i={$this->id_db_settings}");
                            if($Read->getResult()):
                                foreach ($Read->getResult() as $item):
                                    $ln += 1;
                                    $this->Info['gallery_cover_'.$ln] = $item['cover'];
                                endforeach;
                            endif;

                            if(isset($this->Data['matriculas'])): $this->Info['matriculas'] = $this->Data['matriculas']; endif;
                            if(isset($this->Data['id_fabricante'])): $this->Info['id_fabricante'] = $this->Data['id_fabricante']; endif;
                            $this->CreateFact();
                        endif;
                    endif;
                endif;
            endif;
        endif;
    }

    private function GeraHash($tamanho) {
        $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!/|?';
        $caracteres_tamanho = strlen($caracteres);
        $string_aleatoria = '';
        for ($i = 0; $i < $tamanho; $i++) {
            $string_aleatoria .= $caracteres[rand(0, $caracteres_tamanho - 1)];
        }
        $this->Hash = $string_aleatoria;
        $this->Result = true;
    }

    private function Hash($db = null){
        $this->GeraHash(172);
        if($this->Result):
            $this->HashControl = "0";
            $this->Info['hash'] = $this->Hash;
            $this->Info['hashcontrol'] = $this->HashControl;
        endif;
    }

    private function Number(){
        if(DBKwanzar::CheckConfig($this->id_db_settings) == false || DBKwanzar::CheckConfig($this->id_db_settings)['JanuarioSakalumbu'] == null):
            $ttt = " status='2'";
        else:
            $ttt = " status!='2'";
        endif;

        $s = 0;
        $Y = date('Y');
        $Read = new Read();
        $Read->FullRead("SELECT *FROM sd_billing WHERE id_db_settings=:st AND InvoiceType=:iT AND {$ttt}", "st={$this->id_db_settings}&iT={$this->Data['InvoiceType']}");

        if($Read->getResult()):
            $hora = explode(':', $Read->getResult()[0]['hora']);
            if(date('Y') < $Read->getResult()[0]['ano'] && (date('m') < $Read->getResult()[0]['mes'] ) && (date('m') < $Read->getResult()[0]['mes'] && date('d') < $Read->getResult()[0]['dia']) && (date('m') == $Read->getResult()[0]['mes'] && $Read->getResult()[0]['dia'] > date('d'))):
                $this->Error = ["Ops: a hora e data não está correta, atualize a data e tente novamente. (0)", WS_ERROR];
                $this->Result = false;
            elseif(date('Y') == $Read->getResult()[0]['ano'] && date('m') == $Read->getResult()[0]['mes'] && date('d') == $Read->getResult()[0]['dia']):
                if(date('H') < $hora[0] && date('i') < $hora[1]):
                    $this->Error  = ["Ops: a hora e data não está correta, atualize a data e tente novamente. (1)", WS_ERROR];
                    $this->Result = false;
                else:
                    $this->Number  = $Read->getRowCount() + 1;
                    //$this->Error   = ["{$this->Number} (1)", WS_ERROR];
                    $this->Result  = true;
                endif;
            else:
                $this->Number  = $Read->getRowCount() + 1;
                //$this->Error   = ["{$this->Number} (2)", WS_ERROR];
                $this->Result  = true;
            endif;
        else:
            $this->Number = 1;
            $this->Result = true;
        endif;
    }

    private function Datting(){
        $Read = new Read();
        $Read->ExeRead(self::db_settings, "WHERE id=:i", "i={$this->id_db_settings}");

        if(DBKwanzar::CheckConfig($this->id_db_settings) == false || DBKwanzar::CheckConfig($this->id_db_settings)['sequencialCode'] == null || DBKwanzar::CheckConfig($this->id_db_settings)['sequencialCode'] == '' || empty(DBKwanzar::CheckConfig($this->id_db_settings)['sequencialCode']) || !isset(DBKwanzar::CheckConfig($this->id_db_settings)['sequencialCode'])): $code = null; else: $code = DBKwanzar::CheckConfig($this->id_db_settings)['sequencialCode']; endif;

        if($Read->getResult()):
            $f = $Read->getResult()[0];

            if(DBKwanzar::CheckConfig($this->id_db_settings) != false): $fe = DBKwanzar::CheckConfig($this->id_db_settings)['moeda']; else:  $fe = "AOA"; endif;

            // Informações da empresa
            $this->Info['settings_empresa']     = $f['empresa'];
            $this->Info['settings_nif']         = $f['nif'];
            $this->Info['settings_telefone']    = $f['telefone'];
            $this->Info['settings_email']       = $f['email'];
            $this->Info['settings_endereco']    = $f['endereco'];
            $this->Info['settings_logotype']    = $f['logotype'];
            $this->Info['settings_rodape']      = $f['makeUp'];

            $this->Info['settings_nib']         = $f['nib'];
            $this->Info['settings_iban']        = $f['iban'];
            $this->Info['settings_banco']        = $f['banco'];
            $this->Info['settings_swift']       = $f['swift'];

            $this->Info['settings_nib1']         = $f['nib1'];
            $this->Info['settings_iban1']        = $f['iban1'];
            $this->Info['settings_banco1']        = $f['banco1'];
            $this->Info['settings_swift1']       = $f['swift1'];

            $this->Info['settings_nib2']         = $f['nib2'];
            $this->Info['settings_iban2']        = $f['iban2'];
            $this->Info['settings_banco2']        = $f['banco2'];
            $this->Info['settings_swift2']       = $f['swift2'];

            $this->Info['settings_website']     = $f['website'];
            $this->Info['settings_city']        = $f['city'];
            $this->Info['settings_taxEntity']   = $f['taxEntity'];
            $this->Info['settings_coordenadas'] = $f['coordenadas'];
            $this->Info['settings_moeda']       = $fe;
        endif;

        // Informações de data e local
        $this->Info['dia']          = date('d');
        $this->Info['mes']          = date('m');
        $this->Info['ano']          = date('Y');
        $this->Info['hora']         = date('H:i:s');
        $this->Info['TaxPointDate'] = $this->Data['TaxPointDate'];
        $this->Info['InvoiceType']  = $this->Data['InvoiceType'];
        $this->Info['Code']         = $code;
        $this->Info['config_regimeIVA']  = DBKwanzar::CheckConfig($this->id_db_settings)['regimeIVA'];

        if(DBKwanzar::CheckConfig($this->id_db_settings) == true && DBKwanzar::CheckConfig($this->id_db_settings)['IncluirNaFactura'] == 2):
            $this->Info['IncluirNaFactura'] = DBKwanzar::CheckConfig($this->id_db_settings)['IncluirNaFactura'];
            $this->Info['RetencaoDeFonte']  = DBKwanzar::CheckConfig($this->id_db_settings)['RetencaoDeFonte'];
        endif;

        $Read->ExeRead(self::cv_customer, "WHERE id=:i AND id_db_settings=:st", "i={$this->Data['customer']}&st={$this->id_db_settings}");
        if($Read->getResult()):
            $a = $Read->getResult()[0];

            // Informações dos clientes;
            $this->Info['customer_name']     = $a['nome'];
            $this->Info['customer_endereco'] = $a['endereco'];
            $this->Info['customer_telefone'] = $a['telefone'];
            $this->Info['customer_nif']      = $a['nif'];
            $this->Info['id_customer']       = $this->Data['customer'];
            if($this->Info['customer_name'] != "Consumidor final" && $a['city'] != "Consumidor final"):
                $this->Info['customer_endereco_final'] = $a['city']." - Angola";
            endif;
        endif;


        $Read->FullRead("SELECT name FROM db_users WHERE id=:i ", "i={$this->Session}");
        if($Read->getResult()):
            $this->Info['username'] = $Read->getResult()[0]['name'];
        endif;

        $this->Info['box_in'] = 1;

        if($this->Info['InvoiceType'] == 'PP'):
            if(date('m') < 12):
                $Mn = date('m') + 1;
                if($Mn <= 9): $Fn = "0".$Mn; else: $Fn = $Mn; endif;

                $this->Info['date_expiration'] = date('Y')."-".$Fn."-".date('d');
            else:
                $this->Info['date_expiration'] = date('Y')."-".date('m')."-"."31";
            endif;
        else:
            $this->Info['date_expiration'] = null;
        endif;

        $this->Result = true;
    }

    private function CreateFact(){
        if($this->Info['InvoiceType'] == "FT"):
            $Read = new Read();
            $Read->ExeRead(self::credito, "WHERE id_customer=:id AND id_db_settings=:set ", "id={$this->Info['id_customer']}&set={$this->Info['id_db_settings']}");

            if($Read->getResult()):
                $this->Credito = $Read->getResult()[0]['credito'];

                $total_geral_saldo = 0;
                $total_geral_divida = 0;
                $total_geral_pago = 0;

                $suspenso = 0;
                $inv = "FT";

                if(DBKwanzar::CheckConfig($this->Info['id_db_settings'])['JanuarioSakalumbu'] == null): $ttt = 2; else: $ttt = DBKwanzar::CheckConfig($this->Info['id_db_settings'])['JanuarioSakalumbu']; endif;

                $clientes = " AND sd_billing.id_customer='{$this->Info['id_customer']}' ";

                $n3 = "sd_billing_pmp";
                $n4 = "sd_retification_pmp";

                if(DBKwanzar::CheckConfig($this->Info['id_db_settings']) == false || Strong::Config($this->Info['id_db_settings'])['JanuarioSakalumbu'] == 3 || Strong::Config($this->Info['id_db_settings'])['JanuarioSakalumbu'] == '' || Strong::Config($this->Info['id_db_settings'])['JanuarioSakalumbu'] == null):
                    $st = 3;
                else:
                    $st = 2;
                endif;

                $s = 0;

                $Read = new Read();
                $Read->ExeRead("sd_billing", "WHERE sd_billing.id_db_settings=:i AND sd_billing.InvoiceType=:inv AND sd_billing.suspenso=:s AND sd_billing.status=:st {$clientes} ORDER BY sd_billing.id DESC", "i={$this->Info['id_db_settings']}&inv={$inv}&s={$suspenso}&st={$ttt}");

                if($Read->getResult()):
                    foreach ($Read->getResult() as $key):
                        $t_v = 0;
                        $t_g = 0;

                        $read = new Read();
                        $read->ExeRead("{$n3}", "WHERE id_db_settings=:i AND status=:st AND numero=:nn AND SourceBilling=:sc AND InvoiceType=:itt", "i={$this->Info['id_db_settings']}&st={$st}&nn={$key['numero']}&sc={$key['SourceBilling']}&itt={$key['InvoiceType']}");
                        if($read->getResult()):
                            foreach($read->getResult() as $ky):
                                $value = $ky['quantidade_pmp'] * $ky['preco_pmp'];
                                if($ky['desconto_pmp'] >= 100):
                                    $desconto = $ky['desconto_pmp'];
                                else:
                                    $desconto = ($value * $ky['desconto_pmp']) / 100;
                                endif;
                                //$desconto = ($value * $ky['desconto_pmp']) / 100;
                                $imposto  = ($value * $ky['taxa']) / 100;

                                $t_v += ($value - $desconto) + $imposto;
                            endforeach;
                        endif;

                        $read->ExeRead("{$n4}", "WHERE id_db_settings=:i  AND status=:st AND id_invoice=:nn AND SourceBilling=:sc", "i={$this->Info['id_db_settings']}&st={$st}&nn={$key['id']}&sc={$key['SourceBilling']}");
                        if($read->getResult()):
                            foreach($read->getResult() as $ey):
                                extract($ey);

                                $value = $ey['quantidade_pmp'] * $ey['preco_pmp'];
                                $desconto = ($value * $ey['desconto_pmp']) / 100;
                                $imposto  = ($value * $ey['taxa']) / 100;

                                $t_g += ($value - $desconto) + $imposto;
                            endforeach;
                        endif;

                        $saldo = $t_g - $t_v;

                        $total_geral_divida += $t_g;
                        $total_geral_saldo += $t_v;
                        $total_geral_pago += $saldo;
                    endforeach;
                endif;

                if(abs($total_geral_pago) >= $this->Credito):
                    $this->Result = false;
                    $this->Error = ["O Cliente {$this->Info['customer_name']}, já atingiu o limite de crédito!", WS_ALERT];
                else:
                    $Create = new Create();
                    $Create->ExeCreate("sd_billing", $this->Info);

                    if($Create->getResult()):
                        $this->Error  = [$Create->getResult()[0], WS_INFOR];
                        $this->Result = true;
                    else:
                        $this->Error  = ["Ops: aconteceu um erro inesperado ao criar o documento!", WS_ERROR];
                        $this->Result = false;
                    endif;
                endif;
            else:
                $Create = new Create();
                $Create->ExeCreate("sd_billing", $this->Info);

                if($Create->getResult()):
                    $this->Error  = [$Create->getResult()[0], WS_INFOR];
                    $this->Result = true;
                else:
                    $this->Error  = ["Ops: aconteceu um erro inesperado ao criar o documento!", WS_ERROR];
                    $this->Result = false;
                endif;
            endif;
        else:
            $Create = new Create();
            $Create->ExeCreate("sd_billing", $this->Info);

            if($Create->getResult()):
                $this->Error  = [$Create->getResult()[0], WS_INFOR];
                $this->Result = true;
            else:
                $this->Error  = ["Ops: aconteceu um erro inesperado ao criar o documento!", WS_ERROR];
                $this->Result = false;
            endif;
        endif;
    }

    private function UpdateFact(){
        $ttt = 1;
        $sp  = 0;

        $Update = new Update();
        $Update->ExeUpdate(self::sd_billing, $this->Info,  "WHERE id_db_settings=:st AND session_id=:ses AND page_found=:ppY AND id_mesa=:igg AND status=:ttt AND suspenso=:sp", "st={$this->id_db_settings}&ses={$this->Session}&ppY={$this->PageFound}&igg={$this->id_mesa}&ttt={$ttt}&sp={$sp}");

        if($Update->getResult()):
            $this->Result = true;
        else:
            $this->Error  = ["Ops: aconteceu um erro inesperado ao criar o documento!", WS_ERROR];
            $this->Result = false;
        endif;
    }

    private $Sheldon, $SheldonII, $PageFound;
    const
        static_customer = "db_static_sales_customer",
        static_users    = "db_static_sales_db_users",
        static_product  = "db_static_db_settings_product";

    public function Finish($id_db_settings, $session_id, array $data = null, $id_db_kwanzar = null,  $page_found = null, $id_mesa = null){
        $this->id_db_settings = (int) $id_db_settings;
        $this->id_db_kwanzar = (int) $id_db_kwanzar;
        $this->Session = $session_id;
        $this->Finish = $data;

        $this->PageFound = strip_tags(trim($page_found));

        if(!empty($id_mesa) || $id_mesa != null):
            $this->id_mesa = (int) $id_mesa;
            $mesa = " AND id_mesa={$this->id_mesa} ";
        else:
            $this->id_mesa = null;
            $mesa = null;
        endif;

        $status = 1;
        $suspenso = 0;

        $Read = new Read();
        $Read->ExeRead(self::sd_billing, "WHERE id_db_settings=:st AND session_id=:ses AND page_found=:ppY {$mesa} AND status=:p AND suspenso=:sp", "st={$this->id_db_settings}&ses={$this->Session}&ppY={$this->PageFound}&p={$status}&sp={$suspenso}");

        if($Read->getResult()):
            $this->Sheldon = $Read->getResult()[0];
            $this->Number  = $Read->getResult()[0]['numero'];
            $this->Help    = $Read->getResult()[0]['SourceBilling'];

            if($Read->getResult()[0]['InvoiceType'] != 'PP'):
                $Read->ExeRead(self::static_customer, "WHERE id_db_settings=:i AND id_cv_customer=:ip", "i={$this->id_db_settings}&ip={$this->Sheldon['id_customer']}");

                if($Read->getResult()):
                    $cPlus = $Read->getResult()[0]['counting'] + 1;
                    $dPlus = ["counting" => $cPlus];

                    $Update = new Update();
                    $Update->ExeUpdate(self::static_customer, $dPlus, "WHERE id_db_settings=:i AND id_cv_customer=:ip", "i={$this->id_db_settings}&ip={$this->Sheldon['id_customer']}");

                    if(!$Update->getResult()):
                        $this->Error  = ["Ops: aconteceu um erro inesperado ao salvar a contagem de clientes;", WS_ERROR];
                        $this->Result = false;
                    endif;
                else:
                    $sPlus = ["id_db_settings" => $this->id_db_settings, "id_cv_customer" => $this->Sheldon['id_customer'], "counting" => 1];

                    $Create = new Create();
                    $Create->ExeCreate(self::static_customer, $sPlus);

                    if(!$Create->getResult()):
                        $this->Error  = ["Ops: aconteceu um erro inesperado ao salvar a contagem de clientes;", WS_ERROR];
                        $this->Result = false;
                    endif;
                endif;

                $Read->ExeRead(self::static_users, "WHERE id_db_settings=:i AND id_db_users=:ip", "i={$this->id_db_settings}&ip={$this->Sheldon['session_id']}");

                if($Read->getResult()):
                    $nPlus = $Read->getResult()[0]['counting'] + 1;
                    $vPlus = ["counting" => $nPlus];

                    $Update = new Update();
                    $Update->ExeUpdate(self::static_users, $vPlus, "WHERE id_db_settings=:i AND id_db_users=:ip", "i={$this->id_db_settings}&ip={$this->Sheldon['session_id']}");

                    if(!$Update->getResult()):
                        $this->Error  = ["Ops: aconteceu um erro inesperado ao salvar a contagem de usuário;", WS_ERROR];
                        $this->Result = false;
                    endif;
                else:
                    $mPlus = ["id_db_settings" => $this->id_db_settings, "id_db_users" => $this->Sheldon['session_id'], "counting" => 1];

                    $Create = new Create();
                    $Create->ExeCreate(self::static_users, $mPlus);

                    if(!$Create->getResult()):
                        $this->Error  = ["Ops: aconteceu um erro inesperado ao salvar a contagem de usuário;", WS_ERROR];
                        $this->Result = false;
                    endif;
                endif;
            endif;
            $this->DataProduct();
        else:
            $this->Error  = ["Ops: não encontramos nenhum documento em aberto!", WS_INFOR];
            $this->Result = false;
        endif;
    }

    private function DataProduct(){
        $suspenso = 0;
        if(!empty($this->id_mesa) || $this->id_mesa != null):
            $mesa = " AND id_mesa={$this->id_mesa} ";
        else:
            $mesa = null;
        endif;

        $Read = new Read();
        $Read->ExeRead(self::sd_billing_tmp, "WHERE id_db_settings=:st AND session_id=:ses AND page_found=:ppY {$mesa} AND suspenso=:s ORDER BY id ASC", "st={$this->id_db_settings}&ses={$this->Session}&ppY={$this->PageFound}&s={$suspenso}");
        if($Read->getResult()):
            foreach($Read->getResult() as $key):
                extract($key);
                $this->Info = $key;
                $this->Data['product_code'] = $this->Info['product_list'];
                $Read->ExeRead(self::cv_product, "WHERE id=:id_product AND id_db_settings=:st", "id_product={$key['id_product']}&st={$this->id_db_settings}");

                if($Read->getResult()):
                    $this->SheldonII = $Read->getResult()[0];
                    if($this->Sheldon['InvoiceType'] != 'PP'):
                        $functions = new Read();

                        $functions->ExeRead(self::static_product, "WHERE id_db_settings=:i AND id_cv_product=:ip", "i={$this->id_db_settings}&ip={$this->SheldonII['id']}");

                        if($functions->getResult()):
                            $cPlus = ["counting" => $functions->getResult()[0]['counting'] + $this->Info['quantidade_tmp']];

                            $Update = new Update();
                            $Update->ExeUpdate(self::static_product, $cPlus, "WHERE id_db_settings=:i AND id_cv_product=:ip", "i={$this->id_db_settings}&ip={$this->SheldonII['id']}");

                            if(!$Update->getResult()):
                                $this->Error  = ["Ops: aconteceu um erro inesperado ao salvar a contagem de produtos/serviços;", WS_ERROR];
                                $this->Result = false;
                            endif;
                        else:
                            $sPlus = ["id_db_settings" => $this->id_db_settings, "id_cv_product" => $this->SheldonII['id'], "counting" => 1];

                            $Create = new Create();
                            $Create->ExeCreate(self::static_product, $sPlus);

                            if(!$Create->getResult()):
                                $this->Error  = ["Ops: aconteceu um erro inesperado ao salvar a contagem de produtos;", WS_ERROR];
                                $this->Result = false;
                            endif;
                        endif;
                    endif;

                    if($Read->getResult()[0]['type'] != 'S'):
                        $this->Alert = $Read->getResult()[0];
                        /**if(DBKwanzar::CheckSettingsII($this->id_db_settings)['atividade'] == 1 || DBKwanzar::CheckSettingsII($this->id_db_settings)['atividade'] == 4):
                            $qtd = $Read->getResult()[0]['quantidade'];
                        else:
                            $qtd = $Read->getResult()[0]['gQtd'];
                        endif;**/

                        $qtd = $Read->getResult()[0]['quantidade'];

                        if(DBKwanzar::CheckConfig($this->id_db_settings) != false):
                            if(DBKwanzar::CheckConfig($this->id_db_settings)['HeliosPro'] == 2 && $qtd <= DBKwanzar::CheckConfig($this->id_db_settings)['estoque_minimo']):
                                $this->Error  = ["Ops: não existe quantatidade suficiente de <strong>{$Read->getResult()[0]['product']}</strong> no estoque!", WS_ALERT];
                                $this->Result = false;
                            elseif(DBKwanzar::CheckConfig($this->id_db_settings)['HeliosPro'] != 1):
                                if($this->Sheldon['InvoiceType'] != 'PP'):
                                    $this->Desconto();
                                endif;
                                $this->ProcessPmP();
                            else:
                                $this->ProcessPmP();
                            endif;
                        else:
                            $this->ProcessPmP();
                        endif;
                    else:
                        $this->ProcessPmP();
                    endif;

                    if($this->Result):
                        $this->DataFinish();
                    endif;
                endif;
            endforeach;
        else:
            $this->Error  = ["Ops: não encontramos itens adicionado na factura.", WS_ALERT];
            $this->Result = false;
        endif;
    }

    private function Desconto(){
        $qtd = $this->Alert['quantidade'] - $this->Info['quantidade_tmp'];
        $Dados['quantidade'] = $qtd;

        $Update = new Update();
        $Update->ExeUpdate(self::cv_product, $Dados, "WHERE id=:id AND id_db_settings=:st", "id={$this->Alert['id']}&st={$this->id_db_settings}");

        if($Update->getResult()):
            $this->Result = true;
        else:
            $this->Error  = ["Ops: aconteceu um erro inesperado ao atualizar o produto/serviço <strong>{$this->Alert['product']}</strong>", WS_INFOR];
            $this->Result = false;
        endif;
    }

    private function ProcessPmP(){
        if(DBKwanzar::CheckConfig($this->id_db_settings) == false || DBKwanzar::CheckConfig($this->id_db_settings)['JanuarioSakalumbu'] == null): $ttt = 2; else: $ttt = DBKwanzar::CheckConfig($this->id_db_settings)['JanuarioSakalumbu']; endif;

        unset($this->Info['page_found']);
        $this->Data['id_db_settings']     = $this->id_db_settings;
        $this->Data['id_product']         = $this->Info['id_product'];
        $this->Data['session_id']         = $this->Info['session_id'];
        $this->Data['id_mesa']            = $this->Info['id_mesa'];
        $this->Data['quantidade_pmp']     = $this->Info['quantidade_tmp'];
        $this->Data['preco_pmp']          = $this->Info['preco_tmp'];
        $this->Data['desconto_pmp']       = $this->Info['desconto_tmp'];
        $this->Data['taxa']               = $this->Info['taxa'];
        $this->Data['TaxExemptionCode']   = $this->Info['TaxExemptionCode'];
        $this->Data['TaxExemptionReason'] = $this->Info['TaxExemptionReason'];
        $this->Data['taxType']            = $this->Info['taxType'];
        $this->Data['taxCode']            = $this->Info['taxCode'];
        $this->Data['TaxCountryRegion']   = $this->Info['TaxCountryRegion'];
        $this->Data['taxAmount']          = $this->Info['taxAmount'];
        $this->Data['description']        = $this->Info['description'];
        $this->Data['product_name']       = $this->Info['product_name'];
        $this->Data['product_code']       = $this->Info['product_code'];
        $this->Data['product_list']       = $this->Info['product_list'];
        $this->Data['product_uni']        = $this->Info['product_uni'];
        $this->Data['product_type']       = $this->Info['product_type'];
        $this->Data['product_id_category']= $this->Info['product_id_category'];
        $this->Data['product_codigo_barras']= $this->Info['product_codigo_barras'];
        $this->Data['InvoiceType']        = $this->Sheldon['InvoiceType'];
        $this->Data['suspenso']           = 0;
        $this->Data['box_in']             = 1;
        $this->Data['numero']             = $this->Number;
        $this->Data['status']             = $ttt;
        $this->Data['SourceBilling']      = $this->Help;

        $Create = new Create();
        $Create->ExeCreate(self::sd_billing_pmp, $this->Data);

        if($Create->getResult()):
            $this->Result = true;
        else:
            $this->Error  = ["Ops: aconteceu um erro inesperado ao adicionar o item <strong>{$this->Data['product_name']}</strong> na factura final!", WS_ALERT];
            $this->Result = false;
        endif;
    }

    private function DataFinish(){
        if(DBKwanzar::CheckConfig($this->id_db_settings) == false || DBKwanzar::CheckConfig($this->id_db_settings)['JanuarioSakalumbu'] == null): $ttt = 2; else: $ttt = DBKwanzar::CheckConfig($this->id_db_settings)['JanuarioSakalumbu']; endif;

        if(isset($this->id_mesa) && !empty($this->id_mesa) || isset($this->id_mesa) && $this->id_mesa != null): $mesa = " AND id_mesa={$this->id_mesa} "; else:  $mesa = null; endif;

        $this->Finish['status'] = $ttt;
        $status = 1;
        $suspenso = 0;

        $Update = new Update();
        $Update->ExeUpdate(self::sd_billing, $this->Finish, "WHERE id_db_settings=:st AND session_id=:ses AND page_found=:ppY {$mesa} AND status=:p AND suspenso=:sp", "st={$this->id_db_settings}&ses={$this->Session}&ppY={$this->PageFound}&p={$status}&sp={$suspenso}");

        if($Update->getResult()):
            $Delete = new Delete();
            $Delete->ExeDelete(self::sd_billing_tmp, "WHERE id_db_settings=:st AND session_id=:ses AND page_found=:ppY {$mesa} AND suspenso=:sp", "st={$this->id_db_settings}&ses={$this->Session}&ppY={$this->PageFound}&sp={$suspenso}");

            if($Delete->getResult() || $Delete->getRowCount()):
                $Read = new Read();
                $Read->ExeRead(self::ws_times, "WHERE id_db_kwanzar=:i", "i={$this->id_db_kwanzar}");
                if($Read->getResult()):
                    $local['documentos_feito'] = $Read->getResult()[0]['documentos_feito'] + 1;
                    $Update = new Update();
                    $Update->ExeUpdate(self::ws_times, $local,"WHERE id_db_kwanzar=:i", "i={$this->id_db_kwanzar}");

                    if($Update->getResult()):
                        $this->Result = true;
                    else:
                        $this->Result = false;
                        $this->Error = ["Oops: aconteceu um erro inesperado ao limitar os documentos emitidos!", WS_ERROR];
                    endif;
                endif;
            else:
                //$this->Error  = ["Ops: aconteceu um erro inesperado eliminar os arquivos temporario!", WS_ERROR];
                //$this->Result = false;
                $this->Result = true;
            endif;
        else:
            $this->Error  = ["Ops: aconteceu um erro inesperado ao finalizar a factura!", WS_ERROR];
            $this->Result = false;
        endif;
    }

    /**
     * @param $id_db_settings
     * @param $session
     */
    public function AnularVenda($id_db_settings, $session){
        $this->Session = $session;
        $this->id_db_settings = $id_db_settings;

        $status = 1;
        $suspenso = 0;

        $Read = new Read();
        $Read->ExeRead(self::sd_billing, "WHERE id_db_settings=:st AND session_id=:ses AND status=:p AND suspenso=:sp", "st={$this->id_db_settings}&ses={$this->Session}&p={$status}&sp={$suspenso}");

        if($Read->getResult()):
            $this->ID = $Read->getResult()[0]['id'];
            $this->Suspende();
        else:
            $this->Error  = ["Ops: não encontramos nenhum documento em aberto!", WS_INFOR];
            $this->Result = false;
        endif;
    }

    private function Suspende(){
        $Data = ['suspenso' => 1];
        $suspenso = 0;

        $Update = new Update();
        $Update->ExeUpdate(self::sd_billing, $Data, "WHERE id=:i ", "i={$this->ID}");

        if($Update->getResult()):
            $Update->ExeUpdate(self::sd_billing_tmp, $Data, "WHERE id_db_settings=:st AND session_id=:ses AND suspenso=:s", "st={$this->id_db_settings}&ses={$this->Session}&s={$suspenso}");

            if($Update->getResult()):
                $this->Result = true;
            else:
                $this->Error  = ["Ops: aconteceu um erro inesperado ao suspender o documento (1)", WS_ERROR];
                $this->Result = false;
            endif;
        else:
            $this->Error  = ["Ops: aconteceu um erro inesperado ao suspender o documento (0)", WS_ERROR];
            $this->Result = false;
        endif;
    }

    public function SuspenseVenda($id_db_settings, $session){
        $this->Session = $session;
        $this->id_db_settings = $id_db_settings;

        $status = 1;
        $suspenso = 1;

        $Read = new Read();
        $Read->ExeRead(self::sd_billing, "WHERE id_db_settings=:st AND session_id=:ses AND status=:p AND suspenso=:sp", "st={$this->id_db_settings}&ses={$this->Session}&p={$status}&sp={$suspenso}");

        if($Read->getResult()):
            $this->ID = $Read->getResult()[0]['id'];
            $this->Suspense();
        else:
            $this->Error  = ["Ops: não encontramos nenhum documento em aberto!", WS_INFOR];
            $this->Result = false;
        endif;
    }

    private function Suspense(){
        $Data = ['suspenso' => 0];
        $suspenso = 1;

        $Update = new Update();
        $Update->ExeUpdate(self::sd_billing, $Data, "WHERE id=:i ", "i={$this->ID}");

        if($Update->getResult()):
            $Update->ExeUpdate(self::sd_billing_tmp, $Data, "WHERE id_db_settings=:st AND session_id=:ses AND suspenso=:s", "st={$this->id_db_settings}&ses={$this->Session}&s={$suspenso}");

            if($Update->getResult()):
                $this->Result = true;
            else:
                $this->Error  = ["Ops: aconteceu um erro inesperado ao suspender o documento (1)", WS_ERROR];
                $this->Result = false;
            endif;
        else:
            $this->Error  = ["Ops: aconteceu um erro inesperado ao suspender o documento (0)", WS_ERROR];
            $this->Result = false;
        endif;
    }
    public function  Retification(array $data, $id_invoice, $id_db_settings, $session_id, $Invoice){
        $this->ID             = $id_invoice;
        $this->id_db_settings = $id_db_settings;
        $this->Session        = $session_id;
        $this->Data           = $data;
        $this->InvoiceType    = $Invoice;

        if(DBKwanzar::CheckConfig($this->id_db_settings) == false || DBKwanzar::CheckConfig($this->id_db_settings)['JanuarioSakalumbu'] == null): $this->Numero = 2; else: $this->Numero = DBKwanzar::CheckConfig($this->id_db_settings)['JanuarioSakalumbu']; endif;

        $Read = new Read();
        $Read->ExeRead(self::sd_billing, "WHERE id=:i AND id_db_settings=:a", "i={$this->ID}&a={$this->id_db_settings}");

        if($Read->getResult()):
            $this->Info = $Read->getResult()[0];

            $this->Info['Invoice'] = $this->Info['InvoiceType']." ".$this->Info['mes'].$this->Info['Code'].$this->Info['ano']."/".$this->Info['numero'];

            $this->Info["InvoiceDate"] = $this->Info["ano"]."-".$this->Info["mes"]."-".$this->Info["dia"];
            unset($this->Info['hash']);
            unset($this->Info['page_found']);
            unset($this->Info['hashcontrol']);
            unset($this->Info['id']);
            unset($this->Info['numero']);
            unset($this->Info['InvoiceType']);
            unset($this->Info['method']);
            unset($this->Info['status']);
            unset($this->Info['suspenso']);
            unset($this->Info['dia']);
            unset($this->Info['mes']);
            unset($this->Info['ano']);
            unset($this->Info['hora']);
            unset($this->Info['pagou']);
            unset($this->Info['troco']);
            unset($this->Info['status']);
            unset($this->Info['TaxPointDate']);
            unset($this->Info['id_mesa']);
            unset($this->Info['SourceBilling']);
            unset($this->Info['timer ']);
            unset($this->Info['date_expiration']);
            unset($this->Info['box_in']);
            unset($this->Info['session_id']);
            unset($this->Info['username']);
            //unset($this->Info['RetencaoDeFonte']);
            //unset($this->Info['IncluirNaFactura']);
            //unset($this->Info['se']);


            $this->Info['settings_doctype']= $this->Data['settings_doctype'];
            $this->Info['TaxPointDate']    = $this->Data['TaxPointDate'];
            $this->Info['InvoiceType']     = $this->Data['InvoiceType'];
            $this->Info['method']          = $this->Data['method'];
            $this->Info['SourceBilling']   = $this->Data['SourceBilling'];
            $this->Info['date_expiration'] = null;
            $this->Info['timer']           = null;
            $this->Info['box_in']          = 1;

            $this->Info['dia']          = date('d');
            $this->Info['mes']          = date('m');
            $this->Info['ano']          = date('Y');
            $this->Info['hora']         = date('H:i:s');
            $this->Info['id_invoice']   = $this->ID;
            $this->Info['session_id'] = $this->Session;

            $Read = new Read();
            $Read->ExeRead("db_users", "WHERE id=:i", "i={$this->Session}");
            if($Read->getResult()):
                $this->Info['username'] = $Read->getResult()[0]['name'];
            endif;

            $status = 1;
            $Read->ExeRead(self::sd_retification, "WHERE id_db_settings=:i AND id_invoice=:idd AND status=:s", "i={$this->id_db_settings}&idd={$this->ID}&s={$status}");

            if($this->Data['InvoiceType'] == "RG"):
                $this->Info['hash'] = null;
            else:
                $this->Hash(self::sd_retification);
            endif;

            $this->Code();

            if($Read->getResult()):
                $this->UpdateRet();
            else:
                $this->Info['numero']   = $this->Number;
                $this->Info['status']   = 1;
                $this->CreateRet();
            endif;
        endif;
    }

    private function Code(){
        $Read = new Read();
        $Read->ExeRead(self::sd_retification, "WHERE id_db_settings=:i", "i={$this->id_db_settings}");

        if($Read->getResult()):
            $this->Number = $Read->getRowCount() + 1;
        else:
            $this->Number = 1;
        endif;
    }

    private function UpdateRet(){
        $status = 1;
        $Update = new Update();
        $Update->ExeUpdate(self::sd_retification, $this->Info, "WHERE id_db_settings=:i AND id_invoice=:idd AND status=:s", "i={$this->id_db_settings}&idd={$this->ID}&s={$status}");

        if($Update->getResult()):
            $this->Error  = ["O documento foi atualizado com sucesso!", WS_ACCEPT];
            $this->Result = true;
        else:
            $this->Error  = ["Ops: aconteceu um erro inesperado ao atualizar o docmento!", WS_ERROR];
            $this->Result = false;
        endif;
    }

    public function CreateRet(){
        $Create = new Create();
        $Create->ExeCreate(self::sd_retification, $this->Info);

        if($Create->getResult()):
            $this->Result = true;
        else:
            $this->Error  = ["Ops: aconteceu um erro inesperado ao criar o docmento!", WS_ERROR];
            $this->Result = false;
        endif;
    }


    private $iddInvoice;

    public function Remove(array $data, $id_db_settings, $id_sd_billing_pmp, $session_id, $idd, $InvoiceType, $iddInvoice, $Number){
        $this->Data           = $data;
        $this->id_db_settings = $id_db_settings;
        $this->ID             = $id_sd_billing_pmp;
        $this->Session        = $session_id;
        $this->Finish         = $idd;
        $this->InvoiceType    = $InvoiceType;
        $this->iddInvoice = $iddInvoice;
        $this->Number = $Number;

        $this->CheckQuantidade();
        if($this->Result):
            $this->CreateBody();
        endif;
    }

    private function CheckQuantidade(){
        if($this->Data['quantidade'] <= 0):
            $this->Error  = ["Ops: não é permitido ter quantidades negativas aos documentos comercial!", WS_ALERT];
            $this->Result = false;
        else:
            $read = new Read();
            $read->ExeRead(self::sd_billing_pmp, "WHERE id=:n AND id_db_settings=:i AND InvoiceType=:os AND status=:st", "n={$this->Finish}&i={$this->id_db_settings}&os={$this->InvoiceType}&st={$this->Data['status']}");

            if($read->getResult()):
                foreach($read->getResult() as $key):
                    extract($key);
                    $this->Info = $key;
                    unset($this->Info['id_mesa']);
                    unset($this->Info['quantidade_pmp']);
                    unset($this->Info['status']);
                    unset($this->Info['id']);
                    unset($this->Info['suspenso']);
                    unset($this->Info['numero']);
                    unset($this->Info['InvoiceType']);
                    unset($this->Info['box_in']);
                    unset($this->Info['session_id']);
                    $this->Numero = 0;


                    $st = 1;

                    $read->ExeRead(self::sd_retification, "WHERE id_db_settings=:i AND status=:ipp", "i={$this->id_db_settings}&ipp={$st}");
                    if($read->getResult()): $this->Info['InvoiceType'] = $read->getResult()[0]['InvoiceType']; endif;


                    $read->ExeRead(self::sd_retification_pmp, "WHERE id_db_settings=:ip AND id_product=:vg AND id_invoice=:ijj AND status=:st", "ip={$this->id_db_settings}&vg={$this->ID}&ijj={$this->Number}&st={$st}");
                    if($read->getResult()):
                        foreach($read->getResult() as $n):
                            extract($n);

                            $this->Numero = $key['quantidade_pmp'] - $n['quantidade_pmp'];
                            if($this->Numero - $this->Data['quantidade'] > 0):
                                $this->Number = $this->Data['numero'];
                                $this->Result = true;
                            else:
                                $this->Error  = ["Ops: Quantidade insuficiênte!", WS_INFOR];
                                $this->Result = false;
                            endif;
                        endforeach;
                    else:
                        $this->Numero = $this->Data['quantidade'];
                        if($this->Numero > 0):
                            $this->Number = $this->Data['quantidade'];
                            $this->Result = true;
                        else:
                            $this->Error  = ["Ops: Quantidade insuficiênte!", WS_INFOR];
                            $this->Result = false;
                        endif;
                    endif;
                endforeach;
            else:
                $this->Error  = ["Ops: não encontramos nada!", WS_INFOR];
                $this->Result = false;
            endif;
        endif;
    }

    private function CreateBody(){
        $status = 1;
        $Read = new Read();
        $Read->ExeRead(self::sd_retification, "WHERE id_db_settings=:i AND invoice=:ivd AND status=:stt ", "i={$this->id_db_settings}&ivd={$this->iddInvoice}&stt={$status}");

        if($Read->getResult()):
            $this->Info['id_invoice']      = $Read->getResult()[0]['id_invoice'];
            $this->Info['numero']          = $Read->getResult()[0]['numero'];
            $this->Info['Invoice']         = $Read->getResult()[0]['Invoice'];
            $this->Info['status']          = $Read->getResult()[0]['status'];
            $this->Info['quantidade_pmp']  = $this->Number;
            $this->Info['box_in']          = 1;
            $this->Info['session_id']          = $this->Session;

            $Create = new Create();
            $Create->ExeCreate(self::sd_retification_pmp, $this->Info);

            if($Create->getResult()):
                $this->Error  = ["Item adicionado na lista de verificação com sucesso!", WS_ACCEPT];
                $this->Result = true;
            else:
                $this->Error  = ["Ops: aconteceu um erro inesperado ao adionar o item na lista de verificação!", WS_ERROR];
                $this->Result = false;
            endif;
        else:
            $this->Error  = ["Ops: aconteceu um erro inesperado ao pesquisar a factura!", WS_ERROR];
            $this->Result = false;
        endif;
    }

    private $is_number;

    public function RemFinish($id_db_settings, $session, $InvoiceType, $Number, $iddInvoice, $is_number){
        $this->id_db_settings = $id_db_settings;
        $this->Session        = $session;
        $this->InvoiceType    = $InvoiceType;
        $this->Number         = $Number;
        $this->iddInvoice = $iddInvoice;
        $this->is_number = $is_number;

        $r1 = self::sd_retification;
        $r2 = self::sd_retification_pmp;
        $st = 1;
        $stattus = 0;

        $total_f = 0;
        $total_r = 0;


        $Read = new Read();
        $Read->ExeRead("{$r1}, {$r2}", "WHERE {$r1}.id_db_settings=:i AND {$r1}.id_invoice=:id AND {$r1}.status=:st AND {$r1}.Invoice=:idTd AND {$r2}.id_db_settings=:i AND {$r2}.Invoice={$r1}.Invoice AND {$r2}.id_invoice=:id AND {$r2}.status=:st", "i={$this->id_db_settings}&id={$this->Number}&st={$st}&idTd={$this->iddInvoice}");

        if(!$Read->getResult()):
            $Read->ExeRead("{$r1}", "WHERE {$r1}.id_db_settings=:i AND {$r1}.id_invoice=:id AND {$r1}.status=:st", "i={$this->id_db_settings}&id={$this->Number}&st={$st}");
            if($Read->getResult()):
                /**foreach ($Read->getResult() as $item):
                $this->Error = ["O documento <strong>{$item['Invoice']}</strong>, em contra-se aberto e ainda não foi finalizado!", WS_INFOR];
                $this->Result = false;
                endforeach;**/

                if(DBKwanzar::CheckConfig($this->id_db_settings)['JanuarioSakalumbu'] == null): $this->Data['status'] = 2; $this->Info["status"] = 2; else: $this->Data['status'] = DBKwanzar::CheckConfig($this->id_db_settings)['JanuarioSakalumbu']; $this->Info["status"] = DBKwanzar::CheckConfig($this->id_db_settings)['JanuarioSakalumbu']; endif;

                if($Read->getResult()):
                    foreach($Read->getResult() as $key):
                        //extract($key);
                        $value = ($key['preco_pmp'] * $key['quantidade_pmp']);
                        $desconto = ($value * $key['desconto_pmp']) / 100;
                        $iva = ($value * $key['taxa']) / 100;

                        $total = ($value - $desconto) + $iva;
                        $total_r += $total;
                    endforeach;
                endif;

                $n1 = self::sd_billing;
                $n2 = self::sd_billing_pmp;
                $Read->ExeRead("{$n1}, {$n2}", "WHERE {$n1}.id_db_settings=:ip AND {$n1}.InvoiceType=:i AND {$n1}.id=:cc AND {$n2}.id_db_settings=:ip AND {$n2}.InvoiceType=:i AND {$n1}.numero=:is AND {$n2}.numero={$n1}.numero", "ip={$this->id_db_settings}&i={$this->InvoiceType}&cc={$this->Number}&is={$this->is_number}");
                if($Read->getResult()):
                    foreach($Read->getResult() as $key):
                        //extract($key);
                        $value = ($key['preco_pmp'] * $key['quantidade_pmp']);
                        $desconto = ($value * $key['desconto_pmp']) / 100;
                        $iva = ($value * $key['taxa']) / 100;

                        $total = ($value - $desconto) + $iva;
                        $total_f += $total;
                    endforeach;
                endif;

                if($total_r == $total_f): $this->Info['settings_info'] = "Anulação"; else: $this->Info["settings_info"] = "Rectificação"; endif;
                $this->Info['r'] = $total_r;
                $this->Info['f'] = $total_f;
                $this->FinishRem();
            else:
                $this->Error  = ["Ops: encontramos uma inconsistência no documento de verificação, a tualize a página e tente novamente!", WS_ALERT];
                $this->Result = false;
            endif;
        else:
            if(DBKwanzar::CheckConfig($this->id_db_settings)['JanuarioSakalumbu'] == null): $this->Data['status'] = 2; $this->Info["status"] = 2; else: $this->Data['status'] = DBKwanzar::CheckConfig($this->id_db_settings)['JanuarioSakalumbu']; $this->Info["status"] = DBKwanzar::CheckConfig($this->id_db_settings)['JanuarioSakalumbu']; endif;

            if($Read->getResult()):
                foreach($Read->getResult() as $key):
                    //extract($key);
                    $value = ($key['preco_pmp'] * $key['quantidade_pmp']);
                    $desconto = ($value * $key['desconto_pmp']) / 100;
                    $iva = ($value * $key['taxa']) / 100;

                    $total = ($value - $desconto) + $iva;
                    $total_r += $total;
                endforeach;
            endif;

            $n1 = self::sd_billing;
            $n2 = self::sd_billing_pmp;
            $Read->ExeRead("{$n1}, {$n2}", "WHERE {$n1}.id_db_settings=:ip AND {$n1}.InvoiceType=:i AND {$n1}.id=:cc AND {$n2}.id_db_settings=:ip AND {$n2}.InvoiceType=:i AND {$n1}.numero=:is AND {$n2}.numero={$n1}.numero", "ip={$this->id_db_settings}&i={$this->InvoiceType}&cc={$this->Number}&is={$this->is_number}");
            if($Read->getResult()):
                foreach($Read->getResult() as $key):
                    //extract($key);
                    $value = ($key['preco_pmp'] * $key['quantidade_pmp']);
                    $desconto = ($value * $key['desconto_pmp']) / 100;
                    $iva = ($value * $key['taxa']) / 100;

                    $total = ($value - $desconto) + $iva;
                    $total_f += $total;
                endforeach;
            endif;

            if($total_r == $total_f): $this->Info['settings_info'] = "Anulação"; else: $this->Info["settings_info"] = "Rectificação"; endif;
            $this->Info['r'] = $total_r;
            $this->Info['f'] = $total_f;
            $this->FinishRem();
        endif;
    }

    private function FinishRem(){
        $r1 = self::sd_retification;
        $r2 = self::sd_retification_pmp;
        $st = 1;

        //$this->Info["{$r1}.status"] =  $this->Data['status'];
        //$this->Info["{$r2}.status"] =  $this->Data['status'];


        $Update = new Update();
        $Update->ExeUpdate("{$r1}", $this->Info, "WHERE {$r1}.id_db_settings=:i AND  {$r1}.id_invoice=:iT AND {$r1}.session_id=:id AND {$r1}.status=:st", "i={$this->id_db_settings}&iT={$this->Number}&id={$this->Session}&st={$st}");

        if($Update->getResult()):
            $Read = new Read();
            $Read->ExeRead("{$r2}", "WHERE {$r2}.id_db_settings=:i  AND  {$r2}.id_invoice=:iT AND {$r2}.session_id=:id AND {$r2}.status=:st", "i={$this->id_db_settings}&iT={$this->Number}&id={$this->Session}&st={$st}");

            if($Read->getResult()):
                $b = $Read->getResult()[0];
                if($b['InvoiceType'] == "NC"):
                    foreach ($Read->getResult() as $row):
                        if($row['product_type']):
                            $Read->ExeRead(self::cv_product, "WHERE id=:i", "i={$row['id_product']}");
                            if($Read->getResult()):
                                $heliospro = $Read->getResult()[0];
                                /**if(DBKwanzar::CheckSettingsII($this->id_db_settings)['atividade'] == 1):
                                    $qtd['quantidade'] = $heliospro['quantidade'] + $row['quantidade_pmp'];
                                else:
                                    $qtd['unidades'] = $heliospro['unidades'] + $row['quantidade_pmp'];
                                endif;**/

                                $qtd['quantidade'] = $heliospro['quantidade'] + $row['quantidade_pmp'];

                                $Update->ExeUpdate(self::cv_product, $qtd, "WHERE id=:i", "i={$row['id_product']}");
                                if($Update->getResult()):
                                    $Update->ExeUpdate("{$r2}", $this->Data, "WHERE {$r2}.id_db_settings=:i AND  {$r2}.id_invoice=:iT AND {$r2}.session_id=:id AND {$r2}.status=:st", "i={$this->id_db_settings}&iT={$this->Number}&id={$this->Session}&st={$st}");

                                    if($Update->getResult()):
                                        $this->Error  = ["Operação realizada com sucesso!", WS_ACCEPT];
                                        $this->Result = true;
                                    else:
                                        $this->Error  = ["Ops: aconteceu um erro inesperado ao finalizar o documento de retificação! (1)", WS_ERROR];
                                        $this->Result = false;
                                    endif;
                                else:
                                    $this->Error  = ["Ops: aconteceu um erro ao atualizar o produto! x100", WS_ERROR];
                                    $this->Result = false;
                                endif;
                            else:
                                $this->Result = false;
                                $this->Error  = ["Ops: não encontramos o produto selecionado!", WS_ERROR];
                            endif;
                        endif;
                    endforeach;
                else:
                    $Update->ExeUpdate("{$r2}", $this->Data, "WHERE {$r2}.id_db_settings=:i AND  {$r2}.id_invoice=:iT AND {$r2}.session_id=:id AND {$r2}.status=:st", "i={$this->id_db_settings}&iT={$this->Number}&id={$this->Session}&st={$st}");

                    if($Update->getResult()):
                        $this->Error  = ["Operação realizada com sucesso!", WS_ACCEPT];
                        $this->Result = true;
                    else:
                        $this->Error  = ["Ops: aconteceu um erro inesperado ao finalizar o documento de retificação! (1)", WS_ERROR];
                        $this->Result = false;
                    endif;
                endif;
            else:
                $Update->ExeUpdate("{$r2}", $this->Data, "WHERE {$r2}.id_db_settings=:i AND {$r2}.id_invoice=:iT AND {$r2}.session_id=:id AND {$r2}.status=:st", "i={$this->id_db_settings}&iT={$this->Number}&id={$this->Session}&st={$st}");

                if($Update->getResult()):
                    $this->Error  = ["Operação realizada com sucesso!", WS_ACCEPT];
                    $this->Result = true;
                else:
                    $this->Error  = ["Ops: aconteceu um erro inesperado ao finalizar o documento de retificação! (1)", WS_ERROR];
                    $this->Result = false;
                endif;
            endif;
        else:
            $this->Error  = ["Ops: aconteceu um erro inesperado ao finalizar o documento de retificação! (2)", WS_ERROR];
            $this->Result = false;
        endif;
    }

    public function Guid(array $data, $id_invoice, $id_db_settings, $session_id, $Invoice){
        $this->ID             = $id_invoice;
        $this->id_db_settings = $id_db_settings;
        $this->Session        = $session_id;
        $this->Data           = $data;
        $this->InvoiceType    = $Invoice;

        if(DBKwanzar::CheckConfig($this->id_db_settings) == false || DBKwanzar::CheckConfig($this->id_db_settings)['JanuarioSakalumbu'] == null): $this->Numero = 2; else: $this->Numero = DBKwanzar::CheckConfig($this->id_db_settings)['JanuarioSakalumbu']; endif;

        $Read = new Read();
        $Read->ExeRead(self::sd_billing, "WHERE id=:i AND id_db_settings=:a", "i={$this->ID}&a={$this->id_db_settings}");

        if($Read->getResult()):
            $this->Info = $Read->getResult()[0];

            $this->Info['Invoice'] = $this->Info['InvoiceType']." ".$this->Info['mes'].$this->Info['Code'].$this->Info['ano']."/".$this->Info['numero'];

            $this->Info["InvoiceDate"] = $this->Info["ano"]."-".$this->Info["mes"]."-".$this->Info["dia"];
            unset($this->Info['hash']);
            unset($this->Info['page_found']);
            unset($this->Info['hashcontrol']);
            unset($this->Info['id']);
            unset($this->Info['numero']);
            unset($this->Info['InvoiceType']);
            unset($this->Info['method']);
            unset($this->Info['status']);
            unset($this->Info['suspenso']);
            unset($this->Info['dia']);
            unset($this->Info['mes']);
            unset($this->Info['ano']);
            unset($this->Info['hora']);
            unset($this->Info['pagou']);
            unset($this->Info['troco']);
            unset($this->Info['status']);
            unset($this->Info['TaxPointDate']);
            unset($this->Info['id_mesa']);
            unset($this->Info['SourceBilling']);
            unset($this->Info['timer ']);
            unset($this->Info['date_expiration']);
            unset($this->Info['box_in']);
            unset($this->Info['RetencaoDeFonte']);
            unset($this->Info['IncluirNaFactura']);
            //unset($this->Info['se']);

            $this->Info['TaxPointDate']    = $this->Data['TaxPointDate'];
            $this->Info['InvoiceType']     = $this->Data['InvoiceType'];
            $this->Info['method']          = $this->Data['method'];
            $this->Info['SourceBilling']   = $this->Data['SourceBilling'];
            $this->Info['date_expiration'] = null;
            $this->Info['timer']           = null;
            $this->Info['box_in']          = 1;
            $this->Info['guid_name']       = $this->Data['guid_name'];
            $this->Info['guid_matricula']  = $this->Data['guid_matricula'];
            $this->Info['guid_obs']        = $this->Data['guid_obs'];
            $this->Info['guid_endereco']   = $this->Data['guid_endereco'];
            $this->Info['guid_city']       = $this->Data['guid_city'];
            $this->Info['guid_postal']     = $this->Data['guid_postal'];

            $this->Info['dia']          = date('d');
            $this->Info['mes']          = date('m');
            $this->Info['ano']          = date('Y');
            $this->Info['hora']         = date('H:i:s');
            $this->Info['id_invoice']   = $this->ID;

            $status = 1;
            $Read->ExeRead(self::sd_guid, "WHERE id_db_settings=:i AND status=:s", "i={$this->id_db_settings}&s={$status}");
            if($this->Data['InvoiceType'] == "RG"):
                $this->Info['hash'] = null;
            else:
                $this->Hash(self::sd_guid);
            endif;

            $this->GuiCode();

            if($Read->getResult()):
                $this->UpdateGuid();
            else:
                $this->Info['numero']       = $this->Number;
                $this->Info['status']   = 1;
                $this->CreateGuid();
            endif;
        endif;
    }

    private function GuiCode(){
        $Read = new Read();
        $Read->ExeRead(self::sd_guid, "WHERE id_db_settings=:i AND InvoiceType=:ip AND status=:st", "i={$this->id_db_settings}&ip={$this->Data['InvoiceType']}&st={$this->Numero}");

        if($Read->getResult()):
            $this->Number = $Read->getRowCount() + 1;
        else:
            $this->Number = 1;
        endif;
    }

    private function UpdateGuid(){
        $status = 1;
        $Update = new Update();
        $Update->ExeUpdate(self::sd_guid, $this->Info, "WHERE id_db_settings=:i AND status=:st", "i={$this->id_db_settings}&st={$status}");

        if($Update->getResult()):
            $this->Result = true;
        else:
            $this->Error  = ["Ops: aconteceu um erro inesperado ao atualizar o docmento!", WS_ERROR];
            $this->Result = false;
        endif;
    }

    public function CreateGuid(){
        $Create = new Create();
        $Create->ExeCreate(self::sd_guid, $this->Info);

        if($Create->getResult()):
            $this->Result = true;
        else:
            $this->Error  = ["Ops: aconteceu um erro inesperado ao criar o docmento!", WS_ERROR];
            $this->Result = false;
        endif;
    }

    public function RemoveGuid(array $data, $id_db_settings, $id_sd_billing_pmp, $session_id, $idd, $InvoiceType){
        $this->Data           = $data;
        $this->id_db_settings = $id_db_settings;
        $this->ID             = $id_sd_billing_pmp;
        $this->Session        = $session_id;
        $this->Finish         = $idd;
        $this->InvoiceType    = $InvoiceType;

        $this->CheckQuantidadeGuid();
        if($this->Result):
            $this->CreateBodyGuid();
        endif;
    }

    private function CheckQuantidadeGuid(){
        if($this->Data['quantidade'] <= 0):
            $this->Error  = ["Ops: não é permitido ter quantidades negativas aos documentos comercial!", WS_ALERT];
            $this->Result = false;
        else:
            $read = new Read();
            $read->ExeRead(self::sd_billing_pmp, "WHERE id=:n AND id_db_settings=:i AND InvoiceType=:os AND status=:st", "n={$this->Finish}&i={$this->id_db_settings}&os={$this->InvoiceType}&st={$this->Data['status']}");

            if($read->getResult()):
                foreach($read->getResult() as $key):
                    extract($key);
                    $this->Info = $key;
                    unset($this->Info['id_mesa']);
                    unset($this->Info['quantidade_pmp']);
                    unset($this->Info['status']);
                    unset($this->Info['id']);
                    unset($this->Info['suspenso']);
                    unset($this->Info['numero']);
                    unset($this->Info['InvoiceType']);
                    unset($this->Info['box_in']);
                    $this->Numero = 0;


                    $st = 1;

                    $read->ExeRead(self::sd_guid, "WHERE id_db_settings=:i AND session_id=:ip AND status=:ipp", "i={$this->id_db_settings}&ip={$this->Session}&ipp={$st}");
                    if($read->getResult()): $this->Info['InvoiceType'] = $read->getResult()[0]['InvoiceType']; endif;


                    $read->ExeRead(self::sd_guid_pmp, "WHERE id_db_settings=:ip AND id_product=:vg AND session_id=:i AND status=:st", "ip={$this->id_db_settings}&vg={$this->ID}&i={$this->Session}&st={$st}");
                    if($read->getResult()):
                        foreach($read->getResult() as $n):
                            extract($n);

                            $this->Numero = $key['quantidade_pmp'] - $n['quantidade_pmp'];
                            if($this->Numero - $this->Data['quantidade'] > 0):
                                $this->Number = $this->Data['numero'];
                                $this->Result = true;
                            else:
                                $this->Error  = ["Ops: Quantidade insuficiênte!", WS_INFOR];
                                $this->Result = false;
                            endif;
                        endforeach;
                    else:
                        $this->Numero = $this->Data['quantidade'];
                        if($this->Numero > 0):
                            $this->Number = $this->Data['quantidade'];
                            $this->Result = true;
                        else:
                            $this->Error  = ["Ops: Quantidade insuficiênte!", WS_INFOR];
                            $this->Result = false;
                        endif;
                    endif;
                endforeach;
            else:
                $this->Error  = ["Ops: não encontramos nada!", WS_INFOR];
                $this->Result = false;
            endif;
        endif;
    }

    private function CreateBodyGuid(){
        $status = 1;
        $Read = new Read();
        $Read->ExeRead(self::sd_guid, "WHERE id_db_settings=:i AND session_id=:p AND status=:stt ", "i={$this->id_db_settings}&p={$this->Session}&stt={$status}");

        if($Read->getResult()):
            $this->Info['id_invoice']      = $Read->getResult()[0]['id_invoice'];
            $this->Info['numero']          = $Read->getResult()[0]['numero'];
            $this->Info['Invoice']         = $Read->getResult()[0]['Invoice'];
            $this->Info['status']          = $Read->getResult()[0]['status'];
            $this->Info['quantidade_pmp']  = $this->Number;
            $this->Info['box_in']          = 1;

            $Create = new Create();
            $Create->ExeCreate(self::sd_guid_pmp, $this->Info);

            if($Create->getResult()):
                $this->Error  = ["Item adicionado na lista de verificação com sucesso!", WS_ACCEPT];
                $this->Result = true;
            else:
                $this->Error  = ["Ops: aconteceu um erro inesperado ao adionar o item na lista de verificação!", WS_ERROR];
                $this->Result = false;
            endif;
        else:
            $this->Error  = ["Ops: aconteceu um erro inesperado ao pesquisar a factura!", WS_ERROR];
            $this->Result = false;
        endif;
    }

    public function GuidFinish($id_db_settings, $session, $InvoiceType, $Number){
        $this->id_db_settings = $id_db_settings;
        $this->Session        = $session;
        $this->InvoiceType    = $InvoiceType;
        $this->Number         = $Number;

        $r1 = self::sd_guid;
        $r2 = self::sd_guid_pmp;
        $st = 1;

        $total_f = 0;
        $total_r = 0;

        $Read = new Read();
        $Read->ExeRead("{$r1}, {$r2}", "WHERE {$r1}.id_db_settings=:i AND {$r1}.session_id=:id AND {$r1}.status=:st AND {$r2}.id_db_settings=:i AND {$r2}.session_id=:id AND {$r2}.status=:st", "i={$this->id_db_settings}&id={$this->Session}&st={$st}");

        if(!$Read->getResult()):
            $this->Error  = ["Ops: encontramos uma inconsistência no documento de verificação, a tualize a página e tente novamente!", WS_ALERT];
            $this->Result = false;
        else:
            if(DBKwanzar::CheckConfig($this->id_db_settings)['JanuarioSakalumbu'] == null): $this->Data['status'] = 2; $this->Info["status"] = 2; else: $this->Data['status'] = DBKwanzar::CheckConfig($this->id_db_settings)['JanuarioSakalumbu']; $this->Info["status"] = DBKwanzar::CheckConfig($this->id_db_settings)['JanuarioSakalumbu']; endif;

            if($Read->getResult()):
                foreach($Read->getResult() as $key):
                    extract($key);
                    $value = ($key['preco_pmp'] * $key['quantidade_pmp']);
                    $desconto = ($value * $key['desconto_pmp']) / 100;
                    $iva = ($value * $key['taxa']) / 100;

                    $total = ($value - $desconto) + $iva;
                    $total_r += $total;
                endforeach;
            endif;

            $n1 = self::sd_billing;
            $n2 = self::sd_billing_pmp;
            $Read->ExeRead("{$n1}, {$n2}", "WHERE {$n1}.id_db_settings=:ip AND {$n1}.InvoiceType=:i AND {$n1}.id=:cc AND {$n2}.id_db_settings=:ip AND {$n2}.InvoiceType=:i AND {$n2}.numero={$n1}.numero", "ip={$this->id_db_settings}&i={$this->InvoiceType}&cc={$this->Number}");
            if($Read->getResult()):
                foreach($Read->getResult() as $key):
                    extract($key);
                    $value = ($key['preco_pmp'] * $key['quantidade_pmp']);
                    $desconto = ($value * $key['desconto_pmp']) / 100;
                    $iva = ($value * $key['taxa']) / 100;

                    $total = ($value - $desconto) + $iva;
                    $total_f += $total;
                endforeach;
            endif;

            if($total_r == $total_f): $this->Info['settings_info'] = "Anulação"; else: $this->Info["settings_info"] = "Retificação"; endif;
            $this->Info['r'] = $total_r;
            $this->Info['f'] = $total_f;
            $this->FinishGuid();
        endif;
    }

    private function FinishGuid(){
        $r1 = self::sd_guid;
        $r2 = self::sd_guid_pmp;
        $st = 1;

        //$this->Info["{$r1}.status"] =  $this->Data['status'];
        //$this->Info["{$r2}.status"] =  $this->Data['status'];


        $Update = new Update();
        $Update->ExeUpdate("{$r1}", $this->Info, "WHERE {$r1}.id_db_settings=:i AND {$r1}.session_id=:id AND {$r1}.status=:st", "i={$this->id_db_settings}&id={$this->Session}&st={$st}");

        if($Update->getResult()):
            $Update->ExeUpdate("{$r2}", $this->Data, "WHERE {$r2}.id_db_settings=:i AND {$r2}.session_id=:id AND {$r2}.status=:st", "i={$this->id_db_settings}&id={$this->Session}&st={$st}");

            if($Update->getResult()):
                $this->Error  = ["Operação realizada com sucesso!", WS_ACCEPT];
                $this->Result = true;
            else:
                $this->Error  = ["Ops: aconteceu um erro inesperado ao finalizar o documento de retificação! (1)", WS_ERROR];
                $this->Result = false;
            endif;
        else:
            $this->Error  = ["Ops: aconteceu um erro inesperado ao finalizar o documento de retificação! (2)", WS_ERROR];
            $this->Result = false;
        endif;
    }

    public static function Timer($numero, $invoice){
        $Read = new Read();
        $Read->ExeRead(self::sd_billing, "WHERE numero=:i AND InvoiceType=:id", "i={$numero}&id={$invoice}");

        if($Read->getResult()):
            $k = $Read->getResult()[0];

            if($k['timer'] != null || $k['timer'] >= 1):
                $Data['timer'] = $k['timer'] + 1;
            else:
                $Data['timer'] = 1;
            endif;

            $Update = new Update();
            $Update->ExeUpdate(self::sd_billing, $Data, "WHERE numero=:i AND InvoiceType=:id", "i={$numero}&id={$invoice}");

            if(!$Update->getResult()):
                return false;
            else:
                return true;
            endif;
        endif;
    }

    public static function Timers($numero, $invoice){
        $Read = new Read();
        $Read->ExeRead(self::sd_retification, "WHERE numero=:i AND InvoiceType=:id", "i={$numero}&id={$invoice}");

        if($Read->getResult()):
            $k = $Read->getResult()[0];
            $Data['timer'] = $k['timer'] + 1;

            $Update = new Update();
            $Update->ExeUpdate(self::sd_retification, $Data, "WHERE numero=:i AND InvoiceType=:id", "i={$numero}&id={$invoice}");

            if(!$Update->getResult()):
                return false;
            else:
                return true;
            endif;
        endif;
    }

    public static function GTimers($numero, $invoice){
        $Read = new Read();
        $Read->ExeRead(self::sd_guid, "WHERE numero=:i AND InvoiceType=:id", "i={$numero}&id={$invoice}");

        if($Read->getResult()):
            $k = $Read->getResult()[0];
            $Data['timer'] = $k['timer'] + 1;

            $Update = new Update();
            $Update->ExeUpdate(self::sd_guid, $Data, "WHERE numero=:i AND InvoiceType=:id", "i={$numero}&id={$invoice}");

            if(!$Update->getResult()):
                return false;
            else:
                return true;
            endif;
        endif;
    }

    public function OpenBox($id_db_settings, $id_user, $value_box){
        $this->id_db_settings = $id_db_settings;
        $this->Session = $id_user;
        $this->Value = $value_box;

        if(!isset($this->Value) || empty($this->Value)):
            $this->Error  = ["Ops: O valor de abertura de caixa é obrigatório, caso não haja valores digite: <strong>0</strong>", WS_INFOR];
            $this->Result = false;
        else:
            $st = 1;

            $Read = new Read();
            $Read->ExeRead(self::sd_box, "WHERE id_db_settings=:i AND session_id=:ip AND status=:st", "i={$this->id_db_settings}&ip={$this->Session}&st={$st}");

            if($Read->getResult()):
                $this->UpdateOpenBox();
                //$this->Error  = ["Ops: o caixa já encontra-se aberto!", WS_INFOR];
                //$this->Result = false;
            else:
                $this->CreateOpenBox();
            endif;
        endif;
    }

    private function CreateOpenBox(){
        $this->Data['id_db_settings'] = $this->id_db_settings;
        $this->Data['session_id']     = $this->Session;
        $this->Data['value_open']     = $this->Value;
        $this->Data['abertura']       = date('d-m-Y H:i:s');
        $this->Data['status']         = 1;
        $this->Data['dia']            = date('d');
        $this->Data['mes']            = date('m');
        $this->Data['ano']            = date('Y');

        $ln = number_format($this->Value, 2);

        $Create = new Create();
        $Create->ExeCreate(self::sd_box, $this->Data);

        if($Create->getResult()):
            $this->Error  = ["Operação realizada com sucesso, o caixa foi aberto com <strong>{$ln}</strong>", WS_ACCEPT];
            $this->Result = true;
        else:
            $this->Error  = ["Ops: aconteceu um erro inesperado ao abrir o caixa, atualize a página e tente novamente!", WS_ERROR];
            $this->Result = false;
        endif;
    }

    private function UpdateOpenBox(){
        $this->Data['updater'] = date('d-m-Y H:i:s');
        $this->Data['value_open']     = $this->Value;

        $ln = number_format($this->Value, 2);
        $st = 1;

        $Update = new Update();
        $Update->ExeUpdate(self::sd_box, $this->Data, "WHERE id_db_settings=:i AND session_id=:ip AND status=:st", "i={$this->id_db_settings}&ip={$this->Session}&st={$st}");

        if($Update->getResult()):
            $this->Error  = ["Operação realizada com sucesso, a abertura do caixa foi atualizada com: <strong>{$ln}</strong>", WS_ACCEPT];
            $this->Result = true;
        else:
            $this->Error  = ["Ops: aconteceu um erro inesperado ao atualizar a abertura do caixa, atualize a página e tente novamente!", WS_ERROR];
            $this->Result = false;
        endif;
    }

    public  function SangriaBox($id_db_settings, $id_user, $value_sangria, $text_sangria){
        $this->id_db_settings = $id_db_settings;
        $this->Session = $id_user;
        $this->Value = $value_sangria;
        $this->Help  = $text_sangria;

        if(!isset($this->Value) || empty($this->Value) || !isset($this->Help) || empty($this->Help)):
            $this->Error  = ["Ops: O valor da sangria é obrigatório, caso não haja valores digite: <strong>0</strong>", WS_INFOR];
            $this->Result = false;
        else:
            $st = 1;

            $Read = new Read();
            $Read->ExeRead(self::sd_box, "WHERE id_db_settings=:i AND session_id=:ip AND status=:st", "i={$this->id_db_settings}&ip={$this->Session}&st={$st}");

            if($Read->getResult()):
                $this->Alert  = $Read->getResult()[0];
                $this->ExeSangriaBox();
            else:
                $this->Error  = ["Ops: É necessar fazer abertura de caixa para sangriar.!", WS_ALERT];
                $this->Result = false;
            endif;
        endif;
    }

    private function ExeSangriaBox(){

        $this->id_mesa = number_format($this->Value, 2);

        $this->Info['value_sangria'] = $this->Alert['value_sangria'] + $this->Value;

        $st = 1;
        $Update = new Update();
        $Update->ExeUpdate(self::sd_box, $this->Info, "WHERE id_db_settings=:i AND session_id=:ip AND status=:st", "i={$this->id_db_settings}&ip={$this->Session}&st={$st}");

        if($Update->getResult()):
            $this->Data['natureza']   = "S";
            $this->Data['quantidade'] = "1";
            $this->Data['preco']      = $this->Value;
            $this->Data['descricao']  = $this->Help;

            $Speding = new Spending();
            $Speding->ExeSpending($this->Data, $this->id_db_settings, $this->Session);

            if($Speding->getResult()):
                $this->Error  = ["Operação realizada com sucesso, o caixa foi sangriado em: <strong>{$this->id_mesa}</strong>", WS_ACCEPT];
                $this->Result = true;
            else:
                $this->Error  = ["Ops: aconteceu um erro inesperado ao criar a despesa;", WS_ERROR];
                $this->Result = false;
            endif;
        else:
            $this->Error  = ["Ops: aconteceu um erro inesperado ao atualizar a abertura do caixa, atualize a página e tente novamente!", WS_ERROR];
            $this->Result = false;
        endif;
    }

    public function BoxClose($id_db_settings, $id_user){
        $this->id_db_settings = $id_db_settings;
        $this->Session = $id_user;

        $st = 1;

        $Read = new Read();
        $Read->ExeRead(self::sd_box, "WHERE id_db_settings=:i AND session_id=:ip AND status=:st", "i={$this->id_db_settings}&ip={$this->Session}&st={$st}");

        if($Read->getResult()):
            $this->Info = $Read->getResult()[0];

            $day = date('d');
            $mound = date('m');
            $year = date('Y');

            $tT1 = 0;
            $tT2 = 0;
            $tT3 = 0;

            $n1 = self::sd_billing;
            $n2 = self::sd_billing_pmp;
            $n3 = self::sd_retification;
            $n4 = self::sd_retification_pmp;

            $Read->ExeRead("{$n1}, {$n2}", "WHERE {$n1}.id_db_settings=:i AND {$n1}.session_id=:ip AND {$n2}.id_db_settings=:i AND {$n2}.session_id=:ip AND {$n1}.dia BETWEEN {$this->Info['dia']} AND {$day} AND {$n1}.mes BETWEEN {$this->Info['mes']} AND {$mound} AND {$n1}.ano BETWEEN {$this->Info['ano']} AND {$year} AND {$n1}.InvoiceType='FR' AND {$n2}.InvoiceType={$n1}.InvoiceType AND {$n1}.box_in='1' AND {$n2}.box_in={$n1}.box_in ", "i={$this->id_db_settings}&ip={$this->Session}");

            if($Read->getResult()):
                foreach($Read->getResult() as $key):
                    extract($key);

                    $value = ($key['quantidade_pmp'] * $key['preco_pmp']);
                    $imposto = ($key['taxa'] * $value) / 100;
                    $desconto = ($key['desconto_pmp'] * $value) / 100;

                    $t1 = ($value - $desconto) + $imposto;
                    $tT1 += $t1;
                endforeach;
            endif;

            $Read->ExeRead("{$n1}, {$n2}", "WHERE {$n1}.id_db_settings=:i AND {$n1}.session_id=:ip AND {$n2}.id_db_settings=:i AND {$n2}.session_id=:ip AND {$n1}.dia BETWEEN {$this->Info['dia']} AND {$day} AND {$n1}.mes BETWEEN {$this->Info['mes']} AND {$mound} AND {$n1}.ano BETWEEN {$this->Info['ano']} AND {$year} AND {$n1}.InvoiceType='FT' AND {$n2}.InvoiceType={$n1}.InvoiceType AND {$n1}.box_in='1' AND {$n2}.box_in={$n1}.box_in", "i={$this->id_db_settings}&ip={$this->Session}");

            if($Read->getResult()):
                foreach($Read->getResult() as $key):
                    extract($key);

                    $value = ($key['quantidade_pmp'] * $key['preco_pmp']);
                    $imposto = ($key['taxa'] * $value) / 100;
                    $desconto = ($key['desconto_pmp'] * $value) / 100;

                    $t2 = ($value - $desconto) + $imposto;
                    $tT2 += $t2;
                endforeach;
            endif;

            $Read->ExeRead("{$n3}, {$n4}", "WHERE {$n3}.id_db_settings=:i AND {$n3}.session_id=:ip AND {$n4}.id_db_settings=:i AND {$n4}.session_id=:ip AND {$n3}.dia BETWEEN {$this->Info['dia']} AND {$day} AND {$n3}.mes BETWEEN {$this->Info['mes']} AND {$mound} AND {$n3}.ano BETWEEN {$this->Info['ano']} AND {$year} AND {$n3}.InvoiceType='NC' AND {$n4}.InvoiceType={$n3}.InvoiceType AND {$n3}.box_in='1' AND {$n4}.box_in={$n3}.box_in", "i={$this->id_db_settings}&ip={$this->Session}");

            if($Read->getResult()):
                foreach($Read->getResult() as $key):
                    extract($key);

                    $value = ($key['quantidade_pmp'] * $key['preco_pmp']);
                    $imposto = ($key['taxa'] * $value) / 100;
                    $desconto = ($key['desconto_pmp'] * $value) / 100;

                    $t3 = ($value - $desconto) + $imposto;
                    $tT3 += $t3;
                endforeach;
            endif;

            $Read->ExeRead("{$n3}, {$n4}", "WHERE {$n3}.id_db_settings=:i AND {$n3}.session_id=:ip AND {$n4}.id_db_settings=:i AND {$n4}.session_id=:ip AND {$n3}.dia BETWEEN {$this->Info['dia']} AND {$day} AND {$n3}.mes BETWEEN {$this->Info['mes']} AND {$mound} AND {$n3}.ano BETWEEN {$this->Info['ano']} AND {$year} AND {$n3}.InvoiceType='RG' AND {$n4}.InvoiceType={$n3}.InvoiceType AND {$n3}.box_in='1' AND {$n4}.box_in={$n3}.box_in ", "i={$this->id_db_settings}&ip={$this->Session}");

            if($Read->getResult()):
                foreach($Read->getResult() as $key):
                    extract($key);

                    $value = ($key['quantidade_pmp'] * $key['preco_pmp']);
                    $imposto = ($key['taxa'] * $value) / 100;
                    $desconto = ($key['desconto_pmp'] * $value) / 100;

                    $t1 = ($value - $desconto) + $imposto;
                    $tT1 += $t1;
                endforeach;
            endif;

            $this->Data['value_finish'] = $tT1;
            $this->Data['value_null']  = $tT3;
            $this->Data['value_credit']= $tT2;
            $this->Data['status']      = 2;

            $this->ExeBoxClose();
        endif;
    }

    private function ExeBoxClose(){
        $this->Data['fecho'] = date('d-m-Y H:i:s');
        $st = 1;
        $Update = new Update();
        $Update->ExeUpdate(self::sd_box, $this->Data, "WHERE id_db_settings=:i AND session_id=:ip AND status=:st", "i={$this->id_db_settings}&ip={$this->Session}&st={$st}");

        if($Update->getResult()):
            $box = 1;
            $BoxIn = ['box_in' => 2];
            $Update->ExeUpdate(self::sd_billing, $BoxIn, "WHERE box_in=:in", "in={$box}");

            if($Update->getResult()):
                $Update->ExeUpdate(self::sd_billing_pmp, $BoxIn, "WHERE box_in=:in", "in={$box}");
                if($Update->getResult()):
                    $Update->ExeUpdate(self::sd_retification, $BoxIn, "WHERE box_in=:in", "in={$box}");
                    if($Update->getResult()):
                        $Update->ExeUpdate(self::sd_retification_pmp, $BoxIn, "WHERE box_in=:in", "in={$box}");
                        if($Update->getResult()):
                            $this->Result = true;
                        else:
                            $this->Error  = ["Ops: Erro 4x19 (4)", WS_INFOR];
                            $this->Result = false;
                        endif;
                    else:
                        $this->Error  = ["Ops: Erro 4x19 (3)", WS_INFOR];
                        $this->Result = false;
                    endif;
                else:
                    $this->Error  = ["Ops: Erro 4x19 (2)", WS_INFOR];
                    $this->Result = false;
                endif;
            else:
                $this->Error  = ["Ops: Erro 4x19 (1)", WS_INFOR];
                $this->Result = false;
            endif;

        else:
            $this->Error  = ["Ops: aconteceu um erro inesperado ao fechar o caixa, atualize a página e tente novamente!", WS_ERROR];
            $this->Result = false;
        endif;
    }

    // Atualizar a quantidade dos produtos
    /**
     * @param $id_db_settings
     * @param $id_user
     * @param $id
     * @param $value
     */
    public function Qtds($id_db_settings, $id_user, $id, $value){
        $this->Session                = $id_user;
        $this->id_db_settings         = $id_db_settings;
        $this->ID                     = $id;
        $this->Data['quantidade_tmp'] = $value;

        if($this->Data['quantidade_tmp'] < 1):
            $this->Error  = ["Ops: não é permitido adicionar quantidades negativas na mesa!", WS_ALERT];
            $this->Result = false;
        else:
            $this->UpdateQtds();
        endif;
    }

    private function UpdateQtds(){
        $Update = new Update();
        $Update->ExeUpdate(self::sd_billing_tmp, $this->Data, "WHERE id=:ipp AND id_db_settings=:i AND session_id=:ip", "ipp={$this->ID}&i={$this->id_db_settings}&ip={$this->Session}");

        if($Update->getResult()):
            $this->Error  = ["Item foi adicionado a factura com sucesso!", WS_ACCEPT];
            $this->Result = true;
        else:
            $this->Error  = ["Ops: aconteceu um erro inesperado ao adicionar o produto a factura (1)", WS_ERROR];
            $this->Result = false;
        endif;
    }


    public function Descs($id_db_settings, $id_user, $id, $value){
        $this->Session                = $id_user;
        $this->id_db_settings         = $id_db_settings;
        $this->ID                     = $id;
        $this->Data['desconto_tmp'] = $value;

        if($this->Data['desconto_tmp'] < 0):
            $this->Error  = ["Ops: não é permitido adicionar quantidades negativas na factura!", WS_ALERT];
            $this->Result = false;
        else:
            $Read = new Read();
            $Read->ExeRead(self::sd_billing_tmp, "WHERE id=:ipp AND id_db_settings=:i AND session_id=:ip", "ipp={$this->ID}&i={$this->id_db_settings}&ip={$this->Session}");

            if($Read->getResult()):
                $key = $Read->getResult()[0];

                if($this->Data['desconto_tmp'] == 100 || $this->Data['desconto_tmp'] == 99 || $this->Data['desconto_tmp'] >= $key['preco_tmp']):
                    $this->Error = ["Não foi possível efeturar o desconto desse valor!", WS_ALERT];
                    $this->Result = false;
                else:
                    /**if($this->Data['desconto_tmp'] > 100):
                    $this->Result = false;
                    $this->Error = ["Não é permitido fazer descontos acima dos 100%!", WS_ERROR];
                    else:**/
                    $this->UpdateDescs();
                    //endif;
                endif;
            endif;
        endif;
    }

    private function UpdateDescs(){
        $Update = new Update();
        $Update->ExeUpdate(self::sd_billing_tmp, $this->Data, "WHERE id=:ipp AND id_db_settings=:i AND session_id=:ip", "ipp={$this->ID}&i={$this->id_db_settings}&ip={$this->Session}");

        if($Update->getResult()):
            $this->Error  = ["Item foi adicionado a factura com sucesso!", WS_ACCEPT];
            $this->Result = true;
        else:
            $this->Error  = ["Ops: aconteceu um erro inesperado ao adicionar o produto a factura (2)", WS_ERROR];
            $this->Result = false;
        endif;
    }

    public function Pricings($id_db_settings, $id_user, $id, $value){
        $this->Session                = $id_user;
        $this->id_db_settings         = $id_db_settings;
        $this->ID                     = $id;
        $this->Data['preco_tmp'] = $value;

        if($this->Data['preco_tmp'] <= 0):
            $this->Error  = ["Ops: não é permitido adicionar quantidades negativas na factura!", WS_ALERT];
            $this->Result = false;
        else:
            $this->UpdatePricings();
        endif;
    }

    private function UpdatePricings(){
        $Update = new Update();
        $Update->ExeUpdate(self::sd_billing_tmp, $this->Data, "WHERE id=:ipp AND id_db_settings=:i AND session_id=:ip", "ipp={$this->ID}&i={$this->id_db_settings}&ip={$this->Session}");

        if($Update->getResult()):
            $this->Error  = ["Item foi adicionado a factura com sucesso!", WS_ACCEPT];
            $this->Result = true;
        else:
            $this->Error  = ["Ops: aconteceu um erro inesperado ao adicionar o produto a factura (3)", WS_ERROR];
            $this->Result = false;
        endif;
    }
    public function EliminarFactura($id){
        $this->ID = $id;

        $Read = new Read();
        $Read->ExeRead(self::sd_billing, "WHERE id=:i", "i={$this->ID}");

        if($Read->getResult()):
            $this->Data = $Read->getResult()[0];
            $this->GetEliminarFactura();
        else:
            $this->Error  = ["Ops: não encontramos nenhum documento com esse ID", WS_INFOR];
            $this->Result = false;
        endif;
    }

    private function GetEliminarFactura(){
        $Delete = new Delete();
        $Delete->ExeDelete(self::sd_billing_pmp, "WHERE id_db_settings=:i AND numero=:ip AND InvoiceType=:ipp", "i={$this->Data['id_db_settings']}&ip={$this->Data['numero']}&ipp={$this->Data['InvoiceType']}");

        if($Delete->getResult() || $Delete->getRowCount()):
            $this->Alert = $this->Data['InvoiceType']." ".$this->Data['mes'].$this->Data['Code'].$this->Data['ano']."/".$this->Data['numero'];

            $Read = new Read();
            $Read->ExeRead(self::sd_retification, "WHERE id_db_settings=:i AND Invoice=:ip", "i={$this->Data['id_db_settings']}&ip={$this->Alert}");

            if($Read->getResult()):
                $this->Info = $Read->getResult()[0];
                $Delete->ExeDelete(self::sd_retification_pmp, "WHERE id_db_settings=:i AND numero=:ip AND InvoiceType=:ipp", "i={$this->Info['id_db_settings']}&ip={$this->Info['numero']}&ipp={$this->Info['InvoiceType']}");

                if($Delete->getResult() || $Delete->getRowCount()):
                    $Delete->ExeDelete(self::sd_retification, "WHERE id_db_settings=:i AND Invoice=:ip", "i={$this->Data['id_db_settings']}&ip={$this->Alert}");

                    if($Delete->getResult() || $Delete->getRowCount()):
                        $Delete->ExeDelete(self::sd_billing, "WHERE id=:i", "i={$this->ID}");

                        if($Delete->getResult() || $Delete->getRowCount()):
                            $this->Error  = ["Documentos eliminado com sucesso!", WS_ACCEPT];
                            $this->Result = true;
                        else:
                            $this->Error  = ["Ops: não encontramos nenhuma linha do doc. nº <strong>{$this->Data['numero']}</strong>, da empresa: <strong>{$this->Data['settings_empresa']}</strong> (1)", WS_ALERT];
                            $this->Result = false;
                        endif;
                    else:
                        $this->Error  = ["Ops: não encontramos nenhuma linha do doc. nº <strong>{$this->Info['numero']}</strong>, da empresa: <strong>{$this->Info['settings_empresa']}</strong> (2)", WS_ALERT];
                        $this->Result = false;
                    endif;
                else:
                    $this->Error  = ["Ops: não encontramos nenhuma linha do doc. nº <strong>{$this->Info['numero']}</strong>, da empresa: <strong>{$this->Info['settings_empresa']}</strong> (3)", WS_ALERT];
                    $this->Result = false;
                endif;
            else:
                $Delete->ExeDelete(self::sd_billing, "WHERE id=:i AND id_db_settings=:ix", "i={$this->ID}&ix={$this->Data['id_db_settings']}");

                if($Delete->getResult() || $Delete->getRowCount()):
                    $this->Error  = ["Documentos eliminado com sucesso!", WS_ACCEPT];
                    $this->Result = true;
                else:
                    $this->Error  = ["Ops: não encontramos nenhuma linha do doc. nº <strong>{$this->Data['numero']}</strong>, da empresa: <strong>{$this->Data['settings_empresa']}</strong> (1x2)", WS_ALERT];
                    $this->Result = false;
                endif;
            endif;
        else:
            $Delete->ExeDelete(self::sd_billing, "WHERE id=:i AND id_db_settings=:ix", "i={$this->ID}&ix={$this->Data['id_db_settings']}");

            if($Delete->getResult() || $Delete->getRowCount()):
                $this->Error  = ["Documentos eliminado com sucesso!", WS_ACCEPT];
                $this->Result = true;
            else:
                $this->Error  = ["Ops: não encontramos nenhuma linha do doc. nº <strong>{$this->Data['numero']}</strong>, da empresa: <strong>{$this->Data['settings_empresa']}</strong> (1x1)", WS_ALERT];
                $this->Result = false;
            endif;
        endif;
    }
    public function Distancia($id_db_settings, $id_product, $qtdOne){
        $this->id_db_settings = $id_db_settings;
        $this->id_product     = $id_product;
        $this->qtdOne         = $qtdOne;

        $st = 1;

        $Read = new Read();
        $Read->ExeRead(self::cv_pedido_product, "WHERE id_db_settings=:ip AND id_product=:ipp AND status=:ipO", "ip={$this->id_db_settings}&ipp={$id_product}&ipO={$st}");

        if($Read->getResult()):
            $this->Error  = ["Ops: já foi feito um pedido formal do presente produto!", WS_INFOR];
            $this->Result = false;
        else:
            $this->Dattingts();
        endif;
    }

    private function Dattingts(){
        $this->Data['id_db_settings'] = $this->id_db_settings;
        $this->Data['id_product']     = $this->id_product;
        $this->Data['qtdOne']         = $this->qtdOne;
        $this->Data['data']           = date('d-m-Y H:i:s');
        $this->Data['status']         = 1;

        $Create = new Create();
        $Create->ExeCreate(self::cv_pedido_product, $this->Data);

        if($Create->getResult()):
            $this->Error  = ["Operação realizada com sucesso, foi feito um pedido formal no estoque!", WS_ACCEPT];
            $this->Result = true;
        else:
            $this->Error  = ["Ops: aconteceu um erro inesperado ao salvar a operação!", WS_ERROR];
            $this->Result = false;
        endif;
    }

    public function QtdsX1($id_db_settings, $id_user, $id, $value){
        $this->Session                = $id_user;
        $this->id_db_settings         = $id_db_settings;
        $this->ID                     = $id;
        $this->Data['quantidade_pmp'] = $value;

        if($this->Data['quantidade_pmp'] < 1):
            $this->Error  = ["Ops: não é permitido adicionar quantidades negativas na mesa!", WS_ALERT];
            $this->Result = false;
        else:
            $this->UpdateQtdsX1();
        endif;
    }

    private function UpdateQtdsX1(){
        $Update = new Update();
        $Update->ExeUpdate(self::sd_billing_pmp, $this->Data, "WHERE id=:ipp AND id_db_settings=:i", "ipp={$this->ID}&i={$this->id_db_settings}");

        if($Update->getResult()):
            $this->Error  = ["Item foi adicionado a factura com sucesso!", WS_ACCEPT];
            $this->Result = true;
        else:
            $this->Error  = ["Ops: aconteceu um erro inesperado ao adicionar o produto a factura (1)", WS_ERROR];
            $this->Result = false;
        endif;
    }

    public function DescsX1($id_db_settings, $id_user, $id, $value){
        $this->Session                = $id_user;
        $this->id_db_settings         = $id_db_settings;
        $this->ID                     = $id;
        $this->Data['desconto_pmp'] = $value;

        if($this->Data['desconto_pmp'] < 0):
            $this->Error  = ["Ops: não é permitido adicionar quantidades negativas na factura!", WS_ALERT];
            $this->Result = false;
        else:
            $Read = new Read();
            $Read->ExeRead(self::sd_billing_pmp, "WHERE id=:ipp AND id_db_settings=:i", "ipp={$this->ID}&i={$this->id_db_settings}");

            if($Read->getResult()):
                $key = $Read->getResult()[0];

                /**if($this->Data['desconto_pmp'] > 100):
                    $this->Result = false;
                    $this->Error = ["Não é permitido fazer descontos acima dos 100%!", WS_ERROR];
                else:**/
                    $this->UpdateDescsX1();
                //endif;
            endif;
        endif;
    }

    private function UpdateDescsX1(){
        $Update = new Update();
        $Update->ExeUpdate(self::sd_billing_pmp, $this->Data, "WHERE id=:ipp AND id_db_settings=:i", "ipp={$this->ID}&i={$this->id_db_settings}");

        if($Update->getResult()):
            $this->Error  = ["Item foi adicionado a factura com sucesso!", WS_ACCEPT];
            $this->Result = true;
        else:
            $this->Error  = ["Ops: aconteceu um erro inesperado ao adicionar o produto a factura (2)", WS_ERROR];
            $this->Result = false;
        endif;
    }

    public function PricingsX1($id_db_settings, $id_user, $id, $value){
        $this->Session                = $id_user;
        $this->id_db_settings         = $id_db_settings;
        $this->ID                     = $id;
        $this->Data['preco_pmp'] = $value;

        if($this->Data['preco_pmp'] <= 0):
            $this->Error  = ["Ops: não é permitido adicionar quantidades negativas na factura!", WS_ALERT];
            $this->Result = false;
        else:
            $this->UpdatePricingsX1();
        endif;
    }

    private function UpdatePricingsX1(){
        $Update = new Update();
        $Update->ExeUpdate(self::sd_billing_pmp, $this->Data, "WHERE id=:ipp AND id_db_settings=:i ", "ipp={$this->ID}&i={$this->id_db_settings}");

        if($Update->getResult()):
            $this->Error  = ["Item foi adicionado a factura com sucesso!", WS_ACCEPT];
            $this->Result = true;
        else:
            $this->Error  = ["Ops: aconteceu um erro inesperado ao adicionar o produto a factura (3)", WS_ERROR];
            $this->Result = false;
        endif;
    }

    public function RemovePSX($id_product, $id_db_settings, $InvoiceType, $Number, $id_mesa = null){
        $this->id_db_settings = $id_db_settings;
        $this->ID = $id_product;

        $Read = new Read();

        if(DBKwanzar::CheckConfig($id_db_settings)['JanuarioSakalumbu'] == null): $ttt = 2; else: $ttt = DBKwanzar::CheckConfig($id_db_settings)['JanuarioSakalumbu']; endif;

        if(!isset($mondy)): $mondy = date('m'); endif;
        if(!isset($year)):  $year  = date('Y'); endif;

        if($year <= "2020" && $mondy <= "07"):
            $InBody = '';
            $InHead = '';
        else:
            $InHead = " AND sd_billing_pmp.InvoiceType=:In";
            $InBody = "&In={$InvoiceType}";
        endif;

        $Read->ExeRead("sd_billing_pmp", "WHERE sd_billing_pmp.numero=:n AND sd_billing_pmp.status=:st AND sd_billing_pmp.id_db_settings=:i {$InHead} ", "i={$id_db_settings}&st={$ttt}&n={$Number}{$InBody}");

        if($Read->getRowCount() >= 2):
            $Read->ExeRead(self::sd_billing_pmp, "WHERE id=:p AND id_db_settings=:st ", "p={$this->ID}&st={$this->id_db_settings}");

            if($Read->getResult()):
                $this->DeleteX();
            else:
                $this->Error  = ["Ops: não encontramos a ação desejada!", WS_ALERT];
                $this->Result = false;
            endif;
        else:
            $this->Result = false;
            $this->Error = ["Não é possível excluír o último item disponível no Documento comercial!", WS_INFOR];
        endif;
    }

    private function DeleteX(){
        $Delete = new Delete();
        $Delete->ExeDelete(self::sd_billing_pmp, "WHERE id=:i", "i={$this->ID}");

        if($Delete->getResult() || $Delete->getRowCount()):
            $this->Result = true;
        else:
            $this->Error  = ["Ops: aconteceu um erro inesperado ao remover o <strong>Item</strong> da factura.", WS_ERROR];
            $this->Result = false;
        endif;
    }

    public function AddX(array $data, $id_db_settings, $id_users, $InvoiceType, $Number, $id_mesa = null){
        unset($this->id_db_settings);
        unset($this->id_mesa);
        if($id_mesa != null): $this->id_mesa = $id_mesa; endif;
        $this->Data = $data;
        $this->id_db_settings = $id_db_settings;
        $this->Session = $id_users;

        $this->InvoiceType = $InvoiceType;
        $this->Number = $Number;

        if($this->Data['quantidade'] <= 0 || $this->Data['desconto'] < 0 || $this->Data['preco'] <= 0):
            $this->Error  = ["Ops: não é permitido a inserção de válores negativos no documento de venda!", WS_ERROR];
            $this->Result = false;
        elseif($this->Data['desconto'] >= $this->Data['preco']):
            $this->Error  = ["Ops: não é permitido aplicar desconto acima de 100%", WS_ALERT];
            $this->Result = false;
        else:
            $Read = new Read();
            $Read->ExeRead(self::cv_product, "WHERE id=:i AND id_db_settings=:id", "i={$this->Data['id_product']}&id={$this->id_db_settings}");

            if($Read->getResult()):
                $this->Info = $Read->getResult()[0];
                $PP = $Read->getResult()[0];
                /**if(DBKwanzar::CheckSettingsII($this->id_db_settings)['atividade'] == 1 || DBKwanzar::CheckSettingsII($this->id_db_settings)['atividade'] == 4):
                    $qtd = $PP['quantidade'];
                else:
                    $qtd = $PP['gQtd'];
                endif;**/

                $qtd = $PP['quantidade'];

                if($PP['type'] != 'S'):
                    if(DBKwanzar::CheckConfig($this->id_db_settings) != false):
                        if($qtd <= DBKwanzar::CheckConfig($this->id_db_settings)['estoque_minimo'] && DBKwanzar::CheckConfig($this->id_db_settings)['HeliosPro'] == 2):
                            $this->Error  = ["Ops: quantidade em estoque está insuficiênte!", WS_INFOR];
                            $this->Result = false;
                        else:
                            $this->CheckProductX();
                        endif;
                    else:
                        $this->CheckProductX();
                    endif;
                else:
                    $this->CheckProductX();
                endif;
            else:
                $this->Error  = ["Ops: não encontramos nenhum produto!", WS_INFOR];
                $this->Result = false;
            endif;
        endif;
    }

    private function CheckProductX(){
        if(!isset($mondy)): $mondy = date('m'); endif;
        if(!isset($year)):  $year  = date('Y'); endif;
        if(DBKwanzar::CheckConfig($this->id_db_settings)['JanuarioSakalumbu'] == null): $ttt = 2; else: $ttt = DBKwanzar::CheckConfig($this->id_db_settings)['JanuarioSakalumbu']; endif;
        $suspenso = 0;

        $Read = new Read();
        if($year <= "2020" && $mondy <= "07"):
            $InBody = '';
            $InHead = '';
        else:
            $InHead = " AND sd_billing_pmp.InvoiceType=:In";
            $InBody = "&In={$this->InvoiceType}";
        endif;

        $whe =  "WHERE sd_billing_pmp.numero=:n AND sd_billing_pmp.status=:st AND sd_billing_pmp.id_db_settings=:i {$InHead} ";
        $fin =  "i={$this->id_db_settings}&st={$ttt}&n={$this->Number}{$InBody}";

        $Read->ExeRead("sd_billing_pmp", "WHERE sd_billing_pmp.numero=:n AND id_product=:imm AND sd_billing_pmp.status=:st AND sd_billing_pmp.id_db_settings=:i {$InHead} ", "i={$this->id_db_settings}&st={$ttt}&n={$this->Number}{$InBody}&imm={$this->Data['id_product']}");

        if($Read->getResult()):
            $this->Alert                    = $Read->getResult()[0];
            $this->Finish['quantidade_pmp'] = $this->Data['quantidade'] + $this->Alert['quantidade_pmp'];
            $this->Finish['desconto_pmp']   = $this->Data['desconto'];

            $Read->ExeRead(self::cv_product, "WHERE id=:i", "i={$this->Alert['id_product']}");
            if($Read->getResult()):
                $heliospro = $Read->getResult()[0];
                /**if(DBKwanzar::CheckSettingsII($this->id_db_settings)['atividade'] == 1 || DBKwanzar::CheckSettingsII($this->id_db_settings)['atividade'] == 4):
                    $qtd = $heliospro['quantidade'];
                else:
                    $qtd = $heliospro['gQtd'];
                endif;**/

                $qtd = $heliospro['quantidade'];

                if(DBKwanzar::CheckConfig($this->id_db_settings)['HeliosPro'] == 2 && $qtd <= DBKwanzar::CheckConfig($this->id_db_settings)['estoque_minimo'] || DBKwanzar::CheckConfig($this->id_db_settings)['HeliosPro'] == 2 && $qtd < $this->Finish['quantidade_tmp']):
                    $this->Error  = ["Ops: não existe quantatidade suficiente de <strong>{$heliospro['product']}</strong> no estoque!", WS_ALERT];
                    $this->Result = false;
                else:
                    $this->UpdatePOSX();
                endif;
            endif;
        else:
            $this->Finish['InvoiceType'] = $this->InvoiceType;
            $this->Finish['numero'] = $this->Number;
            $this->Finish['status'] = 3;

            $Read->ExeRead(self::sd_billing_pmp, $whe, $fin);

            if($Read->getResult()):
                $DB = new DBKwanzar();
                if($Read->getRowCount() >= 100 && DBKwanzar::CheckUsersConfig($this->id_db_settings, $this->Session)['Impression'] == 'A4' || $Read->getRowCount() >= 100 && $DB->CheckCpanelAndSettings($this->id_db_settings)['atividade'] != 2 ):
                    $this->Error  = ["Ops: atinguio o máximo de itens que pode ser incorporado na no documento A4", WS_INFOR];
                    $this->Result = false;
                else:
                    $Read->ExeRead(self::db_taxtable, "WHERE taxtableEntry=:id AND id_db_settings=:tc", "id={$this->Data['taxa']}&tc={$this->id_db_settings}");

                    if($Read->getResult()):
                        if($Read->getResult()[0]['taxPercentage'] < 0):
                            $this->Error  = ["Ops: não é permitido a inserção de válores negativos no documento de venda!", WS_ERROR];
                            $this->Result = false;
                        elseif($Read->getResult()[0]['taxPercentage'] > 100):
                            $this->Error  = ["Ops: não é permitido aplicar taxa de imposto acima de 100%", WS_ALERT];
                            $this->Result = false;
                        else:
                            // Taxas de imposto;
                            $this->Finish['taxa']               = $Read->getResult()[0]['taxPercentage'];
                            $this->Finish['TaxExemptionCode']   = $Read->getResult()[0]['TaxExemptionCode'];
                            $this->Finish['TaxExemptionReason'] = $Read->getResult()[0]['TaxExemptionReason'];
                            $this->Finish['taxType']            = $Read->getResult()[0]['taxType'];
                            $this->Finish['taxCode']            = $Read->getResult()[0]['taxCode'];
                            $this->Finish['TaxCountryRegion']   = $Read->getResult()[0]['TaxCountryRegion'];
                            $this->Finish['taxAmount']          = $Read->getResult()[0]['taxAmount'];
                            $this->Finish['description']        = $Read->getResult()[0]['description'];

                            // Informações do produto
                            $this->Finish['product_name']        = $this->Info['product'];
                            $this->Finish['product_list']        = $this->Info['Description'];
                            $this->Finish['product_uni']         = $this->Info['unidade_medida'];
                            $this->Finish['product_code']        = $this->Info['codigo'];
                            $this->Finish['product_type']        = $this->Info['type'];
                            $this->Finish['product_id_category'] = $this->Info['id_category'];
                            //$this->Finish['product_codigo_barras']= $this->Info['product_codigo_barras'];

                            // Informações da venda
                            $this->Finish['quantidade_pmp'] = $this->Data['quantidade'];
                            $this->Finish['preco_pmp']      = $this->Data['preco'];
                            $this->Finish['desconto_pmp']   = $this->Data['desconto'];

                            // ID'S
                            if(isset($this->id_mesa) && !empty($this->id_mesa) || isset($this->id_mesa) && $this->id_mesa != null):
                                $this->Finish['id_mesa']    = $this->id_mesa;
                            else:
                                $this->Finish['id_mesa']    = 0;
                            endif;

                            $this->Finish['id_db_settings'] = $this->id_db_settings;
                            $this->Finish['session_id']     = $this->Session;
                            $this->Finish['id_product']     = $this->Data['id_product'];

                            // Suspensão
                            $this->Finish['suspenso'] = 0;

                            $this->CreatePOSX();
                        endif;
                    else:
                        $this->Error  = ["Ops: não encontramos nenhuma taxa de imposto cadastrada no sistema!", WS_INFOR];
                        $this->Result = false;
                    endif;
                endif;
            else:
                $Read->ExeRead(self::db_taxtable, "WHERE taxtableEntry=:id AND id_db_settings=:tc", "id={$this->Data['taxa']}&tc={$this->id_db_settings}");

                if($Read->getResult()):
                    if($Read->getResult()[0]['taxPercentage'] < 0):
                        $this->Error  = ["Ops: não é permitido a inserção de válores negativos no documento de venda!", WS_ERROR];
                        $this->Result = false;
                    elseif($Read->getResult()[0]['taxPercentage'] > 100):
                        $this->Error  = ["Ops: não é permitido aplicar taxa de imposto acima de 100%", WS_ALERT];
                        $this->Result = false;
                    else:
                        // Taxas de imposto;
                        $this->Finish['taxa']               = $Read->getResult()[0]['taxPercentage'];
                        $this->Finish['TaxExemptionCode']   = $Read->getResult()[0]['TaxExemptionCode'];
                        $this->Finish['TaxExemptionReason'] = $Read->getResult()[0]['TaxExemptionReason'];
                        $this->Finish['taxType']            = $Read->getResult()[0]['taxType'];
                        $this->Finish['taxCode']            = $Read->getResult()[0]['taxCode'];
                        $this->Finish['TaxCountryRegion']   = $Read->getResult()[0]['TaxCountryRegion'];
                        $this->Finish['taxAmount']          = $Read->getResult()[0]['taxAmount'];
                        $this->Finish['description']        = $Read->getResult()[0]['description'];

                        // Informações do produto
                        $this->Finish['product_name']        = $this->Info['product'];
                        $this->Finish['product_list']        = $this->Info['Description'];
                        $this->Finish['product_uni']         = $this->Info['unidade_medida'];
                        $this->Finish['product_code']        = $this->Info['codigo'];
                        $this->Finish['product_type']        = $this->Info['type'];
                        $this->Finish['product_id_category'] = $this->Info['id_category'];
                        $this->Finish['product_codigo_barras']= $this->Info['product_codigo_barras'];

                        // Informações da venda
                        $this->Finish['quantidade_pmp'] = $this->Data['quantidade'];
                        $this->Finish['preco_pmp']      = $this->Data['preco'];
                        $this->Finish['desconto_pmp']   = $this->Data['desconto'];

                        // ID'S
                        if(isset($this->id_mesa) && !empty($this->id_mesa) || isset($this->id_mesa) && $this->id_mesa != null):
                            $this->Finish['id_mesa']    = $this->id_mesa;
                        else:
                            $this->Finish['id_mesa']    = 0;
                        endif;

                        $this->Finish['id_db_settings'] = $this->id_db_settings;
                        $this->Finish['session_id']     = $this->Session;
                        $this->Finish['id_product']     = $this->Data['id_product'];

                        // Suspensão
                        $this->Finish['suspenso'] = 0;

                        $this->CreatePOSX();
                    endif;
                else:
                    $this->Error  = ["Ops: não encontramos nenhuma taxa de imposto cadastrada no sistema!", WS_INFOR];
                    $this->Result = false;
                endif;
            endif;
        endif;
    }

    private function CreatePOSX(){
        $Create = new Create();
        $Create->ExeCreate(self::sd_billing_pmp, $this->Finish);

        if($Create->getResult()):
            $this->Result = true;
            $this->Error  = ["Produto adicionado a factura com sucesso!", WS_ACCEPT];
        else:
            $this->Error  = ["Ops: aconteceu um erro inesperado ao adicionar o <strong>Item</strong> ao carrinho!", WS_INFOR];
            $this->Result = false;
        endif;
    }

    private function UpdatePOSX(){
        if(!isset($mondy)): $mondy = date('m'); endif;
        if(!isset($year)):  $year  = date('Y'); endif;

        if(DBKwanzar::CheckConfig($this->id_db_settings)['JanuarioSakalumbu'] == null): $ttt = 2; else: $ttt = DBKwanzar::CheckConfig($this->id_db_settings)['JanuarioSakalumbu']; endif;

        if($year <= "2020" && $mondy <= "07"):
            $InBody = '';
            $InHead = '';
        else:
            $InHead = " AND sd_billing_pmp.InvoiceType=:In";
            $InBody = "&In={$this->InvoiceType}";
        endif;

        $Update = new Update();
        $Update->ExeUpdate("sd_billing_pmp", $this->Finish, "WHERE sd_billing_pmp.numero=:n AND id_product=:imm AND sd_billing_pmp.status=:st AND sd_billing_pmp.id_db_settings=:i {$InHead} ", "i={$this->id_db_settings}&st={$ttt}&n={$this->Number}{$InBody}&imm={$this->Data['id_product']}");

        if($Update->getResult()):
            $this->Result = true;
        else:
            $this->Error  = ["Ops: aconteceu um erro inesperado ao adicionar o <strong>Item</strong> ao carrinho!", WS_ALERT];
            $this->Result = false;
        endif;
    }
}
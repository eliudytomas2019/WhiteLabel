<?php
/**
 * Created by PhpStorm.
 * User: Kwanzar Soft
 * Date: 12/08/2020
 * Time: 14:58
 */

class PDV{
    private $Data, $Dater, $Infor, $id_db_settings, $id_user, $Error, $Result, $Info, $ID, $Visit, $Alert, $De, $Para, $id_mesa, $Finish, $Hash, $Number, $Session, $PC;

    const
        cv_customer     = "cv_customer",
        cv_product      = "cv_product",
        cv_mesas        = "cv_mesas",
        db_taxtable     = "db_taxtable",
        db_settings     = "db_settings",
        sd_billing      = "sd_billing",
        sd_billing_pmp  = "sd_billing_pmp",
        sd_billing_tmp  = "sd_billing_tmp",
        static_customer = "db_static_sales_customer",
        static_users    = "db_static_sales_db_users",
        static_product  = "db_static_db_settings_product";

    /**
     * @return mixed
     */
    public function getError() {return $this->Error;}
    public function getResult(){return $this->Result;}

    /**
     * @param array $data
     * @param $id_db_settings
     * @param $id_user
     * @param $id_mesa
     */
    public function FinishPDV(array $data, $id_db_settings, $id_user, $id_mesa){
        $this->id_db_settings = $id_db_settings;
        $this->Session        = $id_user;
        $this->id_mesa        = $id_mesa;
        $this->Data           = $data;

        if(!empty($this->Data['settings_desc_financ']) && $this->Data['settings_desc_financ'] < 0 || !empty($this->Data['settings_desc_financ']) && $this->Data['settings_desc_financ'] > 100):
            $this->Error  = ["Ops: os descontos Financeiros não podem ser menor que 0 e nem maior que 100. Atualize a página e tente novamente!", WS_ALERT];
            $this->Result = false;
        else:
            if(DBKwanzar::CheckConfig($this->id_db_settings) == false || DBKwanzar::CheckConfig($this->id_db_settings)['JanuarioSakalumbu'] == null): $ttt = 2; else: $ttt = DBKwanzar::CheckConfig($this->id_db_settings)['JanuarioSakalumbu']; endif;

            $sp = 0;
            $this->Info['status'] = $ttt;
            $this->Info['suspenso'] = $sp;

            $this->Number();
            if($this->Result):
                $this->Datting();
                if($this->Result):
                    $this->Info['id_mesa']              = $this->id_mesa;
                    $this->Info['id_db_settings']       = $this->id_db_settings;
                    $this->Info['method']               = $this->Data['method'];
                    $this->Info['numero']               = $this->Number;
                    $this->Info['session_id']           = $this->Session;
                    $this->Info['SourceBilling']        = "P";
                    $this->Info['TaxPointDate']         = $this->Data['TaxPointDate'];
                    $this->Info['id_garcom']            = $this->Data['id_garcom'];
                    $this->Info['settings_desc_financ'] = $this->Data['settings_desc_financ'];
                    $this->Info['pagou']                = $this->Data['pagou'];
                    $this->Info['troco']                = $this->Data['troco'];

                    $this->DataProduct();
                    if($this->Result):
                        $art['status'] = 1;
                        $this->ExeStatus($art, $this->id_mesa, $this->id_db_settings);
                        if($this->Result):
                            $this->CreateFact();
                        endif;
                    endif;
                endif;
            endif;
        endif;
    }

    private function Number(){
        if(DBKwanzar::CheckConfig($this->id_db_settings) == false || DBKwanzar::CheckConfig($this->id_db_settings)['JanuarioSakalumbu'] == null): $ttt = 2; else: $ttt = DBKwanzar::CheckConfig($this->id_db_settings)['JanuarioSakalumbu']; endif;

        $s = 0;
        $Y = date('Y');
        $Read = new Read();
        $Read->FullRead("SELECT *FROM sd_billing WHERE id_db_settings=:st AND InvoiceType=:iT AND  status=:ttt", "st={$this->id_db_settings}&iT={$this->Data['InvoiceType']}&ttt={$ttt}");

        if($Read->getResult()):
            $hora = explode(':', $Read->getResult()[0]['hora']);
            if(date('Y') < $Read->getResult()[0]['ano'] || (date('m') < $Read->getResult()[0]['mes'] ) || (date('m') < $Read->getResult()[0]['mes'] && date('d') < $Read->getResult()[0]['dia']) || (date('m') == $Read->getResult()[0]['mes'] && $Read->getResult()[0]['dia'] > date('d'))):
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
            $this->Info['settings_swift']       = $f['swift'];
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

        $Read->ExeRead(self::cv_customer, "WHERE id=:i AND id_db_settings=:st", "i={$this->Data['customer']}&st={$this->id_db_settings}");
        if($Read->getResult()):
            $a = $Read->getResult()[0];

            // Informações dos clientes;
            $this->Info['customer_name']     = $a['nome'];
            $this->Info['customer_endereco'] = $a['endereco'];
            $this->Info['customer_telefone'] = $a['telefone'];
            $this->Info['customer_nif']      = $a['nif'];
            $this->Info['id_customer']       = $this->Data['customer'];
        endif;


        $Read->FullRead("SELECT name FROM db_users WHERE id=:i ", "i={$this->Session}");
        if($Read->getResult()):
            $this->Info['username'] = $Read->getResult()[0]['name'];
        endif;

        $this->Info['box_in'] = 1;

        $this->Hash();

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

    private function Hash(){
        $this->Hash  = hash('sha512', $this->Number-time()+$this->Number*time()*$this->Number);
        $this->Hash .= hash('sha512', $this->Number+time()-$this->Number*time()*$this->Number);
        $this->Hash .= hash('sha512', $this->Number*time()*$this->Number-time()+$this->Number);

        $this->Info['hash'] = trim(substr( $this->Hash, 0, 171));
    }

    private function CreateFact(){
        $Create = new Create();
        $Create->ExeCreate("sd_billing", $this->Info);

        if($Create->getResult()):
            $this->PC     = $Create->getResult();
            //$this->Error  = [$Create->getResult()[0], WS_INFOR];
            $this->Result = true;
        else:
            $this->Error  = ["Ops: aconteceu um erro inesperado ao criar o documento!", WS_ERROR];
            $this->Result = false;
        endif;
    }

    private function DataProduct(){
        $Read = new Read();
        $Read->ExeRead(self::sd_billing_tmp, "WHERE id_db_settings=:i AND session_id=:ip AND id_mesa=:ippp ", "i={$this->id_db_settings}&ip={$this->Session}&ippp={$this->id_mesa}");

        if($Read->getResult()):
            foreach($Read->getResult() as $key):
                extract($key);
                $this->Infor = $key;
                $this->Dater['product_code'] = $this->Infor['product_list'];
                $Read->ExeRead(self::cv_product, "WHERE id=:id_product AND id_db_settings=:st", "id_product={$key['id_product']}&st={$this->id_db_settings}");

                if($Read->getResult()):
                    $this->Alert = $Read->getResult()[0];
                    if($this->Data['InvoiceType'] != 'PP'):
                        $functions = new Read();

                        $functions->ExeRead(self::static_product, "WHERE id_db_settings=:i AND id_cv_product=:ip", "i={$this->id_db_settings}&ip={$this->Alert['id']}");

                        if($functions->getResult()):
                            $cPlus = ["counting" => $functions->getResult()[0]['counting'] + $this->Infor['quantidade_tmp']];

                            $Update = new Update();
                            $Update->ExeUpdate(self::static_product, $cPlus, "WHERE id_db_settings=:i AND id_cv_product=:ip", "i={$this->id_db_settings}&ip={$this->Alert['id']}");

                            if(!$Update->getResult()):
                                $this->Error  = ["Ops: aconteceu um erro inesperado ao salvar a contagem de produtos/serviços;", WS_ERROR];
                                $this->Result = false;
                            endif;
                        else:
                            $sPlus = ["id_db_settings" => $this->id_db_settings, "id_cv_product" => $this->Alert['id'], "counting" => 1];

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
                        if(DBKwanzar::CheckSettingsII($this->id_db_settings)['atividade'] == 1):
                            $qtd = $Read->getResult()[0]['quantidade'];
                        else:
                            $qtd = $Read->getResult()[0]['gQtd'];
                        endif;

                        if(DBKwanzar::CheckConfig($this->id_db_settings) != false):
                            if(DBKwanzar::CheckConfig($this->id_db_settings)['HeliosPro'] != 1 && $qtd <= DBKwanzar::CheckConfig($this->id_db_settings)['estoque_minimo']):
                                $this->Error  = ["Ops: não existe quantatidade suficiente de <strong>{$Read->getResult()[0]['product']}</strong> no estoque!", WS_ALERT];
                                $this->Result = false;
                            elseif(DBKwanzar::CheckConfig($this->id_db_settings)['HeliosPro'] != 1):
                                $this->Desconto();
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
        if(DBKwanzar::CheckSettingsII($this->id_db_settings)['atividade'] == 1):
            $qtd = $this->Alert['quantidade'] - $this->Info['quantidade_tmp'];
            $Dados = ['quantidade' => $qtd];
        else:
            $qtd = $this->Alert['gQtd'] - $this->Info['quantidade_tmp'];
            $Dados = ['gQtd' => $qtd];
        endif;

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

        $this->Dater['id_db_settings']     = $this->id_db_settings;
        $this->Dater['id_product']         = $this->Infor['id_product'];
        $this->Dater['session_id']         = $this->Infor['session_id'];
        $this->Dater['id_mesa']            = $this->id_mesa;
        $this->Dater['quantidade_pmp']     = $this->Infor['quantidade_tmp'];
        $this->Dater['preco_pmp']          = $this->Infor['preco_tmp'];
        $this->Dater['desconto_pmp']       = $this->Infor['desconto_tmp'];
        $this->Dater['taxa']               = $this->Infor['taxa'];
        $this->Dater['TaxExemptionCode']   = $this->Infor['TaxExemptionCode'];
        $this->Dater['TaxExemptionReason'] = $this->Infor['TaxExemptionReason'];
        $this->Dater['taxType']            = $this->Infor['taxType'];
        $this->Dater['taxCode']            = $this->Infor['taxCode'];
        $this->Dater['TaxCountryRegion']   = $this->Infor['TaxCountryRegion'];
        $this->Dater['taxAmount']          = $this->Infor['taxAmount'];
        $this->Dater['description']        = $this->Infor['description'];
        $this->Dater['product_name']       = $this->Infor['product_name'];
        $this->Dater['product_code']       = $this->Infor['product_code'];
        $this->Dater['product_list']       = $this->Infor['product_list'];
        $this->Dater['product_uni']        = $this->Infor['product_uni'];
        $this->Dater['product_type']       = $this->Infor['product_type'];
        $this->Dater['product_id_category']= $this->Infor['product_id_category'];
        $this->Dater['InvoiceType']        = $this->Data['InvoiceType'];
        $this->Dater['suspenso']           = 0;
        $this->Dater['box_in']             = 1;
        $this->Dater['numero']             = $this->Number;
        $this->Dater['status']             = $ttt;
        $this->Dater['SourceBilling']      = "P";
        $this->Dater['id_garcom']          = $this->Data['id_garcom'];

        $Create = new Create();
        $Create->ExeCreate(self::sd_billing_pmp, $this->Dater);

        if($Create->getResult()):
            $this->Result = true;
        else:
            $this->Error  = ["Ops: aconteceu um erro inesperado ao adicionar o item <strong>{$this->Data['product_name']}</strong> na factura final!", WS_ALERT];
            $this->Result = false;
        endif;
    }

    private function DataFinish(){
        $Delete = new Delete();
        $Delete->ExeDelete(self::sd_billing_tmp, "WHERE id_db_settings=:i AND session_id=:ip AND id_mesa=:ippp ", "i={$this->id_db_settings}&ip={$this->Session}&ippp={$this->id_mesa}");

        if($Delete->getResult() || $Delete->getRowCount()):
            //$this->Error  = ["Venda finalizada com sucesso!", WS_ACCEPT];
            $this->Result = true;
        else:
            //$this->Error  = ["Ops: aconteceu um erro inesperado eliminar os arquivos temporario!", WS_ERROR];
            //$this->Result = false;
            $this->Result = true;
        endif;
    }

    // Cancelar os pedidos da mesa
    /**
     * @param $id_db_settings
     * @param $id_user
     * @param $id_mesa
     */
    public function CancelMesa($id_db_settings, $id_user, $id_mesa){
        $this->id_user                = $id_user;
        $this->id_db_settings         = $id_db_settings;
        $this->id_mesa                = $id_mesa;

        $Delete = new Delete();
        $Delete->ExeDelete(self::sd_billing_tmp, "WHERE id_db_settings=:i AND session_id=:ip AND id_mesa=:ippp ", "i={$this->id_db_settings}&ip={$this->id_user}&ippp={$this->id_mesa}");

        if($Delete->getResult() || $Delete->getRowCount()):
            $Read = New Read();
            $Read->ExeRead(self::sd_billing_tmp, "WHERE id_db_settings=:i AND session_id=:ip AND id_mesa=:ippp ", "i={$this->id_db_settings}&ip={$this->id_user}&ippp={$this->id_mesa}");

            if($Read->getResult()):
                $this->Error  = ["Item removido da mesa com sucesso!", WS_ACCEPT];
                $this->Result = true;
            else:
                $in['status'] = 1;
                $this->ExeStatus($in, $this->id_mesa, $this->id_db_settings);
                if($this->Result):
                    $this->Error  = ["Item removido da mesa com sucesso!", WS_ACCEPT];
                    $this->Result = true;
                else:
                    $this->Error  = ["Ops: aconteceu um erro inesperado ao atualizar o estado da mesa!", WS_ERROR];
                    $this->Result = false;
                endif;
            endif;
        else:
            $this->Error  = ["Ops: aconteu um erro inesperado ao remover o item da mesa!", WS_ERROR];
            $this->Result = false;
        endif;
    }

    // Remover itens da mesa
    /**
     * @param $id_db_settings
     * @param $id_user
     * @param $id_mesa
     * @param $id
     */
    public function RemoveMesa($id_db_settings, $id_user, $id_mesa, $id){
        $this->id_user                = $id_user;
        $this->id_db_settings         = $id_db_settings;
        $this->id_mesa                = $id_mesa;
        $this->ID                     = $id;

        $Delete = new Delete();
        $Delete->ExeDelete(self::sd_billing_tmp, "WHERE id=:i", "i={$this->ID}");

        if($Delete->getResult() || $Delete->getRowCount()):
            $Read = New Read();
            $Read->ExeRead(self::sd_billing_tmp, "WHERE id_db_settings=:i AND session_id=:ip AND id_mesa=:ippp ", "i={$this->id_db_settings}&ip={$this->id_user}&ippp={$this->id_mesa}");

            if($Read->getResult()):
                $this->Error  = ["Item removido da mesa com sucesso!", WS_ACCEPT];
                $this->Result = true;
            else:
                $in['status'] = 1;
                $this->ExeStatus($in, $this->id_mesa, $this->id_db_settings);
                if($this->Result):
                    $this->Error  = ["Item removido da mesa com sucesso!", WS_ACCEPT];
                    $this->Result = true;
                else:
                    $this->Error  = ["Ops: aconteceu um erro inesperado ao atualizar o estado da mesa!", WS_ERROR];
                    $this->Result = false;
                endif;
            endif;
        else:
            $this->Error  = ["Ops: aconteu um erro inesperado ao remover o item da mesa!", WS_ERROR];
            $this->Result = false;
        endif;
    }

    // Atualizar a quantidade dos produtos
    /**
     * @param $id_db_settings
     * @param $id_user
     * @param $id_mesa
     * @param $id
     * @param $value
     */
    public function Qtds($id_db_settings, $id_user, $id_mesa, $id, $value){
        $this->id_user                = $id_user;
        $this->id_db_settings         = $id_db_settings;
        $this->id_mesa                = $id_mesa;
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
        $Update->ExeUpdate(self::sd_billing_tmp, $this->Data, "WHERE id=:ipp AND id_db_settings=:i AND session_id=:ip  AND id_mesa=:ippp ", "ipp={$this->ID}&i={$this->id_db_settings}&ip={$this->id_user}&ippp={$this->id_mesa}");

        if($Update->getResult()):
            $this->Error  = ["Item foi adicionado a mesa com sucesso!", WS_ACCEPT];
            $this->Result = true;
        else:
            $this->Error  = ["Ops: aconteceu um erro inesperado ao adicionar o produto na mesa (1)", WS_ERROR];
            $this->Result = false;
        endif;
    }

    // Checar produtos  quantidades
    public function CheckProductANDInfo($id_db_settings, $id){
        $preco = 0;

        $Read = new Read();
        $Read->ExeRead(self::cv_product, "WHERE id=:i AND id_db_settings=:ip", "i={$id}&ip={$id_db_settings}");

        if($Read->getResult()):
            $key = $Read->getResult()[0];

            if($Read->getResult()[0]['type'] != 'P'):
                $this->Info   = $Read->getResult()[0];

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

                $this->Info['preco'] = $preco;

                $this->Result = true;
            else:
                if(DBKwanzar::CheckConfig($this->id_db_settings)['HeliosPro'] == 1):
                    $this->Info   = $Read->getResult()[0];

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

                    $this->Info['preco'] = $preco;

                    $this->Result = true;
                else:
                    $DB = new DBKwanzar();
                    if($DB->CheckCpanelAndSettings($id_db_settings)['atividade'] != 1):
                        if($key['unidades'] > DBKwanzar::CheckConfig($this->id_db_settings)['estoque_minimo']):
                            $this->Info   = $Read->getResult()[0];

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

                            $this->Info['preco'] = $preco;

                            $this->Result = true;
                        else:
                            $this->Error  = ["Ops: não existe quantidade suficiente de <strong>{$key['product']}</strong>", WS_ALERT];
                            $this->Result = false;
                        endif;
                    else:
                        if($key['quantidade'] > DBKwanzar::CheckConfig($this->id_db_settings)['estoque_minimo']):
                            $this->Info   = $Read->getResult()[0];

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

                            $this->Info['preco'] = $preco;

                            $this->Result = true;
                        else:
                            $this->Error  = ["Ops: não existe quantidade suficiente de <strong>{$key['product']}</strong>", WS_ALERT];
                            $this->Result = false;
                        endif;
                    endif;
                endif;
            endif;
        else:
            $this->Error  = ["Ops: não encontramos o produto selecionado", WS_INFOR];
            $this->Result = false;
        endif;
    }

    // TaxTable
    /**
     * @param $id
     * @param $id_db_settings
     */
    public function CheckTaxTable($id, $id_db_settings){
        $Read = new Read();
        $Read->ExeRead(self::db_taxtable, "WHERE taxtableEntry=:i AND id_db_settings=:ip", "i={$id}&ip={$id_db_settings}");

        if($Read->getResult()):
            if($Read->getResult()[0]['taxPercentage'] < 0):
                $this->Error  = ["Ops: não é permitido a inserção de válores negativos no documento de venda!", WS_ERROR];
                $this->Result = false;
            elseif($Read->getResult()[0]['taxPercentage'] > 100):
                $this->Error  = ["Ops: não é permitido aplicar taxa de imposto acima de 100%", WS_ALERT];
                $this->Result = false;
            else:
                $this->Visit  = $Read->getResult()[0];
                $this->Result = true;
            endif;
        else:
            $this->Error  = ["Ops: não encontramos nenhuma taxa de impostos!", WS_INFOR];
            $this->Result = false;
        endif;
    }

    // Adicionar itens a mesa
    /**
     * @param $id_db_settings
     * @param $id_user
     * @param $id_mesa
     * @param $id
     */
    public function AddMesa($id_db_settings, $id_user, $id_mesa, $id){
        $this->id_user        = $id_user;
        $this->id_db_settings = $id_db_settings;
        $this->id_mesa        = $id_mesa;
        $this->ID             = $id;

        $Read = New Read();
        $Read->ExeRead(self::sd_billing_tmp, "WHERE id_db_settings=:i AND session_id=:ip AND id_product=:ipp AND id_mesa=:ippp ", "i={$this->id_db_settings}&ip={$this->id_user}&ipp={$this->ID}&ippp={$this->id_mesa}");

        if($Read->getResult()):
            $this->Alert  = $Read->getResult()[0];
            $this->Finish['quantidade_tmp'] = $Read->getResult()[0]['quantidade_tmp'] + 1;
            $this->UpdatePDV();
        else:
            $this->CheckProductANDInfo($this->id_db_settings, $this->ID);
            if($this->Result):
                $this->CheckTaxTable($this->Info['id_iva'], $this->id_db_settings);
                if($this->Result):
                    $this->CreateAddMesa();
                else:
                    $this->Error  = ["Ops: não encontramos nenhuma taxa de imposto (2)", WS_ERROR];
                    $this->Result = false;
                endif;
            else:
                $this->Error  = ["Ops: não encontramos nenhum produto (1)", WS_ERROR];
                $this->Result = false;
            endif;
        endif;
    }

    private function CreateAddMesa(){
        // Taxas de imposto;
        $this->Finish['taxa']               = $this->Visit['taxPercentage'];
        $this->Finish['TaxExemptionCode']   = $this->Visit['TaxExemptionCode'];
        $this->Finish['TaxExemptionReason'] = $this->Visit['TaxExemptionReason'];
        $this->Finish['taxType']            = $this->Visit['taxType'];
        $this->Finish['taxCode']            = $this->Visit['taxCode'];
        $this->Finish['TaxCountryRegion']   = $this->Visit['TaxCountryRegion'];
        $this->Finish['taxAmount']          = $this->Visit['taxAmount'];
        $this->Finish['description']        = $this->Visit['description'];

        // Informações do produto
        $this->Finish['product_name']        = $this->Info['product'];
        $this->Finish['product_list']        = $this->Info['Description'];
        $this->Finish['product_uni']         = $this->Info['unidade_medida'];
        $this->Finish['product_code']        = $this->Info['codigo'];
        $this->Finish['product_type']        = $this->Info['type'];
        $this->Finish['product_id_category'] = $this->Info['id_category'];

        // Informações da venda
        $this->Finish['quantidade_tmp'] = 1;
        $this->Finish['preco_tmp']      = $this->Info['preco'];
        $this->Finish['desconto_tmp']   = "0";

        $this->Finish['id_mesa']        = $this->id_mesa;
        $this->Finish['id_db_settings'] = $this->id_db_settings;
        $this->Finish['session_id']     = $this->id_user;
        $this->Finish['id_product']     = $this->ID;

        // Suspensão
        $this->Finish['suspenso'] = 0;

        $this->CreatePDV();
    }

    private function CreatePDV(){
        $Create = new Create();
        $Create->ExeCreate(self::sd_billing_tmp, $this->Finish);

        if($Create->getResult()):
            $in['status'] = 2;
            $this->ExeStatus($in, $this->id_mesa, $this->id_db_settings);
            if($this->Result):
                $this->Error  = ["Item: <strong>{$this->Finish['product_name']}</strong> foi adicionado a mesa com sucesso!", WS_ACCEPT];
                $this->Result = true;
            else:
                $this->Error  = ["Ops: aconteceu um erro inesperado ao atualizar o estado da mesa!", WS_ERROR];
                $this->Result = false;
            endif;
        else:
            $this->Error  = ["Ops: aconteceu um erro inesperado ao adicionar o item: <strong>{$this->Finish['product_name']}</strong> a mesa!", WS_ERROR];
            $this->Result = false;
        endif;
    }

    private function UpdatePDV(){
        $Update = new Update();
        $Update->ExeUpdate(self::sd_billing_tmp, $this->Finish, "WHERE id_db_settings=:i AND session_id=:ip AND id_product=:ipp AND id_mesa=:ippp ", "i={$this->id_db_settings}&ip={$this->id_user}&ipp={$this->ID}&ippp={$this->id_mesa}");

        if($Update->getResult()):
            $in['status'] = 2;
            $this->ExeStatus($in, $this->id_mesa, $this->id_db_settings);
            if($this->Result):
                $this->Error  = ["Item: <strong>{$this->Alert['product_name']}</strong> foi adicionado a mesa com sucesso!", WS_ACCEPT];
                $this->Result = true;
            else:
                $this->Error  = ["Ops: aconteceu um erro inesperado ao atualizar o estado da mesa!", WS_ERROR];
                $this->Result = false;
            endif;
        else:
            $this->Error  = ["Ops: aconteceu um erro inesperado ao adicionar o produto na mesa (1)", WS_ERROR];
            $this->Result = false;
        endif;
    }


    // Consultar Se a mesa existe
    /**
     * @param $id
     * @return bool
     */
    public function Consult($id, $id_db_settings){
        $Read = new Read();
        $Read->ExeRead(self::cv_mesas, "WHERE id=:i AND id_db_settings=:ip", "i={$id}&ip={$id_db_settings}");

        if($Read->getResult()):
            $this->Result = true;
            return $Read->getResult()[0];
        else:
            $this->Result = false;
            return false;
        endif;
    }

    // Mudar o estado da mesa automaticamente

    /**
     * @param $data
     * @param $id
     * @param $id_db_settings
     */
    private function ExeStatus($data, $id, $id_db_settings){
        $Update = new Update();
        $Update->ExeUpdate(self::cv_mesas, $data, "WHERE id=:i AND id_db_settings=:ip", "i={$id}&ip={$id_db_settings}");

        if($Update->getResult()):
            $this->Result = true;
        else:
            $this->Result = false;
        endif;
    }

    // Transfêrencia no geral

    /**
     * @param $de
     * @param $para
     * @param $id
     */
    public function Transfer($de, $para, $id){
        $this->De             = $de;
        $this->Para           = $para;
        $this->id_db_settings = $id;

        $this->Consult($this->De, $this->id_db_settings);
        if($this->Result):
            $this->Consult($this->Para, $this->id_db_settings);
            if($this->Result):
                $this->ExeTransfer();
            else:
                $this->Error  = ["Ops: não encontramos a mesa de entrada!", WS_ALERT];
                $this->Result = false;
            endif;
        else:
            $this->Error  = ["Ops: não encontramos a mesa de saída!", WS_ALERT];
            $this->Result = false;
        endif;
    }

    private function ExeTransfer(){
        $this->Data['id_mesa'] = $this->Para;

        $Update = new Update();
        $Update->ExeUpdate(self::sd_billing_tmp, $this->Data, "WHERE id_db_settings=:i AND id_mesa=:ip", "i={$this->id_db_settings}&ip={$this->De}");

        if($Update->getResult()):
            $this->Info['status'] = 1;
            $this->ExeStatus($this->Info, $this->De, $this->id_db_settings);

            if($this->Result):
                $this->Alert['status'] = 2;
                $this->ExeStatus($this->Alert, $this->Para, $this->id_db_settings);

                if($this->Result):
                    $this->Error  = ["Transferencia efectuda com sucesso!", WS_ACCEPT];
                    $this->Result = true;
                else:
                    $this->Error  = ["Ops: aconteceu um erro ao atualizar a mesa (2)", WS_ALERT];
                    $this->Result = false;
                endif;
            else:
                $this->Error  = ["Ops: aconteceu um erro ao atualizar a mesa (1)", WS_ALERT];
                $this->Result = false;
            endif;
        else:
            $this->Error  = ["Ops: aconteceu um erro inesperado ao efectuar a transferencia de uma mesa para outra!", WS_ERROR];
            $this->Result = false;
        endif;
    }

    // Opções de mesa

    /**
     * @param $idMesa
     * @param $optionMesa
     * @param $id_db_settings
     */
    public function ExeOptions($idMesa, $optionMesa, $id_db_settings){
        $this->id_db_settings = $id_db_settings;
        $this->Info           = $idMesa;
        $this->Data['status'] = $optionMesa;


        $Read = new Read();
        $Read->ExeRead(self::cv_mesas, "WHERE id=:i AND id_db_settings=:ip", "i={$this->Info}&ip={$this->id_db_settings}");

        if($Read->getResult()):
            $this->Alert = $Read->getResult()[0];
            $this->UpdateMesa();
        else:
            $this->Error  = ["Ops: não encontramos nehuma mesa!", WS_ALERT];
        endif;
    }

    private function UpdateMesa(){
        $Update = new Update();
        $Update->ExeUpdate(self::cv_mesas, $this->Data, "WHERE id=:i AND id_db_settings=:ip", "i={$this->Info}&ip={$this->id_db_settings}");

        if($Update->getResult()):
            $Data = ["", "Livre", "Em uso", "Reservada", "Em manutenção"];
            $this->Error  = ["Operação realizada com sucesso, a <strong>{$this->Alert['name']}</strong>, está: <strong>{$Data[$this->Data['status']]}</strong>", WS_ACCEPT];
            $this->Result = true;
        else:
            $this->Error  = ["Ops: aconteceu um erro inesperado ao atualizar a mesa!", WS_ERROR];
            $this->Result = false;
        endif;
    }

    /**
     * @param mixed $Data
     * @return PDV
     */
    public function setData($Data)
    {
        $this->Data = $Data;
        return $this;
    }
}
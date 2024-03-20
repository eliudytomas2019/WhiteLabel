<?php
class Saft{
    private $Xml, $Dados, $dateI, $dateF, $File, $Error, $ID;

    const
        billing = "sd_billing",
        billing_pmp = "sd_billing_pmp",
        retification = "sd_retification",
        retifiacation_pmp = "sd_retification_pmp",
        count = "count",
        product = "cv_product",
        purchase = "cv_purchase",
        customer = "cv_customer",
        category = "cv_category",
        supplier = "cv_supplier",
        settings = "db_settings",
        taxtable = "db_taxtable";

    public function getError(){
        return $this->Error;
    }

    public function XML($inicio, $fim, $id){
        $this->ID = $id;
        // FORMATAÇÃO DA DATA
        $date = explode("-", $inicio);
        $this->dateI = $date;
        $puta = $date[2]."-".$date[1]."-".$date[0];

        $dat = explode("-", $fim);
        $this->dateF = $dat;
        $porra = $dat[2]."-".$dat[1]."-".$dat[0];

        $Read = new Read();
        $Read->ExeRead(self::settings, "WHERE id=:i", "i={$this->ID}");
        if($Read->getResult()):
            $this->Dados = $Read->getResult()[0];
        endif;

        $time = time();
        $this->File = "SAF-T_".time().".xml";
        $this->Xml  = "<?xml version='1.0' encoding='UTF-8' ?>";
        $this->Xml .= '<AuditFile>';
            // 1. Header

            if(empty($this->Dados['city']) || $this->Dados['city'] == " "): $this->Dados['city'] = "Luanda"; endif;
            if(empty($this->Dados['addressDetail']) || $this->Dados['addressDetail'] = " "): $this->Dados['addressDetail'] = "Luanda - Angola"; endif;
            if(empty($this->Dados['BuildingNumber']) || $this->Dados['BuildingNumber'] == " "): $this->Dados['BuildingNumber'] = 1; endif;

            if(empty($this->Dados['BuildingNumber'])): $this->Dados['BuildingNumber'] = 12; endif;
            $this->Xml .= '<Header>';
                $this->Xml .= '<AuditFileVersion>1.00_01</AuditFileVersion>';
                $this->Xml .= '<CompanyID>'.$this->Dados['id'].'</CompanyID>';
                $this->Xml .= '<TaxRegistrationNumber>'.$this->Dados['nif'].'</TaxRegistrationNumber>';
                $this->Xml .= '<TaxAccountingBasis>F</TaxAccountingBasis>';
                $this->Xml .= '<CompanyName>'.$this->Dados['empresa'].'</CompanyName>';
                $this->Xml .= '<BusinessName>'.$this->Dados['businessName'].'</BusinessName>';
                $this->Xml .= '<CompanyAddress>';
                    $this->Xml .= '<BuildingNumber>'.Check::Words($this->Dados['BuildingNumber'], 11).'</BuildingNumber>';
                    $this->Xml .= '<StreetName>'.$this->Dados['endereco'].'</StreetName>';
                    $this->Xml .= '<AddressDetail>'.$this->Dados['addressDetail'].'</AddressDetail>';
                    $this->Xml .= '<City>'.Check::Words($this->Dados['city'], 25).'</City>';
                    $this->Xml .= '<Country>AO</Country>';
                $this->Xml .= '</CompanyAddress>';
                $this->Xml .= '<FiscalYear>'.$this->dateI[0].'</FiscalYear>';
                $this->Xml .= '<StartDate>'.$inicio.'</StartDate>';
                $this->Xml .= '<EndDate>'.$fim.'</EndDate>';
                $this->Xml .= '<CurrencyCode>AOA</CurrencyCode>';
                $d = $this->dateI[2] - 1;
                $this->Xml .= '<DateCreated>'.date('Y-m-d').'</DateCreated>';
                $this->Xml .= '<TaxEntity>'.$this->Dados['taxEntity'].'</TaxEntity>';

                $this->Xml .= '<ProductCompanyTaxID>5000161012</ProductCompanyTaxID>';
                $this->Xml .= '<SoftwareValidationNumber>244/AGT/2019</SoftwareValidationNumber>';
                $this->Xml .= '<ProductID>Kwanzar - Software de gestão comercial/HELIOS PRO PRESTACAO DE SERVICOS (SU), LDA.</ProductID>';
                $this->Xml .= '<ProductVersion>1.1</ProductVersion>';
                $this->Xml .= '<Telephone>949482020</Telephone>';
                $this->Xml .= '<Email>teliudy28@gmail.com</Email>';
            $this->Xml .="</Header>";

            // 2. Tabelas Mastres
            $this->Xml .= '<MasterFiles>';
                // 2.2 Clientes
                $Read->ExeRead(self::customer, "WHERE id_db_settings=:i", "i={$this->ID}");
                if($Read->getResult()):
                    foreach ($Read->getResult() as $key):
                        //extract($key);

                        if(empty($key['addressDetail']) || $key['addressDetail'] == " "): $key['addressDetail'] = "Luanda - Angola"; endif;

                        $this->Xml .= '<Customer>';
                            $this->Xml .= '<CustomerID>'.$key['id'].'</CustomerID>';
                            $this->Xml .= '<AccountID>'.$key['id'].'</AccountID>';
                            $this->Xml .= '<CustomerTaxID>'.$key['nif'].'</CustomerTaxID>';
                            $this->Xml .= '<CompanyName>'.Check::CheckNamePro($key['nome']).'</CompanyName>';
                            $this->Xml .= '<BillingAddress>';
                                $this->Xml .= '<AddressDetail>'.Check::CheckNamePro($key['addressDetail']).'</AddressDetail>';
                                $this->Xml .= '<City>'.$key['city'].'</City>';
                                $this->Xml .= '<Country>'.$key['country'].'</Country>';
                            $this->Xml .= '</BillingAddress>';
                            $this->Xml .= '<SelfBillingIndicator>0</SelfBillingIndicator>';
                        $this->Xml .= '</Customer>';
                    endforeach;
                endif;

                //2.4 Produtos/Serviços
                $Read->ExeRead(self::product, "WHERE id_db_settings=:i", "i={$this->ID}");
                if($Read->getResult()):
                    foreach ($Read->getResult() as $key):
                        //extract($key);
                        $this->Xml .= '<Product>';
                            $this->Xml .= '<ProductType>'.$key['type'].'</ProductType>';
                            $this->Xml .= '<ProductCode>'.$key['id'].'</ProductCode>';
                            $this->Xml .= '<ProductDescription>'.Check::CheckNamePro($key['product']).'</ProductDescription>';
                            $this->Xml .= '<ProductNumberCode>'.Check::CheckNamePro($key['codigo']).$key['id'].'</ProductNumberCode>';
                        $this->Xml .= '</Product>';
                    endforeach;
                endif;

                // 2.5 Impostos
                $this->Xml .= '<TaxTable>';
                    $Read->ExeRead(self::taxtable, "WHERE id_db_settings=:i", "i={$this->ID}");
                    if($Read->getResult()):
                        foreach ($Read->getResult() as $key):
                            extract($key);
                            $this->Xml .= '<TaxTableEntry>';
                                $this->Xml .= '<TaxType>'.$key['taxType'].'</TaxType>';
                                $this->Xml .= '<TaxCountryRegion>'.$key['TaxCountryRegion'].'</TaxCountryRegion>';
                                $this->Xml .= '<TaxCode>'.$key['taxCode'].'</TaxCode>';
                                $this->Xml .= '<Description>'.$key['description'].'</Description>';
                                $this->Xml .= '<TaxPercentage>'.$key['taxPercentage'].'</TaxPercentage>';
                            $this->Xml .= '</TaxTableEntry>';
                        endforeach;
                    endif;
                $this->Xml .= '</TaxTable>';
            $this->Xml .= '</MasterFiles>';

            $this->Xml .='<SourceDocuments>';
                $this->Xml .='<SalesInvoices>';

                    $xline = null;
                    $n1 = "sd_billing";
                    $n2 = "sd_billing_pmp";
                    $n3 = "sd_retification";
                    $n4 = "sd_retification_pmp";
                    $sL = 3;
                    $Vp = 0;
                    $line = 0;

                    $hp = 0;
                    $Tdoc1 = 0;
                    $Tdoc2 = 0;
                    $Tdoc3 = 0;

                    $read = new Read();

                    // CONTAGEM DOS DOCUMENTOS
                    $read->ExeRead("{$n1}", "WHERE ({$n1}.id_db_settings=:i) AND ({$n1}.dia BETWEEN {$this->dateI[2]} AND {$this->dateF[2]}) AND ({$n1}.mes BETWEEN {$this->dateI[1]} AND {$this->dateF[1]}) AND ({$n1}.ano BETWEEN {$this->dateI[0]} AND {$this->dateF[0]}) AND ({$n1}.InvoiceType!='PP') AND ({$n1}.status=:ss) AND ({$n1}.suspenso=:Vp)", "i={$this->ID}&ss={$sL}&Vp={$Vp}");
                    if($read->getResult()):
                        $hp += $read->getRowCount();
                    endif;

                    // REGRAR DOCUMENTO QUE SERÁ USADO NA FACTURA
                    $read->ExeRead("{$n1}", "WHERE ({$n1}.id_db_settings=:i) AND ({$n1}.dia BETWEEN {$this->dateI[2]} AND {$this->dateF[2]}) AND ({$n1}.mes BETWEEN {$this->dateI[1]} AND {$this->dateF[1]}) AND ({$n1}.ano BETWEEN {$this->dateI[0]} AND {$this->dateF[0]}) AND ({$n1}.InvoiceType!='PP') AND ({$n1}.status=:ss) AND ({$n1}.suspenso=:Vp) ORDER BY {$n1}.TaxPointDate ASC", "i={$this->ID}&ss={$sL}&Vp={$Vp}");
                    $Docs = $read->getResult();

                    // CONTAR OS PRODUTOS PARA GERAR IMPOSTOS
                    $read->ExeRead("{$n1}, {$n2}", "WHERE ({$n1}.id_db_settings=:i) AND ({$n1}.dia BETWEEN {$this->dateI[2]} AND {$this->dateF[2]}) AND ({$n1}.mes BETWEEN {$this->dateI[1]} AND {$this->dateF[1]}) AND ({$n1}.ano BETWEEN {$this->dateI[0]} AND {$this->dateF[0]}) AND ({$n1}.InvoiceType!='PP') AND {$n2}.InvoiceType={$n1}.InvoiceType AND ({$n1}.status=:ss) AND ({$n1}.suspenso=:Vp) AND  ({$n2}.id_db_settings=:i) AND ({$n2}.numero={$n1}.numero) AND ({$n2}.status=:ss) ORDER BY {$n1}.TaxPointDate ASC ", "i={$this->ID}&ss={$sL}&Vp={$Vp}");

                    $xXx = null;

                    if($read->getResult()):
                        foreach($read->getResult() as $key):
                            extract($key);
                            $value = ($key['quantidade_pmp'] * $key['preco_pmp']);
                            if($key['desconto_pmp'] >= 100):
                                $desconto = $key['desconto_pmp'];
                            else:
                                $desconto = ($value * $key['desconto_pmp']) / 100;
                            endif;
                            //$desconto = ($value * $key['desconto_pmp']) / 100;
                            $imposto  = ($value * $key['taxa']) / 100;
                            $Tdoc1 += ($value);
                        endforeach;
                    endif;

                    $john = $Tdoc1;

                    $this->Xml .= '<NumberOfEntries>'.$hp.'</NumberOfEntries>';
                    $this->Xml .= '<TotalDebit>'.$Tdoc3.'</TotalDebit>';
                    $this->Xml .= '<TotalCredit>'.$john.'</TotalCredit>';

                    if($Docs):
                        foreach ($Docs as $key):
                            $xXx += 1;
                            //extract($key);

                            //$a = str_split($key['hash']);
                            $this->Xml .= '<Invoice>';
                            $line += 1;
                            $this->Xml .= '<InvoiceNo>'.$key['InvoiceType']." ".$key['mes'].$key['Code'].$key['ano']."/".$xXx.'</InvoiceNo>';
                            $this->Xml .= '<DocumentStatus>';
                                $this->Xml .= '<InvoiceStatus>N</InvoiceStatus>';
                                $this->Xml .= '<InvoiceStatusDate>'.$key['ano'].'-'.$key['mes'].'-'.$key['dia'].'T'.$key['hora'].'</InvoiceStatusDate>';
                                $this->Xml .= '<SourceID>'.$key['session_id'].'</SourceID>';
                                $this->Xml .= '<SourceBilling>'.$key['SourceBilling'].'</SourceBilling>';
                            $this->Xml .= '</DocumentStatus>';

                            //$a = str_split($key['hash']);

                            //$this->Xml .= '<Hash>'.$a[0].$a[11].$a[21].$a[31].'</Hash>';
                            $this->Xml .= '<Hash>'.htmlspecialchars(strip_tags(trim($key['hash'], "\n"))).'</Hash>';
                            $this->Xml .= '<HashControl>0</HashControl>';
                            $this->Xml .= '<InvoiceDate>'.$key['ano'].'-'.$key['mes'].'-'.$key['dia'].'</InvoiceDate>';
                            $this->Xml .= '<InvoiceType>'.$key['InvoiceType'].'</InvoiceType>';

                            $this->Xml .= '<SpecialRegimes>';
                                $this->Xml .= '<SelfBillingIndicator>1</SelfBillingIndicator>';
                                $this->Xml .= '<CashVATSchemeIndicator>1</CashVATSchemeIndicator>';
                                $this->Xml .= '<ThirdPartiesBillingIndicator>0</ThirdPartiesBillingIndicator>';
                            $this->Xml .= '</SpecialRegimes>';

                            $this->Xml .= '<SourceID>'.$key['session_id'].'</SourceID>';
                            $this->Xml .= '<SystemEntryDate>'.$key['ano'].'-'.$key['mes'].'-'.$key['dia'].'T'.$key['hora'].'</SystemEntryDate>';
                            $this->Xml .= '<CustomerID>'.$key['id_customer'].'</CustomerID>';

                            $iV = 0;
                            $total_valor = 0;
                            $tota_quantidade = 0;
                            $total_iva = 0;
                            $total_desconto = 0;
                            $total_preco = 0;
                            $total_val = 0;
                            $tt = 0;

                            $nLine = 0;

                            $Read->ExeRead("{$n2}", "WHERE id_db_settings=:i AND numero=:idd AND status={$key['status']} AND InvoiceType=:iv", "i={$this->ID}&idd={$key['numero']}&iv={$key['InvoiceType']}");
                            if($Read->getResult()):
                                foreach ($Read->getResult() as $ke):
                                    extract($ke);
                                    $nLine += 1;
                                    $valor = $ke['quantidade_pmp'] * $ke['preco_pmp'];
                                    $iva = ($valor * $ke['taxa']) / 100;
                                    //$desconto = ($valor * $ke['desconto_pmp']) / 100;
                                    if($ke['desconto_pmp'] >= 100):
                                        $desconto = $ke['desconto_pmp'];
                                    else:
                                        $desconto = ($value * $ke['desconto_pmp']) / 100;
                                    endif;
                                    //$desconto_f = ($valor * $ke['settings_desc_financ']) / 100;
                                    $total = ($valor - $desconto) + $iva;
                                    $iV += $iva;

                                    $net = $valor;
                                    $tt += ($valor - $desconto);

                                    $total_valor += ($valor - $desconto);
                                    $tota_quantidade += $ke['quantidade_pmp'];
                                    $total_iva += $iva;
                                    $total_desconto += $desconto;
                                    $total_preco += $total;
                                    $this->Xml .= '<Line>';
                                        $this->Xml .= '<LineNumber>'.$nLine.'</LineNumber>';
                                        $this->Xml .= '<ProductCode>'.$ke['id_product'].'</ProductCode>';
                                        $this->Xml .= '<ProductDescription>'.Check::CheckNamePro($ke['product_name']).'</ProductDescription>';
                                        $this->Xml .= '<Quantity>'.$ke['quantidade_pmp'].'</Quantity>';
                                        $this->Xml .= '<UnitOfMeasure>'.$ke['product_uni'].'</UnitOfMeasure>';
                                        $this->Xml .= '<UnitPrice>'.$ke['preco_pmp'].'</UnitPrice>';
                                        $this->Xml .= '<TaxPointDate>'.$key['TaxPointDate'].'</TaxPointDate>';
                                        $this->Xml .= '<Description>'.Check::CheckNamePro($ke['product_name']).'</Description>';
                                        $this->Xml .= '<CreditAmount>'.$net.'</CreditAmount>';
                                        $this->Xml .= '<Tax>';
                                            $this->Xml .= '<TaxType>'.$ke['taxType'].'</TaxType>';
                                            $this->Xml .= '<TaxCountryRegion>'.$ke['TaxCountryRegion'].'</TaxCountryRegion>';
                                            $this->Xml .= '<TaxCode>'.$ke['taxCode'].'</TaxCode>';
                                            $this->Xml .= '<TaxPercentage>'.$ke['taxa'].'</TaxPercentage>';
                                            if($ke['taxType'] != 'IVA' && $ke['taxType'] == 15):
                                                $this->Xml .= '<TaxAmount>'.$ke['taxAmount'].'</TaxAmount>';
                                            endif;
                                        $this->Xml .= '</Tax>';
                                        if($ke['taxa'] == 0 && $ke['taxAmount'] == 0):
                                            $this->Xml .= '<TaxExemptionReason>'.$ke['TaxExemptionReason'].'</TaxExemptionReason>';
                                            $this->Xml .= '<TaxExemptionCode>'.$ke['TaxExemptionCode'].'</TaxExemptionCode>';
                                        endif;
                                        /*if($ke['taxa'] == 0):
                                            $this->Xml .= '<TaxExemptionCode>'.$ke['TaxExemptionCode'].'</TaxExemptionCode>';
                                        endif;*/
                                    $this->Xml .= '</Line>';
                                endforeach;
                            endif;
                            $this->Xml .= '<DocumentTotals>';
                                $this->Xml .= '<TaxPayable>'.$iV.'</TaxPayable>';
                                $this->Xml .= '<NetTotal>'.($tt).'</NetTotal>';
                                $this->Xml .= '<GrossTotal>'.($total_preco).'</GrossTotal>';
                            $this->Xml .= '</DocumentTotals>';
                            $this->Xml .= '</Invoice>';
                        endforeach;
                    endif;

                $this->Xml .='</SalesInvoices>';
            $this->Xml .='</SourceDocuments>';
        $this->Xml .= "</AuditFile>";


        header("Content-Description: PHP Generated Data");
        header("Content-Type: application/xml");
        header("Content-Disposition: attachment; filename=\"{$this->File}\"");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Pragma: no-cache");
        echo $this->Xml;
        exit();
    }
}
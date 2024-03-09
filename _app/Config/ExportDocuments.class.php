<?php
/**
 * Created by PhpStorm.
 * User: Kwanzar Soft
 * Date: 11/06/2020
 * Time: 14:08
 */

class ExportDocuments{
    private $DataI, $DateF, $id_db_settings, $Documents, $Error, $Result, $F;

    public function getError(){return $this->Error;}
    public function getResult(){return $this->Result;}


    /**
     * @param $dateI
     * @param $dateF
     * @param $id
     * @param $document
     */
    public function Exporting($dateI, $dateF, $id, $document){
        if(!empty(strip_tags(trim($dateI))) && !empty(strip_tags(trim($dateF)))):
            $this->DataI = explode("-", $dateI);
            $this->DateF = explode("-", $dateF);
            $this->id_db_settings = $id;
            $this->Documents = $document;

            $n1 = "sd_billing";
            $n2 = "sd_billing_pmp";
            $n3 = "sd_retification";
            $n4 = "sd_retification_pmp";

            if(DBKwanzar::CheckConfig($this->id_db_settings)['JanuarioSakalumbu'] == null): $ttt = 2; else: $ttt = DBKwanzar::CheckConfig($this->id_db_settings)['JanuarioSakalumbu']; endif;
            if($this->Documents == 'CO' || $this->Documents == 'TM' || $this->Documents == 'FT' || $this->Documents == 'FR'):
                if($this->Documents == 'CO' || $this->Documents == 'TM'): $this->F = null; else: $this->F = " AND {$n1}.InvoiceType={$this->Documents} "; endif;
                $s = 'P';
                $Read = new Read();
                $Read->ExeRead("{$n1}", "WHERE {$n1}.id_db_settings={$this->id_db_settings} AND ({$n1}.dia BETWEEN {$this->DataI[2]} AND {$this->DateF[2]} ) AND ({$n1}.mes BETWEEN {$this->DataI[1]} AND {$this->DateF[1]} ) AND ({$n1}.ano BETWEEN {$this->DataI[0]} AND {$this->DateF[0]} ) {$this->F}");

                $file = "Export (a) - ".time().".csv";

                if($Read->getResult()):
                    foreach($Read->getResult() as $key):
                        extract($key);

                        $html = $key['id_db_settings']."; ".$key['id_customer']."; ".$key['id_mesa']."; ".$key['session_id']."; ".$key['numero']."; ".$key['InvoiceType']."; ".$key['TaxPointDate']."; "."I; ".$key['Code']."; ".$key['customer_name']."; ".$key['customer_nif']."; ".$key['customer_telefone']."; ".$key['customer_endereco']."; ".$key['settings_empresa']."; ".$key['settings_nif']."; ".$key['settings_endereco']."; ".$key['settings_telefone']."; ".$key['settings_email']."; ".$key['settings_nib']."; ".$key['settings_swift']."; ".$key['settings_iban']."; ".$key['settings_rodape']."; ".$key['settings_website']."; ".$key['settings_city']."; ".$key['settings_taxEntity']."; ".$key['username']."; ".$key['status']."; ".$key['suspenso']."; ".$key['dia']."; ".$key['mes']."; ".$key['ano']."; ".$key['hora']."; ".$key['pagou']."; ".$key['troco']."; ";

                        $Read->ExeRead("{$n2}", "WHERE id_db_settings={$this->id_db_settings} AND numero={$key['numero']}");

                        $file2 = "Export (b) - ".time().".csv";
                        if($Read->getResult()):
                            foreach($Read->getResult() as $k):
                                extract($k);

                                $html .= $k['id_db_settings']."; ".$k['session_id']."; ".$k['id_product']."; ".$k['id_mesa']."; ".$k['quantidade_pmp']."; ".$k['preco_pmp']."; ".$k['desconto_pmp']."; ".$k['taxa']."; ".$k['TaxExemptionCode']."; ".$k['TaxExemptionReason']."; ".$k['taxType']."; ".$k['taxCode']."; ".$k['description']."; ".$k['taxAmount']."; ".$k['TaxCountryRegion']."; ".$k['product_name']."; ".$k['product_code']."; ".$k['product_list']."; ".$k['product_uni']."; ".$k['suspenso']."; ".$k['numero']."; ".$k['status']."; "."I; "."\n";

                            endforeach;
                        endif;

                        //header("Content-Description: PHP Generated Data");
                        //header("Content-Type: application/cvs");
                        header("Content-Disposition: attachment; filename=\"{$file}\"");
                        //header("Expires: 0");
                        //header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
                        //header("Pragma: no-cache");
                        echo $html;
                    endforeach;
                endif;
            endif;
        else:
            $this->Error  = ["Ops: preencha a corretamenta da data para continuar!", WS_INFOR];
            $this->Result = false;
        endif;
    }
}
<?php
$p1 = "cv_customer";
$p2 = "db_taxtable";

$Read = new Read();
$DBC  = new DBKwanzar();

$Read->ExeRead("{$p1}", "WHERE id_db_settings=:i", "i={$id_db_settings}");
if(!$Read->getResult()):
    $Data["nome"]          = "Consumidor final";
    $Data["type"]          = "Consumidor final";
    $Data["nif"]           = "999999999";
    $Data["endereco"]      = "Consumidor final";
    $Data["addressDetail"] = "Consumidor final";
    $Data["city"]          = "Consumidor final";
    $Data["country"]       = "AO";
    $Data["status"]        = 3;

    $cover['logotype'] = null;

    $Customer = new Customer();
    $Customer->ExeCreate($cover, $Data, $id_db_settings);
endif;

$Read->ExeRead("{$p2}", "WHERE id_db_settings=:i AND taxType='IVA' AND taxCode='NOR' AND taxPercentage='14'");
if(!$Read->getResult()):
    $Dat['id_db_settings'] = $id_db_settings;
    $Dat['taxType'] = "IVA";
    $Dat['taxCode'] = "NOR";
    $Dat['description'] = "Descrição do Kwanzar";
    $Dat['taxAmount'] = 1;
    $Dat['taxPercentage'] = 14;
    $Dat['TaxCountryRegion'] = "AO";
    $Dat['TaxExemptionReason'] = "Isento Artigo 15.º 1 d) do CIVA";
    $Dat["TaxExemptionCode"] = "M33";

    $Create = new Create();
    $Create->ExeCreate("{$p2}", $Dat);
endif;

$Read->ExeRead("{$p2}", "WHERE id_db_settings=:i AND taxType='IVA' AND taxCode='ISE' AND taxPercentage='0'");
if(!$Read->getResult()):
    $Da['id_db_settings'] = $id_db_settings;
    $Da['taxType'] = "IVA";
    $Da['taxCode'] = "ISE";
    $Da['taxPercentage'] = 0;
    $Da['description'] = "Descrição do Kwanzar";
    $Da['taxAmount'] = 0;
    $Da['TaxCountryRegion'] = "AO";
    $Da['TaxExemptionReason'] = "Transmissão de bens e serviço não sujeita";
    $Da["TaxExemptionCode"] = "M02";

    $Create = new Create();
    $Create->ExeCreate("{$p2}", $Da);
endif;

$Read->ExeRead("{$p2}", "WHERE id_db_settings=:i AND taxType='IVA' AND taxCode='NOR' AND taxPercentage='7'");
if(!$Read->getResult()):
    $D['id_db_settings'] = $id_db_settings;
    $D['taxType'] = "IVA";
    $D['taxCode'] = "NOR";
    $D['description'] = "Descrição do Kwanzar";
    $D['taxAmount'] = 1;
    $D['taxPercentage'] = 7;
    $D['TaxCountryRegion'] = "AO";
    $D['TaxExemptionReason'] = "Isento Artigo 15.º 1 d) do CIVA";
    $D["TaxExemptionCode"]  = "M33";

    $Create = new Create();
    $Create->ExeCreate("{$p2}", $D);
endif;


/*** Novas verificações ***/

$Read->ExeRead("db_config", "WHERE id_db_settings=:i AND id_db_kwanzar=:ip ", "i={$id_db_settings}&ip={$id_db_kwanzar}");
if(!$Read->getResult()):
    $Data2["JanuarioSakalumbu"] = "3";
    $Data2["moeda"] = "AOA";
    $Data2["sequencialCode"] = "A".$id_db_settings;
    $Data2["HeliosPro"] = "1";
    $Data2["IncluirCover"] = "2";
    $Data2["MethodDefault"] = "2";
    $Data2["ECommerce"] = "2";
    $Data2["DocModel"] = "2";
    $Data2["PadraoAGT"] = "2";
    $Data2["regimeIVA"] = "Regime de exclusão";
    $Data2["id_db_settings"] = $id_db_settings;
    $Data2["id_db_kwanzar"] = $id_db_kwanzar;
    $Data2["cef"] = 1;
    $Data2["cambio_atual"] = 0;
    $Data2["cambio_x_preco"] = 2;
    $Data2["porcentagem_x_cambio"] = 0;
    $Data2["Idioma"] = "Português";

    $Create = new Create();
    $Create->ExeCreate("db_config", $Data2);
endif;

$Read->ExeRead("db_users_settings", "WHERE session_id=:i", "i={$id_user}");
if(!$Read->getResult()):
    $Data1["Impression"] = "A4";
    $Data1["NumberOfCopies"] = "1";
    $Data1["cef"] = "1";
    $Data1["SalesType"] = "1";
    $Data1["session_id"] = $id_user;
    $Data1["id_db_settings"] = $id_db_settings;

    $Create = new Create();
    $Create->ExeCreate("db_users_settings", $Data1);
endif;

$type = "P";
$Read = new Read();
$Read->ExeRead("cv_product", "WHERE id_db_settings=:id AND type=:t ORDER BY product ASC", "id={$id_db_settings}&t={$type}");

if($Read->getResult()):
    foreach ($Read->getResult() as $key):
        $Product = new Product();
        if(!empty($key['data_expiracao'])):
            $Product->VerificarExpiracao($key['data_expiracao'], $key['id'], $key['product'], $id_db_settings);
        else:
            $Product->AlertEmpty($id_db_settings);
        endif;
    endforeach;
endif;

if(DBKwanzar::CheckConfig($id_db_settings)['cambio_x_preco'] == 1 && !empty(DBKwanzar::CheckConfig($id_db_settings)['cambio_atual']) && DBKwanzar::CheckConfig($id_db_settings)['porcentagem_x_cambio'] > 0):
    $Product = new Product();
    $Product->ExeUpdateCambio($id_db_settings);

    if(!$Product->getResult()):
        WSError($Product->getError()[0], $Product->getError()[1]);
    endif;
else:
    $Product = new Product();
    $Product->ExeUpdateCambioII($id_db_settings);

    if(!$Product->getResult()):
        WSError($Product->getError()[0], $Product->getError()[1]);
    endif;
endif;
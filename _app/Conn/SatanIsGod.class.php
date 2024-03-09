<?php
class SatanIsGod{
    const
        config = "z_config",
        security = "z_security";
    private $Error, $Data, $Result, $Conn, $Arq, $Cover, $Dados, $postId, $Icon;
    private $HOST, $USER, $PASS, $DBSA;
    public function getError(){return $this->Error;}
    public function getResult(){return $this->Result;}

    public function EliminarErros($HOST, $USER, $DBSA, $PASS = null){
        $this->Data['host'] = $HOST;
        $this->Data['user'] = $USER;
        $this->Data['pass'] = $PASS;
        $this->Data['db'] = $DBSA;

        $this->Tables();
    }

    public function UpdateSecurity($postId, array $Dados){
        $this->Dados = $Dados;
        $this->postId = (int) $postId;
        unset($this->Dados['SendPostFormL']);
        $this->Dados["plano"] = strip_tags(trim($this->Dados['plano']));
        $this->Dados["documentos"] = strip_tags(trim($this->Dados['documentos']));
        $this->Dados["usuarios"] = strip_tags(trim($this->Dados['usuarios']));
        $this->Dados["modulos"] = strip_tags(trim($this->Dados['modulos']));
        $this->Dados["empresas"] = strip_tags(trim($this->Dados['empresas']));
        $this->Dados["valor"] = strip_tags(trim($this->Dados['valor']));

        if(in_array("", $this->Dados)):
            $this->Error = ["Opsss!: preencha todos os campos para prosseguir com o processo!", WS_ALERT];
            $this->Result = false;
        elseif(!is_numeric($this->Dados['valor']) || !is_numeric($this->Dados['documentos']) || !is_numeric($this->Dados['empresas']) || !is_numeric($this->Dados['usuarios'])):
            $this->Result = false;
            $this->Error = ["Opsss!: os campos: <strong>Documentos mensal, Usuários, Empresas/Negócios, Valor Mensal</strong> tem de ser preenchidos com números!", WS_INFOR];
        else:
            $this->SecurityUp();
        endif;
    }

    private function SecurityUp(){
        $Create = new Update();
        $Create->ExeUpdate(self::security, $this->Dados, "WHERE id=:i ", "i={$this->postId}");

        if($Create->getResult()):
            $this->Error = ["Pacote de Licença atualizada com sucesso!", WS_ACCEPT];
            $this->Result = false;
        else:
            $this->Error = ["Opsss!: aconteceu um erro inesperado ao criar o pacote de Licença!", WS_ERROR];
            $this->Result = false;
        endif;
    }

    public function CreateSecurity(array $Dados){
        $this->Dados = $Dados;
        unset($this->Dados['SendPostFormL']);
        $this->Dados["plano"] = strip_tags(trim($this->Dados['plano']));
        $this->Dados["documentos"] = strip_tags(trim($this->Dados['documentos']));
        $this->Dados["usuarios"] = strip_tags(trim($this->Dados['usuarios']));
        $this->Dados["modulos"] = strip_tags(trim($this->Dados['modulos']));
        $this->Dados["empresas"] = strip_tags(trim($this->Dados['empresas']));
        $this->Dados["valor"] = strip_tags(trim($this->Dados['valor']));

        if(in_array("", $this->Dados)):
            $this->Error = ["Opsss!: preencha todos os campos para prosseguir com o processo!", WS_ALERT];
            $this->Result = false;
        elseif(!is_numeric($this->Dados['valor']) || !is_numeric($this->Dados['documentos']) || !is_numeric($this->Dados['empresas']) || !is_numeric($this->Dados['usuarios'])):
            $this->Result = false;
            $this->Error = ["Opsss!: os campos: <strong>Documentos mensal, Usuários, Empresas/Negócios, Valor Mensal</strong> tem de ser preenchidos com números!", WS_INFOR];
        else:
            $Read = new Read();
            $Read->ExeRead(self::security, "WHERE plano=:a1 AND modulos=:a2 AND empresas=:a3 AND valor=:a4 ", "a1={$this->Dados['plano']}&a2={$this->Dados['modulos']}&a3={$this->Dados['empresas']}&a4={$this->Dados['valor']}");
            if($Read->getResult()):
                $this->Error = ["Opsss!: o plano: <strong>{$this->Dados['plano']}</strong>, já encontra-se registrado!", WS_ALERT];
                $this->Result = false;
            else:
                $this->Security();
            endif;
        endif;
    }

    private function Security(){
        $Create = new Create();
        $Create->ExeCreate(self::security, $this->Dados);

        if($Create->getResult()):
            $this->Error = ["Pacote de Licença criado com sucesso!", WS_ACCEPT];
            $this->Result = false;
        else:
            $this->Error = ["Opsss!: aconteceu um erro inesperado ao criar o pacote de Licença!", WS_ERROR];
            $this->Result = false;
        endif;
    }

    public function CreateDatabase(array $data){
        $this->Data = $data;
        unset($this->Data['SendPostFormL']);
        if(!empty($this->Data["host"]) && !empty($this->Data["user"]) && !empty($this->Data["db"])):
            $this->Conn = new mysqli($this->Data['host'], $this->Data['user'], $this->Data['pass']);
            if ( $this->Conn->connect_error):
                die("Falha ao efectuar a conexāo: " . $this->Conn->connect_error);
            endif;

            $info = "<?php\n";
            $info .= "\$var = \"{$this->Data['host']}; {$this->Data['user']}; {$this->Data['pass']}; {$this->Data['db']}\";";

            $sql = "CREATE DATABASE {$this->Data['db']}";
            if ( $this->Conn->query($sql) === TRUE):
                $name = 'database'.'.php';
                $fileHandler = fopen($name, 'w+');
                fwrite($fileHandler, $info);
                fclose($fileHandler);
                $this->Tables();
            else:
                $this->Result = false;
                $this->Error  = "Erro ao criar o banco de dados: {$this->Conn->error}";
            endif;
        endif;
    }

    private function Tables(){
        $this->Conn = new mysqli($this->Data['host'], $this->Data['user'], $this->Data['pass'], $this->Data['db']);
        if ( $this->Conn->connect_error):
            die("Falha ao efectuar a conexāo: ".$this->Conn->connect_error);
        endif;

        $table1 = "
CREATE TABLE IF NOT EXISTS `br_cart` (
  `id` double  UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `id_cv_product` double DEFAULT NULL,
  `id_db_users` double DEFAULT NULL,
  `qtd` double DEFAULT NULL,
  `pricing` double DEFAULT NULL,
  `data` varchar(100) DEFAULT NULL,
  `hora` varchar(100) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `method` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1
        ";

        $table2 = "
CREATE TABLE IF NOT EXISTS `br_likes` (
  `id` double  UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `id_cv_product` double DEFAULT NULL,
  `id_db_users` double DEFAULT NULL,
  `data` varchar(100) DEFAULT NULL,
  `hora` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1
        ";

        $table3 = "
CREATE TABLE IF NOT EXISTS `br_newsletter` (
  `id` double  UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `dia` varchar(10) DEFAULT NULL,
  `mes` varchar(10) DEFAULT NULL,
  `ano` varchar(10) DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1
        ";

        $table4 = "
CREATE TABLE IF NOT EXISTS `br_rating` (
  `id` double  UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `id_cv_product` double DEFAULT NULL,
  `id_db_users` double DEFAULT NULL,
  `rating` int(11) DEFAULT NULL,
  `message` varchar(500) DEFAULT NULL,
  `dia` varchar(5) DEFAULT NULL,
  `mes` varchar(5) DEFAULT NULL,
  `ano` int(11) DEFAULT NULL,
  `hora` time DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1
        ";

        $table5 = "
CREATE TABLE IF NOT EXISTS `cv_category` (
  `id` double  UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `id_db_settings` double NOT NULL,
  `category_title` varchar(1000) NOT NULL,
  `category_content` longtext NOT NULL,
  `category_data` varchar(1000) NOT NULL,
  `views` double DEFAULT NULL,
  `cover` varchar(500) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1
        ";

        $table6 = "
CREATE TABLE IF NOT EXISTS `cv_customer` (
  `id` double  UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `id_db_settings` double NOT NULL,
  `nome` varchar(255) NOT NULL,
  `type` varchar(222) NOT NULL,
  `nif` varchar(225) NOT NULL,
  `email` varchar(225) DEFAULT NULL,
  `telefone` varchar(255) DEFAULT NULL,
  `endereco` varchar(255) NOT NULL,
  `addressDetail` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `country` varchar(2) NOT NULL,
  `accountID` double DEFAULT NULL,
  `cover` varchar(255) DEFAULT NULL,
  `obs` longtext DEFAULT NULL,
  `status` double DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1
        ";

        $table7 = "
CREATE TABLE IF NOT EXISTS `cv_gallery_product` (
  `id` double  UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `id_db_settings` double DEFAULT NULL,
  `id_cv_product` double DEFAULT NULL,
  `cover` varchar(500) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `time` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1
        ";

        $table8 = "
CREATE TABLE IF NOT EXISTS `cv_garcom` (
  `id` double  UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `id_db_settings` double DEFAULT NULL,
  `telefone` varchar(100) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `porcentagem` double DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1
        ";

        $table9 = "
CREATE TABLE IF NOT EXISTS `cv_mesas` (
  `id` double  UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `id_db_settings` double NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `localizacao` varchar(255) DEFAULT NULL,
  `capacidade` int(11) DEFAULT NULL,
  `obs` longtext DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1
        ";

        $table10 = "
CREATE TABLE IF NOT EXISTS `cv_operation` (
  `id` double  UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `id_db_settings` double DEFAULT NULL,
  `id_product` double DEFAULT NULL,
  `operacao` varchar(100) DEFAULT NULL,
  `natureza` varchar(100) DEFAULT NULL,
  `quantidade` double DEFAULT NULL,
  `unidades` double DEFAULT NULL,
  `custo_compra` double DEFAULT NULL,
  `data_emissao` varchar(100) DEFAULT NULL,
  `data_operacao` varchar(100) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `descricao` longtext DEFAULT NULL,
  `olds_caixas` double DEFAULT NULL,
  `olds_unidades` double DEFAULT NULL,
  `novas_caixas` mediumint(9) DEFAULT NULL,
  `novas_unidades` double DEFAULT NULL,
  `olds_unidades_loja` double DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4
        ";

        $table11 = "
CREATE TABLE IF NOT EXISTS `cv_pedido_product` (
  `id` double  UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `id_db_settings` double DEFAULT NULL,
  `id_product` double DEFAULT NULL,
  `qtdOne` int(11) DEFAULT NULL,
  `data` varchar(122) DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1
        ";

        $table12 = "
CREATE TABLE IF NOT EXISTS `cv_product` (
  `id` double  UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `id_db_settings` double NOT NULL,
  `id_category` double NOT NULL,
  `codigo` varchar(1000) NOT NULL,
  `codigo_barras` varchar(1000) NOT NULL,
  `product` varchar(1000) NOT NULL,
  `preco_venda` double NOT NULL,
  `preco_venda_ii` double NOT NULL,
  `preco_promocao` double NOT NULL,
  `quantidade` double NOT NULL,
  `unidades` double NOT NULL,
  `iva` double NOT NULL,
  `id_iva` double NOT NULL,
  `unidade_medida` varchar(1000) NOT NULL,
  `estoque_minimo` double NOT NULL,
  `type` varchar(1000) NOT NULL,
  `peso_liquido` varchar(1000) NOT NULL,
  `peso_bruto` varchar(1000) NOT NULL,
  `cover` varchar(1000) NOT NULL,
  `data_promocao` varchar(100) NOT NULL,
  `data_fim_promocao` varchar(100) NOT NULL,
  `status` double NOT NULL,
  `Description` longtext NOT NULL,
  `gQtd` double NOT NULL,
  `Ls` int(11) DEFAULT NULL,
  `IE_commerce` int(11) DEFAULT NULL,
  `ILoja` int(11) DEFAULT NULL,
  `porcentagem_promocao` int(11) DEFAULT NULL,
  `views` double DEFAULT NULL,
  `likes` double DEFAULT NULL,
  `purchased` double DEFAULT NULL,
  `custo_compra` double DEFAULT NULL,
  `id_unidade` double DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1
        ";

        $table13 = "
CREATE TABLE IF NOT EXISTS `cv_supplier` (
  `id` double  UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `id_db_settings` double NOT NULL,
  `nome` varchar(255) NOT NULL,
  `type` varchar(100) NOT NULL,
  `nif` varchar(220) NOT NULL,
  `email` varchar(220) NOT NULL,
  `telefone` varchar(220) NOT NULL,
  `endereco` varchar(220) NOT NULL,
  `addressDetail` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `accountID` double NOT NULL,
  `cover` varchar(1000) NOT NULL,
  `obs` longtext NOT NULL,
  `status` double NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1
        ";

        $table14 = "
CREATE TABLE IF NOT EXISTS `db_active` (
  `id` double  UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `id_db_settings` double DEFAULT NULL,
  `active` varchar(600) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1
        ";

        $table15 = "
CREATE TABLE IF NOT EXISTS `db_config` (
  `id` double  UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `id_db_kwanzar` double NOT NULL,
  `id_db_settings` double NOT NULL,
  `moeda` varchar(25) DEFAULT NULL,
  `estoque_minimo` varchar(25) DEFAULT NULL,
  `sequencialCode` varchar(25) DEFAULT NULL,
  `WidthLogotype` varchar(25) DEFAULT NULL,
  `HeightLogotype` varchar(25) DEFAULT NULL,
  `HeliosPro` varchar(25) DEFAULT NULL,
  `JanuarioSakalumbu` varchar(25) DEFAULT NULL,
  `RetencaoDeFonte` double DEFAULT NULL,
  `IncluirNaFactura` int(11) DEFAULT NULL,
  `IncluirCover` int(11) DEFAULT NULL,
  `MethodDefault` int(11) DEFAULT NULL,
  `PadraoAGT` int(11) DEFAULT NULL,
  `ECommerce` int(11) DEFAULT NULL,
  `cef` int(11) DEFAULT NULL,
  `DocModel` int(11) DEFAULT NULL 
) ENGINE=MyISAM DEFAULT CHARSET=latin1
        ";

        $table16 = "
CREATE TABLE IF NOT EXISTS `db_kwanzar` (
  `id` double  UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `dia` varchar(10) DEFAULT NULL,
  `mes` varchar(10) DEFAULT NULL,
  `ano` varchar(10) DEFAULT NULL,
  `hora` varchar(25) DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1
        ";

        $table17 = "
CREATE TABLE IF NOT EXISTS `db_settings` (
  `id` double  UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `id_db_kwanzar` double DEFAULT NULL,
  `empresa` varchar(255) DEFAULT NULL,
  `nif` varchar(255) DEFAULT NULL,
  `telefone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `endereco` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `logotype` varchar(500) DEFAULT NULL,
  `nib` varchar(255) DEFAULT NULL,
  `iban` varchar(255) DEFAULT NULL,
  `swift` varchar(255) DEFAULT NULL,
  `businessName` varchar(255) DEFAULT NULL,
  `addressDetail` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `BuildingNumber` varchar(255) DEFAULT NULL,
  `taxEntity` varchar(255) DEFAULT NULL,
  `makeUp` varchar(255) DEFAULT NULL,
  `atividade` varchar(255) DEFAULT NULL,
  `typeVenda` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `coordenadas` longtext DEFAULT NULL,
  `cef` int(11) DEFAULT NULL,
  `cef_nib` int(11) DEFAULT NULL,
  `dia` varchar(10) DEFAULT NULL,
  `mes` varchar(10) DEFAULT NULL,
  `ano` varchar(20) DEFAULT NULL,
  `banco` varchar(255) DEFAULT  NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1
        ";

        $table18 = "
CREATE TABLE IF NOT EXISTS `db_settings_static` (
  `id` double  UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `id_db_settings` double DEFAULT NULL,
  `dia` varchar(10) DEFAULT NULL,
  `mes` varchar(10) DEFAULT NULL,
  `ano` varchar(50) DEFAULT NULL,
  `hora` varchar(50) DEFAULT NULL,
  `total` double DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4
        ";

        $table19 = "
CREATE TABLE IF NOT EXISTS `db_static_db_settings_product` (
  `id` double UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `id_db_settings` double DEFAULT NULL,
  `id_cv_product` double DEFAULT NULL,
  `counting` float DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1
        ";

        $table20 = "
CREATE TABLE IF NOT EXISTS `db_static_sales_customer` (
  `id` double UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `id_db_settings` double DEFAULT NULL,
  `id_cv_customer` double DEFAULT NULL,
  `counting` float DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1
        ";

        $table21 = "
CREATE TABLE IF NOT EXISTS `db_static_sales_db_users` (
  `id` double UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `id_db_settings` double DEFAULT NULL,
  `id_db_users` double DEFAULT NULL,
  `counting` float DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1
        ";

        $table22 = "
CREATE TABLE IF NOT EXISTS `db_taxtable` (
  `taxtableEntry` double UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `id_db_kwanzar` double DEFAULT NULL,
  `id_db_settings` double NOT NULL,
  `taxType` varchar(220) NOT NULL,
  `taxCode` varchar(220) NOT NULL,
  `description` varchar(220) NOT NULL,
  `taxPercentage` varchar(220) NOT NULL,
  `taxAmount` varchar(220) NOT NULL,
  `TaxCountryRegion` varchar(255) NOT NULL,
  `TaxExemptionReason` varchar(100) NOT NULL,
  `TaxExemptionCode` varchar(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1
        ";

        $table23 = "
CREATE TABLE IF NOT EXISTS `db_users` (
  `id` double UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `id_db_kwanzar` double DEFAULT NULL,
  `id_db_settings` double DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(500) DEFAULT NULL,
  `registration` varchar(100) DEFAULT NULL,
  `lastupdate` varchar(100) DEFAULT NULL,
  `cover` varchar(500) DEFAULT NULL,
  `level` int(11) DEFAULT NULL,
  `st` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `block` int(11) DEFAULT NULL,
  `agora` varchar(111) DEFAULT NULL,
  `limite` varchar(111) DEFAULT NULL,
  `blocks` varchar(500) DEFAULT NULL,
  `telefone` varchar(100) DEFAULT NULL,
  `endereco` varchar(255) DEFAULT NULL,
  `descricao` longtext DEFAULT NULL,
  `nif` varchar(100) DEFAULT NULL,
  `session_start` varchar(255) DEFAULT NULL,
  `session_end` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1
        ";

        $table24 = "
CREATE TABLE IF NOT EXISTS `db_users_active_static` (
  `id` double UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `session_id` double DEFAULT NULL,
  `dia` varchar(10) DEFAULT NULL,
  `mes` varchar(10) DEFAULT NULL,
  `ano` varchar(30) DEFAULT NULL,
  `total` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4
        ";

        $table25 = "
CREATE TABLE IF NOT EXISTS `db_users_active_store` (
  `id` double UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `id_db_settings` double DEFAULT NULL,
  `session_id` double DEFAULT NULL,
  `page` varchar(500) DEFAULT NULL,
  `user_ip` varchar(500) DEFAULT NULL,
  `system` longtext DEFAULT NULL,
  `hora` varchar(100) DEFAULT NULL,
  `data` varchar(100) DEFAULT NULL,
  `dia` varchar(10) DEFAULT NULL,
  `mes` varchar(10) DEFAULT NULL,
  `ano` varchar(50) DEFAULT NULL,
  `cookie` varchar(500) DEFAULT NULL,
  `platform` varchar(500) DEFAULT NULL,
  `browser` varchar(500) DEFAULT NULL,
  `query_string` varchar(500) DEFAULT NULL,
  `x` double DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1
        ";

        $table26 = "
CREATE TABLE IF NOT EXISTS `db_users_browser_static` (
  `id` double UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `browser` varchar(100) DEFAULT NULL,
  `views` double DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4
        ";

        $table27 = "
CREATE TABLE IF NOT EXISTS `db_users_commint` (
  `id` double UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `id_user` double DEFAULT NULL,
  `commint` longtext DEFAULT NULL,
  `data` varchar(50) DEFAULT NULL,
  `hora` varchar(30) DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4
        ";

        $table28 = "
CREATE TABLE IF NOT EXISTS `db_users_settings` (
  `id` double UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `id_db_settings` double NOT NULL,
  `session_id` double NOT NULL,
  `positionMenu` varchar(25) DEFAULT NULL,
  `Impression` varchar(25) DEFAULT NULL,
  `NumberOfCopies` varchar(25) DEFAULT NULL,
  `Language` varchar(25) DEFAULT NULL,
  `PRecuvaPassword` varchar(25) DEFAULT NULL,
  `RecuvaPassword` varchar(255) DEFAULT NULL,
  `cef` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1
        ";

        $table29 = "
CREATE TABLE IF NOT EXISTS `ec_face` (
  `id` double UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `dia` varchar(5) DEFAULT NULL,
  `mes` varchar(5) DEFAULT NULL,
  `ano` varchar(5) DEFAULT NULL,
  `hora` varchar(20) DEFAULT NULL,
  `t` varchar(30) DEFAULT NULL,
  `value` double DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1
        ";

        $table30 = "
CREATE TABLE IF NOT EXISTS `ec_saldos` (
  `id` double UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `ENTRADA` double DEFAULT NULL,
  `SAIDA` double DEFAULT NULL,
  `FACE` double DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1
        ";

        $table31 = "
CREATE TABLE IF NOT EXISTS `iii_static_cars` (
  `id` double UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `id_db_settings` double DEFAULT NULL,
  `id_cliente` double DEFAULT NULL,
  `postId` double DEFAULT NULL,
  `ordem` double DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1
        ";

        $table32 = "
CREATE TABLE IF NOT EXISTS `iii_static_clientes` (
  `id` double UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `id_db_settings` double DEFAULT NULL,
  `postId` double DEFAULT NULL,
  `compra` double DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1
        ";

        $table33 = "
CREATE TABLE IF NOT EXISTS `iii_static_kilape` (
  `id` double UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `id_db_settings` double DEFAULT NULL,
  `postId` double DEFAULT NULL,
  `kilape` double DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1
        ";

        $table34 = "
CREATE TABLE IF NOT EXISTS `iii_static_product` (
  `id` double UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `id_db_settings` double DEFAULT NULL,
  `postId` double DEFAULT NULL,
  `qtd` double DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1
        ";

        $table35 = "
CREATE TABLE IF NOT EXISTS `iii_static_users` (
  `id` double UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `id_db_settings` double DEFAULT NULL,
  `postId` double DEFAULT NULL,
  `sales` double DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1
        ";

        $table36 = "
CREATE TABLE IF NOT EXISTS `ii_billing` (
  `id` double UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `id_db_settings` double DEFAULT NULL,
  `id_cliente` double DEFAULT NULL,
  `id_user` double DEFAULT NULL,
  `numero` double DEFAULT NULL,
  `hash` varchar(172) DEFAULT NULL,
  `hashcontrol` varchar(172) DEFAULT NULL,
  `method` varchar(10) DEFAULT NULL,
  `InvoiceType` varchar(10) DEFAULT NULL,
  `TaxPointDate` varchar(50) DEFAULT NULL,
  `Code` varchar(30) DEFAULT NULL,
  `customer_name` varchar(255) DEFAULT NULL,
  `customer_endereco` varchar(255) DEFAULT NULL,
  `customer_nif` varchar(100) DEFAULT NULL,
  `system_logotype` varchar(500) DEFAULT NULL,
  `system_endereco` varchar(255) DEFAULT NULL,
  `system_telefone` varchar(100) DEFAULT NULL,
  `system_email` varchar(100) DEFAULT NULL,
  `system_nib` varchar(255) DEFAULT NULL,
  `system_swift` varchar(255) DEFAULT NULL,
  `system_iban` varchar(255) DEFAULT NULL,
  `system_city` varchar(50) DEFAULT NULL,
  `system_coordenadas` longtext DEFAULT NULL,
  `system_website` varchar(100) DEFAULT NULL,
  `system_name` varchar(255) DEFAULT NULL,
  `system_nif` varchar(100) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `dia` varchar(10) DEFAULT NULL,
  `mes` varchar(10) DEFAULT NULL,
  `ano` varchar(10) DEFAULT NULL,
  `hora` varchar(25) DEFAULT NULL,
  `pagou` double DEFAULT NULL,
  `troco` double DEFAULT NULL,
  `config_moeda` varchar(10) DEFAULT NULL,
  `config_module` varchar(10) DEFAULT NULL,
  `desconto_financeiro` double DEFAULT NULL,
  `config_retencao_de_fonte` double DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `Invoice` varchar(200) DEFAULT NULL,
  `id_box_in` double DEFAULT NULL,
  `id_invoice` double DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `id_veiculo` double DEFAULT NULL,
  `id_mecanico` double DEFAULT NULL,
  `mecanico` varchar(255) DEFAULT NULL,
  `fo_data_entrada` varchar(125) DEFAULT NULL,
  `fo_laudo` longtext DEFAULT NULL,
  `fo_problema` longtext DEFAULT NULL,
  `fo_observacoes` longtext DEFAULT NULL,
  `kilometragem` varchar(125) DEFAULT NULL,
  `matricula` varchar(125) DEFAULT NULL,
  `timer` double DEFAULT NULL,
  `Rectification` varchar(255) DEFAULT NULL,
  `InvoiceDate` varchar(100) DEFAULT NULL,
  `v_modelo` varchar(450) DEFAULT NULL,
  `system_banco` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1
        ";

        $table37 = "
CREATE TABLE IF NOT EXISTS `ii_billing_ac` (
  `id` double UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `id_db_settings` double DEFAULT NULL,
  `id_user` double DEFAULT NULL,
  `id_invoice` double DEFAULT NULL,
  `id_invoice_i` double DEFAULT NULL,
  `data` varchar(75) DEFAULT NULL,
  `value` double DEFAULT NULL,
  `InvoiceType` varchar(25) DEFAULT NULL,
  `Invoice` varchar(125) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1
        ";

        $table38 = "
CREATE TABLE IF NOT EXISTS `ii_billing_pmp` (
  `id` double UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `id_db_settings` double DEFAULT NULL,
  `id_user` double DEFAULT NULL,
  `id_product` double DEFAULT NULL,
  `id_category` double DEFAULT NULL,
  `id_unidade` double DEFAULT NULL,
  `id_taxtable` double DEFAULT NULL,
  `id_box_in` double DEFAULT NULL,
  `product` varchar(255) DEFAULT NULL,
  `qtd_pmp` double DEFAULT NULL,
  `preco_pmp` double DEFAULT NULL,
  `desconto_pmp` double DEFAULT NULL,
  `taxa_pmp` double DEFAULT NULL,
  `TaxType` varchar(50) DEFAULT NULL,
  `TaxCode` varchar(15) DEFAULT NULL,
  `ExeReason` varchar(255) DEFAULT NULL,
  `ExeCode` varchar(15) DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL,
  `system_module` varchar(10) DEFAULT NULL,
  `product_code` varchar(50) DEFAULT NULL,
  `product_code_bars` varchar(100) DEFAULT NULL,
  `product_unidade` varchar(50) DEFAULT NULL,
  `product_list` varchar(500) DEFAULT NULL,
  `product_type` varchar(10) DEFAULT NULL,
  `InvoiceType` varchar(10) DEFAULT NULL,
  `Invoice` varchar(200) DEFAULT NULL,
  `id_invoice` double DEFAULT NULL,
  `id_invoice_i` double DEFAULT NULL,
  `id_invoice_pmp` double DEFAULT NULL,
  `Country` varchar(10) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1
        ";

        $table39 = "
CREATE TABLE IF NOT EXISTS `ii_billing_story` (
  `id` double UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `id_db_settings` double DEFAULT NULL,
  `id_user` double DEFAULT NULL,
  `id_cliente` double DEFAULT NULL,
  `id_invoice` double DEFAULT NULL,
  `value` double DEFAULT NULL,
  `imposto` double DEFAULT NULL,
  `desconto` double DEFAULT NULL,
  `total` double DEFAULT NULL,
  `dia` varchar(10) DEFAULT NULL,
  `mes` varchar(10) DEFAULT NULL,
  `ano` varchar(10) DEFAULT NULL,
  `InvoiceType` varchar(10) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1
        ";

        $table40 = "
CREATE TABLE IF NOT EXISTS `ii_billing_tmp` (
  `id` double UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `id_db_settings` double DEFAULT NULL,
  `id_user` double DEFAULT NULL,
  `id_product` double DEFAULT NULL,
  `id_category` double DEFAULT NULL,
  `id_unidade` double DEFAULT NULL,
  `id_taxtable` double DEFAULT NULL,
  `product` varchar(255) DEFAULT NULL,
  `qtd_tmp` double DEFAULT NULL,
  `preco_tmp` double DEFAULT NULL,
  `desconto_tmp` double DEFAULT NULL,
  `taxa_tmp` double DEFAULT NULL,
  `ExeCode` varchar(15) DEFAULT NULL,
  `ExeReason` varchar(225) DEFAULT NULL,
  `TaxType` varchar(125) DEFAULT NULL,
  `TaxCode` varchar(125) DEFAULT NULL,
  `Country` varchar(10) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `product_code` varchar(50) DEFAULT NULL,
  `product_code_bars` varchar(125) DEFAULT NULL,
  `product_list` varchar(500) DEFAULT NULL,
  `product_unidade` varchar(15) DEFAULT NULL,
  `product_type` varchar(10) DEFAULT NULL,
  `system_module` varchar(10) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1
        ";

        $table41 = "
CREATE TABLE IF NOT EXISTS `i_fabricante` (
  `id` double UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `id_db_settings` double DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `content` varchar(500) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1
        ";

        $table42 = "
CREATE TABLE IF NOT EXISTS `i_fornecedores` (
  `id` double UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `id_db_settings` double DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `nif` varchar(45) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `telefone` varchar(50) DEFAULT NULL,
  `endereco` varchar(255) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `country` varchar(10) DEFAULT NULL,
  `obs` varchar(1000) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1
        ";

        $table43 = "
CREATE TABLE IF NOT EXISTS `i_unidade` (
  `id` double UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `id_db_settings` double DEFAULT NULL,
  `unidade` varchar(100) DEFAULT NULL,
  `simbolo` varchar(10) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1
        ";

        $table44 = "
CREATE TABLE IF NOT EXISTS `i_veiculos` (
  `id` double UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `id_db_settings` double DEFAULT NULL,
  `id_fabricante` double DEFAULT NULL,
  `id_cliente` double DEFAULT NULL,
  `veiculo` varchar(255) DEFAULT NULL,
  `placa` varchar(50) DEFAULT NULL,
  `km_atual` varchar(100) DEFAULT NULL,
  `modelo` varchar(100) DEFAULT NULL,
  `content` varchar(3000) DEFAULT NULL,
  `data_registro` varchar(50) DEFAULT NULL,
  `data_entrada` varchar(50) DEFAULT NULL,
  `data_saida` varchar(50) DEFAULT NULL,
  `dia` varchar(12) DEFAULT NULL,
  `mes` varchar(12) DEFAULT NULL,
  `ano` varchar(12) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1
        ";

        $table45 = "
CREATE TABLE IF NOT EXISTS `sd_billing` (
  `id` double UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `id_db_settings` double NOT NULL,
  `id_customer` double NOT NULL,
  `id_mesa` double DEFAULT NULL,
  `session_id` double NOT NULL,
  `numero` double NOT NULL,
  `hash` varchar(172) DEFAULT NULL,
  `hashcontrol` varchar(70) DEFAULT NULL,
  `method` varchar(5) NOT NULL,
  `InvoiceType` varchar(5) NOT NULL,
  `TaxPointDate` varchar(25) NOT NULL,
  `SourceBilling` varchar(5) DEFAULT NULL,
  `Code` varchar(5) DEFAULT NULL,
  `customer_name` varchar(225) DEFAULT NULL,
  `customer_nif` varchar(45) DEFAULT NULL,
  `customer_telefone` varchar(50) DEFAULT NULL,
  `customer_endereco` varchar(255) DEFAULT NULL,
  `settings_empresa` varchar(255) DEFAULT NULL,
  `settings_logotype` varchar(500) DEFAULT NULL,
  `settings_nif` varchar(45) DEFAULT NULL,
  `settings_endereco` varchar(255) DEFAULT NULL,
  `settings_telefone` varchar(50) DEFAULT NULL,
  `settings_email` varchar(65) DEFAULT NULL,
  `settings_nib` varchar(255) DEFAULT NULL,
  `settings_swift` varchar(255) DEFAULT NULL,
  `settings_iban` varchar(255) DEFAULT NULL,
  `settings_rodape` varchar(255) DEFAULT NULL,
  `settings_website` varchar(255) DEFAULT NULL,
  `settings_city` varchar(255) DEFAULT NULL,
  `settings_taxEntity` varchar(10) DEFAULT NULL,
  `settings_coordenadas` longtext DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `suspenso` int(11) DEFAULT NULL,
  `dia` varchar(10) DEFAULT NULL,
  `mes` varchar(10) DEFAULT NULL,
  `ano` varchar(10) DEFAULT NULL,
  `hora` varchar(10) DEFAULT NULL,
  `pagou` double DEFAULT NULL,
  `troco` double DEFAULT NULL,
  `date_expiration` varchar(50) DEFAULT NULL,
  `timer` varchar(10) DEFAULT NULL,
  `settings_moeda` varchar(25) DEFAULT NULL,
  `box_in` int(11) DEFAULT NULL,
  `settings_desc_financ` double DEFAULT NULL,
  `id_garcom` double DEFAULT NULL,
  `RetencaoDeFonte` double DEFAULT NULL,
  `IncluirNaFactura` int(11) DEFAULT NULL,
  `settings_banco` varchar(255) DEFAULT NULL,
    `id_veiculos` varchar(255) DEFAULT NULL,
    `matriculas` varchar(255) DEFAULT NULL,
    `id_fabricante` varchar(255) DEFAULT NULL,
    `gallery_cover_1` varchar(500) DEFAULT NULL,
    `gallery_cover_2` varchar(500) DEFAULT NULL,
     `gallery_cover_3` varchar(500) DEFAULT NULL,
     `gallery_cover_4` varchar(500) DEFAULT NULL,
     `gallery_cover_5` varchar(500) DEFAULT NULL,
     `gallery_cover_6` varchar(500) DEFAULT NULL,
    `id_obs` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1
        ";

        $table46 = "
CREATE TABLE IF NOT EXISTS `sd_billing_pmp` (
  `id` double UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `id_db_settings` double NOT NULL,
  `session_id` double DEFAULT NULL,
  `id_product` double DEFAULT NULL,
  `id_mesa` double DEFAULT NULL,
  `quantidade_pmp` float DEFAULT NULL,
  `preco_pmp` double DEFAULT NULL,
  `desconto_pmp` float DEFAULT NULL,
  `taxa` float DEFAULT NULL,
  `TaxExemptionCode` varchar(255) DEFAULT NULL,
  `TaxExemptionReason` varchar(255) DEFAULT NULL,
  `taxType` varchar(255) DEFAULT NULL,
  `taxCode` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `taxAmount` varchar(255) DEFAULT NULL,
  `TaxCountryRegion` varchar(255) DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `product_code` varchar(255) DEFAULT NULL,
  `product_list` longtext DEFAULT NULL,
  `product_uni` varchar(255) DEFAULT NULL,
  `suspenso` int(11) DEFAULT NULL,
  `numero` double DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `SourceBilling` varchar(5) DEFAULT NULL,
  `InvoiceType` varchar(20) DEFAULT NULL,
  `box_in` int(11) DEFAULT NULL,
  `product_type` varchar(20) DEFAULT NULL,
  `product_id_category` double DEFAULT NULL,
  `id_garcom` double DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1
        ";

        $table47 = "
CREATE TABLE IF NOT EXISTS `sd_billing_tmp` (
  `id` double UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `id_db_settings` double NOT NULL,
  `session_id` double NOT NULL,
  `id_product` double NOT NULL,
  `id_mesa` double DEFAULT NULL,
  `quantidade_tmp` float NOT NULL,
  `preco_tmp` double NOT NULL,
  `desconto_tmp` float NOT NULL,
  `taxa` float DEFAULT NULL,
  `TaxExemptionCode` varchar(255) DEFAULT NULL,
  `TaxExemptionReason` varchar(255) DEFAULT NULL,
  `taxType` varchar(255) DEFAULT NULL,
  `taxCode` varchar(255) DEFAULT NULL,
  `TaxCountryRegion` varchar(255) DEFAULT NULL,
  `taxAmount` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_code` varchar(255) NOT NULL,
  `product_list` longtext DEFAULT NULL,
  `product_uni` varchar(255) DEFAULT NULL,
  `suspenso` int(11) NOT NULL,
  `product_type` varchar(20) DEFAULT NULL,
  `product_id_category` double DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1
        ";

        $table48 = "
CREATE TABLE IF NOT EXISTS `sd_box` (
  `id` double UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `id_db_settings` double DEFAULT NULL,
  `session_id` double DEFAULT NULL,
  `abertura` varchar(50) DEFAULT NULL,
  `updater` varchar(50) DEFAULT NULL,
  `fecho` varchar(50) DEFAULT NULL,
  `value_open` double DEFAULT NULL,
  `value_finish` double DEFAULT NULL,
  `value_credit` double DEFAULT NULL,
  `value_null` double DEFAULT NULL,
  `value_sangria` double DEFAULT NULL,
  `dia` varchar(10) DEFAULT NULL,
  `mes` varchar(10) DEFAULT NULL,
  `ano` varchar(10) DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1
        ";

        $table49 = "
CREATE TABLE IF NOT EXISTS `sd_guid` (
  `id` double UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `id_db_settings` double DEFAULT NULL,
  `id_customer` double DEFAULT NULL,
  `id_invoice` double DEFAULT NULL,
  `session_id` double DEFAULT NULL,
  `numero` double DEFAULT NULL,
  `method` varchar(255) DEFAULT NULL,
  `dia` varchar(255) DEFAULT NULL,
  `mes` varchar(255) DEFAULT NULL,
  `ano` varchar(255) DEFAULT NULL,
  `hora` varchar(255) DEFAULT NULL,
  `Invoice` varchar(255) DEFAULT NULL,
  `InvoiceType` varchar(255) DEFAULT NULL,
  `hash` varchar(255) DEFAULT NULL,
  `TaxPointDate` varchar(255) DEFAULT NULL,
  `SourceBilling` varchar(5) DEFAULT NULL,
  `Code` varchar(255) DEFAULT NULL,
  `customer_name` varchar(255) DEFAULT NULL,
  `customer_nif` varchar(255) DEFAULT NULL,
  `customer_email` varchar(255) DEFAULT NULL,
  `customer_telefone` varchar(255) DEFAULT NULL,
  `customer_endereco` varchar(255) DEFAULT NULL,
  `settings_empresa` varchar(255) DEFAULT NULL,
  `settings_nif` varchar(255) DEFAULT NULL,
  `settings_endereco` varchar(255) DEFAULT NULL,
  `settings_telefone` varchar(255) DEFAULT NULL,
  `settings_email` varchar(255) DEFAULT NULL,
  `settings_nib` varchar(255) DEFAULT NULL,
  `settings_swift` varchar(255) DEFAULT NULL,
  `settings_city` varchar(255) DEFAULT NULL,
  `settings_iban` varchar(255) DEFAULT NULL,
  `settings_logotype` varchar(500) DEFAULT NULL,
  `settings_website` varchar(255) DEFAULT NULL,
  `settings_taxEntity` varchar(255) DEFAULT NULL,
  `settings_rodape` varchar(255) DEFAULT NULL,
  `settings_coordenadas` longtext DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `date_expiration` varchar(50) DEFAULT NULL,
  `timer` varchar(50) DEFAULT NULL,
  `settings_moeda` varchar(50) DEFAULT NULL,
  `settings_info` varchar(50) DEFAULT NULL,
  `r` double DEFAULT NULL,
  `f` double DEFAULT NULL,
  `box_in` int(11) DEFAULT NULL,
  `InvoiceDate` varchar(120) DEFAULT NULL,
  `settings_desc_financ` double DEFAULT NULL,
  `guid_endereco` varchar(255) DEFAULT NULL,
  `guid_name` varchar(255) DEFAULT NULL,
  `guid_city` varchar(255) DEFAULT NULL,
  `guid_postal` varchar(255) DEFAULT NULL,
  `guid_matricula` varchar(255) DEFAULT NULL,
  `guid_obs` varchar(255) DEFAULT NULL,
  `id_garcom` double DEFAULT NULL,
  `hashcontrol` varchar(70) DEFAULT NULL,
  `settings_banco` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1
        ";

        $table50 = "
CREATE TABLE IF NOT EXISTS `sd_guid_pmp` (
  `id` double UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `id_db_settings` double NOT NULL,
  `id_product` double NOT NULL,
  `id_invoice` double NOT NULL,
  `session_id` double NOT NULL,
  `numero` double NOT NULL,
  `quantidade_pmp` double DEFAULT NULL,
  `preco_pmp` double DEFAULT NULL,
  `desconto_pmp` float DEFAULT NULL,
  `taxa` float DEFAULT NULL,
  `TaxExemptionReason` varchar(255) DEFAULT NULL,
  `TaxExemptionCode` varchar(255) DEFAULT NULL,
  `taxCode` varchar(255) DEFAULT NULL,
  `taxType` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `taxAmount` varchar(255) DEFAULT NULL,
  `TaxCountryRegion` varchar(255) DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `product_code` varchar(255) DEFAULT NULL,
  `product_list` varchar(255) DEFAULT NULL,
  `product_uni` varchar(255) DEFAULT NULL,
  `Invoice` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `SourceBilling` varchar(5) DEFAULT NULL,
  `InvoiceType` varchar(50) DEFAULT NULL,
  `box_in` int(11) DEFAULT NULL,
  `product_type` varchar(20) DEFAULT NULL,
  `product_id_category` double DEFAULT NULL,
  `id_garcom` double DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1
        ";

        $table51 = "
CREATE TABLE IF NOT EXISTS `sd_purchase` (
  `id` double UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `id_db_settings` double DEFAULT NULL,
  `id_product` double DEFAULT NULL,
  `id_supplier` double DEFAULT NULL,
  `session_id` double DEFAULT NULL,
  `quantidade` double DEFAULT NULL,
  `unidade` double DEFAULT NULL,
  `preco_compra` double DEFAULT NULL,
  `data_lanca` varchar(50) DEFAULT NULL,
  `dia` varchar(10) DEFAULT NULL,
  `mes` varchar(10) DEFAULT NULL,
  `ano` varchar(10) DEFAULT NULL,
  `hora` varchar(25) DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL,
  `dateF` varchar(50) DEFAULT NULL,
  `dateEx` varchar(50) DEFAULT NULL,
  `status` varchar(5) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1
        ";

        $table52 = "
CREATE TABLE IF NOT EXISTS `sd_purchase_story` (
  `id` double UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `id_db_settings` double DEFAULT NULL,
  `session_id` double DEFAULT NULL,
  `id_sd_purchase` double DEFAULT NULL,
  `qtd` double DEFAULT NULL,
  `unidades` double DEFAULT NULL,
  `type` varchar(5) DEFAULT NULL,
  `date` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1
        ";

        $table53 = "
CREATE TABLE IF NOT EXISTS `sd_retification` (
  `id` double UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `id_db_settings` double NOT NULL,
  `id_customer` double NOT NULL,
  `id_invoice` double NOT NULL,
  `session_id` double NOT NULL,
  `numero` double NOT NULL,
  `method` varchar(255) NOT NULL,
  `dia` varchar(255) DEFAULT NULL,
  `mes` varchar(255) DEFAULT NULL,
  `ano` varchar(255) DEFAULT NULL,
  `hora` varchar(255) DEFAULT NULL,
  `Invoice` varchar(255) DEFAULT NULL,
  `InvoiceType` varchar(255) DEFAULT NULL,
  `hash` varchar(255) DEFAULT NULL,
  `TaxPointDate` varchar(255) DEFAULT NULL,
  `SourceBilling` varchar(5) DEFAULT NULL,
  `Code` varchar(255) DEFAULT NULL,
  `customer_name` varchar(255) DEFAULT NULL,
  `customer_nif` varchar(255) DEFAULT NULL,
  `customer_email` varchar(255) DEFAULT NULL,
  `customer_telefone` varchar(255) DEFAULT NULL,
  `customer_endereco` varchar(255) DEFAULT NULL,
  `settings_empresa` varchar(255) DEFAULT NULL,
  `settings_nif` varchar(255) DEFAULT NULL,
  `settings_endereco` varchar(255) DEFAULT NULL,
  `settings_telefone` varchar(255) DEFAULT NULL,
  `settings_email` varchar(255) DEFAULT NULL,
  `settings_nib` varchar(255) DEFAULT NULL,
  `settings_swift` varchar(255) DEFAULT NULL,
  `settings_city` varchar(255) DEFAULT NULL,
  `settings_iban` varchar(255) DEFAULT NULL,
  `settings_logotype` varchar(500) DEFAULT NULL,
  `settings_website` varchar(255) DEFAULT NULL,
  `settings_taxEntity` varchar(255) DEFAULT NULL,
  `settings_rodape` varchar(255) DEFAULT NULL,
  `settings_coordenadas` longtext DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `date_expiration` varchar(50) DEFAULT NULL,
  `timer` varchar(10) DEFAULT NULL,
  `settings_moeda` varchar(50) DEFAULT NULL,
  `settings_info` varchar(50) DEFAULT NULL,
  `r` double DEFAULT NULL,
  `f` double DEFAULT NULL,
  `box_in` int(11) DEFAULT NULL,
  `InvoiceDate` varchar(120) DEFAULT NULL,
  `settings_desc_financ` double DEFAULT NULL,
  `settings_doctype` varchar(255) DEFAULT NULL,
  `id_garcom` double DEFAULT NULL,
  `RetencaoDeFonte` double DEFAULT NULL,
  `IncluirNaFactura` int(11) DEFAULT NULL,
  `hashcontrol` varchar(70) DEFAULT NULL,
  `settings_banco` varchar(255) DEFAULT NULL, 
    `id_veiculos` varchar(255) DEFAULT NULL,
    `matriculas` varchar(255) DEFAULT NULL,
    `id_fabricante` varchar(255) DEFAULT NULL,
     `gallery_cover_1` varchar(500) DEFAULT NULL,
    `gallery_cover_2` varchar(500) DEFAULT NULL,
     `gallery_cover_3` varchar(500) DEFAULT NULL,
     `gallery_cover_4` varchar(500) DEFAULT NULL,
     `gallery_cover_5` varchar(500) DEFAULT NULL,
     `gallery_cover_6` varchar(500) DEFAULT NULL,
     `id_obs` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1
        ";

        $table54 = "
CREATE TABLE IF NOT EXISTS `sd_retification_pmp` (
  `id` double UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `id_db_settings` double NOT NULL,
  `id_product` double NOT NULL,
  `id_invoice` double NOT NULL,
  `session_id` double NOT NULL,
  `numero` double NOT NULL,
  `quantidade_pmp` double DEFAULT NULL,
  `preco_pmp` double DEFAULT NULL,
  `desconto_pmp` float DEFAULT NULL,
  `taxa` float DEFAULT NULL,
  `TaxExemptionReason` varchar(255) DEFAULT NULL,
  `TaxExemptionCode` varchar(255) DEFAULT NULL,
  `taxCode` varchar(255) DEFAULT NULL,
  `taxType` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `taxAmount` varchar(255) DEFAULT NULL,
  `TaxCountryRegion` varchar(255) DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `product_code` varchar(255) DEFAULT NULL,
  `product_list` varchar(255) DEFAULT NULL,
  `product_uni` varchar(255) DEFAULT NULL,
  `Invoice` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `SourceBilling` varchar(5) DEFAULT NULL,
  `InvoiceType` varchar(50) DEFAULT NULL,
  `box_in` int(11) DEFAULT NULL,
  `product_type` varchar(20) DEFAULT NULL,
  `product_id_category` double DEFAULT NULL,
  `id_garcom` double DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1
        ";

        $table55 = "
CREATE TABLE IF NOT EXISTS `sd_spending` (
  `id` double UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `id_db_settings` double DEFAULT NULL,
  `session_id` double DEFAULT NULL,
  `natureza` varchar(5) DEFAULT NULL,
  `quantidade` double DEFAULT NULL,
  `preco` double DEFAULT NULL,
  `descricao` varchar(255) DEFAULT NULL,
  `dia` varchar(5) DEFAULT NULL,
  `mes` varchar(5) DEFAULT NULL,
  `ano` varchar(5) DEFAULT NULL,
  `hora` varchar(25) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1
        ";

        $table56 = "
CREATE TABLE IF NOT EXISTS `site_views` (
  `id` double UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `s_date` varchar(255) NOT NULL,
  `users` varchar(255) NOT NULL,
  `views` varchar(255) NOT NULL,
  `pages` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1
        ";

        $table57 = "
CREATE TABLE IF NOT EXISTS `site_views_agent` (
  `id` double UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `name` varchar(255) NOT NULL,
  `views` double NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1
        ";

        $table58 = "
CREATE TABLE IF NOT EXISTS `site_views_online` (
  `id` double UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `session` varchar(200) NOT NULL,
  `startview` varchar(270) NOT NULL,
  `endview` varchar(270) NOT NULL,
  `server_ip` varchar(270) NOT NULL,
  `ip` varchar(270) NOT NULL,
  `url` varchar(270) NOT NULL,
  `agent` varchar(270) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1
        ";

        $table59 = "
CREATE TABLE IF NOT EXISTS `site_views_static` (
  `id` double UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `session` varchar(255) DEFAULT NULL,
  `startview` varchar(255) DEFAULT NULL,
  `endview` varchar(255) DEFAULT NULL,
  `server_ip` varchar(255) DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `agent` varchar(255) DEFAULT NULL,
  `dia` varchar(255) DEFAULT NULL,
  `mes` varchar(255) DEFAULT NULL,
  `ano` varchar(255) DEFAULT NULL,
  `hora` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1
        ";

        $table60 = "
CREATE TABLE IF NOT EXISTS `website_about` (
  `id` double UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `logotype` varchar(500) DEFAULT NULL,
  `titulo` varchar(300) DEFAULT NULL,
  `subtitulo` varchar(450) DEFAULT NULL,
  `content` longtext DEFAULT NULL,
  `data` varchar(50) DEFAULT NULL,
  `numeros_1` varchar(11) DEFAULT NULL,
  `numeros_descricao_1` varchar(150) DEFAULT NULL,
  `numeros_2` varchar(11) DEFAULT NULL,
  `numeros_descricao_2` varchar(150) DEFAULT NULL,
  `numeros_3` varchar(11) DEFAULT NULL,
  `numeros_descricao_3` varchar(150) DEFAULT NULL,
  `numeros_4` varchar(11) DEFAULT NULL,
  `numeros_descricao_4` varchar(150) DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4
        ";

        $table61 = "
CREATE TABLE IF NOT EXISTS `website_author` (
  `id` double UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `name` varchar(360) DEFAULT NULL,
  `logotype` varchar(500) DEFAULT NULL,
  `content` longtext DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `views` double DEFAULT NULL,
  `total_public` double DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `youtube` varchar(150) DEFAULT NULL,
  `facebook` varchar(150) DEFAULT NULL,
  `instagram` varchar(150) DEFAULT NULL,
  `twitter` varchar(150) DEFAULT NULL,
  `linkdin` varchar(150) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4
        ";

        $table62 = "
CREATE TABLE IF NOT EXISTS `website_blog` (
  `id` double UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `id_author` double DEFAULT NULL,
  `id_category` double DEFAULT NULL,
  `titulo` varchar(350) DEFAULT NULL,
  `subtitulo` varchar(500) DEFAULT NULL,
  `logotype` varchar(500) DEFAULT NULL,
  `content` longtext DEFAULT NULL,
  `views` double DEFAULT NULL,
  `likes` double DEFAULT NULL,
  `hora` varchar(30) DEFAULT NULL,
  `data` varchar(50) DEFAULT NULL,
  `status` varchar(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4
        ";

        $table63 = "
CREATE TABLE IF NOT EXISTS `website_blog_comment` (
  `id` double UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `id_blog` double DEFAULT NULL,
  `session_id` double DEFAULT NULL,
  `data` varchar(50) DEFAULT NULL,
  `hora` varchar(30) DEFAULT NULL,
  `content` longtext DEFAULT NULL,
  `views` double DEFAULT NULL,
  `likes` double DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4
        ";

        $table64 = "
CREATE TABLE IF NOT EXISTS `website_blog_gallery` (
  `id` double UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `id_blog` double DEFAULT NULL,
  `cover` varchar(500) DEFAULT NULL,
  `content` varchar(500) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `views` double DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4
        ";

        $table65 = "
CREATE TABLE IF NOT EXISTS `website_category` (
  `id` double UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `name` varchar(350) DEFAULT NULL,
  `content` longtext DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL,
  `views` double DEFAULT NULL,
  `logotype` varchar(500) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4
        ";

        $table66 = "
CREATE TABLE IF NOT EXISTS `website_count_blog_comment` (
  `id` double UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `id_blog` double DEFAULT NULL,
  `total` double DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4
        ";

        $table67 = "
CREATE TABLE IF NOT EXISTS `website_count_blog_likes` (
  `id` double UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `id_blog` double DEFAULT NULL,
  `total` double DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4
        ";

        $table68 = "
CREATE TABLE IF NOT EXISTS `website_faq` (
  `id` double UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `titulo` varchar(500) DEFAULT NULL,
  `content` longtext DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4
        ";

        $table69 = "
CREATE TABLE IF NOT EXISTS `website_gallery` (
  `id` double UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `logotype` varchar(500) DEFAULT NULL,
  `titulo` varchar(500) DEFAULT NULL,
  `subtitulo` varchar(500) DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4
        ";

        $table70 = "
CREATE TABLE IF NOT EXISTS `website_home` (
  `id` double UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `logotype` varchar(500) DEFAULT NULL,
  `titulo` varchar(350) DEFAULT NULL,
  `subtitulo` varchar(300) DEFAULT NULL,
  `link` varchar(350) DEFAULT NULL,
  `content` longtext DEFAULT NULL,
  `data` varchar(50) DEFAULT NULL,
  `status` varchar(5) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4
        ";

        $table71 = "
CREATE TABLE IF NOT EXISTS `website_pricing` (
  `id` double UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `pacote` varchar(500) DEFAULT NULL,
  `preco` varchar(300) DEFAULT NULL,
  `content` longtext DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4
        ";

        $table72 = "
CREATE TABLE IF NOT EXISTS `website_services` (
  `id` double UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `logotype` varchar(500) DEFAULT NULL,
  `titulo` varchar(300) DEFAULT NULL,
  `subtitulo` varchar(500) DEFAULT NULL,
  `content` longtext DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4
        ";

        $table73 = "
CREATE TABLE IF NOT EXISTS `website_team` (
  `id` double UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `name` varchar(300) DEFAULT NULL,
  `cargo` varchar(150) DEFAULT NULL,
  `logotype` varchar(500) DEFAULT NULL,
  `content` longtext DEFAULT NULL,
  `linkdin` varchar(150) DEFAULT NULL,
  `youtube` varchar(150) DEFAULT NULL,
  `facebook` varchar(150) DEFAULT NULL,
  `instagram` varchar(150) DEFAULT NULL,
  `twitter` varchar(150) DEFAULT NULL,
  `views` double DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4
        ";

        $table74 = "
CREATE TABLE IF NOT EXISTS `ws_alerts` (
  `id` double UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `email_users` longtext DEFAULT NULL,
  `email_customers` longtext DEFAULT NULL,
  `email_settings` longtext DEFAULT NULL,
  `email_suppliers` longtext DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1
        ";

        $table75 = "
CREATE TABLE IF NOT EXISTS `ws_msg` (
  `id` double UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `de` double DEFAULT NULL,
  `para` double DEFAULT NULL,
  `msg` longtext DEFAULT NULL,
  `hora` varchar(30) DEFAULT NULL,
  `data` varchar(50) DEFAULT NULL,
  `lido` int(11) DEFAULT NULL,
  `dia` varchar(3) DEFAULT NULL,
  `mes` varchar(3) DEFAULT NULL,
  `ano` varchar(5) DEFAULT NULL,
  `min` varchar(3) DEFAULT NULL,
  `seg` varchar(3) DEFAULT NULL,
  `hor` varchar(3) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1
        ";

        $table76 = "
CREATE TABLE IF NOT EXISTS `ws_services` (
  `id` double UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `content` longtext DEFAULT NULL,
  `data` varchar(50) DEFAULT NULL,
  `cover` varchar(500) DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1
        ";

        $table77 = "
CREATE TABLE IF NOT EXISTS `ws_streaming` (
  `id` double UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `video` varchar(500) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `status` varchar(5) DEFAULT NULL,
  `data` varchar(25) DEFAULT NULL,
  `hora` varchar(25) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1
        ";

        $table78 = "
CREATE TABLE IF NOT EXISTS `ws_times` (
  `id` double UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `id_db_kwanzar` double DEFAULT NULL,
  `times` varchar(225) DEFAULT NULL,
  `ps3` varchar(10) DEFAULT NULL,
  `postos` varchar(30) DEFAULT NULL,
  `users` varchar(30) DEFAULT NULL,
  `dia` varchar(10) DEFAULT NULL,
  `mes` varchar(10) DEFAULT NULL,
  `ano` varchar(10) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `saldo` varchar(255) DEFAULT NULL,
  `documentos` varchar(255) DEFAULT NULL,
  `documentos_feito` varchar(255) DEFAULT NULL,
  `pricing` varchar(255) DEFAULT NULL,
  `total` varchar(255) DEFAULT NULL,
  `users_de` varchar(255) DEFAULT NULL,
  `plano` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1
        ";

        $table79 = "
CREATE TABLE IF NOT EXISTS `ws_times_backup` (
  `id` double UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `id_db_kwanzar` double DEFAULT NULL,
  `times` varchar(255) DEFAULT NULL,
  `ps3` varchar(255) DEFAULT NULL,
  `postos` varchar(255) DEFAULT NULL,
  `users` varchar(255) DEFAULT NULL,
  `dia` varchar(255) DEFAULT NULL,
  `mes` varchar(255) DEFAULT NULL,
  `ano` varchar(255) DEFAULT NULL,
  `saldo` varchar(255) DEFAULT NULL,
  `documentos` varchar(255) DEFAULT NULL,
  `pricing` varchar(255) DEFAULT NULL,
  `total` varchar(255) DEFAULT NULL,
  `data` varchar(255) DEFAULT NULL,
  `hora` varchar(255) DEFAULT NULL,
  `plano` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1
        ";

        $table80 = "
CREATE TABLE IF NOT EXISTS `z_config` (
  `id` double UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `color_1` varchar(500) DEFAULT NULL,
  `color_2` varchar(500) DEFAULT NULL,
  `color_3` varchar(500) DEFAULT NULL,
  `name` varchar(500) DEFAULT NULL,
  `logotype` varchar(500) DEFAULT NULL,
  `telefone` varchar(150) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `endereco` varchar(500) DEFAULT NULL,
  `website` varchar(150) DEFAULT NULL,
  `hora` varchar(50) DEFAULT NULL,
  `data` varchar(50) DEFAULT NULL,
  `agt` varchar(50) DEFAULT NULL,
  `iso` varchar(50) DEFAULT NULL,
  `versao` varchar(50) DEFAULT NULL,
  `color_41` varchar(111) DEFAULT NULL,
  `color_42` varchar(111) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
        ";

        $table81 = "
CREATE TABLE IF NOT EXISTS `z_security` (
                `id` double UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
                `plano` varchar(225) DEFAULT NULL,
                `documentos` varchar(225) DEFAULT NULL,
                `usuarios` varchar(225) DEFAULT NULL,
                `modulos` varchar(225) DEFAULT NULL,
                `empresas` varchar(225) DEFAULT NULL,
                `valor` varchar(225) DEFAULT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
        ";

        $table82 = "
CREATE TABLE IF NOT EXISTS `db_settings_all_in_one` (
                `id` double UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
                `id_db_settings` double DEFAULT NULL,
                `total` double DEFAULT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
        ";

        $table83 = "
CREATE TABLE IF NOT EXISTS `db_users_all_in_one` (
                `id` double UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
                `session_id` double DEFAULT NULL,
                `total` double DEFAULT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
        ";

        $table84 = "
CREATE TABLE IF NOT EXISTS `p_type` (
                `id` double UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
                `id_db_settings` double NOT NULL,
                `nome` varchar(255) DEFAULT NULL,
                `descricao` varchar(255) DEFAULT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
        ";

        $table85 = "
        CREATE TABLE IF NOT EXISTS `p_table` (
                `id` double UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
                `id_db_settings` double DEFAULT NULL,
                `session_id` double DEFAULT NULL,
                `id_type` double DEFAULT NULL,
                `nome` varchar(255) DEFAULT NULL,
                 `referencia` varchar(255) DEFAULT NULL,
                 `marca` varchar(255) DEFAULT NULL,
                 `modelo` varchar(255) DEFAULT NULL, 
                 `time_last` varchar(255) DEFAULT NULL,
                 `data_last` varchar(255) DEFAULT NULL,
                 `data` varchar(255) DEFAULT NULL,
                 `hora` varchar(255) DEFAULT NULL,
                 `preco` varchar(255) DEFAULT NULL,
                `status` varchar(5) DEFAULT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
        ";

        $table86 = "
        CREATE TABLE IF NOT EXISTS `p_local` (
                `id` double UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
                `id_db_settings` double DEFAULT NULL,
                `nome` varchar(255) DEFAULT NULL,
                 `escritorio` varchar(255) DEFAULT NULL,
                `n_patrimonio` varchar(255) DEFAULT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
        ";

        $table87 = "
        CREATE TABLE IF NOT EXISTS `p_funcionario` (
                `id` double UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
                `id_db_settings` double DEFAULT NULL,
                `nome` varchar(255) DEFAULT NULL,
                `telefone` varchar(255) DEFAULT NULL,
                `email` varchar(255) DEFAULT NULL,
                `endereco` varchar(255) DEFAULT NULL,
                 `sexo` varchar(15) DEFAULT NULL,
                 `bi` varchar(160) DEFAULT NULL,
                 `departamento`  varchar(255) DEFAULT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
        ";

        $table88 = "
        CREATE TABLE IF NOT EXISTS `p_atribuicoes` (
                `id` double UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
                `id_db_settings` double DEFAULT NULL,
                `session_id` double DEFAULT NULL,
                `id_local` double DEFAULT NULL,
                `id_funcionario` double DEFAULT NULL,
                `id_table` double DEFAULT NULL,
                `data` varchar(35) DEFAULT NULL,
                `hora` varchar(25) DEFAULT NULL,
                 `descricao` longtext DEFAULT NULL,
                 `status` varchar(5) DEFAULT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
        ";

        $table89 = "
        CREATE TABLE IF NOT EXISTS `db_settings_gallery` (
                `id` double UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
                `id_db_settings` double DEFAULT NULL,
                `id_db_kwanzar` double DEFAULT NULL,
                `cover` varchar(500) DEFAULT NULL,
                `data` varchar(110) DEFAULT NULL,
                `hora` varchar(110) DEFAULT NULL,
                 `status` int(11) DEFAULT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
        ";

        $table90 = "
        CREATE TABLE IF NOT EXISTS `cv_obs` (
                `id` double UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
                `id_db_settings` double DEFAULT NULL,
                `nome` varchar(255) DEFAULT NULL,
                `data` varchar(255) DEFAULT NULL,
                 `status` int(11) DEFAULT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
        ";

        if(mysqli_query($this->Conn, $table1)):
            if(mysqli_query($this->Conn, $table2)):
                if(mysqli_query($this->Conn, $table3)):
                    if(mysqli_query($this->Conn, $table4)):
                        if(mysqli_query($this->Conn, $table5)):
                            if(mysqli_query($this->Conn, $table6)):
                                if(mysqli_query($this->Conn, $table7)):
                                    if(mysqli_query($this->Conn, $table8)):
                                        if(mysqli_query($this->Conn, $table9)):
                                            if(mysqli_query($this->Conn, $table10)):
                                                if(mysqli_query($this->Conn, $table11)):
                                                    if(mysqli_query($this->Conn, $table12)):
                                                        if(mysqli_query($this->Conn, $table13)):
                                                            if(mysqli_query($this->Conn, $table14)):
                                                                if(mysqli_query($this->Conn, $table15)):
                                                                    if(mysqli_query($this->Conn, $table16)):
                                                                        if(mysqli_query($this->Conn, $table17)):
                                                                            if(mysqli_query($this->Conn, $table18)):
                                                                                if(mysqli_query($this->Conn, $table19)):
                                                                                    if(mysqli_query($this->Conn, $table20)):
                                                                                        if(mysqli_query($this->Conn, $table21)):
                                                                                            if(mysqli_query($this->Conn, $table22)):
                                                                                                if(mysqli_query($this->Conn, $table23)):
                                                                                                    if(mysqli_query($this->Conn, $table24)):
                                                                                                        if(mysqli_query($this->Conn, $table25)):
                                                                                                            if(mysqli_query($this->Conn, $table26)):
                                                                                                                if(mysqli_query($this->Conn, $table27)):
                                                                                                                    if(mysqli_query($this->Conn, $table28)):
                                                                                                                        if(mysqli_query($this->Conn, $table29)):
                                                                                                                            if(mysqli_query($this->Conn, $table30)):
                                                                                                                                if(mysqli_query($this->Conn, $table31)):
                                                                                                                                    if(mysqli_query($this->Conn, $table32)):
                                                                                                                                        if(mysqli_query($this->Conn, $table33)):
                                                                                                                                            if(mysqli_query($this->Conn, $table34)):
                                                                                                                                                if(mysqli_query($this->Conn, $table35)):
                                                                                                                                                    if(mysqli_query($this->Conn, $table36)):
                                                                                                                                                        if(mysqli_query($this->Conn, $table37)):
                                                                                                                                                            if(mysqli_query($this->Conn, $table38)):
                                                                                                                                                                if(mysqli_query($this->Conn, $table39)):
                                                                                                                                                                    if(mysqli_query($this->Conn, $table40)):
                                                                                                                                                                        if(mysqli_query($this->Conn, $table41)):
                                                                                                                                                                            if(mysqli_query($this->Conn, $table42)):
                                                                                                                                                                                if(mysqli_query($this->Conn, $table43)):
                                                                                                                                                                                    if(mysqli_query($this->Conn, $table44)):
                                                                                                                                                                                        if(mysqli_query($this->Conn, $table45)):
                                                                                                                                                                                            if(mysqli_query($this->Conn, $table46)):
                                                                                                                                                                                                if(mysqli_query($this->Conn, $table47)):
                                                                                                                                                                                                    if(mysqli_query($this->Conn, $table48)):
                                                                                                                                                                                                        if(mysqli_query($this->Conn, $table49)):
                                                                                                                                                                                                            if(mysqli_query($this->Conn, $table50)):
                                                                                                                                                                                                                if(mysqli_query($this->Conn, $table51)):
                                                                                                                                                                                                                    if(mysqli_query($this->Conn, $table52)):
                                                                                                                                                                                                                        if(mysqli_query($this->Conn, $table53)):
                                                                                                                                                                                                                            if(mysqli_query($this->Conn, $table54)):
                                                                                                                                                                                                                                if(mysqli_query($this->Conn, $table55)):
                                                                                                                                                                                                                                    if(mysqli_query($this->Conn, $table56)):
                                                                                                                                                                                                                                        if(mysqli_query($this->Conn, $table57)):
                                                                                                                                                                                                                                            if(mysqli_query($this->Conn, $table58)):
                                                                                                                                                                                                                                                if(mysqli_query($this->Conn, $table59)):
                                                                                                                                                                                                                                                    if(mysqli_query($this->Conn, $table60)):
                                                                                                                                                                                                                                                        if(mysqli_query($this->Conn, $table61)):
                                                                                                                                                                                                                                                            if(mysqli_query($this->Conn, $table62)):
                                                                                                                                                                                                                                                                if(mysqli_query($this->Conn, $table63)):
                                                                                                                                                                                                                                                                    if(mysqli_query($this->Conn, $table64)):
                                                                                                                                                                                                                                                                        if(mysqli_query($this->Conn, $table65)):
                                                                                                                                                                                                                                                                            if(mysqli_query($this->Conn, $table66)):
                                                                                                                                                                                                                                                                                if(mysqli_query($this->Conn, $table67)):
                                                                                                                                                                                                                                                                                    if(mysqli_query($this->Conn, $table68)):
                                                                                                                                                                                                                                                                                        if(mysqli_query($this->Conn, $table69)):
                                                                                                                                                                                                                                                                                            if(mysqli_query($this->Conn, $table70)):
                                                                                                                                                                                                                                                                                                if(mysqli_query($this->Conn, $table71)):
                                                                                                                                                                                                                                                                                                    if(mysqli_query($this->Conn, $table72)):
                                                                                                                                                                                                                                                                                                        if(mysqli_query($this->Conn, $table73)):
                                                                                                                                                                                                                                                                                                            if(mysqli_query($this->Conn, $table74)):
                                                                                                                                                                                                                                                                                                                if(mysqli_query($this->Conn, $table75)):
                                                                                                                                                                                                                                                                                                                    if(mysqli_query($this->Conn, $table76)):
                                                                                                                                                                                                                                                                                                                        if(mysqli_query($this->Conn, $table77)):
                                                                                                                                                                                                                                                                                                                            if(mysqli_query($this->Conn, $table78)):
                                                                                                                                                                                                                                                                                                                                if(mysqli_query($this->Conn, $table79)):
                                                                                                                                                                                                                                                                                                                                    if(mysqli_query($this->Conn, $table80)):
                                                                                                                                                                                                                                                                                                                                        if(mysqli_query($this->Conn, $table81)):
                                                                                                                                                                                                                                                                                                                                            if(mysqli_query($this->Conn, $table82)):
                                                                                                                                                                                                                                                                                                                                                if(mysqli_query($this->Conn, $table83)):
                                                                                                                                                                                                                                                                                                                                                    if(mysqli_query($this->Conn, $table84)):
                                                                                                                                                                                                                                                                                                                                                        if(mysqli_query($this->Conn, $table85)):
                                                                                                                                                                                                                                                                                                                                                            if(mysqli_query($this->Conn, $table86)):
                                                                                                                                                                                                                                                                                                                                                                if(mysqli_query($this->Conn, $table87)):
                                                                                                                                                                                                                                                                                                                                                                    if(mysqli_query($this->Conn, $table88)):
                                                                                                                                                                                                                                                                                                                                                                        if(mysqli_query($this->Conn, $table89)):
                                                                                                                                                                                                                                                                                                                                                                            if(mysqli_query($this->Conn, $table90)):
                                                                                                                                                                                                                                                                                                                                                                                $this->Result = true;
                                                                                                                                                                                                                                                                                                                                                                                $this->Error  = "Banco de dados criado com sucesso!";
                                                                                                                                                                                                                                                                                                                                                                            else:
                                                                                                                                                                                                                                                                                                                                                                                $this->Result = false;
                                                                                                                                                                                                                                                                                                                                                                                $this->Error  = "Erro ao criar tabela no banco de dados (1): {$this->Conn->error}";
                                                                                                                                                                                                                                                                                                                                                                            endif;
                                                                                                                                                                                                                                                                                                                                                                        else:
                                                                                                                                                                                                                                                                                                                                                                            $this->Result = false;
                                                                                                                                                                                                                                                                                                                                                                            $this->Error  = "Erro ao criar tabela no banco de dados (1): {$this->Conn->error}";
                                                                                                                                                                                                                                                                                                                                                                        endif;
                                                                                                                                                                                                                                                                                                                                                                    else:
                                                                                                                                                                                                                                                                                                                                                                        $this->Result = false;
                                                                                                                                                                                                                                                                                                                                                                        $this->Error  = "Erro ao criar tabela no banco de dados (1): {$this->Conn->error}";
                                                                                                                                                                                                                                                                                                                                                                    endif;
                                                                                                                                                                                                                                                                                                                                                                else:
                                                                                                                                                                                                                                                                                                                                                                    $this->Result = false;
                                                                                                                                                                                                                                                                                                                                                                    $this->Error  = "Erro ao criar tabela no banco de dados (1): {$this->Conn->error}";
                                                                                                                                                                                                                                                                                                                                                                endif;
                                                                                                                                                                                                                                                                                                                                                            else:
                                                                                                                                                                                                                                                                                                                                                                $this->Result = false;
                                                                                                                                                                                                                                                                                                                                                                $this->Error  = "Erro ao criar tabela no banco de dados (1): {$this->Conn->error}";
                                                                                                                                                                                                                                                                                                                                                            endif;
                                                                                                                                                                                                                                                                                                                                                        else:
                                                                                                                                                                                                                                                                                                                                                            $this->Result = false;
                                                                                                                                                                                                                                                                                                                                                            $this->Error  = "Erro ao criar tabela no banco de dados (1): {$this->Conn->error}";
                                                                                                                                                                                                                                                                                                                                                        endif;
                                                                                                                                                                                                                                                                                                                                                    else:
                                                                                                                                                                                                                                                                                                                                                        $this->Result = false;
                                                                                                                                                                                                                                                                                                                                                        $this->Error  = "Erro ao criar tabela no banco de dados (1): {$this->Conn->error}";
                                                                                                                                                                                                                                                                                                                                                    endif;
                                                                                                                                                                                                                                                                                                                                                else:
                                                                                                                                                                                                                                                                                                                                                    $this->Result = false;
                                                                                                                                                                                                                                                                                                                                                    $this->Error  = "Erro ao criar tabela no banco de dados (1): {$this->Conn->error}";
                                                                                                                                                                                                                                                                                                                                                endif;
                                                                                                                                                                                                                                                                                                                                            else:
                                                                                                                                                                                                                                                                                                                                                $this->Result = false;
                                                                                                                                                                                                                                                                                                                                                $this->Error  = "Erro ao criar tabela no banco de dados (1): {$this->Conn->error}";
                                                                                                                                                                                                                                                                                                                                            endif;
                                                                                                                                                                                                                                                                                                                                        else:
                                                                                                                                                                                                                                                                                                                                            $this->Result = false;
                                                                                                                                                                                                                                                                                                                                            $this->Error  = "Erro ao criar tabela no banco de dados (1): {$this->Conn->error}";
                                                                                                                                                                                                                                                                                                                                        endif;
                                                                                                                                                                                                                                                                                                                                    else:
                                                                                                                                                                                                                                                                                                                                        $this->Result = false;
                                                                                                                                                                                                                                                                                                                                        $this->Error  = "Erro ao criar tabela no banco de dados (1): {$this->Conn->error}";
                                                                                                                                                                                                                                                                                                                                    endif;
                                                                                                                                                                                                                                                                                                                                else:
                                                                                                                                                                                                                                                                                                                                    $this->Result = false;
                                                                                                                                                                                                                                                                                                                                    $this->Error  = "Erro ao criar tabela no banco de dados (1): {$this->Conn->error}";
                                                                                                                                                                                                                                                                                                                                endif;
                                                                                                                                                                                                                                                                                                                            else:
                                                                                                                                                                                                                                                                                                                                $this->Result = false;
                                                                                                                                                                                                                                                                                                                                $this->Error  = "Erro ao criar tabela no banco de dados (1): {$this->Conn->error}";
                                                                                                                                                                                                                                                                                                                            endif;
                                                                                                                                                                                                                                                                                                                        else:
                                                                                                                                                                                                                                                                                                                            $this->Result = false;
                                                                                                                                                                                                                                                                                                                            $this->Error  = "Erro ao criar tabela no banco de dados (1): {$this->Conn->error}";
                                                                                                                                                                                                                                                                                                                        endif;
                                                                                                                                                                                                                                                                                                                    else:
                                                                                                                                                                                                                                                                                                                        $this->Result = false;
                                                                                                                                                                                                                                                                                                                        $this->Error  = "Erro ao criar tabela no banco de dados (1): {$this->Conn->error}";
                                                                                                                                                                                                                                                                                                                    endif;
                                                                                                                                                                                                                                                                                                                else:
                                                                                                                                                                                                                                                                                                                    $this->Result = false;
                                                                                                                                                                                                                                                                                                                    $this->Error  = "Erro ao criar tabela no banco de dados (1): {$this->Conn->error}";
                                                                                                                                                                                                                                                                                                                endif;
                                                                                                                                                                                                                                                                                                            else:
                                                                                                                                                                                                                                                                                                                $this->Result = false;
                                                                                                                                                                                                                                                                                                                $this->Error  = "Erro ao criar tabela no banco de dados (1): {$this->Conn->error}";
                                                                                                                                                                                                                                                                                                            endif;
                                                                                                                                                                                                                                                                                                        else:
                                                                                                                                                                                                                                                                                                            $this->Result = false;
                                                                                                                                                                                                                                                                                                            $this->Error  = "Erro ao criar tabela no banco de dados (1): {$this->Conn->error}";
                                                                                                                                                                                                                                                                                                        endif;
                                                                                                                                                                                                                                                                                                    else:
                                                                                                                                                                                                                                                                                                        $this->Result = false;
                                                                                                                                                                                                                                                                                                        $this->Error  = "Erro ao criar tabela no banco de dados (1): {$this->Conn->error}";
                                                                                                                                                                                                                                                                                                    endif;
                                                                                                                                                                                                                                                                                                else:
                                                                                                                                                                                                                                                                                                    $this->Result = false;
                                                                                                                                                                                                                                                                                                    $this->Error  = "Erro ao criar tabela no banco de dados (1): {$this->Conn->error}";
                                                                                                                                                                                                                                                                                                endif;
                                                                                                                                                                                                                                                                                            else:
                                                                                                                                                                                                                                                                                                $this->Result = false;
                                                                                                                                                                                                                                                                                                $this->Error  = "Erro ao criar tabela no banco de dados (1): {$this->Conn->error}";
                                                                                                                                                                                                                                                                                            endif;
                                                                                                                                                                                                                                                                                        else:
                                                                                                                                                                                                                                                                                            $this->Result = false;
                                                                                                                                                                                                                                                                                            $this->Error  = "Erro ao criar tabela no banco de dados (1): {$this->Conn->error}";
                                                                                                                                                                                                                                                                                        endif;
                                                                                                                                                                                                                                                                                    else:
                                                                                                                                                                                                                                                                                        $this->Result = false;
                                                                                                                                                                                                                                                                                        $this->Error  = "Erro ao criar tabela no banco de dados (1): {$this->Conn->error}";
                                                                                                                                                                                                                                                                                    endif;
                                                                                                                                                                                                                                                                                else:
                                                                                                                                                                                                                                                                                    $this->Result = false;
                                                                                                                                                                                                                                                                                    $this->Error  = "Erro ao criar tabela no banco de dados (1): {$this->Conn->error}";
                                                                                                                                                                                                                                                                                endif;
                                                                                                                                                                                                                                                                            else:
                                                                                                                                                                                                                                                                                $this->Result = false;
                                                                                                                                                                                                                                                                                $this->Error  = "Erro ao criar tabela no banco de dados (1): {$this->Conn->error}";
                                                                                                                                                                                                                                                                            endif;
                                                                                                                                                                                                                                                                        else:
                                                                                                                                                                                                                                                                            $this->Result = false;
                                                                                                                                                                                                                                                                            $this->Error  = "Erro ao criar tabela no banco de dados (1): {$this->Conn->error}";
                                                                                                                                                                                                                                                                        endif;
                                                                                                                                                                                                                                                                    else:
                                                                                                                                                                                                                                                                        $this->Result = false;
                                                                                                                                                                                                                                                                        $this->Error  = "Erro ao criar tabela no banco de dados (1): {$this->Conn->error}";
                                                                                                                                                                                                                                                                    endif;
                                                                                                                                                                                                                                                                else:
                                                                                                                                                                                                                                                                    $this->Result = false;
                                                                                                                                                                                                                                                                    $this->Error  = "Erro ao criar tabela no banco de dados (1): {$this->Conn->error}";
                                                                                                                                                                                                                                                                endif;
                                                                                                                                                                                                                                                            else:
                                                                                                                                                                                                                                                                $this->Result = false;
                                                                                                                                                                                                                                                                $this->Error  = "Erro ao criar tabela no banco de dados (1): {$this->Conn->error}";
                                                                                                                                                                                                                                                            endif;
                                                                                                                                                                                                                                                        else:
                                                                                                                                                                                                                                                            $this->Result = false;
                                                                                                                                                                                                                                                            $this->Error  = "Erro ao criar tabela no banco de dados (1): {$this->Conn->error}";
                                                                                                                                                                                                                                                        endif;
                                                                                                                                                                                                                                                    else:
                                                                                                                                                                                                                                                        $this->Result = false;
                                                                                                                                                                                                                                                        $this->Error  = "Erro ao criar tabela no banco de dados (1): {$this->Conn->error}";
                                                                                                                                                                                                                                                    endif;
                                                                                                                                                                                                                                                else:
                                                                                                                                                                                                                                                    $this->Result = false;
                                                                                                                                                                                                                                                    $this->Error  = "Erro ao criar tabela no banco de dados (1): {$this->Conn->error}";
                                                                                                                                                                                                                                                endif;
                                                                                                                                                                                                                                            else:
                                                                                                                                                                                                                                                $this->Result = false;
                                                                                                                                                                                                                                                $this->Error  = "Erro ao criar tabela no banco de dados (1): {$this->Conn->error}";
                                                                                                                                                                                                                                            endif;
                                                                                                                                                                                                                                        else:
                                                                                                                                                                                                                                            $this->Result = false;
                                                                                                                                                                                                                                            $this->Error  = "Erro ao criar tabela no banco de dados (1): {$this->Conn->error}";
                                                                                                                                                                                                                                        endif;
                                                                                                                                                                                                                                    else:
                                                                                                                                                                                                                                        $this->Result = false;
                                                                                                                                                                                                                                        $this->Error  = "Erro ao criar tabela no banco de dados (1): {$this->Conn->error}";
                                                                                                                                                                                                                                    endif;
                                                                                                                                                                                                                                else:
                                                                                                                                                                                                                                    $this->Result = false;
                                                                                                                                                                                                                                    $this->Error  = "Erro ao criar tabela no banco de dados (1): {$this->Conn->error}";
                                                                                                                                                                                                                                endif;
                                                                                                                                                                                                                            else:
                                                                                                                                                                                                                                $this->Result = false;
                                                                                                                                                                                                                                $this->Error  = "Erro ao criar tabela no banco de dados (1): {$this->Conn->error}";
                                                                                                                                                                                                                            endif;
                                                                                                                                                                                                                        else:
                                                                                                                                                                                                                            $this->Result = false;
                                                                                                                                                                                                                            $this->Error  = "Erro ao criar tabela no banco de dados (1): {$this->Conn->error}";
                                                                                                                                                                                                                        endif;
                                                                                                                                                                                                                    else:
                                                                                                                                                                                                                        $this->Result = false;
                                                                                                                                                                                                                        $this->Error  = "Erro ao criar tabela no banco de dados (1): {$this->Conn->error}";
                                                                                                                                                                                                                    endif;
                                                                                                                                                                                                                else:
                                                                                                                                                                                                                    $this->Result = false;
                                                                                                                                                                                                                    $this->Error  = "Erro ao criar tabela no banco de dados (1): {$this->Conn->error}";
                                                                                                                                                                                                                endif;
                                                                                                                                                                                                            else:
                                                                                                                                                                                                                $this->Result = false;
                                                                                                                                                                                                                $this->Error  = "Erro ao criar tabela no banco de dados (1): {$this->Conn->error}";
                                                                                                                                                                                                            endif;
                                                                                                                                                                                                        else:
                                                                                                                                                                                                            $this->Result = false;
                                                                                                                                                                                                            $this->Error  = "Erro ao criar tabela no banco de dados (1): {$this->Conn->error}";
                                                                                                                                                                                                        endif;
                                                                                                                                                                                                    else:
                                                                                                                                                                                                        $this->Result = false;
                                                                                                                                                                                                        $this->Error  = "Erro ao criar tabela no banco de dados (1): {$this->Conn->error}";
                                                                                                                                                                                                    endif;
                                                                                                                                                                                                else:
                                                                                                                                                                                                    $this->Result = false;
                                                                                                                                                                                                    $this->Error  = "Erro ao criar tabela no banco de dados (1): {$this->Conn->error}";
                                                                                                                                                                                                endif;
                                                                                                                                                                                            else:
                                                                                                                                                                                                $this->Result = false;
                                                                                                                                                                                                $this->Error  = "Erro ao criar tabela no banco de dados (1): {$this->Conn->error}";
                                                                                                                                                                                            endif;
                                                                                                                                                                                        else:
                                                                                                                                                                                            $this->Result = false;
                                                                                                                                                                                            $this->Error  = "Erro ao criar tabela no banco de dados (1): {$this->Conn->error}";
                                                                                                                                                                                        endif;
                                                                                                                                                                                    else:
                                                                                                                                                                                        $this->Result = false;
                                                                                                                                                                                        $this->Error  = "Erro ao criar tabela no banco de dados (1): {$this->Conn->error}";
                                                                                                                                                                                    endif;
                                                                                                                                                                                else:
                                                                                                                                                                                    $this->Result = false;
                                                                                                                                                                                    $this->Error  = "Erro ao criar tabela no banco de dados (1): {$this->Conn->error}";
                                                                                                                                                                                endif;
                                                                                                                                                                            else:
                                                                                                                                                                                $this->Result = false;
                                                                                                                                                                                $this->Error  = "Erro ao criar tabela no banco de dados (1): {$this->Conn->error}";
                                                                                                                                                                            endif;
                                                                                                                                                                        else:
                                                                                                                                                                            $this->Result = false;
                                                                                                                                                                            $this->Error  = "Erro ao criar tabela no banco de dados (1): {$this->Conn->error}";
                                                                                                                                                                        endif;
                                                                                                                                                                    else:
                                                                                                                                                                        $this->Result = false;
                                                                                                                                                                        $this->Error  = "Erro ao criar tabela no banco de dados (1): {$this->Conn->error}";
                                                                                                                                                                    endif;
                                                                                                                                                                else:
                                                                                                                                                                    $this->Result = false;
                                                                                                                                                                    $this->Error  = "Erro ao criar tabela no banco de dados (1): {$this->Conn->error}";
                                                                                                                                                                endif;
                                                                                                                                                            else:
                                                                                                                                                                $this->Result = false;
                                                                                                                                                                $this->Error  = "Erro ao criar tabela no banco de dados (1): {$this->Conn->error}";
                                                                                                                                                            endif;
                                                                                                                                                        else:
                                                                                                                                                            $this->Result = false;
                                                                                                                                                            $this->Error  = "Erro ao criar tabela no banco de dados (1): {$this->Conn->error}";
                                                                                                                                                        endif;
                                                                                                                                                    else:
                                                                                                                                                        $this->Result = false;
                                                                                                                                                        $this->Error  = "Erro ao criar tabela no banco de dados (1): {$this->Conn->error}";
                                                                                                                                                    endif;
                                                                                                                                                else:
                                                                                                                                                    $this->Result = false;
                                                                                                                                                    $this->Error  = "Erro ao criar tabela no banco de dados (1): {$this->Conn->error}";
                                                                                                                                                endif;
                                                                                                                                            else:
                                                                                                                                                $this->Result = false;
                                                                                                                                                $this->Error  = "Erro ao criar tabela no banco de dados (1): {$this->Conn->error}";
                                                                                                                                            endif;
                                                                                                                                        else:
                                                                                                                                            $this->Result = false;
                                                                                                                                            $this->Error  = "Erro ao criar tabela no banco de dados (1): {$this->Conn->error}";
                                                                                                                                        endif;
                                                                                                                                    else:
                                                                                                                                        $this->Result = false;
                                                                                                                                        $this->Error  = "Erro ao criar tabela no banco de dados (1): {$this->Conn->error}";
                                                                                                                                    endif;
                                                                                                                                else:
                                                                                                                                    $this->Result = false;
                                                                                                                                    $this->Error  = "Erro ao criar tabela no banco de dados (1): {$this->Conn->error}";
                                                                                                                                endif;
                                                                                                                            else:
                                                                                                                                $this->Result = false;
                                                                                                                                $this->Error  = "Erro ao criar tabela no banco de dados (1): {$this->Conn->error}";
                                                                                                                            endif;
                                                                                                                        else:
                                                                                                                            $this->Result = false;
                                                                                                                            $this->Error  = "Erro ao criar tabela no banco de dados (1): {$this->Conn->error}";
                                                                                                                        endif;
                                                                                                                    else:
                                                                                                                        $this->Result = false;
                                                                                                                        $this->Error  = "Erro ao criar tabela no banco de dados (1): {$this->Conn->error}";
                                                                                                                    endif;
                                                                                                                else:
                                                                                                                    $this->Result = false;
                                                                                                                    $this->Error  = "Erro ao criar tabela no banco de dados (1): {$this->Conn->error}";
                                                                                                                endif;
                                                                                                            else:
                                                                                                                $this->Result = false;
                                                                                                                $this->Error  = "Erro ao criar tabela no banco de dados (1): {$this->Conn->error}";
                                                                                                            endif;
                                                                                                        else:
                                                                                                            $this->Result = false;
                                                                                                            $this->Error  = "Erro ao criar tabela no banco de dados (1): {$this->Conn->error}";
                                                                                                        endif;
                                                                                                    else:
                                                                                                        $this->Result = false;
                                                                                                        $this->Error  = "Erro ao criar tabela no banco de dados (1): {$this->Conn->error}";
                                                                                                    endif;
                                                                                                else:
                                                                                                    $this->Result = false;
                                                                                                    $this->Error  = "Erro ao criar tabela no banco de dados (1): {$this->Conn->error}";
                                                                                                endif;
                                                                                            else:
                                                                                                $this->Result = false;
                                                                                                $this->Error  = "Erro ao criar tabela no banco de dados (1): {$this->Conn->error}";
                                                                                            endif;
                                                                                        else:
                                                                                            $this->Result = false;
                                                                                            $this->Error  = "Erro ao criar tabela no banco de dados (1): {$this->Conn->error}";
                                                                                        endif;
                                                                                    else:
                                                                                        $this->Result = false;
                                                                                        $this->Error  = "Erro ao criar tabela no banco de dados (1): {$this->Conn->error}";
                                                                                    endif;
                                                                                else:
                                                                                    $this->Result = false;
                                                                                    $this->Error  = "Erro ao criar tabela no banco de dados (1): {$this->Conn->error}";
                                                                                endif;
                                                                            else:
                                                                                $this->Result = false;
                                                                                $this->Error  = "Erro ao criar tabela no banco de dados (1): {$this->Conn->error}";
                                                                            endif;
                                                                        else:
                                                                            $this->Result = false;
                                                                            $this->Error  = "Erro ao criar tabela no banco de dados (1): {$this->Conn->error}";
                                                                        endif;
                                                                    else:
                                                                        $this->Result = false;
                                                                        $this->Error  = "Erro ao criar tabela no banco de dados (1): {$this->Conn->error}";
                                                                    endif;
                                                                else:
                                                                    $this->Result = false;
                                                                    $this->Error  = "Erro ao criar tabela no banco de dados (1): {$this->Conn->error}";
                                                                endif;
                                                            else:
                                                                $this->Result = false;
                                                                $this->Error  = "Erro ao criar tabela no banco de dados (1): {$this->Conn->error}";
                                                            endif;
                                                        else:
                                                            $this->Result = false;
                                                            $this->Error  = "Erro ao criar tabela no banco de dados (1): {$this->Conn->error}";
                                                        endif;
                                                    else:
                                                        $this->Result = false;
                                                        $this->Error  = "Erro ao criar tabela no banco de dados (1): {$this->Conn->error}";
                                                    endif;
                                                else:
                                                    $this->Result = false;
                                                    $this->Error  = "Erro ao criar tabela no banco de dados (1): {$this->Conn->error}";
                                                endif;
                                            else:
                                                $this->Result = false;
                                                $this->Error  = "Erro ao criar tabela no banco de dados (1): {$this->Conn->error}";
                                            endif;
                                        else:
                                            $this->Result = false;
                                            $this->Error  = "Erro ao criar tabela no banco de dados (1): {$this->Conn->error}";
                                        endif;
                                    else:
                                        $this->Result = false;
                                        $this->Error  = "Erro ao criar tabela no banco de dados (1): {$this->Conn->error}";
                                    endif;
                                else:
                                    $this->Result = false;
                                    $this->Error  = "Erro ao criar tabela no banco de dados (1): {$this->Conn->error}";
                                endif;
                            else:
                                $this->Result = false;
                                $this->Error  = "Erro ao criar tabela no banco de dados (1): {$this->Conn->error}";
                            endif;
                        else:
                            $this->Result = false;
                            $this->Error  = "Erro ao criar tabela no banco de dados (1): {$this->Conn->error}";
                        endif;
                    else:
                        $this->Result = false;
                        $this->Error  = "Erro ao criar tabela no banco de dados (1): {$this->Conn->error}";
                    endif;
                else:
                    $this->Result = false;
                    $this->Error  = "Erro ao criar tabela no banco de dados (1): {$this->Conn->error}";
                endif;
            else:
                $this->Result = false;
                $this->Error  = "Erro ao criar tabela no banco de dados (1): {$this->Conn->error}";
            endif;
        else:
            $this->Result = false;
            $this->Error  = "Erro ao criar tabela no banco de dados (1): {$this->Conn->error}";
        endif;

        mysqli_close($this->Conn);
    }

    public function CreateConfig($Cover, array $Dados){
        $this->Cover = $Cover;
        $this->Dados = $Dados;

        $this->Dados["email"] = strip_tags(trim($this->Dados['email']));
        $this->Dados["color_1"] = strip_tags(trim($this->Dados['color_1']));
        $this->Dados["color_2"] = strip_tags(trim($this->Dados['color_2']));
        $this->Dados["color_41"] = strip_tags(trim($this->Dados['color_41']));
        $this->Dados["color_42"] = strip_tags(trim($this->Dados['color_42']));
        $this->Dados["color_3"] = strip_tags(trim($this->Dados['color_3']));
        $this->Dados["name"] = strip_tags(trim($this->Dados['name']));
        $this->Dados["telefone"] = strip_tags(trim($this->Dados['telefone']));
        $this->Dados["email"] = strip_tags(trim($this->Dados['email']));
        $this->Dados["endereco"] = strip_tags(trim($this->Dados['endereco']));
        $this->Dados["website"] = strip_tags(trim($this->Dados['website']));
        $this->Dados["iso"] = strip_tags(trim($this->Dados['iso']));
        $this->Dados["agt"] = strip_tags(trim($this->Dados['agt']));
        $this->Dados["versao"] = strip_tags(trim($this->Dados['versao']));

        unset($this->Dados['SendPostFormL']);

        $Read = new Read();
        $Read->ExeRead(self::config);

        if(!$Read->getResult() || !$Read->getRowCount()):
            if(in_array("", $this->Dados)):
                $this->Result = false;
                $this->Error  = ["Opss: preencha todos os campos para prosseguir com o processo!", WS_ALERT];
            elseif(!Check::Email($this->Dados['email'])):
                $this->Result = false;
                $this->Error  = ["Opss: introduza um endereço de email válido!", WS_INFOR];
            else:
                if(!in_array('', $this->Cover)):
                    $this->SendLogotype();
                    $this->Dados['logotype'] = $this->Cover['logotype'];
                endif;


                $this->Dados["hora"] = date("H:i:s");
                $this->Dados["data"] = date('d/m/Y');
                $this->Config();
            endif;
        else:
            $this->Error  = ["Opss: já encontra-se configurado o software!", WS_ALERT];
            $this->Result = false;
        endif;
    }

    private function SendLogotype(){
        if(!empty($this->Cover['logotype']['tmp_name'])):
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

    private function SendIcon(){
        if(!empty($this->Icon['icon']['tmp_name'])):
            $Upload = new Upload;
            $Upload->Image($this->Icon['icon']);

            if($Upload->getError()):
                $this->Error = $Upload->getError();
                $this->Result = false;
            else:
                $this->Icon['icon'] = $Upload->getResult();
                $this->Result = true;
            endif;
        endif;
    }

    private function Config(){
        $Create = new Create();
        $Create->ExeCreate(self::config, $this->Dados);

        if($Create->getResult()):
            $this->Result = true;
            $this->Error = ["Configuraçōes do sistema salvas com sucesso!", WS_ACCEPT];
        else:
            $this->Error = ["Opss: aconteceu um erro inesperado ao salvar as configuraçōes do sistema¡", WS_ERROR];
            $this->Result = false;
        endif;
    }

    public function UpdateConfig($Cover, $icon, array $Dados){
        $this->Cover = $Cover;
        $this->Icon = $icon;
        $this->Dados = $Dados;

        $this->Dados["email"] = strip_tags(trim($this->Dados['email']));
        $this->Dados["color_1"] = strip_tags(trim($this->Dados['color_1']));
        $this->Dados["color_2"] = strip_tags(trim($this->Dados['color_2']));
        $this->Dados["color_41"] = strip_tags(trim($this->Dados['color_41']));
        $this->Dados["color_42"] = strip_tags(trim($this->Dados['color_42']));
        $this->Dados["color_3"] = strip_tags(trim($this->Dados['color_3']));
        $this->Dados["name"] = strip_tags(trim($this->Dados['name']));
        $this->Dados["telefone"] = strip_tags(trim($this->Dados['telefone']));
        $this->Dados["email"] = strip_tags(trim($this->Dados['email']));
        $this->Dados["endereco"] = strip_tags(trim($this->Dados['endereco']));
        $this->Dados["website"] = strip_tags(trim($this->Dados['website']));
        $this->Dados["iso"] = strip_tags(trim($this->Dados['iso']));
        $this->Dados["agt"] = strip_tags(trim($this->Dados['agt']));
        $this->Dados["versao"] = strip_tags(trim($this->Dados['versao']));

        $this->Dados["facebook"] = strip_tags(trim($this->Dados['facebook']));
        $this->Dados["instagram"] = strip_tags(trim($this->Dados['instagram']));
        $this->Dados["linkedin"] = strip_tags(trim($this->Dados['linkedin']));
        $this->Dados["twitter"] = strip_tags(trim($this->Dados['twitter']));
        $this->Dados["youtube"] = strip_tags(trim($this->Dados['youtube']));
        $this->Dados["whatsapp"] = strip_tags(trim($this->Dados['whatsapp']));

        $this->Dados["banco"] = strip_tags(trim($this->Dados['banco']));
        $this->Dados["swift"] = strip_tags(trim($this->Dados['swift']));
        $this->Dados["nib"] = strip_tags(trim($this->Dados['nib']));
        $this->Dados["iban"] = strip_tags(trim($this->Dados['iban']));

        unset($this->Dados['SendPostFormL']);

        $Read = new Read();
        $Read->ExeRead(self::config);

        if($Read->getResult() || $Read->getRowCount()):
            $this->Arq = $Read->getResult()[0]['id'];
            if(!Check::Email($this->Dados['email'])):
                $this->Result = false;
                $this->Error  = ["Opss: introduza um endereço de email válido!", WS_INFOR];
            else:
                $this->SendLogotype();
                if($this->Result):  $this->Dados['logotype'] = $this->Cover['logotype']; endif;

                $this->SendIcon();
                if($this->Result):  $this->Dados['icon'] = $this->Icon['icon']; endif;

                $this->Dados["hora"] = date("H:i:s");
                $this->Dados["data"] = date('d/m/Y');
                $this->ConfigUpdate();
            endif;
        else:
            $this->CreateConfig($Cover, $Dados);
        endif;
    }

    private function ConfigUpdate(){
        $Create = new Update();
        $Create->ExeUpdate(self::config, $this->Dados, "WHERE id=:i", "i={$this->Arq}");

        if($Create->getResult()):
            $this->Result = true;
            $this->Error = ["Configuraçōes do sistema salvas com sucesso!", WS_ACCEPT];
        else:
            $this->Error = ["Opss: aconteceu um erro inesperado ao salvar as configuraçōes do sistema¡", WS_ERROR];
            $this->Result = false;
        endif;
    }
}
<?php
class Websites{
    private $Data, $Error, $Result, $Cover, $database, $array, $postId, $Save, $id;
    const faq = "website_faq", team = "website_team", pricing = "website_pricing", blog_gallery = "website_blog_gallery", blog = "website_blog", author = "website_author", category = "website_category", gallery = "website_gallery", services = "website_services", about = "website_about", home = 'website_home', terms = "website_terms", Ads = "ads_whatsapp", AdsHome = "ads_home";
    public function getError(){return $this->Error;}
    public function getResult(){return $this->Result;}

    public function UpdateCategory($logotype, $ClienteData, $postId){
        $this->Data = $ClienteData;
        $this->Cover = $logotype;
        $this->postId = $postId;

        unset($this->Data["SendPostFormL"]);
        if(isset($this->Cover) || $this->Cover != null):
            $this->SendLogotype();
            $this->Data["logotype"] = $this->Cover['logotype'];
        endif;

        if(!isset($this->Data["name"]) || empty($this->Data["name"]) || $this->Data["name"] == null):
            $this->Error = ["Ops: preencha todos os campos para prosseguir com o processo!", WS_ALERT];
            $this->Result = false;
        else:
            $this->Data["status"] = 1;
            $this->ExeUpdate(self::category, $this->Data, $this->postId);
        endif;
    }

    public function UpdateFaq($ClienteData, $postId){
        $this->Data = $ClienteData;
        $this->postId = $postId;

        unset($this->Data["SendPostFormL"]);
        if(!isset($this->Data["titulo"]) || empty($this->Data["titulo"]) || $this->Data["titulo"] == null):
            $this->Error = ["Ops: preencha todos os campos para prosseguir com o processo!", WS_ALERT];
            $this->Result = false;
        else:
            $this->ExeUpdate(self::faq, $this->Data, $this->postId);
        endif;
    }

    public function UpdateBlog($logotype, $ClienteData, $postId){
        $this->Data = $ClienteData;
        $this->Cover = $logotype;
        $this->postId = $postId;

        unset($this->Data["SendPostFormL"]);
        if(!in_array('', $this->Cover)):
            $this->SendLogotype();
            $this->Data["logotype"] = $this->Cover['logotype'];
        endif;

        $this->Data["titulo"] = strip_tags(trim($this->Data["titulo"]));
        $this->Data["id_author"] = strip_tags(trim($this->Data["id_author"]));
        $this->Data["id_category"] = strip_tags(trim($this->Data["id_category"]));
        $this->Data["subtitulo"] = strip_tags(trim($this->Data["subtitulo"]));
        $this->Data["hora"] = strip_tags(trim($this->Data["hora"]));
        $this->Data["data"] = strip_tags(trim($this->Data["data"]));

        if(empty($this->Data["titulo"]) && empty($this->Data["content"]) || $this->Data["titulo"] == '' && $this->Data['content'] == '' || empty($this->Data['id_category']) || empty($this->Data['id_author'])):
            $this->Error = ["Ops: preencha todos os campos para prosseguir com o processo!", WS_ALERT];
            $this->Result = false;
        else:
            $this->ExeUpdate(self::blog, $this->Data, $this->postId);
        endif;
    }

    public function UpdatePricing($ClienteData, $postId){
        $this->Data = $ClienteData;
        $this->postId = $postId;

        unset($this->Data["SendPostFormL"]);
        $this->Data["pacote"] = strip_tags(trim($this->Data["pacote"]));
        $this->Data["preco"] = strip_tags(trim($this->Data["preco"]));

        if(empty($this->Data["preco"]) && empty($this->Data["pacote"]) || $this->Data["preco"] == '' && $this->Data['pacote'] == '' || empty($this->Data['preco']) || empty($this->Data['pacote'])):
            $this->Error = ["Ops: preencha todos os campos para prosseguir com o processo!", WS_ALERT];
            $this->Result = false;
        else:
            $this->ExeUpdate(self::pricing, $this->Data, $this->postId);
        endif;
    }

    public function UpdateAuthor($logotype, $ClienteData, $postId){
        $this->Data = $ClienteData;
        $this->Cover = $logotype;
        $this->postId = $postId;

        unset($this->Data["SendPostFormL"]);
        if(isset($this->Cover) || $this->Cover != null):
            $this->SendLogotype();
            $this->Data["logotype"] = $this->Cover['logotype'];
        endif;

        $this->Data["name"] = strip_tags(trim($this->Data["name"]));
        $this->Data["email"] = strip_tags(trim($this->Data["email"]));
        $this->Data["linkdin"] = strip_tags(trim($this->Data["linkdin"]));
        $this->Data["youtube"] = strip_tags(trim($this->Data["youtube"]));
        $this->Data["facebook"] = strip_tags(trim($this->Data["facebook"]));
        $this->Data["instagram"] = strip_tags(trim($this->Data["instagram"]));
        $this->Data["twitter"] = strip_tags(trim($this->Data["twitter"]));

        if(empty($this->Data["name"]) && empty($this->Data["content"]) || $this->Data["name"] == '' && $this->Data['content'] == ''):
            $this->Error = ["Ops: preencha todos os campos para prosseguir com o processo!", WS_ALERT];
            $this->Result = false;
        elseif(isset($this->Data["email"]) && !Check::Email($this->Data["email"])):
            $this->Error = ["Ops: introduza um endereço de e-mail válido!", WS_ALERT];
            $this->Result = false;
        else:
            $this->Data["status"] = 1;
            $this->ExeUpdate(self::author, $this->Data, $postId);
        endif;
    }

    public function UpdateTeam($logotype, $ClienteData, $postId){
        $this->Data = $ClienteData;
        $this->Cover = $logotype;
        $this->postId = $postId;

        unset($this->Data["SendPostFormL"]);
        if(isset($this->Cover) || $this->Cover != null):
            $this->SendLogotype();
            $this->Data["logotype"] = $this->Cover['logotype'];
        endif;

        $this->Data["name"] = strip_tags(trim($this->Data["name"]));
        $this->Data["cargo"] = strip_tags(trim($this->Data["cargo"]));
        $this->Data["linkdin"] = strip_tags(trim($this->Data["linkdin"]));
        $this->Data["youtube"] = strip_tags(trim($this->Data["youtube"]));
        $this->Data["facebook"] = strip_tags(trim($this->Data["facebook"]));
        $this->Data["instagram"] = strip_tags(trim($this->Data["instagram"]));
        $this->Data["twitter"] = strip_tags(trim($this->Data["twitter"]));

        if(empty($this->Data["name"]) && empty($this->Data["content"]) || $this->Data["name"] == '' && $this->Data['content'] == ''):
            $this->Error = ["Ops: preencha todos os campos para prosseguir com o processo!", WS_ALERT];
            $this->Result = false;
        elseif(isset($this->Data["email"]) && !Check::Email($this->Data["email"])):
            $this->Error = ["Ops: introduza um endereço de e-mail válido!", WS_ALERT];
            $this->Result = false;
        else:
            $this->Data["status"] = 1;
            $this->ExeUpdate(self::team, $this->Data, $postId);
        endif;
    }

    public function UpdateTerms($ClienteData, $postId){
        $this->Data = $ClienteData;
        $this->postId = $postId;

        unset($this->Data["SendPostFormL"]);
        $this->Data["title"] = strip_tags(trim($this->Data["title"]));

        if(empty($this->Data["title"]) && empty($this->Data["content"]) || $this->Data["title"] == '' && $this->Data['content'] == ''):
            $this->Error = ["Ops: preencha todos os campos para prosseguir com o processo!", WS_ALERT];
            $this->Result = false;
        else:
            $this->ExeUpdate(self::terms, $this->Data, $postId);
        endif;
    }

    public function UpdateHome($logotype, $ClienteData, $postId){
        $this->Data = $ClienteData;
        $this->Cover = $logotype;
        $this->postId = $postId;
        unset($this->Data["SendPostFormL"]);

        if(!in_array('', $this->Cover)):
            $this->SendLogotype();
            $this->Data["logotype"] = $this->Cover['logotype'];
        endif;

        if(!isset($this->Data["titulo"]) || !isset($this->Data["subtitulo"])):
            $this->Error = ["Ops: preencha todos os campos para prosseguir com o processo!", WS_ALERT];
            $this->Result = false;
        else:
            $this->ExeUpdate(self::home, $this->Data, $this->postId);
        endif;
    }

    public function UpdateAds($logotype, $ClienteData, $postId){
        $this->Data = $ClienteData;
        $this->Cover = $logotype;
        $this->postId = $postId;
        unset($this->Data["SendPostFormL"]);

        if(!in_array('', $this->Cover)):
            $this->SendLogotype();
            $this->Data["cover"] = $this->Cover['logotype'];
        endif;

        if(!isset($this->Data["titulo"])):
            $this->Error = ["Ops: preencha todos os campos para prosseguir com o processo!", WS_ALERT];
            $this->Result = false;
        else:
            $this->ExeUpdate(self::Ads, $this->Data, $this->postId);
        endif;
    }

    public function UpdateServices($logotype, $ClienteData, $postId){
        $this->Data = $ClienteData;
        $this->Cover = $logotype;
        $this->postId = $postId;
        unset($this->Data["SendPostFormL"]);
        if(isset($this->Cover) || $this->Cover != null):
            $this->SendLogotype();
            $this->Data["logotype"] = $this->Cover['logotype'];
        endif;

        if(!isset($this->Data["titulo"]) || !isset($this->Data["subtitulo"])):
            $this->Error = ["Ops: preencha todos os campos para prosseguir com o processo!", WS_ALERT];
            $this->Result = false;
        else:
            $this->ExeUpdate(self::services, $this->Data, $this->postId);
        endif;
    }

    public function UpdateAbout($logotype, $ClienteData, $postId){
        $this->Data = $ClienteData;
        $this->Cover = $logotype;
        $this->postId = $postId;
        unset($this->Data["SendPostFormL"]);
        if(isset($this->Cover) || $this->Cover != null):
            $this->SendLogotype();
            $this->Data["logotype"] = $this->Cover['logotype'];
        endif;

        if(empty($this->Data["titulo"]) && empty($this->Data["content"]) || $this->Data["titulo"] == '' && $this->Data['content'] == ''):
            $this->Error = ["Ops: preencha todos os campos para prosseguir com o processo!", WS_ALERT];
            $this->Result = false;
        else:
            $this->ExeUpdate(self::about, $this->Data, $this->postId);
        endif;
    }

    public function ExeHome($logotype, $ClienteData){
        $this->Data = $ClienteData;
        $this->Cover = $logotype;

        unset($this->Data["SendPostFormL"]);
        if(!in_array('', $this->Cover)):
            $this->SendLogotype();
            $this->Data["logotype"] = $this->Cover['logotype'];
        endif;

        if(!isset($this->Data["titulo"]) || !isset($this->Data["subtitulo"])):
            $this->Error = ["Ops: preencha todos os campos para prosseguir com o processo!", WS_ALERT];
            $this->Result = false;
        else:
            $this->Data["data"] = date('d/m/Y H:i');
            $this->Data["status"] = 1;
            $this->ExeSave(self::home, $this->Data);
        endif;
    }

    public function ExeAds($logotype, $ClienteData){
        $this->Data = $ClienteData;
        $this->Cover = $logotype;

        unset($this->Data["SendPostFormL"]);
        if(!in_array('', $this->Cover)):
            $this->SendLogotype();
            $this->Data["cover"] = $this->Cover['logotype'];
        endif;

        if(!isset($this->Data["titulo"]) || !isset($this->Data["content"])):
            $this->Error = ["Ops: preencha todos os campos para prosseguir com o processo!", WS_ALERT];
            $this->Result = false;
        else:
            $this->Data["data"] = date('d/m/Y');
            $this->Data['hora'] = date('H:i:s');
            $this->Data["status"] = 1;
            $this->ExeSave(self::Ads, $this->Data);
        endif;
    }

    public function ExeFaq($ClienteData){
        $this->Data = $ClienteData;
        unset($this->Data["SendPostFormL"]);

        $this->Data["titulo"] = strip_tags(trim($this->Data["titulo"]));
        if(!isset($this->Data["titulo"])):
            $this->Error = ["Ops: preencha todos os campos para prosseguir com o processo!", WS_ALERT];
            $this->Result = false;
        else:
            $this->Data["status"] = 1;
            $this->ExeSave(self::faq, $this->Data);
        endif;
    }

    public function ExeGallery($logotype, $ClienteData){
        $this->Data = $ClienteData;
        $this->Cover = $logotype;

        unset($this->Data["SendPostFormL"]);
        if(isset($this->Cover['logotype']) || $this->Cover['logotype'] != null || $this->Cover["logotype"] != ''):
            $this->SendLogotype();

            if(!isset($this->Data["titulo"])):
                $this->Error = ["Ops: preencha todos os campos para prosseguir com o processo!", WS_ALERT];
                $this->Result = false;
            else:
                if(isset($this->Cover) || $this->Cover != null): $this->Data["logotype"] = $this->Cover['logotype']; endif;
                $this->Data["status"] = 1;
                $this->ExeSave(self::gallery, $this->Data);
            endif;
        else:
            $this->Error = ["Ops: introduza uma imagem para continuar com o processo!", WS_ALERT];
            $this->Result = false;
        endif;
    }

    public function ExeServices($logotype, $ClienteData){
        $this->Data = $ClienteData;
        $this->Cover = $logotype;

        unset($this->Data["SendPostFormL"]);
        if(isset($this->Cover) || $this->Cover != null):
            $this->SendLogotype();
            $this->Data["logotype"] = $this->Cover['logotype'];
        endif;

        if(!isset($this->Data["titulo"]) || !isset($this->Data["subtitulo"])):
            $this->Error = ["Ops: preencha todos os campos para prosseguir com o processo!", WS_ALERT];
            $this->Result = false;
        else:
            $this->Data["status"] = 1;
            $this->ExeSave(self::services, $this->Data);
        endif;
    }

    public function ExeCategory($logotype, $ClienteData){
        $this->Data = $ClienteData;
        $this->Cover = $logotype;

        unset($this->Data["SendPostFormL"]);
        if(isset($this->Cover) || $this->Cover != null):
            $this->SendLogotype();
            $this->Data["logotype"] = $this->Cover['logotype'];
        endif;

        if(!isset($this->Data["name"]) || empty($this->Data["name"]) || $this->Data["name"] == null):
            $this->Error = ["Ops: preencha todos os campos para prosseguir com o processo!", WS_ALERT];
            $this->Result = false;
        else:
            $this->Data["status"] = 1;
            $this->ExeSave(self::category, $this->Data);
        endif;
    }

    public function ExeAbout($logotype, $ClienteData){
        $this->Data = $ClienteData;
        $this->Cover = $logotype;

        unset($this->Data["SendPostFormL"]);
        if(isset($this->Cover) || $this->Cover != null):
            $this->SendLogotype();
            $this->Data["logotype"] = $this->Cover['logotype'];
        endif;

        if(empty($this->Data["titulo"]) && empty($this->Data["content"]) || $this->Data["titulo"] == '' && $this->Data['content'] == ''):
            $this->Error = ["Ops: preencha todos os campos para prosseguir com o processo!", WS_ALERT];
            $this->Result = false;
        else:
            $this->Data["data"] = date('d/m/Y H:i');
            $this->Data["status"] = 1;
            $this->ExeSave(self::about, $this->Data);
        endif;
    }

    public function ExeAuthor($logotype, $ClienteData){
        $this->Data = $ClienteData;
        $this->Cover = $logotype;

        unset($this->Data["SendPostFormL"]);
        if(isset($this->Cover) || $this->Cover != null):
            $this->SendLogotype();
            $this->Data["logotype"] = $this->Cover['logotype'];
        endif;

        $this->Data["name"] = strip_tags(trim($this->Data["name"]));
        $this->Data["email"] = strip_tags(trim($this->Data["email"]));
        $this->Data["linkdin"] = strip_tags(trim($this->Data["linkdin"]));
        $this->Data["youtube"] = strip_tags(trim($this->Data["youtube"]));
        $this->Data["facebook"] = strip_tags(trim($this->Data["facebook"]));
        $this->Data["instagram"] = strip_tags(trim($this->Data["instagram"]));
        $this->Data["twitter"] = strip_tags(trim($this->Data["twitter"]));

        if(empty($this->Data["name"]) && empty($this->Data["content"]) || $this->Data["name"] == '' && $this->Data['content'] == ''):
            $this->Error = ["Ops: preencha todos os campos para prosseguir com o processo!", WS_ALERT];
            $this->Result = false;
        elseif(isset($this->Data["email"]) && !Check::Email($this->Data["email"])):
            $this->Error = ["Ops: introduza um endereço de e-mail válido!", WS_ALERT];
            $this->Result = false;
        else:
            $this->Data["status"] = 1;
            $this->ExeSave(self::author, $this->Data);
        endif;
    }

    public function ExeTeam($logotype, $ClienteData){
        $this->Data = $ClienteData;
        $this->Cover = $logotype;

        unset($this->Data["SendPostFormL"]);
        if(isset($this->Cover) || $this->Cover != null):
            $this->SendLogotype();
            $this->Data["logotype"] = $this->Cover['logotype'];
        endif;

        $this->Data["name"] = strip_tags(trim($this->Data["name"]));
        $this->Data["cargo"] = strip_tags(trim($this->Data["cargo"]));
        $this->Data["linkdin"] = strip_tags(trim($this->Data["linkdin"]));
        $this->Data["youtube"] = strip_tags(trim($this->Data["youtube"]));
        $this->Data["facebook"] = strip_tags(trim($this->Data["facebook"]));
        $this->Data["instagram"] = strip_tags(trim($this->Data["instagram"]));
        $this->Data["twitter"] = strip_tags(trim($this->Data["twitter"]));

        if(empty($this->Data["name"]) && empty($this->Data["content"]) || $this->Data["name"] == '' && $this->Data['content'] == ''):
            $this->Error = ["Ops: preencha todos os campos para prosseguir com o processo!", WS_ALERT];
            $this->Result = false;
        else:
            $this->Data["status"] = 1;
            $this->ExeSave(self::team, $this->Data);
        endif;
    }

    public function ExeTerms($ClienteData){
        $this->Data = $ClienteData;

        unset($this->Data["SendPostFormL"]);
        $this->Data["title"] = strip_tags(trim($this->Data["title"]));

        if(empty($this->Data["title"]) && empty($this->Data["content"]) || $this->Data["title"] == '' && $this->Data['content'] == ''):
            $this->Error = ["Ops: preencha todos os campos para prosseguir com o processo!", WS_ALERT];
            $this->Result = false;
        else:
            $this->Data['hora'] = date('H:i:s');
            $this->Data['data'] = date('d-m-Y');
            $this->Data["status"] = 1;
            $this->ExeSave(self::terms, $this->Data);
        endif;
    }

    public function ExePricing($ClienteData){
        $this->Data = $ClienteData;

        unset($this->Data["SendPostFormL"]);
        $this->Data["preco"] = strip_tags(trim($this->Data["preco"]));
        $this->Data["pacote"] = strip_tags(trim($this->Data["pacote"]));

        if(empty($this->Data["preco"]) && empty($this->Data["pacote"]) || $this->Data["preco"] == '' && $this->Data['pacote'] == ''):
            $this->Error = ["Ops: preencha todos os campos para prosseguir com o processo!", WS_ALERT];
            $this->Result = false;
        else:
            if(isset($this->Cover) || $this->Cover != null): $this->Data["logotype"] = $this->Cover['logotype']; endif;
            $this->Data["status"] = 1;
            $this->ExeSave(self::pricing, $this->Data);
        endif;
    }

    public function ExeBlog($logotype, $ClienteData){
        $this->Data = $ClienteData;
        $this->Cover = $logotype;

        unset($this->Data["SendPostFormL"]);
        if(!in_array('', $this->Cover)):
            $this->SendLogotype();
            $this->Data["logotype"] = $this->Cover['logotype'];
        endif;

        $this->Data["titulo"] = strip_tags(trim($this->Data["titulo"]));
        $this->Data["id_author"] = strip_tags(trim($this->Data["id_author"]));
        $this->Data["id_category"] = strip_tags(trim($this->Data["id_category"]));
        $this->Data["subtitulo"] = strip_tags(trim($this->Data["subtitulo"]));
        $this->Data["hora"] = strip_tags(trim($this->Data["hora"]));
        $this->Data["data"] = strip_tags(trim($this->Data["data"]));

        if(empty($this->Data["titulo"]) && empty($this->Data["content"]) || $this->Data["titulo"] == '' && $this->Data['content'] == '' || empty($this->Data['id_category']) || empty($this->Data['id_author'])):
            $this->Error = ["Ops: preencha todos os campos para prosseguir com o processo!", WS_ALERT];
            $this->Result = false;
        else:
            $this->Data["status"] = 1;
            $this->ExeSave(self::blog, $this->Data);
        endif;
    }

    private function ExeSave($database, array $data){
        unset($this->Save);
        unset($this->database);
        $this->database = $database;
        $this->Save = $data;

        $Create = new Create();
        $Create->ExeCreate($this->database, $this->Save);

        if($Create->getResult()):
            $this->Result = true;
            $this->Error = ["Operaçāo realizada com sucesso!", WS_ACCEPT];
        else:
            $this->Result = false;
            $this->Error = ["Ops: aconteceu um erro ao salvar as informaçōes no banco de dados!", WS_ERROR];
        endif;
    }

    private function ExeUpdate($database, array $data, $postId){
        unset($this->Save);
        unset($this->database);

        $this->database = $database;
        $this->Save = $data;
        $this->id = $postId;

        $Update = new Update();
        $Update->ExeUpdate($this->database, $this->Save, "WHERE id=:i", "i={$this->id}");
        if($Update->getResult()):
            $this->Result = true;
            $this->Error = ["Operaçāo realizada com sucesso!", WS_ACCEPT];
        else:
            $this->Result = false;
            $this->Error = ["Ops: aconteceu um erro ao alterar as informaçōes no banco de dados!", WS_ERROR];
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

    public function gbSend(array $Image, $id){
        $this->File = $Image;
        $this->postId = $id;

        $this->Data['id_blog']  = $this->postId;
        $ImageName = "50726f536d617274-";

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

                $insertGb = new Create;
                $insertGb->ExeCreate(self::blog_gallery, $this->Data);
                $u++;
            endif;
        endforeach;

        if($u >= 1):
            $this->Error = ["Galleria atualizada com sucesso, foram enviadas {$u} imagens para galeria.", WS_ACCEPT];
            $this->Result  = true;
        else:
            $this->Error = ["Aconteceu um erro ao enviar as imagens!", WS_ERROR];
            $this->Result = false;
        endif;
    }

    /**private function CheckCover(){
        $ReadCover = new Read;
        $ReadCover->FullRead("SELECT cover FROM cv_product WHERE id=:id AND id_db_settings=:i", "id={$this->Product}&i={$this->IDEmpresa}");

        if($ReadCover->getRowCount()):
            $delCover = $ReadCover->getResult()[0]['cover'];
            if(file_exists("./uploads/{$delCover}") && !is_dir("./uploads/{$delCover}")):
                unlink("./uploads/{$delCover}");
            endif;
        endif;
    }**/

    public function MsgAds($postId){
        $this->postId = (int) $postId;

        $Read = new Read();
        $Read->ExeRead(self::Ads, "WHERE id=:i", "i={$this->postId}");

        if($Read->getResult()):
            $key = $Read->getResult()[0];

            $this->Data['msg'] = $key['msg'] + 1;

            $this->ExeUpdate(self::Ads, $this->Data, $this->postId);
        endif;
    }

    public function AdsHome(){
        $dia = date('d');
        $mes = date('m');
        $ano = date('Y');

        $Read = new Read();
        $Read->ExeRead(self::AdsHome, "WHERE dia=:i AND mes=:iy AND ano=:it", "i={$dia}&iy={$mes}&it={$ano}");

        if($Read->getResult()):
            $key = $Read->getResult()[0];
            $this->Data['views'] = $key['views'] + 1;

            $this->ExeUpdate(self::AdsHome, $this->Data, $key['id']);
        else:
            $this->Data['dia'] = date('d');
            $this->Data['mes'] = date('m');
            $this->Data['ano'] = date('Y');
            $this->Data['status'] = 1;

            $this->Data['views'] = 1;
            $this->ExeSave(self::AdsHome, $this->Data);
        endif;
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: Kwanzar Soft
 * Date: 15/10/2020
 * Time: 00:16
 */

class BR{
    private $Result, $Error, $Data, $id_user, $id_cv_product, $Like, $Info, $id_cart, $idQtd, $Rating;

    const
        br_rating  = "br_rating",
        cv_product = "cv_product",
        br_cart    = "br_cart",
        br_newsletter = "br_newsletter",
        br_likes   = "br_likes";

    public function getError(){
        return $this->Error;
    }

    public function getResult(){
        return $this->Result;
    }

    public function getLike(){
        return $this->Like;
    }

    /**
     * @param $id_user
     * @param $id_cv_product
     */
    public function Like($id_user, $id_cv_product){
        $this->id_cv_product = $id_cv_product;
        $this->id_user = $id_user;

        $Read = new Read();
        $Read->ExeRead(self::br_likes, "WHERE id_cv_product=:i AND id_db_users=:ip ", "i={$this->id_cv_product}&ip={$this->id_user}");

        if($Read->getResult()):
            $this->DeleteLike();
        else:
            $this->CreateLike();
        endif;
    }

    private function DeleteLike(){
        $Delete = new Delete;
        $Delete->ExeDelete(self::br_likes, "WHERE id_cv_product=:i AND id_db_users=:ip ", "i={$this->id_cv_product}&ip={$this->id_user}");

        if($Delete->getResult() || $Delete->getRowCount()):
            $Read = new Read();
            $Read->ExeRead(self::cv_product, "WHERE id=:i", "i={$this->id_cv_product}");

            if($Read->getResult()):
                $this->Data['likes'] = $Read->getResult()[0]['likes'] - 1;

                $Update = new Update();
                $Update->ExeUpdate(self::cv_product, $this->Data, "WHERE id=:i", "i={$this->id_cv_product}");

                if($Update->getResult()):
                    $this->Like   = 2;
                    $this->Result = true;
                else:
                    $this->Error  = ["Ops: aconteceu um erro inesperado ao deletar o like! (1)", WS_ERROR];
                    $this->Result = false;
                endif;
            endif;
        else:
            $this->Error  = ["Ops: aconteceu um erro inesperado ao deletar o like!", WS_ERROR];
            $this->Result = false;
        endif;
    }

    private function CreateLike(){
        $this->Data['id_cv_product'] = $this->id_cv_product;
        $this->Data['id_db_users'] = $this->id_user;
        $this->Data['data'] = date('d-m-Y');
        $this->Data['hora'] = date('H:i:s');

        $Create = new Create();
        $Create->ExeCreate(self::br_likes, $this->Data);

        if($Create->getResult()):
            $Read = new Read();
            $Read->ExeRead(self::cv_product, "WHERE id=:i", "i={$this->id_cv_product}");

            if($Read->getResult()):
                $this->Info['likes'] = $Read->getResult()[0]['likes'] + 1;

                $Update = new Update();
                $Update->ExeUpdate(self::cv_product, $this->Info, "WHERE id=:i", "i={$this->id_cv_product}");

                if($Update->getResult()):
                    $this->Like   = 1;
                    $this->Result = true;
                else:
                    $this->Error  = ["Ops: aconteceu um erro inesperado ao criar o like! (1)", WS_ERROR];
                    $this->Result = false;
                endif;
            endif;
        else:
            $this->Error  = ["Ops: aconteceu um erro inesperado ao criar o like!", WS_ERROR];
            $this->Result = false;
        endif;
    }

    /**
     * @param $id_user
     * @param $id_cv_product
     */
    public function AdCart($id_user, $id_cv_product){
        $this->id_cv_product = $id_cv_product;
        $this->id_user = $id_user;

        $Read = new Read();
        $Read->ExeRead(self::br_cart, "WHERE id_cv_product=:i AND id_db_users=:ip ", "i={$this->id_cv_product}&ip={$this->id_user}");

        if($Read->getResult()):
            $this->Info = $Read->getResult()[0];
            $this->UpdateAdCart();
        else:
            $this->CreateAdCart();
        endif;
    }

    private function CreateAdCart(){
        $Read = new Read();
        $Read->ExeRead(self::cv_product, "WHERE id=:i", "i={$this->id_cv_product}");

        if($Read->getResult()):
            $key = $Read->getResult()[0];

            if($key['preco_promocao'] > 0):
                $value = (1 * $key['preco_promocao']);
                $imposto = ($value * $key['iva']) / 100;
                $pricing = $value + $imposto;
            else:
                $value = (1 * $key['preco_venda']);
                $imposto = ($value * $key['iva']) / 100;
                $pricing = $value + $imposto;
            endif;

            $this->Data['pricing'] = $pricing;
            $this->Data['id_cv_product'] = $this->id_cv_product;
            $this->Data['id_db_users'] = $this->id_user;
            $this->Data['data'] = date('d-m-Y');
            $this->Data['hora'] = date('H:i:s');
            $this->Data['status'] = 1;
            $this->Data['qtd'] = 1;

            $Create = new Create();
            $Create->ExeCreate(self::br_cart, $this->Data);

            if($Create->getResult()):
                $this->Like   = 1;
                $this->Result = true;
            else:
                $this->Error  = ["Ops: aconteceu um erro inesperado ao adicionar o produto ao carrinho!", WS_ERROR];
                $this->Result = false;
            endif;
        endif;
    }

    private function UpdateAdCart(){
        $this->Data['qtd'] = $this->Info['qtd'] + 1;

        $Update = new Update();
        $Update->ExeUpdate(self::br_cart, $this->Data, "WHERE id_cv_product=:i AND id_db_users=:ip", "i={$this->id_cv_product}&ip={$this->id_user}");

        if($Update->getResult()):
            $this->Like   = 1;
            $this->Result = true;
        else:
            $this->Error  = ["Ops: aconteceu um erro inesperado ao atualizar o carrinho!", WS_ERROR];
            $this->Result = false;
        endif;
    }

    /**
     * @param $id_user
     * @param $id_cart
     */
    public function RemCart($id_user, $id_cart){
        $this->id_user = $id_user;
        $this->id_cart = $id_cart;

        $st = 1;

        $Read = new Read();
        $Read->ExeRead(self::br_cart, "WHERE id=:i AND id_db_users=:ip AND status=:st", "i={$this->id_cart}&ip={$this->id_user}&st={$st}");

        if($Read->getResult()):
            $this->Remove();
        else:
            $this->Error  = ["Ops: o Item selecionado já encontra-se disponível no carrinho!", WS_ERROR];
            $this->Result = false;
        endif;
    }

    private function Remove(){
        $st = 1;

        $Delete = new Delete();
        $Delete->ExeDelete(self::br_cart, "WHERE id=:i AND id_db_users=:ip AND status=:st", "i={$this->id_cart}&ip={$this->id_user}&st={$st}");

        if($Delete->getResult() || $Delete->getRowCount()):
            $this->Result = true;
        else:
            $this->Error  = ["Ops: aconteceu um erro inesperado ao remover o item do carrinho!", WS_ERROR];
            $this->Result = false;
        endif;
    }

    public function AdCartII($id_user, $id_cv_product, $idQtd){
        $this->id_cv_product = $id_cv_product;
        $this->id_user = $id_user;
        $this->idQtd = $idQtd;

        $Read = new Read();
        $Read->ExeRead(self::br_cart, "WHERE id_cv_product=:i AND id_db_users=:ip ", "i={$this->id_cv_product}&ip={$this->id_user}");

        if($Read->getResult()):
            $this->Info = $Read->getResult()[0];
            $this->UpdateAdCartII();
        else:
            $this->CreateAdCartII();
        endif;
    }

    private function CreateAdCartII(){
        $Read = new Read();
        $Read->ExeRead(self::cv_product, "WHERE id=:i", "i={$this->id_cv_product}");

        if($Read->getResult()):
            $key = $Read->getResult()[0];

            if($key['preco_promocao'] > 0):
                $value = ($this->idQtd * $key['preco_promocao']);
                $imposto = ($value * $key['iva']) / 100;
                $pricing = $value + $imposto;
            else:
                $value = ($this->idQtd * $key['preco_venda']);
                $imposto = ($value * $key['iva']) / 100;
                $pricing = $value + $imposto;
            endif;

            $this->Data['pricing'] = $pricing;
            $this->Data['id_cv_product'] = $this->id_cv_product;
            $this->Data['id_db_users'] = $this->id_user;
            $this->Data['data'] = date('d-m-Y');
            $this->Data['hora'] = date('H:i:s');
            $this->Data['status'] = 1;
            $this->Data['qtd'] = $this->idQtd;

            $Create = new Create();
            $Create->ExeCreate(self::br_cart, $this->Data);

            if($Create->getResult()):
                $this->Like   = 1;
                $this->Result = true;
            else:
                $this->Error  = ["Ops: aconteceu um erro inesperado ao adicionar o produto ao carrinho!", WS_ERROR];
                $this->Result = false;
            endif;
        endif;
    }

    private function UpdateAdCartII(){
        $this->Data['qtd'] = $this->Info['qtd'] + $this->idQtd;

        $Update = new Update();
        $Update->ExeUpdate(self::br_cart, $this->Data, "WHERE id_cv_product=:i AND id_db_users=:ip", "i={$this->id_cv_product}&ip={$this->id_user}");

        if($Update->getResult()):
            $this->Like   = 1;
            $this->Result = true;
        else:
            $this->Error  = ["Ops: aconteceu um erro inesperado ao atualizar o carrinho!", WS_ERROR];
            $this->Result = false;
        endif;
    }

    /**
     * @param $id_user
     * @param $id_cv_product
     * @param $rating
     * @param $content
     */
    public function Rating($id_user, $id_cv_product, $rating, $content){
        $this->id_user = $id_user;
        $this->id_cv_product = $id_cv_product;
        $this->Data['message'] = strip_tags(trim($content));
        $this->Data['rating']  = $rating;

        if(in_array("", $this->Data)):
            $this->Error  = ["Ops: preecha todos os campos para prosseguir com o processo!", WS_INFOR];
            $this->Result = false;
        else:
            $this->CreateRating();
        endif;
    }

    private function CreateRating(){
        $this->Data['dia']  = date('d');
        $this->Data['mes']  = date('m');
        $this->Data['ano']  = date('Y');
        $this->Data['hora'] = date('H:i:s');

        $this->Data['id_db_users']   = $this->id_user;
        $this->Data['id_cv_product'] = $this->id_cv_product;

        $Create = new Create();
        $Create->ExeCreate(self::br_rating, $this->Data);

        if($Create->getResult()):
            $this->Error  = ["Comentário adicionado com sucesso!", WS_ACCEPT];
            $this->Result = true;
        else:
            $this->Error  = ["Ops: aconteceu um erro inesperado ao adicionar o comentário!", WS_ERROR];
            $this->Result = false;
        endif;
    }

    public function FinishOne($id_user, $rating){
        $this->id_user = $id_user;
        $this->Rating  = $rating;
        $status = 1;

        $Read = new Read();
        $Read->ExeRead(self::br_cart, "WHERE id_db_users=:i AND status=:ip", "i={$this->id_user}&ip={$status}");

        if($Read->getResult()):
            foreach($Read->getResult() as $key):
                $this->AddPurchased($key['id_cv_product']);
                if($this->Result):
                    $this->Finish();
                endif;
            endforeach;
        else:
            $this->Error  = ["Ops: não encontramos produtos a serem processados!", WS_ALERT];
            $this->Result = false;
        endif;
    }

    private function AddPurchased($id_product){
        $this->id_cv_product = $id_product;

        $Read = new Read();
        $Read->ExeRead(self::cv_product, "WHERE id=:i", "i={$this->id_cv_product}");

        if($Read->getResult()):
            $this->Data['purchased'] = $Read->getResult()[0]['purchased'] + 1;

            $Update = new Update();
            $Update->ExeUpdate(self::cv_product, $this->Data, "WHERE id=:i", "i={$this->id_cv_product}");

            if($Update->getResult()):
                $this->Result = true;
            else:
                $this->Error  = ["Ops: aconteceu um erro insperado ao adicionar o produto na lista de compra!", WS_ERROR];
                $this->Result = false;
            endif;
        else:
            $this->Error  = ["Ops: não encontramos o produto selecionado!", WS_ERROR];
            $this->Result = false;
        endif;
    }

    private function Finish(){
        $this->Info['method'] = $this->Rating;
        $this->Info["status"] = 2;
        $status = 1;

        $Update = new Update();
        $Update->ExeUpdate(self::br_cart, $this->Info, "WHERE id_db_users=:i AND status=:ip", "i={$this->id_user}&ip={$status}");

        if($Update->getResult()):
            $this->Error  = ["Solicitação efectuada com sucesso; a nossa equipe comercial entrará em contato num período máximo de 24 à 72 horas!", WS_ACCEPT];
            $this->Result = true;
        else:
            $this->Error  = ["Ops: aconteceu um erro inesperado ao terminar a solicitação de compra!", WS_ERROR];
            $this->Result = false;
        endif;
    }

    public function CancelAll($id_user){
        $this->id_user = $id_user;

        $st = 1;

        $Read = new Read();
        $Read->ExeRead(self::br_cart, "WHERE id_db_users=:ip AND status=:st", "ip={$this->id_user}&st={$st}");

        if($Read->getResult()):
            $this->RemoveAll();
        else:
            $this->Error  = ["Ops: o Item selecionado já encontra-se disponível no carrinho!", WS_ERROR];
            $this->Result = false;
        endif;
    }

    private function RemoveAll(){
        $st = 1;

        $Delete = new Delete();
        $Delete->ExeDelete(self::br_cart, "WHERE id_db_users=:ip AND status=:st", "ip={$this->id_user}&st={$st}");

        if($Delete->getResult() || $Delete->getRowCount()):
            $this->Result = true;
        else:
            $this->Error  = ["Ops: aconteceu um erro inesperado ao remover o item do carrinho!", WS_ERROR];
            $this->Result = false;
        endif;
    }

    public function NewsLetter($newsEmail){
        $this->Data['email'] = $newsEmail;

        if(in_array("", $this->Data)):
            $this->Error  = ["Ops: preecha o campo <strong>E-mail</strong> para prosseguir com o cadastro na newsletter!", WS_INFOR];
            $this->Result = false;
        else:
            if(Check::Email($this->Data['email'])):
                $Read = new Read();
                $Read->ExeRead(self::br_newsletter, "WHERE email=:i", "i={$this->Data['email']}");

                if($Read->getResult()):
                    $this->Error  = ["Ops: o email: <strong>{$this->Data['email']}</strong> já encontra-se registrado na nossa newsletter!", WS_ALERT];
                    $this->Result = false;
                else:
                    $this->NewsLetters();
                endif;
            else:
                $this->Error  = ["Ops: o formato do email: <strong>{$this->Data['email']}</strong> não é válido!", WS_ALERT];
                $this->Result = false;
            endif;
        endif;
    }

    private function NewsLetters(){
        $this->Data['dia'] = date('d');
        $this->Data['mes'] = date('m');
        $this->Data['ano'] = date('Y');
        $this->Data['status'] = 1;

        $Create = new Create();
        $Create->ExeCreate(self::br_newsletter, $this->Data);

        if($Create->getResult()):
            $this->Error  = ["O e-mail: <strong>{$this->Data['email']}</strong> foi inscrito na nossa newsletter!", WS_ACCEPT];
            $this->Result = true;
        else:
            $this->Error  = ["Ops: aconteceu um erro ao inscrever o e-mail: <strong>{$this->Data['email']}</strong> na newsletter!", WS_ERROR];
            $this->Result = false;
        endif;
    }
}
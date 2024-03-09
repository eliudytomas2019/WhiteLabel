<?php
class ProSmart{
    private $Data, $id_user, $Error, $Result;
    const testemunho = "db_users_commint";

    public function getError(){return $this->Error;}
    public function getResult(){return $this->Result;}

    public function Testimony($id_user, $testemunho){
        $this->id_user = strip_tags(trim($id_user));
        $this->Data['commint'] = strip_tags(trim($testemunho));

        if(!isset($this->id_user) || empty($this->id_user) || !isset($this->Data["commint"]) || empty($this->Data["commint"])):
            $this->Error = ["Ops: preencha todos os campos para prosseguir com o processo!", WS_ERROR];
            $this->Result = false;
        else:
            $this->Data["id_user"] = $this->id_user;
            $this->Data["hora"] = date('H:i:s');
            $this->Data["data"] = date('d-m-Y');
            $this->Data['status'] = 0;

            $Create = new Create();
            $Create->ExeCreate(self::testemunho, $this->Data);

            if($Create->getResult()):
                $this->Result = true;
                $this->Error = ["O seu testemunho foi publicado no nosso site, agradecemos pelo seu contributo!", WS_ACCEPT];
            else:
                $this->Result = false;
                $this->Error = ["Ops: aconteceu um erro inesperado ao adicionar o testemunho ao website!", WS_ERROR];
            endif;
        endif;
    }
}
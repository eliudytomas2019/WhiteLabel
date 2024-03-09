<?php

class DataProcessing{
    private
        $Data, $Error, $Result, $Belma,
        $id_system, $id_user, $id_panel, $dba, $id_result,
        $Nucleus, $Logotype, $Infor, $Alert, $Dice, $Email, $level;

    const
        db_settings = 'db_settings',
        entity = 'db_kwanzar',
        db_users = 'db_users';

    public function getError(){return $this->Error;}
    public function getResult(){return $this->Result;}
    public function __construct($id_db_kwanzar = null, $id_user = null, $level = null){
        $this->level = (int) $level;
        $this->id_user = (int) $id_user;
        $this->id_system = (int) $id_db_kwanzar;
        if(isset($this->id_system) || !empty($this->id_system)):
            if(isset($this->level) && $this->level == 5):
                $Read = new Read();
                $Read->ExeRead(self::db_users, "WHERE id=:i", "i='{$this->id_user}'");
                if($Read->getResult()):
                    $key = $Read->getResult()[0];
                    if($key['level'] != $this->level):
                        $this->Result = false;
                    else:
                        $Read->ExeRead(self::db_settings);
                        if($Read->getResult()):
                            foreach ($Read->getResult() as $item):
                                if($item["id_db_kwanzar"] == null || empty($item["id_db_kwanzar"]) || $item["id_db_kwanzar"] == null):
                                    $Xitem["id_db_kwanzar"] = $this->id_system;
                                    $Update = new Update();
                                    $Update->ExeUpdate(self::db_settings, $Xitem,"WHERE id=:i ", "i='{$item['id']}'");
                                    if(!$Update->getResult()):
                                        $this->Result = false;
                                    else:
                                        $this->Result = true;
                                    endif;
                                endif;
                            endforeach;
                        endif;
                    endif;
                endif;
            endif;
        endif;
    }
    /**
     * @param array $Data
     * @param null $id_db_kwanzar
     */
    public function  Settings(array $Data, $id_db_kwanzar = null){
        $this->Data = $Data;
        $this->id_panel = (int) $id_db_kwanzar;

        $this->Verifications($this->Data);
        if($this->Result):
            if(isset($this->Data['nif']) || !empty($this->Data["nif"])):
                $this->Verification();
            else:
                $this->Data['id_db_kwanzar'] = $this->id_panel;
            endif;

            if($this->Result):
                $this->Data['status'] = 1;
                $this->Data["dia"] = date('d');
                $this->Data["mes"] = date('m');
                $this->Data['ano'] = date('Y');
                $this->CreateData(self::db_settings, $this->Data);
                if($this->Result):
                    $this->Error  = ["Operação realizada com sucesso! empresa <strong>{$this->Data['empresa']}</strong> foi registrada.", WS_ACCEPT];
                    $this->Result = true;
                else:
                    $this->Error  = ["Oops: aconteceu um erro inesperado ao criar a empresa <strong>{$this->Data['empresa']}</strong>...", WS_ERROR];
                    $this->Result = false;
                endif;
            endif;
        endif;
    }

    /**
     *
     */
    public function Verification(){
        $Read = new Read();
        $Read->ExeRead(self::db_settings, "WHERE  nif=:nif", "nif={$this->Data['nif']}");

        if($Read->getResult()):
            $this->Error  = ["Oops: o NIF: {$this->Data['nif']}, já encontra-se em uso no sistema!", WS_ALERT];
            $this->Result = false;
        else:
            $this->Data['id_db_kwanzar'] = $this->id_panel;
            $this->Result = true;
        endif;
    }

    /**
     * @param $Email
     */
    public function CheckUserExistence($Email){
        $this->Email = strip_tags(trim($Email));

        if(Check::Email($this->Email)):
            $Read = new Read();
            $Read->ExeRead(self::db_users, "WHERE username=:user", "user={$this->Email}");

            if ($Read->getResult()):
                $this->Error = ["Oops: o E-mail: <strong>{$this->Email}</strong>, já encontra-se em uso.", WS_ALERT];
                $this->Result = false;
            else:
                $this->Result = true;
            endif;
        else:
            $this->Result = false;
            $this->Error = ["Introduza email válido!", WS_INFOR];
        endif;
    }

    /**
     * @param array $Data
     */
    public function CreateNewAccount(array $Data){
        $this->Data = $Data;
        $this->Data["name"] = strip_tags(trim($this->Data['name']));
        $this->Data['username'] = strip_tags(trim($this->Data['username']));
        $this->Data['telefone'] = strip_tags(trim($this->Data['telefone']));
        $this->Data['password'] = strip_tags(trim($this->Data['password']));

        $this->Verifications($this->Data);
        if($this->Result):
            $this->VerificationPassword($this->Data);
            if($this->Result):
                unset($this->Nucleus);
                $this->Nucleus["dia"] = date("d");
                $this->Nucleus["mes"] = date("m");
                $this->Nucleus["ano"] = date("Y");
                $this->Nucleus["hora"] = date("H:i:s");
                $this->Nucleus["status"] = 1;
                $this->CreateData(self::entity, $this->Nucleus);
                if($this->Result):
                    unset($this->Nucleus);
                    $this->CheckUserExistence($this->Data['username']);
                    if($this->Result):
                        unset($this->Nucleus);
                        $Read = new Read();
                        $Read->ExeRead(self::entity, "ORDER BY id DESC LIMIT 1");

                        if($Read->getResult()):
                            $this->Data['id_db_kwanzar'] = $Read->getResult()[0]['id'];
                            $this->Belma = $Read->getResult()[0]['id'];
                        else:
                            $this->Data['id_db_kwanzar'] = 1;
                        endif;

                        $this->Data['registration'] = date('d-m-Y H:i:s');

                        $Read = new Read();
                        $Read->ExeRead(self::db_users);
                        if(!$Read->getResult() || !$Read->getRowCount()):
                            $this->Data['level'] = 5;
                        else:
                            $this->Data['level'] = 4;
                        endif;

                        $this->Data['st'] = 1;
                        $this->Data['status'] = 1;
                        $this->Data['block'] = 1;
                        $this->Data['password'] = md5($this->Data['password']);
                        $this->CreateData(self::db_users, $this->Data);
                        if($this->Result):
                            unset($this->Nucleus);
                            $Ws = new WSKwanzar();
                            if (!empty($this->Belma)):
                                $Ws->Times($this->Belma);
                            endif;

                            if ($Ws->getResult()):
                                $this->Error = ["Conta de usuário criada com sucesso!", WS_ACCEPT];
                                $this->Result = true;
                            else:
                                $this->Error = ["Oops: aconteceu um erro inesperado ao ativar a licença do software!", WS_ALERT];
                                $this->Result = false;
                            endif;
                        endif;
                    endif;
                else:
                    $this->Result = false;
                    $this->Error  = ["Oops: aconteceu um erro inesperado ao criar o painel de usuários!", WS_ERROR];
                endif;
            endif;
        endif;
    }

    private function VerificationPassword($data){
        if(strlen($data['password']) < 8 || strlen($data['password']) > 32):
            $this->Error = ["O campo senha deve ter no minimo 8 caracteres e máximo 32 caracteres!", WS_INFOR];
            $this->Result = false;
        elseif(!preg_match('/\d+/', $data['password']) > 0):
            $this->Error = ["O Campo senha deve conter números!", WS_INFOR];
            $this->Result = false;
        elseif(!preg_match('/\p{Lu}/u', $data['password'])):
            $this->Result = false;
            $this->Error = ["O campo senha deve ter no minimo uma letra maíuscula!", WS_ALERT];
        elseif(!preg_match('/[!#*,.?@&%]/', $data['password'])):
            $this->Result = false;
            $this->Error = ["O campo senha deve conter caracteres especiais!", WS_ALERT];
        else:
            $this->Result = true;
        endif;
    }

    /**
     * @param $dba
     * @param array $Dice
     */
    private function CreateData($dba, array $Dice){
        $this->Dice = $Dice;
        $this->dba = $dba;

        $Create = new Create();
        $Create->ExeCreate("{$this->dba}", $this->Dice);

        if($Create->getResult()):
            $this->id_result = $Create->getResult();
            $this->Result = true;
        else:
            $this->Result = false;
        endif;
    }

    /**
     * Verificar os dados recebidos para; filtrar as informações todas!
     * @param array $data
     */
    private function Verifications(array $data){
        if(in_array("", $data)):
            $this->Error = ["Preencha todos os campos para prosseguir com o processo!", WS_ALERT];
            $this->Result = false;
        elseif(isset($data["username"]) && !Check::Email($data['username']) || isset($data['email']) && !Check::Email($data['email'])):
            $this->Error = ["Introduza e-mail válido!", WS_ALERT];
            $this->Result = false;
        elseif (isset($data['nif']) && strlen($data['nif']) < 9 || isset($data['nif']) && strlen($data['nif']) > 35):
            $this->Error  = ["Introduza um NIF válido!", WS_INFOR];
            $this->Result = false;
        elseif (isset($data['telefone']) && !is_numeric($data['telefone'])):
            $this->Error  = ["Introduza número de telefone válido!", WS_INFOR];
            $this->Result = false;
        elseif (isset($data['telefone']) && strlen($data['telefone']) < 9 || isset($data['telefone']) && strlen($data['telefone']) > 9):
            $this->Error  = ["Introduza número de telefone válido!", WS_INFOR];
            $this->Result = false;
        elseif (isset($data['username'])):
            if (!Check::Email($data['username'])):
                $this->Error = ["Introduza um email válido para prosseguir com o processo!", WS_INFOR];
                $this->Result = false;
            else:
                $this->Result = true;
            endif;
        else:
            $this->Error = ["", WS_ERROR];
            $this->Result = true;
        endif;
    }
}
<?php
class DBKwanzar{
    /**** Regras da class ****/
    private
        $Data,
        $id_db_kwanzar,
        $id_db_settings,
        $File, $Result,
        $Error,
        $Session,
        $IDEmpresa,
        $IDcPanel,
        $Info,
        $Database,
        $postId,
        $ID;

    const
        entity = 'db_kwanzar',
        db_settings = 'db_settings',
        db_active = 'db_active',
        db_users = 'db_users',
        db_config = 'db_config',
        db_config_users = 'db_users_settings',
        settings_gallery = 'db_settings_gallery',
        db_users_active_store = "db_users_active_store";

    /**** Metodos publico ****/
    /**
     * @param $Session
     */
    function __construct($Session = null){
        $this->Session = (int)$Session;
    }

    /**
     * @return mixed
     */
    public function getError(){
        return $this->Error;
    }

    /**
     * @return mixed
     */
    public function getResult(){
        return $this->Result;
    }

    /**** Metodos de checagem ****/
    public function Checking(array $data){
        if (in_array('', $data)):
            $this->Error = ["Ops: preencha todos os campos para prosseguir com o processo!", WS_ALERT];
            $this->Result = false;
        elseif (isset($data['nif'])):
            if(strlen($data['nif']) < 9 || strlen($data['nif']) > 35):
                $this->Error  = ["Ops: introduza um NIF válido!", WS_INFOR];
                $this->Result = false;
            else:
                $this->Result = true;
            endif;
        elseif (isset($data['username'])):
            if (!Check::Email($data['username'])):
                $this->Error = ["Ops: introduza um email válido para prosseguir com o processo!", WS_INFOR];
                $this->Result = false;
            else:
                $this->Result = true;
            endif;
        elseif(isset($data['password'])):
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
                $this->Error = ["", WS_ACCEPT];
                $this->Result = true;
            endif;
        else:
            $this->Error = ["", WS_INFOR];
            $this->Result = true;
        endif;
    }


    /**** Criar conta ****/
    /**
     * @param array $Data
     */
    public function CreateAccounting(array $Data){
        $this->Data = $Data;

        // Função para checar as os ficheiros dentro desta classe!
        $this->Checking($Data);
        if ($this->Result):
            // Função para criar o cPanel
            $this->CreateCpanel();
            if ($this->Result):
                // Verificar se o nome de usuário já está em uso no sistema.
                $this->CheckUsers($this->Data['username']);
                if ($this->Result):
                    $this->Data['md5'] = md5($this->Data['password']);
                    // Função para criar o primeiro usuário da empresa (super usuário);
                    $this->CreteUsers();
                    if ($this->Result):
                        // Ativar a licença do software.
                        $Ws = new WSKwanzar();
                        if (!empty($this->id_db_kwanzar)):
                            $Ws->Times($this->id_db_kwanzar);
                        endif;

                        if ($Ws->getResult()):
                            $this->Error = ["Operação concluída com sucesso!", WS_ACCEPT];
                            $this->Result = true;
                        else:
                            $this->Error = ["Ops: aconteceu um erro inesperado ao ativar a licença do kwanzar!", WS_ALERT];
                            $this->Result = false;
                        endif;
                    endif;
                endif;
            endif;
        else:
            $this->Result = false;
        endif;
    }

    private function  CreateCpanel(){
        $Data = [
            'dia' => date('d'),
            'mes' => date('m'),
            'ano' => date('Y'),
            'hora' => date('H:i:s'),
            'status' => 1
        ];

        $Create = new Create();
        $Create->ExeCreate(self::entity, $Data);

        if ($Create->getResult()):
            $this->id_db_kwanzar = $Create->getResult();
            $this->Result = true;
        else:
            $this->Error = ["Ops: aconteceu um erro ao criar o cPanel, atualize a página e tente novamente!", WS_ERROR];
            $this->Result = false;
        endif;
    }

    /**
     * @param $Email
     */
    public function CheckUsers($Email){
        $this->Data['username'] = $Email;

        $Read = new Read();
        $Read->ExeRead(self::db_users, "WHERE username=:user", "user={$this->Data['username']}");

        if ($Read->getResult()):
            $this->Error = ["Ops: o E-mail: <strong>{$this->Data['username']}</strong>, já encontra-se em uso.", WS_ALERT];
            $this->Result = false;
        else:
            $this->Result = true;
        endif;
    }

    public function CheckUsersII($Username){
        $this->Data['email'] = $Username;

        $Read = new Read();
        $Read->ExeRead(self::db_users, "WHERE email=:user", "user={$this->Data['email']}");

        if ($Read->getResult()):
            $this->Error = ["Ops: o Username: <strong>{$this->Data['email']}</strong>, já encontra-se em uso.", WS_ALERT];
            $this->Result = false;
        else:
            $this->Result = true;
        endif;
    }

    private function CreteUsers(){
        $Data = [
            'id_db_kwanzar' => $this->id_db_kwanzar,
            'name' => $this->Data['name'],
            'username' => $this->Data['username'],
            'password' => $this->Data['md5'],
            'registration' => date('d-m-Y H:i:s'),
            'level' => 4,
            'st' => 1,
            'status' => 1,
            'block'  => 1
        ];

        $Create = new Create();
        $Create->ExeCreate(self::db_users, $Data);

        if ($Create->getResult()):
            $this->Result = true;
        else:
            $this->Error = ["Ops: aconteceu um erro inesperado ao  criar o usuário!", WS_ERROR];
            $this->Result = false;
        endif;
    }

    /**
     * @param $id_db_kwanzar
     * @return bool
     */
    public static function CheckCPanel($id_db_kwanzar){
        //$this->id_db_kwanzar = $id_db_kwanzar;
        $Read = new Read();
        $Read->ExeRead(self::entity, "WHERE id=:i", "i={$id_db_kwanzar}");

        if ($Read->getResult()):
            return $Read->getResult()[0];
        else:
            return false;
        endif;
    }

    /**
     * @param $id_db_kwanzar
     * @return bool
     */
    public static function CheckSettings($id_db_kwanzar){
        //$this->id_db_kwanzar = $id_db_kwanzar;
        $Read = new Read();
        $Read->ExeRead(self::db_settings, "WHERE id_db_kwanzar=:i", "i={$id_db_kwanzar}");

        if ($Read->getResult()):
            return $Read->getRowCount();
        else:
            return 0;
        endif;
    }

    /**
     * @param array $Data
     * @param null $id_db_kwanzar
     */
    public function CreateSettings(array $Data, $id_db_kwanzar = null){
        $this->Data = $Data;
        $this->id_db_kwanzar = $id_db_kwanzar;

        $this->Checking($this->Data);
        if($this->Result):
            $this->Verification();
            if($this->Result):
                $this->CreateSetting();
            endif;
        endif;
    }

    public function Verification(){
        $Read = new Read();
        $Read->ExeRead(self::db_settings, "WHERE id_db_kwanzar=:i AND empresa=:emp AND nif=:nif AND taxEntity=:tax", "i={$this->id_db_kwanzar}&emp={$this->Data['empresa']}&nif={$this->Data['nif']}&tax={$this->Data['taxEntity']}");

        if($Read->getResult()):
            $this->Error  = ["Ops: já existe uma empresa com os presentes dados e o mesmo número de filiar!", WS_ALERT];
            $this->Result = false;
        else:
            $this->Data['id_db_kwanzar'] = $this->id_db_kwanzar;
            $this->Result = true;
        endif;
    }

    private function CreateSetting(){
        $this->Data['status'] = 1;
        $Create = new Create();
        $Create->ExeCreate(self::db_settings, $this->Data);

        if($Create->getResult()):
            $this->Error  = ["Operação realizada com sucesso! empresa <strong>{$this->Data['empresa']}</strong> foi registrada.", WS_ACCEPT];
            $this->Result = true;
        else:
            $this->Error  = ["Ops: aconteceu um erro inesperado ao criar a empresa <strong>{$this->Data['empresa']}</strong>...", WS_ERROR];
            $this->Result = false;
        endif;
    }

    /**
     * @param array $data
     * @param null $id_db_settings
     * @param null $id_db_kwanzar
     */
    public function ExeNiB(array $data, $id_db_settings = null, $id_db_kwanzar = null){
        $this->Data = $data;
        $this->id_db_settings = $id_db_settings;
        $this->id_db_kwanzar = $id_db_kwanzar;

        /*$this->Checking($this->Data);
        if($this->Result):

        endif;**/

        $this->CheckCpanelAndSettings($this->id_db_settings, $this->id_db_kwanzar);
        if($this->Result):
            $this->Data["cef_nib"] = 1;
            $this->Update();
        else:
            $this->Error  = ["Ops: a empresa selecionada não pertence ao presente cPanel!", WS_ERROR];
            $this->Result = false;
        endif;
    }

    /**
     * @param null $id_db_settings
     * @param null $id_db_kwanzar
     * @return bool
     */
    public function CheckCpanelAndSettings($id_db_settings = null, $id_db_kwanzar = null){
        $this->id_db_kwanzar = $id_db_kwanzar;
        $this->id_db_settings = $id_db_settings;


        if(isset($this->id_db_kwanzar) && isset($this->id_db_settings)):
            $Value = "id={$this->id_db_settings} AND id_db_kwanzar={$this->id_db_kwanzar}";
        elseif(isset($this->id_db_kwanzar) && !isset($this->id_db_settings)):
            $Value = "id_db_kwanzar={$this->id_db_kwanzar} ";
        elseif(isset($this->id_db_settings) && !isset($this->id_db_kwanzar)):
            $Value = "id={$this->id_db_settings} ";
        endif;

        $Read = new Read();
        $Read->ExeRead(self::db_settings, "WHERE {$Value}");

        if($Read->getResult()):
            $this->Result = true;
            return $Read->getResult()[0];
        else:
            $this->Result = false;
            return false;
        endif;
    }

    public function Times($id){
        $Read = new Read();
        $Read->ExeRead(self::entity, "WHERE id=:i ", "i={$id}");

        if($Read->getResult()):
            $this->Result = true;
            return true;
        else:
            $this->Result = false;
            return false;
        endif;
    }


    /**
     * @param array|null $data
     */
    private function  Update(array $data = null){
        if($data != null): $this->Data = $data; endif;

        $Update = new Update();
        $Update->ExeUpdate(self::db_settings, $this->Data,  "WHERE id=:i AND id_db_kwanzar=:ip", "i={$this->id_db_settings}&ip={$this->id_db_kwanzar}");

        if($Update->getResult()):
            $this->Error  = ["Operação realizada com sucesso!", WS_ACCEPT];
            $this->Result = true;
        else:
            $this->Error  = ["Ops: aconteceu um erro inesperado ao salvar os dados!", WS_ALERT];
            $this->Result = false;
        endif;
    }

    /**
     * @param array $data
     * @param null $id_db_settings
     * @param null $id_db_kwanzar
     */
    public function ExeUpdate(array $data, $id_db_settings = null, $id_db_kwanzar = null){
        $this->Data           = $data;
        $this->id_db_settings = $id_db_settings;
        $this->id_db_kwanzar  = $id_db_kwanzar;

        $this->Checking($this->Data);
        if($this->Result):
            $this->CheckCpanelAndSettings($this->id_db_settings, $this->id_db_kwanzar);
            if($this->Result):
                $this->VerFile();
                if($this->Result):
                    $this->Data["cef"] = 1;
                    $this->Update();
                endif;
            else:
                $this->Error  = ["Ops: a empresa selecionada não pertence ao presente cPanel!", WS_ERROR];
                $this->Result = false;
            endif;
        endif;
    }

    private function VerFile(){
        $Read = new Read();
        $Read->ExeRead(self::db_settings, "WHERE id !=:ip AND empresa=:emp AND nif=:nif AND taxEntity=:tax", "ip={$this->id_db_settings}&emp={$this->Data['empresa']}&nif={$this->Data['nif']}&tax={$this->Data['taxEntity']}");

        if($Read->getResult()):
            $this->Error  = ["Ops: já existe uma empresa com os presentes dados e o mesmo número de filiar!", WS_ALERT];
            $this->Result = false;
        else:
            //$this->Data['id_db_kwanzar'] = $this->id_db_kwanzar;
            $this->Result = true;
        endif;
    }

    public function ExeData(array $file, $id_db_settings, $id_db_kwanzar){
            $this->File = $file;
        $this->id_db_kwanzar = $id_db_kwanzar;
        $this->id_db_settings = $id_db_settings;

        $this->CheckCpanelAndSettings($this->id_db_settings, $this->id_db_kwanzar);
        if($this->Result):
            if(!in_array('', $this->File)):
                $this->SendLogotype();
            else:
                $this->File['logotype'] = '';
            endif;

            $this->Update($this->File);
        else:
            $this->Error  = ["Ops: a empresa selecionada não pertence ao presente cPanel!", WS_ERROR];
            $this->Result = false;
        endif;
    }

    private function SendLogotype(){
        if(!empty($this->File['logotype']['tmp_name'])):
            $Upload = new Upload;
            $Upload->Image($this->File['logotype']);

            if($Upload->getError()):
                $this->Error = $Upload->getError();
                $this->Result = false;
            else:
                $this->File['logotype'] = $Upload->getResult();
                $this->Result = true;
            endif;
        endif;
    }

    /**
     * @param array $data
     * @param $id_db_settings
     * @param $id_db_kwanzar
     */
    public function ExeConfig(array $data, $id_db_settings, $id_db_kwanzar){
        $this->Data = $data;
        $this->id_db_kwanzar = $id_db_kwanzar;
        $this->id_db_settings = $id_db_settings;

        $this->CheckCpanelAndSettings($this->id_db_settings, $this->id_db_kwanzar);
        if($this->Result):
            if(!empty($this->Data['taxa_preferencial']) && !is_numeric($this->Data['taxa_preferencial']) || !empty($this->Data['cambio_atual']) && !is_numeric($this->Data['cambio_atual']) ||!empty($this->Data['cambio_x_preco']) && !is_numeric($this->Data['cambio_x_preco']) || !empty($this->Data['porcentagem_x_cambio']) && !is_numeric($this->Data['porcentagem_x_cambio'])):
                $this->Result  = false;
                $this->Error = ["Os campos: Taxa de Imposto Preferêncial, Câmbio Atual, Atualizar os preços o Câmbio? e % de lucro pelo Câmbio são do tipo númerico!", WS_ERROR];
            endif;

            $Read = new Read();
            $Read->ExeRead(self::db_config, "WHERE id_db_kwanzar=:i AND id_db_settings=:ip", "i={$this->id_db_kwanzar}&ip={$this->id_db_settings}");
            if($Read->getResult()):
                $this->ID = $Read->getResult()[0]['id'];
                $this->Data["cef"] = 1;
                $this->UpdateConfig();
            else:
                $this->Data['id_db_settings'] = $this->id_db_settings;
                $this->Data['id_db_kwanzar']  = $this->id_db_kwanzar;
                $this->CreateConfig();
            endif;
        endif;
        //endif;
    }

    private function UpdateConfig(){
        $Update = new Update();
        $Update->ExeUpdate(self::db_config, $this->Data, "WHERE id=:i AND id_db_kwanzar=:ip AND id_db_settings=:id", "i={$this->ID}&ip={$this->id_db_kwanzar}&id={$this->id_db_settings}");

        if($Update->getResult()):
            $this->Error  = ["Operação realizada com sucesso, as <strong>Configurações</strong> da empresa foram alteradas!", WS_ACCEPT];
            $this->Result = true;
        else:
            $this->Error  = ["Ops: aconteceu um erro inesperado ao criar as configurações da conta!", WS_ERROR];
            $this->Result = false;
        endif;
    }

    private function CreateConfig(){
        $Create = new Create();
        $Create->ExeCreate(self::db_config, $this->Data);

        if($Create->getResult()):
            $this->Error  = ["Operação realizada com sucesso, as <strong>Configurações</strong> da empresa foram criadas!", WS_ACCEPT];
            $this->Result = true;
        else:
            $this->Error  = ["Ops: aconteceu um erro inesperado ao criar as configurações da conta!", WS_ERROR];
            $this->Result = false;
        endif;
    }

    public function ExeUsers(array $data, $id_db_settings, $id_db_kwanzar){
        $this->id_db_kwanzar = $id_db_kwanzar;
        $this->id_db_settings = $id_db_settings;
        $this->Data = $data;

        if(isset($this->Data['email']) && !empty($this->Data['email'])):
            $this->Data['email'] = str_replace([' ', '.', ',','#', '@', '?', '=', '^', '~', "º", "ç", "-"], '', $this->Data['email']);
            $this->Data['email']     = strtolower($this->Data['email']);
        else:
            $this->Data['email'] = null;
        endif;

        $this->Checking($this->Data);
        if($this->Result):
            $this->CheckCpanelAndSettings($this->id_db_settings, $this->id_db_kwanzar);
            if($this->Result):
                $this->CheckUsers($this->Data['username']);
                if($this->Result):
                    $this->CheckUsersII($this->Data['email']);
                    if($this->Result):
                        $this->Data['id_db_settings'] = $this->id_db_settings;
                        $this->Data['id_db_kwanzar'] = $this->id_db_kwanzar;
                        $this->Data['password'] = md5('123456');
                        $this->Data['registration'] = date('d-m-Y H:i:s');
                        $this->Data['status'] = 1;
                        $this->Data['st'] = 0;
                        $this->CreateUsers();
                    endif;
                endif;
            endif;
        endif;
    }

    private function CreateUsers(){
        $Create = new Create();
        $Create->ExeCreate(self::db_users, $this->Data);

        if ($Create->getResult()):
            $this->Error  = ["Operação realizada com sucesso!", WS_ACCEPT];
            $this->Result = true;
        else:
            $this->Error = ["Ops: aconteceu um erro inesperado ao  criar o usuário!", WS_ERROR];
            $this->Result = false;
        endif;
    }


    /**
     * @param $IdUsers
     * @param null $id_db_settings
     * @param null $id_db_kwanzar
     */
    public function SuspenderConta($IdUsers, $id_db_settings = null, $id_db_kwanzar = null){
        $this->ID = $IdUsers;
        $this->id_db_kwanzar = $id_db_kwanzar;
        $this->id_db_settings = $id_db_settings;

        $Read = new Read();
        $Read->ExeRead(self::db_users, "WHERE id=:i", "i={$this->ID}");

        if($Read->getResult()):
            $this->Data['level'] = $Read->getResult()[0]['level'];
            if($Read->getResult()[0]['status'] == 1): $this->Data['status'] = 0; else: $this->Data['status'] = 1; endif;

            if($this->Data['level'] == 5):
                $this->Error  = ["Ops: não é permitido suspender a conta de um administrador!", WS_INFOR];
                $this->Result = false;
            else:
                $this->UpdateUsers();
            endif;
        endif;
    }

    private function UpdateUsers(){
        $Update = new Update();
        $Update->ExeUpdate(self::db_users, $this->Data, "WHERE id=:i ", "i={$this->ID}");

        if($Update->getResult()):
            $this->Error  = ["Operação realizada com sucesso!", WS_ACCEPT];
            $this->Result = true;
        else:
            $this->Error = ["Ops: aconteceu um erro inesperado ao  atualizar o usuário!", WS_ERROR];
            $this->Result = false;
        endif;
    }

    /**
     * @param $IdUsers
     * @param null $id_db_settings
     * @param null $id_db_kwanzar
     */
    public function DeleteUsers($IdUsers, $id_db_settings = null, $id_db_kwanzar = null){
        $this->ID = $IdUsers;
        $this->id_db_kwanzar = $id_db_kwanzar;
        $this->id_db_settings = $id_db_settings;

        $Read = new Read();
        $Read->ExeRead(self::db_users, "WHERE id=:i AND id_db_kwanzar=:ip", "i={$this->ID}&ip={$this->id_db_kwanzar}");

        if($Read->getResult()):
            $this->Data = $Read->getResult()[0];

            if($this->Data['level'] == 4):
                $this->Error  = ["Ops: não é permitido eliminar um administrador!", WS_INFOR];
                $this->Result = false;
            else:
                $this->Delete();
            endif;
        endif;
    }

    private function Delete(){
        $Delete = new Delete();
        $Delete->ExeDelete(self::db_users, "WHERE id=:i AND id_db_kwanzar=:ip", "i={$this->ID}&ip={$this->id_db_kwanzar}");

        if($Delete->getResult() || $Delete->getRowCount()):
            $this->Error  = ["Usuário <strong>{$this->Data['name']}</strong>, foi eliminado com sucessso!", WS_INFOR];
            $this->Result = true;
        else:
            $this->Error  = ["Ops: aconteceu um erro inesperado ao deletear o usuário <strong>{$this->Data['name']}</strong>.", WS_ALERT];
            $this->Result = false;
        endif;
    }

    /**
     * @param $id
     * @param $id_db_kwanzar
     */
    public function LockScreen($id, $id_db_kwanzar){
        $this->ID = $id;
        $this->id_db_kwanzar = $id_db_kwanzar;

        $this->Data['block'] = 0;
        $this->UpdateUsers();
    }

    /**
     * @param array $data
     * @param $Session
     * @param null | $id_db_kwanzar
     */
    public function ExePassword(array $data, $Session, $id_db_kwanzar = null){
        $this->Data = $data;
        $this->Session = $Session;
        $this->id_db_kwanzar = $id_db_kwanzar;

        $this->Checking($this->Data);
        if($this->Result):
            if($this->Data['password_atual'] == $this->Data['password']):
                $this->Error  = ["Ops: a nova senha não pode ser igual a senha anterior!", WS_INFOR];
                $this->Result = false;
            else:
                $Read = new Read();
                $Read->ExeRead(self::db_users, "WHERE id=:i ", "i={$this->Session}");
                if($Read->getResult()):
                    $Dt = $Read->getResult()[0];
                    $this->Data['password_atual'] = md5($this->Data['password_atual']);

                    if($Dt['password'] != $this->Data['password_atual']):
                        $this->Error  = ["Ops: senha atual está incorreta. Tente novamente!", WS_INFOR];
                        $this->Result = false;
                    else:
                        $this->Password();
                    endif;
                endif;
            endif;
        endif;
    }

    public function RecoverPassword(array $data, $Session, $id_db_kwanzar = null){
        $this->Data = $data;
        $this->Session = $Session;
        $this->id_db_kwanzar = $id_db_kwanzar;

        $this->Checking($this->Data);
        if($this->Result):
            $this->Password();
        endif;
    }

    /**
     *
     */
    private function Password(){
        $Data = [
            'password' => md5($this->Data['password']),
            'st' => 1,
            'block' => 1
        ];

        $Update = new Update();
        $Update->ExeUpdate(self::db_users, $Data, "WHERE id=:i ", "i={$this->Session}");

        if($Update->getResult()):
            $this->Error  = ["Operação realizada com sucesso!", WS_ACCEPT];
            $this->Result = true;
        else:
            $this->Error  = ["Ops: aconteceu um erro inesperado ao atualizar a senha!", WS_ERROR];
            $this->Result = false;
        endif;
    }

    public static function CheckConfig($id_db_settings){
        $Read = new Read();
        $Read->ExeRead(self::db_config, "WHERE id_db_settings=:i", "i={$id_db_settings}");

        if($Read->getResult()):
            return $Read->getResult()[0];
        else:
            return false;
        endif;
    }

    /**
     * @param $id_db_settings
     * @return bool
     */
    public static function CheckSettingsII($id_db_settings){
        $Read = new Read();
        $Read->ExeRead(self::db_settings, "WHERE id=:i", "i={$id_db_settings}");

        if($Read->getResult()):
            return $Read->getResult()[0];
        else:
            return false;
        endif;
    }

    /**
     * @param array $data
     * @param $id_db_settings
     * @param $id_user
     */
    public function UsersConfig(array $data, $id_db_settings, $id_user){
        $this->Data = $data;
        $this->id_db_settings = $id_db_settings;
        $this->Session = $id_user;

        if($this->Data["Impression"] == '' || empty($this->Data["Impression"]) || $this->Data["NumberOfCopies"] == '' || empty($this->Data["NumberOfCopies"])):
            $this->Error  = ["Ops: preencha os campos: 'Modelo de impressora & Número de páginas' para prosseguir com o processo!", WS_INFOR];
            $this->Result = false;
        else:
            $Read = new Read();
            $Read->ExeRead(self::db_config_users, "WHERE id_db_settings=:i AND session_id=:ses", "i={$this->id_db_settings}&ses={$this->Session}");

            $this->Data["cef"] = 1;

            if($Read->getResult()):
                $this->UpdateUsersConfig();
            else:
                $this->CreateUsersConfig();
            endif;
        endif;
    }

    private function UpdateUsersConfig(){
        $Update = new Update();
        $Update->ExeUpdate(self::db_config_users, $this->Data, "WHERE id_db_settings=:i AND session_id=:ses", "i={$this->id_db_settings}&ses={$this->Session}");

        if($Update->getResult()):
            $this->Error  = ["Operação realizada com sucesso!", WS_ACCEPT];
            $this->Result = true;
        else:
            $this->Error  = ["Ops: aconteceu um erro inesperado ao atualizar as configurações!", WS_ERROR];
            $this->Result = false;
        endif;
    }

    private function CreateUsersConfig(){
        $this->Data['id_db_settings'] = $this->id_db_settings;
        $this->Data['session_id'] = $this->Session;

        $Create = new Create();
        $Create->ExeCreate(self::db_config_users, $this->Data);

        if($Create->getResult()):
            $this->Error  = ["Operação realizada com sucesso!", WS_ACCEPT];
            $this->Result = true;
        else:
            $this->Error  = ["Ops: aconteceu um erro inesperado ao atualizar as configurações!", WS_ERROR];
            $this->Result = false;
        endif;
    }

    /**
     * @param $id_db_settings
     * @param $session_id
     * @return bool
     */
    public static function CheckUsersConfig($id_db_settings, $session_id){
        $Read = new Read();
        $Read->ExeRead(self::db_config_users, "WHERE id_db_settings=:i AND session_id=:ses", "i={$id_db_settings}&ses={$session_id}");

        if($Read->getResult()):
            return $Read->getResult()[0];
        else:
            return false;
        endif;
    }

    /**
     * @param $Session
     * @param $id_db_settings
     * @param array $data
     */
    public function ExeUsersUpdate($Session, $id_db_settings, array $data){
        $this->Session        = $Session;
        $this->id_db_settings = $id_db_settings;
        $this->Data           = $data;

        unset($this->Data['SendPostForm']);

        $Read = new Read();
        $Read->ExeRead(self::db_users, "WHERE id=:i AND id_db_settings=:ip", "i={$this->Session}&ip={$this->id_db_settings}");

        if($Read->getResult()):
            $this->UsersUpdate();
        else:
            $this->Error  = ["Ops: não encontramos nenhum usuário!", WS_ALERT];
            $this->Result = false;
        endif;
    }

    private function UsersUpdate(){
        $Update = new Update();
        $Update->ExeUpdate(self::db_users, $this->Data, "WHERE id=:i AND id_db_settings=:ip", "i={$this->Session}&ip={$this->id_db_settings}");

        if($Update->getResult()):
            $this->Error  = ["Operação realizada com sucesso!", WS_ACCEPT];
            $this->Result = true;
        else:
            $this->Error  = ["Ops: aconteceu um erro inesperado ao atualizar os dados do usuário!", WS_ERROR];
            $this->Result = false;
        endif;
    }

    /**
     * @param $id_user
     * @param $ClienteData
     * @param null $file
     */
    public function ExeProfile($id_user, $ClienteData, $file = null){
        $this->Session = $id_user;
        $this->Data = $ClienteData;
        $this->File = $file;

        if($this->File != null):
            $this->Covers();
        endif;

        if(in_array('', $this->Data)):
            $this->Result = false;
            $this->Error = ["Preencha todos os campos para prosseguir com a atualização do perfil!", WS_INFOR];
        elseif(strlen($this->Data['telefone']) > 9 || strlen($this->Data['telefone']) < 9):
            $this->Result = false;
            $this->Error = ["Introduza um telefone válido!", WS_ALERT];
        else:
            $this->DataProfile();
        endif;
    }

    private function Covers(){
        $File = new Upload();
        $File->Image($this->File);

        if($File->getResult()):
            $this->File['cover'] = $File->getResult();

            $Data = ['cover' => $this->File['cover']];
            $Update = new Update();
            $Update->ExeUpdate(self::db_users, $Data, "WHERE id=:i", "i={$this->Session}");

            if($Update->getResult()):
                $this->Error = ["Imagem carregada com sucesso, as alterações serão vizives na próxima sessão!", WS_ACCEPT];
                $this->Result = true;
            else:
                $this->Error = ["Ops: aconteceu um erro fatal ao salvar a imagem, atualize a página e tente novamente!", WS_ERROR];
                $this->Result = false;
            endif;
        else:
            $this->Error = ["Ops: aconteceu um erro ao carregar a foto, atualize a página e tente novamente!", WS_ERROR];
            $this->Result = false;
        endif;
    }

    private function DataProfile(){
        $Data['name'] = strip_tags(trim($this->Data['name']));
        $Data['telefone'] = strip_tags(trim($this->Data['telefone']));
        //$Data = ["name" => $this->Data['name']];

        $Read = new Update();
        $Read->ExeUpdate(self::db_users, $Data, "WHERE id=:id", "id={$this->Session}");

        if($Read->getResult()):
            $this->Error = ["O nome do usuário foi atualizado para <strong>{$this->Data['name']}</strong>, as alterações serão visiveis na próxima sessão!", WS_ACCEPT];
            $this->Result = true;
        else:
            $this->Error = ["Ops: aconteceu um erro ao atualizar o nome, atulize a página e tente novamente!", WS_ERROR];
            $this->Result = false;
        endif;
    }

    /**
     * @param $id
     */
    public function ExeRestored($id){
        $this->ID = $id;

        $Read = new Read();
        $Read->ExeRead(self::db_users, "WHERE id=:i", "i={$this->ID}");

        if($Read->getResult()):
            $this->Restored();
        endif;
    }

    private function Restored(){
        $pass = "123456";
        $this->Data['password'] = md5($pass);
        $this->Data['st'] = "0";

        $Update = new Update();
        $Update->ExeUpdate(self::db_users, $this->Data, "WHERE id=:i", "i={$this->ID}");

        if($Update->getResult()):
            $this->Error  = ["Password restaurada com sucesso a nova senha é <strong>123456</strong>", WS_ACCEPT];
            $this->Result = true;
        else:
            $this->Error  = ["Ops: aconteceu um erro ao restaurar a password, atualize a página e tente novamente;", WS_ALERT];
            $this->Result = false;
        endif;
    }

    /***** ==================================================> Visualizar o Usuário <================================================== *****/

    public static function ViewsUsers($id){
        $Read = new Read();
        $Read->ExeRead(self::db_users, "WHERE id=:i","i={$id}");

        if($Read->getResult()):
            return $Read->getResult()[0];
        else:
            return false;
        endif;
    }

    /***** ==================================================> Suspensão de contas <================================================== *****/

    public function Suspanse($id){
        $this->id_db_settings = $id;

        $Read = new Read();
        $Read->ExeRead(self::db_settings, "WHERE id=:i", "i={$this->id_db_settings}");

        if($Read->getResult()):
            $P = $Read->getResult()[0];

            if($P['status'] == 1): $this->Data['status'] = 0; else: $this->Data['status'] = 1; endif;
            $this->ExeSuspanse();
        endif;
    }

    private function ExeSuspanse(){
        $Data = ["Suspensa", "Activa"];

        $Update = new Update();
        $Update->ExeUpdate(self::db_settings, $this->Data, "WHERE id=:i", "i={$this->id_db_settings}");

        if($Update->getResult()):
            $this->Error  = ["O Painel foi <strong>{$Data[$this->Data['status']]}</strong>, com sucesso!", WS_ACCEPT];
            $this->Result = true;
        else:
            $this->Error  = ["Ops: acontecu um erro inesperado ao <strong>{$Data[$this->Data['status']]}</strong> o Painel.", WS_ERROR];
            $this->Result = false;
        endif;
    }

    /***** ==================================================> Histórico de atividades <================================================== *****/

    public function UsersStore(array $date){
        $Create = new Create();
        $Create->ExeCreate(self::db_users_active_store, $date);

        if($Create->getResult()):
            $this->Result = true;
        else:
            $this->Result = false;
        endif;
    }

    /***** ==================================================> Transferencia de Empresa <================================================== *****/

    public function SettingsTransfer($IDEmpresa, $IDcPanel){
        $this->IDcPanel  = $IDcPanel;
        $this->IDEmpresa = $IDEmpresa;

        $Read = new Read();
        $Read->ExeRead(self::entity, "WHERE id=:i", "i={$this->IDcPanel}");

        if($Read->getResult()):
            $Read->ExeRead(self::db_settings, "WHERE id=:i", "i={$this->IDEmpresa}");
            if($Read->getResult()):
                $this->Loney();
            else:
                $this->Error  = ["Ops: não encontramos a Empresa ID: <strong>{$this->IDEmpresa}</strong>", WS_ERROR];
                $this->Result = false;
            endif;
        else:
            $this->Error  = ["Ops: não encontramos o cPanel ID: <strong>{$this->IDcPanel}</strong>", WS_ERROR];
            $this->Result = false;
        endif;
    }

    private function Loney(){
        $Data['id_db_kwanzar'] = $this->IDcPanel;

        $Update = new Update();
        $Update->ExeUpdate(self::db_settings, $Data, "WHERE id=:i", "i={$this->IDEmpresa}");

        if($Update->getResult()):
            $Update->ExeUpdate(self::db_config, $Data, "WHERE id_db_settings=:i", "i={$this->IDEmpresa}");
            $Update->ExeUpdate(self::db_users, $Data, "WHERE id_db_settings=:i", "i={$this->IDEmpresa}");

            $this->Error  = ["Operação realizada com sucesso! A Empresa ID: <strong>{$this->IDEmpresa}</strong> foi transferida para o cPanel ID: <strong>{$this->IDcPanel}</strong>!", WS_ACCEPT];
            $this->Result = true;
        else:
            $this->Error  = ["Ops: aconteceu um erro inesperado ao transferir a empresa para outro cPanel, atualize a página e tente novamente!", WS_ERROR];
            $this->Result = false;
        endif;
    }

    /**
     * @param $ClienteData
     * @param $id_db_settings
     */
    public function ExeActive($ClienteData, $id_db_settings){
        $this->Data = $ClienteData;
        $this->id_db_settings = $id_db_settings;

        unset($this->Data['SendPostForm']);

        if(in_array("", $this->Data)):
            $this->Error  = ["Ops: preencha todos os campos para prosseguir com o processo!", WS_INFOR];
            $this->Result = false;
        else:
            $Read = new Read();
            $Read->ExeRead(self::db_active, "WHERE id_db_settings=:i AND active=:ip", "i={$this->id_db_settings}&ip={$this->Data['active']}");

            if($Read->getResult()):
                $this->Error  = ["Ops: o Motivo de documentos de rectificação: <strong>{$Read->getResult()[0]['active']}</strong>, já encontra-se registrado!", WS_ALERT];
                $this->Result = false;
            else:
                $this->CreateActive();
            endif;
        endif;
    }

    private function CreateActive(){
        $this->Data['id_db_settings'] = $this->id_db_settings;

        $Create = new Create();
        $Create->ExeCreate(self::db_active, $this->Data);

        if($Create->getResult()):
            $this->Error  = ["Operação realizada com sucesso! Motivo de documentos de rectificação: <strong>{$this->Data['active']}</strong>, foi cadastrado.", WS_ACCEPT];
            $this->Result = true;
        else:
            $this->Error  = ["Ops: aconteceu um erro inesperado ao cadastrar o Motivo de documentos de rectificação: <strong>{$this->Data['active']}</strong>!", WS_ERROR];
            $this->Result = false;
        endif;
    }

    /**
     * @param $ClienteData
     * @param $id_db_settings
     * @param $userId
     */
    public function ExeUpdateActive($ClienteData, $id_db_settings, $userId){
        $this->Data = $ClienteData;
        $this->id_db_settings = $id_db_settings;
        $this->ID = $userId;

        unset($this->Data['SendPostForm']);

        if(in_array("", $this->Data)):
            $this->Error  = ["Ops: preencha todos os campos para prosseguir com o processo!", WS_INFOR];
            $this->Result = false;
        else:
            $this->UpdateActive();
        endif;
    }

    private function UpdateActive(){
        $Update = new Update();
        $Update->ExeUpdate(self::db_active, $this->Data, "WHERE id=:ip AND id_db_settings=:i", "ip={$this->ID}&i={$this->id_db_settings}");

        if($Update->getResult()):
            $this->Error  = ["Operação realizada com sucesso! Motivo de documentos de rectificação: <strong>{$this->Data['active']}</strong>, foi atualizado.", WS_ACCEPT];
            $this->Result = true;
        else:
            $this->Error  = ["Ops: aconteceu um erro inesperado ao editar o Motivo de documentos de rectificação: <strong>{$this->Data['active']}</strong>!", WS_ERROR];
            $this->Result = false;
        endif;
    }

    public function MyCount($id_user, $data){
        $this->ID   = $id_user;
        $this->Data = $data;

        $Read = new Read();
        $Read->ExeRead(self::db_users, "WHERE id=:i", "i={$this->ID}");

        if($Read->getResult()):
            $this->Count();
        else:
            $this->Error  = ["Ops: não encontramos perfil que corresponde a esse ID!", WS_ALERT];
            $this->Result = false;
        endif;
    }

    private function Count(){
        $Update = new Update();
        $Update->ExeUpdate(self::db_users, $this->Data, "WHERE id=:i", "i={$this->ID}");

        if($Update->getResult()):
            $this->Error  = ["Informações de contato atualizadas com sucesso!", WS_ACCEPT];
            $this->Result = true;
        else:
            $this->Error  = ["Ops: aconteceu um erro inesperado ao atualizar as informações de contato!", WS_ERROR];
            $this->Result = false;
        endif;
    }

    public function gbSend(array $Image, $id_db_settings, $id_db_kwanzar = null){
        $this->File = $Image;

        $this->id_db_kwanzar = $id_db_kwanzar;
        $this->id_db_settings = $id_db_settings;
        $this->Data['id_db_settings'] = $this->id_db_settings;
        if(isset($this->id_db_kwanzar) && !empty($this->id_db_kwanzar)): $this->Data['id_db_kwanzar'] = $this->id_db_kwanzar; endif;

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
                $this->Data['data'] = date('d-m-Y');
                $this->Data['hora'] = date('H:i:s');
                $this->Data['status'] = 1;

                $insertGb = new Create;
                $insertGb->ExeCreate(self::settings_gallery, $this->Data);
                $u++;
            endif;
        endforeach;

        if($u >= 1):
            $this->Error = ["Galleria atualizada com sucesso, foram enviadas {$u} imagens para galeria.", WS_ACCEPT];
            $this->Result  = true;
        endif;
    }

    public function ForgotPassword($userId, $ClienteData){
        $this->postId = (int) $userId;
        $this->Data["password"] = strip_tags(trim($ClienteData["password"]));
        $this->Data["replace_password"] = strip_tags(trim($ClienteData["replace_password"]));

        if(in_array("", $this->Data)):
            $this->Result = false;
            $this->Error = ["Preencha todos os campos para prosseguir com o registro!", WS_INFOR];
        elseif(strlen($this->Data['password']) < 8 || strlen($this->Data['password']) > 32):
            $this->Error = ["O campo senha deve ter no minimo 8 caracteres e máximo 32 caracteres!", WS_INFOR];
            $this->Result = false;
        elseif(!preg_match('/\d+/', $this->Data['password']) > 0):
            $this->Error = ["O Campo senha deve conter números!", WS_INFOR];
            $this->Result = false;
        elseif(!preg_match('/\p{Lu}/u', $this->Data['password'])):
            $this->Result = false;
            $this->Error = ["O campo senha deve ter no minimo uma letra maíuscula!", WS_ALERT];
        elseif(!preg_match('/[!#*,.?@&%]/', $this->Data['password'])):
            $this->Result = false;
            $this->Error = ["O campo senha deve conter caracteres especiais!", WS_ALERT];
        elseif($this->Data['replace_password'] != $this->Data['password']):
            $this->Error = ["O campo de verificação de senha deve ser igual ao campo senha!", WS_ALERT];
            $this->Result = false;
        else:
            $Read = new Read();
            $Read->ExeRead(self::db_users, "WHERE id=:i", "i={$this->postId}");
            if(!$Read->getResult()):
                $this->Result = false;
                $this->Error = ["Não encontramos o usuário selecionado!", WS_INFOR];
            else:
                $this->Database = $this->Data;
                unset($this->Database['password']);
                unset($this->Database['replace_password']);

                $this->Database['lastupdate'] = date('d-m-Y H:i:s');
                $this->Database['password'] = md5($this->Data['password']);

                if($Read->getResult()[0]['password'] == $this->Database['password']):
                    $this->Result = false;
                    $this->Error = ["A nova senha não deve ser igual a senha atual!", WS_ALERT];
                else:
                    $this->CreateForgotPassword();
                endif;
            endif;
        endif;
    }

    private function CreateForgotPassword(){
        $Update = new Update();
        $Update->ExeUpdate(self::db_users, $this->Database, "WHERE id=:i", "i={$this->postId}");

        if($Update->getResult()):
            $this->Result = true;
            $this->Error = ["A senha foi atualizada com sucesso!", WS_ACCEPT];
        else:
            $this->Result = false;
            $this->Error = ["Aconteceu um erro inesperado ao atualizar a senha!", WS_ERROR];
        endif;
    }
}
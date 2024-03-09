<?php
class SessionLogs{
    private $Data, $id_db_settings, $session_id, $Array, $Result, $Error, $Browser, $Logs, $Belma;
    const
        settings = "db_settings",
        logs = "db_users_active_store",
        belma1 = "db_settings_all_in_one",
        belma2 = "db_users_all_in_one",
        browser = "db_users_browser_static",
        settings_logs = "db_settings_static",
        users_logs = "db_users_active_static";

    public function getResult(){return $this->Result;}
    public function getError(){return $this->Error;}

    function __construct(array $Data, $session_id = null, $id_db_settings = null){
        ob_start();
        $this->Array = $Data;
        $this->session_id = $session_id;
        $this->id_db_settings = $id_db_settings;

        $system = explode("(", $this->Array["HTTP_USER_AGENT"]);
        $this->Data["system"] = str_replace(")", "", $system[1]);

        $this->Browser = $this->Array["HTTP_USER_AGENT"];
        if(strpos($this->Browser, 'Chrome')):
            $this->Browser = 'Chrome';
        elseif(strpos($this->Browser, 'Firefox')):
            $this->Browser = 'Firefox';
        elseif(strpos($this->Browser, 'MSIE') || strpos($this->Browser, 'Trident/')):
            $this->Browser = 'IE';
        else:
            $this->Browser = 'Outros';
        endif;

        if(!isset($this->Array["HTTP_COOKIE"]) || empty($this->Array["HTTP_COOKIE"])): $this->Array["HTTP_COOKIE"] = null; endif;
        if(isset($this->Array["HTTP_COOKIE"])): $cookie = explode("=", $this->Array["HTTP_COOKIE"]); endif;
        $this->Data["browser"] = $this->Browser;

        if(!in_array("", $this->Array) || isset($this->Array["HTTP_COOKIE"]) || $this->Array["HTTP_COOKIE"] != null || !empty($this->Array["HTTP_COOKIE"])):
            $this->Data["cookie"]  = $cookie[1];
        endif;

        $this->Data["page"] = $this->Array["REQUEST_URI"];
        $this->Data["query_string"] = $this->Array["QUERY_STRING"];
        //$this->Data["platform"] = $this->Array["HTTP_SEC_CH_UA_PLATFORM"];
        $this->Data["user_ip"] = $this->Array["REMOTE_ADDR"];

        $this->Data["data"] = date("d-m-Y H:i:s");
        $this->Data["dia"] = date('d');
        $this->Data["mes"] = date('m');
        $this->Data["ano"] = date('Y');
        $this->Data["hora"] = date('H:i:s');

        $this->QueryExecute();
        if($this->Result):
            $this->QueryBrowser();
        endif;

        if($this->id_db_settings != null || $this->id_db_settings != '' || !empty($this->id_db_settings) || isset($this->id_db_settings)):
            $this->QuerySettings();
        endif;
    }

    private function QueryBrowser(){
        unset($this->Logs);
        $Read = new Read();
        $Read->ExeRead(self::browser, "WHERE browser=:i", "i={$this->Browser}");
        if($Read->getResult()):
            if($Read->getResult()[0]['views'] == null || empty($Read->getResult()[0]['views']) || !isset($Read->getResult()[0]['views'])):
                $v = 0;
            else:
                $v = $Read->getResult()[0]['views'];
            endif;
            $this->Logs["views"] =  $v + 1;

            $Update = new Update();
            $Update->ExeUpdate(self::browser, $this->Logs, "WHERE browser=:i", "i={$this->Browser}");
            if($Update->getResult()):
                $this->Result = true;
            else:
                $this->Result = false;
                $this->Error = ["Ops: aconteceu um erro inesperado ao salvar o Cookie(5)!", WS_ALERT];
            endif;
        else:
            $this->Logs["browser"] = $this->Browser;
            $this->Logs["views"] = 1;
            $Create = new Create();
            $Create->ExeCreate(self::browser, $this->Logs);
            if($Create->getResult()):
                $this->Result = true;
            else:
                $this->Result = false;
                $this->Error = ["Ops: aconteceu um erro inesperado ao salvar o Cookie(4)!", WS_ALERT];
            endif;
        endif;
    }

    private function QuerySettings(){
        unset($this->Logs);

        $Read = new Read();
        $Read->ExeRead(self::settings, "WHERE id=:i ", "i={$this->id_db_settings}");
        if($Read->getResult()):
            $this->FuncaoOriginal();
            $this->FicaSoJaAssim();
        else:
            $this->Error = ["Ops: nāo encontramos a empresa selecionada!", WS_ALERT];
            $this->Result = false;
        endif;
    }

    private function FuncaoOriginal(){
        $Reads = new Read();
        $Reads->ExeRead(self::settings_logs, "WHERE id_db_settings=:id AND dia=:d AND mes=:m AND ano=:a ", "id={$this->id_db_settings}&d={$this->Data['dia']}&m={$this->Data['mes']}&a={$this->Data['ano']}");

        if($Reads->getResult()):
            if($Reads->getResult()[0]['total'] == null || empty($Reads->getResult()[0]['total']) || !isset($Reads->getResult()[0]['total'])):
                $v = 0;
            else:
                $v = $Reads->getResult()[0]['total'];
            endif;

            $this->Logs["total"] =  $v + 1;

            $Update = new Update();
            $Update->ExeUpdate(self::settings_logs, $this->Logs, "WHERE id_db_settings=:id AND dia=:d AND mes=:m AND ano=:a ", "id={$this->id_db_settings}&d={$this->Data['dia']}&m={$this->Data['mes']}&a={$this->Data['ano']}");
            if($Update->getResult()):
                $this->Result = true;
            else:
                $this->Result = false;
                $this->Error = ["Ops: aconteceu um erro inesperado ao salvar o Cookie(2)!", WS_ALERT];
            endif;
        else:
            $this->Logs["dia"] = date('d');
            $this->Logs["mes"] = date('m');
            $this->Logs["ano"] = date('Y');
            $this->Logs["hora"] = date('H:i:s');
            $this->Logs["total"] = 1;
            $this->Logs["id_db_settings"] = $this->id_db_settings;

            $Create = new Create();
            $Create->ExeCreate(self::settings_logs, $this->Logs);
            if($Create->getResult()):
                $this->Result = true;
            else:
                $this->Result = false;
                $this->Error = ["Ops: aconteceu um erro inesperado ao salvar o Cookie(3)!", WS_ALERT];
            endif;
        endif;
    }

    private function FicaSoJaAssim(){
        $Reads = new Read();
        $Reads->ExeRead(self::belma1, "WHERE id_db_settings=:id", "id={$this->id_db_settings}");
        if($Reads->getResult()):
            if($Reads->getResult()[0]['total'] == null || empty($Reads->getResult()[0]['total']) || !isset($Reads->getResult()[0]['total'])):
                $v = 0;
            else:
                $v = $Reads->getResult()[0]['total'];
            endif;

            $this->Belma["total"] =  $v + 1;

            $Update = new Update();
            $Update->ExeUpdate(self::belma1, $this->Belma, "WHERE id_db_settings=:id ", "id={$this->id_db_settings}");
            if($Update->getResult()):
                $this->Result = true;
            else:
                $this->Result = false;
                $this->Error = ["Ops: aconteceu um erro inesperado ao salvar o Cookie(2)!", WS_ALERT];
            endif;
        else:
            $this->Belma["total"] = 1;
            $this->Belma["id_db_settings"] = $this->id_db_settings;

            $Create = new Create();
            $Create->ExeCreate(self::belma1, $this->Belma);
            if($Create->getResult()):
                $this->Result = true;
            else:
                $this->Result = false;
                $this->Error = ["Ops: aconteceu um erro inesperado ao salvar o Cookie(3)!", WS_ALERT];
            endif;
        endif;
    }

    private function QueryExecute(){
        $this->Data["id_db_settings"] = $this->id_db_settings;
        $this->Data["session_id"] = $this->session_id;

        if(isset($this->Data['cookie']) || empty($this->Data['cookie'])):
            $this->Data['cookie'] = null;
        endif;

        $this->Data["x"] = 1;
        $Error = [
            "session_id" => $this->Data['session_id'],
            "page" => $this->Data['page'],
            "system_id" => $this->Data['system'],
            "user_ip" => $this->Data['user_ip'],
            "hora" => $this->Data['hora'],
            "data" => $this->Data['data'],
            "dia" => $this->Data['dia'],
            "mes" => $this->Data['mes'],
            "ano" => $this->Data['ano'],
            "cookie" => $this->Data['cookie'],
            "browser" => $this->Data['browser'],
            "query_string" => $this->Data['query_string'],
            "x" => $this->Data['x']
        ];

        $Create = new Create();
        $Create->ExeCreate(self::logs, $Error);
        if($Create->getResult()):
            $Read = new Read();
            $Read->ExeRead(self::users_logs, "WHERE session_id=:id AND dia=:d AND mes=:m AND ano=:a ", "id={$this->session_id}&d={$this->Data['dia']}&m={$this->Data['mes']}&a={$this->Data['ano']}");
            if($Read->getResult()):
                if($Read->getResult()[0]['total'] == null || empty($Read->getResult()[0]['total']) || !isset($Read->getResult()[0]['total'])): $v = 0; else: $v = $Read->getResult()[0]['total']; endif;
                $this->Logs["total"] =  $v + 1;
                $Update = new Update();
                $Update->ExeUpdate(self::users_logs, $this->Logs, "WHERE session_id=:id AND dia=:d AND mes=:m AND ano=:a ", "id={$this->session_id}&d={$this->Data['dia']}&m={$this->Data['mes']}&a={$this->Data['ano']}");
                if($Update->getResult()):
                    $this->Result = true;
                else:
                    $this->Result = false;
                    $this->Error = ["Ops: aconteceu um erro inesperado ao salvar o Cookie(2)!", WS_ALERT];
                endif;
            else:
                $this->Logs["session_id"] = $this->session_id;
                $this->Logs["dia"] = $this->Data["dia"];
                $this->Logs["mes"] = $this->Data["mes"];
                $this->Logs["ano"] = $this->Data["ano"];
                $this->Logs["total"] = 1;

                $Create->ExeCreate(self::users_logs, $this->Logs);
                if($Create->getResult()):
                    $this->Result = true;
                else:
                    $this->Result = false;
                    $this->Error = ["Ops: aconteceu um erro inesperado ao salvar o Cookie(1)!", WS_ALERT];
                endif;
            endif;
        else:
            $this->Result = false;
            $this->Error = ["Ops: aconteceu um erro inesperado ao salvar o Cookie(0)!", WS_ALERT];
        endif;

        $this->MotivacaoMonetaria();
    }

    private function MotivacaoMonetaria(){
        $Create = new Create();
        $Read = new Read();
        $Read->ExeRead(self::belma2, "WHERE session_id=:id ", "id={$this->session_id}");
        if($Read->getResult()):
            if($Read->getResult()[0]['total'] == null || empty($Read->getResult()[0]['total']) || !isset($Read->getResult()[0]['total'])): $v = 0; else: $v = $Read->getResult()[0]['total']; endif;
            $this->Belma["total"] =  $v + 1;
            $Update = new Update();
            $Update->ExeUpdate(self::belma2, $this->Belma, "WHERE session_id=:id ", "id={$this->session_id}");
            if($Update->getResult()):
                $this->Result = true;
            else:
                $this->Result = false;
                $this->Error = ["Ops: aconteceu um erro inesperado ao salvar o Cookie(2)!", WS_ALERT];
            endif;
        else:
            $this->Belma["session_id"] = $this->session_id;
            $this->Belma["total"] = 1;

            $Create->ExeCreate(self::belma2, $this->Belma);
            if($Create->getResult()):
                $this->Result = true;
            else:
                $this->Result = false;
                $this->Error = ["Ops: aconteceu um erro inesperado ao salvar o Cookie(1)!", WS_ALERT];
            endif;
        endif;
    }
}
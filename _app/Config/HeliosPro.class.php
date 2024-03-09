<?php
/**
 * Created by PhpStorm.
 * User: Kwanzar Soft
 * Date: 06/06/2020
 * Time: 17:12
 */

class HeliosPro{
    private $Data, $Error, $Result, $Session, $id_db_kwanzar, $kaizen;
    const
        entity     = "ws_times",
        db_backup  = "ws_times_backup",
        db_user    = "db_users",
        security   = "z_security",
        db_kwanzar = "db_kwanzar";

    public function getError(){return $this->Error; }
    public function getResult(){return $this->Result;}

    /**
     * @param array $data
     * @param $id_db_kwanzar
     * @param $session
     */
    public function ExeLicence(array $data, $id_db_kwanzar, $session){
        $this->Data = $data;
        $this->id_db_kwanzar = $id_db_kwanzar;
        $this->Session = $session;

        if(!in_array('', $this->Data)):
            $Read = new Read();
            $Read->ExeRead(self::db_user, "WHERE id=:i ", "i={$this->Session}");

            if($Read->getResult()):
                if($Read->getResult()[0]['level'] < 5):
                    $this->Error  = ["Ops: não tens premissão para estar nessa área do software!", WS_ERROR];
                    $this->Result = false;
                else:
                    $this->Create();
                endif;
            else:
                $this->Error  = ["Ops: não encontramos nenhum usuário!", WS_ALERT];
                $this->Result = false;
            endif;
        else:
            $this->Error  = ["Ops: preencha todos os campos para prosseguir com o processo!", WS_INFOR];
            $this->Result = false;
        endif;
    }

    private function Update(){
        $st = 1;

        $Update = new Update();
        $Update->ExeUpdate(self::entity, $this->Data, "WHERE id_db_kwanzar=:i AND status=:st", "i={$this->id_db_kwanzar}&st={$st}");

        if($Update->getResult()):
            $this->Error  = ["Operação realizada com sucesso, licença activa/renovada para {$this->Data['times']}!", WS_ACCEPT];
            $this->Result = true;
        else:
            $this->Error  = ["Ops: aconteceu um erro ao activar a licencça (0)", WS_ERROR];
            $this->Result = false;
        endif;
    }

    private function Create(){
        $Read = new Read();
        $Read->ExeRead(self::entity, "WHERE id_db_kwanzar=:i", "i={$this->id_db_kwanzar}");
        if($Read->getResult()):
            $Delete = new Delete();
            $Delete->ExeDelete(self::entity, "WHERE id_db_kwanzar=:i", "i={$this->id_db_kwanzar}");

            if($Delete->getResult() || $Delete->getRowCount()):
                $this->Error = ["Sucesso ao deletar a licença passada!", WS_INFOR];
                $this->Result = true;
            else:
                $this->Result = false;
                $this->Error = ["Oops: aconteceu um erro inesperado ao deletar a licença passada!", WS_ERROR];
            endif;
        endif;

        $data_inicial = date('Y-m-d');
        $data_final = $this->Data['times'];
        $diferenca = strtotime($data_final) - strtotime($data_inicial);
        $this->Data['saldo'] = floor($diferenca / (60 * 60 * 24));

        $mound = explode("-", $this->Data['times']);
        if($mound[0] == date('Y')):
            $mes = $mound[1] - date('m');
        else:
            $mes = 0;
            if($mound[1] > date('m')):
                $meses = $mound[1] - date('m');
            elseif(date('m') > $mound[1]):
                $meses = date('m') - $mound[1];
            else:
                $meses = 1;
            endif;

            $ano = $mound[0] - date('Y');
            for($i = 0; $i <= $ano; $i++):
                $mes += $meses;
            endfor;
        endif;

        $this->Data['mes']    = date('m');
        $this->Data['dia']    = date('d');
        $this->Data['ano']    = date('Y');
        $this->Data['status'] = 1;
        $this->Data['id_db_kwanzar'] = $this->id_db_kwanzar;

        $Read = new Read();
        $Read->ExeRead(self::security, "WHERE id=:i", "i={$this->Data['ps3']}");

        if($Read->getResult()):
            $this->kaizen = $Read->getResult()[0];
        endif;

        $this->Data['plano'] = $this->kaizen['plano'];
        $this->Data['postos'] = $this->kaizen['empresas'];
        $this->Data['users'] = $this->kaizen['usuarios'];

        if($this->Data['saldo'] <= 30):
            $this->Data['documentos'] = $this->kaizen['documentos'];
        elseif($this->Data['saldo'] >= 30 && $this->Data['saldo'] <= 60):
            $this->Data['documentos'] = 1 * $this->kaizen['documentos'];
        elseif($this->Data['saldo'] >= 60 && $this->Data['saldo'] <= 90):
            $this->Data['documentos'] = 2 * $this->kaizen['documentos'];
        elseif($this->Data['saldo'] >= 90 && $this->Data['saldo'] <= 120):
            $this->Data['documentos'] = 3 * $this->kaizen['documentos'];
        elseif($this->Data['saldo'] >= 120 && $this->Data['saldo'] <= 150):
            $this->Data['documentos'] = 4 * $this->kaizen['documentos'];
        elseif($this->Data['saldo'] >= 150 && $this->Data['saldo'] <= 180):
            $this->Data['documentos'] = 5 * $this->kaizen['documentos'];
        elseif($this->Data['saldo'] >= 180 && $this->Data['saldo'] <= 210):
            $this->Data['documentos'] = 6 * $this->kaizen['documentos'];
        elseif($this->Data['saldo'] >= 210 && $this->Data['saldo'] <= 240):
            $this->Data['documentos'] = 7 * $this->kaizen['documentos'];
        elseif($this->Data['saldo'] >= 240 && $this->Data['saldo'] <= 270):
            $this->Data['documentos'] = 8 * $this->kaizen['documentos'];
        elseif($this->Data['saldo'] >= 270 && $this->Data['saldo'] <= 300):
            $this->Data['documentos'] = 9 * $this->kaizen['documentos'];
        elseif($this->Data['saldo'] >= 300 && $this->Data['saldo'] <= 330):
            $this->Data['documentos'] = 10 * $this->kaizen['documentos'];
        elseif($this->Data['saldo'] >= 330 && $this->Data['saldo'] <= 360):
            $this->Data['documentos'] = 11 * $this->kaizen['documentos'];
        elseif($this->Data['saldo'] >= 360 && $this->Data['saldo'] <= 390):
            $this->Data['documentos'] = 12 * $this->kaizen['documentos'];
        elseif($this->Data['saldo'] >= 390 && $this->Data['saldo'] <= 420):
            $this->Data['documentos'] = 13 * $this->kaizen['documentos'];
        elseif($this->Data['saldo'] >= 420 && $this->Data['saldo'] <= 460):
            $this->Data['documentos'] = 14 * $this->kaizen['documentos'];
        else:
            $this->Data['documentos'] = 50 * $this->kaizen['documentos'];
        endif;

        $this->Data['pricing'] = $this->kaizen['valor'];

        if($mes == 0 && $mound[0] == date('Y') || $mes == null && $mound[0] == date('Y')):
            $this->Data['total'] = $this->Data['pricing'];
        else:
            $this->Data['total'] = ($this->Data['pricing'] / 30) * $this->Data['saldo'];
        endif;

        $Create = new Create();
        $Create->ExeCreate(self::entity, $this->Data);

        if($Create->getResult()):
            unset($this->Data['status']);
            $this->Data['data'] = date('d-m-Y');
            $this->Data['hora'] = date('H:i:s');

            $Create->ExeCreate(self::db_backup, $this->Data);
            if($Create->getResult()):
                $this->Error  = ["Operação realizada com sucesso, licença activa/renovada para {$this->Data['times']}!", WS_ACCEPT];
                $this->Result = true;
            else:
                $this->Result = false;
                $this->Error = ["Oops: aconteceu um erro inesperado ao efeturar o backup da licença!", WS_ERROR];
            endif;
        else:
            $this->Error  = ["Ops: aconteceu um erro ao activar a licencça (1)", WS_ERROR];
            $this->Result = false;
        endif;
    }
}
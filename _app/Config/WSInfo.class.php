<?php
/**
 * Created by PhpStorm.
 * User: Kwanzar Soft
 * Date: 21/06/2020
 * Time: 13:40
 */

class WSInfo{
    private $Data, $Error, $Result, $ID, $id_db_settings, $Session, $Info, $File;
    const
        ws_services = "ws_services",
        ws_streaming = "ws_streaming";

    public function getError(){return $this->Error;}
    public function getResult(){return $this->Result;}

    /**
     * @param array $data
     * @param null $cover
     */
    public function ExeCreate($data = array(), $cover = null){
        $this->Data = $data;
        $this->File = $cover;

        unset($this->Data['SendPostForm']);
        unset($this->Data['SendPostForm']);

        $Read = new Read();
        $Read->ExeRead(self::ws_services, "WHERE title=:t", "i={$this->Data['title']}");

        if(!$Read->getResult()):
            if(!in_array('', $this->File)):
                $this->SendLogotype();
            else:
                $this->File['cover'] = '';
            endif;

            if(in_array('', $this->Data)):
                $this->Error  = ["Ops: preencha todos campos para prosseguir com o processo.", WS_ALERT];
                $this->Result = false;
            else:
                $this->Create();
            endif;
        else:
            $this->Error  = ["Ops: o serviço já encontra-se registado no sistema;", WS_INFOR];
            $this->Result = false;
        endif;
    }

    private function SendLogotype(){
        if(!empty($this->File['cover']['tmp_name'])):
            $Upload = new Upload;
            $Upload->Image($this->File['cover']);

            if($Upload->getError()):
                $this->Error = $Upload->getError();
                $this->Result = false;
            else:
                $this->File['cover'] = $Upload->getResult();
                $this->Result = true;
            endif;
        endif;
    }

    private function Create(){
        if($this->File['cover'] != '' || $this->File['cover'] != null): $this->Data['cover'] = $this->File['cover']; endif;
        $this->Data['data']   = date('d-m-Y H:i:s');
        $this->Data['status'] = 1;

        $Create = new Create;
        $Create->ExeCreate(self::ws_services, $this->Data);

        if($Create->getResult()):
            $this->Error  = ["Serviço: <b>{$this->Data['title']}</b> foi cadastrado com sucesso!", WS_ACCEPT];
            $this->Result = true;
        else:
            $this->Error  = ["Ops: aconteceu um erro inesperado ao registar o serviço", WS_INFOR];
            $this->Result = false;
        endif;
    }

    public function ExeDelete($postId){
        $this->ID = $postId;

        $Read = new Read();
        $Read->ExeRead(self::ws_services, "WHERE id=:i", "i={$this->ID}");

        if($Read->getResult()):
            $Delete = new Delete();
            $Delete->ExeDelete(self::ws_services, "WHERE id=:i ", "i={$this->ID}");

            if($Delete->getResult() || $Delete->getRowCount()):
                $this->Error  = ["Serviço deletado com sucesso!", WS_ACCEPT];
                $this->Result = true;
            else:
                $this->Error  = ["Ops: aconteceu um erro inesperado ao deletar o serviço;", WS_ERROR];
                $this->Result = false;
            endif;
        endif;
    }

    public function Deleting($postId){
        $this->ID = $postId;

        $Delete = new Delete();
        $Delete->ExeDelete(self::ws_streaming, "WHERE id=:i ", "i={$this->ID}");

        if($Delete->getResult() || $Delete->getRowCount()):
            $this->Error  = ["Serviço deletado com sucesso!", WS_ACCEPT];
            $this->Result = true;
        else:
            $this->Error  = ["Ops: aconteceu um erro inesperado ao deletar o serviço;", WS_ERROR];
            $this->Result = false;
        endif;
    }

    public function ExeUpdate($data = array(), $cover = null, $postId){
        $this->Data = $data;
        $this->File = $cover;
        $this->ID   = $postId;

        unset($this->Data['SendPostForm']);
        unset($this->Data['SendPostForm']);

        if(!in_array('', $this->File)):
            $this->SendLogotype();
        else:
            $this->File['cover'] = '';
        endif;

        if(in_array('', $this->Data)):
            $this->Error  = ["Ops: preencha todos campos para prosseguir com o processo.", WS_ALERT];
            $this->Result = false;
        else:
            $this->Update();
        endif;

    }

    private function Update(){
        if($this->File['cover'] != '' || $this->File['cover'] != null): $this->Data['cover'] = $this->File['cover']; endif;

        $Create = new Update();
        $Create->ExeUpdate(self::ws_services, $this->Data, "WHERE id=:i", "i={$this->ID}");

        if($Create->getResult()):
            $this->Error  = ["Serviço: <b>{$this->Data['title']}</b> foi atualizado com sucesso!", WS_ACCEPT];
            $this->Result = true;
        else:
            $this->Error  = ["Ops: aconteceu um erro inesperado ao atualizar o serviço", WS_INFOR];
            $this->Result = false;
        endif;
    }

    /**
     * @param array $data
     * @param array $video
     */
    public function ExeStreaming($data = array(), array $video = null){
        $this->Data = $data;
        $this->File = $video;

        unset($this->Data['SendPostForm']);
        unset($this->Data['SendPostForm']);

        $Read = new Read();
        $Read->ExeRead(self::ws_streaming, "WHERE title=:t", "i={$this->Data['title']}");

        if(!$Read->getResult()):
            if(!in_array('', $this->File)):
                $this->SendVideo();
            else:
                $this->Error  = ["Ops: preencha todos campos para prosseguir com o processo.", WS_ALERT];
                $this->Result = false;
            endif;

            if(in_array('', $this->Data)):
                $this->Error  = ["Ops: preencha todos campos para prosseguir com o processo.", WS_ALERT];
                $this->Result = false;
            else:
                $this->CreateVideo();
            endif;
        else:
            $this->Error  = ["Ops: o serviço já encontra-se registado no sistema;", WS_INFOR];
            $this->Result = false;
        endif;
    }

    private function SendVideo(){
        if(!empty($this->File['cover']['tmp_name'])):
            $Upload = new Upload();
            $Upload->Media($this->File['cover']);

            if($Upload->getError()):
                $this->Error = $Upload->getError();
                $this->Result = false;
            else:
                $this->File['cover'] = $Upload->getResult();
                $this->Result = true;
            endif;
        endif;
    }

    private function CreateVideo(){
        $this->Data['video']  = $this->File['cover'];
        $this->Data['data']   = date('d-m-Y');
        $this->Data['hora']   = date('H:i:s');
        $this->Data['status'] = "1";

        $Create = new Create;
        $Create->ExeCreate(self::ws_streaming, $this->Data);

        if($Create->getResult()):
            $this->Error  = ["Vídeo: <b>{$this->Data['title']}</b> foi cadastrado com sucesso!", WS_ACCEPT];
            $this->Result = true;
        else:
            $this->Error  = ["Ops: aconteceu um erro inesperado ao registar o serviço", WS_INFOR];
            $this->Result = false;
        endif;
    }
}
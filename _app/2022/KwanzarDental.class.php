<?php
class KwanzarDental{
    private $Result, $Error, $id_user, $id_db_settings, $Data, $postId, $Cover, $File, $Arq, $ID, $Dados;
    const
        pacientes = "cv_customer",
        receita = "cv_clinic_receita",
        product = "cv_clinic_product",
        contact = "cv_customer_contact",
        arquivo = "cv_customer_arquivo",
        anamnese = "cv_customer_anamnese",
        stock = "cv_clinic_product_stock",
        tratamento = "cv_customer_tratamento",
        odontograma = "cv_customer_odontograma",
        justificativo = "cv_clinic_justificativo",
        clinic_horario = "db_users_clinic_horario",
        clinic_agendamento = "db_clinic_agendamento",
        clinic_porcentagem = "db_settings_clinic_porcentagem";

    public function Moviment($ClienteData, $id_db_settings, $postId, $user_id){
        $this->id_db_settings = $id_db_settings;
        $this->postId = $postId;
        $this->id_user = $user_id;
        $this->Data = $ClienteData;

        unset($this->Data['SendPostFormL']);

        if(empty($this->Data['qtd']) || empty($this->Data['unidades']) || empty($this->Data['movimento'])):
            $this->Error = ["Preencha todos os campos marcados com <strong>*<strong/> para continuar com a operação!", WS_ALERT];
            $this->Result = false;
        else:
            $Read = new Read();
            $Read->ExeRead(self::product, "WHERE id=:i AND id_db_settings=:iv ", "i={$this->postId}&iv={$this->id_db_settings}");

            if($Read->getResult()):
                $x = $Read->getResult()[0];

                if($this->Data['movimento'] == "entrada"):
                    if(!empty($x['unidades']) && $x['unidades'] >= 1 && ($this->Data['unidades'] != $x['unidades'])):
                        $this->Error = ["Para movimentos de natureza entrada, a unidade tem que ser igual a remessa passada!", WS_INFOR];
                        $this->Result = false;
                    else:
                        $this->Dados['qtd'] = $x['qtd'] + $this->Data['qtd'];
                        if(empty($x['unidades']) || !isset($x['unidades'])):
                            $this->Dados['unidades'] = $this->Data['unidades'];
                        endif;
                    endif;
                else:
                    $this->Dados['qtd'] = $x['qtd'] - $this->Data['qtd'];
                endif;

                if($this->Data['movimento'] == "saida" && $x['qtd'] < $this->Data['qtd']):
                    $this->Result = false;
                    $this->Error = ["Não existe em stock a quantidade requisitada!", WS_ALERT];
                else:
                    $this->UpdateUnidades();
                    if($this->Result):
                        $this->Data['dia'] = date('d');
                        $this->Data['mes'] = date('m');
                        $this->Data['ano'] = date('Y');
                        $this->Data['hora'] = date('H:i');
                        $this->Data['data'] = date('d-m-Y');
                        $this->Data['id_user'] = $this->id_user;
                        $this->Data['id_product'] = $this->postId;
                        $this->Data['id_db_settings'] = $this->id_db_settings;
                        $this->Data['status'] = 1;

                        $this->FinishMoviment();
                    endif;
                endif;
            else:
                $this->Result = false;
                $this->Error = ["Não encontramos o material selecionado!", WS_ALERT];
            endif;
        endif;
    }

    private function FinishMoviment(){
        $Create = new Create();
        $Create->ExeCreate(self::stock, $this->Data);

        if($Create->getResult()):
            $this->Error = ["Operação com sucesso!", WS_ACCEPT];
            $this->Result = true;
        else:
            $this->Error = ["Aconteceu um erro inesperado ao realizar a operação!", WS_ERROR];
            $this->Result = false;
        endif;
    }

    private function UpdateUnidades(){
        $Update = new Update();
        $Update->ExeUpdate(self::product, $this->Dados, "WHERE id=:J AND id_db_settings=:id", "J={$this->postId}&id={$this->id_db_settings}");

        if($Update->getResult()):
            $this->Result = true;
        else:
            $this->Error  = ["Ops: aconteceu um erro inesperado ao editar o material.", WS_ERROR];
            $this->Result = false;
        endif;
    }

    public function ExeUpdate($userId, $ClienteData, $id_db_settings){
        $this->postId = $userId;
        $this->Data = $ClienteData;
        $this->id_db_settings = $id_db_settings;

        unset($this->Data['SendPostFormL']);

        if(empty($this->Data['name'])):
            $this->Error = ["Ops!!! Preencha todos campos, para prosseguir com o processo.", WS_ALERT];
            $this->Result = false;
        else:
            $this->UpdateProduct();
        endif;
    }

    private function UpdateProduct(){
        $Update = new Update();
        $Update->ExeUpdate(self::product, $this->Data, "WHERE id=:J AND id_db_settings=:id", "J={$this->postId}&id={$this->id_db_settings}");

        if($Update->getResult()):
            $this->Error  = ["O material <b>{$this->Data['name']}</b> foi atualizado com sucesso!", WS_ACCEPT];
            $this->Result = $Update->getResult();
        else:
            $this->Error  = ["Ops: aconteceu um erro inesperado ao editar o material <b>{$this->Data['name']}</b>.", WS_ERROR];
            $this->Result = false;
        endif;
    }

    public function CreateMaterial($ClienteData, $id_db_settings){
        $this->Data = $ClienteData;
        $this->id_db_settings = $id_db_settings;

        unset($this->Data['SendPostFormL']);

        if(empty($this->Data['name'])):
            $this->Error = ["Ops!!! Preencha todos campos, para prosseguir com o processo.", WS_ALERT];
            $this->Result = false;
        else:
            $Read = new Read();
            $Read->ExeRead(self::product, "WHERE id_db_settings=:i AND name=:st ", "i={$this->id_db_settings}&st={$this->Data['name']}");

            if($Read->getResult()):
                $this->Error = ["O material <strong>{$this->Data['name']}</strong>, já encontra-se regitrado!", WS_ALERT];
                $this->Result = false;
            else:
                $this->Data['status'] = 1;
                $this->Data['id_db_settings'] = $this->id_db_settings;
                $this->CreateProduct();
            endif;
        endif;
    }

    private function CreateProduct(){
        $Create = new Create();
        $Create->ExeCreate(self::product, $this->Data);

        if($Create->getResult()):
            $this->Error = ["Material salvo com sucesso!", WS_ACCEPT];
            $this->Result = true;
        else:
            $this->Error = ["Aconteceu um erro inesperado ao salvar o material!", WS_ERROR];
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

    private function SendFile(){
        if(!empty($this->File['gallery']['tmp_name'])):
            $Upload = new Upload;
            $Upload->File($this->File['gallery']);

            if($Upload->getError()):
                $this->Error = $Upload->getError();
                $this->Result = false;
            else:
                $this->Arq = $Upload->getResult();
                $this->Result = true;
            endif;
        endif;
    }

    private function SendGallery(){
        if(!empty($this->Cover['gallery']['tmp_name'])):
            $Upload = new Upload;
            $Upload->Image($this->Cover['gallery']);

            if($Upload->getError()):
                $this->Error = $Upload->getError();
                $this->Result = false;
            else:
                $this->Arq = $Upload->getResult();
                $this->Result = true;
            endif;
        endif;
    }

    public function gbSend(array $Image, $id_db_settings, $postId){
        $this->File = $Image;
        $this->id_db_settings = strip_tags(trim($id_db_settings));
        $this->postId = strip_tags(trim($postId));

        $filetype = explode(".", $this->File['gallery']['name']);
        if(isset($filetype[1]) && $filetype[1] == "jpge" || isset($filetype[1]) && $filetype[1] == "jpg" || isset($filetype[1]) && $filetype[1] == "png"):
            $this->Cover = $this->File;
            $this->SendGallery();
        elseif(isset($filetype[1]) && $filetype[1] == "doc" || isset($filetype[1]) && $filetype[1] == "docx" || isset($filetype[1]) && $filetype[1] == "pdf"):
            $this->SendFile();
        endif;


        $this->Data['files'] = $this->Arq;
        $this->Data['data'] = date('d-m-Y');
        $this->Data['hora'] = date('H:i');
        $this->Data['id_paciente'] = $this->postId;
        $this->Data['id_db_settings'] = $this->id_db_settings;
        $this->Data['status'] = 1;

        $this->CreategbSent();
    }

    public function getError(){return $this->Error;}
    public function getResult(){return $this->Result;}

    public function CreateJustificativo($ClienteData, $id_db_settings, $id_user, $postid){
        $this->Data = $ClienteData;
        $this->Data['id_db_settings'] = $id_db_settings;
        $this->Data['id_user'] = $id_user;
        $this->Data['id_paciente'] = $postid;

        unset($this->Data['SendPostFormL']);

        $this->Data['hora'] = date('H:i:s');
        $this->Data['status'] = 1;

        $this->SalveJustificativo();
    }

    private function SalveJustificativo(){
        $Create = new Create();
        $Create->ExeCreate(self::justificativo, $this->Data);

        if($Create->getResult()):
            $this->Error = ["Receita salva com sucesso!", WS_ACCEPT];
            $this->Result = true;
        else:
            $this->Error = ["Aconteceu um erro inesperado ao salvar a receita!", WS_ERROR];
            $this->Result = false;
        endif;
    }

    public function CreateReceita($ClienteData, $id_db_settings, $id_user, $postid){
        $this->Data = $ClienteData;
        $this->Data['id_db_settings'] = $id_db_settings;
        $this->Data['id_user'] = $id_user;
        $this->Data['id_paciente'] = $postid;

        unset($this->Data['SendPostFormL']);

        $this->Data['hora'] = date('H:i:s');
        $this->Data['status'] = 1;

        $this->SalveReceia();
    }

    private function SalveReceia(){
        $Create = new Create();
        $Create->ExeCreate(self::receita, $this->Data);

        if($Create->getResult()):
            $this->Error = ["Receita salva com sucesso!", WS_ACCEPT];
            $this->Result = true;
        else:
            $this->Error = ["Aconteceu um erro inesperado ao salvar a receita!", WS_ERROR];
            $this->Result = false;
        endif;
    }

    public function FinalizarTratamento($ID, $id_db_settings, $postid){
        $this->ID = $ID;
        $this->id_db_settings = $id_db_settings;
        $this->postId = $postid;

        $Read = new Read();
        $Read->ExeRead(self::tratamento, "WHERE id=:i AND id_paciente=:id AND id_db_settings=:dt ", "i={$this->ID}&id={$this->postId}&dt={$this->id_db_settings}");
        if($Read->getResult()):
            $this->Data['status'] = 2;

            $this->UpdateTratamento();
            if($this->Result):
                if($Read->getResult()[0]['dente'] == "arcada_superior" || $Read->getResult()[0]['dente'] == "arcada_inferior"):
                    $Read->ExeRead(self::odontograma, "WHERE id_paciente=:i AND id_db_settings=:st AND arcada=:dt", "i={$this->postId}&st={$this->id_db_settings}&dt={$Read->getResult()[0]['dente']}");
                else:
                    $Read->ExeRead(self::odontograma, "WHERE id_paciente=:i AND id_db_settings=:st AND dente=:dt ", "i={$this->postId}&st={$this->id_db_settings}&dt={$Read->getResult()[0]['dente']}");
                endif;

                if($Read->getResult()):
                    foreach ($Read->getResult() as $yL):
                        if($yL['status'] != 4):
                            $Datax['status'] = 3;
                            $this->UpdateOdontograma($yL['id'], $id_db_settings, $this->postId, $Datax);
                        endif;
                    endforeach;
                endif;

                unset($this->Data);
            endif;
        endif;
    }

    private function UpdateTratamento(){
        $Update = new Update();
        $Update->ExeUpdate(self::tratamento, $this->Data, "WHERE id=:ix AND id_paciente=:i AND id_db_settings=:id ", "ix={$this->ID}&i={$this->postId}&id={$this->id_db_settings}");

        if($Update->getResult()):
            $this->Error = ["O tratamento foi atualizado com sucesso!", WS_ACCEPT];
            $this->Result = true;
        else:
            $this->Error = ["Aconteceu um erro ao atualizar ao finalizar o tratamento!", WS_ERROR];
            $this->Result = false;
        endif;
    }

    public function Tratamento($id_user, $id_db_settings, $postid, $Data){
        $this->id_user = $id_user;
        $this->id_db_settings = $id_db_settings;
        $this->postId = $postid;
        $this->Data = $Data;

        $content = $this->Data['content_data'];
        unset($this->Data['content_data']);

        if(in_array("", $this->Data)):
            $this->Error = ["Preencha todos os campos para prosseguir!", WS_ALERT];
            $this->Result = false;
        else:
            $this->Data['content_data'] = $content;
            $st = 1;

            $Read = new Read();
            $Read->ExeRead(self::tratamento, "WHERE id_paciente=:i AND id_db_settings=:st AND dente=:dt AND face=:fc AND id_procedimento=:ittt AND status=:stt", "i={$this->postId}&st={$this->id_db_settings}&dt={$this->Data['dente']}&fc={$this->Data['face']}&ittt={$this->Data['id_procedimento']}&stt={$st}");
            if($Read->getResult()):
                $this->Error = ["Há um tratamento do dente: <strong>{$this->Data['dente']}</strong>, face: <strong>{$this->Data['face']}</strong> que está em aberto", WS_ALERT];
                $this->Result = false;
            else:
                $this->Data['id_db_settings'] = $this->id_db_settings;
                $this->Data['id_paciente'] = $this->postId;
                $this->Data['id_user'] = $this->id_user;
                $this->Data['status'] = 1;

                $this->SalveTratamento();
                if($this->Result):
                    if($this->Data['dente'] == "arcada_superior" || $this->Data['dente'] == "arcada_inferior"):
                        $Read->ExeRead(self::odontograma, "WHERE id_paciente=:i AND id_db_settings=:st AND arcada=:dt", "i={$this->postId}&st={$this->id_db_settings}&dt={$this->Data['dente']}");
                    else:
                        $Read->ExeRead(self::odontograma, "WHERE id_paciente=:i AND id_db_settings=:st AND dente=:dt ", "i={$this->postId}&st={$this->id_db_settings}&dt={$this->Data['dente']}");
                    endif;


                    if($Read->getResult()):
                        foreach ($Read->getResult() as $yL):
                            if($yL['status'] != 4):
                                $Datax['status'] = 2;
                                $this->UpdateOdontograma($yL['id'], $id_db_settings, $this->postId, $Datax);
                            endif;
                        endforeach;
                    endif;

                    unset($this->Data);
                endif;
            endif;
        endif;
    }

    private function SalveTratamento(){
        $Create = new Create();
        $Create->ExeCreate(self::tratamento, $this->Data);

        if($Create->getResult()):
            $this->Error = ["Tratamento salvo com sucesso!", WS_ACCEPT];
            $this->Result = true;
        else:
            $this->Error = ["Aconteceu um erro inesperado ao salvar o tratamento!", WS_ERROR];
            $this->Result = false;
        endif;
    }

    public function UpdateOdontograma($id, $id_db_settings, $postid, $Data){
        $this->Data = $Data;
        $this->postId = $postid;
        $this->id_db_settings = $id_db_settings;

        $Update = new Update();
        $Update->ExeUpdate(self::odontograma, $this->Data, "WHERE id=:ix AND id_paciente=:i AND id_db_settings=:id ", "ix={$id}&i={$this->postId}&id={$this->id_db_settings}");

        if($Update->getResult()):
            $this->Error = ["O Odontograma foi atualizado com sucesso!", WS_ACCEPT];
            $this->Result = true;
        else:
            $this->Error = ["Aconteceu um erro ao atualizar o Odontograma!", WS_ERROR];
            $this->Result = false;
        endif;
    }

    public function CreateOdontograma($id_db_settings, $postid, $Data){
        $this->Data = $Data;
        $this->id_db_settings = $id_db_settings;
        $this->postId = $postid;

        $Read = new Read();
        $Read->ExeRead("cv_customer_odontograma", "WHERE id_paciente=:i AND id_db_settings=:st AND dente=:dt ", "i={$postid}&st={$id_db_settings}&dt={$this->Data['dente']}");

        if($Read->getResult()):
            $this->Result = false;
            $this->Error = ["O dente selecionado já encontra-se cadastrado", WS_ERROR];
        else:
            $this->Data['id_db_settings'] = $id_db_settings;
            $this->Data['id_paciente'] = $postid;
            $this->CreaTeOdontogramaO();
        endif;
    }

    private function CreaTeOdontogramaO(){
        $Create = new Create();
        $Create->ExeCreate(self::odontograma, $this->Data);

        if($Create->getResult()):
            $this->Error = ["Odontograma salvo com sucesso!", WS_ACCEPT];
            $this->Result = true;
        else:
            $this->Error = ["Aconteceu um erro inesperado ao salvar o Odontograma!", WS_ERROR];
            $this->Result = false;
        endif;
    }

    public function Anamnese($postid, $ClienteData, $id_db_settings){
        $this->postId = strip_tags(trim($postid));
        $this->id_db_settings = strip_tags(trim($id_db_settings));
        $this->Data = $ClienteData;

        unset($this->Data['SendPostForm']);

        $Read = new Read();
        $Read->ExeRead(self::anamnese, "WHERE id_paciente=:i AND id_db_settings=:ip ", "i={$this->postId}&ip={$this->id_db_settings}");

        if($Read->getResult()):
            $this->UpdateAnamnese();
        else:
            $this->Data['id_paciente'] = $this->postId;
            $this->Data['id_db_settings'] = $this->id_db_settings;
            $this->CreateAnamnese();
        endif;
    }

    private function UpdateAnamnese(){
        $Update = new Update();
        $Update->ExeUpdate(self::anamnese, $this->Data, "WHERE id_paciente=:i AND id_db_settings=:id ", "i={$this->postId}&id={$this->id_db_settings}");

        if($Update->getResult()):
            $this->Error = ["O Anamnese foi atualizado com sucesso!", WS_ACCEPT];
            $this->Result = true;
        else:
            $this->Error = ["Aconteceu um erro ao atualizar o Anamnese!", WS_ERROR];
            $this->Result = false;
        endif;
    }

    private function CreateAnamnese(){
        $Create = new Create();
        $Create->ExeCreate(self::anamnese, $this->Data);

        if($Create->getResult()):
            $this->Error = ["Anamnese salvo com sucesso!", WS_ACCEPT];
            $this->Result = true;
        else:
            $this->Error = ["Aconteceu um erro inesperado ao salvar o Anamnese!", WS_ERROR];
            $this->Result = false;
        endif;
    }

    private function CreategbSent(){
        $Create = new Create();
        $Create->ExeCreate(self::arquivo, $this->Data);

        if($Create->getResult()):
            $this->Error = ["Ficheiro salvo com sucesso!", WS_ACCEPT];
            $this->Result = true;
        else:
            $this->Error = ["Aconteceu um erro inesperado ao salvar o ficheiro!", WS_ERROR];
            $this->Result = false;
        endif;
    }

    public function ContactCustomer($postid, $ClienteData, $id_db_settings){
        $this->postId = strip_tags(trim($postid));
        $this->id_db_settings = strip_tags(trim($id_db_settings));
        $this->Data = $ClienteData;

        unset($this->Data['SendPostForm']);

        if(!isset($this->Data['nome']) || empty($this->Data['nome']) || !isset($this->Data['telefone']) || empty($this->Data['telefone'])):
            $this->Error = ["Os campos nome e telefone são de caracter obrigatório!", WS_ALERT];
            $this->Result = false;
        elseif(!is_numeric($this->Data['telefone']) || strlen($this->Data['telefone']) > 9 || strlen($this->Data['telefone']) < 9):
            $this->Error = ["O campo telefone deve ter 9 digitos e tem que ser do tipo numérico!", WS_INFOR];
            $this->Result = false;
        elseif(isset($this->Data['email']) && !Check::Email($this->Data['email']) || !empty($this->Data['email']) && !Check::Email($this->Data['email'])):
            $this->Error = ["Introduza um endereço de e-mail válido!", WS_ALERT];
            $this->Result = false;
        else:
            $Read = new Read();
            $Read->ExeRead(self::contact, "WHERE id_paciente=:i AND id_db_settings=:id ", "i={$this->postId}&id={$this->id_db_settings}");

            if($Read->getResult()):
                $this->UpdateContact();
            else:
                $this->Data['id_db_settings'] = $this->id_db_settings;
                $this->Data['id_paciente'] = $this->postId;
                $this->Data['status'] = 1;

                $this->CreateContact();
            endif;
        endif;
    }

    private function UpdateContact(){
        $Update = new Update();
        $Update->ExeUpdate(self::contact, $this->Data, "WHERE id_paciente=:i AND id_db_settings=:id ", "i={$this->postId}&id={$this->id_db_settings}");

        if($Update->getResult()):
            $this->Error = ["O contato de emergência foi atualizado com sucesso!", WS_ACCEPT];
            $this->Result = true;
        else:
            $this->Error = ["Aconteceu um erro ao atualizar o contato de emergência!", WS_ERROR];
            $this->Result = false;
        endif;
    }

    private function CreateContact(){
        $Create = new Create();
        $Create->ExeCreate(self::contact, $this->Data);

        if($Create->getResult()):
            $this->Error = ["O contato de emergência foi salvo com sucesso!", WS_ACCEPT];
            $this->Result = true;
        else:
            $this->Error = ["Aconteceu um erro inesperado ao salvar o contato de emergência!", WS_ERROR];
            $this->Result = false;
        endif;
    }

    public function UpdateSchedule($id_db_settings, $postId, $Data){
        $this->id_db_settings = strip_tags(trim($id_db_settings));
        $this->postId = strip_tags(trim($postId));
        $this->Data = $Data;

        $content = $this->Data['content_schedule'];
        unset($this->Data['content_schedule']);

        if(in_array("", $this->Data)):
            $this->Error = ["Preencha todos os campos para prosseguir com o agendamento!", WS_ALERT];
            $this->Result = false;
        else:
            $this->Data['content_schedule'] = $content;
            $this->ScheuleUpdate();
        endif;
    }

    private function ScheuleUpdate(){
        $Update = new Update();
        $Update->ExeUpdate(self::clinic_agendamento, $this->Data, "WHERE id=:ip AND id_db_settings=:i ", "ip={$this->postId}&i={$this->id_db_settings}");

        if($Update->getResult()):
            $this->Error = ["A agenda foi atualizada com sucesso!", WS_ACCEPT];
            $this->Result = true;
        else:
            $this->Error = ["Aconteceu um erro ao atualizar a agenda!", WS_ERROR];
            $this->Result = false;
        endif;
    }

    public function CreateSchedule($id_db_settings, array $Data){
        $this->id_db_settings = strip_tags(trim($id_db_settings));
        $this->Data = $Data;

        $content = $this->Data['content_schedule'];
        unset($this->Data['content_schedule']);

        if(in_array("", $this->Data)):
            $this->Error = ["Preencha todos os campos para prosseguir com o agendamento!", WS_ALERT];
            $this->Result = false;
        else:
            $this->Data['content_schedule'] = $content;

            if(date('Y-m-d') > $this->Data['date_schedule']):
                $this->Result = false;
                $this->Error = ["Não é possivel agendar uma consulta para datas anteriores!", WS_INFOR];
            else:
                $data = $this->Data['date_schedule'];
                $dia_da_semana = date('l', strtotime($data));

                $Read = new Read();
                $Read->ExeRead(self::clinic_horario, "WHERE id_user=:i AND dia_da_semana=:st ", "i={$this->Data['id_medico']}&st={$dia_da_semana}");

                if(!$Read->getResult()):
                    $this->Error = ["O médico selecionado não está escalado nesse dia!", WS_ALERT];
                    $this->Result = false;
                else:
                    $Read->ExeRead(self::clinic_agendamento, "WHERE (id_medico=:i AND id_db_settings=:io AND date_schedule=:date AND hora_i_schedule=:h1 AND hora_f_schedule=:h2 ) OR (id_medico=:i AND id_db_settings=:io AND date_schedule=:date AND hora_i_schedule=:h2 AND hora_f_schedule=:h1)", "i={$this->Data['id_medico']}&io={$this->id_db_settings}&date={$this->Data['date_schedule']}&h1={$this->Data['hora_i_schedule']}&h2={$this->Data['hora_f_schedule']}");

                    if($Read->getResult()):
                        $this->Error = ["O horário selecionado já encontra-se agendado!", WS_ALERT];
                        $this->Result = false;
                    else:
                        $this->Data['id_db_settings'] = $this->id_db_settings;
                        $this->ScheduleCreate();
                    endif;
                endif;
            endif;
        endif;
    }

    private function ScheduleCreate(){
        $Create = new Create();
        $Create->ExeCreate(self::clinic_agendamento, $this->Data);

        if($Create->getResult()):
            $this->Error = ["Agendamento salvo com sucesso!", WS_ACCEPT];
            $this->Result = true;
        else:
            $this->Error = ["Aconteceu um erro inesperado ao salvar o agendamento!", WS_ERROR];
            $this->Result = false;
        endif;
    }

    public function UpdatePacientes($postId, array $Cover, array $Data, $id_db_settings){
        $this->Data = $Data;
        $this->postId = strip_tags(trim($postId));
        $this->Cover = $Cover;
        $this->id_db_settings = strip_tags(trim($id_db_settings));

        unset($this->Data['SendPostForm']);

        if(!in_array('', $this->Cover)):
            $this->SendLogotype();
            if($this->Result):
                $this->Data['cover'] = $this->Cover['logotype'];
            endif;
        endif;

        if(!isset($this->Data['nome']) || empty($this->Data['nome'])):
            $this->Error = ["O campo nome é de caracter obrigatório!", WS_ALERT];
            $this->Result = false;
        elseif(!is_numeric($this->Data['telefone']) || !empty($this->Data['telefone']) && strlen($this->Data['telefone']) < 9 || !empty($this->Data['telefone']) && strlen($this->Data['telefone']) > 9):
            $this->Error = ["Introduza um número de telefone válido!", WS_ALERT];
            $this->Result = false;
        elseif(!empty($this->Data['email']) && !Check::Email($this->Data['email'])):
            $this->Error = ["Introduza um endereço de e-mail válido!", WS_ALERT];
            $this->Result = false;
        else:
            $this->UpdatePaciente();
        endif;
    }

    private function UpdatePaciente(){
        $Update = new Update();
        $Update->ExeUpdate(self::pacientes, $this->Data, "WHERE id_db_settings=:i AND id=:ix ", "i={$this->id_db_settings}&ix={$this->postId}");

        if($Update->getResult()):
            $this->Error = ["A ficha do paciente foi atualizada com sucesso!", WS_ACCEPT];
            $this->Result = true;
        else:
            $this->Error = ["Aconteceu um erro ao atualizar a ficha do paciente!", WS_ERROR];
            $this->Result = false;
        endif;
    }

    public function SalvePaciente($id_db_settings, array $Data){
        $this->id_db_settings = strip_tags(trim($id_db_settings));
        $this->Data = $Data;

        if(!isset($this->Data['nome']) || empty($this->Data['nome'])):
            $this->Error = ["O campo nome é de caracter obrigatório!", WS_ALERT];
            $this->Result = false;
        elseif(!empty($this->Data['telefone']) && strlen($this->Data['telefone']) < 9 || !empty($this->Data['telefone']) && strlen($this->Data['telefone']) > 9):
            $this->Error = ["Introduza um número de telefone válido!", WS_ALERT];
            $this->Result = false;
        elseif(!empty($this->Data['email']) && !Check::Email($this->Data['email'])):
            $this->Error = ["Introduza um endereço de e-mail válido!", WS_ALERT];
            $this->Result = false;
        else:
            $this->Data['city'] = "Luanda";
            $this->Data['country'] = "AO";
            $this->Data['status'] = 1;
            $this->Data['type'] = "Pessoa Física";
            $this->Data['id_db_settings'] = $this->id_db_settings;

            if(!empty($this->Data['nif'])):
                $Read = new Read();
                $Read->ExeRead(self::pacientes, "WHERE nif=:i AND id_db_settings=:ip ", "i={$this->Data['nif']}&ip={$this->id_db_settings}");

                if($Read->getResult()):
                    $this->Error = ["O nif digitado, já encontra-se inserido na ficha de outro paciente dessa instituíção!", WS_ALERT];
                    $this->Result = false;
                else:
                    $this->SalveFichaDePaciente();
                endif;
            else:
                $this->Data['nif'] = "999999999";

                $this->SalveFichaDePaciente();
            endif;
        endif;
    }

    private function SalveFichaDePaciente(){
        $Create = new Create();
        $Create->ExeCreate(self::pacientes, $this->Data);

        if($Create->getResult()):
            $this->Error = ["Ficha de paciente salva com sucesso!", WS_ACCEPT];
            $this->Result = true;
        else:
            $this->Error = ["Aconteceu um erro inesperado ao salvar ficha do paciente!", WS_ERROR];
            $this->Result = false;
        endif;
    }

    public function PorcentagemGanhos($id_db_settings, $id_user, array $Data){
        $this->Data = $Data;
        $this->id_user = $id_user;
        $this->id_db_settings = strip_tags(trim($id_db_settings));

        if(in_array("", $this->Data)):
            $this->Error = ["Preencha todos os campos para prosseguir com o processo!", WS_ALERT];
            $this->Result = false;
        elseif(!intval($this->Data['porcentagem']) || $this->Data['porcentagem'] <= 0 || $this->Data['porcentagem'] > 100):
            $this->Error = ["A porcentagem de ganho deve ser do tipo inteiro e tem que estar no intervalo de 1 à 100%", WS_ALERT];
            $this->Result = false;
        else:
            $Read = new Read();
            $Read->ExeRead(self::clinic_porcentagem, "WHERE id_db_settings=:i AND id_user=:id ", "i={$this->id_db_settings}&id={$this->id_user}");

            if($Read->getResult()):
                $this->UpdatePorcentagem();
            else:
                $this->Data['id_db_settings'] = $this->id_db_settings;
                $this->Data['id_user'] = $id_user;
                $this->Data['status'] = 1;

                $this->CreatePorcentagem();
            endif;
        endif;
    }

    private function UpdatePorcentagem(){
        $Update = new Update();
        $Update->ExeUpdate(self::clinic_porcentagem, $this->Data, "WHERE id_db_settings=:i AND id_user=:id ", "i={$this->id_db_settings}&id={$this->id_user}");

        if($Update->getResult()):
            $this->Error = ["Porcentagem de ganhos foi atualizada com sucesso!", WS_ACCEPT];
            $this->Result = true;
        else:
            $this->Error = ["Aconteceu um erro ao atualizar a Porcentagem de ganhos!", WS_ERROR];
            $this->Result = false;
        endif;
    }

    private function CreatePorcentagem(){
        $Create = new Create();
        $Create->ExeCreate(self::clinic_porcentagem, $this->Data);

        if($Create->getResult()):
            $this->Error = ["Porcentagem de ganhos salvo com sucesso!", WS_ACCEPT];
            $this->Result = true;
        else:
            $this->Error = ["Aconteceu um erro inesperado ao salvar a Porcentagem de ganhos!", WS_ERROR];
            $this->Result = false;
        endif;
    }

    public function ClinicHorarioUpdate($postId, array $Data){
        $this->postId = strip_tags(trim($postId));
        $this->Data = $Data;

        if(in_array("", $this->Data)):
            $this->Error = ["Preencha todos os campos para prosseguir com o processo!", WS_ALERT];
            $this->Result = false;
        else:
            $this->UpdateClinicHorario();
        endif;
    }

    private function UpdateClinicHorario(){
        $Update = new Update();
        $Update->ExeUpdate(self::clinic_horario, $this->Data, "WHERE id=:i ", "i={$this->postId}");

        if($Update->getResult()):
            $this->Error = ["Horário atualizado com sucesso!", WS_ACCEPT];
            $this->Result = true;
        else:
            $this->Error = ["Aconteceu um erro ao atualizar o horário!", WS_ERROR];
            $this->Result = false;
        endif;
    }

    public function CreateHorario($id_user, $id_db_settings, array $Data){
        $this->id_user = strip_tags(trim($id_user));
        $this->id_db_settings = strip_tags(trim($id_db_settings));
        $this->Data = $Data;

        if(in_array("", $this->Data)):
            $this->Error = ["Preencha todos os campos para prosseguir com o processo!", WS_ALERT];
            $this->Result = false;
        else:
            $Read = new Read();
            $Read->ExeRead(self::clinic_horario, "WHERE id_user=:i AND id_db_settings=:id AND hora_i=:i1 AND hora_f=:i2 AND dia_da_semana=:i3 ", "i={$this->id_user}&id={$this->id_db_settings}&i1={$this->Data['hora_i']}&i2={$this->Data['hora_f']}&i3={$this->Data['dia_da_semana']}");

            if($Read->getResult()):
                $this->Error = ["O Horário selecionado, já encontra-se preenchido para o presente Médico(a)!", WS_ALERT];
                $this->Result = false;
            else:
                $this->Data['id_db_settings'] = $this->id_db_settings;
                $this->Data['id_user'] = $this->id_user;
                $this->Data['status'] = 1;

                $this->CreateHorarioSave();
            endif;
        endif;
    }

    private function CreateHorarioSave(){
        $Create = new Create();
        $Create->ExeCreate(self::clinic_horario, $this->Data);

        if($Create->getResult()):
            $this->Error = ["Horário salvo com sucesso!", WS_ACCEPT];
            $this->Result = true;
        else:
            $this->Error = ["Aconteceu um erro inesperado ao salvar o horário!", WS_ERROR];
            $this->Result = false;
        endif;
    }
}
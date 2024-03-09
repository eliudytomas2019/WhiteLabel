<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
$mail = new PHPMailer(true);

$read = new Read();
$read->ExeRead("ws_times");
if($read->getResult()):
    foreach ($read->getResult() as $time):
        $data_inicials = date('Y-m-d');
        $data_finals = $time['times'];
        $diferencas = strtotime($data_finals) - strtotime($data_inicials);
        $dia = floor($diferencas / (60 * 60 * 24));

        $Meses = ["", "Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"];
        $exe = explode("-", $time['times']);

        $read->ExeRead("db_settings", "WHERE id_db_kwanzar=:i", "i={$time['id_db_kwanzar']}");
        if($read->getResult()):
            foreach ($read->getResult() as $value):
                if($value['email'] != null && Check::Email($value['email'])):
                    $Read = new Read();

                    $planos = null;
                    $Read->ExeRead("website_pricing", "ORDER BY preco DESC LIMIT 1");
                    if($Read->getResult()): $planos = str_replace(",", ".", number_format($Read->getResult()[0]['preco'], 2)); endif;

                    $Read->ExeRead("ws_control", "WHERE id_db_settings=:i", "i={$value['id']}");
                    if($Read->getResult()):
                        $Control = $Read->getResult()[0];

                        if($Control['ano'] >= date('Y') && $Control['mes'] != date('m')):
                            if($dia <= 5 && $dia >= 1):
                                try{
                                    //$mail->SMTPDebug = SMTP::DEBUG_SERVER;
                                    $mail->CharSet = 'UTF-8';
                                    $mail->isSMTP();
                                    $mail->Host       = MailHost;
                                    $mail->SMTPAuth   = true;
                                    $mail->Username   = Email;
                                    $mail->Password   = SenhaEmail;
                                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                                    $mail->Port       = PortaEmail;

                                    $mail->setFrom(Email, EmailNome);
                                    $mail->addAddress("{$value['email']}", "{$value['empresa']}");     //Add a recipient

                                    $mail->isHTML(true);
                                    $mail->Subject = "Licença do software a terminar";
                                    $mail->Body    = "
                                            <p style='margin: 0px 25%!important;text-align: justify!important;'>{$value['empresa']}</p>,<br/>
                                            
                                            <p style='margin: 0px 25%!important;text-align: justify!important;'>A sua licença ProSmart,  termina já no próximo dia {$exe[2]} de {$Meses[ltrim($exe[1], "0")]} de {$exe[0]} .</p><br/>
                                            <p style='margin: 0px 25%!important;text-align: justify!important;'>Para continuar a faturar, subscreva um dos nossos planos apartir de {$planos} AOA/Mês </p><br/>
                                            
                                            
                                            
                                            <p style='margin: 0px 25%!important;text-align: justify!important;border-top: 1px solid #a4a4a4!important;
                                            padding-top: 10px!important;'>".EmailNome."</p><br/><br/><br/>
                                            
                                            <p style='margin: 0 auto!important;text-align: center!important;'>Suporte ao Cliente: {$Index['email']} | {$Index['telefone']}</p><br/>
                                             <p style='margin: 0 auto!important;text-align: center!important;'>{$Index['endereco']}</p><br/>
                                        ";

                                    $mail->send();
                                } catch(Exception $e){
                                    WSError("Aconteceu um erro inesperado ao enviar o E-mail: {$mail->ErrorInfo}", WS_ERROR);
                                }

                                $Data0["id_db_settings"] = $value['id'];
                                $Data0['dia'] = date('d');
                                $Data0['mes'] = date('m');
                                $Data0['ano'] = date('Y');
                                $Data0['status'] = 1;

                                $Create = new Create();
                                $Create->ExeCreate("ws_control", $Data0);

                                if(!$Create->getResult()):
                                    WSError("Aconteceu um erro ao salvar os emails!", WS_INFOR);
                                endif;
                            endif;
                        endif;
                    else:
                        if($dia <= 5 && $dia >= 1):
                            try{
                                //$mail->SMTPDebug = SMTP::DEBUG_SERVER;
                                $mail->CharSet = 'UTF-8';
                                $mail->isSMTP();
                                $mail->Host       = MailHost;
                                $mail->SMTPAuth   = true;
                                $mail->Username   = Email;
                                $mail->Password   = SenhaEmail;
                                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                                $mail->Port       = PortaEmail;

                                $mail->setFrom(Email, EmailNome);
                                $mail->addAddress("{$value['email']}", "{$value['empresa']}");     //Add a recipient

                                $mail->isHTML(true);
                                $mail->Subject = "Licença do software a terminar";
                                $mail->Body    = "
                                            <p style='margin: 0px 25%!important;text-align: justify!important;'>{$value['empresa']}</p>,<br/>
                                            
                                            <p style='margin: 0px 25%!important;text-align: justify!important;'>A sua licença ProSmart,  termina já no próximo dia {$exe[2]} de {$Meses[ltrim($exe[1], "0")]} de {$exe[0]} .</p><br/>
                                            <p style='margin: 0px 25%!important;text-align: justify!important;'>Para continuar a faturar, subscreva um dos nossos planos apartir de {$planos} AOA/Mês </p><br/>
                                            
                                            
                                            
                                            <p style='margin: 0px 25%!important;text-align: justify!important;border-top: 1px solid #a4a4a4!important;
                                            padding-top: 10px!important;'>".EmailNome."</p><br/><br/><br/>
                                            
                                            <p style='margin: 0 auto!important;text-align: center!important;'>Suporte ao Cliente: {$Index['email']} | {$Index['telefone']}</p><br/>
                                             <p style='margin: 0 auto!important;text-align: center!important;'>{$Index['endereco']}</p><br/>
                                        ";

                                $mail->send();
                            } catch(Exception $e){
                                WSError("Aconteceu um erro inesperado ao enviar o E-mail: {$mail->ErrorInfo}", WS_ERROR);
                            }

                            $Data0["id_db_settings"] = $value['id'];
                            $Data0['dia'] = date('d');
                            $Data0['mes'] = date('m');
                            $Data0['ano'] = date('Y');
                            $Data0['status'] = 1;

                            $Create = new Create();
                            $Create->ExeCreate("ws_control", $Data0);

                            if(!$Create->getResult()):
                                WSError("Aconteceu um erro ao salvar os emails!", WS_INFOR);
                            endif;
                        endif;
                    endif;
                endif;
            endforeach;
        endif;
    endforeach;
endif;
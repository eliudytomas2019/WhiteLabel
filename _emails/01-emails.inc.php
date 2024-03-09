<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

$mail = new PHPMailer(true);

require_once("../Config.inc.php");

$Read = new Read();

$Read->ExeRead("z_config");
if($Read->getResult()):
    $Index = $Read->getResult()[0];
else:
    $Index = null;
endif;

$Read->ExeRead("ws_times");

if($Read->getResult()):
    foreach ($Read->getResult() as $key):
        if($key['status'] == 0):
            $planos = null;
            $Read->ExeRead("website_pricing", "ORDER BY preco DESC LIMIT 1");
            if($Read->getResult()): $planos = str_replace(",", ".", number_format($Read->getResult()[0]['preco'], 2)); endif;

            $Read->ExeRead("db_settings", "WHERE id_db_kwanzar=:is", "is={$key['id_db_kwanzar']}");

            if($Read->getResult()):
                foreach ($Read->getResult() as $value):
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
                        $mail->Subject = "Licença do software terminou";
                        $mail->Body    = "
                            <p style='margin: 0px 25%!important;text-align: justify!important;'>{$value['empresa']}</p>,<br/>
                            
                            <p style='margin: 0px 25%!important;text-align: justify!important;'>A sua licença no ProSmart, terminou.</p><br/>
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
                endforeach;
            endif;
        endif;
    endforeach;

    exit();
else:
    exit();
endif;
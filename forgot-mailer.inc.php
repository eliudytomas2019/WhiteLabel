<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require './vendor/autoload.php';

$mail = new PHPMailer(true);

try{
    $mail->CharSet = 'UTF-8';
    $mail->isSMTP();
    $mail->Host       = MailHost;
    $mail->SMTPAuth   = true;
    $mail->Username   =  Email;
    $mail->Password   = SenhaEmail;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port       = PortaEmail;

    $mail->setFrom(Email, EmailName);
    $mail->addAddress("{$Data['username']}", "{$Data['name']}");     //Add a recipient

    $mail->isHTML(true);
    $mail->Subject = "Alteração da senha da conta Kwanzar!";
    $mail->Body    = "
     <p style='margin: 0px 25%!important;text-align: justify!important;'>Olá, <strong>{$Data['name']}</strong></p><br/>
                        <p style='margin: 0px 25%!important;text-align: justify!important;'>Uma solicitação de alteração da senha da sua conta foi feita recentemente. Caso tenha solicitado essa alteração de senha, você tem 24 horas para clicar no link abaixo para definir uma nova senha:</p><br/>
                        
                        <a target='_blank' href='".HOME."finished.php?code=5N2DZ3WK87hGS07db0Swf9TN0eiVyuGUwF_VTwTehqE&postId=".$Data['id']."' style='margin: 0px 25%!important;text-align: justify!important;'>".HOME."finished.php?code=5N2DZ3WK87hGS07db0Swf9TN0eiVyuGUwF_VTwTehqE&postId=".$Data['id']."</a><br/><br/>
                        
                        <p style='margin: 0px 25%!important;text-align: justify!important;'>Se não desejar alterar sua senha, ignore esta mensagem.</p><br/>
                        
                        <p style='margin: 0px 25%!important;text-align: justify!important;'>Obrigado por escolher à {$Index['name']}.</p>
                        <p style='margin: 0px 25%!important;text-align: justify!important;'>".EmailName."</p>
    ";

    $mail->send();
    WSError("E-mail enviado com sucesso!!!", WS_ACCEPT);
} catch(Exception $e){
    WSError("Aconteceu um erro inesperado ao enviar o E-mail: {$mail->ErrorInfo}", WS_ERROR);
}

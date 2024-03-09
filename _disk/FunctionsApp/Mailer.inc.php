<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../../vendor/autoload.php';

$mail = new PHPMailer(true);

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

    $mail->setFrom(Email, EmailName);
    $mail->addAddress("{$Data['username']}", "{$Data['name']}");     //Add a recipient

    $mail->isHTML(true);
    $mail->Subject = "Bem-vindo a Kwanzar!";
    $mail->Body    = "
    <p style='margin: 0px 25%!important;text-align: justify!important;'>Olá <strong>{$Data['name']}</strong>,</p><br/>
    <p style='margin: 0px 25%!important;text-align: justify!important;'>Bem-vindo(a) à {$Index['name']}</p><br/>
    
    <p style='margin: 0px 25%!important;text-align: justify!important;'>A sua conta já foi criada. Para que consiga usar o software deve efectuar os seguintes passos:</p><br/>
    
    <p style='margin: 0px 25%!important;text-align: justify!important;'><strong>1. Adicionar a Empresa no {$Index['name']}</strong></p>
    <p style='margin: 0px 25%!important;text-align: justify!important;'>O <strong>{$Index['name']}</strong>, é um software que permite gerir várias empresas/negócios em uma única conta de usuário. Por esse motivo após criar a conta de usuário terá de fazer o registro da empresa.</p><br/>
    
    <p style='margin: 0px 25%!important;text-align: justify!important;'><strong>2. Configurações Funcionais</strong></p>
    <p style='margin: 0px 25%!important;text-align: justify!important;'>Após Criar a empresa e aceder a mesma, no menu principal poderá ir em <strong>Definições</strong> e prencher as áreas que estiverem em branco para que desfrute ao máximo o software sem interrupções, avisos ou bugs. </p><br/>
    
    <p style='margin: 0px 25%!important;text-align: justify!important;'><strong>3. Adicionar os Productos/Serviços e clientes.</strong></p>
    <p style='margin: 0px 25%!important;text-align: justify!important;'>Essa é a última etapa, basta apenas registrar os Productos/Serviços e os Clientes para começar a facturar.</p><br/>
    
    <p style='margin: 0px 25%!important;text-align: justify!important;'>Não se preocupe caso não consiga fazer a configuração sozinho. Todos os dias estamos disponíveis, e iremos ajuda-lo via email, telefone, videoconferência, acesso remoto, whatsapp e presencialmente das 10h às 18h.</p><br/>
    
    <p style='margin: 0px 25%!important;text-align: justify!important;'>Pode entrar em contacto connosco através dos seguintes canais: {$Index['telefone']} | {$Index['email']}</p><br/>
    
    <p style='margin: 0px 25%!important;text-align: justify!important;'>Desde já, agradecemos a sua confiança na {$Index['name']} e desejamos-lhe a melhor das sortes e sucesso nas suas vendas!.</p><br/>
    
    <p style='margin: 0px 25%!important;text-align: justify!important;'>".EmailName."</p>
    ";

    $mail->send();
} catch(Exception $e){
    WSError("Aconteceu um erro inesperado ao enviar o E-mail: {$mail->ErrorInfo}", WS_ERROR);
}
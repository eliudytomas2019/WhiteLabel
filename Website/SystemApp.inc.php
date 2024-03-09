<?php

$acao = strip_tags((filter_input(INPUT_POST, 'acao', FILTER_DEFAULT)));

if($acao):
    require_once("../_app/Config.inc.php");
    switch ($acao):
        case 'Kwanzar':
            $name = strip_tags(trim(htmlspecialchars($_POST['name'])));
            $emails = strip_tags(trim(htmlspecialchars($_POST['RemitenteEmail'])));
            $subject = strip_tags(trim(htmlspecialchars($_POST['subject'])));
            $message = strip_tags(trim(htmlspecialchars($_POST['message'])));

            if(empty($name) || empty($emails) || empty($subject) || empty($message)):
                WSError("Oops: preencha todos os campos para prosseguir com o processo!", WS_ALERT);
            elseif(!Check::Email($emails)):
                WSError("Oops: introduza um endereço de e-mail válido!", WS_INFOR);
            else:
                $recipient = "teliudy28@gmail.com";
                $error_mssg = "Oops: aconteceu um erro ao enviar o email!";

                $email_headers = 'From:'.$name.'<'.$emails.'>'.PHP_EOL.'Reply-To: '.$name.'<'.$emails.'>'.PHP_EOL.'MIME-Version: 1.0'.PHP_EOL.'Content-type: text/html; charset=iso-8859-1'.PHP_EOL.'X-Mailer: PHP/'.phpversion();

                $sendemail_to_customer = @mail($recipient, $emails, $subject, $message);

                if (!$sendemail_to_customer):
                    WSError("Oops: aconteceu um erro inesperado ao enviar o email!", WS_ERROR);
                else:
                    WSError("Recebemos o seu e-mail, entraremos em contacto o mais breve possível!", WS_ACCEPT);
                endif;
            endif;

            break;
        default:
            WSError("Ops: não encontramos a ação desejada!", WS_INFOR);
    endswitch;
endif;
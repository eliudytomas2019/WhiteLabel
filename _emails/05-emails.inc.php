<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$Read = new Read();
$Read->ExeRead("db_settings");

if($Read->getResult()):
    foreach ($Read->getResult() as $key):
        $Read->ExeRead("cv_customer", "WHERE id_db_settings=:i ", "i={$key['id']}");

        if($Read->getResult()):
            foreach ($Read->getResult() as $item):
                if($item['email'] != null && Check::Email($item['email'])):

                    $Read->ExeRead("db_settings, db_users","WHERE db_settings.email=:ab AND db_users.username=:ab ","ab={$item['email']}");
                    if(!$Read->getResult() || !$Read->getRowCount()):
                        $read = new Read();
                        $read->ExeRead("ws_control_3", "WHERE id_customer=:i ORDER BY id DESC LIMIT 1 ","i={$item['id']}");
                        if($read->getResult()):
                            $datab = $read->getResult()[0];
                            if($datab['ano'] <= date('Y') && $datab['mes'] != date('m')):

                                $mail = new PHPMailer(true);

                                try{
                                    $mail->CharSet = 'UTF-8';
                                    $mail->isSMTP();
                                    $mail->Host       = MailHost;
                                    $mail->SMTPAuth   = true;
                                    $mail->Username   = Email;
                                    $mail->Password   = SenhaEmail;
                                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                                    $mail->Port       = PortaEmail;

                                    $mail->setFrom(Email, EmailName);
                                    $mail->addAddress("{$item['email']}", "{$item['nome']}");     //Add a recipient

                                    $mail->isHTML(true);
                                    $mail->Subject = "Software de faturação e gestão de estoque - Experimente";
                                    $mail->Body    = "
                                        <p style='margin: 0px 25%!important;text-align: justify!important;'><strong>Saudações de acordo a hora do dia.</strong></p><br/>
                                        <p style='margin: 0px 25%!important;text-align: justify!important;'>Prezado(a) Sr.(a) <strong>{$item['nome']}</strong> foi convidado(a) a experimentar o nosso software de faturação e gestão de estoque. Kwanzar, certificado pela AGT.</p><br/>
                                        <p style='margin: 0px 25%!important;text-align: justify!important;'>Nos próximos 30 dias poderá experimentar o nosso Software de Faturação Online, sem qualquer restrição e de forma totalmente gratuita!</p><br/>
                                        <p style='margin: 0px 25%!important;text-align: justify!important;'>Para criar a sua conta basta apenas aceder o link: <a href='https://kwanzar.galeranerd.ao/_register.php' target='_blank'>https://kwanzar.galeranerd.ao/_register.php</a></p><br/>
                                        <p style='margin: 0px 25%!important;text-align: justify!important;'>Durante este período, vamos enviar alguns e-mails para lhe dar a conhecer algumas funcionalidades do Kwanzar, para que possa tirar o máximo proveito do nosso software. </p><br/>
                                        <p style='margin: 0px 25%!important;text-align: justify!important;'>Recomendamos a utilização do browser Google Chrome para que tire totalmente partido do Kwanzar.</p><br/>
                                        <p style='margin: 0px 25%!important;text-align: justify!important;'>Se necessitar de ajuda, para o esclarecimento de dúvidas ou questões, temos uma equipa de suporte dedicada, dias úteis das 10:00-18:00, que poderá contactar  por chat, por email ({$Index['email']}) ou através do telefone ({$Index['telefone']}).</p><br/>
                                        <p style='margin: 0px 25%!important;text-align: justify!important;'>Obrigado,</p><br/>
                                        <p style='margin: 0px 25%!important;text-align: justify!important;'>Obrigado e até breve!</p><br/>
                        
                                        <p style='margin: 0px 25%!important;text-align: justify!important;border-top: 1px solid #a4a4a4!important;
                                        padding-top: 10px!important;'>".EmailName."</p><br/><br/><br/>
                                        <p style='margin: 0 auto!important;text-align: center!important;'>Suporte ao Cliente: {$Index['email']} | {$Index['telefone']}</p><br/>
                                        <p style='margin: 0 auto!important;text-align: center!important;'>{$Index['endereco']}</p>
                                    ";

                                    $mail->send();
                                } catch(Exception $e){
                                    WSError("Aconteceu um erro inesperado ao enviar o E-mail: {$mail->ErrorInfo}", WS_ERROR);
                                }

                                $Data3["id_customer"] = $item['id'];
                                $Data3['dia'] = date('d');
                                $Data3['mes'] = date('m');
                                $Data3['ano'] = date('Y');
                                $Data3['status'] = 1;

                                $Create = new Create();
                                $Create->ExeCreate("ws_control_3", $Data3);

                                if(!$Create->getResult()):
                                    WSError("Aconteceu um erro ao salvar os emails! (3)", WS_INFOR);
                                endif;
                            endif;
                        else:
                            $mail = new PHPMailer(true);

                            try{
                                $mail->CharSet = 'UTF-8';
                                $mail->isSMTP();
                                $mail->Host       = MailHost;
                                $mail->SMTPAuth   = true;
                                $mail->Username   = Email;
                                $mail->Password   = SenhaEmail;
                                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                                $mail->Port       = PortaEmail;

                                $mail->setFrom(Email, EmailName);
                                $mail->addAddress("{$item['email']}", "{$item['nome']}");     //Add a recipient

                                $mail->isHTML(true);
                                $mail->Subject = "Software de faturação e gestão de estoque - Experimente";
                                $mail->Body    = "
                                    <p style='margin: 0px 25%!important;text-align: justify!important;'><strong>Saudações de acordo a hora do dia.</strong></p><br/>
                                    <p style='margin: 0px 25%!important;text-align: justify!important;'>Prezado(a) Sr.(a) <strong>{$item['nome']}</strong> foi convidado(a) a experimentar o nosso software de faturação e gestão de estoque. Kwanzar, certificado pela AGT.</p><br/>
                                    <p style='margin: 0px 25%!important;text-align: justify!important;'>Nos próximos 30 dias poderá experimentar o nosso Software de Faturação Online, sem qualquer restrição e de forma totalmente gratuita!</p><br/>
                                    <p style='margin: 0px 25%!important;text-align: justify!important;'>Para criar a sua conta basta apenas aceder o link: <a href='https://kwanzar.galeranerd.ao/_register.php' target='_blank'>https://kwanzar.galeranerd.ao/_register.php</a></p><br/>
                                    <p style='margin: 0px 25%!important;text-align: justify!important;'>Durante este período, vamos enviar alguns e-mails para lhe dar a conhecer algumas funcionalidades do Kwanzar, para que possa tirar o máximo proveito do nosso software. </p><br/>
                                    <p style='margin: 0px 25%!important;text-align: justify!important;'>Recomendamos a utilização do browser Google Chrome para que tire totalmente partido do Kwanzar.</p><br/>
                                    <p style='margin: 0px 25%!important;text-align: justify!important;'>Se necessitar de ajuda, para o esclarecimento de dúvidas ou questões, temos uma equipa de suporte dedicada, dias úteis das 10:00-18:00, que poderá contactar  por chat, por email ({$Index['email']}) ou através do telefone ({$Index['telefone']}).</p><br/>
                                    <p style='margin: 0px 25%!important;text-align: justify!important;'>Obrigado,</p><br/>
                                    <p style='margin: 0px 25%!important;text-align: justify!important;'>Obrigado e até breve!</p><br/>
                    
                                    <p style='margin: 0px 25%!important;text-align: justify!important;border-top: 1px solid #a4a4a4!important;
                                    padding-top: 10px!important;'>".EmailName."</p><br/><br/><br/>
                                    <p style='margin: 0 auto!important;text-align: center!important;'>Suporte ao Cliente: {$Index['email']} | {$Index['telefone']}</p><br/>
                                    <p style='margin: 0 auto!important;text-align: center!important;'>{$Index['endereco']}</p>
                                ";

                                $mail->send();
                            } catch(Exception $e){
                                WSError("Aconteceu um erro inesperado ao enviar o E-mail: {$mail->ErrorInfo}", WS_ERROR);
                            }

                            $Data3["id_customer"] = $item['id'];
                            $Data3['dia'] = date('d');
                            $Data3['mes'] = date('m');
                            $Data3['ano'] = date('Y');
                            $Data3['status'] = 1;

                            $Create = new Create();
                            $Create->ExeCreate("ws_control_3", $Data3);

                            if(!$Create->getResult()):
                                WSError("Aconteceu um erro ao salvar os emails! (3)", WS_INFOR);
                            endif;
                        endif;
                    endif;
                endif;
            endforeach;
        endif;
    endforeach;
endif;
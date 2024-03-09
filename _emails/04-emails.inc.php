<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
$mail = new PHPMailer(true);

$Read = new Read();

$Read->ExeRead("db_users");
if($Read->getResult()):
    foreach ($Read->getResult() as $key):
        if($key['username'] != null && Check::Email($key['username'])):

            $read = new Read();
            $read->ExeRead("ws_control_2", "WHERE id_user=:i", "i={$key['id']}");

            if($read->getResult()):
                $Control2 = $read->getResult()[0];

                if( $Control2['ano'] >= date('Y') && $Control2['mes'] != date('m')):
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
                        $mail->addAddress("{$key['username']}", "{$key['name']}");     //Add a recipient

                        $mail->isHTML(true);
                        $mail->Subject = "Suporte Grátis e Ilimitado";
                        $mail->Body    = "
                            <h1 style='text-align: center!important;margin: 0px auto!important;'>Suporte GRÁTIS e ILIMITADO</h1><br/><br/>
                            
                            <p style='margin: 0px 25%!important;text-align: justify!important;'>No ProSmart, temos como prioridade cuidar dos nossos clientes. Queremos ser a primeira linha de ajuda, quando existir uma dúvida ou dificuldade e por essa razão temos uma equipa de suporte, disponível para lhe prestar o auxílio que necessita.</p><br/>
                            
                            <h2 style='text-align: center!important;margin: 0px auto!important;'>Chat, Email ou Telefone? A decisão é sua!</h2><br/><br/>
                            
                            <p style='margin: 0px 25%!important;text-align: justify!important;'>Diariamente ajudamos centenas de clientes, desde aconselhamento sobre o melhor plano a escolher, integrações, emissão de documentos, aspectos fiscais e muito mais. </p><br/>
                            <p style='margin: 0px 25%!important;text-align: justify!important;'>Para entrar em contacto com o nosso suporte, pode utilizar um dos três canais, chat, email ou telefone.</p><br/>
                            <p style='margin: 0px 25%!important;text-align: justify!important;'>Recomendamos que visite a nossa página, <a href='https://prosmart.heliospro.ao/_login.php' target='_blank'>https://prosmart.heliospro.ao/_login.php</a> e selecione o seu canal preferido para iniciar o contacto com a nossa equipa.</p><br/>
                            
                            <h2 style='text-align: center!important;margin: 0px auto!important;'>Qual o horário de atendimento?</h2><br/><br/>
                            
                            <p style='margin: 0px 25%!important;text-align: justify!important;'>Neste momento, o nosso horário de atendimento funciona em dias úteis, das 10h às 18h.</p><br/>
                            <p style='margin: 0px 25%!important;text-align: justify!important;'>Já sabe, se tiver dúvidas ou necessitar de esclarecimentos adicionais, não hesite em contactar-nos, estamos cá para ajudar!</p><br/>
                            <p style='margin: 0px auto!important;text-align: center!important;'>Até breve!</p><br/>
                            
                            <p style='margin: 0px 25%!important;text-align: justify!important;border-top: 1px solid #a4a4a4!important;
                                            padding-top: 10px!important;'>".EmailNome."</p><br/><br/><br/>
                            <p style='margin: 0 auto!important;text-align: center!important;'>Suporte ao Cliente: {$Index['email']} | {$Index['telefone']}</p><br/>
                             <p style='margin: 0 auto!important;text-align: center!important;'>{$Index['endereco']}</p>
                        ";

                        $mail->send();
                    } catch(Exception $e){
                        WSError("Aconteceu um erro inesperado ao enviar o E-mail: {$mail->ErrorInfo}", WS_ERROR);
                    }

                    $Data1["id_user"] = $key['id'];
                    $Data1['dia'] = date('d');
                    $Data1['mes'] = date('m');
                    $Data1['ano'] = date('Y');
                    $Data1['status'] = 1;

                    $Create = new Create();
                    $Create->ExeCreate("ws_control_2", $Data1);

                    if(!$Create->getResult()):
                        WSError("Aconteceu um erro ao salvar os emails! (2)", WS_INFOR);
                    endif;
                endif;
            else:
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
                    $mail->addAddress("{$key['username']}", "{$key['name']}");     //Add a recipient

                    $mail->isHTML(true);
                    $mail->Subject = "Suporte Grátis e Ilimitado";
                    $mail->Body    = "
                            <h1 style='text-align: center!important;margin: 0px auto!important;'>Suporte GRÁTIS e ILIMITADO</h1><br/><br/>
                            
                            <p style='margin: 0px 25%!important;text-align: justify!important;'>No ProSmart, temos como prioridade cuidar dos nossos clientes. Queremos ser a primeira linha de ajuda, quando existir uma dúvida ou dificuldade e por essa razão temos uma equipa de suporte, disponível para lhe prestar o auxílio que necessita.</p><br/>
                            
                            <h2 style='text-align: center!important;margin: 0px auto!important;'>Chat, Email ou Telefone? A decisão é sua!</h2><br/><br/>
                            
                            <p style='margin: 0px 25%!important;text-align: justify!important;'>Diariamente ajudamos centenas de clientes, desde aconselhamento sobre o melhor plano a escolher, integrações, emissão de documentos, aspectos fiscais e muito mais. </p><br/>
                            <p style='margin: 0px 25%!important;text-align: justify!important;'>Para entrar em contacto com o nosso suporte, pode utilizar um dos três canais, chat, email ou telefone.</p><br/>
                            <p style='margin: 0px 25%!important;text-align: justify!important;'>Recomendamos que visite a nossa página, <a href='https://prosmart.heliospro.ao/_login.php' target='_blank'>https://prosmart.heliospro.ao/_login.php</a> e selecione o seu canal preferido para iniciar o contacto com a nossa equipa.</p><br/>
                            
                            <h2 style='text-align: center!important;margin: 0px auto!important;'>Qual o horário de atendimento?</h2><br/><br/>
                            
                            <p style='margin: 0px 25%!important;text-align: justify!important;'>Neste momento, o nosso horário de atendimento funciona em dias úteis, das 10h às 18h.</p><br/>
                            <p style='margin: 0px 25%!important;text-align: justify!important;'>Já sabe, se tiver dúvidas ou necessitar de esclarecimentos adicionais, não hesite em contactar-nos, estamos cá para ajudar!</p><br/>
                            <p style='margin: 0px auto!important;text-align: center!important;'>Até breve!</p><br/>
                            
                            <p style='margin: 0px 25%!important;text-align: justify!important;border-top: 1px solid #a4a4a4!important;
                                            padding-top: 10px!important;'>".EmailNome."</p><br/><br/><br/>
                            <p style='margin: 0 auto!important;text-align: center!important;'>Suporte ao Cliente: {$Index['email']} | {$Index['telefone']}</p><br/>
                             <p style='margin: 0 auto!important;text-align: center!important;'>{$Index['endereco']}</p>
                        ";

                    $mail->send();
                } catch(Exception $e){
                    WSError("Aconteceu um erro inesperado ao enviar o E-mail: {$mail->ErrorInfo}", WS_ERROR);
                }

                $Data1["id_user"] = $key['id'];
                $Data1['dia'] = date('d');
                $Data1['mes'] = date('m');
                $Data1['ano'] = date('Y');
                $Data1['status'] = 1;

                $Create = new Create();
                $Create->ExeCreate("ws_control_2", $Data1);

                if(!$Create->getResult()):
                    WSError("Aconteceu um erro ao salvar os emails! (2)", WS_INFOR);
                endif;
            endif;
        endif;
    endforeach;
endif;
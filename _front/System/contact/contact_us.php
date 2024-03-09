<?php
$title = "Contactos - {$Index['name']}";

$Seo = new SEO($title, $Index['content'], "Vendus, PHC, Software de facturação, Programa de faturação, AGT, Software Grátis, Kwanzar, Kwanza, Licenciado AGT, Licença, Factura, Restaurantes, Restaurante, Bar", "index, follow", "{$_SERVER['REQUEST_URI']}}", "Eliúdy Tomás");
$Seo->metaTags();

$yX = explode("-", $title);
include("_front/Includes/Section.inc.php");
?>

<div class="container-fluid contact bg-light py-5">
    <div class="container py-5">
        <div class="mx-auto text-center mb-5" style="max-width: 900px;">
            <h5 class="section-title px-3">Contactos</h5>
            <h1 class="mb-0">Suporte ao Cliente</h1>
        </div>
        <div class="row g-5 align-items-center">
            <div class="col-lg-4">
                <div class="bg-white rounded p-4">
                    <div class="text-center mb-4">
                        <i class="fa fa-map-marker-alt fa-3x text-primary"></i>
                        <h4 class="text-primary"><Address></Address></h4>
                        <p class="mb-0"><?= $Index['endereco']; ?></p>
                    </div>
                    <div class="text-center mb-4">
                        <i class="fa fa-phone-alt fa-3x text-primary mb-3"></i>
                        <h4 class="text-primary">Telefone</h4>
                        <p class="mb-0"><?= $Index['telefone']; ?></p>
                    </div>

                    <div class="text-center">
                        <i class="fa fa-envelope-open fa-3x text-primary mb-3"></i>
                        <h4 class="text-primary">Email</h4>
                        <p class="mb-0"><?= $Index['email']; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <h3 class="mb-2">Deixe uma mensagem</h3>
                <p class="mb-4">Fale connosco através do chat, telefone ou e-mail. O nosso serviço de suporte ao cliente funciona entre as 9:30 e as 18h em dias úteis.</p>
                <form action="#getResult" method="post" enctype="multipart/form-data">
                    <?php
                    use PHPMailer\PHPMailer\PHPMailer;
                    use PHPMailer\PHPMailer\SMTP;
                    use PHPMailer\PHPMailer\Exception;

                    require './vendor/autoload.php';

                    $SendPostFormL = filter_input(INPUT_POST, "SendPostFormL");
                    if(isset($SendPostFormL)):
                        $ClienteData = filter_input_array(INPUT_POST, FILTER_DEFAULT);
                        if ($ClienteData && $ClienteData['SendPostFormL']):
                            $name = strip_tags(trim(htmlspecialchars($ClienteData['name'])));
                            $emails = strip_tags(trim(htmlspecialchars($ClienteData['RemitenteEmail'])));
                            $subject = strip_tags(trim(htmlspecialchars($ClienteData['subject'])));
                            $message = strip_tags(trim(htmlspecialchars($ClienteData['message'])));

                            if(empty($name) || empty($emails) || empty($subject) || empty($message)):
                                WSError("Oops: preencha todos os campos para prosseguir com o processo!", WS_ALERT);
                            elseif(!Check::Email($emails)):
                                WSError("Oops: introduza um endereço de e-mail válido!", WS_INFOR);
                            else:
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

                                    $mail->setFrom("{$ClienteData['RemitenteEmail']}", "{$ClienteData['name']}");
                                    $mail->addAddress(Email, EmailName);

                                    $mail->isHTML(true);
                                    $mail->Subject = "{$ClienteData['subject']}";
                                    $mail->Body    = "{$ClienteData['message']}";

                                    $mail->send();
                                    WSError("Recebemos o seu email, entraremos em contacto o mais breve possível!", WS_ACCEPT);
                                } catch(Exception $e){
                                    WSError("Aconteceu um erro inesperado ao enviar o E-mail: {$mail->ErrorInfo}", WS_ERROR);
                                }
                            endif;
                        endif;
                    endif;
                    ?>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control border-0" value="<?php if (!empty($ClienteData['name'])) echo $ClienteData['name']; ?>" name="name" id="name">
                                <label for="name">Nome</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control border-0" value="<?php if (!empty($ClienteData['subject'])) echo $ClienteData['subject']; ?>" name="subject" id="subject">
                                <label for="email">Assunto</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-floating">
                                <input type="text" class="form-control border-0" value="<?php if (!empty($ClienteData['RemitenteEmail'])) echo $ClienteData['RemitenteEmail']; ?>" name="RemitenteEmail" id="RemitenteEmail">
                                <label for="subject">Email</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-floating">
                                <textarea class="form-control border-0" name="message" id="message"  cols="30" rows="7"><?php if (!empty($ClienteData['message'])) echo $ClienteData['message']; ?></textarea>
                                <label for="message">Mensagem</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <input class="btn btn-primary w-100 py-3" type="submit" name="SendPostFormL" value="Enviar"/>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<?php
include("_front/Includes/subscribe.inc.php");
?>
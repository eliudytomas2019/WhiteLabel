<section class="hero-wrap hero-wrap-2" style="background-image: url('images/bg_2.jpg');" data-stellar-background-ratio="0.5">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text align-items-end">
            <div class="col-md-9 ftco-animate pb-5">
                <p class="breadcrumbs mb-2"><span class="mr-2"><a href="?exe=home">Home <i class="ion-ios-arrow-forward"></i></a></span> <span>Contacto <i class="ion-ios-arrow-forward"></i></span></p>
                <h1 class="mb-0 bread">Contacto</h1>
            </div>
        </div>
    </div>
</section>

<section class="ftco-section bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="wrapper">
                    <div class="row no-gutters">
                        <div class="col-lg-8 col-md-7 order-md-last d-flex align-items-stretch">
                            <div class="contact-wrap w-100 p-md-5 p-4">
                                <h3 class="mb-4">Entrar em contato</h3>
                                <div id="form-message-warning" class="mb-4"></div>
                                <div id="form-message-success getResult" class="mb-4">
                                    <?php
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
                                            $recipient = "prosmart@heliospro.ao";
                                            $error_mssg = "Oops: aconteceu um erro ao enviar o email!";

                                            $email_headers = 'From:'.$name.'<'.$emails.'>'.PHP_EOL.'Reply-To: '.$name.'<'.$emails.'>'.PHP_EOL.'MIME-Version: 1.0'.PHP_EOL.'Content-type: text/html; charset=iso-8859-1'.PHP_EOL.'X-Mailer: PHP/'.phpversion();

                                            $sms = "Nome: {$name}<br/>E-mail: {$emails}<br/> Assunto: {$subject}<br/> Mensagem: {$message}";

                                            $sendemail_to_customer = @mail($recipient, $emails, $subject, $sms);

                                            if (!$sendemail_to_customer):
                                                WSError("Oops: aconteceu um erro inesperado ao enviar o email!", WS_ERROR);
                                            else:
                                                WSError("Recebemos o seu e-mail, entraremos em contacto o mais breve possível!", WS_ACCEPT);
                                            endif;
                                        endif;
                                    endif;
                                    ?>
                                </div>
                                <form action="#getResult" method="post" enctype="multipart/form-data" id="contactForm" name="contactForm" class="contactForm">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="label" for="name">Nome</label>
                                                <input type="text" class="form-control" value="<?php if (!empty($ClienteData['name'])) echo $ClienteData['name']; ?>" name="name" id="name" placeholder="Nome">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="label" for="email">Email</label>
                                                <input type="text" class="form-control" value="<?php if (!empty($ClienteData['RemitenteEmail'])) echo $ClienteData['RemitenteEmail']; ?>" name="RemitenteEmail" id="RemitenteEmail" placeholder="Email">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="label" for="subject">Assunto</label>
                                                <input type="text" class="form-control" value="<?php if (!empty($ClienteData['subject'])) echo $ClienteData['subject']; ?>" name="subject" id="subject" placeholder="Assunto">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="label" for="#">Message</label>
                                                <textarea  rows="4" name="message" id="message" class="form-control" placeholder="Mensagem"><?php if (!empty($ClienteData['message'])) echo $ClienteData['message']; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <input type="submit" name="SendPostFormL" value="Enviar Mensagem" class="btn btn-primary">
                                                <div class="submitting"></div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-5 d-flex align-items-stretch">
                            <div class="info-wrap bg-primary w-100 p-md-5 p-4">
                                <h3>Suporte ao Cliente</h3>
                                <p class="mb-4">Fale connosco através do chat, telefone ou e-mail. O nosso serviço de suporte ao cliente funciona entre as 10h e as 18h em dias úteis.</p>
                                <div class="dbox w-100 d-flex align-items-start">
                                    <div class="icon d-flex align-items-center justify-content-center">
                                        <span class="fa fa-map-marker"></span>
                                    </div>
                                    <div class="text pl-3">
                                        <p> Avenida dos comandos, casa nº 302, Cazenga, Luanda, Angola</p>
                                    </div>
                                </div>
                                <div class="dbox w-100 d-flex align-items-center">
                                    <div class="icon d-flex align-items-center justify-content-center">
                                        <span class="fa fa-phone"></span>
                                    </div>
                                    <div class="text pl-3">
                                        <p><a href="tel://+244949482020"> 949 482 020 | 943 049 838</a></p>
                                    </div>
                                </div>
                                <div class="dbox w-100 d-flex align-items-center">
                                    <div class="icon d-flex align-items-center justify-content-center">
                                        <span class="fa fa-paper-plane"></span>
                                    </div>
                                    <div class="text pl-3">
                                        <p><a href="mailto:prosmart@heliospro.ao">prosmart@heliospro.ao</a></p>
                                    </div>
                                </div>
                                <div class="dbox w-100 d-flex align-items-center">
                                    <div class="icon d-flex align-items-center justify-content-center">
                                        <span class="fa fa-globe"></span>
                                    </div>
                                    <div class="text pl-3">
                                        <p><a href="#">prosmart.heliospro.ao</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

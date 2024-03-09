<?php
/**
 * Created by PhpStorm.
 * User: Kwanzar Soft
 * Date: 20/07/2020
 * Time: 00:19
 */

include_once("_heliospro/vizew.video.show.inc.php");
?>

<section class="contact-area mb-80">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-7 col-lg-8">
                <div class="section-heading style-2">
                    <h4>Contato</h4>
                    <div class="line"></div>
                </div>

                <div class="contact-form-area mt-50" >
                    <form name="FormSendEmail" method="post" action="#getResult">
                        <div id="getResult"></div>
                        <div class="form-group">
                            <label for="name">Nome*</label>
                            <input type="text" class="form-control" name="RemetenteName" id="RemetenteName">
                        </div>
                        <div class="form-group">
                            <label for="assunto">Assunto*</label>
                            <select name="RemetenteAssunto" id="RemetenteAssunto" class="form-control">
                                <option>Dúvidas</option>
                                <option>Sugestões</option>
                                <option>Erro de funcionalidade</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="email">Email*</label>
                            <input type="email" class="form-control" name="RemetenteEmail" id="RemetenteEmail">
                        </div>
                        <div class="form-group">
                            <label for="message">Mensagem*</label>
                            <textarea class="form-control" name="RemetenteMensagem" id="RemetenteMensagem"></textarea>
                        </div>
                        <button class="btn vizew-btn mt-30 btn-sm" type="submit">Enviar agora</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</section>

<footer class="footer-area">
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="footer-widget mb-70">
                    <h6 class="widget-title">Endereço</h6>
                    <div class="contact-address">
                        <p>Av. dos comandos, casa nº 302 <br>Luanda-Angola</p>
                        <p>Tel.: (+244) 949 482 020 / 914 248 149</p>
                        <p>Email: info@kwanzar.net</p>
                    </div>

                    <div class="footer-social-area">
                        <a href="#" class="facebook"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="instagram"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="twitter"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>


<?php
/**
 * Created by PhpStorm.
 * User: Kwanzar Soft
 * Date: 22/06/2020
 * Time: 11:42
 */

if($level >= 4): $n =  '&id_db_settings='.$id_db_settings; else: $n = null; endif;
?>
<div class="page-inner">
    <div class="welcome">
        <div class="abc">
            <img src="images/logotype.png"/>
        </div>
        <div class="efg">
            <?php $name = explode(" ", $userlogin['name']); ?>
            <p>Bem-vindo ao Kwanzar, <?= $name[0]." ".end($name); ?>.</p>
            <p><strong>Expermente as seguintes funcionalidades.</strong></p>
        </div>

        <div class="row">
            <?php if($level >= 2): ?>
                <div class="col-md-3">
                    <div class="card card-info card-annoucement card-round">
                        <div class="card-body text-center">
                            <div class="card-opening">Adicionar produto</div>
                            <div class="card-desc">
                                Adicione um produto ou serviço do seu negócio/empresa
                            </div>
                            <div class="card-detail">
                                <a href="<?= HOME; ?>panel.php?exe=product/create<?= $n; ?>" class="btn btn-light btn-rounded">Adicionar</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <div class="col-md-3">
                <div class="card card-info card-annoucement card-round">
                    <div class="card-body text-center">
                        <div class="card-opening">Adicionar clientes</div>
                        <div class="card-desc">
                            Crie perfil dos seus clientes ou compradores
                        </div>
                        <div class="card-detail">
                            <a href="<?= HOME; ?>panel.php?exe=customer/index<?= $n; ?>" class="btn btn-light btn-rounded">Adicionar</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card card-info card-annoucement card-round">
                    <div class="card-body text-center">
                        <div class="card-opening">Abrir <?php if($DB->CheckCpanelAndSettings($id_db_settings, $id_db_kwanzar)['atividade'] == 2): ?>PDV<?php else: ?>POS<?php endif; ?></div>
                        <div class="card-desc">
                            Facture na sua empresa/negócio através do ponto de vendas
                        </div>
                        <div class="card-detail">
                            <a href="<?php if($DB->CheckCpanelAndSettings($id_db_settings, $id_db_kwanzar)['atividade'] == 2): ?><?= HOME; ?>Res.php?<?= $n; ?><?php else: ?><?= HOME; ?>Pos.php?<?= $n; ?><?php endif; ?>" class="btn btn-light btn-rounded">Abrir <?php if($DB->CheckCpanelAndSettings($id_db_settings, $id_db_kwanzar)['atividade'] == 2): ?>PDV<?php else: ?>POS<?php endif; ?></a>
                        </div>
                    </div>
                </div>
            </div>
            <?php if($level >= 3): ?>
                <div class="col-md-3">
                    <div class="card card-info card-annoucement card-round">
                        <div class="card-body text-center">
                            <div class="card-opening">Dados da empresa</div>
                            <div class="card-desc">
                                Preencha dados bancários, impostos, etc.
                            </div>
                            <div class="card-detail">
                                <a href="<?= HOME; ?>panel.php?exe=settings/index<?= $n; ?>" class="btn btn-light btn-rounded">Preencher dados</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

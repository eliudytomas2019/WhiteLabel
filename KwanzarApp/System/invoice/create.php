<?php
/**
 * Created by PhpStorm.
 * User: Kwanzar Soft
 * Date: 30/05/2020
 * Time: 16:03
 */

if(!class_exists('login')):
    header("index.php");
    die();
endif;

if($level >= 4): $n =  '&id_db_settings='.$id_db_settings; else: $n = null; endif;
?>

<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">KWANZAR</h4>
        <ul class="breadcrumbs">
            <li class="nav-home">
                <a href="<?= HOME; ?>panel.php?exe=default/home<?= $n; ?>">
                    <i class="flaticon-home"></i>
                </a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="<?= HOME; ?>Pos.php?<?= $n; ?>">Facturação</a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="<?= HOME; ?>panel.php?exe=invoice/create<?= $n; ?>">Relatório de caixa</a>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col col-02">
                            <?php
                            $null = array();
                            $read->ExeRead("db_kwanzar", "WHERE id=:id", "id={$id_db_kwanzar}");
                            if($read->getResult()):
                                $null = $read->getResult()[0];
                            endif;
                            ?>

                            <h6>Data Inicio</h6>
                            <input type="date" id="dateI" class="form-control" placeholder="Data Fnicial"/>
                        </div>
                        <div class="col col-02">
                            <h5>Data Final</h5>
                            <input type="date" id="dateF" class="form-control" placeholder="Data Final"/>
                        </div>

                        <div class="col col-02">
                            <h6>Tipo de documento</h6>
                            <select class="form-control" id="TypeDoc">
                                <option selected value="CO">Documentos comercial</option>
                                <option value="RT">Documentos de retificação</option>
                                <option value="TM">Todos os documentos juntos</option>
                                <optgroup label="Modo especialista">
                                    <option value="FR">Factura-recibo</option>
                                    <option value="FT">Factura</option>
                                    <option value="NC">Nota de credito</option>
                                    <option value="ND">Nota de debito</option>
                                    <option value="RG">Recibo <small>(+atualizado)</small></option>
                                    <option value="RC">Recibo <small>(atualizado)</small></option>
                                    <option value="RE">Recibo <small>(antigo)</small></option>
                                </optgroup>
                            </select>
                        </div>

                        <div class="col col-02">
                            <h6>Origem</h6>
                            <select class="form-control" id="SourceBilling">
                                <option value="P" selected>Documento produzido na aplicação;</option>
                                <option value="M">Documento proveniente de Recuperação ou de emissão manual;</option>
                                <option value="I">Documento proveniente de Integração com outros sistemas;</option>
                                <option value="T">Todas origem juntas;</option>
                            </select>
                        </div>

                        <div class="col col-02">
                            <h6>Cliente</h6>
                            <select class="form-control" id="Customers_id">
                                <option value="all">Todos Clientes </option>
                                <?php
                                $read->ExeRead("cv_customer", "WHERE id_db_settings=:i ORDER BY nome ASC", "i={$id_db_settings}");
                                if($read->getResult()):
                                    foreach($read->getResult() as $key):
                                        extract($key);
                                        ?>
                                        <option value="<?= $key['id']; ?>"><?= $key['nome']; ?></option>
                                        <?php
                                    endforeach;
                                endif;
                                ?>
                            </select>
                        </div>


                        <div class="col col-02">
                            <h6>Operador</h6>
                            <select class="form-control" id="Function_id">
                                <?php if($level >= 3): ?>
                                    <option value="all">Todos Usuários</option>
                                    <?php
                                    $read->ExeRead("db_users", "WHERE id_db_settings=:i ORDER BY name ASC", "i={$id_db_settings}");
                                    if($read->getResult()):
                                        foreach($read->getResult() as $key):
                                            extract($key);
                                            ?>
                                            <option value="<?= $key['id']; ?>"><?= $key['name']; ?></option>
                                            <?php
                                        endforeach;
                                    endif;
                                    ?>
                                <?php else: ?>
                                    <option value="all">Minhas Vendas</option>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>

                    <br/>
                    <a href="javascript:void" onclick="DocumentPdv();" class="btn btn-primary btn-sm">
                        Pesquisar
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive" id="getResult">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
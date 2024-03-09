<?php
/**
 * Created by PhpStorm.
 * User: Kwanzar Soft
 * Date: 15/06/2020
 * Time: 03:46
 */

if(!class_exists('login')):
    header("index.php");
    die();
endif;

if($level >= 4): $n =  '&id_db_settings='.$id_db_settings; else: $n = null; endif;

if($userlogin['level'] < 1):
    header("location: panel.php?exe=default/index".$n);
endif;
?>
<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title"><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Gestão de despesas"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "费用管理"; endif; ?></h4>
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
                <a href="<?= HOME; ?>panel.php?exe=default/home<?= $n; ?>"><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Painel"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "面板"; endif; ?></a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="<?= HOME; ?>panel.php?exe=spending/index<?= $n; ?>"><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Gestão de despesas"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "费用管理"; endif; ?></a>
            </li>
        </ul>
    </div>

    <div class="styles">
        <a href="javascript:void" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#SdSpending">
            Nova despesa
        </a>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="card-title"><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Gestão de despesas"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "费用管理"; endif; ?> de: <?= date('m')."/".date('Y'); ?></div>
        </div>
        <div class="card-body">
            <div class="card-sub">
                para imprimir click em <a href="<?= HOME; ?>print.php?action=05<?= $n; ?>" target="_blank">Imprimir</a>
            </div>
            <div id="Waya"></div>
            <table class="table table-striped mt-3">
                <thead>
                <tr>
                    <th scope="col">Dia</th>
                    <th scope="col"><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Descrição"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo ""; endif; ?></th>
                    <th scope="col"><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Qtd"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "描述"; endif; ?></th>
                    <th scope="col"><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Preço"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "数量"; endif; ?></th>
                    <th scope="col"><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Usuário"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "Usuário"; endif; ?></th>
                    <th scope="col"><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Entrada"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "Entrada"; endif; ?></th>
                    <th scope="col"><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Saída"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "退出 "; endif; ?></th>
                    <th scope="col"><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Investimento"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "投资"; endif; ?></th>
                    <th scope="col">-</th>
                </tr>
                </thead>
                <tbody>
                <?php
                    $m = date('m');
                    $y = date('Y');

                    $t_1 = 0;
                    $t_2 = 0;
                    $t_3 = 0;

                    $read = new Read();
                    $read->ExeRead("sd_spending", "WHERE id_db_settings=:i AND mes=:mm AND ano=:aa ORDER BY id ASC", "i={$id_db_settings}&mm={$m}&aa={$y}");

                    if($read->getResult()):
                        foreach($read->getResult() as $key):
                            extract($key);
                            ?>
                            <tr>
                                <td><?= $key['dia'] ?></td>
                                <td><?= $key['descricao'] ?></td>
                                <td><?= $key['quantidade'] ?></td>
                                <td><?= number_format($key['preco'], 2) ?></td>
                                <td><?php $read->ExeRead("db_users", "WHERE id=:i", "i={$key['session_id']}"); if($read->getResult()): echo $read->getResult()[0]['name']; endif; ?></td>
                                <?php
                                    if($key['natureza'] == "E"):
                                        $t_1 += $key['quantidade'] * $key['preco'];
                                        ?>
                                        <td><?= number_format($key['quantidade'] * $key['preco'], 2); ?></td>
                                        <td></td>
                                        <td></td>
                                        <?php
                                    elseif($key['natureza'] == 'S'):
                                        $t_2 += $key['quantidade'] * $key['preco'];
                                        ?>
                                        <td></td>
                                        <td><?= number_format($key['quantidade'] * $key['preco'], 2); ?></td>
                                        <td></td>
                                        <?php
                                    else:
                                        $t_3 += $key['quantidade'] * $key['preco'];
                                        ?>
                                        <td></td>
                                        <td></td>
                                        <td><?= number_format($key['quantidade'] * $key['preco'], 2); ?></td>
                                        <?php
                                    endif;
                                ?>
                                <td><a href="javascript:void" class="btn btn-danger btn-sm" onclick="DeleteSpending(<?= $key['id']; ?>)">Eliminar</a></td>
                            </tr>
                            <?php
                        endforeach;
                    endif;
                ?>
                </tbody>
                <tfoot>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>TOTAL =></td>
                    <td><?= number_format($t_1, 2); ?></td>
                    <td><?= number_format($t_2, 2); ?></td>
                    <td><?= number_format($t_3, 2); ?></td>
                    <td></td>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>


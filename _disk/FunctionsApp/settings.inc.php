<?php
/**
 * Created by Nucleus, LDA.
 * User: Eliúdy Tomás
 * Date: 08/10/2021
 * Time: 11:54
 */

$acao = strip_tags((filter_input(INPUT_POST, 'acao', FILTER_DEFAULT)));
if($acao):
    require_once("../../Config.inc.php");
    if(isset($_POST['id_db_kwanzar'])): $id_db_kwanzar = (int) $_POST['id_db_kwanzar']; endif;
    if(isset($_POST['id_db_settings'])): $id_db_settings = (int) $_POST['id_db_settings']; endif;
    if(isset($_POST['id_db_settings'])): $n =  '&id_db_settings='.$id_db_settings; else: $n = null;  endif;
    switch ($acao):
        case 'MackbookPro':
            $txt = strip_tags(trim($_POST['txt']));

            $read = new Read();
            $read->ExeRead("p_funcionario", "WHERE (id_db_settings=:i AND bi LIKE '%' :link '%') OR  (id_db_settings=:i AND nome LIKE '%' :link '%')  ORDER BY id DESC LIMIT 10", "i={$id_db_settings}&link={$txt}");
            if($read->getResult()):
                foreach ($read->getResult() as $item):
                    ?>
                    <tr>
                        <td><?= $item['nome']; ?></td>
                        <td><?= $item['sexo']; ?></td>
                        <td><?= $item['bi']; ?></td>
                        <td><?= $item['departamento']; ?></td>
                        <td><?= $item['email']; ?></td>
                        <td><?= $item['telefone']; ?></td>
                        <td><?= $item['endereco']; ?></td>
                        <td>
                            <a href="panel.php?exe=judith=abiudy<?= $n; ?>&postId=<?= $item['id']; ?>"  class="btn btn-sm btn-primary">Histórico</a>
                            <a href="#" class="btn btn-sm btn-warning"  data-bs-toggle="modal" data-bs-target="#ModalDefault" onclick="FuncionarioUpdate(<?= $item['id']; ?>);">Editar</a>&nbsp;
                            <a href="#" onclick="DeleteFuncionario(<?php if(isset($item['id'])) echo $item['id']; ?>)" class="btn btn-sm btn-danger">Apagar</a>&nbsp;
                        </td>
                    </tr>
                <?php
                endforeach;
            endif;

            break;
        case 'DjamilaTomas':
            $txt = strip_tags(trim($_POST['txt']));

            $read = new Read();
            $read->ExeRead("p_local", "WHERE (id_db_settings=:i AND id LIKE '%' :link '%') OR  (id_db_settings=:i AND nome LIKE '%' :link '%')  ORDER BY id DESC LIMIT 10", "i={$id_db_settings}&link={$txt}");
            if($read->getResult()):
                foreach ($read->getResult() as $item):
                    ?>
                    <tr>
                        <td><?= $item['nome']; ?></td>
                        <td><?= $item['escritorio']; ?></td>
                        <td><?= $item['n_patrimonio']; ?></td>
                        <td>
                            <a href="#" class="btn btn-sm btn-warning"  data-bs-toggle="modal" data-bs-target="#ModalDefault" onclick="LocalUpdate(<?= $item['id']; ?>);">Editar</a>&nbsp;
                            <a href="#" onclick="DeleteLocal(<?php if(isset($item['id'])) echo $item['id']; ?>)" class="btn btn-sm btn-danger">Apagar</a>&nbsp;
                        </td>
                    </tr>
                <?php
                endforeach;
            endif;

            break;
        case 'AuriaRafaela':
            $txt = strip_tags(trim($_POST['txt']));

            $read = new Read();
            $read->ExeRead("p_type", "WHERE (id_db_settings=:i AND id LIKE '%' :link '%') OR  (id_db_settings=:i AND nome LIKE '%' :link '%')  ORDER BY id DESC LIMIT 10", "i={$id_db_settings}&link={$txt}");
            if($read->getResult()):
                foreach ($read->getResult() as $item):
                    ?>
                    <tr>
                        <td><?= $item['nome']; ?></td>
                        <td><?= $item['descricao']; ?></td>
                        <td>
                            <a href="#" class="btn btn-sm btn-warning"  data-bs-toggle="modal" data-bs-target="#ModalDefault" onclick="TipoPatrimonioUpdate(<?= $item['id']; ?>);">Editar</a>&nbsp;
                            <a href="#" onclick="DeleteTipoPatrimonio(<?php if(isset($item['id'])) echo $item['id']; ?>)" class="btn btn-sm btn-danger">Apagar</a>&nbsp;
                        </td>
                    </tr>
                <?php
                endforeach;
            endif;

            break;
        case 'PatriciaPalucha':
            $txt = strip_tags(trim($_POST['txt']));

            $read = new Read();
            $read->ExeRead("p_table", "WHERE (id_db_settings=:i AND id LIKE '%' :link '%') OR  (id_db_settings=:i AND nome LIKE '%' :link '%')  ORDER BY id DESC LIMIT 10", "i={$id_db_settings}&link={$txt}");
            if($read->getResult()):
                foreach ($read->getResult() as $item):
                    ?>
                    <tr>
                        <td><?= $item['nome']; ?></td>
                        <td><?= $item['referencia']; ?></td>
                        <td><?= $item['marca']; ?></td>
                        <td><?= $item['modelo']; ?></td>
                        <td><?= $item['time_last']; ?></td>
                        <td>
                            <a href="#" class="btn btn-sm btn-warning"  data-bs-toggle="modal" data-bs-target="#ModalDefault" onclick="PatrimonioUpdate(<?= $item['id']; ?>);">Editar</a>&nbsp;
                            <a href="#" onclick="DeletePatrimonio(<?php if(isset($item['id'])) echo $item['id']; ?>)" class="btn btn-sm btn-danger">Apagar</a>&nbsp;
                        </td>
                    </tr>
                <?php
                endforeach;
            endif;

            break;
        case 'AbiudyTomas':
            $txt = strip_tags(trim($_POST['txt']));
            $Read = new Read();
            $Read->ExeRead("p_atribuicoes", "WHERE (id_db_settings=:i AND id LIKE '%' :link '%') OR  (id_db_settings=:i AND data LIKE '%' :link '%')  ORDER BY id DESC LIMIT 10", "i={$id_db_settings}&link={$txt}");

            if($Read->getResult()):
                foreach ($Read->getResult() as $key):
                    ?>
                    <tr>
                        <td><?= $key['id']; ?></td>
                        <td><?= $key['data']." ".$key['hora']; ?></td>
                        <td><?= "P".$key['id']."/".date('Y'); ?></td>
                        <td>
                            <a href="print.php?&number=19&action=19&id_db_settings=<?= $id_db_settings; ?>&postId=<?= $key['id']; ?>" class="btn btn-default btn-sm" target="_blank">Imprimir</a>
                            <?php
                            if($key['status'] == 1):
                                ?>
                                <a href="#" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#ModalDefault" onclick="EditarAtribuicao(<?= $key['id']; ?>)">Editar</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php
                endforeach;
            endif;

            break;
        case 'EliudyTomasDocs':
            $dateI = strip_tags(trim($_POST['dateI']));
            $dateF = strip_tags(trim($_POST['dateF']));
            ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Plano</th>
                        <th>Saldo</th>
                        <th>Documentos</th>
                        <th>Usuários</th>
                        <th>Empresas</th>
                        <th>Válido até</th>
                        <th>Preço uni.</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if(isset($dateI) && isset($dateF) && !empty($dateI) && !empty($dateF)):
                            $f    = explode("-", $dateF);
                            $i    = explode("-", $dateI);
                        else:
                            $dateF = date('Y-m-d');
                            $dateI = date('Y-m-d');

                            $f    = explode("-", $dateF);
                            $i    = explode("-", $dateI);
                        endif;

                        $sum = null;
                        $Read = new Read();
                        $Read->ExeRead("ws_times_backup", "WHERE dia BETWEEN {$i[2]} AND {$f[2]} AND mes BETWEEN {$i[1]} AND {$f[1]} AND ano BETWEEN {$i[0]} AND {$f[0]} ORDER BY id ASC");
                        if($Read->getResult()):
                            foreach ($Read->getResult() as $key):
                                $sum += $key['total'];
                                ?>
                                <tr>
                                    <td><?= $key['plano']; ?></td>
                                    <td><?= $key['saldo']; ?> dias</td>
                                    <td><?= $key['documentos']; ?></td>
                                    <td><?= $key['users']; ?></td>
                                    <td><?= $key['postos']; ?></td>
                                    <td><?= $key['times']; ?></td>
                                    <td><?= str_replace(",", ".", number_format($key['pricing'], 2)); ?></td>
                                    <td><?= str_replace(",", ".", number_format($key['total'], 2)); ?></td>
                                </tr>
                                <?php
                            endforeach;
                        endif;
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="7">TOTAL =====></th>
                        <th><?= str_replace(",", ".", number_format($sum, 2)); ?> AOA</th>
                    </tr>
                </tfoot>
            </table>
            <?php
            break;
        case 'MoDred':
            $txt = strip_tags(trim($_POST['txt']));

            $Read = new Read();
            $Read->ExeRead("db_settings");
            if($Read->getResult()): $single = $Read->getRowCount(); else: $single = 0; endif;

            $read = new Read();
            $read->ExeRead("db_settings", "WHERE (empresa LIKE '%' :link '%') OR (nif LIKE '%' :link '%') ORDER BY empresa ASC LIMIT 30", "link={$txt}");
            $result = $read->getRowCount();

            echo  $result." de ".$single." empresas";
            break;
        case 'RealNigga':
            $txt = strip_tags(trim($_POST['txt']));

            $Data = ["Ativar", "Suspender", "Suspender"];
            $read = new Read();
            $read->ExeRead("db_settings", "WHERE (empresa LIKE '%' :link '%') OR (nif LIKE '%' :link '%') ORDER BY empresa ASC LIMIT 30", "link={$txt}");
            if($read->getResult()):
                foreach ($read->getResult() as $key):
                    ?>
                    <div class="col-md-6 col-lg-3">
                        <div class="card" style="height: 400px!important;">
                            <div class="card-body p-4 text-center">
                                <span class="avatar avatar-xl mb-3 avatar-rounded"><img style="border-radius: 50%!important;" src="uploads/<?php if($key['logotype'] != null || $key['logotype'] != ''): echo $key['logotype']; else: echo 'logotype.jpg'; endif; ?>"/></span>
                                <a href="Admin.php?exe=statistic/views&postId=<?= $key['id']; ?>"><h3 class="m-0 mb-1"><?= $key['empresa']; ?></h3></a>
                                <div class="mt-3">
                                    <span class="badge bg-purple-lt"><?= $key['nif'] ?></span>
                                </div>
                            </div>
                            <div class="d-flex">
                                <a href="javascript:void()" onclick="Suspanse(<?= $key['id']; ?>)" title="<?php if($key['status'] != null): echo $Data[$key['status']]; else: echo "Suspender"; endif; ?>" class="card-btn"><?= $Data[$key["status"]]; ?></a>
                            </div>
                        </div>
                    </div>
                <?php
                endforeach;
            endif;

            break;
        case 'Settings':
            $id_db_kwanzar = filter_input(INPUT_POST, 'id_db_kwanzar', FILTER_VALIDATE_INT);
            $Data['empresa'] = strip_tags(($_POST['empresa']));
            if(!empty($_POST['nif'])): $Data['nif'] = strip_tags(($_POST['nif']));endif;
            if(!empty($_POST['telefone'])): $Data['telefone'] = strip_tags(($_POST['telefone'])); endif;
            if(!empty($_POST['email'])): $Data['email'] = strip_tags(($_POST['email'])); endif;
            if(!empty($_POST['endereco'])) :$Data['endereco'] = strip_tags(($_POST['endereco']));endif;
            if(!empty($_POST['atividade'])) :$Data['atividade'] = strip_tags(($_POST['atividade']));endif;

            $Create = new DataProcessing();
            $Create->Settings($Data, $id_db_kwanzar);

            if($Create->getResult()):
                WSError($Create->getError()[0], $Create->getError()[1]);
                echo "<script>leva();</script>";
            else:
                WSError($Create->getError()[0], $Create->getError()[1]);
            endif;

            break;
        case 'CreateAccounting':
            $Data['name'] = strip_tags(trim($_POST['name']));
            $Data['username'] = strip_tags(trim($_POST['username']));
            $Data['password'] = strip_tags(trim($_POST['password']));
            $Data['telefone'] = strip_tags(trim($_POST['telefone']));

            $Create = new DataProcessing();
            $Create->CreateNewAccount($Data);
            if($Create->getResult()):
                //WSError($Create->getError()[0], $Create->getError()[1]);
                $Read = new Read();
                $Read->ExeRead("z_config");
                if($Read->getResult()): $Index = $Read->getResult()[0]; else: $Index = null; endif;
                require_once("Mailer.inc.php");

                $Dat = ['user' => $Data['username'], 'pass' => $Data['password']];
                $Login = new Login(1);
                $Login->ExeLogin($Dat);
                if($Login->getResult()):
                    WSError($Create->getError()[0], $Create->getError()[1]);
                    echo "<script>leva();</script>";
                else:
                    WSError($Login->getError()[0], $Login->getError()[1]);
                endif;
            else:
                WSError($Create->getError()[0], $Create->getError()[1]);
            endif;

            break;
        default:
            WSError("Ops: não encontramos a ação desejada!", WS_INFOR);
    endswitch;
endif;

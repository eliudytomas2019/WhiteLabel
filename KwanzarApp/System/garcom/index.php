<?php
/**
 * Created by PhpStorm.
 * User: Kwanzar Soft
 * Date: 16/08/2020
 * Time: 15:04
 */

if(!class_exists('login')):
    header("index.php");
    die();
endif;

if($level >= 4): $n =  '&id_db_settings='.$id_db_settings; else: $n = null; endif;

if($userlogin['level'] < 1):
    header("location: panel.php?exe=default/index".$n);
endif;

include_once("_includes/my-modal-garcom-settings.inc.php");
?>
<div class="row page-titles mx-0">
    <div class="col p-md-0">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= HOME; ?>panel.php?exe=default/home<?php if($level >= 4): echo '&id_db_settings='.$id_db_settings; endif; ?>">Painel de controle</a></li>
            <li class="breadcrumb-item active"><a href="<?= HOME; ?>panel.php?exe=garcom/index<?php if($level >= 4): echo '&id_db_settings='.$id_db_settings; endif; ?>">Gestão de Garçons</a></li>
        </ol>
    </div>
</div>

<div class="container-fluid">
    <div class="styles">
        <a href="" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#garcom">Criar novo garçom</a>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Garçons</h4>
                    <div class="table-responsive">
                        <div id="aPaulo"></div>
                        <table class="table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Nome</th>
                                <th>Telefone</th>
                                <th>Porcentagem</th>
                                <th>-</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $posti = 0;
                            $getPage = filter_input(INPUT_GET, 'page',FILTER_VALIDATE_INT);
                            $Pager = new Pager("panel.php?exe=garcom/index{$n}&page=");
                            $Pager->ExePager($getPage, 30);

                            $read->ExeRead("cv_garcom", "WHERE id_db_settings=:i ORDER BY name ASC LIMIT :limit OFFSET :offset", "i={$id_db_settings}&limit={$Pager->getLimit()}&offset={$Pager->getOffset()}");
                            if($read->getResult()):
                                foreach ($read->getResult() as $key):
                                    extract($key);
                                    ?>
                                    <tr>
                                        <td><?= $key['id']; ?></td>
                                        <td><?= $key['name']; ?></td>
                                        <td><?= $key['telefone']; ?></td>
                                        <td><?= $key['porcentagem']; ?></td>
                                        <td style="width: 200px!important;">
                                            <a href="<?= HOME; ?>panel.php?exe=garcom/update<?= $n; ?>&postid=<?= $id; ?>" title="Editar" class="btn btn-warning btn-sm">Editar</a>
                                            <?php if($_SESSION['userlogin']['level'] >= 3): ?>
                                                <a href="javascript:void()" onclick="DeleteGarcom(<?= $id; ?>)" title="Deletar" class="btn btn-danger btn-sm">Excluir</a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php
                                endforeach;
                            endif;
                            ?>

                            </tbody>
                        </table>

                        <?php
                        $Pager->ExePaginator("cv_garcom");
                        echo $Pager->getPaginator();
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
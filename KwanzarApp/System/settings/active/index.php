<?php
/**
 * Created by PhpStorm.
 * User: Kwanzar Soft
 * Date: 14/10/2020
 * Time: 10:35
 */


if(!class_exists('login')):
    header("index.php");
    die();
endif;

if($level >= 4): $n =  '&id_db_settings='.$id_db_settings; else: $n = null; endif;

if($userlogin['level'] < 3):
    header("location: painel.php?exe=default/index".$n);
endif;

?>
<div class="row page-titles mx-0">
    <div class="col p-md-0">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= HOME; ?>panel.php?exe=default/home<?php if($level >= 4): echo '&id_db_settings='.$id_db_settings; endif; ?>">Painel de controle</a></li>
            <li class="breadcrumb-item active"><a href="<?= HOME; ?>panel.php?exe=settings/active/index<?= $n; ?>">Motivo de documentos de retificação</a></li>
        </ol>
    </div>
</div>


<div class="container-fluid">
    <div class="styles">
        <a href="<?= HOME; ?>panel.php?exe=settings/index<?= $n; ?>" class="btn btn-primary btn-sm"><?php if(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user) == false || DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "1"): echo "Voltar"; elseif(DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['Language'] == "3"): echo "回传"; endif; ?></a>

        <a href="<?= HOME; ?>panel.php?exe=settings/active/create<?= $n; ?>" class="btn btn-primary btn-sm">Criar Nova</a>
    </div>


    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <h4>Motivo de documentos de rectificação</h4>
                    </div>
                </div>
                <div class="card-body">

                    <?php
                        $userId = filter_input(INPUT_GET, 'postId', FILTER_VALIDATE_INT);
                        if($userId):
                            $Delete = new Delete();
                            $Delete->ExeDelete("db_active", "WHERE id=:i", "i={$userId}");

                            if($Delete->getResult() || $Delete->getRowCount()):
                                WSError("Motivo de documentos de rectificação Deletado com sucesso!", WS_ACCEPT);
                            endif;
                        endif;
                    ?>

                    <table class="table mt-3">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Motivo de retificação</th>
                            <th>-</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $read->ExeRead("db_active", "WHERE id_db_settings=:i ORDER BY id ASC ", "i={$id_db_settings}");

                        if($read->getResult()):
                            foreach($read->getResult() as $key):
                                ?>
                                <tr>
                                    <td><?= $key['id']; ?></td>
                                    <td><?= $key['active']; ?></td>
                                    <td>
                                        <a href="<?= HOME; ?>panel.php?exe=settings/active/update<?= $n; ?>&postId=<?= $key['id']; ?>" class="btn btn-sm btn-warning">Editar</a>
                                        <a href="<?= HOME; ?>panel.php?exe=settings/active/index<?= $n; ?>&postId=<?= $key['id']; ?>" class="btn btn-sm btn-danger">Apagar</a>
                                    </td>
                                </tr>
                                <?php
                            endforeach;
                        endif;
                        ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
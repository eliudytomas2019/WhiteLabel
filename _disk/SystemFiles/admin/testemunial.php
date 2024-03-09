<div class="page-header d-print-none">
    <div class="row align-items-center">
        <div class="col">
            <div class="page-pretitle">
                <?= $Index['name']; ?>
            </div>
            <h2 class="page-title">
                Testemunhos
            </h2>
        </div>
    </div>
</div>
<br/>
<div class="col-12">
    <div class="card">
        <?php
            $table = "db_users_commint";
            $Array = ["Aprovar", "Suspender"];

            if(isset($_GET['action'])):
                $postId = filter_input(INPUT_GET, "postId", FILTER_VALIDATE_INT);
                $action = strip_tags(trim($_GET['action']));
                switch ($action):
                    case 'status':
                        $x = strip_tags(trim($_GET['value']));
                        if($x == 1): $Data['status'] = 0; elseif($x == 0): $Data['status'] = 1; endif;

                        $Update = new Update();
                        $Update->ExeUpdate("{$table}", $Data, "WHERE id=:i ", "i={$postId}");

                        if($Update->getResult()):
                            WSError("O testemunho foi <strong>Aprovada</strong>, com sucesso!", WS_INFOR);
                        else:
                            WSError("Ops: aconteceu um erro inesperado ao <strong>{$Array[$Data['status']]}</strong> a publicação!", WS_ERROR);
                        endif;

                        break;
                    case 'delete':
                        $Delete = new Delete();
                        $Delete->ExeDelete($table, "WHERE id=:i ", "i={$postId}");

                        if($Delete->getResult() || $Delete->getRowCount()):
                            $ReadCover = new Read;
                            $ReadCover->FullRead("SELECT cover FROM {$table} WHERE id=:id", "id={$postId}");

                            if($ReadCover->getRowCount()):
                                $delCover = $ReadCover->getResult()[0]['cover'];
                                if(file_exists("./uploads/{$delCover}") && !is_dir("./uploads/{$delCover}")):
                                    unlink("./uploads/{$delCover}");
                                endif;
                            endif;

                            WSError("Publicação deletada com sucesso!", WS_ACCEPT);
                        else:
                            WSError("Ops: aconteceu um erro inesperado ao deletar a publicação!", WS_ERROR);
                        endif;

                        break;
                    default:
                        WSError("Ops: não encontramos a ação selecionada!", WS_ERROR);
                endswitch;
            endif;
        ?>
        <table class="table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Usuário</th>
                <th>Data</th>
                <th>Comentário</th>
                <th>-</th>
            </tr>
            </thead>
            <tbody id="getResult">
            <?php
                $status = 0;
                $Read = new Read();
                $Read->ExeRead("db_users_commint", "WHERE status=:st ORDER BY id DESC LIMIT 6", "st={$status}");

                if($Read->getResult()):
                    foreach ($Read->getResult() as $key):

                        $Read->ExeRead("db_users", "WHERE id=:id ", "id={$key['id_user']}");
                        if($Read->getResult()): $Data = $Read->getResult()[0]; endif;
                        $DataLevel = ["", "Usuário", "Gestor", "Administrador", "CEO", "Desenvolvidor"];
                        ?>
                            <tr>
                                <td><?= $key['id']; ?></td>
                                <td><?= $Data['name'];; ?></td>
                                <td><?= $key['data']; ?></td>
                                <td><?= $key['commint']; ?></td>
                                <td>
                                    <a href="Admin.php?exe=admin/testemunial&action=status&value=<?= $key['status']; ?>&postId=<?= $key['id']; ?>" class="btn btn-sm btn-primary"><?= $Array[$key['status']]; ?></a>
                                    <a href="Admin.php?exe=admin/testemunial&action=delete&postId=<?= $key['id']; ?>" class="btn btn-sm btn-danger">Eliminar</a>
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
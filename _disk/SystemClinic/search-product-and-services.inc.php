<?php
$posti = 0;
$getPage = filter_input(INPUT_GET, 'page',FILTER_VALIDATE_INT);
$Pager = new Pager("panel.php?exe=definitions/index{$n}&page=");
$Pager->ExePager($getPage, 10);

$read = new Read();
$read->ExeRead("cv_product", "WHERE id_db_settings=:id ORDER BY id DESC LIMIT :limit OFFSET :offset", "id={$id_db_settings}&limit={$Pager->getLimit()}&offset={$Pager->getOffset()}");
if($read->getResult()):
    foreach ($read->getResult() as $key):
        //extract($key);

        $promocao = explode("-", $key['data_fim_promocao']);
        if($promocao[0] >= date('Y')):
            if($promocao[1] >= date('m')):
                if($promocao[2] >= date('d')):
                    $preco = $key['preco_promocao'];
                else:
                    $preco = $key['preco_promocao'];
                endif;
            else:
                $preco = $key['preco_promocao'];
            endif;
        elseif($promocao[0] < date('Y')):
            $preco = $key['preco_venda'];
        endif;


        $DB = new DBKwanzar();
        if($DB->CheckCpanelAndSettings($id_db_settings)['atividade'] == 1 || $DB->CheckCpanelAndSettings($id_db_settings)['atividade'] == 4):
            $NnM = $key['quantidade'];
        else:
            $NnM = $key['gQtd'];
        endif;
        ?>
        <tr>
            <td><?= $key['id']; ?></td>
            <td title="<?= $key['product']; ?>"><?= $key['product']; ?></td>
            <td><?= number_format($preco, 2, ",", "."); ?> AOA</td>
            <td>
                <?php
                $Read = new Read();
                $Read->ExeRead("cv_category", "WHERE id=:i ", "i={$key['id_category']}");

                if($Read->getResult()): echo $Read->getResult()[0]['category_title']; endif;
                ?>
            </td>
            <td>
                <a href="panel.php?exe=definitions/update<?= $n; ?>&postid=<?= $key['id']; ?>" title="Editar" class="btn btn-warning btn-sm">Editar</a>
                <a href="javascript:void()" onclick="DeleteProcedimento(<?= $key['id']?>)" title="Eliminar" class="btn btn-danger btn-sm">apagar</a>
            </td>
        </tr>
    <?php
    endforeach;
endif;
?>
<?php
$id_db_settings= strip_tags(trim($_GET['id_db_settings']));
$id_user       = strip_tags(trim($_GET['id_user']));

$moviment_x       = strip_tags(trim($_GET['moviment_x']));
$users_id_x      = strip_tags(trim($_GET['users_id_x']));
$product_x = strip_tags(trim($_GET['product_x']));

$dateI         = strip_tags(trim($_GET['dateI']));
$dateF         = strip_tags(trim($_GET['dateF']));

?>
<h2 style="margin: 10px auto; text-align: center!important;text-transform: uppercase!important;">Relatório dos Materiais Fixos</h2>
<br/><table class="table table-responsive">
    <thead>
    <tr>
        <th>ID</th>
        <th>Material</th>
        <th>T. Movimento</th>
        <th>Quantidade</th>
        <th>Unidades</th>
        <th>Data & Hora</th>
        <th>Operador</th>
    </tr>
    </thead>
    <tbody>
    <?php
    if(!empty($dateI) && !empty($dateF)):
        $i = explode("-", $dateI);
        $f = explode("-", $dateF);

        $data = " AND dia BETWEEN {$i[2]} AND {$f[2]} AND mes BETWEEN {$i[1]} AND {$f[1]} AND ano BETWEEN {$i[0]} AND {$f[0]} ";
    elseif(!empty($dateI) && empty($dateF)):
        $i = explode("-", $dateI);

        $data = " AND dia={$i[2]} AND mes={$i[1]} AND ano={$i[0]} ";
    elseif(!empty($dateF) && empty($dateI)):
        $f = explode("-", $dateF);

        $data = " AND dia={$f[2]} AND mes={$f[1]} AND ano={$f[0]} ";
    else:
        $data = null;
    endif;

    if(!empty($moviment_x)):
        $mov = " AND movimento='{$moviment_x}' ";
    else:
        $mov = null;
    endif;

    if(!empty($product_x) && $product_x != "all"):
        $xV = " AND id_product={$product_x} ";
    else:
        $xV = null;
    endif;

    if(!empty($users_id_x) && $users_id_x != "all"):
        $us = " AND id_user={$users_id_x} ";
    else:
        $us = null;
    endif;

    $Where = "WHERE id_db_settings={$id_db_settings} {$data} {$mov} {$xV} {$us} ";


    $Read = new Read();
    $Read->ExeRead("cv_clinic_product_stock", $Where);

    if($Read->getResult()):
        foreach ($Read->getResult() as $key):
            ?>
            <tr>
                <td><?= $key['id']; ?></td>
                <td><?php $Read->ExeRead("cv_clinic_product", "WHERE id=:i ", "i={$key['id_product']}"); if($Read->getResult()): echo $Read->getResult()[0]['name']; endif; ?></td>
                <td><?= $key['movimento']; ?></td>
                <td><?= $key['qtd']; ?></td>
                <td><?php $Read->ExeRead("cv_clinic_product", "WHERE id=:i ", "i={$key['id_product']}"); if($Read->getResult()): echo $Read->getResult()[0]['unidades']; endif; ?></td>
                <td><?= $key['data']." ".$key['hora']; ?></td>
                <td><?php $Read->ExeRead("db_users", "WHERE id=:i ", "i={$key['id_user']}"); if($Read->getResult()): echo $Read->getResult()[0]['name']; endif; ?></td>
            </tr>
        <?php
        endforeach;
    endif;
    ?>
    </tbody>
</table>
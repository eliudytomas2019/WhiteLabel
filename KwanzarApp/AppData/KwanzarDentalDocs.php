<?php
require_once("../../Config.inc.php");

$id_db_settings= strip_tags(trim($_POST['id_db_settings']));
$id_user       = strip_tags(trim($_POST['id_user']));

$moviment_x       = strip_tags(trim($_POST['moviment_x']));
$users_id_x      = strip_tags(trim($_POST['users_id_x']));
$product_x = strip_tags(trim($_POST['product_x']));

$dateI         = strip_tags(trim($_POST['dateI']));
$dateF         = strip_tags(trim($_POST['dateF']));

?>
<hr/>
<br/><div class="styles">
    <a href="print_dental.php?action=2005&dateI=<?= $dateI; ?>&dateF=<?= $dateF; ?>&id_user=<?= $id_user ?>&id_db_settings=<?= $id_db_settings; ?>&moviment_x=<?= $moviment_x; ?>&users_id_x=<?= $users_id_x; ?>&product_x=<?= $product_x; ?>" class="bol bol-default bol-sm btn btn-primary btn-sm" target="_blank">Imprimir</a>
</div>
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
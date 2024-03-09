<?php
/**
 * Created by PhpStorm.
 * User: Kwanzar Soft
 * Date: 13/06/2020
 * Time: 23:06
 */

$Counting01   = [];
$Counting01_1 = [];

$Counting02   = [];
$Counting02_2 = [];

$Counting03   = [];
$Counting03_3 = [];

$pp1 = "db_static_sales_customer";
$pp2 = "db_static_db_settings_product";
$pp3 = "db_static_sales_db_users";

$read = new Read();
$read->ExeRead("{$pp1}", "WHERE id_db_settings=:i ORDER BY counting DESC LIMIT 5", "i={$id_db_settings}");

if($read->getResult()):
    foreach($read->getResult() as $key):
        $Counting01[] += $key['counting'];

        $read->ExeRead("cv_customer", "WHERE id=:i", "i={$key['id_cv_customer']}");
        if($read->getResult()):
            $Counting01_1[] .= $read->getResult()[0]['nome'];
        endif;
    endforeach;
endif;

$read = new Read();
$read->ExeRead("{$pp2}", "WHERE id_db_settings=:i ORDER BY counting DESC LIMIT 5", "i={$id_db_settings}");

if($read->getResult()):
    foreach($read->getResult() as $key):
        $Counting02[] += $key['counting'];

        $read->ExeRead("cv_product", "WHERE id=:i", "i={$key['id_cv_product']}");
        if($read->getResult()):
            $Counting02_2[] .= substr($read->getResult()[0]['product'], 0, 12);
        endif;
    endforeach;
endif;

$read = new Read();
$read->ExeRead("{$pp3}", "WHERE id_db_settings=:i ORDER BY counting DESC LIMIT 5", "i={$id_db_settings}");

if($read->getResult()):
    foreach($read->getResult() as $key):
        $Counting03[] += $key['counting'];

        $read->ExeRead("db_users", "WHERE id=:i", "i={$key['id_db_users']}");
        if($read->getResult()):
            $Counting03_3[] .= substr($read->getResult()[0]['name'], 0, 15);
        endif;
    endforeach;
endif;
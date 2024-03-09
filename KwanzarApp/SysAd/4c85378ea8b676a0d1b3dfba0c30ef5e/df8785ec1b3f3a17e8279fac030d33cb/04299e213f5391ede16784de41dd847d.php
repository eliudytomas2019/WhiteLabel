<?php
/**
 * Created by PhpStorm.
 * User: Kwanzar Soft
 * Date: 03/09/2020
 * Time: 23:32
 */

if(!class_exists('login')):
    header("index.php");
    die();
endif;

$System = new Read();

require_once("_adm/100-settings-admin-level-4.inc.php");
echo "<br/>";
require_once("_adm/02-settings-admin-level-4.inc.php");
require_once("_adm/03-settings-admin-level-4.inc.php");
?>
<input type="hidden" value="<?= $level?>" id="level" name="level"/>
<?php
/**
 * Created by PhpStorm.
 * User: Kwanzar Soft
 * Date: 06/06/2020
 * Time: 12:56
 */

if(!class_exists('login')):
    header("index.php");
    die();
endif;


if($userlogin['level'] <= 4):
    header("location: panel.php?exe=default/index".$n);
endif;

$System = new Read();

require_once("_adm/00-settings-admin-level-4.inc.php");
require_once("_adm/00-0-1-settings-admin-level-4.inc.php");
require_once("_adm/00-1-settings-admin-level-4.inc.php");
//require_once("../../../_adm/01-settings-admin-level-4.inc.php");
require_once("_adm/01-1-settings-admin-level-4.inc.php");
//require_once("_adm/02-settings-admin-level-4.inc.php");
//require_once("_adm/03-settings-admin-level-4.inc.php");
//require_once("../../../_adm/04-settings-admin-level-4.inc.php");
require_once("_adm/05-settings-admin-level-4.inc.php");
?>
<input type="hidden" value="<?= $level?>" id="level" name="level"/>

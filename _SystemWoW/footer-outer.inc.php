<?php
/**
 * Created by PhpStorm.
 * User: Kwanzar Soft
 * Date: 04/06/2020
 * Time: 22:36
 */
?>
<footer class="fac-footer">
    <p>Processado por programa validado nº <?= $Index['agt']; ?><?php if($Index["iso"] != null || $Index["iso"] != ""): echo "/ ".$Index["iso"]; endif; ?> &copy; <?= $Index['name']; ?> - <?= $Index['versao']; ?>.</p>
</footer>
<?php
/**
 * Created by PhpStorm.
 * User: Kwanzar Soft
 * Date: 31/05/2020
 * Time: 23:19
 */
?>
<footer class="fac-footer">
    <p>Processado por programa validado n.º <?= $Index['agt']; ?><?php if($Index["iso"] != null || $Index["iso"] != ""): endif; ?>  &copy; <?= $Index['name']; ?> <?= $Index['versao']; ?>.</p>
</footer>

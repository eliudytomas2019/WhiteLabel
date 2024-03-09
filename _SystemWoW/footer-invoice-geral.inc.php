<?php
/**
 * Created by PhpStorm.
 * User: Kwanzar Soft
 * Date: 31/05/2020
 * Time: 23:19
 */
?>
<footer class="fac-footer">
    <?php /*echo $AGT['hash'];*/ if(!empty($k['hash'])): $a = str_split($k['hash']); endif; //var_dump($a); ?>
    <p class="jud"><?php if(isset($a)): echo $a[0].$a[11].$a[21].$a[31]." - ";  endif; ?> Processado por programa validado nº <?= $Index['agt']; ?><?php if($Index["iso"] != null || $Index["iso"] != ""): echo "/ ".$Index["iso"]; endif; ?>  &copy; <?= $Index['name']; ?>  <?= $Index['versao']; ?>.</p>
</footer>

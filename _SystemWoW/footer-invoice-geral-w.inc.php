




<footer class="fac-footer">
    <?php /*echo $AGT['hash'];*/ if(!empty($k['hash'])): $a = str_split($k['hash']); endif; //var_dump($a); ?>
    <p class="jud" style="font-size: 8pt!important;"><?php if(isset($a)): echo $a[0].$a[11].$a[21].$a[31]." - ";  endif; ?> Processado por programa validado n.º <?= $Index['agt']; ?><?php if($Index["iso"] != null || $Index["iso"] != ""): endif; ?>  &copy; <?= $Index['name']; ?> <?= $Index['versao']; ?>.</p>
</footer>

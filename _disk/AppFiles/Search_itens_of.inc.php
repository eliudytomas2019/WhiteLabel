<?php
if($Read->getResult()):
    foreach ($Read->getResult() as $item):
        ?>
        <tr>
            <td><small><?= $item['product']; ?></small></td>
            <td><input type="text" id="quantidade_<?= $item['id']; ?>" value="1" min="1" placeholder="" class="form-control"/></td>
            <td><a href="javascript:void()" onclick="adicionarII(<?= $item['id']; ?>)" class="btn btn-success">+</a></td>
        </tr>
    <?php
    endforeach;
endif;
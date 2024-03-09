<?php

if($read->getResult()):
    foreach($read->getResult() as $key):
        if($key['ILoja'] == null || $key['ILoja'] == '' || $key['ILoja'] != 1):
            ?>
            <div class="col-2 col-sm-2 text-center" style="width: 133px!important;height: 133px!important;margin: 30px auto!important;">
                <label class="form-imagecheck mb-2">
                    <a href="javascript:void()" onclick="AdicionarPDV(<?= $key['id']; ?>)"><input name="form-imagecheck" type="checkbox" value="1" class="form-imagecheck-input" /></a>
                    <a href="javascript:void()" onclick="AdicionarPDV(<?= $key['id']; ?>)"><span class="form-imagecheck-figure mb-1">
                      <img src="uploads/<?php if($key["cover"] == null || !isset($key["cover"])): echo 'default.jpg'; else: echo $key["cover"]; endif; ?>" alt="<?= $key['product']; ?>" class="form-imagecheck-image">
                        </span></a>
                    <a href="javascript:void()" onclick="AdicionarPDV(<?= $key['id']; ?>)"><span><strong><?= Check::Words($key['product'], 4); ?></strong></span></a>
                </label>
            </div>
            <!---li class="col-1 col-sm-1 text-center all-itens">
                <a href="javascript:void()" onclick="AdicionarPDV(<?= $key['id']; ?>)">
                    <label class="form-imagecheck mb-2">
                        <span class="form-imagecheck-figure mb-1">
                          <img src="uploads/<?php if($key["cover"] == null || !isset($key["cover"])): echo 'default.jpg'; else: echo $key["cover"]; endif; ?>" class="form-imagecheck-image">
                        </span>
                        <span><strong><?= Check::Words($key['product'], 4); ?></strong></span>
                    </label>
                </a>
            </li--->
        <?php
        endif;
    endforeach;
endif;
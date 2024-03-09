<?php
if(!class_exists('login')):
    header("index.php");
    die();
endif;

if($level >= 4): $n =  '&id_db_settings='.$id_db_settings; else: $n = null; endif;

if($userlogin['level'] < 1):
    header("location: panel.php?exe=default/index".$n);
endif;
?>
<div class="page-header d-print-none">
    <div class="row align-items-center">

        <div class="col-auto ms-auto d-print-none">
            <div class="btn-list">
                <a href="panel.php?exe=product/index<?= $n; ?>" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 13l-4 -4l4 -4m-4 4h11a4 4 0 0 1 0 8h-1" /></svg>
                    Voltar
                </a>
            </div>
        </div>
        <div class="col">
            <div class="page-pretitle">
                <?= $Index['name']; ?>
            </div>
            <h2 class="page-title">
                Itens
            </h2>
        </div>
    </div>
</div><br/>

<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Itens Apenas em Stock</h3>&nbsp;&nbsp;&nbsp;
        </div>
        <div id="aPaulo"></div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th>Imagem</th>
                    <th>Descrição</th>
                    <td>Qtd/Loja</td>
                    <th>Qtd/Stock</th>
                    <th>Preço de venda</th>
                    <th>-</th>
                </tr>
                </thead>
                <tbody id="getResult">
                <?php
                $is = 1;

                $posti = 0;
                $getPage = filter_input(INPUT_GET, 'page',FILTER_VALIDATE_INT);
                $Pager = new Pager("panel.php?exe=product/index_stock{$n}&page=");
                $Pager->ExePager($getPage, 10);

                $read->ExeRead("cv_product", "WHERE id_db_settings=:id AND ILoja=:is ORDER BY id DESC LIMIT :limit OFFSET :offset", "id={$id_db_settings}&is={$is}&limit={$Pager->getLimit()}&offset={$Pager->getOffset()}");
                if($read->getResult()):
                    foreach ($read->getResult() as $key):
                        //extract($key);

                        $promocao = explode("-", $key['data_fim_promocao']);
                        if($promocao[0] >= date('Y')):
                            if($promocao[1] >= date('m')):
                                if($promocao[2] >= date('d')):
                                    $preco = $key['preco_promocao'];
                                else:
                                    $preco = $key['preco_promocao'];
                                endif;
                            else:
                                $preco = $key['preco_promocao'];
                            endif;
                        elseif($promocao[0] < date('Y')):
                            $preco = $key['preco_venda'];
                        endif;


                        $DB = new DBKwanzar();
                        if($DB->CheckCpanelAndSettings($id_db_settings)['atividade'] == 1 || $DB->CheckCpanelAndSettings($id_db_settings)['atividade'] == 4):
                            $NnM = $key['quantidade'];
                        else:
                            $NnM = $key['gQtd'];
                        endif;
                        ?>
                        <tr>
                            <td><img style="width: 40px!important;height: 40px!important;border-radius: 50%!important;" src="./uploads/<?php if($key['cover'] != ''): echo $key['cover']; else: echo 'default.jpg'; endif;  ?>"</td>
                            <td title="<?= $key['product']; ?>"><?= $key['product']; ?></td>
                            <td><?= number_format($NnM, 2); ?></td>
                            <td><?= number_format($key["quantidade"], 2); ?></td>
                            <td><?= number_format($preco, 2); ?> AOA</td>
                            <td>
                                <a href="panel.php?exe=product/product-promotions<?= $n; ?>&postid=<?= $key['id']; ?>" class="btn btn-default btn-sm" title="Preço promocional">Preço promocional</a>
                                <?php if($key['IE_commerce'] == 2): ?><a href="<?= HOME; ?>panel.php?exe=product/gallery<?= $n; ?>&postid=<?= $key['id']; ?>" class="btn btn-sm btn-primary">Galeria</a><?php endif; ?>
                                <a href="panel.php?exe=product/update<?= $n; ?>&postid=<?= $key['id']; ?>" title="Editar" class="btn btn-warning btn-sm">Editar</a>
                                <a href="javascript:void()" onclick="DeleteProduct(<?= $key['id']?>)" title="Eliminar" class="btn btn-danger btn-sm">eliminar</a>
                            </td>
                        </tr>
                    <?php
                    endforeach;
                endif;
                ?>
                </tbody>
            </table>
        </div>
        <div class="card-footer d-flex align-items-center">
            <?php
            $Pager->ExePaginator("cv_product", "WHERE id_db_settings=:id AND ILoja=:is ORDER BY id DESC", "id={$id_db_settings}&is={$is}");
            echo $Pager->getPaginator();
            ?>
        </div>
    </div>
</div>
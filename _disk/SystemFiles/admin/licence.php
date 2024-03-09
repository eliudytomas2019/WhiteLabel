<?php
if(!class_exists('login')):
    header("index.php");
    die();
endif;

$id_db_k = (int) strip_tags(trim($_GET['id_db_']));

$System = new Read();
?>
<div class="page-header d-print-none">
    <div class="row align-items-center">

        <div class="col-auto ms-auto d-print-none">
            <div class="btn-list">
                <a href="Admin.php?exe=admin/empresa" class="btn btn-primary d-none d-sm-inline-block">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 13l-4 -4l4 -4m-4 4h11a4 4 0 0 1 0 8h-1" /></svg>
                    Voltar
                </a>
            </div>
        </div>
        <div class="col">
            <div class="page-pretitle">
                Kwanzar
            </div>
            <h2 class="page-title">
                Administrador
            </h2>
        </div>
    </div>
</div>

<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Ativação de licença</h3>
        </div>
        <div class="card-body">
            <div id="getResult"></div>
            <form>
                <div class="form-group mb-3 ">
                    <label class="form-label">Válido até</label>
                    <div>
                        <input type="date" name="times" id="times" class="form-control" placeholder="">
                    </div>
                </div>

                <div class="form-group mb-3 ">
                    <label class="form-label">Plano</label>
                    <div>
                        <select name="ps3" id="ps3" class="form-control">
                            <?php
                                $Read = new Read();
                                $Read->ExeRead("z_security", "ORDER BY id ASC");

                                if($Read->getResult()):
                                    foreach ($Read->getResult() as $key):
                                        ?>
                                        <option value="<?= $key['id']; ?>"><?php echo "{$key['plano']} - ({$key['usuarios']} usuários, {$key['empresas']} empresas, {$key['documentos']} documentos) - ".str_replace(",", ".", number_format($key['valor'], 2))."/mês"; ?></option>
                                        <?php
                                    endforeach;
                                endif;
                            ?>
                        </select>
                    </div>
                </div>

                <div class="form-footer">
                    <a href="javascript:void" onclick="Licenca(<?= $id_db_k; ?>)" class="btn btn-primary">Salvar</a>
                </div>
            </form>
        </div>
    </div>
</div>
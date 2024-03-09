<div class="page-header d-print-none">
    <div class="row align-items-center">
        <div class="col">
            <div class="page-pretitle">
                <?= $Index['name']; ?>
            </div>
            <h2 class="page-title">
                Segurança e Licença
            </h2>
        </div>
        <div class="col-auto ms-auto d-print-none">
            <div class="btn-list">
                <a href="Admin.php?exe=admin/security_create" class="btn btn-primary d-none d-sm-inline-block">
                    Criar novo Plano
                </a>
            </div>
        </div>
    </div>
</div>
<br/>
<div class="col-12">
    <div class="card">
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th>Plano</th>
                    <th>Documentos</th>
                    <th>Usuários</th>
                    <th>Modulos</th>
                    <th>Empresas</th>
                    <th>Valor</th>
                    <th>-</th>
                </tr>
                </thead>
                <tbody id="getResult">
                    <?php
                        $Read = new Read();
                        $Read->ExeRead("z_security", "ORDER BY id ASC");

                        if($Read->getResult()):
                            foreach ($Read->getResult() as $key):
                                ?>
                                <tr>
                                    <td><?= $key['plano']; ?></td>
                                    <td><?= $key['documentos']; ?></td>
                                    <td><?= $key['usuarios']; ?></td>
                                    <td><?= $key['modulos']; ?></td>
                                    <td><?= $key['empresas']; ?></td>
                                    <td><?= str_replace(",", ".", number_format($key['valor'], 2)); ?></td>
                                    <td><a href="Admin.php?exe=admin/security_update&id=<?= $key['id']; ?>" class="btn btn-sm btn-warning">Editar</a></td>
                                </tr>
                                <?php
                            endforeach;
                        endif;
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
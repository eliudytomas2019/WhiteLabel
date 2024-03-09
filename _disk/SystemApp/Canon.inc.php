<?php
$acao = strip_tags((filter_input(INPUT_POST, 'acao', FILTER_DEFAULT)));
if ($acao):
    require_once("../../Config.inc.php");
    if (isset($_POST['level'])): $level = strip_tags(trim($_POST['level'])); endif;
    if (isset($_POST['id_user'])): $id_user = strip_tags(trim($_POST['id_user'])); endif;
    if (isset($_POST['id_db_settings'])): $id_db_settings = (int) $_POST['id_db_settings']; endif;
    if (isset($_POST['postId'])): $postId = strip_tags(trim($_POST['postId'])); endif;
    $n =  '&id_db_settings='.$id_db_settings;

    switch ($acao):
        case 'StatusAtribuicao':
            $data['status'] = strip_tags(trim($_POST['status']));

            $DB = new Belma();
            $DB->OperacaoPatrimonialSatus($data, $id_db_settings, $postId);

            if($DB->getResult()):
                WSError($DB->getError()[0], $DB->getError()[1]);
            else:
                WSError($DB->getError()[0], $DB->getError()[1]);
            endif;

            break;
        case 'EditarAtribuicao':
            ?>
            <div class="modal-header">
                <h5 class="modal-title">Atribuição de Meios</h5>
                <a href="#" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></a>
            </div>
            <div class="getResult"></div>
            <div class="modal-body">
                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <div class="form-group">
                            <label>Status da Atribuição</label>
                            <select name="status" id="status" class="form-control">
                                <option value="0">Remover Atribuição</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-md-8 mb-3">

                    </div>
                    <div class="col-md-4 mb-3">
                        <button type="submit" class="btn btn-primary" onclick="StatusAtribuicao(<?= $postId; ?>)">Salvar</button>
                    </div>
                </div>
                <div class="form-row mb-3 float-right">

                </div>
            </div>
            <?php
            break;
        case 'ReadHistoricoAtribuicoes':
            $Read = new Read();
            $Read->ExeRead("p_atribuicoes", "WHERE id_db_settings=:i ORDER BY id DESC LIMIT 10", "i={$id_db_settings}");

            if($Read->getResult()):
                foreach ($Read->getResult() as $key):
                    ?>
                    <tr>
                        <td><?= $key['id']; ?></td>
                        <td><?= $key['data']." ".$key['hora']; ?></td>
                        <td><?= "P".$key['id']."/".date('Y'); ?></td>
                        <td>
                            <a href="print.php?&number=19&action=19&id_db_settings=<?= $id_db_settings; ?>&postId=<?= $key['id']; ?>" class="btn btn-default btn-sm" target="_blank">Imprimir</a>
                            <?php
                                if($key['status'] == 1):
                                ?>
                            <a href="#" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#ModalDefault" onclick="EditarAtribuicao(<?= $key['id']; ?>)">Editar</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php
                endforeach;
            endif;

            break;
        case 'OperacaoPatrimonial':
            $data['id_table'] = (int) strip_tags(trim($_POST['id_table']));
            $data['id_local'] = (int) strip_tags(trim($_POST['id_local']));
            $data['id_funcionario'] = (int) strip_tags(trim($_POST['id_funcionario']));
            $data['descricao'] = strip_tags(trim($_POST['descricao']));

            $DB = new Belma();
            $DB->OperacaoPatrimonial($data, $id_db_settings, $id_user);

            if($DB->getResult()):
                WSError($DB->getError()[0], $DB->getError()[1]);
            else:
                WSError($DB->getError()[0], $DB->getError()[1]);
            endif;

            break;
        case 'Funcionario':
            ?>
            <div class="modal-header">
                <h5 class="modal-title">Registro de Funcionário</h5>
                <a href="#" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></a>
            </div>
            <div class="getResult"></div>
            <div class="modal-body">
                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <div class="form-group">
                            <label>Nome</label>
                            <input type="text" value="<?php if(isset($ClienteData['nome'])) echo $ClienteData['nome']; ?>" class="form-control" id="nome" placeholder="Nome"/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label>Sexo</label>
                            <select class="form-control" name="sexo" id="sexo">
                                <option value="masculino">Masculino</option>
                                <option value="femenino">Femenino</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label>B.I</label>
                            <input type="text" value="<?php if(isset($ClienteData['bi'])) echo $ClienteData['bi']; ?>" class="form-control" id="bi" placeholder="B.I"/>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label>Departamento</label>
                            <input type="text" value="<?php if(isset($ClienteData['departamento'])) echo $ClienteData['departamento']; ?>" class="form-control" id="departamento" placeholder="Departamento"/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label>Telefone</label><br/>
                            <input type="text" value="<?php if(isset($ClienteData['telefone'])) echo $ClienteData['telefone']; ?>" class="form-control" id="telefone" placeholder="Telefone"/>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label>E-mail</label>
                            <input type="text" value="<?php if(isset($ClienteData['email'])) echo $ClienteData['email']; ?>" class="form-control" id="email" placeholder="E-mail"/>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label>Endereço</label>
                            <input type="text" value="<?php if(isset($ClienteData['endereco'])) echo $ClienteData['endereco']; ?>" class="form-control" id="endereco" placeholder="Endereço"/>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-8 mb-3">

                    </div>
                    <div class="col-md-4 mb-3">
                        <button type="submit" class="btn btn-primary" onclick="SalvarFuncionario(<?= $id_db_settings; ?>)">Salvar</button>
                    </div>
                </div>
                <div class="form-row mb-3 float-right">

                </div>
            </div>
            <?php
            break;
        case 'SalvarFuncionario':
            $data['nome'] = strip_tags(trim($_POST['nome']));
            $data['departamento'] = strip_tags(trim($_POST['departamento']));
            $data['telefone'] = strip_tags(trim($_POST['telefone']));
            $data['email'] = strip_tags(trim($_POST['email']));
            $data['endereco'] = strip_tags(trim($_POST['endereco']));
            $data['sexo'] = strip_tags(trim($_POST['sexo']));
            $data['bi'] = strip_tags(trim($_POST['bi']));

            $DB = new Belma();
            $DB->Funcionario($data, $id_db_settings);

            if($DB->getResult()):
                WSError($DB->getError()[0], $DB->getError()[1]);
            else:
                WSError($DB->getError()[0], $DB->getError()[1]);
            endif;

            break;
        case 'FuncionarioUpdate':
            $Read = new Read();
            $Read->ExeRead("p_funcionario", "WHERE id=:i AND id_db_settings=:y", "i={$postId}&y={$id_db_settings}");

            if($Read->getResult()):
                $ClienteData = $Read->getResult()[0];
            endif;
            ?>
            <div class="modal-header">
                <h5 class="modal-title">Atualizar Ficha de Funcionário</h5>
                <a href="#" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></a>
            </div>
            <div class="getResult"></div>
            <div class="modal-body">
                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <div class="form-group">
                            <label>Nome</label>
                            <input type="text" value="<?php if(isset($ClienteData['nome'])) echo $ClienteData['nome']; ?>" class="form-control" id="nome" placeholder="Nome"/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label>Sexo</label>
                            <select class="form-control" name="sexo" id="sexo">
                                <option value="masculino">Masculino</option>
                                <option value="femenino">Femenino</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label>B.I</label>
                            <input type="text" value="<?php if(isset($ClienteData['bi'])) echo $ClienteData['bi']; ?>" class="form-control" id="bi" placeholder="B.I"/>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label>Departamento</label>
                            <input type="text" value="<?php if(isset($ClienteData['departamento'])) echo $ClienteData['departamento']; ?>" class="form-control" id="departamento" placeholder="Departamento"/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label>Telefone</label><br/>
                            <input type="text" value="<?php if(isset($ClienteData['telefone'])) echo $ClienteData['telefone']; ?>" class="form-control" id="telefone" placeholder="Telefone"/>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label>E-mail</label>
                            <input type="text" value="<?php if(isset($ClienteData['email'])) echo $ClienteData['email']; ?>" class="form-control" id="email" placeholder="E-mail"/>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label>Endereço</label>
                            <input type="text" value="<?php if(isset($ClienteData['endereco'])) echo $ClienteData['endereco']; ?>" class="form-control" id="endereco" placeholder="Endereço"/>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-8 mb-3">

                    </div>
                    <div class="col-md-4 mb-3">
                        <button type="submit" class="btn btn-primary" onclick="UpdateFuncionario(<?= $postId; ?>)">Salvar</button>
                    </div>
                </div>
                <div class="form-row mb-3 float-right">

                </div>
            </div>
            <?php
            break;
        case 'UpdateFuncionario':
            $data['nome'] = strip_tags(trim($_POST['nome']));
            $data['departamento'] = strip_tags(trim($_POST['departamento']));
            $data['telefone'] = strip_tags(trim($_POST['telefone']));
            $data['email'] = strip_tags(trim($_POST['email']));
            $data['endereco'] = strip_tags(trim($_POST['endereco']));
            $data['sexo'] = strip_tags(trim($_POST['sexo']));
            $data['bi'] = strip_tags(trim($_POST['bi']));

            $DB = new Belma();
            $DB->UpdateFuncionario($data, $id_db_settings, $postId);

            if($DB->getResult()):
                WSError($DB->getError()[0], $DB->getError()[1]);
            else:
                WSError($DB->getError()[0], $DB->getError()[1]);
            endif;

            break;
        case 'ReadFuncionario':
            $read = new Read();
            $read->ExeRead("p_funcionario", "WHERE id_db_settings=:id ORDER BY id DESC", "id={$id_db_settings}");
            if($read->getResult()):
                foreach ($read->getResult() as $item):
                    ?>
                    <tr>
                        <td><?= $item['nome']; ?></td>
                        <td><?= $item['sexo']; ?></td>
                        <td><?= $item['bi']; ?></td>
                        <td><?= $item['departamento']; ?></td>
                        <td><?= $item['email']; ?></td>
                        <td><?= $item['telefone']; ?></td>
                        <td><?= $item['endereco']; ?></td>
                        <td>
                            <a href="panel.php?exe=judith=abiudy<?= $n; ?>&postId=<?= $item['id']; ?>"  class="btn btn-sm btn-primary">Histórico</a>
                            <a href="#" class="btn btn-sm btn-warning"  data-bs-toggle="modal" data-bs-target="#ModalDefault" onclick="FuncionarioUpdate(<?= $item['id']; ?>);">Editar</a>&nbsp;
                            <a href="#" onclick="DeleteFuncionario(<?php if(isset($item['id'])) echo $item['id']; ?>)" class="btn btn-sm btn-danger">Apagar</a>&nbsp;
                        </td>
                    </tr>
                <?php
                endforeach;
            endif;

            break;
        case 'DeleteFuncionario':
            $DB = new Belma();
            $DB->DeleteFuncionario($postId);
            WSError($DB->getError()[0], $DB->getError()[1]);
            break;
        case 'LocalUpdate':
            $Read = new Read();
            $Read->ExeRead("p_local", "WHERE id=:i AND id_db_settings=:y", "i={$postId}&y={$id_db_settings}");

            if($Read->getResult()):
                $ClienteData = $Read->getResult()[0];
            endif;
            ?>
            <div class="modal-header">
                <h5 class="modal-title">Atualizar Local de Armazenamento</h5>
                <a href="#" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></a>
            </div>
            <div class="getResult"></div>
            <div class="modal-body">
                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <div class="form-group">
                            <label>Área</label>
                            <input type="text" value="<?php if(isset($ClienteData['nome'])) echo $ClienteData['nome']; ?>" class="form-control" id="nome" placeholder="Área"/>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <div class="form-group">
                            <label>Local</label>
                            <input type="text" value="<?php if(isset($ClienteData['escritorio'])) echo $ClienteData['escritorio']; ?>" class="form-control" id="escritorio" placeholder="Local"/>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-8 mb-3">

                    </div>
                    <div class="col-md-4 mb-3">
                        <button type="submit" class="btn btn-primary" onclick="UpdateLocal(<?= $postId; ?>)">Salvar</button>
                    </div>
                </div>
                <div class="form-row mb-3 float-right">

                </div>
            </div>
            <?php
            break;
        case 'ReadLocal':
            $read = new Read();
            $read->ExeRead("p_local", "WHERE id_db_settings=:id ORDER BY id DESC ", "id={$id_db_settings}");
            if($read->getResult()):
                foreach ($read->getResult() as $item):
                    ?>
                    <tr>
                        <td><?= $item['nome']; ?></td>
                        <td><?= $item['escritorio']; ?></td>
                        <td><?= $item['n_patrimonio']; ?></td>
                        <td>
                            <a href="#" class="btn btn-sm btn-warning"  data-bs-toggle="modal" data-bs-target="#ModalDefault" onclick="LocalUpdate(<?= $item['id']; ?>);">Editar</a>&nbsp;
                            <a href="#" onclick="DeleteLocal(<?php if(isset($item['id'])) echo $item['id']; ?>)" class="btn btn-sm btn-danger">Apagar</a>&nbsp;
                        </td>
                    </tr>
                <?php
                endforeach;
            endif;

            break;
        case 'DeleteLocal':
            $DB = new Belma();
            $DB->DeleteTipoPatrimonio($postId);
            WSError($DB->getError()[0], $DB->getError()[1]);
            break;
        case 'UpdateLocal':
            $data['nome'] = strip_tags(trim($_POST['nome']));
            $data['escritorio'] = strip_tags(trim($_POST['escritorio']));

            $DB = new Belma();
            $DB->UpdateLocal($data, $id_db_settings, $postId);

            if($DB->getResult()):
                WSError($DB->getError()[0], $DB->getError()[1]);
            else:
                WSError($DB->getError()[0], $DB->getError()[1]);
            endif;
            break;
        case 'SalvarLocal':
            $data['nome'] = strip_tags(trim($_POST['nome']));
            $data['escritorio'] = strip_tags(trim($_POST['escritorio']));

            $DB = new Belma();
            $DB->Local($data, $id_db_settings);

            if($DB->getResult()):
                WSError($DB->getError()[0], $DB->getError()[1]);
            else:
                WSError($DB->getError()[0], $DB->getError()[1]);
            endif;

            break;
        case 'Local':
            ?>
            <div class="modal-header">
                <h5 class="modal-title">Tipo de Patrimonio</h5>
                <a href="#" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></a>
            </div>
            <div class="getResult"></div>
            <div class="modal-body">
                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <div class="form-group">
                            <label>Área</label>
                            <input type="text" value="<?php if(isset($ClienteData['nome'])) echo $ClienteData['nome']; ?>" class="form-control" id="nome" placeholder="Área"/>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <div class="form-group">
                            <label>Local</label>
                            <input type="text" value="<?php if(isset($ClienteData['escritorio'])) echo $ClienteData['escritorio']; ?>" class="form-control" id="escritorio" placeholder="Local"/>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-8 mb-3">

                    </div>
                    <div class="col-md-4 mb-3">
                        <button type="submit" class="btn btn-primary" onclick="SalvarLocal(<?= $id_db_settings; ?>)">Salvar</button>
                    </div>
                </div>
                <div class="form-row mb-3 float-right">

                </div>
            </div>
            <?php
            break;
        case 'UpdatePatrimonio':
            $data['nome'] = strip_tags(trim($_POST['nome']));
            $data['referencia'] = strip_tags(trim($_POST['referencia']));
            $data['marca'] = strip_tags(trim($_POST['marca']));
            $data['modelo'] = strip_tags(trim($_POST['modelo']));
            $data['time_last'] = strip_tags(trim($_POST['time_last']));
            $data['data_last'] = strip_tags(trim($_POST['data_last']));
            $data['preco'] = strip_tags(trim($_POST['preco']));
            $data['id_type'] = strip_tags(trim($_POST['id_type']));
            $data['status'] = strip_tags(trim($_POST['status']));

            $DB = new Belma();
            $DB->UpdatePatrimonio($data, $id_db_settings, $postId);

            if($DB->getResult()):
                WSError($DB->getError()[0], $DB->getError()[1]);
            else:
                WSError($DB->getError()[0], $DB->getError()[1]);
            endif;
            break;
        case 'DeletePatrimonio':
            $DB = new Belma();
            $DB->DeletePatrimonio($postId);
            WSError($DB->getError()[0], $DB->getError()[1]);
            break;
        case 'PatrimonioUpdate':
            $Read = new Read();
            $Read->ExeRead("p_table", "WHERE id=:i AND id_db_settings=:y", "i={$postId}&y={$id_db_settings}");

            if($Read->getResult()):
                $ClienteData = $Read->getResult()[0];
            endif;
            ?>
            <div class="modal-header">
                <h5 class="modal-title">Atualizar Tipo de Patrimonio</h5>
                <a href="#" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></a>
            </div>
            <div class="getResult"></div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label>Patrimonio</label>
                            <input type="text" value="<?php if(isset($ClienteData['nome'])) echo $ClienteData['nome']; ?>" class="form-control" id="nome" placeholder="Tipo de Patrimonio"/>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label>Tipo de Patrimonio</label>
                            <select id="id_type" name="id_type" class="form-control">
                                <option value="" selected>-- SELECIONE O TIPO DE PATRIMONIO --</option>
                                <?php
                                    $Read = new Read();
                                    $Read->ExeRead("p_type", "WHERE id_db_settings=:i ORDER BY nome ASC", "i={$id_db_settings}");

                                    if($Read->getResult()):
                                        foreach ($Read->getResult() as $key):
                                            ?>
                                            <option value="<?= $key['id']; ?>" <?php if (isset($ClienteData['id_type']) && $ClienteData['id_type'] == $key['id']) echo 'selected="selected"'; ?>><?= $key['nome']; ?></option>
                                            <?php
                                        endforeach;
                                    endif;
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label>Status</label>
                            <select id="status" name="status" class="form-control">
                                <option value="" selected>-- SELECIONE O STATUS DO PATRIMONIO --</option>
                                <option value="1" <?php if (isset($ClienteData['status']) && $ClienteData['status'] == 1) echo 'selected="selected"'; ?>>Activo</option>
                                <option value="2" <?php if (isset($ClienteData['status']) && $ClienteData['status'] == 2) echo 'selected="selected"'; ?>>Roubado</option>
                                <option value="3" <?php if (isset($ClienteData['status']) && $ClienteData['status'] == 3) echo 'selected="selected"'; ?>>Danificado</option>
                                <option value="4" <?php if (isset($ClienteData['status']) && $ClienteData['status'] == 4) echo 'selected="selected"'; ?>>Estragado</option>
                                <option value="5" <?php if (isset($ClienteData['status']) && $ClienteData['status'] == 5) echo 'selected="selected"'; ?>>Dado por Emprestimo</option>
                                <option value="6" <?php if (isset($ClienteData['status']) && $ClienteData['status'] == 6) echo 'selected="selected"'; ?>>Depreciado</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label>Referência</label>
                            <input type="text" value="<?php if(isset($ClienteData['referencia'])) echo $ClienteData['referencia']; ?>" class="form-control" id="referencia" placeholder="Referencia"/>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label>Marca</label>
                            <input type="text" value="<?php if(isset($ClienteData['marca'])) echo $ClienteData['marca']; ?>" class="form-control" id="marca" placeholder="Marca"/>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label>Modelo</label>
                            <input type="text" value="<?php if(isset($ClienteData['modelo'])) echo $ClienteData['modelo']; ?>" class="form-control" id="modelo" placeholder="Modelo"/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label>Data de compra</label><br/>
                            <input type="date" value="<?php if(isset($ClienteData['time_last'])) echo $ClienteData['time_last']; ?>" class="form-control" id="time_last" placeholder="Tipo de Patrimonio"/>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label>Data de válidade</label>
                            <input type="date" value="<?php if(isset($ClienteData['data_last'])) echo $ClienteData['data_last']; ?>" class="form-control" id="data_last" placeholder="Tipo de Patrimonio"/>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label>Preço de compra</label>
                            <input type="text" value="<?php if(isset($ClienteData['preco'])) echo $ClienteData['preco']; ?>" class="form-control" id="preco" placeholder="Preço de compra"/>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-8 mb-3">

                    </div>
                    <div class="col-md-4 mb-3">
                        <button type="submit" class="btn btn-primary" onclick="UpdatePatrimonio(<?= $postId; ?>)">Salvar</button>
                    </div>
                </div>
                <div class="form-row mb-3 float-right">

                </div>
            </div>
            <?php
            break;
        case 'ReadPatrimonio':
            $read = new Read();
            $read->ExeRead("p_table", "WHERE id_db_settings=:id ORDER BY id DESC", "id={$id_db_settings}");
            if($read->getResult()):
                foreach ($read->getResult() as $item):
                    ?>
                    <tr>
                        <td><?= $item['nome']; ?></td>
                        <td><?= $item['referencia']; ?></td>
                        <td><?= $item['marca']; ?></td>
                        <td><?= $item['modelo']; ?></td>
                        <td><?= $item['time_last']; ?></td>
                        <td>
                            <a href="#" class="btn btn-sm btn-warning"  data-bs-toggle="modal" data-bs-target="#ModalDefault" onclick="PatrimonioUpdate(<?= $item['id']; ?>);">Editar</a>&nbsp;
                            <a href="#" onclick="DeletePatrimonio(<?php if(isset($item['id'])) echo $item['id']; ?>)" class="btn btn-sm btn-danger">Apagar</a>&nbsp;
                        </td>
                    </tr>
                <?php
                endforeach;
            endif;

            break;
        case 'SalvarPatrimonio':
            $data['nome'] = strip_tags(trim($_POST['nome']));
            $data['referencia'] = strip_tags(trim($_POST['referencia']));
            $data['marca'] = strip_tags(trim($_POST['marca']));
            $data['modelo'] = strip_tags(trim($_POST['modelo']));
            $data['time_last'] = strip_tags(trim($_POST['time_last']));
            $data['data_last'] = strip_tags(trim($_POST['data_last']));
            $data['preco'] = strip_tags(trim($_POST['preco']));
            $data['id_type'] = strip_tags(trim($_POST['id_type']));

            $DB = new Belma();
            $DB->Patrimonio($data, $id_db_settings);

            if($DB->getResult()):
                WSError($DB->getError()[0], $DB->getError()[1]);
            else:
                WSError($DB->getError()[0], $DB->getError()[1]);
            endif;

            break;
        case 'Patrimonio':
            ?>
            <div class="modal-header">
                <h5 class="modal-title">Patrimonio</h5>
                <a href="#" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></a>
            </div>
            <div class="getResult"></div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <label>Patrimonio</label>
                            <input type="text" value="<?php if(isset($ClienteData['nome'])) echo $ClienteData['nome']; ?>" class="form-control" id="nome" placeholder="Tipo de Patrimonio"/>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <label>Tipo de Patrimonio</label>
                            <select id="id_type" name="id_type" class="form-control">
                                <option value="" selected>-- SELECIONE O TIPO DE PATRIMONIO --</option>
                                <?php
                                $Read = new Read();
                                $Read->ExeRead("p_type", "WHERE id_db_settings=:i ORDER BY nome ASC", "i={$id_db_settings}");

                                if($Read->getResult()):
                                    foreach ($Read->getResult() as $key):
                                        ?>
                                        <option value="<?= $key['id']; ?>" <?php if (isset($ClienteData['id_type']) && $ClienteData['id_type'] == $key['id']) echo 'selected="selected"'; ?>><?= $key['nome']; ?></option>
                                    <?php
                                    endforeach;
                                endif;
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label>Referência</label>
                            <input type="text" value="<?php if(isset($ClienteData['referencia'])) echo $ClienteData['referencia']; ?>" class="form-control" id="referencia" placeholder="Referencia"/>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label>Marca</label>
                            <input type="text" value="<?php if(isset($ClienteData['marca'])) echo $ClienteData['marca']; ?>" class="form-control" id="marca" placeholder="Marca"/>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label>Modelo</label>
                            <input type="text" value="<?php if(isset($ClienteData['modelo'])) echo $ClienteData['modelo']; ?>" class="form-control" id="modelo" placeholder="Modelo"/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label>Data de compra</label><br/>
                            <input type="date" value="<?php if(isset($ClienteData['time_last'])) echo $ClienteData['time_last']; ?>" class="form-control" id="time_last" placeholder="Tipo de Patrimonio"/>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label>Data de válidade</label>
                            <input type="date" value="<?php if(isset($ClienteData['data_last'])) echo $ClienteData['data_last']; ?>" class="form-control" id="data_last" placeholder="Tipo de Patrimonio"/>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label>Preço de compra</label>
                            <input type="text" value="<?php if(isset($ClienteData['preco'])) echo $ClienteData['preco']; ?>" class="form-control" id="preco" placeholder="Preço de compra"/>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-8 mb-3">

                    </div>
                    <div class="col-md-4 mb-3">
                        <button type="submit" class="btn btn-primary" onclick="SalvarPatrimonio(<?= $id_db_settings; ?>)">Salvar</button>
                    </div>
                </div>
                <div class="form-row mb-3 float-right">

                </div>
            </div>
            <?php
            break;
        case 'DeleteTipoPatrimonio':
            $DB = new Belma();
            $DB->DeleteTipoPatrimonio($postId);
            WSError($DB->getError()[0], $DB->getError()[1]);
            break;
        case 'UpdateTipoPatrimonio':
            $data['nome'] = strip_tags(trim($_POST['nome']));
            $data['descricao'] = strip_tags(trim($_POST['descricao']));

            $DB = new Belma();
            $DB->UpdateType($data, $id_db_settings, $postId);

            if($DB->getResult()):
                WSError($DB->getError()[0], $DB->getError()[1]);
            else:
                WSError($DB->getError()[0], $DB->getError()[1]);
            endif;
            break;
        case 'TipoPatrimonioUpdate':
            $Read = new Read();
            $Read->ExeRead("p_type", "WHERE id=:i AND id_db_settings=:y", "i={$postId}&y={$id_db_settings}");

            if($Read->getResult()):
                $ClienteData = $Read->getResult()[0];
            endif;
            ?>
            <div class="modal-header">
                <h5 class="modal-title">Atualizar Tipo de Patrimonio</h5>
                <a href="#" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></a>
            </div>
            <div class="getResult"></div>
            <div class="modal-body">
                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <div class="input-group">
                            <input type="text" value="<?php if(isset($ClienteData['nome'])) echo $ClienteData['nome']; ?>" class="form-control" id="nome" placeholder="Nome"/>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <div class="input-group input-group-sm">
                            <textarea class="form-control" id="descricao" placeholder="Observações"><?php if(isset($ClienteData['descricao'])) echo $ClienteData['descricao']; ?></textarea>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-8 mb-3">

                    </div>
                    <div class="col-md-4 mb-3">
                        <button type="submit" class="btn btn-primary" onclick="UpdateTipoPatrimonio(<?= $postId; ?>)">Salvar</button>
                    </div>
                </div>
                <div class="form-row mb-3 float-right">

                </div>
            </div>
            <?php
            break;
        case 'ReadTipoPatrimonio':
            $read = new Read();
            $read->ExeRead("p_type", "WHERE id_db_settings=:id ORDER BY id DESC", "id={$id_db_settings}");
            if($read->getResult()):
                foreach ($read->getResult() as $item):
                    ?>
                    <tr>
                        <td><?= $item['nome']; ?></td>
                        <td><?= $item['descricao']; ?></td>
                        <td>
                            <a href="#" class="btn btn-sm btn-warning"  data-bs-toggle="modal" data-bs-target="#ModalDefault" onclick="TipoPatrimonioUpdate(<?= $item['id']; ?>);">Editar</a>&nbsp;
                            <a href="#" onclick="DeleteTipoPatrimonio(<?php if(isset($item['id'])) echo $item['id']; ?>)" class="btn btn-sm btn-danger">Apagar</a>&nbsp;
                        </td>
                    </tr>
                <?php
                endforeach;
            endif;
            break;
        case 'SalvarTipoPatrimonio':
            $data['nome'] = strip_tags(trim($_POST['nome']));
            $data['descricao'] = strip_tags(trim($_POST['descricao']));

            $DB = new Belma();
            $DB->Type($data, $id_db_settings);

            if($DB->getResult()):
                WSError($DB->getError()[0], $DB->getError()[1]);
            else:
                WSError($DB->getError()[0], $DB->getError()[1]);
            endif;

            break;
        case 'TypePatrimonio':
            ?>
            <div class="modal-header">
                <h5 class="modal-title">Tipo de Patrimonio</h5>
                <a href="#" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></a>
            </div>
            <div class="getResult"></div>
            <div class="modal-body">
                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <div class="input-group">
                            <input type="text" value="<?php if(isset($ClienteData['nome'])) echo $ClienteData['nome']; ?>" class="form-control" id="nome" placeholder="Tipo de Patrimonio"/>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <div class="input-group">
                            <textarea class="form-control" id="descricao" placeholder="Observações"><?php if(isset($ClienteData['descricao'])) echo $ClienteData['descricao']; ?></textarea>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-8 mb-3">

                    </div>
                    <div class="col-md-4 mb-3">
                        <button type="submit" class="btn btn-primary" onclick="SalvarTipoPatrimonio(<?= $id_db_settings; ?>)">Salvar</button>
                    </div>
                </div>
                <div class="form-row mb-3 float-right">

                </div>
            </div>
            <?php
            break;
        case 'DeleteVeiculo':
            $DB = new Oficina();
            $DB->DeleteVeiculo($postId);
            WSError($DB->getError()[0], $DB->getError()[1]);
            break;
        case 'UpdateVeiculo':
            $data['veiculo'] = strip_tags(trim($_POST['veiculo']));
            $data['id_cliente'] = strip_tags(trim($_POST['id_cliente']));
            $data['id_fabricante'] = strip_tags(trim($_POST['id_fabricante']));
            $data['km_atual'] = strip_tags(trim($_POST['km_atual']));
            $data['placa'] = strip_tags(trim($_POST['placa']));
            $data['modelo'] = strip_tags(trim($_POST['modelo']));
            $data['content'] = strip_tags(trim($_POST['content']));
            $data['data_entrada'] = strip_tags(trim($_POST['data_entrada']));

            $data['motor'] = strip_tags(trim($_POST['motor']));
            $data['cor'] = strip_tags(trim($_POST['cor']));
            $data['chassi'] = strip_tags(trim($_POST['chassi']));

            $DB = new Oficina();
            $DB->UpdateVeiculo($data, $id_db_settings, $postId);

            if($DB->getResult()):
                WSError($DB->getError()[0], $DB->getError()[1]);
            else:
                WSError($DB->getError()[0], $DB->getError()[1]);
            endif;

            break;
        case 'VeiculoUpdate':
            $Read = new Read();
            $Read->ExeRead("i_veiculos", "WHERE id=:i AND id_db_settings=:y", "i={$postId}&y={$id_db_settings}");

            if($Read->getResult()):
                $ClienteData = $Read->getResult()[0];
            endif;
            ?>
            <div class="modal-header">
                <h5 class="modal-title">Atualizar Veiculos</h5>
                <a href="#" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></a>
            </div>
            <div class="getResult"></div>
            <div class="modal-body">
                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <div class="input-group">
                            <input type="text" value="<?php if(isset($ClienteData['veiculo'])) echo $ClienteData['veiculo']; ?>" class="form-control" id="veiculo" placeholder="Veiculo"/>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <div class="input-group">
                            <input type="text" class="form-control" value="<?php if(isset($ClienteData['placa'])) echo $ClienteData['placa']; ?>" id="placa" placeholder="Placa de matricula"/>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <div class="input-group">
                            <input type="text" value="<?php if(isset($ClienteData['modelo'])) echo $ClienteData['modelo']; ?>" class="form-control" id="modelo" placeholder="Modelo"/>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <select class="form-control" id="id_fabricante">
                            <option value="">Seleciona o fabricante</option>
                            <?php
                            $Read = new Read();
                            $Read->ExeRead("i_fabricante", "WHERE id_db_settings=:i ORDER BY name ASC ", "i={$id_db_settings}");

                            if($Read->getResult()):
                                foreach($Read->getResult() as $key):
                                    ?>
                                    <option value="<?= $key['id']; ?>" <?php if(isset($ClienteData['id_fabricante']) && $ClienteData['id_fabricante'] == $key['id']) echo "selected";  ?>><?= $key['name']; ?></option>
                                <?php
                                endforeach;
                            endif;
                            ?>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <select class="form-control" id="id_cliente">
                            <option value="">Seleciona o cliente</option>
                            <?php
                            $Read = new Read();
                            $Read->ExeRead("cv_customer", "WHERE id_db_settings=:i ORDER BY nome ASC ", "i={$id_db_settings}");

                            if($Read->getResult()):
                                foreach ($Read->getResult() as $item):
                                    ?>
                                    <option value="<?= $item['id']; ?>" <?php if(isset($ClienteData['id_cliente']) && $ClienteData['id_cliente'] == $item['id']) echo "selected";  ?>><?= $item['nome']; ?></option>
                                <?php
                                endforeach;
                            endif;
                            ?>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <div class="input-group">
                            <input type="text" class="form-control" value="<?php if(isset($ClienteData['km_atual'])) echo $ClienteData['km_atual']; ?>" id="km_atual" placeholder="Kilometragem atual" >
                        </div>
                    </div>
                    <div class="col-md-12 mb-3">
                        <div class="input-group">
                            <input type="datetime-local" class="form-control"  value="<?php if(isset($ClienteData['data_entrada'])): echo $ClienteData['data_entrada']; else: echo date('Y-m-d H:i');  endif; ?>" id="data_entrada" placeholder="Data entrada">
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <div class="input-group">
                            <input type="text" class="form-control" value="<?php if(isset($ClienteData['motor'])) echo $ClienteData['motor']; ?>" id="motor" placeholder="Motor" >
                        </div>
                    </div>
                    <div class="col-md-12 mb-3">
                        <div class="input-group">
                            <input type="text" class="form-control"  value="<?php if(isset($ClienteData['cor'])) echo $ClienteData['cor']; ?>" id="cor" placeholder="Cor">
                        </div>
                    </div>
                    <div class="col-md-12 mb-3">
                        <div class="input-group">
                            <input type="text" class="form-control"  value="<?php if(isset($ClienteData['chassi'])) echo $ClienteData['chassi']; ?>" id="chassi" placeholder="Chassi">
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <div class="input-group input-group-sm">
                            <textarea class="form-control" id="content" placeholder="Observações"><?php if(isset($ClienteData['content'])) echo $ClienteData['content']; ?></textarea>
                        </div>
                    </div>
                </div>

                <hr/>
                <div class="form-row">
                    <div class="col-md-8 mb-3">

                    </div>
                    <div class="col-md-4 mb-3">
                        <button type="submit" class="btn btn-primary" onclick="UpdateVeiculo(<?= $postId; ?>)">Salvar</button>
                    </div>
                </div>
                <div class="form-row mb-3 float-right">

                </div>
            </div>
            <?php
            break;
        case 'ReadVeiculo':
            $gQtd = null;
            $tTotal = null;
            $qTotal = null;

            $Read = new Read();
            $Read->ExeRead("i_veiculos", "WHERE id_db_settings=:i ORDER BY veiculo ASC", "i={$id_db_settings}");

            if($Read->getResult()):
                foreach ($Read->getResult() as $item):
                    ?>
                    <tr>
                    	<td><?= $item['id']; ?></td>
                        <td><?php $Read->ExeRead("cv_customer", "WHERE id=:i", "i={$item['id_cliente']}"); if($Read->getResult()): echo $Read->getResult()[0]['nome']; endif; ?></td>
                        <td><?= $item['veiculo']; ?></td>
                        <td><?= $item['placa']; ?></td>
                        <td><?= $item['km_atual']; ?></td>
                        <td><?= $item['data_entrada']; ?></td>
                        <td><?= $item['data_saida']; ?></td>
                        <td>
                            <a href="#" class="btn btn-sm btn-warning"  data-bs-toggle="modal" data-bs-target="#ModalDefault" onclick="VeiculoUpdate(<?= $item['id']; ?>);">Editar</a>&nbsp;
                            <a href="#" onclick="DeleteVeiculo(<?php if(isset($item['id'])) echo $item['id']; ?>)" class="btn btn-sm btn-danger">Apagar</a>&nbsp;
                        </td>
                    </tr>
                <?php
                endforeach;
            endif;
            break;
        case 'SalvarVeiculo':
            $data['veiculo'] = strip_tags(trim($_POST['veiculo']));
            $data['id_cliente'] = strip_tags(trim($_POST['id_cliente']));
            $data['id_fabricante'] = strip_tags(trim($_POST['id_fabricante']));
            $data['km_atual'] = strip_tags(trim($_POST['km_atual']));
            $data['placa'] = strip_tags(trim($_POST['placa']));
            $data['modelo'] = strip_tags(trim($_POST['modelo']));
            $data['content'] = strip_tags(trim($_POST['content']));
            $data['data_entrada'] = strip_tags(trim($_POST['data_entrada']));

            $data['motor'] = strip_tags(trim($_POST['motor']));
            $data['cor'] = strip_tags(trim($_POST['cor']));
            $data['chassi'] = strip_tags(trim($_POST['chassi']));

            $DB = new Oficina();
            $DB->Veiculo($data, $id_db_settings);

            if($DB->getResult()):
                WSError($DB->getError()[0], $DB->getError()[1]);
            else:
                WSError($DB->getError()[0], $DB->getError()[1]);
            endif;

            break;
        case 'CreateVeiculos':
            ?>
            <div class="modal-header">
                <h5 class="modal-title">Entrada de Veiculos</h5>
                <a href="#" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></a>
            </div>
            <div class="getResult"></div>
            <div class="modal-body">
                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <div class="input-group">
                            <input type="text" value="<?php if(isset($ClienteData['veiculo'])) echo $ClienteData['veiculo']; ?>" class="form-control" id="veiculo" placeholder="Veiculo"/>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <div class="input-group">
                            <input type="text" class="form-control" value="<?php if(isset($ClienteData['placa'])) echo $ClienteData['placa']; ?>" id="placa" placeholder="Placa de matricula"/>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <div class="input-group">
                            <input type="text" value="<?php if(isset($ClienteData['modelo'])) echo $ClienteData['modelo']; ?>" class="form-control" id="modelo" placeholder="Modelo"/>
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <select class="form-control" id="id_fabricante">
                            <option value="">Seleciona o fabricante</option>
                            <?php
                                $Read = new Read();
                                $Read->ExeRead("i_fabricante", "WHERE id_db_settings=:i ORDER BY name ASC ", "i={$id_db_settings}");

                                if($Read->getResult()):
                                    foreach($Read->getResult() as $key):
                                        ?>
                                        <option value="<?= $key['id']; ?>" <?php if(isset($ClienteData['id_fabricante']) && $ClienteData['id_fabricante'] == $key['id']) echo "selected";  ?>><?= $key['name']; ?></option>
                                    <?php
                                    endforeach;
                                endif;
                            ?>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <select class="form-control" id="id_cliente">
                            <option value="">Seleciona o cliente</option>
                            <?php
                            $Read = new Read();
                            $Read->ExeRead("cv_customer", "WHERE id_db_settings=:i ORDER BY nome ASC ", "i={$id_db_settings}");

                            if($Read->getResult()):
                                foreach ($Read->getResult() as $item):
                                    ?>
                                    <option value="<?= $item['id']; ?>" <?php if(isset($ClienteData['id_cliente']) && $ClienteData['id_cliente'] == $item['id']) echo "selected";  ?>><?= $item['nome']; ?></option>
                                <?php
                                endforeach;
                            endif;
                            ?>
                        </select>
                    </div>
                </div>


                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <div class="input-group">
                            <input type="text" class="form-control" value="<?php if(isset($ClienteData['km_atual'])) echo $ClienteData['km_atual']; ?>" id="km_atual" placeholder="Kilometragem atual" >
                        </div>
                    </div>
                    <div class="col-md-12 mb-3">
                        <div class="input-group">
                            <input type="datetime-local" class="form-control"  value="<?php if(isset($ClienteData['data_entrada'])): echo $ClienteData['data_entrada']; else: echo date('Y-m-d H:i');  endif; ?>" id="data_entrada" placeholder="Data entrada">
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <div class="input-group">
                            <input type="text" class="form-control" value="<?php if(isset($ClienteData['motor'])) echo $ClienteData['motor']; ?>" id="motor" placeholder="Motor" >
                        </div>
                    </div>
                    <div class="col-md-12 mb-3">
                        <div class="input-group">
                            <input type="text" class="form-control"  value="<?php if(isset($ClienteData['cor'])) echo $ClienteData['cor']; ?>" id="cor" placeholder="Cor">
                        </div>
                    </div>
                    <div class="col-md-12 mb-3">
                        <div class="input-group">
                            <input type="text" class="form-control"  value="<?php if(isset($ClienteData['chassi'])) echo $ClienteData['chassi']; ?>" id="chassi" placeholder="Chassi">
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <div class="input-group">
                            <textarea class="form-control" id="content" placeholder="Observações"><?php if(isset($ClienteData['content'])) echo $ClienteData['content']; ?></textarea>
                        </div>
                    </div>
                </div>

                <hr/>
                <div class="form-row">
                    <div class="col-md-8 mb-3">

                    </div>
                    <div class="col-md-4 mb-3">
                        <button type="submit" class="btn btn-primary" onclick="SalvarVeiculo(<?= $id_db_settings; ?>)">Salvar</button>
                    </div>
                </div>
                <div class="form-row mb-3 float-right">

                </div>
            </div>
            <?php
            break;
        case 'DeleteFabricante':
            $DB = new Oficina();
            $DB->DeleteFabricante($postId);
            WSError($DB->getError()[0], $DB->getError()[1]);
            break;
        case 'DeleteFornecedores':
            $DB = new Oficina();
            $DB->DeleteFornecedores($postId);
            WSError($DB->getError()[0], $DB->getError()[1]);
            break;
        case 'UpdateFabricante':
            $data['content']  = strip_tags(trim($_POST['content']));
            $data['name'] = strip_tags(trim($_POST['name']));

            $DB = new Oficina();
            $DB->UpdateFabricante($data, $id_db_settings, $postId);

            WSError($DB->getError()[0], $DB->getError()[1]);
            break;
        case 'FabricanteUpdate':
            $Read = new Read();
            $Read->ExeRead("i_fabricante", "WHERE id=:i", "i={$postId}");

            if($Read->getResult()):
                $ClienteData = $Read->getResult()[0];
            endif;

            ?>
            <div class="modal-header">
                <h5 class="modal-title">Atualizar fabricante</h5>
                <a href="#" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></a>
            </div>
            <div class="getResult"></div>
            <div class="modal-body">
                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <div class="input-group">
                            <input type="text" class="form-control" id="name" value="<?php if(isset($ClienteData['name'])) echo $ClienteData['name']; ?>" placeholder="Fabricante" >
                        </div>
                    </div>
                    <div class="col-md-12 mb-3">
                        <div class="input-group">
                            <textarea class="form-control" id="content" placeholder="Descrição (Opcional)"><?php if(isset($ClienteData['content'])) echo $ClienteData['content']; ?></textarea>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-8 mb-3">

                    </div>
                    <div class="col-md-4 mb-3">
                        <input type="submit" class="btn btn-primary" onclick="UpdateFabricante(<?= $ClienteData['id']; ?>)" value="Salvar"/>
                    </div>
                </div>
            </div>
            <?php

            break;
        case 'ReadFabricante':
            $Read = new Read();
            $Read->ExeRead("i_fabricante", "WHERE id_db_settings=:i ORDER BY name ASC", "i={$id_db_settings}");

            if($Read->getResult()):
                foreach($Read->getResult() as $item):
                    ?>
                    <tr>
                        <td><?= $item['id']; ?></td>
                        <td><?= $item['name']; ?></td>
                        <td><?= substr($item['content'], 0, 155); ?></td>
                        <td>
                            <a class="btn btn-sm btn-warning" href="#" data-bs-toggle="modal" data-bs-target="#ModalDefault" onclick="FabricanteUpdate(<?= $item['id']; ?>);">Editar</a>&nbsp;
                            <a class="btn btn-sm btn-danger" href="#" onclick="DeleteFabricante(<?= $item['id']; ?>)">Eliminar</a>
                        </td>
                    </tr>
                <?php
                endforeach;
            endif;
            break;
        case 'FabricanteCreate':
            $data['content']  = strip_tags(trim($_POST['content']));
            $data['name'] = strip_tags(trim($_POST['name']));

            $DB = new Oficina();
            $DB->CreateFabricante($data, $id_db_settings);
            WSError($DB->getError()[0], $DB->getError()[1]);
            break;
        case 'CreateFabricante':
            ?>
            <div class="modal-header">
                <h5 class="modal-title">Cria Fabricante</h5>
                <a href="#" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></a>
            </div>
            <div class="getResult"></div>
            <div class="modal-body">
                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <div class="input-group">
                            <input type="text" class="form-control" id="name" value="<?php if(isset($ClienteData['name'])) echo $ClienteData['name']; ?>" placeholder="Fabricante" >
                        </div>
                    </div>
                    <div class="col-md-12 mb-3">
                        <div class="input-group">
                            <textarea class="form-control" id="content" placeholder="Descrição (Opcional)"><?php if(isset($ClienteData['content'])) echo $ClienteData['content']; ?></textarea>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-8 mb-3">

                    </div>
                    <div class="col-md-4 mb-3">
                        <input type="submit" class="btn btn-primary" onclick="FabricanteCreate(<?= $id_db_settings ?>)" value="Salvar"/>
                    </div>
                </div>
            </div>
            <?php
            break;
        case 'UpdatesFornecedores':
            $data['name'] = strip_tags(trim($_POST['name']));
            $data['type'] = strip_tags(trim($_POST['type']));
            $data['nif'] = strip_tags(trim($_POST['nif']));
            $data['email'] = strip_tags(trim($_POST['email']));
            $data['telefone'] = strip_tags(trim($_POST['telefone']));
            $data['endereco'] = strip_tags(trim($_POST['endereco']));
            $data['city'] = strip_tags(trim($_POST['city']));
            $data['country'] = strip_tags(trim($_POST['country']));
            $data['obs'] = strip_tags(trim($_POST['obs']));

            $DB = new Oficina();
            $DB->UpdatesFornecedores($data, $id_db_settings, $postId);

            if($DB->getResult()):
                WSError($DB->getError()[0], $DB->getError()[1]);
            else:
                WSError($DB->getError()[0], $DB->getError()[1]);
            endif;

            break;
        case 'FornecedoresUpdate':
            $Read = new Read();
            $Read->ExeRead("i_fornecedores", "WHERE id=:i", "i={$postId}");

            if($Read->getResult()): $ClienteData = $Read->getResult()[0]; endif;
            ?>
            <div class="modal-header">
                <h5 class="modal-title">Atualizar Fornecedores</h5>
                <a href="#" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></a>
            </div>
            <div class="getResult"></div>
            <div class="modal-body">
                <?php
                if(isset($ClienteData['nif']) && !empty($ClienteData['nif']) || isset($ClienteData['nif']) && $ClienteData['nif'] != "999999999"):
                    ?>
                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <div class="input-group">
                                <input type="text" class="form-control" value="<?php if(isset($ClienteData['name'])) echo $ClienteData['name']; ?>" id="name" placeholder="Fornecedor"/>
                            </div>
                        </div>
                    </div>
                <?php
                else:
                    ?><input type="hidden" name="name" id="name" value="<?php if(isset($ClienteData['name'])) echo $ClienteData['name']; ?>"><?php
                endif;

                if(isset($ClienteData['nif']) && $ClienteData['nif'] == "999999999" || isset($ClienteData['nif']) && empty($ClienteData['nif']) || isset($ClienteData['nif']) && $ClienteData['nif'] == null):
                    ?>
                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <div class="input-group">
                                <input type="text" class="form-control" value="<?php if(isset($ClienteData['nif'])) echo $ClienteData['nif']; ?>" id="nif" placeholder="NIF"/>
                            </div>
                        </div>
                    </div>
                <?php
                else:
                    ?><input type="hidden" name="nif" id="nif" value="<?php if(isset($ClienteData['nif'])) echo $ClienteData['nif']; ?>"><?php
                endif;
                ?>
                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <div class="input-group">
                            <input type="text" class="form-control" value="<?php if(isset($ClienteData['email'])) echo $ClienteData['email']; ?>" id="email" placeholder="E-mail"/>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <div class="input-group">
                            <input type="text" class="form-control" value="<?php if(isset($ClienteData['telefone'])) echo $ClienteData['telefone']; ?>" id="telefone" placeholder="Telefone"/>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <div class="input-group">
                            <input type="text" class="form-control" value="<?php if(isset($ClienteData['endereco'])) echo $ClienteData['endereco']; ?>" id="endereco" placeholder="Endereço"/>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <div class="input-group">
                            <input type="text" class="form-control" value="<?php if(isset($ClienteData['city'])) echo $ClienteData['city']; ?>" id="city" placeholder="Cidade"/>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <div class="input-group">
                            <input type="text" class="form-control" value="<?php if(isset($ClienteData['country'])) echo $ClienteData['country']; ?>" id="country" placeholder="País"/>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <select class="form-control" id="type">
                            <option value="">Seleciona o tipo de cliente</option>
                            <option value="F" <?php if(isset($ClienteData['type']) && $ClienteData['type'] == "F") echo "selected";  ?>>Pessoa Física</option>
                            <option value="J" <?php if(isset($ClienteData['type']) && $ClienteData['type'] == "J") echo "selected";  ?>>Pessoa juridica</option>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <div class="input-group">
                            <textarea class="form-control" id="obs" placeholder="Observações"><?php if(isset($ClienteData['obs'])) echo $ClienteData['obs']; ?></textarea>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-8 mb-3">

                    </div>
                    <div class="col-md-4 mb-3">
                        <button type="submit" class="btn btn-primary" onclick="UpdatesFornecedores(<?= $postId; ?>)">Salvar</button>
                    </div>
                </div>
                <div class="form-row mb-3 float-right">

                </div>
            </div>
            <?php
            break;
        case 'ReadFornecedores':
            $Read = new Read();
            $Read->ExeRead("i_fornecedores", "WHERE id_db_settings=:i ORDER BY name ASC", "i={$id_db_settings}");

            if($Read->getResult()):
                foreach($Read->getResult() as $item):

                    if(empty($item['nif']) || $item['nif'] == null || $item['nif'] == "999999999"): $item['nif'] = "Consumidor final"; endif;
                    ?>
                    <tr>
                        <td><?= $item['id']; ?></td>
                        <td><?= $item['name']; ?></td>
                        <td><?= $item['nif']; ?></td>
                        <td><?= $item['email']; ?></td>
                        <td><?= $item['telefone']; ?></td>
                        <td><?= $item['endereco']; ?></td>
                        <td>
                            <a class="btn btn-sm btn-warning" href="#" data-bs-toggle="modal" data-bs-target="#ModalDefault" onclick="FornecedoresUpdate(<?= $item['id']; ?>);">Editar</a>&nbsp;
                            <a class="btn btn-sm btn-danger" href="#" onclick="DeleteFornecedores(<?= $item['id']; ?>)">Eliminar</a>
                        </td>
                    </tr>
                <?php
                endforeach;
            endif;

            break;
        case 'SalvarFornecedores':
            $data['name'] = strip_tags(trim($_POST['name']));
            $data['type'] = strip_tags(trim($_POST['type']));
            $data['nif'] = strip_tags(trim($_POST['nif']));
            $data['email'] = strip_tags(trim($_POST['email']));
            $data['telefone'] = strip_tags(trim($_POST['telefone']));
            $data['endereco'] = strip_tags(trim($_POST['endereco']));
            $data['city'] = strip_tags(trim($_POST['city']));
            $data['country'] = strip_tags(trim($_POST['country']));
            $data['obs'] = strip_tags(trim($_POST['obs']));

            var_dump($data);

            $DB = new Oficina();
            $DB->Fornecedores($data, $id_db_settings);

            if($DB->getResult()):
                WSError($DB->getError()[0], $DB->getError()[1]);
            else:
                WSError($DB->getError()[0], $DB->getError()[1]);
            endif;
            break;
        case 'CreateFornecedores':
            ?>
            <div class="modal-header">
                <h5 class="modal-title">Criar Fornecedores</h5>
                <a href="#" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></a>
            </div>
            <div class="getResult"></div>
            <div class="modal-body">
                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <div class="input-group">
                            <input type="text" class="form-control" value="<?php if(isset($ClienteData['name'])) echo $ClienteData['name']; ?>" id="name" name="name" placeholder="Fornecedor"/>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <div class="input-group">
                            <input type="text" class="form-control" value="<?php if(isset($ClienteData['nif'])) echo $ClienteData['nif']; ?>" id="nif" placeholder="NIF"/>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <div class="input-group">
                            <input type="text" class="form-control" value="<?php if(isset($ClienteData['email'])) echo $ClienteData['email']; ?>" id="email" placeholder="E-mail"/>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <div class="input-group">
                            <input type="text" class="form-control" value="<?php if(isset($ClienteData['telefone'])) echo $ClienteData['telefone']; ?>" id="telefone" placeholder="Telefone"/>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <div class="input-group">
                            <input type="text" class="form-control" value="<?php if(isset($ClienteData['endereco'])) echo $ClienteData['endereco']; ?>" id="endereco" name="endereco" placeholder="Endereço"/>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <div class="input-group">
                            <input type="text" class="form-control" value="<?php if(isset($ClienteData['city'])) echo $ClienteData['city']; ?>" id="city" placeholder="Cidade"/>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <div class="input-group">
                            <input type="text" class="form-control" value="<?php if(isset($ClienteData['country'])) echo $ClienteData['country']; ?>" id="country" placeholder="País"/>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <select class="form-control" id="type" name="type">
                            <option value="F" <?php if(isset($ClienteData['type']) && $ClienteData['type'] == "F") echo "selected";  ?>>Pessoa Física</option>
                            <option value="J" <?php if(isset($ClienteData['type']) && $ClienteData['type'] == "J") echo "selected";  ?>>Pessoa juridica</option>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <div class="input-group">
                            <textarea class="form-control" id="obs" placeholder="Observações"><?php if(isset($ClienteData['obs'])) echo $ClienteData['obs']; ?></textarea>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-8 mb-3">

                    </div>
                    <div class="col-md-4 mb-3">
                        <button type="submit" class="btn btn-primary" onclick="SalvarFornecedores(<?= $id_db_settings; ?>)">Salvar</button>
                    </div>
                </div>
                <div class="form-row mb-3 float-right">

                </div>
            </div>
            <?php
            break;
        case 'ReadUnidade':
            $Read = new Read();
            $Read->ExeRead("i_unidade", "WHERE id_db_settings=:i ORDER BY unidade ASC", "i={$id_db_settings}");

            if($Read->getResult()):
                foreach($Read->getResult() as $item):
                    ?>
                    <tr>
                        <td><?= $item['id']; ?></td>
                        <td><?= $item['unidade']; ?></td>
                        <td><?= $item['simbolo']; ?></td>
                        <td>
                            <a class="btn btn-warning" href="#" data-bs-toggle="modal" data-bs-target="#ModalDefault" onclick="UnidadeUpdate(<?= $item['id']; ?>);">Editar</a>&nbsp;
                            <a class="btn btn-danger" href="#" onclick="DeleteUnidade(<?= $item['id']; ?>)">Eliminar</a>
                        </td>
                    </tr>
                <?php
                endforeach;
            endif;

            break;
        case 'DeleteUnidade':
            $DB = new Oficina();
            $DB->DeleteUnidade($postId);
            WSError($DB->getError()[0], $DB->getError()[1]);
            break;
        case 'UpdateUnidade':
            $data['unidade']  = strip_tags(trim($_POST['unidade']));
            $data['simbolo'] = strip_tags(trim($_POST['simbolo']));

            $DB = new Oficina();
            $DB->UpdateUnidade($data, $id_db_settings, $postId);
            WSError($DB->getError()[0], $DB->getError()[1]);
            break;
        case 'UnidadeUpdate':
            $Read = new Read();
            $Read->ExeRead("i_unidade", "WHERE id=:i", "i={$postId}");

            if($Read->getResult()):
                $ClienteData = $Read->getResult()[0];
            endif;

            ?>
            <div class="modal-header">
                <h5 class="modal-title">Atualizar unidade</h5>
                <a href="#" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></a>
            </div>
            <div class="getResult"></div>
            <div class="modal-body">
                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <div class="input-group">
                            <input type="text" class="form-control" id="unidade" value="<?php if(isset($ClienteData['unidade'])) echo $ClienteData['unidade']; ?>" placeholder="Unidade de medida" >
                        </div>
                    </div>
                    <div class="col-md-12 mb-3">
                        <div class="input-group">
                            <input type="text" class="form-control" id="simbolo" value="<?php if(isset($ClienteData['simbolo'])) echo $ClienteData['simbolo']; ?>" placeholder="Simbolo da unidade" >
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-8 mb-3">

                    </div>
                    <div class="col-md-4 mb-3">
                        <input type="submit" class="btn btn-primary" onclick="UpdateUnidade(<?= $ClienteData['id']; ?>)" value="Salvar"/>
                    </div>
                </div>
            </div>
            <?php
            break;
        case 'UnidadeCreate':
            $data['unidade']  = strip_tags(trim($_POST['unidade']));
            $data['simbolo'] = strip_tags(trim($_POST['simbolo']));

            $DB = new Oficina();
            $DB->UnidadeCreate($data, $id_db_settings);
            WSError($DB->getError()[0], $DB->getError()[1]);
            break;
        case 'CreateUnidades':
            ?>
            <div class="modal-header">
                <h5 class="modal-title">Cria unidade</h5>
                <a href="#" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></a>
            </div>
            <div class="getResult"></div>
            <div class="modal-body">
                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <div class="input-group">
                            <input type="text" class="form-control" id="unidade" value="<?php if(isset($ClienteData['unidade'])) echo $ClienteData['unidade']; ?>" placeholder="Unidade de medida" >
                        </div>
                    </div>
                    <div class="col-md-12 mb-3">
                        <div class="input-group">
                            <input type="text" class="form-control" id="simbolo" value="<?php if(isset($ClienteData['simbolo'])) echo $ClienteData['simbolo']; ?>" placeholder="Simbolo da unidade" >
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-8 mb-3">

                    </div>
                    <div class="col-md-4 mb-3">
                        <input type="submit" class="btn btn-primary" onclick="UnidadeCreate(<?= $id_db_settings ?>)" value="Salvar"/>
                    </div>
                </div>
            </div>
            <?php
            break;
        default:
            WSError("Ops: não encontramos a ação desejada!", WS_INFOR);
    endswitch;;
endif;
<div class="modal modal-blur fade" id="modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <form method="post" action="" name = "FormCreateCustomer"  enctype="multipart/form-data" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Adicionar novo cliente</h5>
                <a href="#" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></a>
            </div>
            <div class="modal-body">
                <div class="mb-3"><div id="getResult"></div></div>
                <div class="col-md-12">
                    <div class="mb-3">
                        <label class="form-label">Cliente</label>
                        <input name="nome" id="nome" class="form-control" placeholder="Cliente"  value="<?php if (!empty($ClienteData['nome'])) echo $ClienteData['nome']; ?>" type="text">
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label class="form-label">NIF</label>
                            <input type="text" id="nif"  class="form-control " placeholder="NIF" name="nif" value="<?php if (!empty($ClienteData['nif'])) echo $ClienteData['nif']; ?>">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label class="form-label">Telefone</label>
                            <input type="text" id="telefone" class="form-control" placeholder="Telefone" name="telefone" value="<?php if (!empty($ClienteData['telefone'])) echo $ClienteData['telefone']; ?>">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label class="form-label">E-mail</label>
                            <input type="email" id="email" class="form-control " placeholder="Telefone" name="email" value="<?php if (!empty($ClienteData['email'])) echo $ClienteData['email']; ?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label class="form-label">Endereço</label>
                            <input type="text"  id="endereco" class="form-control " placeholder="Endereço" name="endereco" value="<?php if (!empty($ClienteData['endereco'])) echo $ClienteData['endereco']; ?>">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label class="form-label">Província</label>
                            <select name="city" id="city" class="form-control">
                                <option value="Bengo"  <?php if (isset($ClienteData['city']) && $ClienteData['city'] == 'Bengo') echo 'selected="selected"'; ?>>Bengo</option>
                                <option value="Benguela"  <?php if (isset($ClienteData['city']) && $ClienteData['city'] == 'Benguela') echo 'selected="selected"'; ?>>Benguela</option>
                                <option value="Bié"  <?php if (isset($ClienteData['city']) && $ClienteData['city'] == 'Bié') echo 'selected="selected"'; ?>>Bié</option>
                                <option value="Cabinda"  <?php if (isset($ClienteData['city']) && $ClienteData['city'] == 'Cabinda') echo 'selected="selected"'; ?>>Cabinda</option>
                                <option value="Cuando Cubango"  <?php if (isset($ClienteData['city']) && $ClienteData['city'] == 'Cuando Cubango') echo 'selected="selected"'; ?>>Cuando Cubango</option>
                                <option value="Cunene"  <?php if (isset($ClienteData['city']) && $ClienteData['city'] == 'Cunene') echo 'selected="selected"'; ?>>Cunene</option>
                                <option value="Huambo"  <?php if (isset($ClienteData['city']) && $ClienteData['city'] == 'Huambo') echo 'selected="selected"'; ?>>Huambo</option>
                                <option value="Huíla"  <?php if (isset($ClienteData['city']) && $ClienteData['city'] == 'Huíla') echo 'selected="selected"'; ?>>Huíla</option>
                                <option value="Kwanza Sul"  <?php if (isset($ClienteData['city']) && $ClienteData['city'] == 'Kwanza Sul') echo 'selected="selected"'; ?>>Kwanza Sul</option>
                                <option value="Kwanza Norte"  <?php if (isset($ClienteData['city']) && $ClienteData['city'] == 'Kwanza Norte') echo 'selected="selected"'; ?>>Kwanza Norte</option>
                                <option value="Kwanza Norte"  <?php if (isset($ClienteData['city']) && $ClienteData['city'] == 'Kwanza Norte') echo 'selected="selected"'; ?>>Kwanza Norte</option>
                                <option value="Luanda" selected <?php if (isset($ClienteData['city']) && $ClienteData['city'] == 'Luanda') echo 'selected="selected"'; ?>>Luanda</option>
                                <option value="Lunda Norte"  <?php if (isset($ClienteData['city']) && $ClienteData['city'] == 'Lunda Norte') echo 'selected="selected"'; ?>>Lunda Norte</option>
                                <option value="Lunda Sul"  <?php if (isset($ClienteData['city']) && $ClienteData['city'] == 'Lunda Sul') echo 'selected="selected"'; ?>>Lunda Sul</option>
                                <option value="Malanje"  <?php if (isset($ClienteData['city']) && $ClienteData['city'] == 'Malanje') echo 'selected="selected"'; ?>>Malanje</option>
                                <option value="Moxico"  <?php if (isset($ClienteData['city']) && $ClienteData['city'] == 'Moxico') echo 'selected="selected"'; ?>>Moxico</option>
                                <option value="Namibe"  <?php if (isset($ClienteData['city']) && $ClienteData['city'] == 'Namibe') echo 'selected="selected"'; ?>> Namibe</option>
                                <option value="Uíge"  <?php if (isset($ClienteData['city']) && $ClienteData['city'] == 'Uíge') echo 'selected="selected"'; ?>>Uíge</option>
                                <option value="Zaire"  <?php if (isset($ClienteData['city']) && $ClienteData['city'] == 'Zaire') echo 'selected="selected"'; ?>>Zaire</option>
                            </select>

                        </div>
                    </div>


                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label class="form-label">Tipo de cadastro</label>
                            <select name="type" id="type" class="form-control">
                                <option value="Pessoa Física" <?php if (isset($ClienteData['type']) && $ClienteData['type'] == 'Pessoa Física') echo 'selected="selected"'; ?>>Pessoa Física</option>
                                <option value="Pessoa Jurídica" <?php if (isset($ClienteData['type']) && $ClienteData['type'] == 'Pessoa Jurídica') echo 'selected="selected"'; ?>>Pessoa Jurídica</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Observações</label>
                                <textarea name="obs" id="obs" class="form-control" placeholder="Observações"><?php if (!empty($ClienteData['obs'])) echo $ClienteData['obs']; ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" name="SendPostForm" class="btn btn-primary ms-auto">Salvar</button>
            </div>
        </form>
    </div>
</div>
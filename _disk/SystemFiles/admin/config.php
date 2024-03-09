<div class="page-wrapper">
    <div class="container-xl">
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="card">
                    <h2 class="card-header">
                        Configurações de Aspeto
                    </h2>
                    <div class="card-body">
                        <div id="getResult">
                            <?php
                            $ClienteData = filter_input_array(INPUT_POST, FILTER_DEFAULT);
                            if ($ClienteData && $ClienteData['SendPostFormL']):
                                $logoty['logotype'] = ($_FILES['logotype']['tmp_name'] ? $_FILES['logotype'] : null);
                                $icon['icon'] = ($_FILES['icon']['tmp_name'] ? $_FILES['icon'] : null);
                                $Satan = new SatanIsGod();
                                $Satan->UpdateConfig($logoty, $icon, $ClienteData);
                                if($Satan->getResult()):
                                    WSError($Satan->getError()[0], $Satan->getError()[1]);
                                else:
                                    WSError($Satan->getError()[0], $Satan->getError()[1]);
                                endif;
                            else:
                                $Read = new Read();
                                $Read->ExeRead("z_config");

                                if($Read->getResult() || $Read->getRowCount()):
                                    $ClienteData = $Read->getResult()[0];
                                endif;
                            endif;
                            ?>
                        </div>
                        <form method="post" action="" name="SendPostFormL" enctype="multipart/form-data">
                            <div class="row">
                                <div class="mb-3 col-4">
                                    <label class="form-label">Cor do Header</label>
                                    <div class="input-group input-group-flat">
                                        <input type="color" value="<?php if (!empty($ClienteData['color_1'])) echo $ClienteData['color_1']; ?>" class="form-control ps-1" name="color_1" placeholder="color_1">
                                    </div>
                                </div>
                                <div class="mb-3 col-4">
                                    <label class="form-label">Cor do Menu</label>
                                    <div class="input-group input-group-flat">
                                        <input type="color" value="<?php if (!empty($ClienteData['color_2'])) echo $ClienteData['color_2']; ?>" name="color_2" class="form-control ps-1" placeholder="color_2">
                                    </div>
                                </div>
                                <div class="mb-3 col-4">
                                    <label class="form-label">Fundo da Página</label>
                                    <div class="input-group input-group-flat">
                                        <input type="color" value="<?php if (!empty($ClienteData['color_3'])) echo $ClienteData['color_3']; ?>" name="color_3" class="form-control ps-1" placeholder="color_3">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3 col-6">
                                    <label class="form-label">Cor dos botões do menu</label>
                                    <div class="input-group input-group-flat">
                                        <input type="color" value="<?php if (!empty($ClienteData['color_41'])) echo $ClienteData['color_41']; ?>" class="form-control ps-1" name="color_41" placeholder="color_1">
                                    </div>
                                </div>
                                <div class="mb-3 col-6">
                                    <label class="form-label">Cor dos botões do sub-menu</label>
                                    <div class="input-group input-group-flat">
                                        <input type="color" value="<?php if (!empty($ClienteData['color_42'])) echo $ClienteData['color_42']; ?>" name="color_42" class="form-control ps-1" placeholder="color_2">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3 col-3">
                                    <label class="form-label">Logotipo</label>
                                    <div class="input-group input-group-flat">
                                        <input type="file" value="<?php if (!empty($ClienteData['logotype'])) echo $ClienteData['logotype']; ?>" name="logotype" class="form-control ps-1" placeholder="logotype">
                                    </div>
                                </div>
                                <div class="mb-3 col-3">
                                    <label class="form-label">Icon</label>
                                    <div class="input-group input-group-flat">
                                        <input type="file" value="<?php if (!empty($ClienteData['icon'])) echo $ClienteData['icon']; ?>" name="icon" class="form-control ps-1" placeholder="icon">
                                    </div>
                                </div>
                                <div class="mb-3 col-6">
                                    <label class="form-label">Nome do Software</label>
                                    <div class="input-group input-group-flat">
                                        <input type="text" value="<?php if (!empty($ClienteData['name'])) echo $ClienteData['name']; ?>" name="name" class="form-control ps-1" placeholder="Nome do software">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3 col-6">
                                    <label class="form-label">Email</label>
                                    <div class="input-group input-group-flat">
                                        <input type="text" value="<?php if (!empty($ClienteData['email'])) echo $ClienteData['email']; ?>" name="email" class="form-control ps-1" placeholder="Email">
                                    </div>
                                </div>
                                <div class="mb-3 col-6">
                                    <label class="form-label">Endereço</label>
                                    <div class="input-group input-group-flat">
                                        <input type="text" value="<?php if (!empty($ClienteData['endereco'])) echo $ClienteData['endereco']; ?>" name="endereco" class="form-control ps-1" placeholder="Endereço">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3 col-6">
                                    <label class="form-label">Telefone</label>
                                    <div class="input-group input-group-flat">
                                        <input type="text" value="<?php if (!empty($ClienteData['telefone'])) echo $ClienteData['telefone']; ?>" name="telefone" class="form-control ps-1" placeholder="Telefone">
                                    </div>
                                </div>
                                <div class="mb-3 col-6">
                                    <label class="form-label">Website</label>
                                    <div class="input-group input-group-flat">
                                        <input type="text" value="<?php if (!empty($ClienteData['website'])) echo $ClienteData['website']; ?>" name="website" class="form-control ps-1" placeholder="Website">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3 col-6">
                                    <label class="form-label">Nº de Certificado AGT</label>
                                    <div class="input-group input-group-flat">
                                        <input type="text" value="<?php if (!empty($ClienteData['agt'])) echo $ClienteData['agt']; ?>" name="agt" class="form-control ps-1" placeholder="Nº de Certificado AGT">
                                    </div>
                                </div>
                                <div class="mb-3 col-6">
                                    <label class="form-label">Nº de Certificado ISO</label>
                                    <div class="input-group input-group-flat">
                                        <input type="text" value="<?php if (!empty($ClienteData['iso'])) echo $ClienteData['iso']; ?>" name="iso" class="form-control ps-1" placeholder="Nº de Certificado ISO">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3 col-6">
                                    <label class="form-label">Nº da Versão do Software</label>
                                    <div class="input-group input-group-flat">
                                        <input type="text" value="<?php if (!empty($ClienteData['versao'])) echo $ClienteData['versao']; ?>" name="versao" class="form-control ps-1" placeholder="Nº da Versão do Software">
                                    </div>
                                </div>
                            </div>
                            <hr/>
                            <div class="row">
                                <div class="mb-3 col-6">
                                    <label class="form-label">Facebook</label>
                                    <div class="input-group input-group-flat">
                                        <input type="text" value="<?php if (!empty($ClienteData['facebook'])) echo $ClienteData['facebook']; ?>" name="facebook" class="form-control ps-1" placeholder="Facebook">
                                    </div>
                                </div>
                                <div class="mb-3 col-6">
                                    <label class="form-label">Instagram</label>
                                    <div class="input-group input-group-flat">
                                        <input type="text" value="<?php if (!empty($ClienteData['instagram'])) echo $ClienteData['instagram']; ?>" name="instagram" class="form-control ps-1" placeholder="Instagram">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3 col-6">
                                    <label class="form-label">Linkedin</label>
                                    <div class="input-group input-group-flat">
                                        <input type="text" value="<?php if (!empty($ClienteData['linkedin'])) echo $ClienteData['linkedin']; ?>" name="linkedin" class="form-control ps-1" placeholder="Linkedin">
                                    </div>
                                </div>
                                <div class="mb-3 col-6">
                                    <label class="form-label">Twitter</label>
                                    <div class="input-group input-group-flat">
                                        <input type="text" value="<?php if (!empty($ClienteData['twitter'])) echo $ClienteData['twitter']; ?>" name="twitter" class="form-control ps-1" placeholder="Twitter">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3 col-6">
                                    <label class="form-label">Youtube</label>
                                    <div class="input-group input-group-flat">
                                        <input type="text" value="<?php if (!empty($ClienteData['youtube'])) echo $ClienteData['youtube']; ?>" name="youtube" class="form-control ps-1" placeholder="Youtube">
                                    </div>
                                </div>
                                <div class="mb-3 col-6">
                                    <label class="form-label">WhatsApp</label>
                                    <div class="input-group input-group-flat">
                                        <input type="text" value="<?php if (!empty($ClienteData['whatsapp'])) echo $ClienteData['whatsapp']; ?>" name="whatsapp" class="form-control ps-1" placeholder="WhatsApp">
                                    </div>
                                </div>
                            </div>
                            <hr/>
                            <div class="col">
                                <div class="mb-3 col-12">
                                    <label class="form-label">Banco</label>
                                    <div class="input-group input-group-flat">
                                        <input type="text" value="<?php if (!empty($ClienteData['banco'])) echo $ClienteData['banco']; ?>" name="banco" class="form-control ps-1" placeholder="Banco">
                                    </div>
                                </div>
                                <div class="mb-3 col-12">
                                    <label class="form-label">Swift</label>
                                    <div class="input-group input-group-flat">
                                        <input type="text" value="<?php if (!empty($ClienteData['swift'])) echo $ClienteData['swift']; ?>" name="swift" class="form-control ps-1" placeholder="Swift">
                                    </div>
                                </div>
                                <div class="mb-3 col-12">
                                    <label class="form-label">NIB</label>
                                    <div class="input-group input-group-flat">
                                        <input type="text" value="<?php if (!empty($ClienteData['nib'])) echo $ClienteData['nib']; ?>" name="nib" class="form-control ps-1" placeholder="NIB">
                                    </div>
                                </div>
                                <div class="mb-3 col-12">
                                    <label class="form-label">IBAN</label>
                                    <div class="input-group input-group-flat">
                                        <input type="text" value="<?php if (!empty($ClienteData['iban'])) echo $ClienteData['iban']; ?>" name="iban" class="form-control ps-1" placeholder="IBAN">
                                    </div>
                                </div>
                            </div>
                            <hr/>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label class="form-label">Descrição</label>
                                        <textarea placeholder="Descrição" class="form-control" name="content" id="content"><?php if (!empty($ClienteData['content'])) echo htmlspecialchars($ClienteData['content']); ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <hr/>
                            <div class="col">
                                <div class="btn-list justify-content-end">
                                    <input type="submit" name="SendPostFormL" class="btn btn-primary" value="Salvar">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
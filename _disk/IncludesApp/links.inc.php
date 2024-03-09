<?php if($DB->CheckCpanelAndSettings($id_db_settings, $id_db_kwanzar)['atividade'] == 1 || $DB->CheckCpanelAndSettings($id_db_settings, $id_db_kwanzar)['atividade'] == 2 || $DB->CheckCpanelAndSettings($id_db_settings, $id_db_kwanzar)['atividade'] == 3): ?>
<!---li class="nav-item li<?php if (in_array('welcome', $linkto)) echo ' active';  ?>"><a class="nav-link" style="color: <?= $Index['color_41']; ?>!important;" href="panel.php?exe=welcome/welcome<?= $n; ?>" ><span class="nav-link-title">
	<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 14h14v-9h-14v16" /></svg>
            <?php
            if(!isset(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || empty(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || DBKwanzar::CheckConfig($id_db_settings)['Idioma'] == "Português"):
                echo "Bem-vindo";
            else:
                echo "Welcome";
            endif;
            ?></span></a></li--->
<?php endif; ?>

<li class="nav-item li<?php if (in_array('default', $linkto)) echo ' active';  ?>"><a class="nav-link" style="color: <?= $Index['color_41']; ?>!important;" href="panel.php?exe=default/home<?= $n; ?>" ><span class="nav-link-title">
	<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="13" r="2" /><line x1="13.45" y1="11.55" x2="15.5" y2="9.5" /><path d="M6.4 20a9 9 0 1 1 11.2 0z" /></svg>
             <?php
             if(!isset(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || empty(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || DBKwanzar::CheckConfig($id_db_settings)['Idioma'] == "Português"):
                 echo "Painel";
             else:
                 echo "Dashboard";
             endif;
             ?></span></a></li>

<?php if($DB->CheckCpanelAndSettings($id_db_settings, $id_db_kwanzar)['atividade'] == 1 || $DB->CheckCpanelAndSettings($id_db_settings, $id_db_kwanzar)['atividade'] == 2 || $DB->CheckCpanelAndSettings($id_db_settings, $id_db_kwanzar)['atividade'] == 3): ?>
<li class="nav-item dropdown li<?php if (in_array('local', $linkto)) echo ' active'; elseif(in_array('operator', $linkto)) echo ' active'; elseif(in_array('cadastro', $linkto)) echo ' active'; elseif(in_array('judith', $linkto)) echo ' active'; elseif(in_array('customer', $linkto)) echo ' active'; ?>">
    <a class="nav-link dropdown-toggle" style="color: <?= $Index['color_41']; ?>!important;" href="#navbar-base" data-bs-toggle="dropdown" role="button" aria-expanded="false" >
        <span class="nav-link-title">
	<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="9" /><line x1="9" y1="12" x2="15" y2="12" /><line x1="12" y1="9" x2="12" y2="15" /></svg>  <?php
            if(!isset(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || empty(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || DBKwanzar::CheckConfig($id_db_settings)['Idioma'] == "Português"):
                echo "Cadastramento";
            else:
                echo "Registration";
            endif;
            ?>
        </span>
    </a>
    <div class="dropdown-menu">
        <div class="dropdown-menu-columns">
            <div class="dropdown-menu-column">
                <?php if($DB->CheckCpanelAndSettings($id_db_settings, $id_db_kwanzar)['atividade'] == 5 || $DB->CheckCpanelAndSettings($id_db_settings, $id_db_kwanzar)['atividade'] == 9): ?>
                    <a class="dropdown-item" style="color: <?= $Index['color_42']; ?>!important;" href="panel.php?exe=judith/index<?= $n; ?>" ><span class="nav-link-title">
                             <?php
                             if(!isset(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || empty(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || DBKwanzar::CheckConfig($id_db_settings)['Idioma'] == "Português"):
                                 echo "Tipo de patrimonio";
                             else:
                                 echo "Type of heritage";
                             endif;
                             ?></span></a>
                    <a class="dropdown-item" style="color: <?= $Index['color_42']; ?>!important;" href="panel.php?exe=judith/joy<?= $n; ?>" ><span class="nav-link-title">
                             <?php
                             if(!isset(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || empty(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || DBKwanzar::CheckConfig($id_db_settings)['Idioma'] == "Português"):
                                 echo "Patrimonio";
                             else:
                                 echo "Patrimony";
                             endif;
                             ?></span></a>
                    <a class="dropdown-item" style="color: <?= $Index['color_42']; ?>!important;" href="panel.php?exe=judith/kinilson<?= $n; ?>" ><span class="nav-link-title">
                             <?php
                             if(!isset(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || empty(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || DBKwanzar::CheckConfig($id_db_settings)['Idioma'] == "Português"):
                                 echo "Local de Armazenamento";
                             else:
                                 echo "Storage Location";
                             endif;
                             ?></span></a>
                    <a class="dropdown-item" style="color: <?= $Index['color_42']; ?>!important;" href="panel.php?exe=judith/salito<?= $n; ?>" ><span class="nav-link-title">
                             <?php
                             if(!isset(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || empty(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || DBKwanzar::CheckConfig($id_db_settings)['Idioma'] == "Português"):
                                 echo "Funcionários";
                             else:
                                 echo "Employees";
                             endif;
                             ?></span></a>
                <?php endif; ?>
                <?php if(($DB->CheckCpanelAndSettings($id_db_settings, $id_db_kwanzar)['atividade'] >= 1 && $DB->CheckCpanelAndSettings($id_db_settings, $id_db_kwanzar)['atividade'] <= 4) || $DB->CheckCpanelAndSettings($id_db_settings, $id_db_kwanzar)['atividade'] == 9): ?>
                    <a class="dropdown-item" style="color: <?= $Index['color_42']; ?>!important;" href="panel.php?exe=customer/index<?= $n; ?>" ><span class="nav-link-title">
                             <?php
                             if(!isset(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || empty(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || DBKwanzar::CheckConfig($id_db_settings)['Idioma'] == "Português"):
                                 echo "Clientes";
                             else:
                                 echo "Customers";
                             endif;
                             ?></span></a>
                    <?php if(DBKwanzar::CheckConfig($id_db_settings)['DocModel'] == 4): ?>
                        <a class="dropdown-item" style="color: <?= $Index['color_42']; ?>!important;" href="panel.php?exe=obs/index<?= $n; ?>" ><span class="nav-link-title">
                                 <?php
                                 if(!isset(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || empty(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || DBKwanzar::CheckConfig($id_db_settings)['Idioma'] == "Português"):
                                     echo "Observações na Factura";
                                 else:
                                     echo "Notes on the Invoice";
                                 endif;
                                 ?></span></a>
                    <?php endif; ?>
                <?php endif; ?>
                <?php if($DB->CheckCpanelAndSettings($id_db_settings, $id_db_kwanzar)['atividade'] == 2 || $DB->CheckCpanelAndSettings($id_db_settings, $id_db_kwanzar)['atividade'] == 3): ?>
                    <?php if($DB->CheckCpanelAndSettings($id_db_settings, $id_db_kwanzar)['atividade'] == 2): ?>
                        <a class="dropdown-item" style="color: <?= $Index['color_42']; ?>!important;" href="panel.php?exe=local/index<?= $n; ?>" ><span class="nav-link-title">
                                 <?php
                                 if(!isset(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || empty(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || DBKwanzar::CheckConfig($id_db_settings)['Idioma'] == "Português"):
                                     echo "Local";
                                 else:
                                     echo "Local";
                                 endif;
                                 ?></span></a>
                    <?php endif; ?>
                    <a class="dropdown-item" style="color: <?= $Index['color_42']; ?>!important;" href="panel.php?exe=operator/index<?= $n; ?>" ><span class="nav-link-title">
                             <?php
                             if(!isset(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || empty(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || DBKwanzar::CheckConfig($id_db_settings)['Idioma'] == "Português"):
                                 echo "Operador";
                             else:
                                 echo "Operator";
                             endif;
                             ?></span></a>
                <?php endif; ?>

                <?php if($DB->CheckCpanelAndSettings($id_db_settings, $id_db_kwanzar)['atividade'] == 4): ?>
                    <?php if($userlogin['level'] == 1 || $userlogin['level'] >= 3): ?>
                        <a class="dropdown-item" style="color: <?= $Index['color_42']; ?>!important;" href="panel.php?exe=cadastro/fabricante/index<?= $n; ?>" ><span class="nav-link-title">
                                 <?php
                                 if(!isset(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || empty(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || DBKwanzar::CheckConfig($id_db_settings)['Idioma'] == "Português"):
                                     echo "Fabricante";
                                 else:
                                     echo "Manufacturer";
                                 endif;
                                 ?></span></a>
                        <a class="dropdown-item" style="color: <?= $Index['color_42']; ?>!important;" href="panel.php?exe=cadastro/veiculos/index<?= $n; ?>" ><span class="nav-link-title">
                                 <?php
                                 if(!isset(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || empty(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || DBKwanzar::CheckConfig($id_db_settings)['Idioma'] == "Português"):
                                     echo "Veículos";
                                 else:
                                     echo "Vehicles";
                                 endif;
                                 ?></span></a>
                    <?php endif; ?>
                    <?php if($userlogin['level'] >= 2): ?>
                        <a class="dropdown-item" style="color: <?= $Index['color_42']; ?>!important;" href="panel.php?exe=cadastro/fornecedores/index<?= $n; ?>" ><span class="nav-link-title">
                                 <?php
                                 if(!isset(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || empty(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || DBKwanzar::CheckConfig($id_db_settings)['Idioma'] == "Português"):
                                     echo "Fornecedores";
                                 else:
                                     echo "Suppliers";
                                 endif;
                                 ?></span></a>
                        <a class="dropdown-item" style="color: <?= $Index['color_42']; ?>!important;" href="panel.php?exe=cadastro/unidades/index<?= $n; ?>" ><span class="nav-link-title">
                                 <?php
                                 if(!isset(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || empty(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || DBKwanzar::CheckConfig($id_db_settings)['Idioma'] == "Português"):
                                     echo "Unidades";
                                 else:
                                     echo "Units";
                                 endif;
                                 ?></span></a>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</li>
<?php endif; ?>

<?php if($DB->CheckCpanelAndSettings($id_db_settings, $id_db_kwanzar)['atividade'] == 5 || $DB->CheckCpanelAndSettings($id_db_settings, $id_db_kwanzar)['atividade'] == 9): ?>
    <li class="nav-item li<?php if (in_array('Domingos', $linkto)) echo ' active';  ?>"><a  style="color: <?= $Index['color_41']; ?>!important;"class="nav-link" href="panel.php?exe=Domingos/nataniel<?= $n; ?>" ><span class="nav-link-title">
                 <?php
                 if(!isset(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || empty(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || DBKwanzar::CheckConfig($id_db_settings)['Idioma'] == "Português"):
                     echo "Operações Patrimonial";
                 else:
                     echo "Asset Operations";
                 endif;
                 ?></span></a></li>
    <li class="nav-item li<?php if (in_array('adilson', $linkto)) echo ' active';  ?>"><a  style="color: <?= $Index['color_41']; ?>!important;"class="nav-link" href="panel.php?exe=adilson/obama<?= $n; ?>" ><span class="nav-link-title">
                 <?php
                 if(!isset(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || empty(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || DBKwanzar::CheckConfig($id_db_settings)['Idioma'] == "Português"):
                     echo "Balanço Patrimonial";
                 else:
                     echo "Balance Sheet";
                 endif;
                 ?></span></a></li>
<?php endif; ?>
<?php if($userlogin['level'] >= 2): ?>
    <?php if(($DB->CheckCpanelAndSettings($id_db_settings, $id_db_kwanzar)['atividade'] >= 1 && $DB->CheckCpanelAndSettings($id_db_settings, $id_db_kwanzar)['atividade'] <= 4) || $DB->CheckCpanelAndSettings($id_db_settings, $id_db_kwanzar)['atividade'] == 9): ?>
        <li class="nav-item dropdown li<?php if (in_array('purchase', $linkto)) echo ' active'; elseif(in_array('product', $linkto)) echo ' active'; elseif(in_array('marcas', $linkto)) echo ' active'; elseif(in_array('category', $linkto)) echo ' active'; ?>">
            <a class="nav-link dropdown-toggle" style="color: <?= $Index['color_41']; ?>!important;" href="#navbar-base" data-bs-toggle="dropdown" role="button" aria-expanded="false" >
                <span class="nav-link-title">
	<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><polyline points="12 4 4 8 12 12 20 8 12 4" /><polyline points="4 12 12 16 20 12" /><polyline points="4 16 12 20 20 16" /></svg>
                     <?php
                     if(!isset(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || empty(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || DBKwanzar::CheckConfig($id_db_settings)['Idioma'] == "Português"):
                         echo "Produtos";
                     else:
                         echo "Products";
                     endif;
                     ?>
                </span>
            </a>
            <div class="dropdown-menu">
                <div class="dropdown-menu-columns">
                    <div class="dropdown-menu-column">
                        <a class="dropdown-item" style="color: <?= $Index['color_42']; ?>!important;" href="panel.php?exe=category/index<?= $n; ?>" >
                            <?php
                            if(!isset(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || empty(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || DBKwanzar::CheckConfig($id_db_settings)['Idioma'] == "Português"):
                                echo "Categoria";
                            else:
                                echo "Category";
                            endif;
                            ?></a>
                        <a class="dropdown-item" style="color: <?= $Index['color_42']; ?>!important;" href="panel.php?exe=marcas/index<?= $n; ?>" >
                            <?php
                            if(!isset(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || empty(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || DBKwanzar::CheckConfig($id_db_settings)['Idioma'] == "Português"):
                                echo "Marcas";
                            else:
                                echo "Brands";
                            endif;
                            ?></a>
                        <a class="dropdown-item" style="color: <?= $Index['color_42']; ?>!important;" href="panel.php?exe=product/index<?= $n; ?>" >
                            <?php
                            if(!isset(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || empty(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || DBKwanzar::CheckConfig($id_db_settings)['Idioma'] == "Português"):
                                echo "Itens";
                            else:
                                echo "Items";
                            endif;
                            ?></a>
                        <a class="dropdown-item" style="color: <?= $Index['color_42']; ?>!important;" href="panel.php?exe=product/stock<?= $n; ?>" >
                            <?php
                            if(!isset(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || empty(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || DBKwanzar::CheckConfig($id_db_settings)['Idioma'] == "Português"):
                                echo "Controle de Estoque";
                            else:
                                echo "Inventory control";
                            endif;
                            ?></a>
                    </div>
                </div>
            </div>
        </li>
    <?php endif; ?>
<?php endif; ?>
<?php if($DB->CheckCpanelAndSettings($id_db_settings, $id_db_kwanzar)['atividade'] == 4): ?>
    <li class="nav-item li<?php if (in_array('FO', $linkto)) echo ' active';  ?>"><a  style="color: <?= $Index['color_41']; ?>!important;"class="nav-link" href="panel.php?exe=FO/Fo<?= $n; ?>" ><span class="nav-link-title"
             <?php
             if(!isset(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || empty(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || DBKwanzar::CheckConfig($id_db_settings)['Idioma'] == "Português"):
                 echo "Folha de obra";
             else:
                 echo "Worksheet";
             endif;
             ?>></span></a></li>
<?php endif; ?>
<?php if($DB->CheckCpanelAndSettings($id_db_settings, $id_db_kwanzar)['atividade'] == 2): ?>
    <li class="nav-item li<?php if (in_array('PDV', $linkto)) echo ' active';  ?>"><a style="color: <?= $Index['color_41']; ?>!important;" class="nav-link" href="panel.php?exe=PDV/index<?= $n; ?>" ><span class="nav-link-title">
	<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="6" cy="19" r="2" /><circle cx="17" cy="19" r="2" /><path d="M17 17h-11v-14h-2" /><path d="M6 5l6.005 .429m7.138 6.573l-.143 .998h-13" /><path d="M15 6h6m-3 -3v6" /></svg>
                 <?php
                 if(!isset(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || empty(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || DBKwanzar::CheckConfig($id_db_settings)['Idioma'] == "Português"):
                     echo "POS";
                 else:
                     echo "POS";
                 endif;
                 ?></span></a></li>
<?php elseif($DB->CheckCpanelAndSettings($id_db_settings, $id_db_kwanzar)['atividade'] == 1 || $DB->CheckCpanelAndSettings($id_db_settings, $id_db_kwanzar)['atividade'] == 4 || $DB->CheckCpanelAndSettings($id_db_settings, $id_db_kwanzar)['atividade'] == 3 || $DB->CheckCpanelAndSettings($id_db_settings, $id_db_kwanzar)['atividade'] == 9): ?>
    <li class="nav-item li<?php if (in_array('POS', $linkto)) echo ' active';  ?>"><a style="color: <?= $Index['color_41']; ?>!important;" class="nav-link" href="panel.php?exe=POS/invoice<?= $n; ?>" ><span class="nav-link-title"><!-- Download SVG icon from http://tabler-icons.io/i/shopping-cart-plus -->
	<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="6" cy="19" r="2" /><circle cx="17" cy="19" r="2" /><path d="M17 17h-11v-14h-2" /><path d="M6 5l6.005 .429m7.138 6.573l-.143 .998h-13" /><path d="M15 6h6m-3 -3v6" /></svg>
                 <?php
                 if(!isset(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || empty(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || DBKwanzar::CheckConfig($id_db_settings)['Idioma'] == "Português"):
                     echo "Facturas";
                 else:
                     echo "Invoices";
                 endif;
                 ?></span></a></li>
    <?php if($DB->CheckCpanelAndSettings($id_db_settings, $id_db_kwanzar)['atividade'] == 1 ||  $DB->CheckCpanelAndSettings($id_db_settings, $id_db_kwanzar)['atividade'] == 4 || $DB->CheckCpanelAndSettings($id_db_settings, $id_db_kwanzar)['atividade'] == 9): ?>
        <li class="nav-item li<?php if (in_array('proforma', $linkto)) echo ' active';  ?>"><a  style="color: <?= $Index['color_41']; ?>!important;"class="nav-link" href="panel.php?exe=proforma/proforma<?= $n; ?>" ><span class="nav-link-title">
	<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M21 12v3a1 1 0 0 1 -1 1h-16a1 1 0 0 1 -1 -1v-10a1 1 0 0 1 1 -1h9" /><line x1="7" y1="20" x2="17" y2="20" /><line x1="9" y1="16" x2="9" y2="20" /><line x1="15" y1="16" x2="15" y2="20" /><path d="M17 4h4v4" /><path d="M16 9l5 -5" /></svg>  <?php
                    if(!isset(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || empty(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || DBKwanzar::CheckConfig($id_db_settings)['Idioma'] == "Português"):
                        echo "Proformas";
                    else:
                        echo "Proformas";
                    endif;
                    ?></span></a></li>
    <?php endif; ?>
<?php endif; ?>

<?php if($userlogin['level'] >= 3): ?>
<li class="nav-item dropdown li<?php if (in_array('purchase', $linkto)) echo ' active'; elseif(in_array('caixa', $linkto)) echo ' active'; elseif(in_array('sangrar', $linkto)) echo ' active'; elseif(in_array('entrada_e_saida', $linkto)) echo ' active'; ?>">
    <a class="nav-link dropdown-toggle" style="color: <?= $Index['color_41']; ?>!important;" href="#navbar-base" data-bs-toggle="dropdown" role="button" aria-expanded="false" >
        <span class="nav-link-title">
	<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><rect x="4" y="3" width="16" height="18" rx="2" /><rect x="8" y="7" width="8" height="3" rx="1" /><line x1="8" y1="14" x2="8" y2="14.01" /><line x1="12" y1="14" x2="12" y2="14.01" /><line x1="16" y1="14" x2="16" y2="14.01" /><line x1="8" y1="17" x2="8" y2="17.01" /><line x1="12" y1="17" x2="12" y2="17.01" /><line x1="16" y1="17" x2="16" y2="17.01" /></svg>
             <?php
             if(!isset(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || empty(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || DBKwanzar::CheckConfig($id_db_settings)['Idioma'] == "Português"):
                 echo "Caixa";
             else:
                 echo "Box";
             endif;
             ?>
        </span>
    </a>
    <div class="dropdown-menu">
        <div class="dropdown-menu-columns">
            <div class="dropdown-menu-column">
                <a class="dropdown-item" style="color: <?= $Index['color_42']; ?>!important;" href="panel.php?exe=sangrar/index<?= $n; ?>" > <?php
                    if(!isset(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || empty(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || DBKwanzar::CheckConfig($id_db_settings)['Idioma'] == "Português"):
                        echo "Sangrar Caixa";
                    else:
                        echo "Bleed Box";
                    endif;
                    ?></a>
                <a class="dropdown-item" style="color: <?= $Index['color_42']; ?>!important;" href="panel.php?exe=entrada_e_saida/index<?= $n; ?>" > <?php
                    if(!isset(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || empty(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || DBKwanzar::CheckConfig($id_db_settings)['Idioma'] == "Português"):
                        echo "Entrada e Saída de Caixa";
                    else:
                        echo "Cash Inflow and Outflow";
                    endif;
                    ?></a>
            </div>
        </div>
    </div>
</li>
<?php endif; ?>

<?php if($DB->CheckCpanelAndSettings($id_db_settings, $id_db_kwanzar)['atividade'] == 1 || $DB->CheckCpanelAndSettings($id_db_settings, $id_db_kwanzar)['atividade'] == 2 || $DB->CheckCpanelAndSettings($id_db_settings, $id_db_kwanzar)['atividade'] == 3): ?>
<li class="nav-item dropdown li<?php if (in_array('reports', $linkto)) echo ' active'; ?>">
    <a class="nav-link dropdown-toggle" style="color: <?= $Index['color_41']; ?>!important;" href="#navbar-base" data-bs-toggle="dropdown" role="button" aria-expanded="false" >
        <span class="nav-link-title">
	<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 21v-16a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v16l-3 -2l-2 2l-2 -2l-2 2l-2 -2l-3 2m4 -14h6m-6 4h6m-2 4h2" /></svg>  <?php
            if(!isset(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || empty(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || DBKwanzar::CheckConfig($id_db_settings)['Idioma'] == "Português"):
                echo "Relatórios";
            else:
                echo "Reports";
            endif;
            ?>
        </span>
    </a>
    <div class="dropdown-menu">
        <div class="dropdown-menu-columns">
            <div class="dropdown-menu-column">
                <?php if(($DB->CheckCpanelAndSettings($id_db_settings, $id_db_kwanzar)['atividade'] >= 1 && $DB->CheckCpanelAndSettings($id_db_settings, $id_db_kwanzar)['atividade'] <= 4) || $DB->CheckCpanelAndSettings($id_db_settings, $id_db_kwanzar)['atividade'] == 9): ?>
                    <a  class="dropdown-item" style="color: <?= $Index['color_42']; ?>!important;" href="panel.php?exe=reports/sales<?= $n; ?>" ><span class="nav-link-title"> <?php
                            if(!isset(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || empty(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || DBKwanzar::CheckConfig($id_db_settings)['Idioma'] == "Português"):
                                echo "Movimentos de Caixa";
                            else:
                                echo "Cash Movements";
                            endif;
                            ?></span></a>
                    <?php if($userlogin['level'] >= 2): ?>
                        <a  class="dropdown-item" style="color: <?= $Index['color_42']; ?>!important;" href="panel.php?exe=reports/stock<?= $n; ?>" ><span class="nav-link-title"> <?php
                                if(!isset(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || empty(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || DBKwanzar::CheckConfig($id_db_settings)['Idioma'] == "Português"):
                                    echo "Mapa de Stock";
                                else:
                                    echo "Stock Map";
                                endif;
                                ?></span></a>
                        <a  class="dropdown-item" style="color: <?= $Index['color_42']; ?>!important;" href="panel.php?exe=reports/stock-in<?= $n; ?>" ><span class="nav-link-title"> <?php
                                if(!isset(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || empty(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || DBKwanzar::CheckConfig($id_db_settings)['Idioma'] == "Português"):
                                    echo "Movimentos de Stock";
                                else:
                                    echo "Stock Movements";
                                endif;
                                ?></span></a>
                        <?php if($userlogin['level'] >= 3): ?>
                            <a  class="dropdown-item" style="color: <?= $Index['color_42']; ?>!important;" href="panel.php?exe=reports/itens<?= $n; ?>" ><span class="nav-link-title"> <?php
                                    if(!isset(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || empty(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || DBKwanzar::CheckConfig($id_db_settings)['Idioma'] == "Português"):
                                        echo "Itens Vendidos";
                                    else:
                                        echo "Items Sold";
                                    endif;
                                    ?></span></a>
                        <?php endif; ?>
                    <?php endif; ?>
                    <a  class="dropdown-item" style="color: <?= $Index['color_42']; ?>!important;" href="panel.php?exe=reports/extract<?= $n; ?>" ><span class="nav-link-title"> <?php
                            if(!isset(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || empty(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || DBKwanzar::CheckConfig($id_db_settings)['Idioma'] == "Português"):
                                echo "Extrato de conta";
                            else:
                                echo "Account statement";
                            endif;
                            ?></span></a>
                <?php endif; ?>
                <?php if($DB->CheckCpanelAndSettings($id_db_settings, $id_db_kwanzar)['atividade'] == 4): ?>
                    <a class="dropdown-item" style="color: <?= $Index['color_42']; ?>!important;" href="panel.php?exe=reports/ReFa<?= $n; ?>" ><span class="nav-link-title"> <?php
                            if(!isset(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || empty(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || DBKwanzar::CheckConfig($id_db_settings)['Idioma'] == "Português"):
                                echo "Relatórios da oficina";
                            else:
                                echo "Workshop reports";
                            endif;
                            ?></span></a>
                <?php endif; ?>
                <?php if($userlogin['level'] >= 3): ?>
                <a  class="dropdown-item" style="color: <?= $Index['color_42']; ?>!important;" href="panel.php?exe=reports/EntradaESaida<?= $n; ?>" ><span class="nav-link-title"> <?php
                        if(!isset(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || empty(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || DBKwanzar::CheckConfig($id_db_settings)['Idioma'] == "Português"):
                            echo "Entrada e Saída de Valores";
                        else:
                            echo "Input and Output of Values";
                        endif;
                        ?></span></a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</li>
<?php endif; ?>

<?php if($DB->CheckCpanelAndSettings($id_db_settings, $id_db_kwanzar)['atividade'] == 19): ?>

    <li class="nav-item li<?php if (in_array('schedule', $linkto)) echo ' active';  ?>">
        <a class="nav-link" style="color: <?= $Index['color_41']; ?>!important;" href="panel.php?exe=schedule/index<?= $n; ?>" >
            <span class="nav-link-title">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M19 3h-4a2 2 0 0 0 -2 2v12a4 4 0 0 0 8 0v-12a2 2 0 0 0 -2 -2" /><path d="M13 7.35l-2 -2a2 2 0 0 0 -2.828 0l-2.828 2.828a2 2 0 0 0 0 2.828l9 9" /><path d="M7.3 13h-2.3a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h12" /><line x1="17" y1="17" x2="17" y2="17.01" /></svg>
                 <?php
                 if(!isset(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || empty(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || DBKwanzar::CheckConfig($id_db_settings)['Idioma'] == "Português"):
                     echo "Agenda";
                 else:
                     echo "Schedule";
                 endif;
                 ?>
            </span>
        </a>
    </li>

    <li class="nav-item li<?php if (in_array('patient', $linkto)) echo ' active';  ?>">
        <a class="nav-link" style="color: <?= $Index['color_41']; ?>!important;" href="panel.php?exe=patient/index<?= $n; ?>" >
            <span class="nav-link-title">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="9" cy="7" r="4" /><path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" /><path d="M16 11h6m-3 -3v6" /></svg>
                 <?php
                 if(!isset(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || empty(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || DBKwanzar::CheckConfig($id_db_settings)['Idioma'] == "Português"):
                     echo "Pacientes";
                 else:
                     echo "Patients";
                 endif;
                 ?>
            </span>
        </a>
    </li>

    <?php if($level == 1 || $level >= 4): ?>
        <li class="nav-item li<?php if (in_array('POS', $linkto)) echo ' active';  ?>"><a style="color: <?= $Index['color_41']; ?>!important;" class="nav-link" href="panel.php?exe=POS/invoice<?= $n; ?>" ><span class="nav-link-title"><!-- Download SVG icon from http://tabler-icons.io/i/shopping-cart-plus -->
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="6" cy="19" r="2" /><circle cx="17" cy="19" r="2" /><path d="M17 17h-11v-14h-2" /><path d="M6 5l6.005 .429m7.138 6.573l-.143 .998h-13" /><path d="M15 6h6m-3 -3v6" /></svg>  <?php
                    if(!isset(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || empty(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || DBKwanzar::CheckConfig($id_db_settings)['Idioma'] == "Português"):
                        echo "Facturas";
                    else:
                        echo "Invoices";
                    endif;
                    ?></span></a></li>


        <li class="nav-item li<?php if (in_array('proforma', $linkto)) echo ' active';  ?>"><a  style="color: <?= $Index['color_41']; ?>!important;"class="nav-link" href="panel.php?exe=proforma/proforma<?= $n; ?>" ><span class="nav-link-title"><!-- Download SVG icon from http://tabler-icons.io/i/screen-share -->
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M21 12v3a1 1 0 0 1 -1 1h-16a1 1 0 0 1 -1 -1v-10a1 1 0 0 1 1 -1h9" /><line x1="7" y1="20" x2="17" y2="20" /><line x1="9" y1="16" x2="9" y2="20" /><line x1="15" y1="16" x2="15" y2="20" /><path d="M17 4h4v4" /><path d="M16 9l5 -5" /></svg>  <?php
                    if(!isset(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || empty(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || DBKwanzar::CheckConfig($id_db_settings)['Idioma'] == "Português"):
                        echo "Proformas";
                    else:
                        echo "Proformas";
                    endif;
                    ?></span></a></li>
    <?php endif; ?>

    <?php if($level >= 3): ?>
        <li class="nav-item dropdown li<?php if (in_array('reports', $linkto)) echo ' active'; ?>">
            <a class="nav-link dropdown-toggle" style="color: <?= $Index['color_41']; ?>!important;" href="#navbar-base" data-bs-toggle="dropdown" role="button" aria-expanded="false" >
        <span class="nav-link-title">
            <!-- Download SVG icon from http://tabler-icons.io/i/receipt -->
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 21v-16a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v16l-3 -2l-2 2l-2 -2l-2 2l-2 -2l-3 2m4 -14h6m-6 4h6m-2 4h2" /></svg>  <?php
            if(!isset(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || empty(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || DBKwanzar::CheckConfig($id_db_settings)['Idioma'] == "Português"):
                echo "Relatórios";
            else:
                echo "Reports";
            endif;
            ?>
                </span>
            </a>
            <div class="dropdown-menu">
                <div class="dropdown-menu-columns">
                    <div class="dropdown-menu-column">
                        <a  class="dropdown-item" style="color: <?= $Index['color_42']; ?>!important;" href="panel.php?exe=reports/sales<?= $n; ?>" ><span class="nav-link-title"> <?php
                                if(!isset(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || empty(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || DBKwanzar::CheckConfig($id_db_settings)['Idioma'] == "Português"):
                                    echo "Movimentos de Caixa";
                                else:
                                    echo "Cash Movements";
                                endif;
                                ?></span></a>
                        <?php if($level == 1 || $level >= 4): ?>
                            <a  class="dropdown-item" style="color: <?= $Index['color_42']; ?>!important;" href="panel.php?exe=reports/itens<?= $n; ?>" ><span class="nav-link-title"> <?php
                                    if(!isset(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || empty(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || DBKwanzar::CheckConfig($id_db_settings)['Idioma'] == "Português"):
                                        echo "Itens Vendidos";
                                    else:
                                        echo "Items Sold";
                                    endif;
                                    ?></span></a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </li>
    <?php endif; ?>

    <?php if($level == 1 || $level == 2 || $level >= 4): ?>
        <li class="nav-item dropdown li<?php if (in_array('definitions', $linkto) || in_array('fixos', $linkto)) echo ' active';  ?>">
            <a class="nav-link dropdown-toggle" style="color: <?= $Index['color_41']; ?>!important;" href="#navbar-base" data-bs-toggle="dropdown" role="button" aria-expanded="false" >
            <span class="nav-link-title">
                <!-- Download SVG icon from http://tabler-icons.io/i/chart-candle -->
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><rect x="4" y="6" width="4" height="5" rx="1" /><line x1="6" y1="4" x2="6" y2="6" /><line x1="6" y1="11" x2="6" y2="20" /><rect x="10" y="14" width="4" height="5" rx="1" /><line x1="12" y1="4" x2="12" y2="14" /><line x1="12" y1="19" x2="12" y2="20" /><rect x="16" y="5" width="4" height="6" rx="1" /><line x1="18" y1="4" x2="18" y2="5" /><line x1="18" y1="11" x2="18" y2="20" /></svg>
                 <?php
                 if(!isset(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || empty(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || DBKwanzar::CheckConfig($id_db_settings)['Idioma'] == "Português"):
                     echo "Administração";
                 else:
                     echo "Administration";
                 endif;
                 ?>
            </span>
            </a>
            <div class="dropdown-menu">
                <div class="dropdown-menu-columns">
                    <div class="dropdown-menu-column">
                        <?php if($level >= 4): ?>
                            <a href="panel.php?exe=definitions/index_porcentagem<?= $n; ?>" class="dropdown-item" style="color: <?= $Index['color_42']; ?>!important;"> <?php
                                if(!isset(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || empty(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || DBKwanzar::CheckConfig($id_db_settings)['Idioma'] == "Português"):
                                    echo "Porcentagem de ganhos (Médicos)";
                                else:
                                    echo "Earnings Percentage (Doctors)";
                                endif;
                                ?></a>
                            <div class="dropdown-divider"></div>
                        <?php endif; ?>

                        <?php if($level == 1 || $level >= 4): ?>
                            <a href="panel.php?exe=definitions/index_category<?= $n; ?>" class="dropdown-item" style="color: <?= $Index['color_42']; ?>!important;"> <?php
                                if(!isset(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || empty(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || DBKwanzar::CheckConfig($id_db_settings)['Idioma'] == "Português"):
                                    echo "Categorias dos Procedimentos";
                                else:
                                    echo "Procedure Categories";
                                endif;
                                ?></a>
                            <a href="panel.php?exe=definitions/index<?= $n; ?>" class="dropdown-item" style="color: <?= $Index['color_42']; ?>!important;"> <?php
                                if(!isset(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || empty(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || DBKwanzar::CheckConfig($id_db_settings)['Idioma'] == "Português"):
                                    echo "Procedimentos";
                                else:
                                    echo "Procedures";
                                endif;
                                ?></a>
                            <div class="dropdown-divider"></div>
                        <?php endif; ?>

                        <?php if($level == 2 || $level >= 4): ?>
                            <a href="panel.php?exe=fixos/indexx<?= $n; ?>" class="dropdown-item" style="color: <?= $Index['color_42']; ?>!important;"> <?php
                                if(!isset(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || empty(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || DBKwanzar::CheckConfig($id_db_settings)['Idioma'] == "Português"):
                                    echo "Inventário dos Materiais Fixos";
                                else:
                                    echo "Fixed Materials Inventory";
                                endif;
                                ?></a>
                            <a href="panel.php?exe=relatorios_fixos/relatorios_fixos<?= $n; ?>" class="dropdown-item" style="color: <?= $Index['color_42']; ?>!important;"> <?php
                                if(!isset(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || empty(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || DBKwanzar::CheckConfig($id_db_settings)['Idioma'] == "Português"):
                                    echo "Relatório dos Materiais Fixos";
                                else:
                                    echo "Fixed Materials Report";
                                endif;
                                ?></a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </li>
    <?php endif; ?>
<?php endif; ?>

<li class="nav-item dropdown li<?php if (in_array('settings', $linkto)) echo ' active';  ?>">
    <a class="nav-link dropdown-toggle" style="color: <?= $Index['color_41']; ?>!important;" href="#navbar-base" data-bs-toggle="dropdown" role="button" aria-expanded="false" >
        <span class="nav-link-title">
            <!-- Download SVG icon from http://tabler-icons.io/i/settings -->
	<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z" /><circle cx="12" cy="12" r="3" /></svg>  <?php
            if(!isset(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || empty(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || DBKwanzar::CheckConfig($id_db_settings)['Idioma'] == "Português"):
                echo "Configurações";
            else:
                echo "settings";
            endif;
            ?>
        </span>
    </a>
    <div class="dropdown-menu">
        <div class="dropdown-menu-columns">
            <div class="dropdown-menu-column">
                <?php
                if($DB->CheckCpanelAndSettings($id_db_settings, $id_db_kwanzar)['atividade'] == 1  || $DB->CheckCpanelAndSettings($id_db_settings, $id_db_kwanzar)['atividade'] == 2 || $DB->CheckCpanelAndSettings($id_db_settings, $id_db_kwanzar)['atividade'] == 3):
                    $xLevel = $level >= 3;
                endif;

                if($DB->CheckCpanelAndSettings($id_db_settings, $id_db_kwanzar)['atividade'] == 19):
                    $xLevel = $level >= 4;
                endif;

                if($xLevel): ?>
                    <a href="panel.php?exe=settings/System_Settings<?= $n; ?>" class="dropdown-item" style="color: <?= $Index['color_42']; ?>!important;"> <?php
                        if(!isset(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || empty(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || DBKwanzar::CheckConfig($id_db_settings)['Idioma'] == "Português"):
                            echo "Definições do sistema";
                        else:
                            echo "System Settings";
                        endif;
                        ?></a>
                    <a href="panel.php?exe=settings/company<?= $n; ?>" class="dropdown-item" style="color: <?= $Index['color_42']; ?>!important;"> <?php
                        if(!isset(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || empty(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || DBKwanzar::CheckConfig($id_db_settings)['Idioma'] == "Português"):
                            echo "Dados da empresa";
                        else:
                            echo "Company data";
                        endif;
                        ?></a>
                    <a href="panel.php?exe=settings/BankData<?= $n; ?>" class="dropdown-item" style="color: <?= $Index['color_42']; ?>!important;"> <?php
                        if(!isset(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || empty(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || DBKwanzar::CheckConfig($id_db_settings)['Idioma'] == "Português"):
                            echo "Dados bancário";
                        else:
                            echo "Banking details";
                        endif;
                        ?></a>
                    <a href="panel.php?exe=settings/logotype<?= $n; ?>" class="dropdown-item" style="color: <?= $Index['color_42']; ?>!important;"> <?php
                        if(!isset(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || empty(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || DBKwanzar::CheckConfig($id_db_settings)['Idioma'] == "Português"):
                            echo "Logotipo";
                        else:
                            echo "Logo";
                        endif;
                        ?></a>
                    <?php if($DB->CheckCpanelAndSettings($id_db_settings, $id_db_kwanzar)['atividade'] == 1 || $DB->CheckCpanelAndSettings($id_db_settings, $id_db_kwanzar)['atividade'] == 3): ?>
                        <a href="panel.php?exe=settings/gallery<?= $n; ?>" class="dropdown-item" style="color: <?= $Index['color_42']; ?>!important;"> <?php
                            if(!isset(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || empty(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || DBKwanzar::CheckConfig($id_db_settings)['Idioma'] == "Português"):
                                echo "Galeria";
                            else:
                                echo "Gallery";
                            endif;
                            ?></a>
                    <?php endif; ?>
                    <a href="panel.php?exe=settings/taxtable<?= $n; ?>" class="dropdown-item" style="color: <?= $Index['color_42']; ?>!important;"> <?php
                        if(!isset(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || empty(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || DBKwanzar::CheckConfig($id_db_settings)['Idioma'] == "Português"):
                            echo "Impostos";
                        else:
                            echo "Taxes";
                        endif;
                        ?></a>
                    <?php if($Beautiful["ps3"] != 0): ?>
                        <a href="panel.php?exe=settings/import<?= $n; ?>" class="dropdown-item" style="color: <?= $Index['color_42']; ?>!important;"> <?php
                            if(!isset(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || empty(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || DBKwanzar::CheckConfig($id_db_settings)['Idioma'] == "Português"):
                                echo "Importaçāo & Exportaçāo de dados";
                            else:
                                echo "Data import & export";
                            endif;
                            ?></a>
                        <a href="panel.php?exe=settings/export_saft<?= $n; ?>" class="dropdown-item" style="color: <?= $Index['color_42']; ?>!important;"> <?php
                            if(!isset(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || empty(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || DBKwanzar::CheckConfig($id_db_settings)['Idioma'] == "Português"):
                                echo "Exportação de SAFT";
                            else:
                                echo "SAFT Export";
                            endif;
                            ?></a>
                    <?php endif; ?>
                    <a href="panel.php?exe=settings/notifications<?= $n; ?>" class="dropdown-item" style="color: <?= $Index['color_42']; ?>!important;"> <?php
                        if(!isset(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || empty(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || DBKwanzar::CheckConfig($id_db_settings)['Idioma'] == "Português"):
                            echo "Notificações";
                        else:
                            echo "Notifications";
                        endif;
                        ?></a>
                    <a href="panel.php?exe=settings/activity<?= $n; ?>" class="dropdown-item" style="color: <?= $Index['color_42']; ?>!important;"> <?php
                        if(!isset(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || empty(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || DBKwanzar::CheckConfig($id_db_settings)['Idioma'] == "Português"):
                            echo "Registro de atividade";
                        else:
                            echo "Activity log";
                        endif;
                        ?></a>
                    <a href="panel.php?exe=settings/licence<?= $n; ?>" class="dropdown-item" style="color: <?= $Index['color_42']; ?>!important;"> <?php
                        if(!isset(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || empty(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || DBKwanzar::CheckConfig($id_db_settings)['Idioma'] == "Português"):
                            echo "Licença";
                        else:
                            echo "License";
                        endif;
                        ?></a>
                    <?php if($Beautiful["ps3"] != 0 || $level == 5): ?>
                        <a href="panel.php?exe=settings/users<?= $n; ?>" class="dropdown-item" style="color: <?= $Index['color_42']; ?>!important;"> <?php
                            if(!isset(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || empty(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || DBKwanzar::CheckConfig($id_db_settings)['Idioma'] == "Português"):
                                echo "Utilizadores";
                            else:
                                echo "Users";
                            endif;
                            ?></a>
                    <?php endif; ?>
                <?php endif; ?>
                <a href="panel.php?exe=settings/account_configurations<?= $n; ?>" class="dropdown-item" style="color: <?= $Index['color_42']; ?>!important;"> <?php
                    if(!isset(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || empty(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || DBKwanzar::CheckConfig($id_db_settings)['Idioma'] == "Português"):
                        echo "Preferências do usuário";
                    else:
                        echo "User Preferences";
                    endif;
                    ?></a>
                <a href="panel.php?exe=settings/profile<?= $n; ?>" class="dropdown-item" style="color: <?= $Index['color_42']; ?>!important;"> <?php
                    if(!isset(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || empty(DBKwanzar::CheckConfig($id_db_settings)['Idioma']) || DBKwanzar::CheckConfig($id_db_settings)['Idioma'] == "Português"):
                        echo "Meu perfil";
                    else:
                        echo "My profile";
                    endif;
                    ?></a>
            </div>
        </div>
    </div>
</li>
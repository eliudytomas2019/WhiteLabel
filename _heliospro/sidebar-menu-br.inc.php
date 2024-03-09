<?php
/**
 * Created by PhpStorm.
 * User: Kwanzar Soft
 * Date: 01/10/2020
 * Time: 21:40
 */

?>
<div class="sidebar sidebar-style-2">
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-primary">
                <li class="nav-item li<?php if(in_array('4c85378ea8b676a0d1b3dfba0c30ef5e', $linkto)) echo ' active';  ?>">
                    <a data-toggle="collapse" href="#dashboard" class="collapsed" aria-expanded="false">
                        <i class="fas fa-cookie-bite"></i>
                        <p>Programador</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="dashboard">
                        <ul class="nav nav-collapse">
                            <li>
                                <a href="<?= HOME; ?>Br.inc.php?exe=4c85378ea8b676a0d1b3dfba0c30ef5e/03b8e389068f06106a1fc841a8d4b545">
                                    <span class="sub-item">Estatisticas e Backup</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?= HOME; ?>Br.inc.php?exe=4c85378ea8b676a0d1b3dfba0c30ef5e/df8785ec1b3f3a17e8279fac030d33cb/04299e213f5391ede16784de41dd847d">
                                    <span class="sub-item">Operações Impresarial</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item li<?php if (in_array('face', $linkto)) echo ' active';  ?>">
                    <a href="<?= HOME; ?>Br.inc.php?exe=face/index" >
                        <i class="fas fa-bezier-curve"></i>
                        <p>Face</p>
                    </a>
                </li>

            </ul>
        </div>
    </div>
</div>

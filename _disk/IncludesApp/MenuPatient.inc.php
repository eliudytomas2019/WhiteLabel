<div class="d-lg-block col-lg-3">
    <ul class="nav nav-pills nav-vertical">
        <li class="nav-item"><a href="#" class="nav-link" style="font-weight: bold!important;">Menu</a></li>
        <li class="nav-item">
            <a href="panel.php?exe=patient/history<?= $n; ?>&postid=<?= $postid; ?>" class="nav-link <?php if(in_array("history", $linkto)) echo "active"; ?>">

                 Visão Geral
            </a>
        </li>
        <li class="nav-item">
            <a href="panel.php?exe=patient/contato<?= $n; ?>&postid=<?= $postid; ?>" class="nav-link <?php if(in_array("contato", $linkto)) echo "active"; ?>">

                Contato de Emergência
            </a>
        </li>
        <li class="nav-item">
            <a href="panel.php?exe=patient/Anamnese<?= $n; ?>&postid=<?= $postid; ?>" class="nav-link <?php if(in_array("Anamnese", $linkto)) echo "active"; ?>">

                Anamnese
            </a>
        </li>
        <li class="nav-item">
            <a href="panel.php?exe=patient/Orcamentos<?= $n; ?>&postid=<?= $postid; ?>" class="nav-link <?php if(in_array("Orcamentos", $linkto)) echo "active"; ?>">


                Orçamentos
            </a>
        </li>
        <li class="nav-item">
            <a href="panel.php?exe=patient/Tratamentos<?= $n; ?>&postid=<?= $postid; ?>" class="nav-link <?php if(in_array("Tratamentos", $linkto)) echo "active"; ?>">


                Tratamentos
            </a>
        </li>
        <li class="nav-item">
            <a href="panel.php?exe=patient/Documentos<?= $n; ?>&postid=<?= $postid; ?>" class="nav-link <?php if(in_array("Documentos", $linkto) || in_array("receita", $linkto) || in_array("justificativo", $linkto)) echo "active"; ?>">

                 Documentos
            </a>
        </li>
        <li class="nav-item">
            <a href="panel.php?exe=patient/Arquivos<?= $n; ?>&postid=<?= $postid; ?>" class="nav-link <?php if(in_array("Arquivos", $linkto)) echo "active"; ?>">

                Arquivos
            </a>
        </li>
    </ul>
</div>
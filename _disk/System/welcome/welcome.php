<div class="row row-cards">
    <div class="col-md-8">
        <div class="card mb-3">
            <div class="card-header">
                <h3 class="card-title">Assistente de Configuração</h3>
            </div>
            <div class="card-body">
                <iframe width="100%" height="415" src="https://www.youtube.com/embed/oE1WvFWUFmg" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                <?php if($level >= 3): ?><div class="col align-items-center" style="margin-bottom: 10px!important;">
                    <?php
                    require_once("_disk/Helps/casa-start.inc.php");
                    ?>
                    </div><?php endif; ?>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card mb-3">
            <div class="card-header">
                <h3 class="card-title">Fale connosco</h3>
            </div>
            <div class="list-group list-group-flush list-group-hoverable">
                <div class=card-body" style="padding: 10px!important;">
                    <div class="mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2" /></svg>
                        Contacto: <strong><?= $Index['telefone']; ?></strong>
                    </div>
                    <div class="mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><rect x="3" y="5" width="18" height="14" rx="2" /><polyline points="3 7 12 13 21 7" /></svg> E-mail:
                        <strong><?= $Index['email']; ?></strong>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="9" /><polyline points="12 7 12 12 15 15" /></svg>
                        <strong>Estamos disponíveis das 10h às 18h em dias úteis.</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
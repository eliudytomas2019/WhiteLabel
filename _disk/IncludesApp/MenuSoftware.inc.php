<div class="navbar-expand-md">
    <?php
        //$menu = DBKwanzar::CheckUsersConfig($id_db_settings, $id_user)['positionMenu'];
        //if($menu == null || !isset($menu) || empty($menu) || $menu == 0 || $menu == 1): $winna = "light"; else: $winna = "vertical"; endif;
    ?>
    <div class="collapse navbar-collapse" id="navbar-menu">
        <div class="navbar navbar-light" style="background: <?= $Index['color_2']; ?>!important; color: <?= $Index['color_41']; ?>!important;">
            <div class="container-xl">
                <ul class="navbar-nav">
                   <?php require_once("_disk/IncludesApp/links.inc.php"); ?>
                </ul>
                <!---div class="my-2 my-md-0 flex-grow-1 flex-md-grow-0 order-first order-md-last">
                    <form action="." method="get">
                        <div class="input-icon">
                    <span class="input-icon-addon">
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="10" cy="10" r="7" /><line x1="21" y1="21" x2="15" y2="15" /></svg>
                    </span>
                            <input type="text" class="form-control" placeholder="Search…" aria-label="Search in website">
                        </div>
                    </form>
                </div--->
            </div>
        </div>
    </div>
</div>
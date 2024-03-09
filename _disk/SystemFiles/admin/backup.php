<div class="row row-deck row-cards">
    <div class="card-body">
        <?php
        if(!class_exists('login')):
            header("index.php");
            die();
        endif;

        if($userlogin['level'] <= 4):
            header("location: panel.php?exe=default/index".$n);
        endif;

        $System = new Read();

        require_once("_disk/_help/00-settings-admin-level-4.inc.php");
        ?>
    </div>
</div>

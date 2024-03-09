<?php
/**
 * Created by PhpStorm.
 * User: Kwanzar Soft
 * Date: 22/06/2020
 * Time: 15:30
 */
?>

<!---div class="administrator-online" id="users_online">
    <?php
        $read = new Read();
        $read->ExeRead("db_users", "WHERE level='5'");
    
        if($read->getResult()):
            $user = $read->getResult()[0];
            ?>
            <li id="<?= $id_user ?>:<?= $user['id'] ?>">
                <div class="imgSmall"><img src="./uploads/<?php if($user['cover'] != ''): echo $user['cover']; else: echo "user.png"; endif; ?>"></div>
                <a href="#" class="comecar" id="<?= $id_user ?>:<?= $user['id'] ?>"></a>
            </li>
            <?php
        endif; 
    ?>
</div>

<div id="chats">

</div---->
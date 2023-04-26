<?php

    declare(strict_types=1);
    
    require_once(__DIR__ . '/../database/user.class.php');
    require_once(__DIR__ . '/../database/connection.db.php');

    $db = getDatabaseConnection();

    function drawUsersList() : void {
        global $db;
        $users = User::getAllUsers($db); ?>
    <input type="text" placeholder="Search...">
    <ul class="user_list">
<?php
        foreach ($users as $user) { ?>
        <li><a href="../pages/profile.php?username=<?= $user->username ?>"><?= $user->name ?></a></li>
<?php
        }
?>
    </ul>
<?php
    }
?>

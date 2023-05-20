<?php

    declare(strict_types=1);
    
    require_once(__DIR__ . '/../../database/user.class.php');
    require_once(__DIR__ . '/../../database/connection.db.php');

    $db = getDatabaseConnection();

    function drawUsersList() : void {
        global $db;
        $users = User::getAllUsers($db); ?>
    <input class="searchbar" type="text" placeholder="Search...">
    <ul class="search_list">
<?php
        foreach ($users as $user) { ?>
        <li class="search_item"><a href="../pages/profile.php?username=<?= $user->username ?>"><?= $user->name ?></a></li>
<?php
        }
?>
    </ul>
<?php
    }
?>

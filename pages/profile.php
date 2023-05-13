<?php

    declare(strict_types=1);

    require_once(__DIR__ . '/../templates/common.tpl.php');
    require_once(__DIR__ . '/../templates/profile.tpl.php');

    require_once(__DIR__ . '/../utils/session.php');

    require_once(__DIR__ . '/../database/connection.db.php');

    require_once(__DIR__ . '/../database/user.class.php');

    $session = new Session();

    $db = getDatabaseConnection();

    drawHeader();

    if (!($session->isLoggedIn())) {
        header('Location: ../index.php');
    }

    echo '<script src="../js/change_profile.js" async></script>';

    $user = User::getUserByUsername($db, $_GET['username']);

    drawProfile($user);

    drawFooter();

?>

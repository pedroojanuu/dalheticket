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
        exit();
    }

    $user = User::getUserByUsername($db, $_GET['username']);
    $logged_user = User::getUserByUsername($db, $session->getName());

    if($session->getName() == $_GET['username'] || $logged_user->type == 'admin')
        echo '<script src="../js/change_profile.js" async></script>';

    drawProfile($user);

    drawFooter();

?>

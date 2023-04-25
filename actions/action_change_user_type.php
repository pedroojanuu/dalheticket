<?php

    declare(strict_types=1);

    require_once(__DIR__ . '/../utils/session.php');

    $session = new Session();

    require_once(__DIR__ . '/../database/connection.db.php');
    require_once(__DIR__ . '/../database/user.class.php');

    $db = getDatabaseConnection();

    $admin = (User::getUserTypeByUsername($db, $session->getName()) == 'admin');

    if (!$admin) {
        header('HTTP/1.0 403 Forbidden');
        die('You are not allowed to access this page.');
    }

    User::changeUserType($db, $_POST['username'], $_POST['new_type']);

    header('Location: ' . $_SERVER['HTTP_REFERER']);
?>

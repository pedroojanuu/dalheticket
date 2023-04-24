<?php

    declare(strict_types = 1);

    require_once(__DIR__ . '/../utils/session.php');

    $session = new Session();

    if ($_POST['new'] != $_POST['new2']) {
        $session->addMessage('error', 'Passwords do not match!');
        header('Location: ../pages/change_password.php?username=' . $_POST['username']);
    }

    require_once(__DIR__ . '/../database/connection.db.php');
    require_once(__DIR__ . '/../database/user.class.php');

    $db = getDatabaseConnection();

    $admin = (User::getUserTypeByUsername($db, $session->getName()) == 'admin');

    if ($admin) {
        User::changePassword($db, $_POST['username'], $_POST['new']);
        $session->addMessage('success', 'Password changed!');
        header('Location: ../pages/profile.php?username=' . $_POST['username']);
    }

    $email = User::getEmailByUsername($db, $_POST['username']);

    $user = User::getUserWithPassword($db, $email, $_POST['old']);

    if (!$user && User::getUserTypeByUsername($db, $session->getName()) != 'admin') {
        $session->addMessage('error', 'Wrong old password!');
        header('Location: ../pages/change_password.php?username=' . $_POST['username']);
    } else {
        User::changePassword($db, $_POST['username'], $_POST['new']);
        header('Location: ../pages/profile.php?username=' . $_POST['username']);
    }
?>

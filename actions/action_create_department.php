<?php

    declare(strict_types=1);

    require_once(__DIR__ . '/../utils/session.php');
    require_once(__DIR__ . '/../database/user.class.php');

    $session = new Session();

    require_once(__DIR__ . '/../database/connection.db.php');
    require_once(__DIR__ . '/../database/department.class.php');

    $db = getDatabaseConnection();

    if (!($session->isLoggedIn()) || User::getUserTypeByUsername($db, $session->getName()) != 'admin') {
        header('Location: ../index.php');
        exit();
    }

    Department::createAndAdd($db, $_POST['name']);

    header('Location: ../pages/departmentDetails.php?name=' . $_POST['name']);
?>

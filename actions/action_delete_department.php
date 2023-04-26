<?php

    declare(strict_types=1);

    require_once(__DIR__ . '/../utils/session.php');

    $session = new Session();

    if (!($session->isLoggedIn())) {
        header('Location: ../index.php');
    }

    require_once(__DIR__ . '/../database/connection.db.php');
    require_once(__DIR__ . '/../database/department.class.php');
    require_once(__DIR__ . '/../database/user.class.php');

    $db = getDatabaseConnection();

    $admin = (User::getUserTypeByUsername($db, $session->getName()) == 'admin');

    if (!$admin) {
        header('Location: ../index.php');
    }

    $department = Department::getDepartmentByName($db, $_GET['name']);

    $department->delete($db);

    header('Location: ../pages/manage_departments.php');
?>

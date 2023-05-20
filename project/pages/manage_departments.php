<?php

    declare(strict_types=1);

    require_once(__DIR__ . '/../utils/session.php');
    require_once(__DIR__ . '/../templates/users.tpl.php');
    $session = new Session();

    if (!($session->isLoggedIn()) || User::getUserTypeByUsername($db, $session->getName()) != 'admin') {
        header('Location: ../index.php');
        exit();
    }

    require_once(__DIR__ . '/../templates/common.tpl.php');
    require_once(__DIR__ . '/../templates/departmentList.tpl.php');

    drawHeader();
    drawDepartmentsList();
    drawFooter();
?>

<?php
    declare(strict_types=1);

    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();

    require_once(__DIR__ . '/../../database/user.class.php');

    require_once(__DIR__ . '/../../database/connection.db.php');

    $db = getDatabaseConnection();

    if (!($session->isLoggedIn()) || User::getUserTypeByUsername($db, $session->getName()) != 'admin') {
        header('Location: ../index.php');
        exit();
    }

    require_once(__DIR__ . '/../templates/common.tpl.php');
    require_once(__DIR__ . '/../templates/stats.tpl.php');

    drawHeader();
    drawGeneralStats();
    drawTopAgents();
    drawFooter();
?>

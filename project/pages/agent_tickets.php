<?php

    require_once(__DIR__ . '/../templates/common.tpl.php');
    require_once(__DIR__ . '/../templates/ticket.tpl.php');
    require_once(__DIR__ . '/../utils/session.php');

    require_once(__DIR__ . '/../../database/connection.db.php');

    $session = new Session();

    $db = getDatabaseConnection();

    drawHeader();

    if (!($session->isLoggedIn())) {
        header('Location: ../index.php');
        exit();
    }

    $user = $session->getName();

    $tickets = Ticket::getAllTicketsFromAgent($db, $session->getName());

    drawTicketList($tickets, "Tickets Assigned to $user");

    drawFooter();

?>

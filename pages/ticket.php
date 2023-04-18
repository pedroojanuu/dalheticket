<?php
    declare(strict_types = 1); 

    require_once(__DIR__ . '/../database/connection.db.php');

    require_once(__DIR__ . '/../database/ticket.class.php');
    require_once(__DIR__ . '/../database/user.class.php');

    require_once(__DIR__ . '/../templates/common.tpl.php');
    require_once(__DIR__ . '/../templates/ticket.tpl.php');

    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();

    $db = getDatabaseConnection();

    drawHeader();

    $ticket = Ticket::getTicketById($db, intval($_GET['id']));
    $user_type = User::getUserTypeByUsername($db, $session->getName());

    if ($ticket->client != $session->getName() && $ticket->agent != $session->getName() && $user_type != 'admin') {
        header('Location: ../index.php');
    }

    drawTicket($db, $ticket);

    drawFooter();
?>

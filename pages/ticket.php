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
    echo "<script src='../js/ajax.js' async></script>";
    echo "<script src='../js/send_message_ajax.js' async></script>";

    $ticket = Ticket::getTicketById($db, intval($_GET['id']));
    $user = User::getUserByUsername($db, $session->getName());

    if ($ticket->client != $session->getName() && !($user->type == 'agent' && $user->department==$ticket->department) && $user->type != 'admin') {
        header('Location: ../index.php');
    }

    //$show_messages = !($user->type == 'agent' && $ticket->client != $session->getName() && $ticket->agent != $session->getName());

    drawTicket($db, $ticket);

    drawFooter();
?>

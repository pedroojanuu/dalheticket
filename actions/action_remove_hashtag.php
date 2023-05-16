<?php

    require_once(__DIR__ . '/../database/ticket.class.php');
    require_once(__DIR__ . '/../utils/session.php');  
    require_once(__DIR__ . '/../database/ticket.class.php');
    require_once(__DIR__ . '/../database/user.class.php');
    require_once(__DIR__ . '/../database/hashtag.class.php');
    require_once(__DIR__ . '/../database/connection.db.php');

    $session = new Session();
    $db = getDatabaseConnection();

    if (!($session->isLoggedIn())) {
        header('Location: ../index.php');
    }

    $ticket = Ticket::getTicketById($db, $_POST['id']);
    $me = User::getUserByUsername($db, $session->getName());

    if ($me->type != 'admin' && $ticket->agent != $me->username) {
        header('Location: ../index.php');
    }

    $ticket->removeHashtag($db, $_POST['tag']);

    header('Location: ../pages/ticket.php?id=' . $ticket->id);

?>

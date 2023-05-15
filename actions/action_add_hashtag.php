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
    $hashtag = Hashtag::getHashtag($db, $_POST['tag']);
    $me = User::getUserByUsername($db, $session->getName());

    if ($me->type != 'admin' && $me->department != $ticket->department) {
        header('Location: ../index.php');
    }

    $ticket->addHashtag($db, $hashtag);

    header('Location: ../pages/ticket.php?id=' . $ticket->id);

?>

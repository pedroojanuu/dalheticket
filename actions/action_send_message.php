<?php
    require_once(__DIR__ . "/../database/message.class.php");
    require_once(__DIR__ . "/../database/connection.db.php");

    $db = getDatabaseConnection();

    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();

    if($_POST["message"] == "")
        header('HTTP/1.0 404 Nothing to see here');
    else
        Message::createAndAdd($db, intval($_POST['ticketId']), $_POST['isFromClient']=="true", $_POST['message'], $session->getName());

    // header('Location: ../pages/ticket.php?id=' . $_POST['ticketId']);
?>
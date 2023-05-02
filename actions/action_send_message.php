<?php
    require_once(__DIR__ . "/../database/message.class.php");
    require_once(__DIR__ . "/../database/connection.db.php");

    $db = getDatabaseConnection();

    Message::createAndAdd($db, intval($_POST['ticketId']), $_POST['isFromClient']=="true", $_POST['message']);

    header('Location: ../pages/ticket.php?id=' . $_POST['ticketId']);
?>
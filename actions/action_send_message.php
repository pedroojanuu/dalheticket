<?php
    require_once(__DIR__ . "/../database/message.class.php");
    require_once(__DIR__ . "/../database/connection.db.php");

    $db = getDatabaseConnection();

    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();

    if ($_SESSION['csrf'] !== $_POST['csrf']) {
        header('Location: ../index.php');
        exit();
    }

    if($_POST["message"] == "") {
        header('HTTP/1.0 404 Nothing to see here');
        exit();
    } else {
        Message::createAndAdd($db, intval($_POST['ticketId']), $_POST['isFromClient']=="true", $_POST['message'], $session->getName());
    }
?>

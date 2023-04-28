<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../database/connection.db.php');
    require_once(__DIR__ . '/../database/faq.class.php');
    require_once(__DIR__ . '/../database/user.class.php');

    $db = getDatabaseConnection();

    require_once(__DIR__ . '/../utils/session.php');

    $session = new Session();

    $my_type = User::getUserTypeByUsername($db, $session->getName());

    if (!($my_type == 'admin' || $my_type == 'agent')) {
        header('Location: ../index.php');
    }

    $question = $_POST['question'];
    $answer = $_POST['answer'];

    FAQ::createAndAdd($db, $question, $answer);

    header('Location: ../pages/faqs.php');
?>

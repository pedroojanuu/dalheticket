<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../database/connection.db.php');
    require_once(__DIR__ . '/../database/faq.class.php');    

    $db = getDatabaseConnection();

    $question = $_POST['question'];
    $answer = $_POST['answer'];

    FAQ::createAndAdd($db, $question, $answer);

    header('Location: ../pages/faq_page.php');
?>

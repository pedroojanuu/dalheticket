<?php
    declare(strict_types = 1); 

    require_once(__DIR__ . '/../database/connection.db.php');

    $db = getDatabaseConnection();

    require_once(__DIR__ . '/../database/faq.class.php');
    require_once(__DIR__ . '/../database/user.class.php');

    require_once(__DIR__ . '/../templates/common.tpl.php');
    require_once(__DIR__ . '/../templates/faqs.tpl.php');

    require_once(__DIR__ . '/../utils/session.php');

    $session = new Session();

    $db = getDatabaseConnection();

    drawHeader();

    $user_type = $session->isLoggedIn()? User::getUserTypeByUsername($db, $session->getName()) : null;

    if ($user_type == 'admin' || $user_type == 'agent') {
        drawSubmitFAQ();
    }

    drawFAQs($db);

    drawFooter();
?>

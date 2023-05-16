<?php
    declare(strict_types=1);

    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();

    require_once(__DIR__ . '/../database/user.class.php');

    require_once(__DIR__ . '/../database/connection.db.php');

    $db = getDatabaseConnection();

    if (!($session->isLoggedIn())) {
        header('Location: ../index.php');
        exit();
    }

    $me = User::getUserByUsername($db, $session->getName());

    if ($me->type != 'admin' && $me->type != 'agent') {
        header('Location: ../index.php');
        exit();
    }

    require_once(__DIR__ . '/../templates/common.tpl.php');
    require_once(__DIR__ . '/../templates/hashtag.tpl.php');

    $hashtag = Hashtag::getHashtag($db, $_GET['tag']);

    drawHeader();
    drawHashtag($db, $hashtag, $me->department == null? '' : $me->department);
    drawFooter();
?>

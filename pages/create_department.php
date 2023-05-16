<?php

    declare(strict_types=1);

    require_once(__DIR__ . '/../utils/session.php');
    require_once(__DIR__ . '/../templates/users.tpl.php');
    $session = new Session();

    if (!($session->isLoggedIn()) || User::getUserTypeByUsername($db, $session->getName()) != 'admin') {
        header('Location: ../index.php');
        exit();
    }

    require_once(__DIR__ . '/../templates/common.tpl.php');

    drawHeader();
?>
    <h3>Creating a new department</h3>
    <form action="../actions/action_create_department.php" method="post">
        <input type="text" name="name" placeholder="New department's name">
        <button type="submit">Create</button>
    </form>
<?php
    drawFooter();
?>

<?php

    require_once(__DIR__ . '/../templates/common.tpl.php');
    require_once(__DIR__ . '/../utils/session.php');

    require_once(__DIR__ . '/../database/connection.db.php');

    require_once(__DIR__ . '/../database/user.class.php');

    $session = new Session();

    $db = getDatabaseConnection();

    drawHeader();

    if (!($session->isLoggedIn())) {
        header('Location: ../index.php');
    }

    $user = User::getUserByUsername($db, $session->getName());

?>
    <div class="name"><?= $user->name?></div>
    <div class="username"><?= $user->username?></div>
    <div class="email"><?= $user->email?></div>
    <div class="type">User type: <?= $user->type?></div>
<?php
    if ($user->type == 'agent') { ?>
        <div class="department">Department: <?= $user->department?></div>
<?php } ?>
    <a href="change_password.php">Change password...</a>
<?php

    drawFooter();

?>

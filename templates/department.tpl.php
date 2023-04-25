<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../database/connection.db.php');
    $db = getDatabaseConnection();

    require_once(__DIR__ . '/../database/user.class.php');

    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();

    function drawProfile(User $user) : void {
        global $session, $db;
        print $session->getName();
    ?>

    <h3 class="name"><?= $user->name?></h3>
    <div class="username"><?= $user->username?></div>
    <div class="email"><?= $user->email?></div>
    <div class="type">User type: <?= $user->type?></div>
    <?php
    if ($user->type == 'agent') { ?>
        <div class="department">Department: <?= $user->department?></div>
<?php }
    $user_type = $session->isLoggedIn()? User::getUserTypeByUsername($db, $session->getName()) : null;
    if ($user_type == 'admin' || $session->getName() == $user->username) {
?>
    <a href="change_password.php?username=<?= $user->username ?>">Change password...</a>
<?php }
    }
?>

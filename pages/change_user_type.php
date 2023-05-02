<?php
    declare(strict_types=1);

    require_once(__DIR__ . '/../templates/common.tpl.php');
    require_once(__DIR__ . '/../utils/session.php');

    require_once(__DIR__ . '/../database/user.class.php');
    require_once(__DIR__ . '/../database/connection.db.php');

    $db = getDatabaseConnection();

    if (!($session->isLoggedIn()) || User::getUserTypeByUsername($db, $session->getName()) != 'admin') {
        header('Location: ../index.php');
    }

    drawHeader();

    $current_type = User::getUserTypeByUsername($db, $_GET['username']);
?>

    <h3>Changing <?= $_GET['username'] ?>'s user type</h3>
    Select the type of user you want <?= $_GET['username'] ?> to be:
    <form class="radio_form" action="../actions/action_change_user_type.php" method="post">
        <input type="hidden" name="username" value="<?=$_GET['username']?>">
        <span class="radio_span"><input type="radio" name="type" value="client" <?= $current_type == 'client'? "checked" : "" ?>><p>Client</p></span>
        <span class="radio_span"><input type="radio" name="type" value="agent" <?= $current_type == 'agent'? "checked" : "" ?>><p>Agent</p></span>
        <span class="radio_span"><input type="radio" name="type" value="admin" <?= $current_type == 'admin'? "checked" : "" ?>><p>Admin</p></span>
        <button type="submit">Save</button>
    </form>

<?php
    drawFooter();
?>

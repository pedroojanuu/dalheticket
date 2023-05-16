<?php
    declare(strict_types=1);

    require_once(__DIR__ . '/../templates/common.tpl.php');
    require_once(__DIR__ . '/../utils/session.php');

    require_once(__DIR__ . '/../database/connection.db.php');

    require_once(__DIR__ . '/../database/user.class.php');

    if (!($session->isLoggedIn())) {
        header('Location: ../index.php');
        exit();
    }

    $db = getDatabaseConnection();
    
    $user_type = $session->isLoggedIn()? User::getUserTypeByUsername($db, $session->getName()) : null;

    if (($user_type != 'admin') && ($session->getName() != $_GET['username'])) {
        header('Location: ../index.php');
        exit();
    }

    drawHeader();
?>
    <section id="messages">
      <?php foreach ($session->getMessages() as $messsage) { ?>
        <article class="<?=$messsage['type']?>">
          <?=$messsage['text']?>
        </article>
      <?php } ?>
    </section>
    <h3>Changing <?= $_GET['username']?>'s password</h3>
    <form action="../actions/action_change_password.php" method="post">

<?php
    if ($user_type != 'admin') {
?>
        <label for="old">Old password</label>
        <input type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">
        <input type="password" name="old" id="old">
<?php
    }
?>
        <label for="new">New password</label>
        <input type="password" name="new" id="new">
        <label for="new2">Confirm new password</label>
        <input type="password" name="new2" id="new2">
        <input type="hidden" name="username" value="<?=$_GET['username']?>">
        <button type="submit">Submit</button>
    </form>

<?php
    drawFooter();
?>

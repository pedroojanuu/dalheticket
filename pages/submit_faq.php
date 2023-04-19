<?php
    require_once(__DIR__ . '/../templates/common.tpl.php');

    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();

    require_once(__DIR__ . '/../database/connection.db.php');
    $db = getDatabaseConnection();

    require_once(__DIR__ . '/../database/user.class.php');

    $user_type = $session->isLoggedIn()? User::getUserTypeByUsername($db, $session->getName()) : null;

    if (!($user_type == 'admin' || $user_type == 'agent')) {
        header('Location: ../index.php');
    }

    drawHeader();?>

<form action="../actions/action_submit_faq.php" method="post" class="submit_faq">
    <label for="question">Question</label>
    <input type="text" name="question" id="question" placeholder="Frequently Asked Question here">
    <label for="answer">Answer</label>
    <textarea name="answer" id="answer"></textarea>
    <button type="submit">Submit</button>
</form>

<?php
    drawFooter();
?>

<?php
    // Include the header
    require_once(__DIR__ . '/templates/common.tpl.php');
    require_once(__DIR__ . '/database/user.class.php');
    require_once(__DIR__ . '/database/connection.db.php');

    $db = getDatabaseConnection();

    drawHeader(true);
?>

<?php 
    if($session->isLoggedIn()) {
        ?>

        <div class="options hidden">
            <a href="pages/submit_ticket.php">Submit a ticket</a>
            <a href="pages/my_tickets.php">List my tickets</a>
            <?php 
            $user = User::getUserByUsername($db, $session->getName());
            if($user->type == "agent") { ?>
                <a href="">List assigned tickets</a>
                <a href=<?=("pages/department.php?department=" . $user->department)?>>List tickets of my department</a>
            <?php } ?>
        </div>
<?php } ?>
<?php
    drawFooter();
?>

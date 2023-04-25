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
            <?php if(User::isUserAgent($db, $session->getName()) || 
                     User::isUserAdmin($db, $session->getName()) ) { ?>
                <a href="">List assigned tickets</a>
                <a href="">List tickets of my department</a>
            <?php } ?>
        </div>
<?php } ?>
<?php
    drawFooter();
?>

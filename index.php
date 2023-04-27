<?php
    // Include the header
    require_once(__DIR__ . '/templates/common.tpl.php');

    require_once(__DIR__ . '/database/user.class.php');
    require_once(__DIR__ . '/database/connection.db.php');

    $db = getDatabaseConnection();

    drawHeader(true);
 
    if($session->isLoggedIn()) { ?>
    <div class="options hidden">
        <a href="pages/submit_ticket.php">Submit a ticket</a>
        <a href="pages/my_tickets.php">List my tickets</a>
<?php
    }
    if($session->isLoggedIn() && User::getUserTypeByUsername($db, $session->getName()) == 'admin') { ?>
        <a href="pages/manage_users.php">Manage users</a>
        <a href="pages/manage_departments.php">Manage departments</a>
<?php
    }
?>
    </div>
<?php
    drawFooter();
?>

<?php
    // Include the header
    require_once(__DIR__ . '/templates/common.tpl.php');
    require_once(__DIR__ . '/database/user.class.php');
    require_once(__DIR__ . '/database/connection.db.php');

    $db = getDatabaseConnection();

    require_once(__DIR__ . '/database/user.class.php');
    require_once(__DIR__ . '/database/department.class.php');
    require_once(__DIR__ . '/database/connection.db.php');

    drawHeader(true);
 
    if($session->isLoggedIn()) { ?>
    <nav class="options hidden">
        <a href="pages/submit_ticket.php">Submit a ticket</a>
        <a href="pages/my_tickets.php">List my tickets</a>
    <?php $db = getDatabaseConnection();
    $user = User::getUserByUsername($db, $session->getName());
    if($user->type == "agent") { ?>
        <a href="">List assigned tickets</a>
        <a href=<?=("pages/departmentDetails.php?name=" . $user->department)?>>Go to my department</a>
    <?php } ?>
    <?php if(User::getUserTypeByUsername($db, $session->getName()) == 'admin') { ?>
        <a href="pages/manage_users.php">Manage users</a>
        <a href="pages/manage_departments.php">Manage departments</a>
    <?php } ?>
    </nav>
<?php
    }
    drawFooter();
?>

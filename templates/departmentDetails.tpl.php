<?php 

declare(strict_types=1);
    
require_once(__DIR__ . '/../database/department.class.php');
require_once(__DIR__ . '/../database/ticket.class.php');
require_once(__DIR__ . '/../database/connection.db.php');

function drawDepartment(Department $department) : void {
        global $session, $db;
        $my_type = $session->isLoggedIn()? User::getUserTypeByUsername($db, $session->getName()) : null;
?>
    <h3 class="name"><?= $department->name ?></h3>
    <div class="dep_options">
        <a href="../actions/action_delete_department.php?name=<?= $department->name ?>">Delete...</a>
        <br>
        <a href="../pages/change_department_name.php?name=<?= $department->name ?>">Change name...</a>
    </div>
    <p> Member Agents: </p>
    <ul class="search_list">
<?php
    foreach ($department->getMemberAgents($db) as $agent) {
?>
    <li>
        <a href="../pages/profile.php?username=<?= $agent->username ?>"><?= $agent->username ?></a>
    </li>
<?php
    }
?>
    </ul>

    <p> Tickets: </p>
    <ul class="ticket_list">
<?php
    foreach (Ticket::getAllTicketsInDepartment($db, $department->name) as $ticket) {
?>
    <li>
        <!-- lalala -->
        <a href="../pages/ticket.php?id=<?= $ticket->id ?>"><?= $ticket->title ?> 
        - Status: <?= $ticket->status ?> 
        - Client: <?= $ticket->client ?> 
        <?php if($ticket->agent != null) { ?>
        - Assigned to: <?= $ticket->agent ?></a>
        <?php } else {?>
        - No Agent Assigned</a>
        <?php } ?>
    </li>
<?php
    }
?>
    </ul>
<?php
    }
?>

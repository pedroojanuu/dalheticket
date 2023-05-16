<?php 

declare(strict_types=1);
    
require_once(__DIR__ . '/../database/department.class.php');
require_once(__DIR__ . '/../database/ticket.class.php');
require_once(__DIR__ . '/../database/connection.db.php');

function drawDepartment(Department $department) : void {
        global $session, $db;
?>
<script src="../js/filter.js" defer></script>
    <h3 class="name"><?= $department->name ?></h3>
    <div class="dep_options">
        <a href="../actions/action_delete_department.php?name=<?= $department->name ?>">Delete...</a>
        <br>
        <a href="../pages/change_department_name.php?name=<?= $department->name ?>">Change name...</a>
    </div>
    <h4>Member Agents</h4>
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

    <h4>Tickets</h4>
    <h5>Filter by</h5>
    <form class="radio_form" id="status">
        <p>Status: </p>
        <input type="radio" name="status" value="Solved">
        <p>Solved</p>
        <input type="radio" name="status" value="Unsolved">
        <p>Unsolved</p>
        <input type="radio" name="status" value="All" checked>
        <p>All</p>
    </form>
    <ul class="ticket_list">
<?php
    foreach (Ticket::getAllTicketsInDepartment($db, $department->name) as $ticket) {
?>
    <li class="ticket">
        <!-- lalala -->
        <a href="../pages/ticket.php?id=<?= $ticket->id ?>"><?= $ticket->title ?> 
        - Status: <span id="status"><?= $ticket->status ?></span> 
        - Client: <?= $ticket->client ?> 
        <?php if($ticket->agent != null) { ?>
        - Assigned to: <span id="agent"><?= $ticket->agent ?></span></a>
        <?php } else {?>
        - <span id="agent">No Agent Assigned</span></a>
        <?php } ?>
    </li>
<?php
    }
?>
    </ul>
<?php
    }
?>

<?php

    declare(strict_types=1);
    
    require_once(__DIR__ . '/../../database/ticket.class.php');
    require_once(__DIR__ . '/../../database/user.class.php');
    require_once(__DIR__ . '/../../database/connection.db.php');

    $db = getDatabaseConnection();

    function drawGeneralStats() : void {
        global $db;
        $unsolved = Ticket::countUnsolvedTickets($db);
        $solved = Ticket::countSolvedTickets($db);
        $total = $solved + $unsolved;
?>
<h3>Dá-lhe Ticket statistics</h3>

Total Tickets: <?= $total ?><br>
Solved Tickets: <?= $solved ?><br>
Unsolved Tickets: <?= $unsolved ?><br>
<?php
    }

    function drawTopAgents() : void {
        global $db;
        $agents = User::getTopAgents($db);
?>
    <p> Top Agents: </p>
    <ol>
<?php
    foreach ($agents as $agent) {
?>
    <li>
        <a href="../pages/profile.php?username=<?= $agent->username ?>"><?= $agent->username ?> | Solved Tickets: <?= $agent->closed_tickets ?></a>
    </li>
<?php
    }
?>
    </ol>

<?php
    }

?>

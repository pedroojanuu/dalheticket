<?php
    declare(strict_types = 1); 

    require_once(__DIR__ . '/../database/ticket.class.php');
    require_once(__DIR__ . '/../database/hashtag.class.php');
    //require_once(__DIR__ . '/../utils/message.php');
?>

<?php function drawTicketList(array $tickets) : void {
    if (sizeof($tickets) == 0) {
        print "You have no tickets.";
        return;
    }
    ?>
    <ul class="ticket_list">
    <?php foreach ($tickets as $ticket) {?>
        <li><a href="../pages/ticket.php?id=<?= $ticket->id?>">[<?= $ticket->status?>] <?= $ticket->title?></a></li>
    <?php }?>
    </ul>
<?php }?>

<?php function drawTicket(PDO $db, Ticket $ticket) { ?>
    <span class="ticket_title"><?= $ticket->title ?></span>
    <span class="ticket_client">Client: <?= $ticket->client ?></span>
    <?php if($ticket->agent !== null) { ?>
        <span class="ticket_agent">Agent: <?= $ticket->agent ?></span>
    <?php } ?>
    <span class="ticket_status">Status: <?= $ticket->status ?></span>
    <span class="ticket_department">Department: <?= $ticket->department ?></span>
    <div class="ticket_hashtags">Hashtags: 
        <?php foreach($ticket->getHashtags($db) as $hashtag) { ?>
            <span class="hashtag">#<?= $hashtag->name ?></span>
        <?php } ?>
        </div>
<?php } ?>

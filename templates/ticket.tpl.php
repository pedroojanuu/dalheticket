<?php
    declare(strict_types = 1); 

    require_once(__DIR__ . '/../database/ticket.class.php');
    require_once(__DIR__ . '/../database/hashtag.class.php');
    require_once(__DIR__ . '/../database/message.class.php');
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

<?php function drawTicket(PDO $db, Ticket $ticket, bool $show_messages = False) { ?>
    <h3><?= $ticket->title ?></h3>
    <div class="ticket_client"><span class="bold">Client:</span> <?= $ticket->client ?></div>
    <?php if($ticket->agent !== null) { ?>
        <div class="ticket_agent"><span class="bold">Agent:</span> <?= $ticket->agent ?></div>
    <?php } ?>
    <div class="ticket_status"><span class="bold">Status:</span> <?= $ticket->status ?></div>
    <div class="ticket_department"><span class="bold">Department:</span> <?= $ticket->department ?></div>
    <div class="ticket_hashtags"><span class="bold">Hashtags: </span>  
        <?php foreach($ticket->getHashtags($db) as $hashtag) { ?>
            <span class="hashtag">#<?= $hashtag->name ?></span>  
        <?php } ?>
    </div>
    <?php if($show_messages) { ?>
        <section class="ticket_messages">
            <p>Messages:</p>
            <?php foreach(Message::getAllMessagesFromTicket($db, $ticket->id) as $message) { ?>
                    <p><?php echo ($message->isFromClient) ? 'User: ': 'Agent: '?>
                       <?= $message->message ?></p>
            <?php } ?>
        </section>
        <form action="../actions/action_add_message.php" method="post">
            <input type="hidden" name="ticket_id" value="<?= $ticket->id ?>">
            <input type="hidden" name="author" value="<?= $session->getName() ?>">
            <input type="text" name="content" placeholder="Message">
            <input type="submit" value="Send">
        </form>

<?php 
    } else if($ticket->status == 'Unsolved' && $ticket->agent == null) {
?> 
        <a href=<?=("../actions/action_assign_ticket.php?id=" . $ticket->id)?>>Assign to me</a>
<?php
    }
} 
?>

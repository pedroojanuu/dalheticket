<?php
    declare(strict_types = 1); 

    require_once(__DIR__ . '/../database/ticket.class.php');
    require_once(__DIR__ . '/../database/hashtag.class.php');
    require_once(__DIR__ . '/../database/message.class.php');
    //require_once(__DIR__ . '/../utils/message.php');
?>

<?php function drawTicketList(array $tickets, string $title = '') : void {
    if($title != '') {
        echo "<h2>$title</h2>";
    }
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

<?php function drawTicket(PDO $db, Ticket $ticket) { 
    $session = new Session();
    ?>
    <div class="ticket_details">
        <div class="ticket_info">
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

            <?php if($ticket->agent == $session->getName()) { ?>
                <a href=<?=("../actions/action_abandon_ticket.php?id=" . $ticket->id)?>>
                    Abandon Ticket
                </a>
            <?php
                } else if($ticket->status == 'Unsolved' && $ticket->agent == null) {
                    $session = new Session();
            ?> 
                <a href=<?=("../actions/action_assign_ticket.php?id=" . $ticket->id . "&agent=" . $session->getName())?>>
                    Assign to me
                </a>
            <?php } ?>
        </div>
        <?php
            if($session->getName() == $ticket->agent || $session->getName() == $ticket->client) { 
        ?>
        <div class="ticket_messages">
            <?php foreach(Message::getAllMessagesFromTicket($db, $ticket->id) as $message) { ?>
                <div class="ticket_message <?= $message->isMine($db) ? 'right' : 'left' ?>">
                    <div class="ticket_message_text"><?= $message->message ?></div>
                    <div class="ticket_message_date"><?= $message->date ?></div>
                </div>
            <?php } ?>
            <form class="send_message" action="../actions/action_send_message.php" method=post>
                <input type="hidden" name="ticketId" value="<?= $ticket->id ?>">
                <input type="hidden" name="isFromClient" value="<?= $ticket->client == $session->getName() ? "true" : "false" ?>">
                <input type="text" name="message" placeholder="Message">
                <input type="submit" value="Send">
            </form>
        </div>
    <?php } ?>
    </div>
<?php } ?>

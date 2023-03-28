<?php
    declare(strict_types = 1); 

    require_once(__DIR__ . '/../database/ticket.class.php');
    require_once(__DIR__ . '/../database/hashtag.class.php');
    require_once(__DIR__ . '/../utils/message.php');
?>

<?php function drawTicket(Ticket $ticket, PDO $db) { ?>
    <h2>Ticket #<?= $ticket->id ?></h2>
    <h3>Client: <?= $ticket->client ?></h3>
    <?php if($ticket->agent !== null) { ?>
        <h3>Agent: <?= $ticket->agent ?></h3>
    <?php } ?>
    <h3>Status: <?= $ticket->status ?></h3>
    <h3>Department: <?= $ticket->department ?></h3>
    <p>Hashtags: 
        <?php foreach($ticket->getAllHashtags($db) as $hashtag) { ?>
            #<?= $hashtag->name ?> 
        <?php } ?>
    </p>
<?php } ?>

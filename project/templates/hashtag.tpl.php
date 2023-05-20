<?php
    declare(strict_types = 1); 

    require_once(__DIR__ . '/../../database/ticket.class.php');
    require_once(__DIR__ . '/../../database/hashtag.class.php');

    require_once(__DIR__ . '/../templates/ticket.tpl.php');
    
    function drawHashtag(PDO $db, Hashtag $hashtag, string $department = '') : void {
        $tickets = Ticket::getAllTicketsWithHashtag($db, $hashtag, $department);
        drawTicketList($tickets, $hashtag->tag);
    }

?>

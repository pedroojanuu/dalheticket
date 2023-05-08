<?php

require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/ticket.class.php');
require_once(__DIR__ . '/../database/user.class.php');
require_once(__DIR__ . '/../database/message.class.php');
require_once(__DIR__ . '/../utils/session.php');

$db = getDatabaseConnection();

$ticket = Ticket::getTicketById($db, intval($_GET['ticketId']));
$me = User::getUserByUsername($db, $session->getName());

if($session->getName() == $ticket->agent || $session->getName() == $ticket->client || $me->type == 'admin' ||
    ($me->type == "agent" && $me->department == $ticket->department)){
    echo json_encode(Message::getAllMessagesFromTicket($db, intval($_GET['ticketId'])));
}
else
  header('HTTP/1.0 404 Nothing to see here');

?>
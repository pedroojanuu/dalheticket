<?php
  require_once(__DIR__ . '/../database/connection.db.php');
  require_once(__DIR__ . '/../database/ticket.class.php');
  require_once(__DIR__ . '/../database/user.class.php');
  require_once(__DIR__ . '/../database/message.class.php');
  require_once(__DIR__ . '/../utils/session.php');

  $db = getDatabaseConnection();
  $session = new Session();

  $ticket = Ticket::getTicketById($db, intval($_GET['id']));
  $me = User::getUserByUsername($db, $session->getName());

  $message_array = array();

  foreach(Message::getAllMessagesAndChangesFromTicket($db, intval($_GET['id'])) as $message){
    // $message_array[] = array($message->message;
    if($message instanceof Message){
      $message_array[] = array(
        "id" => $message->id,
        "ticketId" => $message->ticketId,
        "isFromClient" => $message->isFromClient,
        "message" => htmlentities($message->message),
        "author" => $message->author,
        "isMine" => $message->isMine($db),
        "datetime" => $message->datetime
      );
    } else if($message instanceof Change){
      $message_array[] = array(
        "id" => $message->id,
        "ticketId" => $message->ticketId,
        "agent" => $message->agent,
        "action" => $message->action,
        "datetime" => $message->datetime
      );
    }
  }

if($session->getName() == $ticket->agent || $session->getName() == $ticket->client || $me->type == 'admin' ||
    ($me->type == "agent" && $me->department == $ticket->department)){
    echo json_encode($message_array);
}
else
  header('HTTP/1.0 404 Nothing to see here');
?>
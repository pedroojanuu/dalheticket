<?php 
  require_once(__DIR__ . '/../database/ticket.class.php');
  require_once(__DIR__ . '/../utils/session.php');  
  require_once(__DIR__ . '/../database/ticket.class.php');
  require_once(__DIR__ . '/../database/user.class.php');
  require_once(__DIR__ . '/../database/connection.db.php');

  $session = new Session();
  $db = getDatabaseConnection();

  $ticket = Ticket::getTicketById($db, $_GET['id']);
  $agent = User::getUserByUsername($db, $_GET['agent']);
  $session_user = User::getUserByUsername($db, $session->getName());

  if(($session_user->type == 'agent' && $agent->type == 'agent' && 
    $ticket->status == 'Unsolved' && $ticket->department == $session_user->department && 
    ($ticket->agent == null || $ticket->agent == $session->getName())) ||
    ($session_user->type == 'admin' && $agent->type == 'agent')) { 
    $ticket->setAgent($db, $_GET['agent']);
    $agent->incrementAssigned($db);
  }

  header('Location: ../pages/ticket.php?id=' . $_GET['id']);

?>

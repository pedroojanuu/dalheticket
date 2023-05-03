<?php 
  require_once(__DIR__ . '/../database/ticket.class.php');
  require_once(__DIR__ . '/../utils/session.php');  
  require_once(__DIR__ . '/../database/user.class.php');
  require_once(__DIR__ . '/../database/connection.db.php');

  $session = new Session();
  $db = getDatabaseConnection();

  $ticket = Ticket::getTicketById($db, $_GET['id']);

  $new_status = $ticket->status == 'Unsolved'? 'Solved' : 'Unsolved';
  
  $ticket->setStatus($db, $new_status);

  header('Location: ../pages/ticket.php?id=' . $_GET['id']);

?>

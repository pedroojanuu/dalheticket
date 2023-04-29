<?php 
  require_once(__DIR__ . '/../database/ticket.class.php');
  require_once(__DIR__ . '/../utils/session.php');  
  require_once(__DIR__ . '/../database/ticket.class.php');
  require_once(__DIR__ . '/../database/user.class.php');
  require_once(__DIR__ . '/../database/connection.db.php');

  $session = new Session();
  $db = getDatabaseConnection();

  $ticket = Ticket::getTicketById($db, $_GET['id']);
  $session_user = User::getUserByUsername($db, $session->getName());

  if(($session_user->type == 'agent' && $ticket->status == 'Unsolved' && 
    $ticket->agent == $session->getName()) ||
    $session_user->type == 'admin') { 
    $ticket->removeAgent($db);
  }
  


  header('Location: ../pages/ticket.php?id=' . $_GET['id']);

  ?>

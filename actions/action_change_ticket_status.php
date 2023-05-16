<?php 
  require_once(__DIR__ . '/../database/ticket.class.php');
  require_once(__DIR__ . '/../utils/session.php');  
  require_once(__DIR__ . '/../database/user.class.php');
  require_once(__DIR__ . '/../database/connection.db.php');

  $session = new Session();
  $db = getDatabaseConnection();

  if (!($session->isLoggedIn())) {
    header('Location: ../index.php');
    exit();
  }

  $me = User::getUserByUsername($db, $session->getName());

  $ticket = Ticket::getTicketById($db, $_GET['id']);

  if ($me->type != 'admin' && $me->department != $ticket->department) {
    header('Location: ../index.php');
    exit();
  }

  $new_status = $ticket->status == 'Unsolved'? 'Solved' : 'Unsolved';

  if ($new_status == 'Solved') {
    $me->incrementSolved($db);
  }
  
  $ticket->setStatus($db, $new_status);

  header('Location: ../pages/ticket.php?id=' . $_GET['id']);

?>

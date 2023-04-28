<?php 
  require_once(__DIR__ . '/../database/ticket.class.php');
  require_once(__DIR__ . '/../utils/session.php');  

  header('Location: ../pages/ticket.php?id=' . $_GET['id']);

  ?>
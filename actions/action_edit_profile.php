<?php

require_once('../database/user.class.php');
require_once('../database/connection.db.php');
require_once('../utils/session.php');

$session = new Session();

if ($_SESSION['csrf'] !== $_POST['csrf']) {
  header('Location: ../index.php');
  exit();
}

$db = getDatabaseConnection();
$logged_user = User::getUserByUsername($db, $session->getName());

$username = $_POST['username'];

if($session->getName() == $username || $logged_user->type == 'admin') {
  $field = $_POST['field'];
  $value = $_POST['value'];
  
  if($value != "")
    User::changeCertainAttribute($db, $username, $field, $value);
}

?>

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

if($_POST['field'] != 'name' || $_POST['field'] != 'email'){
  header('Location: ../index.php');
  exit();
}


if($session->getName() == $username || $logged_user->type == 'admin' &&
  !(User::emailExists($db, $_POST['email']) || 
  $_POST['username'] == '' || $_POST['email'] == '' || $_POST['name'] == '' || $_POST['password'] == '' ||
  User::usernameExists($db, $_POST['username']) || 
  !preg_match("/^[a-zA-Z1-9\s]+$/", $_POST['name']) ||
  !preg_match("/^[a-zA-Z1-9_\-\.]+$/", $_POST['username']) ||
  !preg_match("/^[a-zA-Z1-9_\-\.@]+$/", $_POST['email']) ||
  $_POST['password'] != $_POST['password2'])) {
    
  $field = $_POST['field'];
  $value = $_POST['value'];
  
  if($value != "")
    User::changeCertainAttribute($db, $username, $field, $value);
}

?>

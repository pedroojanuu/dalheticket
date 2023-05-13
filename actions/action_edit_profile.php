<?php

require_once('../database/user.class.php');
require_once('../database/connection.db.php');
require_once('../utils/session.php');

$session = new Session();
$db = getDatabaseConnection();

$username = $_POST['username'];

if($session->getName() == $username) {
  $field = $_POST['field'];
  $value = $_POST['value'];
  
  User::changeCertainAttribute($db, $username, $field, $value);
}

?>

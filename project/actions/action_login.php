<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../utils/session.php');
  $session = new Session();

  require_once(__DIR__ . '/../../database/connection.db.php');
  require_once(__DIR__ . '/../../database/user.class.php');

  $db = getDatabaseConnection();

  $user = User::getUserWithPassword($db, $_POST['email'], $_POST['password']);

  if ($user) {
    $session->setId($user->getRowID($db));
    $session->setName($user->username);
    $session->addMessage('Login success', 'Login successful!');
  } else {
    $session->addMessage('Login error', 'Wrong password!');
  }

  header('Location: ' . $_SERVER['HTTP_REFERER']);
?>

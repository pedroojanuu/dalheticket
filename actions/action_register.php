<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../utils/session.php');
  $session = new Session();

  require_once(__DIR__ . '/../database/connection.db.php');
  require_once(__DIR__ . '/../database/user.class.php');

  $db = getDatabaseConnection();

  if (User::emailExists($db, $_POST['email'])) {
    $session->addMessage('error', 'Email already exists!');
    header('Location: ' . $_SERVER['HTTP_REFERER']);
  } else if (User::usernameExists($db, $_POST['username'])) {
    $session->addMessage('error', 'Username already exists!');
    header('Location: ' . $_SERVER['HTTP_REFERER']);
  } else if ($_POST['password'] != $_POST['password2']) {
    $session->addMessage('error', 'Passwords do not match!');
    header('Location: ' . $_SERVER['HTTP_REFERER']);
  } else {
    $user = User::createAndAdd($db, $_POST['name'], $_POST['username'], $_POST['email'], $_POST['password'], "user", "");
    $session->addMessage('success', 'Registration successful!');
    header('Location: ../pages/registration_successful.php');
  }
?>
<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../templates/common.tpl.php');
  require_once(__DIR__ . '/../templates/profile.tpl.php');

  require_once(__DIR__ . '/../utils/session.php');

  if ($session->isLoggedIn()) {
    header('Location: ../index.php');
    exit();
  }

  drawHeader();
  drawRegisterForm();
  drawFooter();
?>

<?php

    require_once(__DIR__ . '/../templates/common.tpl.php');
    require_once(__DIR__ . '/../templates/departmentDetails.tpl.php');

    require_once(__DIR__ . '/../utils/session.php');

    require_once(__DIR__ . '/../database/connection.db.php');

    require_once(__DIR__ . '/../database/user.class.php');

    $session = new Session();

    $db = getDatabaseConnection();

    if(!($session->isLoggedIn())) 
       header('Location: ../index.php');

    $user = User::getUserByUsername($db, $session->getName());
    $department = $_GET['department'];
    if($user == null || 
      ($user->type != 'admin' && 
      ($user->type != 'agent' || 
       $user->department != $department)))
       header('Location: ../index.php');

    drawHeader();

    drawDepartment($department);

    drawFooter();

?>
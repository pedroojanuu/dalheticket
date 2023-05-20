<?php

    require_once(__DIR__ . '/../templates/common.tpl.php');
    require_once(__DIR__ . '/../templates/departmentDetails.tpl.php');

    require_once(__DIR__ . '/../utils/session.php');

    require_once(__DIR__ . '/../../database/connection.db.php');

    require_once(__DIR__ . '/../../database/department.class.php');
    require_once(__DIR__ . '/../../database/user.class.php');

    $session = new Session();

    $db = getDatabaseConnection();

    if(!($session->isLoggedIn()) || !isset($_GET['name'])) {
      header('Location: ../index.php');
      exit();
    }

    $user = User::getUserByUsername($db, $session->getName());
    $department = Department::getDepartmentByName($db, $_GET['name']);

   if($user->type == 'agent' && $user->department == null && $_GET['name'] == ''){
      drawHeader();
      echo "<h4> Sorry, you aren't yet associated with a department.</h4>";
      drawFooter();
   } else {
      if ($user == null) {
         header('Location: ../index.php');
         exit();
      } else if ($department == null) {
         header('Location: ../index.php');
         exit();
      } else if (!($user->type == 'admin' || ($user->type == 'agent' && $user->department == $department->name))) {
         header('Location: ../index.php');
         exit();
      }

      drawHeader();
      drawDepartment($department);
      drawFooter();
   }

?>

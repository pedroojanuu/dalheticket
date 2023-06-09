<!-- <?php

    declare(strict_types=1);

    require_once(__DIR__ . '/../templates/common.tpl.php');
    require_once(__DIR__ . '/../templates/departmentList.tpl.php');

    require_once(__DIR__ . '/../utils/session.php');

    require_once(__DIR__ . '/../../database/connection.db.php');

    require_once(__DIR__ . '/../../database/user.class.php');

    $session = new Session();

    $db = getDatabaseConnection();

    drawHeader();

    if (!($session->isLoggedIn()) || User::getUserTypeByUsername($db, $session->getName()) != 'admin') {
        header('Location: ../index.php');
        exit();
    }

    $department = Department::getDepartmentByName($db, $_GET['name']);

    drawDepartment($department);

    drawFooter();

?> -->

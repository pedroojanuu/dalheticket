<?php
    declare(strict_types=1);

    require_once(__DIR__ . '/../templates/common.tpl.php');
    require_once(__DIR__ . '/../utils/session.php');

    require_once(__DIR__ . '/../database/user.class.php');
    require_once(__DIR__ . '/../database/department.class.php');
    require_once(__DIR__ . '/../database/connection.db.php');

    $db = getDatabaseConnection();

    if (!($session->isLoggedIn()) || User::getUserTypeByUsername($db, $session->getName()) != 'admin') {
        header('Location: ../index.php');
    }

    drawHeader();

    $department = Department::getDepartmentByName($db, $_GET['name']);
?>

    <h3>Changing Department <?= $_GET['name'] ?>'s name</h3>
    Select the new name for <?= $_GET['name'] ?>:
    <form action="../actions/action_change_department_name.php" method="post">
        <input type="text" name="new" placeholder="New Name" value="<?= $department->name ?>">
        <input type="hidden" name="name" value="<?=$_GET['name']?>">
        <button type="submit">Save</button>
    </form>

<?php
    drawFooter();
?>

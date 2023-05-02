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

    if (User::getUserTypeByUsername($db, $_GET['username']) != 'agent') {
        header('Location: ../pages/profile.php?username=' . $_GET['username']);
    }

    drawHeader();

    $current_depart = User::getAgentDep($db, $_GET['username']);
?>

    <h3>Changing Agent <?= $_GET['username'] ?>'s department</h3>
    Select the department you want <?= $_GET['username'] ?> to become part of:
    <form class="radio_form" action="../actions/action_change_agent_department.php" method="post">
<?php
    foreach (Department::getAllDepartments($db) as $department) { ?>
        <span class="radio_span">
        <input type="radio" name="department" value="<?= $department->name ?>" <?= $current_depart==$department->name? 'checked' : '' ?>>
        <p><?= $department->name ?></p>
        </span>
<?php
    }
?>
        <input type="hidden" name="username" value="<?=$_GET['username']?>">
        <button type="submit">Save</button>
    </form>

<?php
    drawFooter();
?>

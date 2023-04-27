<?php

    declare(strict_types=1);
    
    require_once(__DIR__ . '/../database/department.class.php');
    require_once(__DIR__ . '/../database/connection.db.php');

    $db = getDatabaseConnection();

    function drawDepartmentsList() : void {
        global $db;
        $departments = Department::getAllDepartments($db); ?>
    <div class="department_options">
        <a class="create" href="../pages/create_department.php">Create a new department...</a>
        <input class="searchbar" type="text" placeholder="Search...">
    </div>
    <ul class="search_list">
<?php
        foreach ($departments as $department) { ?>
        <li class="search_item"><a href="../pages/department.php?name=<?= $department->name ?>"><?= $department->name ?></a></li>
<?php
        }
?>
    </ul>
<?php
    }

    function drawDepartment(Department $department) : void {
        global $session, $db;
        $my_type = $session->isLoggedIn()? User::getUserTypeByUsername($db, $session->getName()) : null;
?>
    <h3 class="name"><?= $department->name ?></h3>
    <div class="dep_options">
        <a href="../actions/action_delete_department.php?name=<?= $department->name ?>">Delete...</a>
        <br>
        <a href="../pages/change_department_name.php?name=<?= $department->name ?>">Change name...</a>
    </div>
    <ul class="search_list">
    Member Agents:
<?php
    foreach ($department->getMemberAgents($db) as $agent) {
?>
    <li>
        <a href="../pages/profile.php?username=<?= $agent->username ?>"><?= $agent->username ?></a>
    </li>
<?php
    }
?>
    </ul>
<?php
    }
?>

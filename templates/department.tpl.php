<?php

    declare(strict_types=1);
    
    require_once(__DIR__ . '/../database/department.class.php');
    require_once(__DIR__ . '/../database/connection.db.php');

    $db = getDatabaseConnection();

    function drawDepartmentsList() : void {
        global $db;
        $departments = Department::getAllDepartments($db); ?>
    <input type="text" placeholder="Search...">
    <ul class="search_list">
<?php
        foreach ($departments as $department) { ?>
        <li><a href="../pages/department.php?name=<?= $department->name ?>"><?= $department->name ?></a></li>
<?php
        }
?>
    </ul>
<?php
    }
?>

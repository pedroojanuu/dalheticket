<?php

    declare(strict_types=1);
    
    require_once(__DIR__ . '/../../database/department.class.php');
    require_once(__DIR__ . '/../../database/connection.db.php');

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
        <li class="search_item"><a href="../pages/departmentDetails.php?name=<?= $department->name ?>"><?= $department->name ?></a></li>
<?php
        }
?>
    </ul>
<?php
    }


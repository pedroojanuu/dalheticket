<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../database/connection.db.php');
    $db = getDatabaseConnection();

    require_once(__DIR__ . '/../database/user.class.php');

    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();

    function drawDepartment(String $department) : void {
        global $session, $db;
    ?>

    <h3> Department: <?= $department ?> </h3>
    <p> All tickets of this department: </p>
<?php }
?>

<?php
    declare(strict_types = 1); 

    require_once(__DIR__ . '/../database/user.class.php');

    function drawProfile(User $user) : void {?>

    <h3 class="name"><?= $user->name?></h3>
    <div class="username"><?= $user->username?></div>
    <div class="email"><?= $user->email?></div>
    <div class="type">User type: <?= $user->type?></div>
    <?php
    if ($user->type == 'agent') { ?>
        <div class="department">Department: <?= $user->department?></div>
<?php } ?>
    <a href="change_password.php">Change password...</a>
<?php }
?>
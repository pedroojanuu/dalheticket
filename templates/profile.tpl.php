<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../database/connection.db.php');
  $db = getDatabaseConnection();

  require_once(__DIR__ . '/../database/user.class.php');

  require_once(__DIR__ . '/../utils/session.php');

  function drawProfile(User $user) : void {
    global $session, $db;
    $my_type = $session->isLoggedIn()? User::getUserTypeByUsername($db, $session->getName()) : null;
  ?>
  <h3 class="name"><span class="content"><?= $user->name?></span>
    <?php if ($my_type == 'admin' || $session->getName() == $user->username) { ?>
      <a class="change_profile_attribute" name="name">Change...</a>
    <?php } ?>
  </h3>
  <div class="username"><span class="bold">Username:</span> <span class="content"><?= $user->username?></span></div>
  <div class="email"><span class="bold">E-mail address:</span> <span class="content"><?= $user->email?></span>
    <?php if ($my_type == 'admin' || $session->getName() == $user->username) { ?>
      <a class="change_profile_attribute" name="email">Change...</a>
    <?php } ?>
  </div>
  <div class="type"><span class="bold">User type:</span> <?= ($user->type == 'admin')? 'Administrator' : (($user->type == 'agent')? 'Agent' : 'Client')?>
<?php
    if ($my_type == 'admin') { ?>
  <a class="change_profile_attribute" href="change_user_type.php?username=<?= $user->username?>">Change...</a>
<?php } ?>
  </div>
<?php if ($user->type == 'agent') { ?>
  <div class="agent_department"><span class="bold">Department: </span><?= ($user->department != '')? $user->department : 'None' ?>
<?php 
      if ($my_type == 'admin') {?>
  <a class="change_profile_attribute" href="change_agent_department.php?username=<?= $user->username?>">Change...</a>
<?php } ?>
  </div>
  <div class="assigned_tickets">Assigned Tickets: <?= $user->ticket_count ?></div>
  <div class="solved_tickets">Solved tickets: <?= $user->closed_tickets ?></div>
<?php
  }
    if ($my_type == 'admin' || $session->getName() == $user->username) {
?>
  <a href="change_password.php?username=<?= $user->username ?>">Change password...</a>
<?php
    }
  } ?>

<?php function drawRegisterForm() { ?>
  <form action="../actions/action_register.php" method="post" class="register">
    <label for="name">Name</label>
    <input type="text" name="name" id="name">
    <label for="username">Username</label>
    <input type="text" name="username" id="username">
    <label for="email">Email address</label>
    <input type="email" name="email" id="email">
    <label for="password">Enter a password</label>
    <input type="password" name="password" id="password">
    <label for="password2">Confirm the password</label>
    <input type="password" name="password2" id="password2">
    <button type="submit">Register</button>
  </form>
  <?php global $session; ?>
  <section id="messages">
    <?php foreach ($session->getMessages() as $message) { 
      if (str_starts_with($message['type'], 'Register')) { ?>
    <article class="<?=$message['type']?>">
      <?=$message['text']?>
    </article>
    <?php }} ?>
  </section>
<?php } ?>

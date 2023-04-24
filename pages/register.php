<?php
declare(strict_types = 1);

require_once(__DIR__ . '/../templates/common.tpl.php');
require_once(__DIR__ . '/../utils/session.php');

$session = new Session();

if ($session->isLoggedIn()) {
  header('Location: ../index.php');
}

drawHeader();
drawRegisterForm();
drawFooter();
?>

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
    <?php foreach ($session->getMessages() as $messsage) { ?>
    <article class="<?=$messsage['type']?>">
      <?=$messsage['text']?>
    </article>
    <?php } ?>
  </section>
<?php } ?>

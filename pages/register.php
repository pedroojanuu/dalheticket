<?php
declare(strict_types = 1);

require_once(__DIR__ . '/../templates/common.tpl.php');
require_once(__DIR__ . '/../utils/session.php');

drawHeader();
drawRegisterForm();
drawFooter();
?>

<?php function drawRegisterForm() { ?>
  <form action="../actions/action_register.php" method="post" class="register">
    <input type="text" name="name" placeholder="name">
    <input type="text" name="username" placeholder="username">
    <input type="email" name="email" placeholder="email">
    <input type="password" name="password" placeholder="password">
    <input type="password" name="password2" placeholder="confirm password">
    <button type="submit">Register</button>
  </form>
  <?php $session = new Session(); ?>
  <section id="messages">
      <?php foreach ($session->getMessages() as $messsage) { ?>
        <article class="<?=$messsage['type']?>">
          <?=$messsage['text']?>
        </article>
      <?php } ?>
    </section>
<?php } ?>

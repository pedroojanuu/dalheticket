<?php 
  declare(strict_types = 1); 
  $name = 'Dá-lhe Ticket';

  require_once(__DIR__ . '/../utils/session.php');
  $session = new Session();
?>

<?php function drawHeader() {
  global $session; ?>
<!DOCTYPE html>
<html lang="en-US">
  <head>
    <title><?php global $name; echo $name; ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  </head>
  <body>
    <header>
      <h1><a href="/"><?php global $name; echo $name; ?></a></h1>
    </header>

    <main>
      <a href="../pages/faqs.php" class="faqs">FAQs</a>
<?php
  if ($session->isLoggedIn()) {
    drawLogoutForm($session);
  } else {
    drawLoginForm($session);
  }
} ?>

<?php function drawFooter() { ?>
    </main>

    <footer>
      <?php global $name; echo $name; ?> &copy; 2023
    </footer>
  </body>
</html>
<?php } ?>

<?php function drawLoginForm(Session $session) { ?>
  <form action="../actions/action_login.php" method="post" class="login">
    <label for="email">Email address</label>
    <input type="email" name="email" id="email">
    <label for="password">Password</label>
    <input type="password" name="password" id="password">
    Don't have an account yet? 
    <a href="../pages/register.php">Register</a>
    <button type="submit">Login</button>
  </form>

  <section id="messages">
      <?php foreach ($session->getMessages() as $messsage) { ?>
        <article class="<?=$messsage['type']?>">
          <?=$messsage['text']?>
        </article>
      <?php } ?>
  </section>

<?php } ?>

<?php function drawLogoutForm(Session $session) { ?>
  <form action="../actions/action_logout.php" method="post" class="logout">
    <a href="../pages/profile.php?username=<?=$session->getName()?>"><?=$session->getName()?></a>
    <button type="submit">Logout</button>
  </form>
<?php } ?>

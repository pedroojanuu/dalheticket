<?php 
  declare(strict_types = 1); 
  $name = 'Dá⬝lhe Ticket';

  require_once(__DIR__ . '/../utils/session.php');
  $session = new Session();
?>

<?php function drawHeader(bool $is_index = false) {
  global $session; ?>
<!DOCTYPE html>
<html lang="en-US">
  <head>
    <title><?php global $name; echo $name; ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php if($is_index){ ?>
      <link rel="stylesheet" href="../css/index.css"> 
      <link rel="stylesheet" href="../css/animation.css"> 
      <script src="../js/animation.js" defer></script>
    <?php } else { ?>
      <link rel="stylesheet" href="../css/style.css">
      <link rel="stylesheet" href="../css/header.css">
      <script src="../js/search.js" defer></script>
    <?php } ?>
  </head>
  <body>
    <header>
      <h1 class="hidden"><a href="/"><?php global $name; echo $name; ?></a></h1>
      <section class="header_options hidden">
        <a href="../pages/faqs.php" class="faqs">FAQs</a>
      </section>
      <section class="header_login hidden">
        <?php
          if ($session->isLoggedIn()) {
            drawLogoutForm($session);
          } else {
            drawLoginForm($session);
          } ?>
      </section>
    </header>

    <main>
<?php } ?>

<?php function drawFooter() { ?>
    </main>

    <footer class="hidden">
      <?php global $name; echo $name; ?> &copy; 2023
    </footer>
  </body>
</html>
<?php } ?>

<?php function drawLoginForm(Session $session) { ?>
  <section class="login hidden">
    <form action="../actions/action_login.php" method="post" class="login_form">
      <label for="email">Email address</label>
      <input type="email" name="email" id="email">
      <label for="password">Password</label>
      <input type="password" name="password" id="password">
      <button type="submit">Login</button>
    </form>

    <p> Don't have an account yet? </p>
    <a href="../pages/register.php">Register</a>

    <section id="messages">
        <?php foreach ($session->getMessages() as $message) {
          if (str_starts_with($message['type'], "Login")) {?>
          <article class="<?=$message['type']?>">
            <?=$message['text']?>
          </article>
        <?php }} ?>
    </section>
  </section>

  <a href = "../index.php" class="login_hidden">Login</a>

<?php } ?>

<?php function drawLogoutForm(Session $session) { ?>
  <form action="../actions/action_logout.php" method="post" class="logout hidden">
    <a href="../pages/profile.php?username=<?=$session->getName()?>"><?=$session->getName()?></a>
    <button type="submit">Logout</button>
  </form>
<?php } ?>

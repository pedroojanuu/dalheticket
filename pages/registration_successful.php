<?php
declare(strict_types = 1);

require_once(__DIR__ . '/../templates/common.tpl.php');
require_once(__DIR__ . '/../utils/session.php');

drawHeader();
?>
<section id="messages">
  <?php 
  $session = new Session();
  foreach ($session->getMessages() as $messsage) { ?>
  <article class="<?=$messsage['type']?>">
    <?=$messsage['text']?>
  </article>
<?php } ?>
</section>
<?php drawFooter();
?>

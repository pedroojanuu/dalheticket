<?php
    // Include the header
    require_once(__DIR__ . '/templates/common.tpl.php');

    require_once(__DIR__ . '/utils/session.php');
    $session = new Session();


?>

<?php drawHeader(); ?>

<h1>Hello World</h1>

<?php 
    if($session->isLoggedIn()) {
        drawLogoutForm($session);
    } else {
        drawLoginForm($session);
    }
      drawFooter();
?>

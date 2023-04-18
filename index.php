<?php
    // Include the header
    require_once(__DIR__ . '/templates/common.tpl.php');

    drawHeader();
?>

<?php 
    if($session->isLoggedIn()) {
        ?>
        <div class="options">
            <a href="pages/submit_ticket.php">Submit a ticket</a>
            <a href="pages/my_tickets.php">List my tickets</a>
        </div>
    <?php
    }
      drawFooter();
?>

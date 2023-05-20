<?php

    declare(strict_types = 1);

    require_once(__DIR__ . '/../../database/faq.class.php');
    require_once(__DIR__ . '/../utils/session.php');

    function drawSubmitFAQ() {?>
      <a href="../pages/submit_faq.php" class="submit_faq_button">Submit a FAQ...</a>  
<?php }

    function drawFAQs(PDO $db) { global $session;?>
    <h3>Frequently Asked Questions</h3>
<?php
    $user_type = $session->isLoggedIn()? User::getUserTypeByUsername($db, $session->getName()) : null;

    if ($user_type == 'admin' || $user_type == 'agent') {
        drawSubmitFAQ();
    }
?>
        <div class="faq_group">
            <?php 
            foreach (FAQ::getAllFAQs($db) as $faq) {?>
            <article class="faq">
                <div class="faq_question"><?= $faq->question ?></div>
                <p class="faq_answer"><?= $faq->answer ?></p>
            </article>
            <?php }?>
        </div>
<?php }
?>

<?php

    declare(strict_types = 1);

    require_once(__DIR__ . '/../database/faq.class.php');

    function drawFAQs(PDO $db) {?>
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

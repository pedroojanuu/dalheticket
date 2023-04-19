<?php

declare(strict_types=1);

class FAQ {
    public int $id;
    public string $question;
    public string $answer;
    public function __construct(int $id, string $question, string $answer) {
        $this->id = $id;
        $this->question = $question;
        $this->answer = $answer;
    }
    static public function createAndAdd(PDO $db, string $question, string $answer) : FAQ {
        $stmt = $db->prepare('INSERT INTO FAQ (question, answer) VALUES (?, ?)');
        $stmt->execute(array($question, $answer));
        $stmt = $db->prepare('SELECT max(id) as id from FAQ');
        $stmt->execute();
        $id = $stmt->fetchAll()[0]['id'];
        return new FAQ($id, $question, $answer);
    }
    static public function getAllFAQs(PDO $db) : array {
        $stmt = $db->prepare('SELECT * from FAQ');
        $stmt->execute();

        $faqs = array();

        while($faq = $stmt->fetch()) {
            $faqs[] = new FAQ(
                intval($faq['id']),
                $faq['question'],
                $faq['answer']
            );
        }

        return $faqs;
    }
}
?>

<?php
  declare(strict_types = 1);
  require_once(__DIR__ . '/../utils/session.php');

  class Message{
    public int $id;
    public int $ticketId;
    public bool $isFromClient;
    public string $message;
    public string $author;

    public function __construct(int $id, int $ticketId, bool $isFromClient, string $message, string $author){
      $this->id = $id;
      $this->ticketId = $ticketId;
      $this->isFromClient = $isFromClient;
      $this->message = $message;
      $this->author = $author;
    }

    static public function createAndAdd(PDO $db, int $ticketId, bool $isFromClient, string $message, string $author){
      $stmt = $db->prepare('
        INSERT INTO Message (ticketId, isFromClient, message, author)
        VALUES (?, ?, ?, ?)
      ');
      $stmt->execute(array($ticketId, $isFromClient, $message, $author));
      $stmt = $db->prepare('SELECT max(id) as id from Message');
      $stmt->execute();
      $id = $stmt->fetchAll()[0]["id"];

      return new Message($id, $ticketId, $isFromClient, $message, $author);
    }

    public function isMine(PDO $db){
      $session = new Session();
      return $this->author == $session->getName();
    }

    static public function getAllMessagesFromTicket(PDO $db, int $id) : array {
        $stmt = $db->prepare('
            SELECT m.id, m.ticketId, m.isFromClient, m.message, m.author
            FROM Message m JOIN Ticket t
            ON m.ticketId = t.id
            WHERE t.id = ?
        ');
        $stmt->execute(array($id));
    
        $messages = array();
    
        while($message = $stmt->fetch()){
            $messages[] = new Message(
            $message['id'],
            intval($message['ticketId']),
            $message['isFromClient'] == 1,
            $message['message'],
            $message['author']
            );
        }
    
        return $messages;
    }

  }
?>

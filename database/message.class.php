<?php
  declare(strict_types = 1);

  class Message{
    public int $id;
    public int $ticketId;
    public bool $isFromClient;
    public string $message;

    public function __construct(int $id, int $ticketId, bool $isFromClient, string $message){
      $this->id = $id;
      $this->ticketId = $ticketId;
      $this->isFromClient = $isFromClient;
      $this->message = $message;
    }

    static public function createAndAdd(PDO $db, int $ticketId, bool $isFromClient, string $message){
      $stmt = $db->prepare('
        INSERT INTO Message (ticketId, isFromClient, message)
        VALUES (?, ?, ?)
      ');
      $stmt->execute(array($ticketId, $isFromClient, $message));
      $stmt = $db->prepare('SELECT max(id) as id from Message');
      $stmt->execute();
      $id = $stmt->fetchAll()[0]["id"];

      return new Message($id, $ticketId, $isFromClient, $message);
    }

    static function getAllMessagesFromTicket(PDO $db, string $tag) : array {
        $stmt = $db->prepare('
            SELECT m.id, m.ticketId, m.isFromClient, m.message
            FROM Message m JOIN Ticket t
            ON m.ticketId = t.id
            WHERE t.id = ?
        ');
        $stmt->execute(array($tag));
    
        $messages = array();
    
        while($message = $stmt->fetch()){
            $messages[] = new Message(
            $message['id'],
            $message['ticketId'],
            $message['isFromClient'],
            $message['message']
            );
        }
    
        return $messages;
    }

  }
?>

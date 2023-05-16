<?php
  declare(strict_types = 1);
  require_once(__DIR__ . '/../utils/session.php');
  require_once(__DIR__ . '/change.class.php');

  class Message{
    public int $id;
    public int $ticketId;
    public bool $isFromClient;
    public string $message;
    public string $author;
    public string $datetime;

    public function __construct(int $id, int $ticketId, bool $isFromClient, string $message, string $author, string $datetime){
      $this->id = $id;
      $this->ticketId = $ticketId;
      $this->isFromClient = $isFromClient;
      $this->message = $message;
      $this->author = $author;
      $this->datetime = $datetime;
    }

    static public function createAndAdd(PDO $db, int $ticketId, bool $isFromClient, string $message, string $author){
      $stmt = $db->prepare('
        INSERT INTO Message (ticketId, isFromClient, message, author, datetime)
        VALUES (?, ?, ?, ?, datetime())
      ');
      $stmt->execute(array($ticketId, $isFromClient, $message, $author));
      $stmt = $db->prepare('SELECT max(id) as id from Message');
      $stmt->execute();
      $id = $stmt->fetchAll()[0]["id"];

      return new Message($id, $ticketId, $isFromClient, $message, $author, date("Y-m-d H:i:s"));
    }

    public function isMine(PDO $db){
      $session = new Session();
      return $this->author == $session->getName();
    }

    static public function getAllMessagesFromTicket(PDO $db, int $id) : array {
        $stmt = $db->prepare('
            SELECT m.id, m.ticketId, m.isFromClient, m.message, m.author, m.datetime
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
            $message['author'],
            $message['datetime']
            );
        }
    
        return $messages;
    }

    static public function getAllMessagesAndChangesFromTicket(PDO $db, int $id) : array {
        $stmt = $db->prepare('
            SELECT m.id, m.ticketId, m.isFromClient, m.message, m.author, m.datetime
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
            $message['author'],
            $message['datetime']
            );
        }
    
        $stmt = $db->prepare('
            SELECT m.id, m.ticketId, m.agent, m.action, m.datetime
            FROM Change m JOIN Ticket t
            ON m.ticketId = t.id
            WHERE t.id = ?
        ');
        $stmt->execute(array($id));
    
        $changes = array();
    
        while($change = $stmt->fetch()){
            $changes[] = new Change(
            $change['id'],
            intval($change['ticketId']),
            $change['agent'],
            $change['action'],
            $change['datetime']
            );
        }
    
        $all = array_merge($messages, $changes);
        usort($all, function($a, $b){
            return strtotime($a->datetime) > strtotime($b->datetime);
        });
    
        return $all;
    }

  }
?>

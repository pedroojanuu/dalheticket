<?php
  declare(strict_types = 1);

  class Hashtag{
    public string $tag;

    public function __construct(PDO $db, string $tag){
      $this->tag = tag;

      $stmt = $db->prepare('
        INSERT INTO Hashtag
        VALUES (?)
      ');
      $stmt->execute(array($this->tag));
    }

    static function getAllTicketsWithTag(PDO $db, string $tag) : array {
      $stmt = $db->prepare('
        SELECT t.id, t.client, t.agent, t.status, t.message, t.department
        FROM Ticket t JOIN TicketHashtag th JOIN Hashtag h
        ON th.tag = h.tag AND t.id = th.ticketId
        WHERE h.tag = ?
      ');
      $stmt->execute(array($tag));

      $tickets = array();

      while($ticket = $stmt->fetch()){
        tickets[] = new Ticket(
          $ticket['id'],
          $ticket['client'],
          $ticket['agent'],
          $ticket['status'],
          $ticket['message'],
          $ticket['department']
        );
      }

      return $tickets;
    }

    static fucntion getAllHashtags(PDO $db) : array {
      $stmt = $db->prepare('
        SELECT tag
        FROM Hashtag
      ');
      $stmt->execute();

      $hashtags = array();

      while($hashtag = $stmt->fetch()){
        hashtags[] = new Hashtag(
          $hashtag['tag']
        );
      }

      return $hashtags;
    }

    static function getAllHashtagsInTicket(PDO $db, int $ticketId) : array {
      $stmt = $db->prepare('
        SELECT h.tag
        FROM Hashtag h JOIN TicketHashtag th
        ON h.tag = th.tag
        WHERE th.ticketId = ?
      ');
      $stmt->execute(array($ticketId));

      $hashtags = array();

      while($hashtag = $stmt->fetch()){
        hashtags[] = new Hashtag(
          $hashtag['tag']
        );
      }

      return $hashtags;
    }

    function delete(PDO $db) {
      $stmt = $db->prepare('
        DELETE FROM Hashtag
        WHERE tag = ?
      ');
      $stmt->execute(array($this->tag));
    }

  }
?>

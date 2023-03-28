<?php
  declare(strict_types = 1);

  class Department{
    public string $name;

    public function __construct(string $name){
      $this->name = $name;
    }

    static function getAllTicketsInDepartment(PDO $db, string $name) : array {
      $stmt = $db->prepare('
        SELECT t.id, t.client, t.agent, t.status, t.message, t.department
        FROM Ticket t JOIN Department d
        ON t.department = d.name
        WHERE d.name = ?
      ');
      $stmt->execute(array($name));

      $tickets = array();

      while($ticket = $stmt->fetch()){
        $tickets[] = new Ticket(
          $ticket['id'],
          $ticket['client'],
          $ticket['agent'],
          $ticket['status'],
          $ticket['department']
        );
      }

      return $tickets;
    }

  }
?>

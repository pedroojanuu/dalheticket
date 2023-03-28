<?php
  declare(strict_types = 1);

  class Department{
    public string $name;

    public function __construct(string $name){
      $this->name = name;
    }

    static public function createAndAdd(PDO $db, string $name){
      $this->name = name;

      $stmt = $db->prepare('
        INSERT INTO Department
        VALUES (?)
      ');
      $stmt->execute(array($this->name));

      return new Department($this->name);
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

  }
?>
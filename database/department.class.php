<?php
  declare(strict_types = 1);

  class Department{
    public string $name;

    public function __construct(string $name){
      $this->name = $name;
    }

    static public function createAndAdd(PDO $db, string $name){
      $stmt = $db->prepare('
        INSERT INTO Department
        VALUES (?)
      ');
      $stmt->execute(array($name));

      return new Department($name);
    }

    static public function getAllTicketsInDepartment(PDO $db, string $name) : array {
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
          $ticket['title'],
          $ticket['client'],
          $ticket['agent'],
          $ticket['status'],
          $ticket['department']
        );
      }

      return $tickets;
    }
    static public function getAllDepartments(PDO $db) : array {
      $stmt = $db->prepare('SELECT * from Department');
      $stmt->execute();

      $departments = array();

      while ($department = $stmt->fetch()) {
        $departments[] = new Department($department['name']);
      }

      return $departments;
    }

    public function getMemberAgents(PDO $db) : array {
      $stmt = $db->prepare('SELECT * FROM User WHERE department = ?');
      $stmt->execute(array($this->name));
      
      $agents = array();

      while ($agent = $stmt->fetch()) {
        $agents[] = new User(
          $agent['name'],
          $agent['username'],
          $agent['email'],
          $agent['type'],
          $agent['department'],
        );
      }

      return $agents;
    }

    static public function getDepartmentByName(PDo $db, string $name) : Department {
      $stmt = $db->prepare('SELECT * FROM Department WHERE name = ?');
      $stmt->execute(array($name));

      $query = $stmt->fetchAll()[0];

      return new Department($query['name']);
    }
  }
?>

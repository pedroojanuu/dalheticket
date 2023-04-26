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
        SELECT t.id, t.title, t.client, t.agent, t.status, t.department
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

    public function changeName(PDO $db, string $name) : void {
      $stmt = $db->prepare('UPDATE User SET department = :new WHERE department = :old');
      $stmt->bindParam(':new', $name);
      $stmt->bindParam(':old', $this->name);
      $stmt->execute();

      $stmt = $db->prepare('UPDATE Ticket SET department = :new WHERE department = :old');
      $stmt->bindParam(':new', $name);
      $stmt->bindParam(':old', $this->name);
      $stmt->execute();

      $stmt = $db->prepare('UPDATE Department SET name = :new WHERE name = :old');
      $stmt->bindParam(':new', $name);
      $stmt->bindParam(':old', $this->name);
      $stmt->execute();

      $this->name = $name;
    }

    public function delete(PDO $db) : void {
      foreach (Department::getAllTicketsInDepartment($db, $this->name) as $ticket) {
        $ticket->delete($db);
      }

      $stmt = $db->prepare('UPDATE User SET department = :empty WHERE department = :name');
      $empty_string = '';
      $stmt->bindParam(':empty', $empty_string);
      $stmt->bindParam(':name', $this->name);
      $stmt->execute();

      $stmt = $db->prepare('DELETE FROM Department WHERE name = ?');
      $stmt->execute(array($this->name));
    }
  }
?>

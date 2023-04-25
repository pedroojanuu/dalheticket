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

    static public function getAllDepartments(PDO $db) : array {
      $stmt = $db->prepare('SELECT * from Department');
      $stmt->execute();

      $departments = array();

      while ($department = $stmt->fetch()) {
        $departments[] = new Department($department['name']);
      }

      return $departments;
    }
  }
?>

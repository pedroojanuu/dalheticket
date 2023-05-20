<?php
declare(strict_types = 1);

require_once(__DIR__ . '/ticket.class.php');

class User{
  public int $id;
  public string $name;
  public string $username;
  public string $email;
  public string $type;
  public string $department;
  public int $ticket_count;
  public int $closed_tickets;

  public function __construct(string $name, string $username, string $email, string $type, $department, int $ticket_count, int $closed_tickets){
    $this->name = $name;
    $this->username = $username;
    $this->email = $email;
    $this->type = $type;
    $this->department = $department == null? '' : $department;
    $this->ticket_count = $ticket_count;
    $this->closed_tickets = $closed_tickets;
  }
  static public function createAndAdd(PDO $db, string $name, string $username, string $email, string $password, string $type, string $department){
    $stmt = $db->prepare(
        'INSERT INTO User
          VALUES (?,?,?,?,?,?,?,?)'
          );
    $options = ['cost' => 12];
    $stmt->execute(array($name,$username,$email,password_hash($password, PASSWORD_DEFAULT, $options),$type,$department, 0, 0));

    return new User($name,$username,$email,$type,$department, 0, 0);
  }

  static public function getUserWithPassword(PDO $db, string $email, string $password) : ?User {
    $stmt = $db->prepare('
      SELECT name, username, email, password, type, department, ticket_count, closed_tickets
      FROM User
      WHERE lower(email) = ?
    ');
    $stmt->execute(array(strtolower($email)));

    
    if ($user = $stmt->fetch()) {
      $correct_password = password_verify($password, $user['password']);
      if ($correct_password) {
        return new User(
          $user['name'],
          $user['username'],
          $user['email'],
          $user['type'],
          $user['department'],
          intval($user['ticket_count']),
          intval($user['closed_tickets'])
        );
      }
    }
    return null;
  }

  static public function emailExists(PDO $db, string $email) : bool {
    $stmt = $db->prepare('
      SELECT email
      FROM User
      WHERE lower(email) = ?
    ');

    $stmt->execute(array(strtolower($email)));

    return $stmt->fetch() !== false;
  }

  static public function usernameExists(PDO $db, string $username) : bool {
    $stmt = $db->prepare('
      SELECT username
      FROM User
      WHERE lower(username) = ?
    ');

    $stmt->execute(array(strtolower($username)));

    return $stmt->fetch() !== false;
  }

  public function getRowID(PDO $db) : int {
    $stmt = $db->prepare('
      SELECT rowid
      FROM User
      WHERE username = ?
    ');

    $stmt->execute(array(strtolower($this->username)));

    return $stmt->fetch()['rowid'];
  }
  static public function getUserTypeByUsername(PDO $db, string $username) : string {
    $stmt = $db->prepare('SELECT type from User where username = ?');
    $stmt->execute(array($username));

    return $stmt->fetchAll()[0]['type'];
  }

  static public function getUserByUsername(PDO $db, string $username) : User {
    $stmt = $db->prepare('SELECT * from User where username = ?');
    $stmt->execute(array($username));

    $user = $stmt->fetchAll()[0];

    return new User(
      $user['name'],
      $user['username'],
      $user['email'],
      $user['type'],
      $user['department'],
      intval($user['ticket_count']),
      intval($user['closed_tickets'])
    );
  }

  static public function getEmailByUsername(PDO $db, string $username) : string {
    $stmt = $db->prepare('SELECT email from User where username = ?');
    $stmt -> execute(array($username));

    return $stmt->fetchAll()[0]['email'];
  }

  static public function changePassword(PDO $db, string $username, string $newpassword) : void {
    $stmt = $db->prepare('UPDATE User SET password = :new where username = :u');
    $options = ['cost' => 12];
    $newpassword = password_hash($newpassword, PASSWORD_DEFAULT, $options);
    $stmt->bindParam(':new', $newpassword);
    $stmt->bindParam(':u', $username);

    $stmt->execute();
  }

  static public function changeUserType(PDO $db, string $username, string $new_type) : void {
    $stmt = $db->prepare('UPDATE User SET type = :new where username = :u');
    $stmt->bindParam(':new', $new_type);
    $stmt->bindParam(':u', $username);
    $stmt->execute();

    if ($new_type == 'admin') {
      $stmt = $db->prepare('UPDATE User SET department = "" where username = ?');
      $stmt->execute(array($username));
    }
  }

  static public function changeAgentDep(PDO $db, string $username, string $new_dep) : void {
    $stmt = $db->prepare('UPDATE User SET department = :new where username = :u');
    $stmt->bindParam(':new', $new_dep);
    $stmt->bindParam(':u', $username);
    $stmt->execute();

    foreach (Ticket::getAllTicketsFromAgent($db, $username) as $ticket) {
      $ticket->removeAgent($db);
    }
  }

  static public function changeCertainAttribute(PDO $db, string $username, string $attribute, string $new_value) : void {
    $stmt = $db->prepare('UPDATE User SET '.$attribute.' = :new where username = :u');
    $stmt->bindParam(':new', $new_value);
    $stmt->bindParam(':u', $username);

    $stmt->execute();
  }

  static public function getAgentDep(PDO $db, string $username) : string {
    $stmt = $db->prepare('SELECT department from User where username = ?');
    $stmt->execute(array($username));

    return $stmt->fetchAll()[0]['department'];
  }

  static public function getAllUsers(PDO $db) : array {
    $stmt = $db->prepare('SELECT * from User');
    $stmt->execute();

    $users = array();

    while ($user = $stmt->fetch()) {
      $users[] = new User(
        $user['name'],
        $user['username'],
        $user['email'],
        $user['type'],
        $user['department'],
        intval($user['ticket_count']),
        intval($user['closed_tickets'])
      );
    }
    return $users;
  }

  static public function isUserAgent(PDO $db, string $username) : bool {
    $user = User::getUserByUsername($db, $username);
    return $user->type == 'agent';
  }

  static public function isUserAdmin(PDO $db, string $username) : bool {
    $user = User::getUserByUsername($db, $username);
    return $user->type == 'admin';
  }

  public function incrementAssigned(PDO $db) : void {
    $stmt = $db->prepare('UPDATE user SET ticket_count = ticket_count + 1 WHERE username = ?');
    $stmt->execute(array($this->username));

    $this->ticket_count += 1;
  }

  public function incrementSolved(PDO $db) : void {
    $stmt = $db->prepare('UPDATE user SET closed_tickets = closed_tickets + 1 WHERE username = ?');
    $stmt->execute(array($this->username));

    $this->closed_tickets += 1;
  }

  static public function getTopAgents(PDO $db) : array {
    $stmt = $db->prepare('SELECT * FROM User WHERE type = "agent" ORDER BY closed_tickets DESC LIMIT 10');
    $stmt->execute();

    $agents = array();

    while ($agent = $stmt->fetch()) {
      $agents[] = new User(
        $agent['name'],
        $agent['username'],
        $agent['email'],
        $agent['type'],
        $agent['department'],
        intval($agent['ticket_count']),
        intval($agent['closed_tickets'])
      );
    }

    return $agents;
  }
}
?>

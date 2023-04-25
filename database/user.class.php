<?php
declare(strict_types = 1);

class User{
  public int $id;
  public string $name;
  public string $username;
  public string $email;
  public string $type;
  public string $department;

  public function __construct(string $name, string $username, string $email, string $type, string $department){
    $this->name = $name;
    $this->username = $username;
    $this->email = $email;
    $this->type = $type;
    $this->department = $department;
  }
  static public function createAndAdd(PDO $db, string $name, string $username, string $email, string $password, string $type, string $department){
    $stmt = $db->prepare(
        'INSERT INTO User
          VALUES (?,?,?,?,?,?)'
          );
    $stmt->execute(array($name,$username,$email,sha1($password),$type,$department));

    return new User($name,$username,$email,$type,$department);
  }

  static public function getUserWithPassword(PDO $db, string $email, string $password) : ?User {
    $stmt = $db->prepare('
      SELECT name, username, email, type, department
      FROM User
      WHERE lower(email) = ? AND password = ?
    ');

    $stmt->execute(array(strtolower($email), sha1($password)));

    if ($customer = $stmt->fetch()) {
      return new User(
        $customer['name'],
        $customer['username'],
        $customer['email'],
        $customer['type'],
        $customer['department'],
      );
    } else return null;
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
    );
  }

  static public function getEmailByUsername(PDO $db, string $username) : string {
    $stmt = $db->prepare('SELECT email from User where username = ?');
    $stmt -> execute(array($username));

    return $stmt->fetchAll()[0]['email'];
  }

  static public function changePassword(PDO $db, string $username, string $newpassword) : void {
    $stmt = $db->prepare('UPDATE User SET password = :new where username = :u');
    $newpassword = sha1($newpassword);
    $stmt->bindParam(':new', $newpassword);
    $stmt->bindParam(':u', $username);

    $stmt->execute();
  }

  static public function changeUserType(PDO $db, string $username, string $new_type) : void {
    $stmt = $db->prepare('UPDATE User SET type = :new where username = :u');
    $stmt->bindParam(':new', $new_type);
    $stmt->bindParam(':u', $username);

    $stmt->execute();
  }

  static public function changeAgentDep(PDO $db, string $username, string $new_dep) : void {
    $stmt = $db->prepare('UPDATE User SET department = :new where username = :u');
    $stmt->bindParam(':new', $new_dep);
    $stmt->bindParam(':u', $username);

    $stmt->execute();
  }
}
?>

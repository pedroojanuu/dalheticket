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

    static function getUserWithPassword(PDO $db, string $email, string $password) : ?User {
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

    static function emailExists(PDO $db, string $email) : bool {
        $stmt = $db->prepare('
          SELECT email
          FROM User
          WHERE lower(email) = ?
        ');
  
        $stmt->execute(array(strtolower($email)));
    
        return $stmt->fetch() !== false;
    }

    static function usernameExists(PDO $db, string $username) : bool {
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
}
?>

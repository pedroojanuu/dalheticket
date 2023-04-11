<?php
declare(strict_types = 1);

class User{
    public string $name;
    public string $username;
    public string $email;
    public string $password;
    public string $type;
    public string $department;

    public function __construct(string $name, string $username, string $email, string $password, string $type, string $department){
        $this->name = $name;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->type = $type;
        $this->department = $department;
    }
    static public function createAndAdd(PDO $db, string $name, string $username, string $email, string $password, string $type, string $department){
        $stmt = $db->prepare(
            'INSERT INTO User
             VALUES (?,?,?,?,?,?)'
             );
        $stmt->execute(array($name,$username,$email,$password,$type,$department))
    }
}

?>
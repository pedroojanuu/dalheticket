<?php
declare(strict_types = 1);

class Change{
    int $id;
    int $ticketId;
    string $agent;
    string $action;

    public function __construct(int $id, int $ticketId, string $agent, string $action){
        $this->id = $id;
        $this->ticketId = $ticketId;
        $this->agent = $agent;
        $this->action = $action;
    }
    static public function createAndAdd(PDO $db, int $id, int $ticketId, string $agent, string $action){
        $stmt = $db->prepare(
            'INSERT INTO User
             VALUES (?,?,?,?,?,?)'
             );
        $stmt->execute(array($id, $ticketId, $agent, $action));
    }
}
?>
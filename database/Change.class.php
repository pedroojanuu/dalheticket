<?php
declare(strict_types = 1);

class Change{
    public int $id;
    public int $ticketId;
    public string $agent;
    public string $action;

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
    static function getAllChangesFromTicket(PDO $db, string $tag) : array {
        $stmt = $db->prepare('
            SELECT m.id, m.ticketId, m.agent, m.action
            FROM Change m JOIN Ticket t
            ON m.ticketId = t.id
            WHERE t.id = ?
        ');
        $stmt->execute(array($tag));
    
        $changes = array();
    
        while($change = $stmt->fetch()){
            $changes[] = new Change(
            $change['id'],
            $change['ticketId'],
            $change['agent'],
            $change['action']
            );
        }
    
        return $changes;
    }
}
?>

<?php
declare(strict_types = 1);

class Change{
    public int $id;
    public int $ticketId;
    public ?string $agent;
    public string $action;

    public function __construct(int $id, int $ticketId, ?string $agent, string $action, string $datetime){
        $this->id = $id;
        $this->ticketId = $ticketId;
        $this->agent = $agent;
        $this->action = $action;
        $this->datetime = $datetime;
    }
    static public function createAndAdd(PDO $db, int $ticketId, ?string $agent, string $action) : Change {
        $stmt = $db->prepare(
            'INSERT INTO Change (ticketId, agent, action, datetime)
             VALUES (?,?,?, datetime())'
             );
        $stmt->execute(array($ticketId, $agent, $action));
        $stmt = $db->prepare('SELECT max(id) as id from Change;');
        $stmt->execute();
        $id = $stmt->fetch()['id'];
        return new Change($id, $ticketId, $agent, $action, date("Y-m-d H:i:s"));
    }
    static public function getAllChangesFromTicket(PDO $db, string $tag) : array {
        $stmt = $db->prepare('
            SELECT m.id, m.ticketId, m.agent, m.action, m.datetime
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
            $change['action'],
            $change['datetime']
            );
        }
    
        return $changes;
    }
}
?>

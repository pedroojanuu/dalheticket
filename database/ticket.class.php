<?php
declare(strict_types = 1);

require_once(__DIR__ . '/hashtag.class.php');
require_once(__DIR__ . '/change.class.php');

class Ticket {
    public int $id;
    public string $title;
    public string $client;
    public ?string $agent;
    public string $status;
    public string $department;

    public function __construct(int $id, string $title, string $client, ?string $agent, string $status, string $department) {
        $this->id = $id;
        $this->title = $title;
        $this->client = $client;
        $this->agent = $agent;
        $this->status = $status;
        $this->department = $department;
    }

    static public function createAndAdd(PDO $db, string $title, string $client, string $department) : Ticket {
        $stmt = $db->prepare('INSERT INTO Ticket (title, client, agent, status, department) VALUES (?, ?, ?, ?, ?)');
        $stmt->execute(array($title, $client, '', 'Unsolved', $department));
        $stmt = $db->prepare('SELECT max(id) as id from Ticket');
        $stmt->execute();
        $id = $stmt->fetchAll()[0]["id"];
        return new Ticket($id, $title, $client, "", "Unsolved", $department);
    }
    public function setDepartment(PDO $db, string $department) {
        Change::createAndAdd($db, $this->id, $this->agent, "
        The department of the ticket was changed from " . $this->department . 
        " to " . $department . ".");
        $this->department = $department;

        $stmt = $db->prepare('UPDATE Ticket SET department = :department WHERE id = :id');
        $stmt->bindParam(':department', $department);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();
    }
    public function setAgent(PDO $db, string $agent) : void {
        Change::createAndAdd($db, $this->id, $this->agent, "
        The agent of the ticket was changed from " . $this->agent . 
        " to " . $agent . ".");
        $this->agent = $agent;

        $stmt = $db->prepare('UPDATE Ticket SET agent = :agent WHERE id = :id');
        $stmt->bindParam(':agent', $agent);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();
    }

    public function removeAgent(PDO $db) : void {
        Change::createAndAdd($db, $this->id, $this->agent, "
        The agent abandoned the ticket");
        $this->agent = "";

        $stmt = $db->prepare('UPDATE Ticket SET agent = :agent WHERE id = :id');
        $stmt->bindParam(':agent', $agent);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();
    }

    public function setStatus(PDO $db, string $status) : void {
        Change::createAndAdd($db, $this->id, $this->agent, "
        The status of the ticket was changed from " . $this->status . 
        " to " . $status . ".");
        $this->status = $status;

        $stmt = $stmt = $db->prepare('UPDATE Ticket SET status = :status WHERE id = :id');
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();
    }

    static public function getAllTickets(PDO $db) : array {
        $stmt = $db->prepare('SELECT * from Ticket');
        $stmt->execute();

        $tickets = array();

        while ($ticket = $stmt->fetch()) {
            $tickets[] = new Ticket(
                $ticket['id'],
                $ticket['title'],
                $ticket['client'],
                $ticket['agent'],
                $ticket['status'],
                $ticket['department']);
        }

        return $tickets;
    }

    public function getHashtags(PDO $db) : array {
        $stmt = $db->prepare('SELECT h.tag FROM Hashtag h JOIN TicketHashtag th ON h.tag = th.tag WHERE th.ticketId = ?');
        $stmt->execute(array($this->id));

        $hashtags = array();

        while($hashtag = $stmt->fetch()){
            $hashtags[] = new Hashtag($hashtag['tag']);
        }
        return $hashtags;
    }

    static public function getAllTicketsFromClient(PDO $db, string $client) : array {
        $stmt = $db->prepare('SELECT * from Ticket WHERE client = ?');
        $stmt->execute(array($client));
    
        $tickets = array();
    
        while ($ticket = $stmt->fetch()) {
            $tickets[] = new Ticket(
                $ticket['id'],
                $ticket['title'],
                $ticket['client'],
                $ticket['agent'],
                $ticket['status'],
                $ticket['department']);
        }
    
        return $tickets;
    }

    static public function getAllTicketsFromAgent(PDO $db, string $client) : array {
        $stmt = $db->prepare('SELECT * from Ticket WHERE agent = ?');
        $stmt->execute(array($client));
    
        $tickets = array();
    
        while ($ticket = $stmt->fetch()) {
            $tickets[] = new Ticket(
                $ticket['id'],
                $ticket['title'],
                $ticket['client'],
                $ticket['agent'],
                $ticket['status'],
                $ticket['department']);
        }
    
        return $tickets;
    }

    static public function getTicketById(PDO $db, int $id) : Ticket {
        $stmt = $db->prepare('SELECT * from Ticket WHERE id = ?');
        $stmt->execute(array($id));

        $line = $stmt->fetchAll()[0];

        $ticket = new Ticket(
            $line['id'],
            $line['title'],
            $line['client'],
            $line['agent'],
            $line['status'],
            $line['department'],
        );

        return $ticket;
    }
    
    public function delete(PDO $db) : void {
        $stmt = $db->prepare('DELETE FROM Message WHERE ticketId = ?');
        $stmt->execute(array($this->id));

        $stmt = $db->prepare('DELETE FROM Change WHERE ticketId = ?');
        $stmt->execute(array($this->id));

        $stmt = $db->prepare('DELETE FROM TicketHashtag WHERE ticketId = ?');
        $stmt->execute(array($this->id));

        $stmt = $db->prepare('DELETE FROM Ticket WHERE id = ?');
        $stmt->execute(array($this->id));
    }


    static public function getAllTicketsInDepartment(PDO $db, string $name) : array {
        $stmt = $db->prepare("
            SELECT id, title, client, agent, status, department
            FROM Ticket
            WHERE department = ?
        ");
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

    static public function countUnsolvedTickets(PDO $db) : int {
        $stmt = $db->prepare('SELECT count(*) AS count FROM Ticket WHERE status = "Unsolved"');
        $stmt->execute();

        return intval($stmt->fetchAll()[0]['count']);
    }

    static public function countSolvedTickets(PDO $db) : int {
        $stmt = $db->prepare('SELECT count(*) AS count FROM Ticket WHERE status = "Solved"');
        $stmt->execute();

        return intval($stmt->fetchAll()[0]['count']);
    }

    public function addHashtag(PDO $db, Hashtag $hashtag) : void {
        $stmt = $db->prepare('INSERT INTO TicketHashtag VALUES (?,?)');
        $stmt->execute(array($this->id, $hashtag->tag));
    }
}
?>

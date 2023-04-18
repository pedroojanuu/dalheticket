<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/hashtag.class.php');
    require_once(__DIR__ . '/change.class.php');

    class Ticket {
        public int $id;
        public string $client;
        public string $agent;
        public string $status;
        public string $department;

        public function __construct(int $id, string $client, string $agent, string $status, string $department) {
            $this->id = $id;
            $this->client = $client;
            $this->agent = $agent;
            $this->status = $status;
            $this->department = $department;
        }

        static public function createAndAdd(PDO $db, string $client, string $department) : Ticket {
            $stmt = $db->prepare('INSERT INTO Ticket (client, agent, status, department) VALUES (?, ?, ?, ?)');
            $stmt->execute(array($client, null, 'Unsolved', $department));
            $stmt = $db->prepare('SELECT max(id) as id from Ticket');
            $stmt->execute();
            $id = $stmt->fetchAll()[0]["id"];
            return new Ticket($id, $client, "", "Unsolved", $department);
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

        static function getAllTickets(PDO $db) : array {
            $stmt = $db->prepare('SELECT * from Ticket');
            $stmt->execute();

            $tickets = array();

            while ($ticket = $stmt->fetch()) {
                $tickets[] = new Ticket(
                    $ticket['id'],
                    $ticket['client'],
                    $ticket['agent'],
                    $ticket['status'],
                    $ticket['department']);
            }

            return $tickets;
        }

        function getHastags(PDO $db) : array {
            $stmt = $db->prepare('SELECT h.tag FROM Hashtag h JOIN TicketHashtag th ON h.tag = th.tag WHERE th.ticketId = ?');
            $stmt->execute(array($this->id));

            $hashtags = array();

            while($hashtag = $stmt->fetch()){
                $hashtags[] = new Hashtag($hashtag['tag']);
            }
            return $hashtags;
        }
    }
?>

<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/hashtag.class.php');

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

        static public function createAndAdd(PDO $db, int $id, string $client) : void {
            $stmt = $db->prepare('INSERT INTO Ticket VALUES (?)');
            $stmt->execute(array($id, $client, null, 'Unsolved', null));
        }

        public function setAgent(PDO $db, string $agent) : void {
            $this->agent = $agent;

            $stmt = $db->prepare('UPDATE Ticket SET agent = :agent WHERE id = :id');
            $stmt->bindParam(':agent', $agent);
            $stmt->bindParam(':id', $this->id);
            $stmt->execute();
        }

        public function setStatus(PDO $db, string $status) : void {
            $this->status = $status;

            $stmt = $stmt = $db->prepare('UPDATE Ticket SET status = :status WHERE id = :id');
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':id', $this->id);
            $stmt->execute();
        }

        public function setDepartment(PDO $db, string $department) : void {
            $this->department = $department;

            $stmt = $stmt = $db->prepare('UPDATE Ticket SET department = :department WHERE id = :id');
            $stmt->bindParam(':department', $department);
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
                $hashtags[] = new Hashtag($db, $hashtag['tag']);
            }
            return $hashtags;
        }
    }
?>

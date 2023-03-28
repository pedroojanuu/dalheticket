<?php
    declare(strict_types = 1);

    class Ticket {
        public int $id;
        public string $client;
        public string $agent;
        public string $status;
        public string $department;

        public function __construct(PDO $db, int $id, string $client) {
            $this->id = $id;
            $this->client = $client;
            $this->status = 'Unsolved';

            $stmt = $db->prepare('INSERT INTO Ticket VALUES (?)');
            $stmt->execute(array($this->id, $this->client, null, $this->status, null));
        }

        public function setAgent(PDO $db, string $agent) {
            $this->agent = $agent;

            $stmt = $db->prepare('UPDATE Ticket SET agent = :agent WHERE id = :id');
            $stmt->bindParam(':agent', $agent);
            $stmt->bindParam(':id', $this->id);
            $stmt->execute();
        }

        public function setStatus(PDO $db, string $status) {
            $this->status = $status;

            $stmt = $stmt = $db->prepare('UPDATE Ticket SET status = :status WHERE id = :id');
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':id', $this->id);
            $stmt->execute();
        }

        public function setDepartment(PDO $db, string $department) {
            $this->department = $department;

            $stmt = $stmt = $db->prepare('UPDATE Ticket SET department = :department WHERE id = :id');
            $stmt->bindParam(':department', $department);
            $stmt->bindParam(':id', $this->id);
            $stmt->execute();
        }
    }
?>
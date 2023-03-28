<?php

    declare(strict_types = 1);

    class Ticket {
        public int $id;
        public string $client;
        public string $agent;
        public string $status;
        public string $department;

        public function __construct(int $id, string $client) {
            $this->id = $id;
            $this->client = $client;
            $this->status = 'Unsolved';
        }
    }

?>
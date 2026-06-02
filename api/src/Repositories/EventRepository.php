<?php

namespace App\Repositories;

use PDO;

class EventRepository {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create($organizer_id, $name, $start_time, $end_time, $description, $category) {
        $query = "INSERT INTO events (organizer_id, name, start_time, end_time, description, category) 
                  VALUES (:organizer_id, :name, :start_time, :end_time, :description, :category)";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':organizer_id', $organizer_id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':start_time', $start_time);
        $stmt->bindParam(':end_time', $end_time);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':category', $category);
        
        return $stmt->execute();
    }

    public function findAllFutureEvents() {
        $query = "SELECT * FROM events WHERE start_time > NOW() ORDER BY start_time ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function findByOrganizer($organizer_id) {
        $query = "SELECT * FROM events WHERE organizer_id = :organizer_id ORDER BY start_time DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':organizer_id', $organizer_id);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById($id) {
        $query = "SELECT * FROM events WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

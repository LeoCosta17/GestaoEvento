<?php

namespace App\Repositories;

use PDO;

class SubscriptionRepository {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function subscribe($user_id, $event_id) {
        try {
            $query = "INSERT INTO subscriptions (user_id, event_id) VALUES (:user_id, :event_id)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':event_id', $event_id);
            return $stmt->execute();
        } catch (\PDOException $e) {
            // Se houver erro de unique constraint
            if ($e->getCode() == 23000) {
                return false; 
            }
            throw $e;
        }
    }

    public function unsubscribe($user_id, $event_id) {
        $query = "DELETE FROM subscriptions WHERE user_id = :user_id AND event_id = :event_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':event_id', $event_id);
        return $stmt->execute();
    }

    public function findByUser($user_id) {
        $query = "SELECT e.* FROM events e 
                  JOIN subscriptions s ON e.id = s.event_id 
                  WHERE s.user_id = :user_id ORDER BY e.start_time ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function countByEvent($event_id) {
        $query = "SELECT COUNT(*) as total FROM subscriptions WHERE event_id = :event_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':event_id', $event_id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'];
    }
}

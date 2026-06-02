<?php

namespace App\Repositories;

use PDO;

class UserRepository {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create($type, $name, $document, $email, $password) {
        $query = "INSERT INTO users (type, name, document, email, password) VALUES (:type, :name, :document, :email, :password)";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':type', $type);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':document', $document);
        $stmt->bindParam(':email', $email);
        
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt->bindParam(':password', $hashed_password);

        return $stmt->execute();
    }

    public function findByEmail($email) {
        $query = "SELECT * FROM users WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function findByDocument($document) {
        $query = "SELECT * FROM users WHERE document = :document LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':document', $document);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

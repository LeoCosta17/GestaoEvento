<?php

namespace App\Config;

use PDO;
use PDOException;

class Database {
    private $host = "localhost";
    private $db_name = "cadeventos";
    private $username = "root";
    private $password = "12345";
    private $port = "3307";
    public $conn;

    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->exec("set names utf8");
        } catch(PDOException $exception) {
            \App\Utils\Response::json(500, null, "Database Connection Error: " . $exception->getMessage());
        }

        return $this->conn;
    }
}

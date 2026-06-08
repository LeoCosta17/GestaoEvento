<?php

namespace App\Config;

use PDO;
use PDOException;

class Database {
    private $host;
    private $db_name;
    private $username;
    private $password;
    private $port;
    public $conn;

    public function __construct() {
        // Fallbacks para ambiente local, sobrescritos pelo Railway via Variáveis de Ambiente
        $this->host = getenv('MYSQLHOST') ?: "localhost";
        $this->db_name = getenv('MYSQLDATABASE') ?: "cadeventos";
        $this->username = getenv('MYSQLUSER') ?: "root";
        $this->password = getenv('MYSQLPASSWORD') !== false ? getenv('MYSQLPASSWORD') : "12345";
        $this->port = getenv('MYSQLPORT') ?: "3307";
    }

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

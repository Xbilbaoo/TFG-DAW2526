<?php
namespace Config;

class Database
{
    private static $instance = null;
    private $connection;

    private function __construct(){
        $host = $_SERVER['DB_HOST'] ?? $_ENV['DB_HOST'] ?? getenv('DB_HOST') ?: 'base-datos';
        $user = $_SERVER['DB_USER'] ?? $_ENV['DB_USER'] ?? getenv('DB_USER') ?: 'root';
        $password = $_SERVER['DB_PASS'] ?? $_ENV['DB_PASS'] ?? getenv('DB_PASS') ?: 'root';
        $dbName = $_SERVER['DB_NAME'] ?? $_ENV['DB_NAME'] ?? getenv('DB_NAME') ?: 'tfgDAW2526';
        // Añadimos el puerto:
        $port = $_SERVER['DB_PORT'] ?? $_ENV['DB_PORT'] ?? getenv('DB_PORT') ?: 3306;

        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

        // Pasamos el puerto como quinto argumento
        $this->connection = new \mysqli($host, $user, $password, $dbName, (int)$port);

        if ($this->connection->connect_error) {
            throw new \Exception("Error: " . $this->connection->connect_error);
        }

        $this->connection->set_charset("utf8mb4");
    }

    public static function getInstance(){
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection(){
        return $this->connection;
    }

    public function closeConnection(){
        if ($this->connection) {
            $this->connection->close();
            self::$instance = null;
        }
    }
    public function getError() {
        return $this->connection->error;
    }
    public function isConnected() {
        return $this->connection !== null && !$this->connection->connect_error;
    }

    public static function testConnection() {
        try {
            $instance = self::getInstance();
            return $instance->isConnected();
        } catch (\Exception $e) {
            return false;
        }
    }
}
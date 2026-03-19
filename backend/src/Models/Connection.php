<?php
namespace Models;

class Connection
{
    private static $instance = null;
    private $connection;

    private function __construct(){
        $host = 'base-datos';
        $user = 'root';
        $password = 'root';
        $dbName = 'tfgDAW2526';

        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $this->connection = new \mysqli($host, $user, $password, $dbName);

        if ($this->connection->connect_error) {
            throw new \Exception("Error: " . $this->connection->connect_error);
        }

        $this->connection->set_charset("utf8mb4");
    }

    public static function getInstance(){
        if (self::$instance === null) {
            self::$instance = new Connection();
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
?>
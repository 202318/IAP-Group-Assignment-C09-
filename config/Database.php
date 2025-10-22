<?php
class Database {
    private $host = "127.0.0.1";
    private $port = "3307"; // important: your phpMyAdmin URL shows port 3307
    private $db_name = "bookstore";
    private $username = "root";
    private $password = "0000"; // if this fails, try an empty string ''
    public $conn;

    public function connect() {
        $this->conn = null;
        try {
            $dsn = "mysql:host={$this->host};port={$this->port};dbname={$this->db_name}";
            $this->conn = new PDO($dsn, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "<p style='color:green;'>✅ Connected successfully to bookstore DB!</p>";
        } catch (PDOException $e) {
            echo "<p style='color:red;'>❌ Connection error: " . $e->getMessage() . "</p>";
        }
        return $this->conn;
    }
}
?>

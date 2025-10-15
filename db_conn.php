<?php
class Database {
    private $host = 'localhost';
    private $username = 'root';
    private $password = ''; // leave blank unless you set one
    private $dbname = 'Bookstore'; // 👈 must match phpMyAdmin exactly
    private $conn;

    public function connect() {
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->dbname);

        if ($this->conn->connect_error) {
            die("❌ Connection failed: " . $this->conn->connect_error);
        } else {
            echo "✅ Connected successfully to Bookstore database!";
        }

        return $this->conn;
    }
}
?>

<?php
class Database {
    private $host = 'localhost:3307';
    private $username = 'rooter';
    private $password = '0000';
    private $dbname = 'Bookstore';
    private $conn;

    public function connect() {
        if (!$this->conn) {
            $this->conn = new mysqli($this->host, $this->username, $this->password, $this->dbname);
            if ($this->conn->connect_error) {
                die("Connection failed: " . $this->conn->connect_error);
            }
        }
        return $this->conn;
    }
}
?>

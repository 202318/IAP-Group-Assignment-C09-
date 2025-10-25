<?php
class Database {
    private $host = 'localhost:3307';
    private $db_name = 'bookstore';
    private $username = 'root';
    private $password = '0000';
    private $conn;

    public function connect() {
        $this->conn = null;

        try {
            $this->conn = new PDO(
                "mysql:host={$this->host};dbname={$this->db_name};charset=utf8",
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // ✅ Test message for confirmation
            echo "<div style='color:green;font-weight:bold'>
                    ✅ Connected successfully to <b>{$this->db_name}</b> DB!
                  </div>";
        } catch (PDOException $e) {
            echo "<div style='color:red;font-weight:bold'>
                    ❌ Connection Error: " . htmlspecialchars($e->getMessage()) . "
                  </div>";
        }

        return $this->conn;
    }
}

// ✅ If this file is opened directly in browser, auto-run the test
if (basename(__FILE__) == basename($_SERVER['SCRIPT_FILENAME'])) {
    $db = new Database();
    $db->connect();
}
?>

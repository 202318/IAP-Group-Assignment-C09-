<?php
class Book {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function add($title, $author, $price, $stock) {
        $stmt = $this->conn->prepare("INSERT INTO books (title, author, price, stock) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssdi", $title, $author, $price, $stock);
        return $stmt->execute();
    }

    public function getAll() {
        $stmt = $this->conn->query("SELECT * FROM books");
        return $stmt->fetch_all(MYSQLI_ASSOC);
    }
}
?>

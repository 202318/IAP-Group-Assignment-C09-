<?php
class Book {
    private $conn;
    private $table = 'books';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAllBooks() {
        $sql = "SELECT * FROM {$this->table} WHERE is_active = 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getBookById($id) {
        $sql = "SELECT * FROM {$this->table} WHERE book_id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}


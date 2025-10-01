<?php
require_once "Database.php";

class Cart {
    private $items;

    public function __construct() {
        session_start();
        $this->items = $_SESSION['cart'] ?? [];
    }

    public function getItems() {
        return $this->items;
    }

    public function clear() {
        $_SESSION['cart'] = [];
        $this->items = [];
    }

    public function isEmpty() {
        return empty($this->items);
    }

    public function addItem($bookId, $quantity) {
        if (isset($this->items[$bookId])) {
            $this->items[$bookId] += $quantity;
        } else {
            $this->items[$bookId] = $quantity;
        }
        $_SESSION['cart'] = $this->items;
    }

    public function removeItem($bookId) {
        unset($this->items[$bookId]);
        $_SESSION['cart'] = $this->items;
    }
}
?>


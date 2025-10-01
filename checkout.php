<?php
class Cart {
    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function getItems() {
        return $_SESSION['cart'] ?? [];
    }

    public function isEmpty() {
        return empty($this->getItems());
    }

    public function clear() {
        $_SESSION['cart'] = [];
    }

    public function addItem($bookId, $quantity) {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        if (isset($_SESSION['cart'][$bookId])) {
            $_SESSION['cart'][$bookId] += $quantity;
        } else {
            $_SESSION['cart'][$bookId] = $quantity;
        }
    }

    public function removeItem($bookId) {
        unset($_SESSION['cart'][$bookId]);
    }
}
?>

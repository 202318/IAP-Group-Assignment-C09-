<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['quantity'])) {
    foreach ($_POST['quantity'] as $id => $qty) {
        if (isset($_SESSION['cart'][$id])) {
            $quantity = max(1, (int)$qty); // ensure at least 1
            $_SESSION['cart'][$id]['quantity'] = $quantity;
        }
    }
}

header('Location: cart.php');
exit;

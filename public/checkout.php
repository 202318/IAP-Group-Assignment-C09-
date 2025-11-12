<?php
session_start();
include '../includes/header.php';
include '../config/Database.php';

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "<div class='alert alert-warning text-center'>Your cart is empty. <a href='books.php'>Go shopping</a></div>";
    exit;
}

$database = new Database();
$db = $database->connect();

// Simulate logged-in user (replace with $_SESSION['customer_id'])
$customer_id = $_SESSION['customer_id'] ?? 1;

$cart = $_SESSION['cart'];
$total = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart));

// Handle checkout form
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $db->beginTransaction();

        // Create order
        $stmt = $db->prepare("INSERT INTO orders (customer_id, total_amount, status) VALUES (?, ?, 'pending')");
        $stmt->execute([$customer_id, $total]);
        $order_id = $db->lastInsertId();

        // Insert each item
        $stmt = $db->prepare("INSERT INTO order_items (order_id, book_id, quantity, price) VALUES (?, ?, ?, ?)");
        foreach ($cart as $item) {
            $stmt->execute([$order_id, $item['book_id'], $item['quantity'], $item['price']]);
        }

        $db->commit();
        unset($_SESSION['cart']);

        echo "<div class='alert alert-success text-center'>✅ Order placed successfully! Your Order ID: {$order_id}</div>";

    } catch (Exception $e) {
        $db->rollBack();
        echo "<div class='alert alert-danger text-center'>❌ Error: " . htmlspecialchars($e->getMessage()) . "</div>";
    }
}
?>

<div class="container mt-4">
    <h2 class="text-center mb-4">💳 Checkout</h2>

    <form method="POST" class="text-center">
        <p>Total amount to pay: <strong>$<?php echo number_format($total, 2); ?></strong></p>
        <button type="submit" class="btn btn-success">Confirm Order ✅</button>
    </form>
</div>

<?php include '../includes/footer.php'; ?>

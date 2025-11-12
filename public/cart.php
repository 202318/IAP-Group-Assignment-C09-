<?php
session_start();
include '../includes/header.php';

$cart = $_SESSION['cart'] ?? [];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['clear_cart'])) {
    unset($_SESSION['cart']);
    $cart = [];
}
?>

<div class="container mt-4">
    <h2 class="text-center mb-4">🧺 Your Shopping Cart</h2>

    <?php if (empty($cart)): ?>
        <p class="text-center text-muted">Your cart is empty.</p>
        <div class="text-center">
            <a href="books.php" class="btn btn-primary">Browse Books →</a>
        </div>
    <?php else: ?>
        <table class="table table-bordered text-center">
            <thead class="table-dark">
                <tr>
                    <th>Book</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $total = 0;
                foreach ($cart as $item): 
                    $subtotal = $item['price'] * $item['quantity'];
                    $total += $subtotal;
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($item['title']); ?></td>
                    <td>$<?php echo $item['price']; ?></td>
                    <td><?php echo $item['quantity']; ?></td>
                    <td>$<?php echo number_format($subtotal, 2); ?></td>
                </tr>
                <?php endforeach; ?>
                <tr class="table-secondary">
                    <td colspan="3"><strong>Total</strong></td>
                    <td><strong>$<?php echo number_format($total, 2); ?></strong></td>
                </tr>
            </tbody>
        </table>

        <div class="text-center">
            <form method="POST" class="d-inline">
                <button name="clear_cart" class="btn btn-danger">🗑️ Clear Cart</button>
            </form>
            <a href="checkout.php" class="btn btn-success">Proceed to Checkout →</a>
        </div>
    <?php endif; ?>
</div>

<?php include '../includes/footer.php'; ?>

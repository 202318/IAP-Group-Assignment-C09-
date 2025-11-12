<?php
session_start();
include '../includes/header.php';
include '../config/Database.php';

// Connect to DB
$database = new Database();
$db = $database->connect();

// Fetch all books
$stmt = $db->prepare("SELECT * FROM books WHERE is_active = 1");
$stmt->execute();
$books = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Handle Add to Cart
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['book_id'])) {
    $book_id = $_POST['book_id'];
    $title = $_POST['title'];
    $price = $_POST['price'];

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Check if book already in cart
    $found = false;
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['book_id'] == $book_id) {
            $item['quantity'] += 1;
            $found = true;
            break;
        }
    }
    if (!$found) {
        $_SESSION['cart'][] = [
            'book_id' => $book_id,
            'title' => $title,
            'price' => $price,
            'quantity' => 1
        ];
    }

    echo "<div class='alert alert-success text-center'>✅ {$title} added to cart!</div>";
}
?>

<div class="container mt-4">
    <h2 class="text-center mb-4">📚 Available Books</h2>
    <div class="row">
        <?php foreach ($books as $book): ?>
            <div class="col-md-3 mb-4">
                <div class="card h-100">
                    <img src="<?php echo $book['cover_image_url'] ?: 'https://via.placeholder.com/200'; ?>" class="card-img-top" alt="<?php echo htmlspecialchars($book['title']); ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($book['title']); ?></h5>
                        <p class="card-text">Price: $<?php echo $book['price']; ?></p>
                        <form method="POST">
                            <input type="hidden" name="book_id" value="<?php echo $book['book_id']; ?>">
                            <input type="hidden" name="title" value="<?php echo htmlspecialchars($book['title']); ?>">
                            <input type="hidden" name="price" value="<?php echo $book['price']; ?>">
                            <button type="submit" class="btn btn-primary w-100">Add to Cart 🛒</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="text-center mt-3">
        <a href="cart.php" class="btn btn-success">View Cart →</a>
    </div>
</div>

<?php include '../includes/footer.php'; ?>

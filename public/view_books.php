<?php
include '../includes/header.php';
include '../config/Database.php';
include '../classes/Book.php';

// Connect to DB
$db = (new Database())->connect();
$book = new Book($db);
$books = $book->getAllBooks();
?>

<div class="container mt-4">
    <h2 class="mb-3">📚 Available Books</h2>
    <div class="row">
        <?php foreach ($books as $b): ?>
        <div class="col-md-3 mb-4">
            <div class="card h-100">
                <img src="<?= htmlspecialchars($b['cover_image_url']) ?>" class="card-img-top" alt="<?= htmlspecialchars($b['title']) ?>">
                <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($b['title']) ?></h5>
                    <p class="card-text">💰 $<?= number_format($b['price'], 2) ?></p>
                    <a href="add_to_cart.php?id=<?= $b['book_id'] ?>" class="btn btn-primary w-100">Add to Cart</a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include '../includes/footer.php'; ?>

<?php
require_once '../config/Database.php';

$db = (new Database())->connect();
$stmt = $db->prepare("SELECT book_id, title, price, quantity_in_stock, publication_date, language FROM books WHERE is_active = 1");
$stmt->execute();
$books = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Available Books</title>
    <style>
        table {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }
        th {
            background: #f2f2f2;
        }
    </style>
</head>
<body>
<h2>Available Books</h2>
<table>
    <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Price</th>
        <th>Stock</th>
        <th>Published</th>
        <th>Language</th>
    </tr>
    <?php foreach ($books as $book): ?>
    <tr>
        <td><?= $book['book_id'] ?></td>
        <td><?= htmlspecialchars($book['title']) ?></td>
        <td><?= $book['price'] ?></td>
        <td><?= $book['quantity_in_stock'] ?></td>
        <td><?= $book['publication_date'] ?></td>
        <td><?= htmlspecialchars($book['language']) ?></td>
    </tr>
    <?php endforeach; ?>
</table>
</body>
</html>

<?php
require_once 'config.php';

// Connect to database
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query books table
$sql = "SELECT id, title, author, price FROM books";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Bookstore - Available Books</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f9; margin: 20px; }
        h2 { color: #2c3e50; }
        table { width: 80%; border-collapse: collapse; margin: 20px 0; background: #fff; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background-color: #2c3e50; color: white; }
        tr:hover { background-color: #f1f1f1; }
        a { text-decoration: none; background: #27ae60; color: white; padding: 8px 12px; border-radius: 4px; }
        a:hover { background: #219150; }
    </style>
</head>
<body>

<h2>📚 Available Books</h2>

<table>
    <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Author</th>
        <th>Price (USD)</th>
    </tr>
    <?php
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row["id"]. "</td>
                    <td>" . htmlspecialchars($row["title"]). "</td>
                    <td>" . htmlspecialchars($row["author"]). "</td>
                    <td>$" . number_format($row["price"], 2). "</td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='4'>No books available</td></tr>";
    }
    $conn->close();
    ?>
</table>

<br>
<a href="add_book.php">➕ Add New Book</a>

</body>
</html>

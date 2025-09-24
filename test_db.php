<?php
// test_db.php
$host = 'localhost';
$user = 'root';
$pass = '';      
$dbname = 'bookstore';

// Create connection
$mysqli = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
} else {
    echo "Database connected successfully!";
}

// Optional: list all books
$result = $mysqli->query("SELECT * FROM books");
while($row = $result->fetch_assoc()){
    echo "<pre>";
    print_r($row);
    echo "</pre>";
}

$mysqli->close();
?>
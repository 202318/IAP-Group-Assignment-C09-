<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root";
$password = "0000"; // make sure this matches the MySQL root password
$database = "bookstore";

echo "<p>🔍 Trying to connect to MySQL...</p>";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("<p style='color:red;'>❌ Connection failed: " . $conn->connect_error . "</p>");
}

echo "<p style='color:green;'>✅ Connected successfully to the database!</p>";
?>

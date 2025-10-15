<?php
include 'db_conn.php';

$database = new Database();
$conn = $database->connect();

if ($conn) {
    echo "<br>Tables in Bookstore:<br>";
    $result = $conn->query("SHOW TABLES");
    while ($row = $result->fetch_array()) {
        echo $row[0] . "<br>";
    }
}
?>

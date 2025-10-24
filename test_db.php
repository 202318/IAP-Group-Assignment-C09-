<?php
echo "<h2>TEST_DB FILE VERSION: PDO</h2>";
require_once "ffconfig/Database.php";

$database = new Database();
$db = $database->connect();
?>
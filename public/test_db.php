<?php
require_once __DIR__ . '/../src/Database.php';
use Src\Database;

$db = Database::getInstance()->getConnection();

if ($db) {
    echo "✅ Database connected successfully!";
}

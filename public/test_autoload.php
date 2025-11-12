<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Database;

echo "Testing autoload...<br>";

try {
    $pdo = Database::getInstance()->getConnection();
    echo "✅ Autoload and DB connection working!";
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage();
}

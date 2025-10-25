<?php
require_once __DIR__ . '/../src/Database.php';
use Src\Database;

$db = Database::getInstance()->getConnection();

if (isset($_GET['code'])) {
    $code = $_GET['code'];

    $stmt = $db->prepare("SELECT * FROM users WHERE verification_code = :code LIMIT 1");
    $stmt->execute([':code' => $code]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $update = $db->prepare("UPDATE users SET is_verified = 1, verification_code = NULL WHERE id = :id");
        $update->execute([':id' => $user['id']]);
        echo "<h2>✅ Your email has been verified successfully! You can now log in.</h2>";
    } else {
        echo "<h2>❌ Invalid or expired verification link.</h2>";
    }
} else {
    echo "<h2>❌ Verification code missing.</h2>";
}
?>

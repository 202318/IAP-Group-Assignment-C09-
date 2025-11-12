<?php
require_once __DIR__ . '/../src/Database.php';
use App\Database; // ✅ Use correct namespace (App)

$db = Database::getInstance()->getConnection();

if (isset($_GET['code'])) {
    $code = $_GET['code'];

    // Look up user by verification code
    $stmt = $db->prepare("SELECT * FROM users WHERE verification_code = :code LIMIT 1");
    $stmt->execute([':code' => $code]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Determine correct ID column name
        $idColumn = array_key_exists('user_id', $user) ? 'user_id' : 'id';

        // Update verification status
        $update = $db->prepare("
            UPDATE users 
            SET is_verified = 1, verification_code = NULL 
            WHERE {$idColumn} = :id
        ");
        $update->execute([':id' => $user[$idColumn]]);

        echo "<h2 style='color:green;text-align:center;margin-top:50px'>
                ✅ Your email has been verified successfully! <br>
                <a href='login.php'>Click here to log in</a>
              </h2>";
    } else {
        echo "<h2 style='color:red;text-align:center;margin-top:50px'>
                ❌ Invalid or expired verification link.
              </h2>";
    }
} else {
    echo "<h2 style='color:red;text-align:center;margin-top:50px'>
            ❌ Verification code missing.
          </h2>";
}
?>

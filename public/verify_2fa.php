<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Auth\TwoFactor;
use App\Database;

session_start();

// ✅ Ensure user came from login
if (!isset($_SESSION['pending_2fa_user_id'])) {
    header('Location: login.php');
    exit;
}

try {
    $pdo = Database::getInstance()->getConnection(); // ✅ Correct singleton usage

    // ✅ Fetch the user's 2FA secret
    $stmt = $pdo->prepare('SELECT * FROM user_2fa WHERE user_id = :uid AND enabled = 1 LIMIT 1');
    $stmt->execute([':uid' => $_SESSION['pending_2fa_user_id']]);
    $two = $stmt->fetch(PDO::FETCH_ASSOC);

    $error = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $code = trim($_POST['code'] ?? '');

        if ($two && TwoFactor::verifyCode($two['totp_secret'], $code)) {
            // ✅ Regenerate session and complete login
            session_regenerate_id(true);
            $_SESSION['user_id'] = $_SESSION['pending_2fa_user_id'];
            unset($_SESSION['pending_2fa_user_id']);

            header('Location: dashboard.php');
            exit;
        } else {
            $error = '❌ Invalid or expired code. Please try again.';
        }
    }
} catch (Exception $e) {
    die("❌ Database error: " . htmlspecialchars($e->getMessage()));
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Verify 2FA - BookHaven</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light py-5">
  <div class="container">
    <div class="col-md-6 mx-auto">
      <div class="card shadow-sm border-0 p-4">
        <h2 class="mb-4 text-center">🔐 Two-Factor Verification</h2>

        <?php if (!empty($error)): ?>
          <div class="alert alert-danger text-center"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="post" class="text-center">
          <div class="mb-3">
            <label class="form-label fw-semibold">Enter 6-digit code</label>
            <input 
              name="code" 
              class="form-control text-center" 
              placeholder="123456" 
              required 
              pattern="\d{6}"
              maxlength="6"
            >
          </div>

          <button class="btn btn-primary w-100">Verify</button>
        </form>

        <div class="text-center mt-3">
          <a href="login.php" class="text-decoration-none small">Back to Login</a>
        </div>
      </div>
    </div>
  </div>
</body>
</html>


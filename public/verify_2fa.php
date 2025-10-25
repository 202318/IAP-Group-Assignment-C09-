<?php
include '../includes/header.php';
require_once '../config/Database.php';
require_once '../classes/User.php';

session_start();

$db = (new Database())->connect();
$user = new User($db);

$message = "";

if (!isset($_SESSION['email_for_2fa'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_SESSION['email_for_2fa'];
    $code = trim($_POST['code']);

   if ($user->verifyTwoFactor($email, $code)) {
    $message = "<div class='alert alert-success'>✅ 2FA verified successfully! Redirecting to dashboard...</div>";

    // Mark user as logged in
    $_SESSION['logged_in'] = true;

    // Optional: you can also store user info here
    $_SESSION['user_email'] = $email;

    // Clean up 2FA temporary session
    unset($_SESSION['email_for_2fa']);
    unset($_SESSION['2fa_code']);

    // Redirect after short delay
    echo "<script>
        setTimeout(() => {
            window.location.href = 'dashboard.php';
        }, 2000);
    </script>";
} else {
    $message = "<div class='alert alert-danger'>❌ Invalid or expired code. Try again.</div>";
}
}
?>

<div class="container mt-5">
  <h2>Two-Factor Verification</h2>
  <?= $message; ?>
  <form method="POST">
    <div class="mb-3">
      <label class="form-label">Enter 6-digit code</label>
      <input type="text" name="code" class="form-control" maxlength="6" required>
    </div>
    <button type="submit" class="btn btn-success">Verify</button>
  </form>
</div>

<?php include '../includes/footer.php'; ?>
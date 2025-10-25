<?php
include '../includes/header.php';
require_once '../config/Database.php';
require_once '../classes/User.php';

session_start();

$db = (new Database())->connect();
$user = new User($db);

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $loggedInUser = $user->login($email, $password);

    if ($loggedInUser) {
        // Generate and save 2FA code
        $code = rand(100000, 999999);
        $expires = date('Y-m-d H:i:s', strtotime('+5 minutes'));
        $user->setTwoFactor($email, $code, $expires);

        $_SESSION['email_for_2fa'] = $email;
        $_SESSION['2fa_code'] = $code; // for testing only

        header('Location: verify_2fa.php');
        exit;
    } else {
        $message = "<div class='alert alert-danger'>Invalid email or password.</div>";
    }
}
?>

<div class="container mt-5">
  <h2>Login</h2>
  <?= $message; ?>
  <form method="POST">
    <div class="mb-3">
      <label class="form-label">Email</label>
      <input type="email" name="email" class="form-control" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Password</label>
      <input type="password" name="password" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Login</button>
  </form>
</div>

<?php include '../includes/footer.php'; ?>

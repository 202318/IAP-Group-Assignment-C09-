
<?php
require_once __DIR__ . '/../vendor/autoload.php';
use App\Auth\Auth;
use App\Database;

session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Method not allowed');
}

$email = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
$password = $_POST['password'] ?? '';

if (!$email || !$password) {
    $_SESSION['errors'] = ['Invalid credentials'];
    header('Location: login.php');
    exit;
}

$auth = new Auth();
$user = $auth->login($email, $password);
if (!$user) {
    $_SESSION['errors'] = ['Invalid email or password'];
    header('Location: login.php');
    exit;
}

// Check 2FA
$pdo = Database::getConnection();
$stmt = $pdo->prepare('SELECT * FROM user_2fa WHERE user_id = :uid LIMIT 1');
$stmt->execute([':uid'=> $user['id']]);
$two = $stmt->fetch();

if ($two && $two['enabled']) {
    $_SESSION['pending_2fa_user_id'] = $user['id'];
    header('Location: verify_2fa.php');
    exit;
}

// login success
session_regenerate_id(true);
$_SESSION['user_id'] = $user['id'];
header('Location: dashboard.php');
exit;

$stmt = $db->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
$stmt->execute([':email' => $email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user['is_verified']) {
    die("❌ Please verify your email before logging in.");
}

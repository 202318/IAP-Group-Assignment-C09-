<?php
require_once __DIR__ . '/../src/Database.php';
require_once __DIR__ . '/../vendor/autoload.php'; // PHPMailer

use Src\Database;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Connect to database
$db = Database::getInstance()->getConnection();

// Collect form input
$username = $_POST['username'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';
$first_name = $_POST['first_name'] ?? '';
$last_name = $_POST['last_name'] ?? '';
$phone = $_POST['phone'] ?? '';

// Validate required fields
if (empty($username) || empty($email) || empty($password)) {
    die("❌ Please fill in all required fields.");
}

// Hash password
$password_hash = password_hash($password, PASSWORD_DEFAULT);

// Create verification code
$verification_code = bin2hex(random_bytes(16));

// ✅ 1. INSERT user into database
try {
    $stmt = $db->prepare("INSERT INTO users (username, email, password_hash, first_name, last_name, phone, verification_code, is_verified)
                          VALUES (:username, :email, :password_hash, :first_name, :last_name, :phone, :verification_code, 0)");
    $stmt->execute([
        ':username' => $username,
        ':email' => $email,
        ':password_hash' => $password_hash,
        ':first_name' => $first_name,
        ':last_name' => $last_name,
        ':phone' => $phone,
        ':verification_code' => $verification_code
    ]);
} catch (PDOException $e) {
    die("❌ Database error: " . $e->getMessage());
}

// ✅ 2. Prepare verification email
$verifyLink = "http://localhost/IAP-Group-Assignment-C09--main-updated/public/verify_email.php?code=" . $verification_code;

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'sharon.wambua@strathmore.edu'; // your Gmail
    $mail->Password = 'zsby dgqw mbde cmwn'; // Gmail App Password
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom('sharon.wambua@strathmore.edu', 'IAP Group Project');
    $mail->addAddress($email, "$first_name $last_name");
    $mail->isHTML(true);
    $mail->Subject = 'Please Verify Your Email';
    $mail->Body = "
        <h3>Hello, {$first_name}!</h3>
        <p>Thank you for registering. Please verify your email by clicking the link below:</p>
        <a href='{$verifyLink}'>Verify Email</a>
        <p>If you didn’t register, you can ignore this email.</p>
    ";

    $mail->send();
    echo "✅ Registration successful! Please check your email to verify your account.";

} catch (Exception $e) {
    echo "❌ Email failed to send: {$mail->ErrorInfo}";
}
?>


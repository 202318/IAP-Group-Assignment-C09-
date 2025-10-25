<?php
require_once __DIR__ . '/../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);

try {
    // Server settings
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';        // or your mail server
    $mail->SMTPAuth = true;
    $mail->Username = 'sharon.wambua@strathmore.edu';
    $mail->Password = 'zsby dgqw mbde cmwn'; // Use Gmail App Password
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    // Recipients
    $mail->setFrom('sharon.wambua@strathmore.edu', 'Sharon Wambua');
    $mail->addAddress('sharonwambu06@gmail.com');

    // Content
    $mail->isHTML(true);
    $mail->Subject = 'Test Email from PHPMailer';
    $mail->Body    = '<b>Hello!</b> This is a test email from PHPMailer.';

    $mail->send();
    echo '✅ Email sent successfully!';
} catch (Exception $e) {
    echo "❌ Email failed: {$mail->ErrorInfo}";
}

<?php
require_once "classes/User.php";

$errors = [];
$name = $email = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!$name || !$email || !$password) {
        $errors[] = "All fields are required.";
    } else {
        try {
            $user = new User();
            if ($user->register($name, $email, $password)) {
                header("Location: signin.php?registered=1");
                exit;
            }
        } catch (Exception $e) {
            $errors[] = $e->getMessage();
        }
    }
}
?>
<!doctype html>
<html>
<head><title>Sign Up</title></head>
<body>
<h2>Sign Up</h2>

<?php foreach ($errors as $e): ?>
    <p style="color:red;"><?= htmlspecialchars($e) ?></p>
<?php endforeach; ?>

<form method="post">
  <input name="name" placeholder="Name" value="<?= htmlspecialchars($name ?? '') ?>"><br>
  <input name="email" placeholder="Email" value="<?= htmlspecialchars($email ?? '') ?>"><br>
  <input name="password" type="password" placeholder="Password"><br>
  <button>Sign up</button>
</form>

<p>Already have an account? <a href="signin.php">Sign in</a></p>
</body>
</html>

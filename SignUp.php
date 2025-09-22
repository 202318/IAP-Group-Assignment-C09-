<?php
require 'db_conn.php';
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    if (!$name || !$email || !$password) $errors[] = "All fields are required.";
    if (!$errors) {
        $stmt = $mysqli->prepare("SELECT id FROM users WHERE email=?");
        $stmt->bind_param('s', $email);
        $stmt->execute(); $stmt->store_result();
        if ($stmt->num_rows) $errors[] = "Email already registered.";
        else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $ins = $mysqli->prepare("INSERT INTO users (name,email,password_hash) VALUES (?,?,?)");
            $ins->bind_param('sss', $name, $email, $hash);
            if ($ins->execute()) { header("Location: signin.php?registered=1"); exit; }
            else $errors[] = "Could not create account.";
        }
    }
}
?>
<!doctype html><html><head><title>Sign Up</title></head><body>
<h2>Sign Up</h2>
<?php foreach($errors as $e) echo "<p style='color:red;'>$e</p>"; ?>
<form method="post">
  <input name="name" placeholder="Name" value="<?=htmlspecialchars($name ?? '')?>"><br>
  <input name="email" placeholder="Email" value="<?=htmlspecialchars($email ?? '')?>"><br>
  <input name="password" type="password" placeholder="Password"><br>
  <button>Sign up</button>
</form>
<p>Already have an account? <a href="signin.php">Sign in</a></p>
</body></html>

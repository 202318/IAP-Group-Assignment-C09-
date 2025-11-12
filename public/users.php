<?php
require_once __DIR__ . '/../vendor/autoload.php';
use App\Models\User;
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
$userModel = new User();
$users = $userModel->all();
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Users</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
<div class="container">
  <h2>Users</h2>
  <table class="table table-striped">
    <thead><tr><th>ID</th><th>Username</th><th>Email</th><th>Name</th><th>Phone</th><th>Created</th></tr></thead>
    <tbody>
      <?php foreach ($users as $u): ?>
      <tr>
        <td><?=htmlspecialchars($u['id'])?></td>
        <td><?=htmlspecialchars($u['username'])?></td>
        <td><?=htmlspecialchars($u['email'])?></td>
        <td><?=htmlspecialchars($u['first_name'].' '.$u['last_name'])?></td>
        <td><?=htmlspecialchars($u['phone'])?></td>
        <td><?=htmlspecialchars($u['created_at'])?></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
</body>
</html>

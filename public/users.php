<?php
require_once '../config/Database.php';
require_once '../classes/User.php';

$db = (new Database())->connect();
$user = new User($db);
$users = $user->getAllUsers();
?>

<!DOCTYPE html>
<html>
<head>
    <title>All Users</title>
    <style>
        table {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }
        th {
            background: #f2f2f2;
        }
    </style>
</head>
<body>
<h2>Registered Customers</h2>
<table>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>City</th>
        <th>Country</th>
        <th>Date Created</th>
    </tr>
    <?php foreach ($users as $u): ?>
    <tr>
        <td><?= $u['customer_id'] ?></td>
        <td><?= htmlspecialchars($u['first_name'] . ' ' . $u['last_name']) ?></td>
        <td><?= htmlspecialchars($u['email']) ?></td>
        <td><?= htmlspecialchars($u['phone']) ?></td>
        <td><?= htmlspecialchars($u['city']) ?></td>
        <td><?= htmlspecialchars($u['country']) ?></td>
        <td><?= $u['date_created'] ?></td>
    </tr>
    <?php endforeach; ?>
</table>
</body>
</html>

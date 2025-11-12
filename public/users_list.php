<?php
require_once __DIR__ . '/../src/Database.php';
use App\Database;

include 'inc/header.php';

try {
    $db = Database::getInstance()->getConnection();
    $stmt = $db->query("SELECT id, username, email, first_name, last_name, phone, is_verified, created_at FROM users ORDER BY created_at DESC");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("❌ Error loading users: " . $e->getMessage());
}
?>

<div class="container mt-5">
  <h1 class="fw-bold mb-4 text-center">All Users</h1>

  <div class="card shadow-sm p-3">
    <table class="table table-striped table-hover align-middle">
      <thead class="table-light">
        <tr>
          <th>ID</th>
          <th>Username</th>
          <th>Email</th>
          <th>Full Name</th>
          <th>Phone</th>
          <th>Verified</th>
          <th>Registered On</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($users): ?>
          <?php foreach ($users as $user): ?>
            <tr>
              <td><?= htmlspecialchars($user['id']); ?></td>
              <td><?= htmlspecialchars($user['username']); ?></td>
              <td><?= htmlspecialchars($user['email']); ?></td>
              <td><?= htmlspecialchars(trim($user['first_name'] . ' ' . $user['last_name'])); ?></td>
              <td><?= htmlspecialchars($user['phone']); ?></td>
              <td>
                <?php if ($user['is_verified']): ?>
                  <span class="badge bg-success">Yes</span>
                <?php else: ?>
                  <span class="badge bg-danger">No</span>
                <?php endif; ?>
              </td>
              <td><?= htmlspecialchars($user['created_at']); ?></td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr><td colspan="7" class="text-center text-muted">No users found.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

  <div class="text-center mt-3">
    <a href="dashboard.php" class="btn btn-outline-secondary">← Back to Dashboard</a>
  </div>
</div>

<?php include 'inc/footer.php'; ?>


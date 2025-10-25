<?php include 'inc/header.php'; ?>

<h2 class="text-center mb-4" style="color:#5c4b99;">Admin Dashboard</h2>

<div class="row g-4 text-center">
  <div class="col-md-3">
    <div class="card p-3">
      <h5>Manage Books</h5>
      <a href="admin_books.php" class="btn btn-primary mt-2">Open</a>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card p-3">
      <h5>Manage Users</h5>
      <a href="admin_users.php" class="btn btn-primary mt-2">Open</a>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card p-3">
      <h5>View Orders</h5>
      <a href="admin_orders.php" class="btn btn-primary mt-2">Open</a>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card p-3">
      <h5>Reports</h5>
      <a href="admin_reports.php" class="btn btn-primary mt-2">Open</a>
    </div>
  </div>
</div>

<?php include 'inc/footer.php'; ?>

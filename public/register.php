<?php include 'inc/header.php'; ?>

<h2 class="text-center mb-4">Create an Account</h2>

<form action="register.php" method="POST" class="mx-auto" style="max-width: 500px;">
  <div class="mb-3">
    <label for="fname" class="form-label">First Name</label>
    <input type="text" class="form-control" name="fname" required>
  </div>

  <div class="mb-3">
    <label for="lname" class="form-label">Last Name</label>
    <input type="text" class="form-control" name="lname" required>
  </div>

  <div class="mb-3">
    <label for="username" class="form-label">Username</label>
    <input type="text" class="form-control" name="username" required>
  </div>

  <div class="mb-3">
    <label for="email" class="form-label">Email</label>
    <input type="email" class="form-control" name="email" required>
  </div>

  <div class="mb-3">
    <label for="phone" class="form-label">Phone Number</label>
    <input type="text" class="form-control" name="phone" required>
  </div>

  <div class="mb-3">
    <label for="password" class="form-label">Password</label>
    <input type="password" class="form-control" name="password" required>
  </div>

  <button type="submit" class="btn btn-primary w-100">Register</button>

  <p class="text-center mt-3">
    Already have an account? <a href="login.php">Login</a>
  </p>
</form>

<?php include 'inc/footer.php'; ?>



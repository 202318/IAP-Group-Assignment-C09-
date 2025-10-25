<?php 
include '../includes/header.php'; 
require_once '../config/Database.php';
require_once '../classes/User.php';

$db = (new Database())->connect();
$user = new User($db);

$message = "";

// ✅ Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = [
        'first_name' => trim($_POST['first_name']),
        'last_name'  => trim($_POST['last_name']),
        'email'      => trim($_POST['email']),
        'password'   => $_POST['password'],
        'phone'      => trim($_POST['phone']),
        'address'    => trim($_POST['address']),
        'city'       => trim($_POST['city']),
        'state'      => trim($_POST['state']),
        'zip_code'   => trim($_POST['zip_code']),
        'country'    => trim($_POST['country'])
    ];

    // ✅ Validation
    if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $message = "<div class='alert alert-danger'>Invalid email format.</div>";
    } elseif (strlen($data['password']) < 6) {
        $message = "<div class='alert alert-danger'>Password must be at least 6 characters long.</div>";
    } else {
        // ✅ Attempt registration
        $result = $user->register($data);

        if ($result === true) {
            // ✅ Generate 2FA code
            $code = rand(100000, 999999);
            $expires = date('Y-m-d H:i:s', strtotime('+5 minutes'));
            $user->setTwoFactor($data['email'], $code, $expires);

            // ✅ Store for next step
            $_SESSION['email_for_2fa'] = $data['email'];
            $_SESSION['2fa_code'] = $code; // For demo display

            header('Location: verify_2fa.php');
            exit;

        } elseif ($result === 'duplicate') {
            // ⚠️ Duplicate email
            $message = "<div class='alert alert-warning'>
                ⚠️ This email is already registered. 
                Please <a href='login.php' class='alert-link'>log in</a> or use another email.
            </div>";
        } else {
            // ❌ Generic failure
            $message = "<div class='alert alert-danger'>Something went wrong. Try again.</div>";
        }
    }
}

?>

<div class="container mt-5">
  <h2 class="mb-4">Register</h2>
  <?= $message; ?>

  <form id="registerForm" method="POST" class="needs-validation" novalidate>
    <div class="row g-3">
      <div class="col-md-6">
        <label class="form-label">First Name</label>
        <input type="text" name="first_name" class="form-control" required>
      </div>
      <div class="col-md-6">
        <label class="form-label">Last Name</label>
        <input type="text" name="last_name" class="form-control" required>
      </div>
      <div class="col-md-6">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" required>
      </div>
      <div class="col-md-6">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control" minlength="6" required>
      </div>
      <div class="col-md-6">
        <label class="form-label">Phone</label>
        <input type="text" name="phone" class="form-control">
      </div>
      <div class="col-md-6">
        <label class="form-label">Address</label>
        <input type="text" name="address" class="form-control">
      </div>
      <div class="col-md-4">
        <label class="form-label">City</label>
        <input type="text" name="city" class="form-control">
      </div>
      <div class="col-md-4">
        <label class="form-label">State</label>
        <input type="text" name="state" class="form-control">
      </div>
      <div class="col-md-4">
        <label class="form-label">Zip Code</label>
        <input type="text" name="zip_code" class="form-control">
      </div>
      <div class="col-md-6">
        <label class="form-label">Country</label>
        <input type="text" name="country" class="form-control">
      </div>
    </div>

    <button type="submit" class="btn btn-primary mt-4">Register</button>
  </form>
</div>

<script>
// ✅ Client-side validation (Bootstrap)
(() => {
  const form = document.querySelector('#registerForm');
  form.addEventListener('submit', (e) => {
    if (!form.checkValidity()) {
      e.preventDefault();
      e.stopPropagation();
    }
    form.classList.add('was-validated');
  });
})();
</script>

<?php include '../includes/footer.php'; ?>

<?php include 'inc/header.php'; ?>

<h2 class="text-center mb-4">Checkout</h2>

<form action="checkout.php" method="POST" class="mx-auto" style="max-width: 500px;">
  <div class="mb-3">
    <label class="form-label">Full Name</label>
    <input type="text" class="form-control" name="fullname" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Address</label>
    <textarea class="form-control" name="address" rows="3" required></textarea>
  </div>
  <div class="mb-3">
    <label class="form-label">Payment Method</label>
    <select class="form-select" name="payment" required>
      <option value="mpesa">M-Pesa</option>
      <option value="card">Credit/Debit Card</option>
      <option value="cash">Cash on Delivery</option>
    </select>
  </div>
  <button type="submit" class="btn btn-primary w-100">Place Order</button>
</form>

<?php include 'inc/footer.php'; ?>

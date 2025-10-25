<?php include 'inc/header.php'; ?>

<h2 class="text-center mb-4" style="color:#5c4b99;">Your Shopping Cart</h2>

<table class="table table-bordered">
  <thead class="table-light">
    <tr>
      <th>Book</th>
      <th>Quantity</th>
      <th>Price</th>
      <th>Total</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>The Great Gatsby</td>
      <td>1</td>
      <td>Ksh 1200</td>
      <td>Ksh 1200</td>
      <td><button class="btn btn-sm btn-danger">Remove</button></td>
    </tr>
  </tbody>
</table>

<div class="text-end mt-3">
  <h5>Total: Ksh 1200</h5>
  <a href="checkout.php" class="btn btn-primary">Proceed to Checkout</a>
</div>

<?php include 'inc/footer.php'; ?>

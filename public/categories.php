<?php include 'inc/header.php'; ?>

<h2 class="text-center mb-4" style="color:#5c4b99;">Book Categories</h2>

<div class="row row-cols-1 row-cols-md-3 g-4 text-center">
  <?php
  $categories = ['Fiction', 'Romance', 'Science', 'History', 'Children', 'Technology'];
  foreach ($categories as $cat): ?>
    <div class="col">
      <div class="card p-4">
        <h5 class="fw-bold"><?php echo $cat; ?></h5>
        <a href="books.php?category=<?php echo urlencode($cat); ?>" class="btn btn-primary mt-2">Explore</a>
      </div>
    </div>
  <?php endforeach; ?>
</div>

<?php include 'inc/footer.php'; ?>

